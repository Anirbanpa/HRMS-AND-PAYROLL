<?php

namespace App\Controllers;

use App\Models\EmployeeLoanModel;
use App\Models\LoanRepaymentScheduleModel;
use App\Models\EmployeeModel;

/**
 * Class LoanController
 *
 * Module 23: Salary Advance & Loan Management
 */
class LoanController extends BaseController
{
    /**
     * Loans & Salary Advance Portfolio Dashboard
     */
    public function index()
    {
        $loanModel = new EmployeeLoanModel();
        $isFinance = $this->hasRole(['super_admin', 'accountant', 'payroll_manager', 'hr_admin']);
        $currentEmpId = $this->currentUser['employee_id'] ?? null;

        $filters = [];
        if (!$isFinance && $currentEmpId) {
            $filters['employee_id'] = $currentEmpId;
        }

        $loans = $loanModel->getDetailedLoans($filters);

        // Compute metrics
        $totalDisbursed = 0.0;
        $totalOutstanding = 0.0;
        $activeLoansCount = 0;

        foreach ($loans as $l) {
            if (in_array($l['status'], ['active', 'disbursed'])) {
                $activeLoansCount++;
                $totalOutstanding += (float)$l['outstanding_balance'];
            }
            if ($l['status'] !== 'rejected') {
                $totalDisbursed += (float)$l['principal_amount'];
            }
        }

        $data = [
            'loans'            => $loans,
            'totalDisbursed'   => $totalDisbursed,
            'totalOutstanding' => $totalOutstanding,
            'activeLoansCount' => $activeLoansCount,
            'isFinance'        => $isFinance,
        ];

        return $this->render('loans/index', $data, 'Salary Advance & Employee Loans');
    }

    /**
     * Submit Loan / Advance Request
     */
    public function apply()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee profile linked.');
            return redirect()->to(site_url('loans'));
        }

        $rules = [
            'loan_type'        => 'required|in_list[salary_advance,personal_loan,emergency_advance,education_loan]',
            'principal_amount' => 'required|numeric|greater_than[0]',
            'tenure_months'    => 'required|is_natural_no_zero',
            'reason'           => 'required|min_length[5]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('loans'));
        }

        $principal = (float)$this->request->getPost('principal_amount');
        $tenure    = (int)$this->request->getPost('tenure_months');
        $interest  = (float)($this->request->getPost('interest_rate_percent') ?: 0.00);

        $totalRepayable = round($principal + ($principal * ($interest / 100)), 2);
        $monthlyEmi     = round($totalRepayable / $tenure, 2);

        $loanAppNo = 'LN-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $loanModel = new EmployeeLoanModel();
        $loanModel->insert([
            'loan_application_no'   => $loanAppNo,
            'employee_id'           => $employeeId,
            'loan_type'             => $this->request->getPost('loan_type'),
            'principal_amount'      => $principal,
            'interest_rate_percent' => $interest,
            'total_repayable'       => $totalRepayable,
            'tenure_months'         => $tenure,
            'monthly_emi'           => $monthlyEmi,
            'outstanding_balance'   => $totalRepayable,
            'status'                => 'submitted',
            'reason'                => $this->request->getPost('reason'),
        ]);

        $this->logAudit('LOAN_APPLY', 'loans', "Submitted loan request {$loanAppNo} for ₹{$principal}");
        $this->session->setFlashdata('success', "Loan application {$loanAppNo} submitted successfully.");
        return redirect()->to(site_url('loans'));
    }

    /**
     * Approve Loan & Generate EMI Schedule
     */
    public function approve($id)
    {
        if (!$this->hasRole(['super_admin', 'accountant', 'payroll_manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to approve loan disbursements.');
            return redirect()->to(site_url('loans'));
        }

        $loanModel     = new EmployeeLoanModel();
        $scheduleModel = new LoanRepaymentScheduleModel();
        $db            = \Config\Database::connect();

        $loan = $loanModel->find((int)$id);
        if (!$loan) {
            $this->session->setFlashdata('error', 'Loan record not found.');
            return redirect()->to(site_url('loans'));
        }

        $db->transStart();

        $startMonth = (int)date('n', strtotime('+1 month'));
        $startYear  = (int)date('Y', strtotime('+1 month'));

        $loanModel->update((int)$id, [
            'status'                => 'active',
            'approved_by'           => $this->userId(),
            'approved_at'           => date('Y-m-d H:i:s'),
            'disbursement_date'     => date('Y-m-d'),
            'first_deduction_month' => $startMonth,
            'first_deduction_year'  => $startYear,
        ]);

        // Generate EMI installment breakdown rows
        $tenure   = (int)$loan['tenure_months'];
        $emi      = (float)$loan['monthly_emi'];
        $curMonth = $startMonth;
        $curYear  = $startYear;

        for ($i = 1; $i <= $tenure; $i++) {
            $scheduleModel->insert([
                'loan_id'             => $loan['id'],
                'installment_number'  => $i,
                'due_month'           => $curMonth,
                'due_year'            => $curYear,
                'emi_amount'          => $emi,
                'principal_component' => $emi,
                'interest_component'  => 0.00,
                'status'              => 'scheduled',
            ]);

            $curMonth++;
            if ($curMonth > 12) {
                $curMonth = 1;
                $curYear++;
            }
        }

        $db->transComplete();

        $this->logAudit('LOAN_APPROVE', 'loans', "Approved loan ID {$id} and generated {$tenure} EMI schedule rows.");
        $this->session->setFlashdata('success', 'Loan approved and monthly EMI schedules generated.');
        return redirect()->to(site_url('loans'));
    }
}
