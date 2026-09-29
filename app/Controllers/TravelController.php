<?php

namespace App\Controllers;

use App\Models\TravelRequestModel;
use App\Models\TravelExpenseClaimModel;
use App\Models\EmployeeModel;

/**
 * Class TravelController
 *
 * Module 39: Expense & Travel Management
 */
class TravelController extends BaseController
{
    /**
     * Business Travel Operations & Expense Claims Hub
     */
    public function index()
    {
        $travelModel = new TravelRequestModel();
        $claimModel  = new TravelExpenseClaimModel();
        $isFinance   = $this->hasRole(['super_admin', 'accountant', 'payroll_manager', 'hr_admin', 'manager']);
        $currentEmp  = $this->currentUser['employee_id'] ?? null;
        $db          = \Config\Database::connect();

        $filters = [];
        if (!$isFinance && $currentEmp) {
            $filters['employee_id'] = $currentEmp;
        }

        $trips = $travelModel->getDetailedTravels($filters);

        // Fetch itemized expense claims
        $claimsBuilder = $db->table('travel_expense_claims tec')
            ->select('tec.*, tr.request_number, tr.purpose as trip_purpose, tr.source_city, tr.destination_city, e.first_name, e.last_name, e.employee_code, d.name as department_name')
            ->join('travel_requests tr', 'tr.id = tec.travel_request_id', 'left')
            ->join('employees e', 'e.id = tec.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left');

        if (!$isFinance && $currentEmp) {
            $claimsBuilder->where('tec.employee_id', $currentEmp);
        }

        $claims = $claimsBuilder->orderBy('tec.id', 'DESC')->get()->getResultArray();

        // Calculate summary stats
        $totalApprovedBudget = 0.0;
        $totalClaimsSettled  = 0.0;
        $pendingTripsCount   = 0;
        $pendingClaimsCount  = 0;

        foreach ($trips as $tr) {
            if (in_array($tr['status'], ['approved', 'manager_approved', 'finance_approved'], true)) {
                $totalApprovedBudget += (float)$tr['estimated_budget'];
            }
            if ($tr['status'] === 'submitted') {
                $pendingTripsCount++;
            }
        }

        foreach ($claims as $cl) {
            if ($cl['status'] === 'approved' || $cl['status'] === 'reimbursed') {
                $totalClaimsSettled += (float)($cl['approved_amount'] ?: $cl['amount']);
            }
            if ($cl['status'] === 'submitted') {
                $pendingClaimsCount++;
            }
        }

        // My approved trips available for filing claims
        $myEligibleTrips = [];
        if ($currentEmp) {
            $myEligibleTrips = $travelModel->where('employee_id', $currentEmp)
                ->whereIn('status', ['submitted', 'approved', 'manager_approved', 'finance_approved'])
                ->orderBy('start_date', 'DESC')
                ->findAll();
        }

        $data = [
            'trips'               => $trips,
            'claims'              => $claims,
            'myEligibleTrips'     => $myEligibleTrips,
            'isFinance'           => $isFinance,
            'totalApprovedBudget' => $totalApprovedBudget,
            'totalClaimsSettled'  => $totalClaimsSettled,
            'pendingTripsCount'   => $pendingTripsCount,
            'pendingClaimsCount'  => $pendingClaimsCount,
            'activeTab'           => $this->request->getGet('tab') ?: 'trips',
        ];

        return $this->render('travel/index', $data, 'Travel Requests & Expense Claims');
    }

    /**
     * Submit Travel Request
     */
    public function apply()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee linked.');
            return redirect()->to(site_url('travel'));
        }

        $rules = [
            'purpose'          => 'required|min_length[5]|max_length[150]',
            'source_city'      => 'required',
            'destination_city' => 'required',
            'start_date'       => 'required|valid_date',
            'end_date'         => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('travel'));
        }

        $reqNo = 'TRV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $travelModel = new TravelRequestModel();

        $newId = $travelModel->insert([
            'request_number'   => $reqNo,
            'employee_id'      => $employeeId,
            'purpose'          => $this->request->getPost('purpose'),
            'travel_type'      => $this->request->getPost('travel_type') ?: 'domestic',
            'source_city'      => $this->request->getPost('source_city'),
            'destination_city' => $this->request->getPost('destination_city'),
            'start_date'       => $this->request->getPost('start_date'),
            'end_date'         => $this->request->getPost('end_date'),
            'estimated_budget' => (float)($this->request->getPost('estimated_budget') ?: 0.0),
            'advance_required' => (float)($this->request->getPost('advance_required') ?: 0.0),
            'notes'            => $this->request->getPost('notes'),
            'status'           => 'submitted',
        ]);

        // Send Notification to HR & Finance
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('leave_applied', $employeeId, [
            '{{DETAILS}}'     => "New travel request {$reqNo} for {$this->request->getPost('purpose')}",
            '{{ACTION_DATE}}' => date('F j, Y', strtotime($this->request->getPost('start_date'))),
        ], ['in_app']);

        $this->logAudit('TRAVEL_APPLY', 'travel', "Submitted travel request {$reqNo}", $newId);
        $this->session->setFlashdata('success', "Travel request {$reqNo} submitted successfully.");
        return redirect()->to(site_url('travel?tab=trips'));
    }

    /**
     * Approve Travel Request (Manager / Finance)
     */
    public function approve(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager', 'accountant', 'payroll_manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to authorize travel requests.');
            return redirect()->to(site_url('travel'));
        }

        $travelModel = new TravelRequestModel();
        $trip = $travelModel->find($id);

        if (!$trip) {
            $this->session->setFlashdata('error', 'Travel request not found.');
            return redirect()->to(site_url('travel'));
        }

        $advanceDisbursed = (float)$this->request->getPost('advance_disbursed') ?: (float)$trip['advance_required'];
        $remarks          = trim((string)$this->request->getPost('remarks') ?: 'Travel authorized.');

        $travelModel->update($id, [
            'status'            => 'approved',
            'advance_disbursed' => $advanceDisbursed,
            'manager_id'        => $this->currentUser['employee_id'] ?? 1,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $remarks,
            'finance_id'        => $this->currentUser['employee_id'] ?? 1,
            'finance_action_at' => date('Y-m-d H:i:s'),
            'finance_remarks'   => $remarks,
        ]);

        // Notify Employee
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('leave_approved', (int)$trip['employee_id'], [
            '{{DETAILS}}'     => "Your travel request {$trip['request_number']} ({$trip['source_city']} to {$trip['destination_city']}) has been approved with Advance of ₹" . number_format($advanceDisbursed, 2),
            '{{ACTION_DATE}}' => date('F j, Y'),
        ], ['in_app', 'email']);

        $this->logAudit('TRAVEL_APPROVE', 'travel', "Approved travel request #{$id} with advance {$advanceDisbursed}", $id);
        $this->session->setFlashdata('success', "Travel request {$trip['request_number']} approved.");
        return redirect()->to(site_url('travel?tab=trips'));
    }

    /**
     * Reject Travel Request
     */
    public function reject(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager', 'accountant'])) {
            $this->session->setFlashdata('error', 'Unauthorized.');
            return redirect()->to(site_url('travel'));
        }

        $travelModel = new TravelRequestModel();
        $trip = $travelModel->find($id);

        if (!$trip) {
            $this->session->setFlashdata('error', 'Travel request not found.');
            return redirect()->to(site_url('travel'));
        }

        $remarks = trim((string)$this->request->getPost('remarks') ?: 'Budget constraints / non-essential travel.');

        $travelModel->update($id, [
            'status'            => 'rejected',
            'manager_id'        => $this->currentUser['employee_id'] ?? 1,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $remarks,
        ]);

        // Notify Employee
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('leave_rejected', (int)$trip['employee_id'], [
            '{{DETAILS}}'     => "Your travel request {$trip['request_number']} was not approved: {$remarks}",
            '{{ACTION_DATE}}' => date('F j, Y'),
        ], ['in_app']);

        $this->logAudit('TRAVEL_REJECT', 'travel', "Rejected travel request #{$id}", $id);
        $this->session->setFlashdata('info', "Travel request {$trip['request_number']} rejected.");
        return redirect()->to(site_url('travel?tab=trips'));
    }

    /**
     * Submit Itemized Expense Claim
     */
    public function claim()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee linked.');
            return redirect()->to(site_url('travel?tab=claims'));
        }

        $rules = [
            'expense_category' => 'required',
            'bill_date'        => 'required|valid_date',
            'amount'           => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('travel?tab=claims'));
        }

        $rawTripId = (int)$this->request->getPost('travel_request_id');
        $travelRequestId = null;
        if ($rawTripId > 0) {
            $travelModel = new TravelRequestModel();
            if ($travelModel->find($rawTripId)) {
                $travelRequestId = $rawTripId;
            }
        }
        $claimModel = new TravelExpenseClaimModel();

        $newClaimId = $claimModel->insert([
            'travel_request_id' => $travelRequestId,
            'employee_id'       => $employeeId,
            'expense_category'  => $this->request->getPost('expense_category'),
            'bill_date'         => $this->request->getPost('bill_date'),
            'bill_number'       => $this->request->getPost('bill_number') ?: ('INV-' . strtoupper(substr(uniqid(), -6))),
            'amount'            => (float)$this->request->getPost('amount'),
            'approved_amount'   => 0.00,
            'receipt_path'      => 'receipts/rcpt_' . time() . '.pdf',
            'remarks'           => $this->request->getPost('remarks'),
            'status'            => 'submitted',
        ]);

        $this->logAudit('EXPENSE_CLAIM_APPLY', 'travel', "Submitted expense claim of ₹" . $this->request->getPost('amount'), $newClaimId);
        $this->session->setFlashdata('success', 'Expense claim submitted successfully for finance settlement.');
        return redirect()->to(site_url('travel?tab=claims'));
    }

    /**
     * Approve / Settle Expense Claim (Finance)
     */
    public function approveClaim(int $id)
    {
        if (!$this->hasRole(['super_admin', 'accountant', 'payroll_manager', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to settle expense claims.');
            return redirect()->to(site_url('travel?tab=claims'));
        }

        $claimModel = new TravelExpenseClaimModel();
        $claim = $claimModel->find($id);

        if (!$claim) {
            $this->session->setFlashdata('error', 'Expense claim record not found.');
            return redirect()->to(site_url('travel?tab=claims'));
        }

        $approvedAmount = (float)($this->request->getPost('approved_amount') ?: $claim['amount']);
        $status         = $this->request->getPost('status') ?: 'approved';

        $claimModel->update($id, [
            'approved_amount' => $approvedAmount,
            'status'          => $status,
            'remarks'         => $this->request->getPost('remarks') ?: 'Cleared for payment/reimbursement.',
        ]);

        // Notify Employee
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('payroll_generated', (int)$claim['employee_id'], [
            '{{DETAILS}}'     => "Your travel expense claim #{$id} ({$claim['expense_category']}) has been approved for ₹" . number_format($approvedAmount, 2),
            '{{ACTION_DATE}}' => date('F j, Y'),
        ], ['in_app']);

        $this->logAudit('EXPENSE_CLAIM_APPROVE', 'travel', "Approved expense claim #{$id} for ₹{$approvedAmount}", $id);
        $this->session->setFlashdata('success', "Expense claim settled for ₹" . number_format($approvedAmount, 2));
        return redirect()->to(site_url('travel?tab=claims'));
    }
}
