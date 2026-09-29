<?php

namespace App\Models;

/**
 * Class EmployeeIncentiveModel
 *
 * Module 25: Performance & Sales Incentive Entry & Payroll Batches
 */
class EmployeeIncentiveModel extends BaseModel
{
    protected $table         = 'employee_incentive_entries';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'bonus_scheme_id',
        'reference_period',
        'target_achieved',
        'calculated_amount',
        'final_amount',
        'notes',
        'status',
        'approved_by',
        'approved_at',
        'payroll_run_id',
    ];

    /**
     * Get detailed incentive records with employee and scheme details
     *
     * @param array $filters
     * @return array
     */
    public function getDetailedIncentives(array $filters = []): array
    {
        $builder = $this->select('employee_incentive_entries.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name,
                bs.title as scheme_title, bs.scheme_type, bs.calculation_type,
                u.username as approver_name')
            ->join('employees e', 'e.id = employee_incentive_entries.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('bonus_schemes bs', 'bs.id = employee_incentive_entries.bonus_scheme_id')
            ->join('users u', 'u.id = employee_incentive_entries.approved_by', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('employee_incentive_entries.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('employee_incentive_entries.status', $filters['status']);
        }
        if (!empty($filters['reference_period'])) {
            $builder->where('employee_incentive_entries.reference_period', $filters['reference_period']);
        }

        return $builder->orderBy('employee_incentive_entries.id', 'DESC')->findAll();
    }
}
