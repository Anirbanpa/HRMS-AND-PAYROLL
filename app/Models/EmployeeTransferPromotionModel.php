<?php

namespace App\Models;

/**
 * Class EmployeeTransferPromotionModel
 *
 * Module 31: Employee Transfer, Promotion & Career Movements
 */
class EmployeeTransferPromotionModel extends BaseModel
{
    protected $table         = 'employee_transfers_promotions';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'request_number',
        'employee_id',
        'movement_type',
        'effective_date',
        'from_branch_id',
        'to_branch_id',
        'from_department_id',
        'to_department_id',
        'from_designation_id',
        'to_designation_id',
        'from_pay_grade_id',
        'to_pay_grade_id',
        'from_reporting_to',
        'to_reporting_to',
        'current_salary',
        'revised_salary',
        'reason',
        'remarks',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'implemented_at',
    ];

    /**
     * Get detailed transfers and promotions history & requests
     *
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function getDetailedMovements(array $filters = [], int $limit = 100): array
    {
        $builder = $this->select('employee_transfers_promotions.*,
                e.first_name, e.last_name, e.employee_code, e.official_email,
                f_br.name as from_branch_name, t_br.name as to_branch_name,
                f_dp.name as from_department_name, t_dp.name as to_department_name,
                f_ds.name as from_designation_name, t_ds.name as to_designation_name,
                f_pg.grade_name as from_pay_grade_name, t_pg.grade_name as to_pay_grade_name,
                f_mgr.first_name as from_mgr_first, f_mgr.last_name as from_mgr_last,
                t_mgr.first_name as to_mgr_first, t_mgr.last_name as to_mgr_last,
                u.username as approver_username')
            ->join('employees e', 'e.id = employee_transfers_promotions.employee_id')
            ->join('branches f_br', 'f_br.id = employee_transfers_promotions.from_branch_id', 'left')
            ->join('branches t_br', 't_br.id = employee_transfers_promotions.to_branch_id', 'left')
            ->join('departments f_dp', 'f_dp.id = employee_transfers_promotions.from_department_id', 'left')
            ->join('departments t_dp', 't_dp.id = employee_transfers_promotions.to_department_id', 'left')
            ->join('designations f_ds', 'f_ds.id = employee_transfers_promotions.from_designation_id', 'left')
            ->join('designations t_ds', 't_ds.id = employee_transfers_promotions.to_designation_id', 'left')
            ->join('pay_grades f_pg', 'f_pg.id = employee_transfers_promotions.from_pay_grade_id', 'left')
            ->join('pay_grades t_pg', 't_pg.id = employee_transfers_promotions.to_pay_grade_id', 'left')
            ->join('employees f_mgr', 'f_mgr.id = employee_transfers_promotions.from_reporting_to', 'left')
            ->join('employees t_mgr', 't_mgr.id = employee_transfers_promotions.to_reporting_to', 'left')
            ->join('users u', 'u.id = employee_transfers_promotions.approved_by', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('employee_transfers_promotions.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['movement_type'])) {
            $builder->where('employee_transfers_promotions.movement_type', $filters['movement_type']);
        }
        if (!empty($filters['status'])) {
            $builder->where('employee_transfers_promotions.status', $filters['status']);
        }

        return $builder->orderBy('employee_transfers_promotions.id', 'DESC')->limit($limit)->findAll();
    }
}
