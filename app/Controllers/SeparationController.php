<?php

namespace App\Controllers;

use App\Models\ResignationModel;
use App\Models\ExitClearanceModel;
use App\Models\FnfSettlementModel;
use App\Models\EmployeeModel;
use App\Models\SalaryStructureModel;
use App\Models\LeaveBalanceModel;
use CodeIgniter\HTTP\ResponseInterface;

class SeparationController extends BaseController
{
    protected ResignationModel $resigModel;
    protected ExitClearanceModel $clearanceModel;
    protected FnfSettlementModel $fnfModel;
    protected EmployeeModel $employeeModel;

    public function __construct()
    {
        $this->resigModel = new ResignationModel();
        $this->clearanceModel = new ExitClearanceModel();
        $this->fnfModel = new FnfSettlementModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function index()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'payroll_manager'])) {
            $this->session->setFlashdata('error', 'Access Denied: Separation & F&F is restricted to HR and Payroll Administration.');
            return redirect()->to(site_url('dashboard'));
        }

        // Auto-synchronize employees set to resigned or notice_period in Directory
        $separatingStaff = $this->employeeModel->whereIn('employment_status', ['resigned', 'notice_period'])
            ->where('deleted_at', null)
            ->findAll();
        foreach ($separatingStaff as $st) {
            $existing = $this->resigModel->where('employee_id', $st['id'])->first();
            if (!$existing) {
                $this->resigModel->insert([
                    'employee_id'                => $st['id'],
                    'resignation_date'           => date('Y-m-d'),
                    'requested_last_working_day' => date('Y-m-d', strtotime('+30 days')),
                    'approved_last_working_day'  => date('Y-m-d', strtotime('+30 days')),
                    'reason'                     => 'Status updated in Employee Master Directory (' . ucfirst(str_replace('_', ' ', $st['employment_status'])) . ')',
                    'status'                     => ($st['employment_status'] === 'notice_period') ? 'in_clearance' : 'submitted',
                ]);
            }
        }

        $resignations = $this->resigModel->getResignationsWithEmployee();
        $employees = $this->employeeModel->where('deleted_at', null)
            ->whereNotIn('employment_status', ['terminated', 'resigned', 'retired'])
            ->orderBy('first_name', 'ASC')
            ->findAll();

        // Attach clearances to each resignation
        foreach ($resignations as &$r) {
            $r['clearances'] = $this->clearanceModel->getClearancesByResignation($r['id']);
        }

        // Calculate KPIs
        $totalSeparations = count($resignations);
        $inClearance = count(array_filter($resignations, fn($r) => in_array($r['status'], ['submitted', 'in_clearance', 'manager_approved'])));
        $settledCount = count(array_filter($resignations, fn($r) => $r['status'] === 'settled'));
        $totalPayout = array_sum(array_column($resignations, 'net_payable_amount'));

        $data = [
            'pageTitle'        => 'Separation, Exit Clearance & F&F Settlement',
            'resignations'     => $resignations,
            'employees'        => $employees,
            'totalSeparations' => $totalSeparations,
            'inClearance'      => $inClearance,
            'settledCount'     => $settledCount,
            'totalPayout'      => $totalPayout,
        ];

        return $this->render('separation/index', $data);
    }

    /**
     * Submit Resignation
     */
    public function submit(): ResponseInterface
    {
        $employeeId = (int)$this->request->getPost('employee_id');
        $resigDate = $this->request->getPost('resignation_date') ?: date('Y-m-d');
        $reqLwd = $this->request->getPost('requested_last_working_day');
        $reason = trim($this->request->getPost('reason') ?? '');

        if (empty($employeeId) || empty($reqLwd) || empty($reason)) {
            return redirect()->back()->with('error', 'Employee, requested last working day, and reason are required.');
        }

        // Verify active employee
        $employee = $this->employeeModel->find($employeeId);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        $resigId = $this->resigModel->insert([
            'employee_id'                => $employeeId,
            'resignation_date'           => $resigDate,
            'requested_last_working_day' => $reqLwd,
            'approved_last_working_day'  => $reqLwd,
            'reason'                     => $reason,
            'status'                     => 'submitted',
        ]);

        $this->logAudit('SUBMIT_RESIGNATION', 'resignations', "Submitted resignation notice for {$employee['employee_code']} ({$employee['first_name']} {$employee['last_name']})", (int)$resigId);

        return redirect()->to(site_url('separation'))->with('success', "Separation notice submitted for {$employee['first_name']} {$employee['last_name']}.");
    }

    /**
     * Approve Resignation & Trigger Multi-Dept Clearances
     */
    public function approve(int $id): ResponseInterface
    {
        $resignation = $this->resigModel->find($id);
        if (!$resignation) {
            return redirect()->back()->with('error', 'Resignation record not found.');
        }

        $apprLwd = $this->request->getPost('approved_last_working_day') ?: $resignation['requested_last_working_day'];
        $remarks = trim($this->request->getPost('approver_remarks') ?? 'Resignation accepted. Notice period active.');

        $this->resigModel->update($id, [
            'approved_last_working_day' => $apprLwd,
            'approver_remarks'          => $remarks,
            'status'                    => 'in_clearance',
        ]);

        // Sync employee master status to notice_period
        $this->employeeModel->update($resignation['employee_id'], [
            'employment_status' => 'notice_period',
        ]);

        // Auto-provision 4 Departmental Clearances if not already present
        $existingClearances = $this->clearanceModel->where('resignation_id', $id)->findAll();
        if (empty($existingClearances)) {
            $depts = [
                ['dept' => 'IT', 'remarks' => 'Laptop, monitors, peripherals, and SSO credentials revocation'],
                ['dept' => 'Finance', 'remarks' => 'Travel advance reconciliation and corporate credit card clearance'],
                ['dept' => 'HR', 'remarks' => 'Exit interview completion, non-disclosure agreement, ID badge return'],
                ['dept' => 'Admin', 'remarks' => 'Desk clearance, parking tags, and facility access card deactivation'],
            ];

            foreach ($depts as $d) {
                $this->clearanceModel->insert([
                    'resignation_id'  => $id,
                    'department_type' => $d['dept'],
                    'status'          => 'pending',
                    'remarks'         => $d['remarks'],
                ]);
            }
        }

        $this->logAudit('APPROVE_RESIGNATION', 'resignations', "Approved resignation for case #{$id} with LWD {$apprLwd}", $id);

        return redirect()->to(site_url('separation'))->with('success', "Resignation approved. Departmental exit clearances initiated.");
    }

    /**
     * Update Department Clearance Status
     */
    public function updateClearance(int $clearanceId): ResponseInterface
    {
        $clearance = $this->clearanceModel->find($clearanceId);
        if (!$clearance) {
            return redirect()->back()->with('error', 'Clearance item not found.');
        }

        $status = $this->request->getPost('status') ?: 'cleared';
        $remarks = trim($this->request->getPost('remarks') ?? '');
        $dues = (float)$this->request->getPost('dues_or_recoveries');

        $this->clearanceModel->update($clearanceId, [
            'status'             => $status,
            'cleared_by_user_id' => $this->userId(),
            'cleared_at'         => date('Y-m-d H:i:s'),
            'remarks'            => $remarks,
            'dues_or_recoveries' => $dues,
        ]);

        $this->logAudit('UPDATE_EXIT_CLEARANCE', 'exit_clearances', "Updated {$clearance['department_type']} clearance to {$status} (Dues: ₹{$dues})", $clearanceId);

        return redirect()->to(site_url('separation'))->with('success', "Department clearance ({$clearance['department_type']}) marked as {$status}.");
    }

    /**
     * Calculate & Generate Full & Final (F&F) Settlement
     */
    public function calculateFnF(int $resignationId): ResponseInterface
    {
        $resignation = $this->resigModel->find($resignationId);
        if (!$resignation) {
            return redirect()->back()->with('error', 'Resignation not found.');
        }

        $empId = $resignation['employee_id'];
        $employee = $this->employeeModel->find($empId);

        // Fetch Employee Salary Structure
        $salModel = new SalaryStructureModel();
        $salary = $salModel->where('employee_id', $empId)->orderBy('effective_date', 'DESC')->first();

        $grossSalary = $salary ? (float)$salary['gross_salary'] : 5000.00;
        $basicSalary = $salary ? (float)$salary['basic_salary'] : 2500.00;
        $dailyGross = $grossSalary / 30.0;
        $dailyBasic = $basicSalary / 30.0;

        // 1. Unpaid Salary calculation (e.g. 15 days in final month)
        $unpaidDays = (int)($this->request->getPost('unpaid_salary_days') ?? 15);
        $unpaidAmount = round($dailyGross * $unpaidDays, 2);

        // 2. Leave Encashment
        $leaveBalanceModel = new LeaveBalanceModel();
        $leaveBalances = $leaveBalanceModel->where('employee_id', $empId)->where('year', (int)date('Y'))->findAll();
        $remainingPaidLeaves = 0;
        foreach ($leaveBalances as $lb) {
            $remainingPaidLeaves += max(0, (float)$lb['allocated_days'] - (float)$lb['used_days']);
        }
        $leaveEncashDays = min(30, (int)$remainingPaidLeaves);
        $leaveEncashAmount = round($dailyBasic * $leaveEncashDays, 2);

        // 3. Gratuity Calculation (If tenure >= 5 years)
        $tenureYears = 0.0;
        if (!empty($employee['joining_date'])) {
            $joinDate = new \DateTime($employee['joining_date']);
            $exitDate = new \DateTime($resignation['approved_last_working_day'] ?? date('Y-m-d'));
            $diff = $joinDate->diff($exitDate);
            $tenureYears = $diff->y + ($diff->m / 12.0);
        }
        $gratuityAmount = 0.00;
        if ($tenureYears >= 5.0) {
            $gratuityAmount = round((15 * $basicSalary * $tenureYears) / 26.0, 2);
        }

        $bonusAmount = (float)($this->request->getPost('bonus_amount') ?? 0.00);
        $totalEarnings = $unpaidAmount + $leaveEncashAmount + $gratuityAmount + $bonusAmount;

        // 4. Recoveries & Deductions
        $noticeRecovery = (float)($this->request->getPost('notice_shortfall_recovery') ?? 0.00);
        
        // Sum any dues flagged in clearances
        $clearances = $this->clearanceModel->where('resignation_id', $resignationId)->findAll();
        $assetDues = (float)array_sum(array_column($clearances, 'dues_or_recoveries'));

        $taxDeduction = round($totalEarnings * 0.10, 2); // 10% standard withholding
        $totalDeductions = $noticeRecovery + $assetDues + $taxDeduction;

        $netPayable = max(0.00, $totalEarnings - $totalDeductions);

        // Check if settlement already exists
        $existingFnf = $this->fnfModel->where('resignation_id', $resignationId)->first();
        $fnfData = [
            'resignation_id'            => $resignationId,
            'employee_id'               => $empId,
            'settlement_date'           => date('Y-m-d'),
            'unpaid_salary_days'        => $unpaidDays,
            'unpaid_salary_amount'      => $unpaidAmount,
            'leave_encashment_days'     => $leaveEncashDays,
            'leave_encashment_amount'   => $leaveEncashAmount,
            'gratuity_amount'           => $gratuityAmount,
            'bonus_amount'              => $bonusAmount,
            'total_earnings'            => $totalEarnings,
            'notice_shortfall_recovery' => $noticeRecovery,
            'asset_damage_deduction'    => $assetDues,
            'statutory_tax_deduction'   => $taxDeduction,
            'total_deductions'          => $totalDeductions,
            'net_payable_amount'        => $netPayable,
            'settlement_status'         => 'calculated',
            'approved_by'               => $this->userId(),
        ];

        if ($existingFnf) {
            $this->fnfModel->update($existingFnf['id'], $fnfData);
            $fnfId = $existingFnf['id'];
        } else {
            $fnfId = $this->fnfModel->insert($fnfData);
        }

        // Update resignation status to settled
        $this->resigModel->update($resignationId, ['status' => 'settled']);

        // Update employee status to terminated/resigned
        $this->employeeModel->update($empId, ['employment_status' => 'terminated']);

        $this->logAudit('CALCULATE_FNF', 'fnf_settlements', "Computed F&F settlement for {$employee['employee_code']}: Net ₹{$netPayable}", (int)$fnfId);

        return redirect()->to(site_url('separation/fnf/view/' . $fnfId))
                         ->with('success', "Full & Final Settlement computed successfully for {$employee['first_name']} {$employee['last_name']}. Net Payout: ₹" . number_format($netPayable, 2));
    }

    /**
     * View Formal Print-Ready FnF Statement
     */
    public function viewFnF(int $settlementId): string
    {
        $settlement = $this->fnfModel->getSettlementFull($settlementId);
        if (!$settlement) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Settlement #{$settlementId} not found.");
        }

        $data = [
            'pageTitle'  => 'Full & Final Settlement Statement #' . $settlement['id'],
            'settlement' => $settlement,
        ];

        return $this->render('separation/fnf_view', $data);
    }
}
