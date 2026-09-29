<?php

namespace App\Models;

/**
 * Class EmployeeLoanModel
 *
 * Module 23: Salary Advance & Loan Management
 */
class EmployeeLoanModel extends BaseModel
{
    protected $table         = 'employee_loans';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'loan_application_no',
        'employee_id',
        'loan_type',
        'principal_amount',
        'interest_rate_percent',
        'total_repayable',
        'tenure_months',
        'monthly_emi',
        'disbursement_date',
        'first_deduction_month',
        'first_deduction_year',
        'total_paid',
        'outstanding_balance',
        'status',
        'reason',
        'approved_by',
        'approved_at',
        'settlement_notes',
    ];

    /**
     * Get detailed loans list with employee, department, and repayment progress
     *
     * @param array $filters
     * @return array
     */
    public function getDetailedLoans(array $filters = []): array
    {
        $builder = $this->select('employee_loans.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name,
                u.username as approved_by_user')
            ->join('employees e', 'e.id = employee_loans.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('users u', 'u.id = employee_loans.approved_by', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('employee_loans.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('employee_loans.status', $filters['status']);
        }

        return $builder->orderBy('employee_loans.id', 'DESC')->findAll();
    }
}
