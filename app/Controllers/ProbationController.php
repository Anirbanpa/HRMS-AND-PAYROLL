<?php

namespace App\Controllers;

use App\Models\ProbationAssessmentModel;
use App\Models\EmployeeModel;

/**
 * Class ProbationController
 *
 * Module 32: Confirmation & Probation Management
 */
class ProbationController extends BaseController
{
    /**
     * Probation Tracking & Confirmation Dashboard
     */
    public function index()
    {
        $probationModel = new ProbationAssessmentModel();
        $empModel       = new EmployeeModel();

        $isHR = $this->hasRole(['super_admin', 'hr_admin', 'hr_executive']);
        $currentEmpId = $this->currentUser['employee_id'] ?? null;

        // Auto-synchronize any employee currently marked with status 'probation', type 'probation', or with probation_end_date
        $probationers = $empModel->groupStart()
                ->where('employment_status', 'probation')
                ->orWhere('employment_type', 'probation')
                ->orWhere('probation_end_date IS NOT NULL', null, false)
            ->groupEnd()
            ->whereNotIn('employment_status', ['terminated', 'resigned', 'retired'])
            ->findAll();

        foreach ($probationers as $prob) {
            $existing = $probationModel->where('employee_id', $prob['id'])->first();
            if (!$existing) {
                $joinDate = $prob['joining_date'] ?: date('Y-m-d');
                $endDate  = $prob['probation_end_date'] ?: date('Y-m-d', strtotime('+3 months', strtotime($joinDate)));
                $isDue    = (strtotime($endDate) <= strtotime('+15 days'));
                $probationModel->insert([
                    'employee_id'                => $prob['id'],
                    'joining_date'               => $joinDate,
                    'initial_probation_end_date' => $endDate,
                    'current_probation_end_date' => $endDate,
                    'assessment_status'          => $isDue ? 'due' : 'under_review',
                    'manager_id'                 => $prob['reporting_to'],
                ]);

                // Ensure employee table has consistent status and probation_end_date
                if ($prob['employment_status'] !== 'probation' || empty($prob['probation_end_date'])) {
                    $empModel->update($prob['id'], [
                        'employment_status'  => 'probation',
                        'employment_type'    => 'probation',
                        'probation_end_date' => $endDate,
                    ]);
                }
            }
        }

        // Scope filters for manager vs HR
        $scopeFilters = [];
        if (!$isHR && $currentEmpId) {
            $scopeFilters['manager_id'] = $currentEmpId;
        }

        // Compute KPIs across all records within user scope (unfiltered by UI tab)
        $allScopeRecords = $probationModel->getDetailedProbations($scopeFilters, 500);

        $dueCount       = 0;
        $activeCount    = 0;
        $confirmedCount = 0;
        $extendedCount  = 0;

        foreach ($allScopeRecords as $r) {
            if ($r['assessment_status'] === 'due') {
                $dueCount++;
            } elseif ($r['assessment_status'] === 'under_review') {
                $activeCount++;
            } elseif ($r['assessment_status'] === 'confirmed') {
                $confirmedCount++;
            } elseif ($r['assessment_status'] === 'extended') {
                $extendedCount++;
            }
        }

        // Table filtered records
        $tableFilters = $scopeFilters;
        $statusFilter = $this->request->getGet('status');
        if ($statusFilter && in_array($statusFilter, ['due', 'under_review', 'confirmed', 'extended'])) {
            $tableFilters['assessment_status'] = $statusFilter;
        }

        $records = $probationModel->getDetailedProbations($tableFilters, 100);

        // Fetch active employees and managers for manual enrollment modal
        $activeEmployees = $empModel->select('employees.id, employees.employee_code, employees.first_name, employees.last_name, employees.joining_date, employees.reporting_to, d.name as department_name, des.name as designation_name')
            ->join('departments d', 'd.id = employees.department_id', 'left')
            ->join('designations des', 'des.id = employees.designation_id', 'left')
            ->whereNotIn('employees.employment_status', ['terminated', 'resigned', 'retired'])
            ->orderBy('employees.first_name', 'ASC')
            ->findAll();

        $managers = $empModel->select('id, employee_code, first_name, last_name')
            ->whereNotIn('employment_status', ['terminated', 'resigned', 'retired'])
            ->orderBy('first_name', 'ASC')
            ->findAll();

        $data = [
            'records'         => $records,
            'dueCount'        => $dueCount,
            'activeCount'     => $activeCount,
            'confirmedCount'  => $confirmedCount,
            'extendedCount'   => $extendedCount,
            'isHR'            => $isHR,
            'activeEmployees' => $activeEmployees,
            'managers'        => $managers,
        ];

        return $this->render('probation/index', $data, 'Confirmation & Probation Management');
    }

    /**
     * Enroll an employee into Probation Evaluation
     */
    public function enroll()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Unauthorized to enroll employees in probation.');
            return redirect()->to(site_url('probation'));
        }

        $empId = (int)$this->request->getPost('employee_id');
        $empModel = new EmployeeModel();
        $employee = $empModel->find($empId);

        if (!$employee) {
            $this->session->setFlashdata('error', 'Selected employee does not exist.');
            return redirect()->to(site_url('probation'));
        }

        $probationModel = new ProbationAssessmentModel();

        // Check if employee already has an active probation assessment
        $existing = $probationModel->where('employee_id', $empId)
            ->whereIn('assessment_status', ['due', 'under_review', 'extended'])
            ->first();

        if ($existing) {
            $this->session->setFlashdata('warning', "Employee {$employee['first_name']} {$employee['last_name']} already has an active probation evaluation (#{$existing['id']}).");
            return redirect()->to(site_url('probation'));
        }

        $joinDate = $this->request->getPost('joining_date') ?: ($employee['joining_date'] ?: date('Y-m-d'));
        $months   = (int)($this->request->getPost('duration_months') ?: 3);
        $endDate  = $this->request->getPost('probation_end_date');
        if (empty($endDate)) {
            $endDate = date('Y-m-d', strtotime("+{$months} months", strtotime($joinDate)));
        }

        $managerId = $this->request->getPost('manager_id') ?: ($employee['reporting_to'] ?: null);
        $status    = $this->request->getPost('assessment_status') ?: ((strtotime($endDate) <= strtotime('+15 days')) ? 'due' : 'under_review');
        $notes     = trim((string)$this->request->getPost('notes'));

        $db = \Config\Database::connect();
        $db->transStart();

        $probationModel->insert([
            'employee_id'                => $empId,
            'joining_date'               => $joinDate,
            'initial_probation_end_date' => $endDate,
            'current_probation_end_date' => $endDate,
            'assessment_status'          => $status,
            'manager_id'                 => $managerId,
            'manager_feedback'           => $notes ? "Evaluation Objectives: " . $notes : null,
            'hr_id'                      => $this->userId(),
        ]);

        $empModel->update($empId, [
            'employment_status'  => 'probation',
            'employment_type'    => 'probation',
            'probation_end_date' => $endDate,
            'reporting_to'       => $managerId,
        ]);

        $db->transComplete();

        $this->logAudit('PROBATION_ENROLL', 'probation', "Enrolled employee {$employee['employee_code']} ({$employee['first_name']} {$employee['last_name']}) in probation until {$endDate}");
        $this->session->setFlashdata('success', "Employee {$employee['first_name']} {$employee['last_name']} successfully enrolled in probation tracking until " . date('M j, Y', strtotime($endDate)) . "!");

        return redirect()->to(site_url('probation'));
    }

    /**
     * Submit Manager Probation Assessment & Performance Review
     */
    public function submitAssessment(int $id)
    {
        $probationModel = new ProbationAssessmentModel();
        $record = $probationModel->find($id);

        if (!$record) {
            $this->session->setFlashdata('error', 'Probation assessment record not found.');
            return redirect()->to(site_url('probation'));
        }

        $recommendation = $this->request->getPost('manager_recommendation');

        $probationModel->update($id, [
            'manager_id'                   => $this->currentUser['employee_id'] ?? null,
            'manager_rating'               => (int)$this->request->getPost('manager_rating'),
            'technical_competence_rating'  => (int)$this->request->getPost('technical_competence_rating'),
            'punctuality_attendance_rating'=> (int)$this->request->getPost('punctuality_attendance_rating'),
            'teamwork_culture_rating'      => (int)$this->request->getPost('teamwork_culture_rating'),
            'manager_feedback'             => trim((string)$this->request->getPost('manager_feedback')),
            'manager_recommendation'       => $recommendation,
            'manager_submitted_at'         => date('Y-m-d H:i:s'),
            'assessment_status'            => 'due',
        ]);

        $this->logAudit('PROBATION_ASSESSMENT', 'probation', "Manager evaluated probation record #{$id} with recommendation: {$recommendation}");
        $this->session->setFlashdata('success', 'Probation appraisal submitted successfully for HR confirmation.');
        return redirect()->to(site_url('probation'));
    }

    /**
     * Confirm Employee into Full-Time Employment
     */
    public function confirm(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to confirm employees.');
            return redirect()->to(site_url('probation'));
        }

        $probationModel = new ProbationAssessmentModel();
        $empModel       = new EmployeeModel();

        $record = $probationModel->find($id);
        if (!$record) {
            $this->session->setFlashdata('error', 'Probation record not found.');
            return redirect()->to(site_url('probation'));
        }

        $confirmDate = $this->request->getPost('confirmation_date') ?: date('Y-m-d');
        $remarks     = trim((string)$this->request->getPost('hr_remarks')) ?: 'Confirmed upon satisfactory completion of probation period.';

        $db = \Config\Database::connect();
        $db->transStart();

        $probationModel->update($id, [
            'assessment_status' => 'confirmed',
            'confirmation_date' => $confirmDate,
            'hr_id'             => $this->userId(),
            'hr_decision'       => 'confirmed',
            'hr_remarks'        => $remarks,
            'hr_action_at'      => date('Y-m-d H:i:s'),
            'letter_generated'  => 1,
        ]);

        // Synchronize employee record to active full-time
        $empModel->update($record['employee_id'], [
            'employment_status' => 'active',
            'employment_type'   => 'full_time',
            'confirmation_date' => $confirmDate,
        ]);

        $db->transComplete();

        $this->logAudit('PROBATION_CONFIRM', 'probation', "Confirmed Employee ID {$record['employee_id']} into full-time employment");
        $this->session->setFlashdata('success', 'Employee confirmed successfully! Profile updated to full-time active status.');
        return redirect()->to(site_url('probation'));
    }

    /**
     * Extend Employee Probation Period
     */
    public function extend(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to extend probation periods.');
            return redirect()->to(site_url('probation'));
        }

        $probationModel = new ProbationAssessmentModel();
        $empModel       = new EmployeeModel();

        $record = $probationModel->find($id);
        if (!$record) {
            $this->session->setFlashdata('error', 'Probation record not found.');
            return redirect()->to(site_url('probation'));
        }

        $months    = (int)($this->request->getPost('extension_months') ?: 3);
        $currEnd   = $record['current_probation_end_date'] ?: date('Y-m-d');
        $newEnd    = date('Y-m-d', strtotime("+{$months} months", strtotime($currEnd)));
        $reason    = trim((string)$this->request->getPost('extension_reason')) ?: 'Performance criteria extension required';

        $db = \Config\Database::connect();
        $db->transStart();

        $probationModel->update($id, [
            'assessment_status'          => 'extended',
            'extension_months'           => $months,
            'extended_until'             => $newEnd,
            'current_probation_end_date' => $newEnd,
            'extension_reason'           => $reason,
            'hr_id'                      => $this->userId(),
            'hr_decision'                => 'extended',
            'hr_remarks'                 => $reason,
            'hr_action_at'               => date('Y-m-d H:i:s'),
        ]);

        $empModel->update($record['employee_id'], [
            'probation_end_date' => $newEnd,
        ]);

        $db->transComplete();

        $this->logAudit('PROBATION_EXTEND', 'probation', "Extended probation for Employee ID {$record['employee_id']} by {$months} months");
        $this->session->setFlashdata('warning', "Probation period extended by {$months} months (Until {$newEnd}).");
        return redirect()->to(site_url('probation'));
    }
}
