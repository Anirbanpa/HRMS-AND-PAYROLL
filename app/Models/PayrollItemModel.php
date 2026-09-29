<?php

namespace App\Models;

class PayrollItemModel extends BaseModel
{
    protected $table         = 'payroll_items';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'payroll_run_id',
        'employee_id',
        'payslip_number',
        'present_days',
        'unpaid_leave_days',
        'overtime_hours',
        'basic_salary',
        'hra',
        'conveyance',
        'special_allowance',
        'medical_allowance',
        'overtime_amount',
        'bonus_incentive',
        'reimbursement_amount',
        'gross_salary',
        'pf_deduction',
        'tax_deduction',
        'insurance_deduction',
        'loan_emi_deduction',
        'unpaid_cut',
        'total_deductions',
        'net_salary',
        'payment_status',
        'payment_date',
    ];

    /**
     * Get detailed payslip with employee profile and banking details
     */
    public function getDetailedPayslip(int $itemId): ?array
    {
        $payslip = $this->select('payroll_items.*, 
            emp.employee_code, emp.first_name, emp.last_name, emp.email, emp.phone, emp.joining_date,
            dept.name as department_name, desig.name as designation_name,
            br.name as branch_name, br.city as branch_city, br.country as branch_country,
            pr.month, pr.year, pr.title as run_title, pr.status as run_status')
            ->join('employees emp', 'emp.id = payroll_items.employee_id')
            ->join('departments dept', 'dept.id = emp.department_id', 'left')
            ->join('designations desig', 'desig.id = emp.designation_id', 'left')
            ->join('branches br', 'br.id = emp.branch_id', 'left')
            ->join('payroll_runs pr', 'pr.id = payroll_items.payroll_run_id')
            ->where('payroll_items.id', $itemId)
            ->first();

        if (!$payslip) {
            return null;
        }

        $db = \Config\Database::connect();
        $payslip['company'] = $db->table('companies')->where('id', 1)->get()->getFirstRow('array');
        $payslip['bank']    = $db->table('employee_bank_details')
            ->where('employee_id', $payslip['employee_id'])
            ->where('is_primary', 1)
            ->get()
            ->getFirstRow('array');

        return $payslip;
    }

    /**
     * Get all payroll items for a run with employee profiles and bank details
     */
    public function getItemsWithEmployee(int $payrollRunId): array
    {
        return $this->select('payroll_items.*, 
            emp.employee_code, emp.first_name, emp.last_name, emp.email,
            bank.bank_name, bank.account_number, bank.ifsc_swift_code')
            ->join('employees emp', 'emp.id = payroll_items.employee_id')
            ->join('employee_bank_details bank', 'bank.employee_id = emp.id AND bank.is_primary = 1', 'left')
            ->where('payroll_items.payroll_run_id', $payrollRunId)
            ->findAll();
    }
}
