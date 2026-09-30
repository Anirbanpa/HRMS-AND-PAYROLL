<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\AttendanceModel;
use App\Models\LeaveRequestModel;
use App\Models\OvertimeRequestModel;
use App\Models\OvertimeRuleModel;
use App\Models\ReimbursementRequestModel;
use App\Models\AttendanceCorrectionModel;

/**
 * Class ManagerController
 *
 * Module 27: Manager Self-Service (MSS) Portal & Team Approvals Hub
 */
class ManagerController extends BaseController
{
    /**
     * Unified Manager Self-Service Dashboard & Unified Approvals Hub
     */
    public function index()
    {
        $currentEmpId = $this->currentUser['employee_id'] ?? null;
        $isAdmin      = $this->hasRole(['super_admin', 'hr_admin']);
        $isManager    = $this->hasRole(['manager', 'hr_executive', 'payroll_manager']);

        if (!$isAdmin && !$isManager) {
            $this->session->setFlashdata('error', 'Access Denied: Manager Self-Service requires managerial or supervisory authority.');
            return redirect()->to(site_url('dashboard'));
        }

        // Allow access to admins even if employee record is not linked
        if (!$currentEmpId && !$isAdmin) {
            $this->session->setFlashdata('warning', 'No active employee profile linked to your user account.');
            return redirect()->to(site_url('dashboard'));
        }

        $empModel        = new EmployeeModel();
        $attModel        = new AttendanceModel();
        $leaveModel      = new LeaveRequestModel();
        $otModel         = new OvertimeRequestModel();
        $reimbModel      = new ReimbursementRequestModel();
        $correctionModel = new AttendanceCorrectionModel();

        // 1. Fetch team members
        $teamBuilder = $empModel->select('employees.*, d.name as department_name, des.name as designation_name')
            ->join('departments d', 'd.id = employees.department_id', 'left')
            ->join('designations des', 'des.id = employees.designation_id', 'left')
            ->whereIn('employees.employment_status', ['active', 'probation', 'notice_period']);

        if (!$isAdmin && $currentEmpId) {
            $teamBuilder->where('employees.reporting_to', $currentEmpId);
        }

        $team = $teamBuilder->findAll();

        // If admin has no direct reports assigned, show all active staff for supervision
        if ($isAdmin && empty($team)) {
            $team = $empModel->select('employees.*, d.name as department_name, des.name as designation_name')
                ->join('departments d', 'd.id = employees.department_id', 'left')
                ->join('designations des', 'des.id = employees.designation_id', 'left')
                ->whereIn('employees.employment_status', ['active', 'probation', 'notice_period'])
                ->limit(50)
                ->findAll();
        }

        $teamIds = array_column($team, 'id');

        // 2. Team attendance today
        $today = date('Y-m-d');
        $teamAttendance = [];
        if (!empty($teamIds)) {
            $teamAttendance = $attModel->whereIn('employee_id', $teamIds)
                ->where('date', $today)
                ->findAll();
        }

        // 3. Pending approvals across all streams
        if ($isAdmin) {
            // Admins can see and approve all pending items across the organisation
            $pendingLeaves         = $leaveModel->getDetailedRequests(['status' => 'pending']);
            $pendingOvertime       = $otModel->getDetailedRequests(['status' => 'pending']);
            $pendingReimbursements = $reimbModel->getDetailedClaims(['status' => 'submitted']);
            $pendingCorrections    = $correctionModel->getManagerQueue(null, 'pending');
        } else {
            // Managers see items for employees reporting to them
            $pendingLeaves         = $currentEmpId ? $leaveModel->getDetailedRequests(['reporting_to' => $currentEmpId, 'status' => 'pending']) : [];
            $pendingOvertime       = $currentEmpId ? $otModel->getDetailedRequests(['manager_id' => $currentEmpId, 'status' => 'pending']) : [];
            $pendingReimbursements = $currentEmpId ? $reimbModel->getDetailedClaims(['manager_id' => $currentEmpId, 'status' => 'submitted']) : [];
            $pendingCorrections    = $currentEmpId ? $correctionModel->getManagerQueue((int)$currentEmpId, 'pending') : [];
        }

        $data = [
            'team'                  => $team,
            'teamAttendance'        => $teamAttendance,
            'pendingLeaves'         => $pendingLeaves,
            'pendingOvertime'       => $pendingOvertime,
            'pendingReimbursements' => $pendingReimbursements,
            'pendingCorrections'    => $pendingCorrections,
            'today'                 => $today,
            'isAdmin'               => $isAdmin,
        ];

        return $this->render('manager/index', $data, 'Manager Self-Service & Team Hub');
    }

    /**
     * Approve Attendance Correction
     */
    public function approveCorrection($id)
    {
        $correctionModel = new AttendanceCorrectionModel();
        $attModel        = new AttendanceModel();

        $corr = $correctionModel->find((int)$id);
        if (!$corr) {
            $this->session->setFlashdata('error', 'Correction record not found.');
            return redirect()->to(site_url('manager'));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $correctionModel->update((int)$id, [
            'status'            => 'approved',
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Approved by Manager',
        ]);

        // Calculate revised hours
        $inTime  = strtotime($corr['requested_clock_in']);
        $outTime = strtotime($corr['requested_clock_out']);
        $hours   = round(($outTime - $inTime) / 3600, 2);

        // Update or insert attendance
        $existing = $attModel->where('employee_id', $corr['employee_id'])
            ->where('date', $corr['attendance_date'])
            ->first();

        if ($existing) {
            $attModel->update($existing['id'], [
                'clock_in'    => $corr['requested_clock_in'],
                'clock_out'   => $corr['requested_clock_out'],
                'total_hours' => $hours,
                'status'      => 'Present',
                'source'      => 'manual_adjustment',
                'notes'       => 'Correction approved by Manager',
            ]);
        } else {
            $attModel->insert([
                'employee_id' => $corr['employee_id'],
                'date'        => $corr['attendance_date'],
                'clock_in'    => $corr['requested_clock_in'],
                'clock_out'   => $corr['requested_clock_out'],
                'total_hours' => $hours,
                'status'      => 'Present',
                'source'      => 'manual_adjustment',
                'notes'       => 'Correction approved by Manager',
            ]);
        }

        $db->transComplete();

        $this->logAudit('CORRECTION_APPROVE', 'manager', "Approved punch correction for Employee ID {$corr['employee_id']}");
        $this->session->setFlashdata('success', 'Attendance punch correction approved.');
        return redirect()->to(site_url('manager'));
    }

    /**
     * Reject Attendance Correction
     */
    public function rejectCorrection($id)
    {
        $correctionModel = new AttendanceCorrectionModel();
        $corr = $correctionModel->find((int)$id);
        if (!$corr) {
            $this->session->setFlashdata('error', 'Correction record not found.');
            return redirect()->to(site_url('manager'));
        }

        $correctionModel->update((int)$id, [
            'status'            => 'rejected',
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Rejected by Manager',
        ]);

        $this->logAudit('CORRECTION_REJECT', 'manager', "Rejected punch correction ID {$id}");
        $this->session->setFlashdata('warning', 'Attendance punch correction rejected.');
        return redirect()->to(site_url('manager'));
    }

    /**
     * Approve Leave from Manager Portal
     */
    public function approveLeave($id)
    {
        $leaveModel = new LeaveRequestModel();
        $req = $leaveModel->find((int)$id);
        if (!$req) {
            $this->session->setFlashdata('error', 'Leave request not found.');
            return redirect()->to(site_url('manager'));
        }

        $now = date('Y-m-d H:i:s');
        $isAdmin = $this->hasRole(['super_admin', 'hr_admin']);
        $newStatus = $isAdmin ? 'hr_approved' : 'manager_approved';

        $db = \Config\Database::connect();
        $db->transStart();

        $leaveModel->update((int)$id, [
            'status'            => $newStatus,
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => $now,
            'hr_id'             => $isAdmin ? ($this->currentUser['id'] ?? null) : null,
            'hr_action_at'      => $isAdmin ? $now : null,
        ]);

        if ($isAdmin) {
            // Deduct balance if HR/SuperAdmin approves directly
            $balance = $db->table('leave_balances')
                ->where('employee_id', $req['employee_id'])
                ->where('leave_type_id', $req['leave_type_id'])
                ->where('year', date('Y', strtotime($req['start_date'])))
                ->get()
                ->getFirstRow('array');

            if ($balance) {
                $newUsed = $balance['used_days'] + $req['total_days'];
                $newRem  = max(0, $balance['allocated_days'] - $newUsed);
                $db->table('leave_balances')->where('id', $balance['id'])->update([
                    'used_days'      => $newUsed,
                    'remaining_days' => $newRem,
                ]);
            }
        }

        $db->transComplete();

        $this->logAudit('LEAVE_APPROVE_MSS', 'leaves', "Manager Portal approved leave request #{$id}");
        $this->session->setFlashdata('success', "Leave request #{$id} approved successfully.");
        return redirect()->to(site_url('manager'));
    }

    /**
     * Reject Leave from Manager Portal
     */
    public function rejectLeave($id)
    {
        $leaveModel = new LeaveRequestModel();
        $reason = trim((string)$this->request->getPost('remarks')) ?: 'Operational schedule conflicts.';

        $leaveModel->update((int)$id, [
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        $this->logAudit('LEAVE_REJECT_MSS', 'leaves', "Manager Portal rejected leave request #{$id}");
        $this->session->setFlashdata('warning', "Leave request #{$id} rejected.");
        return redirect()->to(site_url('manager'));
    }

    /**
     * Approve Overtime from Manager Portal
     */
    public function approveOvertime($id)
    {
        $otModel   = new OvertimeRequestModel();
        $ruleModel = new OvertimeRuleModel();

        $request = $otModel->find((int)$id);
        if (!$request) {
            $this->session->setFlashdata('error', 'Overtime record not found.');
            return redirect()->to(site_url('manager'));
        }

        $rule = $ruleModel->find((int)$request['overtime_rule_id']);
        $multiplier = $rule ? (float)$rule['rate_multiplier'] : 1.50;

        $hourlyRate = $otModel->calculateHourlyRate((int)$request['employee_id'], $multiplier);
        $payoutAmount = round((float)$request['total_hours'] * $hourlyRate, 2);

        $newStatus = $this->hasRole(['super_admin', 'hr_admin']) ? 'hr_approved' : 'manager_approved';

        $otModel->update((int)$id, [
            'status'            => $newStatus,
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Approved in Manager Portal',
            'hourly_rate'       => $hourlyRate,
            'payout_amount'     => $payoutAmount,
        ]);

        $this->logAudit('OVERTIME_APPROVE_MSS', 'overtime', "Manager portal approved overtime #{$id}");
        $this->session->setFlashdata('success', "Overtime #{$id} approved. Payout: ₹{$payoutAmount}.");
        return redirect()->to(site_url('manager'));
    }

    /**
     * Reject Overtime from Manager Portal
     */
    public function rejectOvertime($id)
    {
        $otModel = new OvertimeRequestModel();
        $otModel->update((int)$id, [
            'status'            => 'rejected',
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Rejected in Manager Portal',
        ]);

        $this->logAudit('OVERTIME_REJECT_MSS', 'overtime', "Manager portal rejected overtime #{$id}");
        $this->session->setFlashdata('warning', "Overtime #{$id} rejected.");
        return redirect()->to(site_url('manager'));
    }

    /**
     * Approve Reimbursement Claim from Manager Portal
     */
    public function approveReimbursement($id)
    {
        $reimbModel = new ReimbursementRequestModel();
        $claim = $reimbModel->find((int)$id);
        if (!$claim) {
            $this->session->setFlashdata('error', 'Claim not found.');
            return redirect()->to(site_url('manager'));
        }

        $approvedAmount = $this->request->getPost('approved_amount') ? (float)$this->request->getPost('approved_amount') : (float)$claim['amount'];
        $isAdmin = $this->hasRole(['super_admin', 'accountant', 'payroll_manager', 'hr_admin']);

        if ($isAdmin) {
            $reimbModel->update((int)$id, [
                'status'              => 'finance_approved',
                'approved_amount'     => $approvedAmount,
                'finance_approver_id' => $this->userId(),
                'finance_action_at'   => date('Y-m-d H:i:s'),
                'finance_remarks'     => $this->request->getPost('remarks') ?: 'Approved in Portal',
            ]);
            $this->session->setFlashdata('success', "Claim #{$claim['claim_number']} fully approved by Finance.");
        } else {
            $reimbModel->update((int)$id, [
                'status'            => 'manager_approved',
                'approved_amount'   => $approvedAmount,
                'manager_id'        => $this->currentUser['employee_id'] ?? null,
                'manager_action_at' => date('Y-m-d H:i:s'),
                'manager_remarks'   => $this->request->getPost('remarks') ?: 'Endorsed by Manager',
            ]);
            $this->session->setFlashdata('success', "Claim #{$claim['claim_number']} endorsed and forwarded to Finance.");
        }

        $this->logAudit('REIMBURSEMENT_APPROVE_MSS', 'reimbursements', "Approved claim ID {$id}");
        return redirect()->to(site_url('manager'));
    }

    /**
     * Reject Reimbursement Claim from Manager Portal
     */
    public function rejectReimbursement($id)
    {
        $reimbModel = new ReimbursementRequestModel();
        $reimbModel->update((int)$id, [
            'status'            => 'rejected',
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Rejected in Manager Portal',
        ]);

        $this->logAudit('REIMBURSEMENT_REJECT_MSS', 'reimbursements', "Rejected claim ID {$id}");
        $this->session->setFlashdata('warning', 'Expense claim rejected.');
        return redirect()->to(site_url('manager'));
    }
}
