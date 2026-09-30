<?php

namespace App\Controllers;

use App\Models\PayrollRunModel;
use App\Models\PayrollItemModel;
use App\Models\EmployeeModel;

class PayrollController extends BaseController
{
    /**
     * Payroll Dashboard & Runs Management (Module 18 & 22)
     */
    public function index()
    {
        if (!$this->hasPermission('payroll.view')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to view payroll records.');
            return redirect()->to(site_url('dashboard'));
        }

        $runModel = new PayrollRunModel();
        $db = \Config\Database::connect();

        $runs = $runModel->orderBy('year', 'DESC')
            ->orderBy('month', 'DESC')
            ->findAll();

        $totalDisbursed = 0;
        $totalRunsCount = count($runs);
        foreach ($runs as $r) {
            $totalDisbursed += (float)$r['total_net'];
        }

        // Active salary structures count (only for active, non-deleted employees)
        $activeStructuresCount = $db->table('salary_structures ss')
            ->join('employees e', 'e.id = ss.employee_id')
            ->where('e.deleted_at', null)
            ->whereIn('e.employment_status', ['active', 'probation', 'notice_period'])
            ->countAllResults();

        $data = [
            'runs'                  => $runs,
            'totalDisbursed'        => $totalDisbursed,
            'totalRunsCount'        => $totalRunsCount,
            'activeStructuresCount' => $activeStructuresCount,
            'currentMonth'          => (int)date('n'),
            'currentYear'           => (int)date('Y'),
        ];

        return $this->render('payroll/index', $data, 'Monthly Payroll Engine & Disbursements');
    }

    /**
     * Execute Monthly Payroll Processing Calculation Engine (Module 18, 19, 20)
     */
    public function process()
    {
        if (!$this->hasPermission('payroll.process')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to execute monthly payroll runs.');
            return redirect()->to(site_url('payroll'));
        }

        $month = (int)$this->request->getPost('month');
        $year  = (int)$this->request->getPost('year');

        if ($month < 1 || $month > 12 || $year < 2020) {
            $this->session->setFlashdata('error', 'Valid month and year must be selected.');
            return redirect()->to(site_url('payroll'));
        }

        $db = \Config\Database::connect();
        $runModel = new PayrollRunModel();
        $itemModel = new PayrollItemModel();

        // Check if run already exists
        $existing = $runModel->where('month', $month)->where('year', $year)->first();
        if ($existing && $existing['status'] === 'frozen') {
            $this->session->setFlashdata('error', "Payroll run for {$month}/{$year} is locked and frozen. Modification prohibited.");
            return redirect()->to(site_url('payroll'));
        }

        $monthName = date('F', mktime(0, 0, 0, $month, 10));
        $title = "Payroll Run - {$monthName} {$year}";

        $db->transStart();

        // Create or update run record
        if (!$existing) {
            $runId = $runModel->insert([
                'company_id'        => 1,
                'financial_year_id' => 1,
                'month'             => $month,
                'year'              => $year,
                'title'             => $title,
                'status'            => 'processed',
                'processed_by'      => $this->userId(),
                'processed_at'      => date('Y-m-d H:i:s'),
            ]);
        } else {
            $runId = $existing['id'];
            // Remove previous draft items
            $itemModel->where('payroll_run_id', $runId)->delete();
        }

        // Fetch all eligible employees (active, probation, notice period)
        $empModel = new EmployeeModel();
        $employees = $empModel->whereIn('employment_status', ['active', 'probation', 'notice_period'])
            ->where('deleted_at', null)
            ->findAll();

        $totalEmployees = 0;
        $totalGross = 0.0;
        $totalDeductions = 0.0;
        $totalNet = 0.0;

        foreach ($employees as $emp) {
            // Get configured salary structure or fallback default
            $salary = $db->table('salary_structures')
                ->where('employee_id', $emp['id'])
                ->orderBy('effective_date', 'DESC')
                ->get()
                ->getFirstRow('array');

            $basic = $salary ? (float)$salary['basic_salary'] : 5000.00;
            $hra   = $salary ? (float)$salary['hra'] : 2000.00;
            $conv  = $salary ? (float)$salary['conveyance_allowance'] : 500.00;
            $spec  = $salary ? (float)$salary['special_allowance'] : 1000.00;
            $med   = $salary ? (float)$salary['medical_allowance'] : 300.00;
            $pf    = $salary ? (float)$salary['pf_deduction'] : round($basic * 0.12, 2);
            $tax   = $salary ? (float)$salary['tax_deduction'] : round($basic * 0.10, 2);
            $ins   = $salary ? (float)($salary['insurance_deduction'] ?? 120.00) : 120.00;

            // 1. Module 15: Overtime hours & amount integration
            $otHours  = 0.0;
            $otAmount = 0.0;
            $otRows = $db->table('overtime_requests')
                ->where('employee_id', $emp['id'])
                ->whereIn('status', ['manager_approved', 'hr_approved'])
                ->where('payroll_run_id', null)
                ->get()
                ->getResultArray();

            foreach ($otRows as $ot) {
                $otHours  += (float)$ot['total_hours'];
                $otAmount += (float)$ot['payout_amount'];
            }

            // 2. Module 25: Bonus, Incentive & Commission Integration
            $bonusAmount = 0.0;
            $incRows = $db->table('employee_incentive_entries')
                ->where('employee_id', $emp['id'])
                ->whereIn('status', ['manager_approved', 'hr_approved'])
                ->where('payroll_run_id', null)
                ->get()
                ->getResultArray();

            foreach ($incRows as $inc) {
                $bonusAmount += (float)$inc['final_amount'];
            }

            // 3. Module 24: Expense Reimbursement Integration
            $reimbAmount = 0.0;
            $reimbRows = $db->table('reimbursement_requests')
                ->where('employee_id', $emp['id'])
                ->where('status', 'finance_approved')
                ->where('payroll_run_id', null)
                ->get()
                ->getResultArray();

            foreach ($reimbRows as $reimb) {
                $reimbAmount += (float)$reimb['approved_amount'];
            }

            // 4. Module 23: Salary Advance & Loan Monthly EMI Deductions
            $loanEmiDeduction = 0.0;
            $emiRows = $db->table('loan_repayment_schedules')
                ->select('loan_repayment_schedules.*, employee_loans.id as loan_id, employee_loans.outstanding_balance, employee_loans.total_paid')
                ->join('employee_loans', 'employee_loans.id = loan_repayment_schedules.loan_id')
                ->where('employee_loans.employee_id', $emp['id'])
                ->where('loan_repayment_schedules.due_month', $month)
                ->where('loan_repayment_schedules.due_year', $year)
                ->where('loan_repayment_schedules.status', 'scheduled')
                ->get()
                ->getResultArray();

            foreach ($emiRows as $emi) {
                $loanEmiDeduction += (float)$emi['emi_amount'];
            }

            // Compute Earnings & Deductions
            $gross = $basic + $hra + $conv + $spec + $med + $otAmount + $bonusAmount;
            $deductions = $pf + $tax + $ins + $loanEmiDeduction;
            $net = ($gross - $deductions) + $reimbAmount; // Reimbursements are non-taxable net additions

            $monthPad = str_pad((string)$month, 2, '0', STR_PAD_LEFT);
            $payslipNum = "PAY-{$year}{$monthPad}-" . $emp['employee_code'];

            $itemModel->insert([
                'payroll_run_id'       => $runId,
                'employee_id'          => $emp['id'],
                'payslip_number'       => $payslipNum,
                'present_days'         => 22.0,
                'unpaid_leave_days'    => 0.0,
                'overtime_hours'       => $otHours,
                'basic_salary'         => $basic,
                'hra'                  => $hra,
                'conveyance'           => $conv,
                'special_allowance'    => $spec,
                'medical_allowance'    => $med,
                'overtime_amount'      => $otAmount,
                'bonus_incentive'      => $bonusAmount,
                'reimbursement_amount' => $reimbAmount,
                'gross_salary'         => $gross,
                'pf_deduction'         => $pf,
                'tax_deduction'        => $tax,
                'insurance_deduction'  => $ins,
                'loan_emi_deduction'   => $loanEmiDeduction,
                'unpaid_cut'           => 0.00,
                'total_deductions'     => $deductions,
                'net_salary'           => $net,
                'payment_status'       => 'paid',
                'payment_date'         => date('Y-m-d'),
            ]);

            // Mark sub-ledgers as processed by this payroll run
            if (!empty($otRows)) {
                $otIds = array_column($otRows, 'id');
                $db->table('overtime_requests')->whereIn('id', $otIds)->update([
                    'status'         => 'payroll_processed',
                    'payroll_run_id' => $runId,
                ]);
            }

            if (!empty($incRows)) {
                $incIds = array_column($incRows, 'id');
                $db->table('employee_incentive_entries')->whereIn('id', $incIds)->update([
                    'status'         => 'payroll_batched',
                    'payroll_run_id' => $runId,
                ]);
            }

            if (!empty($reimbRows)) {
                $reimbIds = array_column($reimbRows, 'id');
                $db->table('reimbursement_requests')->whereIn('id', $reimbIds)->update([
                    'status'         => 'payroll_processed',
                    'payroll_run_id' => $runId,
                    'paid_date'      => date('Y-m-d'),
                ]);
            }

            if (!empty($emiRows)) {
                foreach ($emiRows as $emi) {
                    $db->table('loan_repayment_schedules')->where('id', $emi['id'])->update([
                        'status'         => 'deducted',
                        'paid_amount'    => $emi['emi_amount'],
                        'paid_date'      => date('Y-m-d'),
                        'payroll_run_id' => $runId,
                    ]);

                    $newPaid = (float)$emi['total_paid'] + (float)$emi['emi_amount'];
                    $newBalance = max(0.0, (float)$emi['outstanding_balance'] - (float)$emi['emi_amount']);
                    $loanStatus = ($newBalance <= 0.0) ? 'repaid' : 'active';

                    $db->table('employee_loans')->where('id', $emi['loan_id'])->update([
                        'total_paid'          => $newPaid,
                        'outstanding_balance' => $newBalance,
                        'status'              => $loanStatus,
                    ]);
                }
            }

            $totalEmployees++;
            $totalGross += $gross;
            $totalDeductions += $deductions;
            $totalNet += $net;
        }

        // Update run totals
        $runModel->update($runId, [
            'total_employees'  => $totalEmployees,
            'total_gross'      => $totalGross,
            'total_deductions' => $totalDeductions,
            'total_net'        => $totalNet,
            'status'           => 'processed',
        ]);

        $db->transComplete();

        // Dispatch payroll_ready notification to all processed employees
        $notifService = new \App\Libraries\NotificationService();
        foreach ($employees as $emp) {
            $notifService->send('payroll_ready', (int)$emp['id'], [
                '{{DETAILS}}'     => "{$monthName} {$year}",
                '{{ACTION_DATE}}' => date('F j, Y'),
            ], ['in_app', 'email']);
        }

        $this->logAudit('PROCESS_PAYROLL', 'payroll', "Generated payroll cycle for {$monthName} {$year} ({$totalEmployees} payslips, Net: ₹{$totalNet}).", $runId);
        $this->session->setFlashdata('success', "Payroll for {$monthName} {$year} processed successfully! Generated {$totalEmployees} employee payslips with total net disbursement of ₹" . number_format($totalNet, 2));

        return redirect()->to(site_url('payroll/view/' . $runId));
    }

    /**
     * View payroll run details and employee payouts breakdown
     */
    public function view(int $runId)
    {
        if (!$this->hasPermission('payroll.view')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to view payroll runs.');
            return redirect()->to(site_url('dashboard'));
        }

        $runModel  = new PayrollRunModel();
        $itemModel = new PayrollItemModel();

        $run = $runModel->find($runId);
        if (!$run) {
            $this->session->setFlashdata('error', 'Payroll run not found.');
            return redirect()->to(site_url('payroll'));
        }

        $items = $itemModel->select('payroll_items.*, emp.employee_code, emp.first_name, emp.last_name, dept.name as department_name')
            ->join('employees emp', 'emp.id = payroll_items.employee_id')
            ->join('departments dept', 'dept.id = emp.department_id', 'left')
            ->where('payroll_items.payroll_run_id', $runId)
            ->findAll();

        $data = [
            'run'   => $run,
            'items' => $items,
        ];

        return $this->render('payroll/view', $data, "Payroll Breakdown: {$run['title']}");
    }

    /**
     * Display Print-Ready, Pixel-Perfect HTML/PDF Payslip (Module 21)
     */
    public function payslip(int $itemId)
    {
        $itemModel = new PayrollItemModel();
        $payslip = $itemModel->getDetailedPayslip($itemId);

        if (!$payslip) {
            $this->session->setFlashdata('error', 'Payslip not found.');
            return redirect()->to(site_url('payroll'));
        }

        // Allow if has payroll.view or is own payslip
        $isOwn = !empty($this->currentUser['employee_id']) && ((int)$payslip['employee_id'] === (int)$this->currentUser['employee_id']);
        if (!$this->hasPermission('payroll.view') && !$isOwn) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to view this payslip.');
            return redirect()->to(site_url('dashboard'));
        }

        $data = [
            'payslip' => $payslip,
        ];

        return view('payroll/payslip', $data);
    }

    /**
     * Update an existing Payroll Run (Module 18)
     */
    public function update(int $id)
    {
        if (!$this->hasPermission('payroll.process')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to modify payroll cycles.');
            return redirect()->to(site_url('payroll'));
        }

        $runModel = new PayrollRunModel();
        $run = $runModel->find($id);
        if (!$run) {
            $this->session->setFlashdata('error', 'Payroll cycle not found.');
            return redirect()->to(site_url('payroll'));
        }

        $title  = trim((string)$this->request->getPost('title'));
        $status = trim((string)$this->request->getPost('status'));
        $month  = (int)$this->request->getPost('month');
        $year   = (int)$this->request->getPost('year');

        if (empty($title)) {
            $this->session->setFlashdata('error', 'Payroll cycle title cannot be empty.');
            return redirect()->to(site_url('payroll'));
        }

        $allowedStatuses = ['draft', 'processed', 'disbursed', 'frozen'];
        if (!in_array($status, $allowedStatuses, true)) {
            $status = $run['status'];
        }

        if ($month < 1 || $month > 12) {
            $month = (int)$run['month'];
        }

        if ($year < 2020 || $year > 2035) {
            $year = (int)$run['year'];
        }

        $updateData = [
            'title'  => $title,
            'status' => $status,
            'month'  => $month,
            'year'   => $year,
        ];

        $runModel->update($id, $updateData);

        $this->logAudit('UPDATE_PAYROLL_RUN', 'payroll', "Updated payroll cycle #{$id} ({$title}) - Status: {$status}, Month: {$month}/{$year}.", $id);
        $this->session->setFlashdata('success', "Payroll cycle \"{$title}\" has been updated successfully.");

        return redirect()->to(site_url('payroll'));
    }

    /**
     * Delete a Payroll Run and cascade removal of associated payslips (Module 18)
     */
    public function delete(int $id)
    {
        if (($this->currentUser['role_slug'] ?? '') !== 'super_admin') {
            $this->session->setFlashdata('error', 'Access Denied: Only Super Admin is authorized to delete payroll cycles.');
            return redirect()->to(site_url('payroll'));
        }

        $runModel  = new PayrollRunModel();
        $itemModel = new PayrollItemModel();
        $run = $runModel->find($id);

        if (!$run) {
            $this->session->setFlashdata('error', 'Payroll cycle not found or already deleted.');
            return redirect()->to(site_url('payroll'));
        }

        // Security check: Only super_admin can delete frozen/disbursed payroll cycles
        if (in_array($run['status'], ['frozen', 'disbursed'], true) && ($this->currentUser['role_slug'] ?? '') !== 'super_admin') {
            $this->session->setFlashdata('error', "Payroll cycle \"{$run['title']}\" is {$run['status']}. Only a Super Admin can delete it.");
            return redirect()->to(site_url('payroll'));
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Delete associated payslips
        $itemModel->where('payroll_run_id', $id)->delete();

        // 2. Unlink any references in peripheral tables if they exist
        $tables = ['overtime_claims', 'employee_loan_repayments', 'employee_reimbursements', 'employee_bonuses'];
        foreach ($tables as $tbl) {
            if ($db->tableExists($tbl)) {
                $db->table($tbl)->where('payroll_run_id', $id)->update(['payroll_run_id' => null]);
            }
        }

        // 3. Delete the run record
        $runModel->delete($id);

        $db->transComplete();

        if ($db->transStatus() === false) {
            $this->session->setFlashdata('error', 'Failed to delete payroll cycle. Database transaction failed.');
            return redirect()->to(site_url('payroll'));
        }

        $this->logAudit('DELETE_PAYROLL_RUN', 'payroll', "Deleted payroll cycle #{$id} ({$run['title']}) and associated payslips.", $id);
        $this->session->setFlashdata('success', "Payroll cycle \"{$run['title']}\" and its payslips were deleted successfully.");

        return redirect()->to(site_url('payroll'));
    }
}
