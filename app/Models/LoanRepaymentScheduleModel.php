<?php

namespace App\Models;

/**
 * Class LoanRepaymentScheduleModel
 *
 * Module 23: Monthly EMI Breakdown & Payroll Deduction Tracker
 */
class LoanRepaymentScheduleModel extends BaseModel
{
    protected $table         = 'loan_repayment_schedules';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'loan_id',
        'installment_number',
        'due_month',
        'due_year',
        'emi_amount',
        'principal_component',
        'interest_component',
        'paid_amount',
        'paid_date',
        'payroll_run_id',
        'status',
    ];

    /**
     * Get active EMI deduction due for a specific employee in a payroll run
     *
     * @param int $employeeId
     * @param int $month
     * @param int $year
     * @return array|null
     */
    public function getDueInstallment(int $employeeId, int $month, int $year): ?array
    {
        return $this->select('loan_repayment_schedules.*, el.employee_id, el.loan_application_no, el.outstanding_balance')
            ->join('employee_loans el', 'el.id = loan_repayment_schedules.loan_id')
            ->where('el.employee_id', $employeeId)
            ->where('loan_repayment_schedules.due_month', $month)
            ->where('loan_repayment_schedules.due_year', $year)
            ->where('loan_repayment_schedules.status', 'scheduled')
            ->first();
    }
}
