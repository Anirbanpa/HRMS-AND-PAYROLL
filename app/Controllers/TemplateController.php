<?php

namespace App\Controllers;

use App\Models\DocumentTemplateModel;
use App\Models\EmployeeModel;
use App\Models\SalaryStructureModel;
use CodeIgniter\HTTP\ResponseInterface;

class TemplateController extends BaseController
{
    protected DocumentTemplateModel $tplModel;
    protected EmployeeModel $employeeModel;

    public function __construct()
    {
        $this->tplModel = new DocumentTemplateModel();
        $this->employeeModel = new EmployeeModel();
    }

    /**
     * Document Template List & Generator Hub
     */
    public function index()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Access Denied: Document Templates is restricted to Human Resources personnel.');
            return redirect()->to(site_url('dashboard'));
        }

        $templates = $this->tplModel->findAll();
        $employees = $this->employeeModel->where('deleted_at', null)->orderBy('first_name', 'ASC')->findAll();

        $data = [
            'pageTitle' => 'HR Document Templates & Letter Generation',
            'templates' => $templates,
            'employees' => $employees,
        ];

        return $this->render('templates/index', $data);
    }

    /**
     * Store new Template
     */
    public function store(): ResponseInterface
    {
        $name = trim($this->request->getPost('name') ?? '');
        $category = $this->request->getPost('category') ?: 'offer_letter';
        $subject = trim($this->request->getPost('subject') ?? '');
        $body = trim($this->request->getPost('body_content') ?? '');

        if (empty($name) || empty($subject) || empty($body)) {
            return redirect()->back()->with('error', 'Template Name, Subject, and Content are required.');
        }

        $code = 'TPL_' . strtoupper(preg_replace('/[^a-zA-Z0-9]/', '_', $name));

        $newId = (int)$this->tplModel->insert([
            'template_code' => $code,
            'name'          => $name,
            'category'      => $category,
            'subject'       => $subject,
            'body_content'  => $body,
        ]);

        $this->logAudit('CREATE_TEMPLATE', 'document_templates', "Created template '{$name}' ({$code})", $newId);

        return redirect()->to(site_url('templates'))->with('success', "Document template '{$name}' created successfully.");
    }

    /**
     * Generate Live Dynamic Document for Employee
     */
    public function generate(): string
    {
        $templateId = (int)$this->request->getPost('template_id');
        $employeeId = (int)$this->request->getPost('employee_id');

        $template = $this->tplModel->find($templateId);
        if (!$template) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Template #{$templateId} not found.");
        }

        $emp = $this->employeeModel->select('employees.*, departments.name AS department_name, designations.name AS designation_title')
                                   ->join('departments', 'departments.id = employees.department_id', 'left')
                                   ->join('designations', 'designations.id = employees.designation_id', 'left')
                                   ->where('employees.id', $employeeId)
                                   ->first();

        if (!$emp) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Employee #{$employeeId} not found.");
        }

        // Fetch salary
        $salModel = new SalaryStructureModel();
        $salary = $salModel->where('employee_id', $employeeId)->orderBy('effective_date', 'DESC')->first();
        $annualGross = $salary ? ((float)$salary['gross_salary'] * 12) : 60000.00;

        // Perform Token Substitution
        $tokens = [
            '{{EMPLOYEE_NAME}}'  => $emp['first_name'] . ' ' . $emp['last_name'],
            '{{EMPLOYEE_CODE}}'  => $emp['employee_code'],
            '{{DESIGNATION}}'    => $emp['designation_title'] ?? 'Staff Professional',
            '{{DEPARTMENT}}'     => $emp['department_name'] ?? 'General Operations',
            '{{JOIN_DATE}}'      => !empty($emp['joining_date']) ? date('F d, Y', strtotime($emp['joining_date'])) : date('F d, Y'),
            '{{GROSS_SALARY}}'   => '₹' . number_format($annualGross, 2) . ' per annum',
            '{{COMPANY_NAME}}'   => 'Infosof Technologies',
            '{{COMPANY}}'        => 'Infosof Technologies',
            '{{TODAY_DATE}}'     => date('F d, Y'),
        ];

        $renderedSubject = str_replace(array_keys($tokens), array_values($tokens), $template['subject']);
        $renderedBody = str_replace(array_keys($tokens), array_values($tokens), $template['body_content']);

        $this->logAudit('GENERATE_DOCUMENT', 'document_templates', "Generated {$template['template_code']} for {$emp['employee_code']}", $templateId);

        $data = [
            'pageTitle'       => 'Generated Document: ' . $template['name'],
            'template'        => $template,
            'employee'        => $emp,
            'renderedSubject' => $renderedSubject,
            'renderedBody'    => $renderedBody,
        ];

        return $this->render('templates/preview', $data);
    }

    /**
     * Show edit form or return template data
     *
     * @return string|ResponseInterface
     */
    public function edit(int $id)
    {
        $template = $this->tplModel->find($id);
        if (!$template) {
            return redirect()->to(site_url('templates'))->with('error', "Template #{$id} not found.");
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $template,
            ]);
        }

        $data = [
            'pageTitle' => 'Edit Document Template: ' . $template['name'],
            'template'  => $template,
        ];

        return $this->render('templates/edit', $data);
    }

    /**
     * Update an existing Template
     */
    public function update(int $id): ResponseInterface
    {
        $template = $this->tplModel->find($id);
        if (!$template) {
            return redirect()->to(site_url('templates'))->with('error', "Template #{$id} not found.");
        }

        $name = trim((string)$this->request->getPost('name'));
        $category = $this->request->getPost('category') ?: $template['category'];
        $subject = trim((string)$this->request->getPost('subject'));
        $body = trim((string)$this->request->getPost('body_content'));
        $isActive = $this->request->getPost('is_active') !== null ? (int)$this->request->getPost('is_active') : (int)($template['is_active'] ?? 1);
        $templateCode = trim((string)$this->request->getPost('template_code')) ?: $template['template_code'];

        if (empty($name) || empty($subject) || empty($body)) {
            return redirect()->back()->with('error', 'Template Name, Subject, and Body content are required.');
        }

        $this->tplModel->update($id, [
            'template_code' => $templateCode,
            'name'          => $name,
            'category'      => $category,
            'subject'       => $subject,
            'body_content'  => $body,
            'is_active'     => $isActive,
        ]);

        $this->logAudit('UPDATE_TEMPLATE', 'document_templates', "Updated template '{$name}' ({$templateCode})", $id);

        return redirect()->to(site_url('templates'))->with('success', "Document template '{$name}' updated successfully.");
    }

    /**
     * Delete an existing Template
     */
    public function delete(int $id): ResponseInterface
    {
        if (($this->currentUser['role_slug'] ?? '') !== 'super_admin') {
            return redirect()->to(site_url('templates'))->with('error', 'Access Denied: Only Super Admin is authorized to delete document templates.');
        }

        $template = $this->tplModel->find($id);
        if (!$template) {
            return redirect()->to(site_url('templates'))->with('error', "Template #{$id} not found.");
        }

        $templateName = $template['name'];
        $templateCode = $template['template_code'];

        $this->tplModel->delete($id);
        $this->logAudit('DELETE_TEMPLATE', 'document_templates', "Deleted template '{$templateName}' ({$templateCode})", $id);

        return redirect()->to(site_url('templates'))->with('success', "Document template '{$templateName}' deleted successfully.");
    }
}
