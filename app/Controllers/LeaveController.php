<?php

namespace App\Controllers;

use App\Models\LeaveRequestModel;
use App\Models\EmployeeModel;

class LeaveController extends BaseController
{
    /**
     * Leave Management & Approval Portal (Module 13)
     */
    public function index()
    {
        $leaveModel = new LeaveRequestModel();
        $db = \Config\Database::connect();

        $employeeId = $this->currentUser['employee_id'] ?? null;
        $roleSlug   = $this->currentUser['role_slug'] ?? 'employee';

        // 1. Fetch Leave Types
        $leaveTypes = $db->table('leave_types')->where('status', 'active')->get()->getResultArray();

        // 2. Fetch User's Leave Balances if employee
        $myBalances = [];
        if ($employeeId) {
            $myBalances = $db->table('leave_balances lb')
                ->select('lb.*, lt.name as leave_type_name, lt.code as leave_type_code, lt.is_paid')
                ->join('leave_types lt', 'lt.id = lb.leave_type_id')
                ->where('lb.employee_id', $employeeId)
                ->where('lb.year', date('Y'))
                ->get()
                ->getResultArray();
        }

        // 3. Fetch Leave Requests based on Role Tier
        $filters = [];
        if ($roleSlug === 'employee') {
            $filters['employee_id'] = $employeeId;
        } elseif ($roleSlug === 'manager') {
            // Team requests reporting to this manager
            $filters['manager_id'] = $employeeId;
        }
        // Super Admin, HR Admin, Payroll see all requests

        $requests = $leaveModel->getDetailedRequests($filters, 100);

        $pendingCount  = 0;
        $approvedCount = 0;
        $rejectedCount = 0;
        foreach ($requests as $r) {
            if ($r['status'] === 'pending' || $r['status'] === 'manager_approved') $pendingCount++;
            if ($r['status'] === 'hr_approved') $approvedCount++;
            if ($r['status'] === 'rejected') $rejectedCount++;
        }

        $data = [
            'requests'      => $requests,
            'leaveTypes'    => $leaveTypes,
            'myBalances'    => $myBalances,
            'pendingCount'  => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'roleSlug'      => $roleSlug,
        ];

        return $this->render('leaves/index', $data, 'Leave Management & Approvals');
    }

    /**
     * Submit new leave application
     */
    public function apply()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No employee record associated with your user session.');
            return redirect()->to(site_url('leaves'));
        }

        $leaveTypeId = (int)$this->request->getPost('leave_type_id');
        $startDate   = (string)$this->request->getPost('start_date');
        $endDate     = (string)$this->request->getPost('end_date');
        $isHalfDay   = $this->request->getPost('is_half_day') ? 1 : 0;
        $reason      = trim((string)$this->request->getPost('reason'));

        if (empty($startDate) || empty($endDate) || empty($reason)) {
            $this->session->setFlashdata('error', 'Start date, end date, and reason are required.');
            return redirect()->to(site_url('leaves'));
        }

        // Calculate total days
        $start = strtotime($startDate);
        $end   = strtotime($endDate);

        if ($end < $start) {
            $this->session->setFlashdata('error', 'End date cannot be earlier than start date.');
            return redirect()->to(site_url('leaves'));
        }

        $totalDays = ($end - $start) / 86400 + 1;
        if ($isHalfDay) {
            $totalDays = 0.5;
        }

        // Validate Leave Balance
        $db = \Config\Database::connect();
        $balance = $db->table('leave_balances')
            ->where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', date('Y'))
            ->get()
            ->getFirstRow('array');

        if ($balance && $balance['remaining_days'] < $totalDays) {
            $this->session->setFlashdata('error', "Insufficient leave balance. You requested {$totalDays} days, but only {$balance['remaining_days']} days remain.");
            return redirect()->to(site_url('leaves'));
        }

        $leaveModel = new LeaveRequestModel();
        $id = $leaveModel->insert([
            'employee_id'   => $employeeId,
            'leave_type_id' => $leaveTypeId,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'total_days'    => $totalDays,
            'is_half_day'   => $isHalfDay,
            'reason'        => $reason,
            'status'        => 'pending',
        ]);

        $this->logAudit('APPLY_LEAVE', 'leaves', "Submitted leave request #{$id} ({$totalDays} days from {$startDate} to {$endDate})", $id);

        // Dispatch leave notification
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('leave_applied', $employeeId, [
            '{{DETAILS}}'     => "{$totalDays} day(s) from {$startDate} to {$endDate}",
            '{{ACTION_DATE}}' => date('F j, Y'),
        ], ['in_app', 'email']);

        $this->session->setFlashdata('success', "Leave application for {$totalDays} days submitted successfully for approval.");

        return redirect()->to(site_url('leaves'));
    }

    /**
     * Approve leave request (dual-layer: Manager -> HR)
     */
    public function approve(int $id)
    {
        if (!$this->hasPermission('leave.approve')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to approve leave requests.');
            return redirect()->to(site_url('leaves'));
        }

        $leaveModel = new LeaveRequestModel();
        $req = $leaveModel->find($id);

        if (!$req) {
            $this->session->setFlashdata('error', 'Leave request not found.');
            return redirect()->to(site_url('leaves'));
        }

        $roleSlug = $this->currentUser['role_slug'] ?? 'employee';
        $now = date('Y-m-d H:i:s');
        $db = \Config\Database::connect();

        if ($roleSlug === 'manager' && $req['status'] === 'pending') {
            // Manager Approval
            $leaveModel->update($id, [
                'status'            => 'manager_approved',
                'manager_id'        => $this->currentUser['employee_id'] ?? null,
                'manager_action_at' => $now,
            ]);
            $this->logAudit('MANAGER_APPROVE_LEAVE', 'leaves', "Manager approved leave request #{$id}.", $id);
            $this->session->setFlashdata('success', "Leave request #{$id} approved by Manager. Escalate to HR for final sign-off.");
        } else {
            // Final HR / Super Admin Approval
            $db->transStart();

            $leaveModel->update($id, [
                'status'       => 'hr_approved',
                'hr_id'        => $this->currentUser['id'] ?? null,
                'hr_action_at' => $now,
            ]);

            // Deduct from leave balance
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

            $db->transComplete();

            // Dispatch approval notification to employee
            $notifService = new \App\Libraries\NotificationService();
            $notifService->send('leave_applied', (int)$req['employee_id'], [
                '{{DETAILS}}'     => "Leave request #{$id} ({$req['total_days']} days) has been APPROVED",
                '{{ACTION_DATE}}' => date('F j, Y'),
            ], ['in_app', 'email']);

            $this->logAudit('HR_APPROVE_LEAVE', 'leaves', "HR fully approved leave request #{$id}. Deducted {$req['total_days']} days from balance.", $id);
            $this->session->setFlashdata('success', "Leave request #{$id} fully approved and balance deducted.");
        }

        return redirect()->to(site_url('leaves'));
    }

    /**
     * Reject leave request
     */
    public function reject(int $id)
    {
        if (!$this->hasPermission('leave.approve')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to reject leave requests.');
            return redirect()->to(site_url('leaves'));
        }

        $leaveModel = new LeaveRequestModel();
        $reason = trim((string)$this->request->getPost('rejection_reason')) ?: 'Business operational requirements.';

        $leaveModel->update($id, [
            'status'           => 'rejected',
            'rejection_reason' => $reason,
        ]);

        $this->logAudit('REJECT_LEAVE', 'leaves', "Rejected leave request #{$id}. Reason: {$reason}", $id);
        $this->session->setFlashdata('success', "Leave request #{$id} has been marked as Rejected.");

        return redirect()->to(site_url('leaves'));
    }
}
