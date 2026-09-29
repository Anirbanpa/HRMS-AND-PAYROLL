<?php

namespace App\Controllers;

use App\Models\OvertimeRequestModel;
use App\Models\OvertimeRuleModel;
use App\Models\EmployeeModel;

/**
 * Class OvertimeController
 *
 * Module 15: Overtime Management, Approval Workflows & Payroll Calculation
 */
class OvertimeController extends BaseController
{
    /**
     * Overtime Operations Dashboard
     */
    public function index()
    {
        $otModel   = new OvertimeRequestModel();
        $ruleModel = new OvertimeRuleModel();

        $rules = $ruleModel->where('is_active', 1)->findAll();

        $currentEmployeeId = $this->currentUser['employee_id'] ?? null;
        $isManager = $this->hasRole(['super_admin', 'hr_admin', 'manager', 'payroll_manager']);

        $filters = [];
        if (!$isManager && $currentEmployeeId) {
            $filters['employee_id'] = $currentEmployeeId;
        }

        $statusFilter = $this->request->getGet('status');
        if ($statusFilter) {
            $filters['status'] = $statusFilter;
        }

        $requests = $otModel->getDetailedRequests($filters, 100);

        // Stats calculation
        $totalHoursApproved  = 0.0;
        $totalPayoutApproved = 0.0;
        $pendingCount        = 0;

        foreach ($requests as $r) {
            if ($r['status'] === 'pending') {
                $pendingCount++;
            } elseif (in_array($r['status'], ['manager_approved', 'hr_approved', 'payroll_processed'])) {
                $totalHoursApproved  += (float)$r['total_hours'];
                $totalPayoutApproved += (float)$r['payout_amount'];
            }
        }

        $data = [
            'requests'            => $requests,
            'rules'               => $rules,
            'totalHoursApproved'  => $totalHoursApproved,
            'totalPayoutApproved' => $totalPayoutApproved,
            'pendingCount'        => $pendingCount,
            'isManager'           => $isManager,
            'filters'             => $filters,
        ];

        return $this->render('overtime/index', $data, 'Overtime Management & Calculations');
    }

    /**
     * Submit Overtime Claim (Employee Self-Service)
     */
    public function apply()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee profile linked to your user account.');
            return redirect()->to(site_url('overtime'));
        }

        $rules = [
            'request_date' => 'required|valid_date',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'reason'       => 'required|min_length[5]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('overtime'));
        }

        $startTime = $this->request->getPost('start_time');
        $endTime   = $this->request->getPost('end_time');
        $hours     = (strtotime($endTime) - strtotime($startTime)) / 3600;

        if ($hours <= 0) {
            $hours += 24; // Handle overnight overtime span
        }
        $totalHours = round($hours, 2);

        $ruleId = $this->request->getPost('overtime_rule_id') ?: 1;
        $otModel = new OvertimeRequestModel();

        $otModel->insert([
            'employee_id'      => $employeeId,
            'overtime_rule_id' => $ruleId,
            'request_date'     => $this->request->getPost('request_date'),
            'start_time'       => $startTime,
            'end_time'         => $endTime,
            'total_hours'      => $totalHours,
            'reason'           => $this->request->getPost('reason'),
            'status'           => 'pending',
        ]);

        $this->logAudit('OVERTIME_APPLY', 'overtime', "Submitted {$totalHours} hours overtime request for {$this->request->getPost('request_date')}");
        $this->session->setFlashdata('success', "Overtime request for {$totalHours} hours submitted successfully.");
        return redirect()->to(site_url('overtime'));
    }

    /**
     * Approve Overtime Request & Calculate Monetary Value
     */
    public function approve($id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to approve overtime.');
            return redirect()->to(site_url('overtime'));
        }

        $otModel   = new OvertimeRequestModel();
        $ruleModel = new OvertimeRuleModel();

        $request = $otModel->find((int)$id);
        if (!$request) {
            $this->session->setFlashdata('error', 'Overtime record not found.');
            return redirect()->to(site_url('overtime'));
        }

        $rule = $ruleModel->find((int)$request['overtime_rule_id']);
        $multiplier = $rule ? (float)$rule['rate_multiplier'] : 1.50;

        // Calculate wage payout
        $hourlyRate = $otModel->calculateHourlyRate((int)$request['employee_id'], $multiplier);
        $payoutAmount = round((float)$request['total_hours'] * $hourlyRate, 2);

        $newStatus = $this->hasRole(['super_admin', 'hr_admin']) ? 'hr_approved' : 'manager_approved';

        $otModel->update((int)$id, [
            'status'            => $newStatus,
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Approved',
            'hourly_rate'       => $hourlyRate,
            'payout_amount'     => $payoutAmount,
        ]);

        $this->logAudit('OVERTIME_APPROVE', 'overtime', "Approved overtime ID {$id} with calculated payout {$payoutAmount}");

        // Dispatch notification
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('overtime_approved', (int)$request['employee_id'], [
            '{{DETAILS}}'     => "{$request['total_hours']} overtime hours on {$request['request_date']} (Payout: ₹{$payoutAmount})",
            '{{ACTION_DATE}}' => date('F j, Y'),
        ], ['in_app', 'email']);

        $this->session->setFlashdata('success', "Overtime approved. Payout of ₹{$payoutAmount} computed for payroll.");
        return redirect()->to(site_url('overtime'));
    }

    /**
     * Reject Overtime Request
     */
    public function reject($id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to reject overtime.');
            return redirect()->to(site_url('overtime'));
        }

        $otModel = new OvertimeRequestModel();
        $otModel->update((int)$id, [
            'status'            => 'rejected',
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Rejected by manager',
        ]);

        $this->logAudit('OVERTIME_REJECT', 'overtime', "Rejected overtime ID {$id}");
        $this->session->setFlashdata('warning', 'Overtime request rejected.');
        return redirect()->to(site_url('overtime'));
    }
}
