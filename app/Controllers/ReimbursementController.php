<?php

namespace App\Controllers;

use App\Models\ReimbursementRequestModel;
use App\Models\ExpenseCategoryModel;
use App\Models\EmployeeModel;

/**
 * Class ReimbursementController
 *
 * Module 24: Expense Reimbursements & Claims Workflow
 */
class ReimbursementController extends BaseController
{
    /**
     * Reimbursements Dashboard & Portfolio
     */
    public function index()
    {
        $reimbModel = new ReimbursementRequestModel();
        $catModel   = new ExpenseCategoryModel();

        $categories = $catModel->where('status', 'active')->findAll();
        $isFinance  = $this->hasRole(['super_admin', 'accountant', 'payroll_manager', 'hr_admin']);
        $currentEmp = $this->currentUser['employee_id'] ?? null;

        $filters = [];
        if (!$isFinance && $currentEmp) {
            $filters['employee_id'] = $currentEmp;
        }

        $status = $this->request->getGet('status');
        if ($status) {
            $filters['status'] = $status;
        }

        $claims = $reimbModel->getDetailedClaims($filters);

        $totalClaimed = 0.0;
        $totalPaid    = 0.0;
        $pendingCount = 0;

        foreach ($claims as $c) {
            $totalClaimed += (float)$c['amount'];
            if (in_array($c['status'], ['finance_approved', 'payroll_processed', 'paid'])) {
                $totalPaid += (float)$c['approved_amount'];
            }
            if (in_array($c['status'], ['submitted', 'manager_approved'])) {
                $pendingCount++;
            }
        }

        $data = [
            'claims'       => $claims,
            'categories'   => $categories,
            'totalClaimed' => $totalClaimed,
            'totalPaid'    => $totalPaid,
            'pendingCount' => $pendingCount,
            'isFinance'    => $isFinance,
            'filters'      => $filters,
        ];

        return $this->render('reimbursements/index', $data, 'Expense Reimbursements & Claims');
    }

    /**
     * Submit Reimbursement Claim with Receipt Upload
     */
    public function apply()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee profile linked.');
            return redirect()->to(site_url('reimbursements'));
        }

        $rules = [
            'expense_category_id' => 'required|numeric',
            'claim_title'         => 'required|min_length[3]|max_length[150]',
            'expense_date'        => 'required|valid_date',
            'amount'              => 'required|numeric|greater_than[0]',
            'description'         => 'required|min_length[5]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('reimbursements'));
        }

        // Handle file upload
        $receiptPath = null;
        $file = $this->request->getFile('receipt');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadDir = FCPATH . 'uploads/receipts';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $file->move($uploadDir, $newName);
            $receiptPath = 'uploads/receipts/' . $newName;
        }

        $claimNo = 'CLM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $reimbModel = new ReimbursementRequestModel();

        $reimbModel->insert([
            'claim_number'        => $claimNo,
            'employee_id'         => $employeeId,
            'expense_category_id' => (int)$this->request->getPost('expense_category_id'),
            'claim_title'         => $this->request->getPost('claim_title'),
            'expense_date'        => $this->request->getPost('expense_date'),
            'amount'              => (float)$this->request->getPost('amount'),
            'approved_amount'     => (float)$this->request->getPost('amount'),
            'description'         => $this->request->getPost('description'),
            'receipt_path'        => $receiptPath,
            'status'              => 'submitted',
        ]);

        $this->logAudit('REIMBURSEMENT_SUBMIT', 'reimbursements', "Submitted claim {$claimNo} for ₹{$this->request->getPost('amount')}");
        $this->session->setFlashdata('success', "Expense claim {$claimNo} submitted successfully.");
        return redirect()->to(site_url('reimbursements'));
    }

    /**
     * Approve Claim (Manager or Finance Stage)
     */
    public function approve($id)
    {
        $reimbModel = new ReimbursementRequestModel();
        $claim = $reimbModel->find((int)$id);
        if (!$claim) {
            $this->session->setFlashdata('error', 'Claim not found.');
            return redirect()->to(site_url('reimbursements'));
        }

        $approvedAmount = $this->request->getPost('approved_amount') ? (float)$this->request->getPost('approved_amount') : (float)$claim['amount'];

        if ($this->hasRole(['super_admin', 'accountant', 'payroll_manager'])) {
            // Finance Approval (Final)
            $reimbModel->update((int)$id, [
                'status'              => 'finance_approved',
                'approved_amount'     => $approvedAmount,
                'finance_approver_id' => $this->userId(),
                'finance_action_at'   => date('Y-m-d H:i:s'),
                'finance_remarks'     => $this->request->getPost('remarks') ?: 'Finance Verified',
            ]);
            $this->logAudit('REIMBURSEMENT_FINANCE_APPROVE', 'reimbursements', "Finance approved claim ID {$id} for ₹{$approvedAmount}");
            $this->session->setFlashdata('success', "Claim approved by Finance for ₹{$approvedAmount}. Queued for payroll.");
        } else {
            // Manager Approval (Stage 1)
            $reimbModel->update((int)$id, [
                'status'            => 'manager_approved',
                'approved_amount'   => $approvedAmount,
                'manager_id'        => $this->currentUser['employee_id'] ?? null,
                'manager_action_at' => date('Y-m-d H:i:s'),
                'manager_remarks'   => $this->request->getPost('remarks') ?: 'Manager Endorsed',
            ]);
            $this->logAudit('REIMBURSEMENT_MANAGER_APPROVE', 'reimbursements', "Manager approved claim ID {$id}");
            $this->session->setFlashdata('success', 'Claim approved by Manager. Forwarded to Finance.');
        }

        return redirect()->to(site_url('reimbursements'));
    }

    /**
     * Reject Claim (Manager or Finance Stage)
     */
    public function reject($id)
    {
        $reimbModel = new ReimbursementRequestModel();
        $claim = $reimbModel->find((int)$id);
        if (!$claim) {
            $this->session->setFlashdata('error', 'Claim not found.');
            return redirect()->to(site_url('reimbursements'));
        }

        $reimbModel->update((int)$id, [
            'status'            => 'rejected',
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => date('Y-m-d H:i:s'),
            'manager_remarks'   => $this->request->getPost('remarks') ?: 'Claim rejected',
        ]);

        $this->logAudit('REIMBURSEMENT_REJECT', 'reimbursements', "Rejected claim ID {$id}");
        $this->session->setFlashdata('warning', 'Expense claim marked as rejected.');
        return redirect()->to(site_url('reimbursements'));
    }
}

