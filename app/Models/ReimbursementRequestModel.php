<?php

namespace App\Models;

/**
 * Class ReimbursementRequestModel
 *
 * Module 24: Employee Reimbursement Claims & Multi-tier Approvals
 */
class ReimbursementRequestModel extends BaseModel
{
    protected $table         = 'reimbursement_requests';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'claim_number',
        'employee_id',
        'expense_category_id',
        'claim_title',
        'expense_date',
        'amount',
        'approved_amount',
        'description',
        'receipt_path',
        'status',
        'manager_id',
        'manager_action_at',
        'manager_remarks',
        'finance_approver_id',
        'finance_action_at',
        'finance_remarks',
        'payroll_run_id',
        'paid_date',
    ];

    /**
     * Get detailed claims list with category, employee, and approver details
     *
     * @param array $filters
     * @return array
     */
    public function getDetailedClaims(array $filters = []): array
    {
        $builder = $this->select('reimbursement_requests.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name,
                c.name as category_name, c.code as category_code,
                m.first_name as manager_first_name, m.last_name as manager_last_name,
                u.username as finance_approver_name')
            ->join('employees e', 'e.id = reimbursement_requests.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('expense_categories c', 'c.id = reimbursement_requests.expense_category_id')
            ->join('employees m', 'm.id = reimbursement_requests.manager_id', 'left')
            ->join('users u', 'u.id = reimbursement_requests.finance_approver_id', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('reimbursement_requests.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['manager_id'])) {
            $builder->where('e.reporting_to', $filters['manager_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('reimbursement_requests.status', $filters['status']);
        }

        return $builder->orderBy('reimbursement_requests.id', 'DESC')->findAll();
    }
}
