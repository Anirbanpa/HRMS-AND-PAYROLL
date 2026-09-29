<?php

namespace App\Controllers;

use App\Models\DisciplinaryActionModel;
use App\Models\EmployeeModel;

/**
 * Class DisciplinaryController
 *
 * Module 33: Employee Warning & Disciplinary Records
 */
class DisciplinaryController extends BaseController
{
    /**
     * Disciplinary Incidents & Warnings Hub
     */
    public function index()
    {
        $actionModel = new DisciplinaryActionModel();
        $empModel    = new EmployeeModel();

        $isHR = $this->hasRole(['super_admin', 'hr_admin', 'hr_executive']);
        $isManager = $this->hasRole(['manager']);
        $currentEmpId = $this->currentUser['employee_id'] ?? null;

        $filters = [];
        if (!$isHR && !$isManager && $currentEmpId) {
            $filters['employee_id'] = $currentEmpId;
        }

        $typeFilter = $this->request->getGet('action_type');
        if ($typeFilter) {
            $filters['action_type'] = $typeFilter;
        }

        $cases     = $actionModel->getDetailedCases($filters, 100);
        $employees = $empModel->whereIn('employment_status', ['active', 'probation', 'notice_period'])->findAll();

        // Calculate KPIs
        $warningCount    = 0;
        $pipCount        = 0;
        $suspensionCount = 0;
        $closedCount     = 0;

        foreach ($cases as $c) {
            if (in_array($c['action_type'], ['verbal_warning', 'written_warning', 'final_warning'])) {
                $warningCount++;
            }
            if ($c['action_type'] === 'pip') {
                $pipCount++;
            }
            if ($c['action_type'] === 'suspension') {
                $suspensionCount++;
            }
            if ($c['status'] === 'closed') {
                $closedCount++;
            }
        }

        $data = [
            'cases'           => $cases,
            'employees'       => $employees,
            'warningCount'    => $warningCount,
            'pipCount'        => $pipCount,
            'suspensionCount' => $suspensionCount,
            'closedCount'     => $closedCount,
            'isHR'            => $isHR,
            'isManager'       => $isManager,
            'currentEmpId'    => $currentEmpId,
        ];

        return $this->render('disciplinary/index', $data, 'Employee Warning & Disciplinary Records');
    }

    /**
     * Issue Disciplinary Notice or Warning
     */
    public function store()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to issue disciplinary actions.');
            return redirect()->to(site_url('disciplinary'));
        }

        $actionModel = new DisciplinaryActionModel();

        $employeeId = (int)$this->request->getPost('employee_id');
        $caseNo     = 'DIS-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        // Handle attachment file upload
        $attachmentPath = null;
        $file = $this->request->getFile('attachment');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDir = FCPATH . 'uploads/disciplinary/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $attachmentPath = 'uploads/disciplinary/' . $newName;
        }

        $actionModel->insert([
            'case_number'     => $caseNo,
            'employee_id'     => $employeeId,
            'incident_date'   => $this->request->getPost('incident_date') ?: date('Y-m-d'),
            'action_type'     => $this->request->getPost('action_type'),
            'severity_level'  => $this->request->getPost('severity_level') ?: 'minor',
            'title'           => trim((string)$this->request->getPost('title')),
            'description'     => trim((string)$this->request->getPost('description')),
            'action_taken'    => trim((string)$this->request->getPost('action_taken')),
            'pip_start_date'  => $this->request->getPost('pip_start_date') ?: null,
            'pip_end_date'    => $this->request->getPost('pip_end_date') ?: null,
            'suspension_days' => $this->request->getPost('suspension_days') ? (int)$this->request->getPost('suspension_days') : null,
            'attachment_path' => $attachmentPath,
            'status'          => 'issued',
            'is_confidential' => 1,
            'issued_by'       => $this->userId(),
        ]);

        $this->logAudit('DISCIPLINARY_ISSUE', 'disciplinary', "Issued {$this->request->getPost('action_type')} case {$caseNo} for Employee ID {$employeeId}");
        $this->session->setFlashdata('success', "Disciplinary record {$caseNo} issued successfully.");
        return redirect()->to(site_url('disciplinary'));
    }

    /**
     * Employee Acknowledges Disciplinary Notice
     */
    public function acknowledge(int $id)
    {
        $actionModel = new DisciplinaryActionModel();
        $record = $actionModel->find($id);

        if (!$record) {
            $this->session->setFlashdata('error', 'Disciplinary record not found.');
            return redirect()->to(site_url('disciplinary'));
        }

        $explanation = trim((string)$this->request->getPost('employee_explanation'));

        $actionModel->update($id, [
            'status'                   => 'acknowledged',
            'employee_explanation'     => $explanation,
            'employee_acknowledged_at' => date('Y-m-d H:i:s'),
        ]);

        $this->logAudit('DISCIPLINARY_ACK', 'disciplinary', "Employee acknowledged case {$record['case_number']}");
        $this->session->setFlashdata('success', 'You have digitally acknowledged the disciplinary record.');
        return redirect()->to(site_url('disciplinary'));
    }

    /**
     * Close Disciplinary Case
     */
    public function close(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to close disciplinary cases.');
            return redirect()->to(site_url('disciplinary'));
        }

        $actionModel = new DisciplinaryActionModel();
        $notes = trim((string)$this->request->getPost('closure_notes')) ?: 'Case reviewed and closed by HR.';

        $actionModel->update($id, [
            'status'        => 'closed',
            'closure_notes' => $notes,
            'closed_at'     => date('Y-m-d H:i:s'),
        ]);

        $this->logAudit('DISCIPLINARY_CLOSE', 'disciplinary', "Closed disciplinary case ID {$id}");
        $this->session->setFlashdata('success', 'Disciplinary case marked as closed and archived.');
        return redirect()->to(site_url('disciplinary'));
    }
}
