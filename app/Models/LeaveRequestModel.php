<?php

namespace App\Models;

class LeaveRequestModel extends BaseModel
{
    protected $table         = 'leave_requests';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'is_half_day',
        'reason',
        'status',
        'manager_id',
        'manager_action_at',
        'hr_id',
        'hr_action_at',
        'rejection_reason',
    ];

    /**
     * Get detailed leave requests with employee, department, and leave type
     */
    public function getDetailedRequests(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $builder = $this->select('leave_requests.*, emp.first_name, emp.last_name, emp.employee_code, emp.department_id,
            lt.name as leave_type_name, lt.code as leave_type_code, lt.is_paid,
            dept.name as department_name,
            mgr.first_name as manager_first_name, mgr.last_name as manager_last_name')
            ->join('employees emp', 'emp.id = leave_requests.employee_id')
            ->join('leave_types lt', 'lt.id = leave_requests.leave_type_id')
            ->join('departments dept', 'dept.id = emp.department_id', 'left')
            ->join('employees mgr', 'mgr.id = leave_requests.manager_id', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('leave_requests.employee_id', $filters['employee_id']);
        }

        if (!empty($filters['manager_id'])) {
            $builder->where('emp.reporting_to', $filters['manager_id']);
        }

        if (!empty($filters['reporting_to'])) {
            $builder->where('emp.reporting_to', $filters['reporting_to']);
        }

        if (!empty($filters['status'])) {
            $builder->where('leave_requests.status', $filters['status']);
        }

        if (!empty($filters['department_id'])) {
            $builder->where('emp.department_id', $filters['department_id']);
        }

        return $builder->orderBy('leave_requests.id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    /**
     * Alias for getDetailedRequests
     */
    public function getDetailedLeaves(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        return $this->getDetailedRequests($filters, $limit, $offset);
    }
}
