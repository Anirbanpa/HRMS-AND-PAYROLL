<?php

namespace App\Controllers;

use App\Models\EmployeeTransferPromotionModel;
use App\Models\EmployeeModel;
use App\Models\BranchModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;

/**
 * Class TransferPromotionController
 *
 * Module 31: Employee Transfer & Promotion Management
 */
class TransferPromotionController extends BaseController
{
    /**
     * Career Movements & Promotions Portfolio
     */
    public function index()
    {
        $movementModel = new EmployeeTransferPromotionModel();
        $empModel      = new EmployeeModel();
        $branchModel   = new BranchModel();
        $deptModel     = new DepartmentModel();
        $desigModel    = new DesignationModel();
        $db            = \Config\Database::connect();

        $isHR = $this->hasRole(['super_admin', 'hr_admin', 'hr_executive']);
        $currentEmpId = $this->currentUser['employee_id'] ?? null;

        $filters = [];
        if (!$isHR && $currentEmpId) {
            $filters['employee_id'] = $currentEmpId;
        }

        $typeFilter = $this->request->getGet('type');
        if ($typeFilter) {
            $filters['movement_type'] = $typeFilter;
        }

        $movements   = $movementModel->getDetailedMovements($filters, 100);
        $employees   = $empModel->whereIn('employment_status', ['active', 'probation', 'notice_period'])->findAll();
        $branches    = $branchModel->findAll();
        $departments = $deptModel->findAll();
        $designations= $desigModel->findAll();
        $payGrades   = $db->table('pay_grades')->get()->getResultArray();

        // Calculate KPIs
        $totalTransfers  = 0;
        $totalPromotions = 0;
        $pendingCount    = 0;

        foreach ($movements as $m) {
            if (in_array($m['movement_type'], ['transfer', 'transfer_and_promotion'])) {
                $totalTransfers++;
            }
            if (in_array($m['movement_type'], ['promotion', 'transfer_and_promotion'])) {
                $totalPromotions++;
            }
            if (in_array($m['status'], ['submitted', 'manager_endorsed'])) {
                $pendingCount++;
            }
        }

        $data = [
            'movements'       => $movements,
            'employees'       => $employees,
            'branches'        => $branches,
            'departments'     => $departments,
            'designations'    => $designations,
            'payGrades'       => $payGrades,
            'totalTransfers'  => $totalTransfers,
            'totalPromotions' => $totalPromotions,
            'pendingCount'    => $pendingCount,
            'isHR'            => $isHR,
        ];

        return $this->render('career/transfers_promotions', $data, 'Employee Transfer & Promotion Management');
    }

    /**
     * Submit Transfer / Promotion Requisition
     */
    public function store()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to initiate transfer or promotion requisitions.');
            return redirect()->to(site_url('career-movements'));
        }

        $empModel      = new EmployeeModel();
        $movementModel = new EmployeeTransferPromotionModel();

        $employeeId = (int)$this->request->getPost('employee_id');
        $employee   = $empModel->find($employeeId);

        if (!$employee) {
            $this->session->setFlashdata('error', 'Target employee not found.');
            return redirect()->to(site_url('career-movements'));
        }

        $reqNumber = 'MOV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $movementType = $this->request->getPost('movement_type');

        $movementModel->insert([
            'request_number'      => $reqNumber,
            'employee_id'         => $employeeId,
            'movement_type'       => $movementType,
            'effective_date'      => $this->request->getPost('effective_date') ?: date('Y-m-d'),
            'from_branch_id'      => $employee['branch_id'],
            'to_branch_id'        => $this->request->getPost('to_branch_id') ?: $employee['branch_id'],
            'from_department_id'  => $employee['department_id'],
            'to_department_id'    => $this->request->getPost('to_department_id') ?: $employee['department_id'],
            'from_designation_id' => $employee['designation_id'],
            'to_designation_id'   => $this->request->getPost('to_designation_id') ?: $employee['designation_id'],
            'from_pay_grade_id'   => $employee['pay_grade_id'],
            'to_pay_grade_id'     => $this->request->getPost('to_pay_grade_id') ?: $employee['pay_grade_id'],
            'from_reporting_to'   => $employee['reporting_to'],
            'to_reporting_to'     => $this->request->getPost('to_reporting_to') ?: $employee['reporting_to'],
            'current_salary'      => (float)($this->request->getPost('current_salary') ?: 0.00),
            'revised_salary'      => (float)($this->request->getPost('revised_salary') ?: 0.00),
            'reason'              => trim((string)$this->request->getPost('reason')),
            'remarks'             => trim((string)$this->request->getPost('remarks')),
            'status'              => 'submitted',
            'requested_by'        => $this->userId(),
        ]);

        $this->logAudit('CAREER_MOVEMENT_SUBMIT', 'career', "Initiated {$movementType} requisition {$reqNumber} for Employee ID {$employeeId}");
        $this->session->setFlashdata('success', "Requisition {$reqNumber} submitted successfully for HR sign-off.");
        return redirect()->to(site_url('career-movements'));
    }

    /**
     * Approve and Execute Career Movement into Employee Master Record
     */
    public function approve(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to approve career movements.');
            return redirect()->to(site_url('career-movements'));
        }

        $movementModel = new EmployeeTransferPromotionModel();
        $empModel      = new EmployeeModel();

        $mov = $movementModel->find($id);
        if (!$mov) {
            $this->session->setFlashdata('error', 'Movement record not found.');
            return redirect()->to(site_url('career-movements'));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Mark requisition approved and implemented
        $movementModel->update($id, [
            'status'         => 'implemented',
            'approved_by'    => $this->userId(),
            'approved_at'    => date('Y-m-d H:i:s'),
            'implemented_at' => date('Y-m-d H:i:s'),
        ]);

        // 2. Synchronize new corporate placement in Employee Master
        $updateEmployeeData = [];
        if (!empty($mov['to_branch_id'])) {
            $updateEmployeeData['branch_id'] = $mov['to_branch_id'];
        }
        if (!empty($mov['to_department_id'])) {
            $updateEmployeeData['department_id'] = $mov['to_department_id'];
        }
        if (!empty($mov['to_designation_id'])) {
            $updateEmployeeData['designation_id'] = $mov['to_designation_id'];
        }
        if (!empty($mov['to_pay_grade_id'])) {
            $updateEmployeeData['pay_grade_id'] = $mov['to_pay_grade_id'];
        }
        if (!empty($mov['to_reporting_to'])) {
            $updateEmployeeData['reporting_to'] = $mov['to_reporting_to'];
        }

        if (!empty($updateEmployeeData)) {
            $empModel->update($mov['employee_id'], $updateEmployeeData);
        }

        $db->transComplete();

        $this->logAudit('CAREER_MOVEMENT_APPROVE', 'career', "Approved and synchronized {$mov['movement_type']} for Employee ID {$mov['employee_id']}");
        $this->session->setFlashdata('success', "Movement requisition #{$mov['request_number']} fully approved and updated in employee records.");
        return redirect()->to(site_url('career-movements'));
    }

    /**
     * Reject Career Movement Requisition
     */
    public function reject(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to reject career movements.');
            return redirect()->to(site_url('career-movements'));
        }

        $movementModel = new EmployeeTransferPromotionModel();
        $movementModel->update($id, [
            'status'      => 'rejected',
            'approved_by' => $this->userId(),
            'approved_at' => date('Y-m-d H:i:s'),
            'remarks'     => $this->request->getPost('remarks') ?: 'Rejected by HR Management',
        ]);

        $this->logAudit('CAREER_MOVEMENT_REJECT', 'career', "Rejected career movement record #{$id}");
        $this->session->setFlashdata('warning', 'Career movement requisition marked as rejected.');
        return redirect()->to(site_url('career-movements'));
    }
}
