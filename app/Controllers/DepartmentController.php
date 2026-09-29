<?php

namespace App\Controllers;

use App\Models\DepartmentModel;
use App\Models\BranchModel;
use App\Models\EmployeeModel;
use App\Models\DesignationModel;

class DepartmentController extends BaseController
{
    public function index()
    {
        if (!$this->hasPermission('department.manage') && !$this->hasPermission('designation.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to manage departments or designations.');
            return redirect()->to(site_url('dashboard'));
        }

        $departmentModel  = new DepartmentModel();
        $branchModel      = new BranchModel();
        $employeeModel    = new EmployeeModel();
        $designationModel = new DesignationModel();
        $db               = \Config\Database::connect();

        $departments  = $departmentModel->getDepartmentsWithStats();
        $branches     = $branchModel->findAll();
        $employees    = $employeeModel->select('id, first_name, last_name, employee_code')->findAll();
        $designations = $designationModel->getDesignationsWithStats();
        $payGrades    = $db->table('pay_grades')->orderBy('grade_code', 'ASC')->get()->getResultArray();

        $activeTab = $this->request->getGet('tab') ?: 'departments';
        $formTab   = $this->request->getGet('form') ?: ($activeTab === 'designations' ? 'designation' : 'department');

        $data = [
            'departments'  => $departments,
            'branches'     => $branches,
            'employees'    => $employees,
            'designations' => $designations,
            'payGrades'    => $payGrades,
            'activeTab'    => $activeTab,
            'formTab'      => $formTab,
        ];

        return $this->render('departments/index', $data, 'Department & Designation Management');
    }

    public function store()
    {
        if (!$this->hasPermission('department.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to create departments.');
            return redirect()->to(site_url('departments'));
        }

        $name     = trim((string)$this->request->getPost('name'));
        $code     = trim((string)$this->request->getPost('code'));
        $branchId = $this->request->getPost('branch_id') ?: null;
        $headId   = $this->request->getPost('head_employee_id') ?: null;
        $parentId = $this->request->getPost('parent_id') ?: null;

        if (empty($name) || empty($code)) {
            $this->session->setFlashdata('error', 'Department name and code are required.');
            return redirect()->back()->withInput();
        }

        $deptModel = new DepartmentModel();
        if ($deptModel->where('code', $code)->first()) {
            $this->session->setFlashdata('error', "Department code '{$code}' already exists.");
            return redirect()->back()->withInput();
        }

        $id = $deptModel->insert([
            'company_id'       => 1,
            'branch_id'        => $branchId,
            'name'             => $name,
            'code'             => strtoupper($code),
            'head_employee_id' => $headId,
            'parent_id'        => $parentId,
            'status'           => 'active',
        ]);

        $this->logAudit('CREATE_DEPT', 'department', "Created department {$name} ({$code})", $id);
        $this->session->setFlashdata('success', "Department '{$name}' created successfully.");
        return redirect()->to(site_url('departments'));
    }

    public function update($id)
    {
        if (!$this->hasPermission('department.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to edit departments.');
            return redirect()->to(site_url('departments'));
        }

        $deptModel = new DepartmentModel();
        $dept = $deptModel->find((int)$id);
        if (!$dept) {
            $this->session->setFlashdata('error', 'Department not found.');
            return redirect()->to(site_url('departments'));
        }

        $name     = trim((string)$this->request->getPost('name'));
        $code     = trim((string)$this->request->getPost('code'));
        $branchId = $this->request->getPost('branch_id') ?: null;
        $headId   = $this->request->getPost('head_employee_id') ?: null;
        $status   = $this->request->getPost('status') ?: 'active';

        if (empty($name) || empty($code)) {
            $this->session->setFlashdata('error', 'Department name and code are required.');
            return redirect()->back()->withInput();
        }

        // Check if code taken by another department
        $existing = $deptModel->where('code', strtoupper($code))->where('id !=', (int)$id)->first();
        if ($existing) {
            $this->session->setFlashdata('error', "Department code '{$code}' is already in use by another department.");
            return redirect()->back()->withInput();
        }

        $deptModel->update((int)$id, [
            'name'             => $name,
            'code'             => strtoupper($code),
            'branch_id'        => $branchId,
            'head_employee_id' => $headId,
            'status'           => $status,
        ]);

        $this->logAudit('UPDATE_DEPT', 'department', "Updated department {$name} ({$code})", (int)$id);
        $this->session->setFlashdata('success', "Department '{$name}' updated successfully.");
        return redirect()->to(site_url('departments'));
    }

    public function delete($id)
    {
        if (!$this->hasPermission('department.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to delete departments.');
            return redirect()->to(site_url('departments'));
        }

        $deptModel = new DepartmentModel();
        $dept = $deptModel->find((int)$id);
        if (!$dept) {
            $this->session->setFlashdata('error', 'Department not found.');
            return redirect()->to(site_url('departments'));
        }

        $db = \Config\Database::connect();
        // Safely unassign any employees or child entities referencing this department
        $db->table('employees')->where('department_id', (int)$id)->update(['department_id' => null]);
        $db->table('departments')->where('parent_id', (int)$id)->update(['parent_id' => null]);
        $db->table('designations')->where('department_id', (int)$id)->update(['department_id' => null]);

        $deptModel->delete((int)$id);

        $this->logAudit('DELETE_DEPT', 'department', "Deleted department {$dept['name']} ({$dept['code']})", (int)$id);
        $this->session->setFlashdata('success', "Department '{$dept['name']}' deleted successfully.");
        return redirect()->to(site_url('departments'));
    }

    /**
     * Store newly created designation
     */
    public function storeDesignation()
    {
        if (!$this->hasPermission('department.manage') && !$this->hasPermission('designation.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to create designations.');
            return redirect()->to(site_url('departments?tab=designations'));
        }

        $name         = trim((string)$this->request->getPost('name'));
        $code         = trim((string)$this->request->getPost('code'));
        $departmentId = $this->request->getPost('department_id') ?: null;
        $gradeBandId  = $this->request->getPost('grade_band_id') ?: null;
        $description  = trim((string)$this->request->getPost('description')) ?: null;
        $status       = $this->request->getPost('status') ?: 'active';

        if (empty($name) || empty($code)) {
            $this->session->setFlashdata('error', 'Designation title and code are required.');
            return redirect()->to(site_url('departments?tab=designations&form=designation'))->withInput();
        }

        $designationModel = new DesignationModel();
        if ($designationModel->where('code', strtoupper($code))->first()) {
            $this->session->setFlashdata('error', "Designation code '{$code}' already exists.");
            return redirect()->to(site_url('departments?tab=designations&form=designation'))->withInput();
        }

        $id = $designationModel->insert([
            'company_id'    => 1,
            'department_id' => $departmentId ? (int)$departmentId : null,
            'name'          => $name,
            'code'          => strtoupper($code),
            'grade_band_id' => $gradeBandId ? (int)$gradeBandId : null,
            'description'   => $description,
            'status'        => $status,
        ]);

        $this->logAudit('CREATE_DESIGNATION', 'designation', "Created designation {$name} ({$code})", $id);
        $this->session->setFlashdata('success', "Designation '{$name}' created successfully.");
        return redirect()->to(site_url('departments?tab=designations'));
    }

    /**
     * Update existing designation
     */
    public function updateDesignation($id)
    {
        if (!$this->hasPermission('department.manage') && !$this->hasPermission('designation.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to edit designations.');
            return redirect()->to(site_url('departments?tab=designations'));
        }

        $designationModel = new DesignationModel();
        $designation = $designationModel->find((int)$id);
        if (!$designation) {
            $this->session->setFlashdata('error', 'Designation not found.');
            return redirect()->to(site_url('departments?tab=designations'));
        }

        $name         = trim((string)$this->request->getPost('name'));
        $code         = trim((string)$this->request->getPost('code'));
        $departmentId = $this->request->getPost('department_id') ?: null;
        $gradeBandId  = $this->request->getPost('grade_band_id') ?: null;
        $description  = trim((string)$this->request->getPost('description')) ?: null;
        $status       = $this->request->getPost('status') ?: 'active';

        if (empty($name) || empty($code)) {
            $this->session->setFlashdata('error', 'Designation title and code are required.');
            return redirect()->to(site_url('departments?tab=designations'))->withInput();
        }

        $existing = $designationModel->where('code', strtoupper($code))->where('id !=', (int)$id)->first();
        if ($existing) {
            $this->session->setFlashdata('error', "Designation code '{$code}' is already in use by another designation.");
            return redirect()->to(site_url('departments?tab=designations'))->withInput();
        }

        $designationModel->update((int)$id, [
            'name'          => $name,
            'code'          => strtoupper($code),
            'department_id' => $departmentId ? (int)$departmentId : null,
            'grade_band_id' => $gradeBandId ? (int)$gradeBandId : null,
            'description'   => $description,
            'status'        => $status,
        ]);

        $this->logAudit('UPDATE_DESIGNATION', 'designation', "Updated designation {$name} ({$code})", (int)$id);
        $this->session->setFlashdata('success', "Designation '{$name}' updated successfully.");
        return redirect()->to(site_url('departments?tab=designations'));
    }

    /**
     * Delete designation
     */
    public function deleteDesignation($id)
    {
        if (!$this->hasPermission('department.manage') && !$this->hasPermission('designation.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to delete designations.');
            return redirect()->to(site_url('departments?tab=designations'));
        }

        $designationModel = new DesignationModel();
        $designation = $designationModel->find((int)$id);
        if (!$designation) {
            $this->session->setFlashdata('error', 'Designation not found.');
            return redirect()->to(site_url('departments?tab=designations'));
        }

        $db = \Config\Database::connect();
        // Safely set employees referencing this designation to null
        $db->table('employees')->where('designation_id', (int)$id)->update(['designation_id' => null]);
        $designationModel->delete((int)$id);

        $this->logAudit('DELETE_DESIGNATION', 'designation', "Deleted designation {$designation['name']} ({$designation['code']})", (int)$id);
        $this->session->setFlashdata('success', "Designation '{$designation['name']}' deleted successfully.");
        return redirect()->to(site_url('departments?tab=designations'));
    }
}
