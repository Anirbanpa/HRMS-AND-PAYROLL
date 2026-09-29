<?php

namespace App\Models;

/**
 * Class ShiftAllocationModel
 *
 * Module 12: Employee Shift Assignment & Rotational Schedules
 */
class ShiftAllocationModel extends BaseModel
{
    protected $table         = 'shift_allocations';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'shift_id',
        'from_date',
        'to_date',
        'rotation_pattern',
        'assigned_by',
        'status',
        'notes',
        'updated_at',
    ];

    /**
     * Get detailed allocations with employee, department, and shift details
     *
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function getDetailedAllocations(array $filters = [], int $limit = 100): array
    {
        $builder = $this->select('shift_allocations.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name,
                s.name as shift_name, s.code as shift_code, s.start_time, s.end_time, s.shift_type,
                u.username as assigned_by_name')
            ->join('employees e', 'e.id = shift_allocations.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('shifts s', 's.id = shift_allocations.shift_id')
            ->join('users u', 'u.id = shift_allocations.assigned_by', 'left');

        if (!empty($filters['department_id'])) {
            $builder->where('e.department_id', $filters['department_id']);
        }
        if (!empty($filters['shift_id'])) {
            $builder->where('shift_allocations.shift_id', $filters['shift_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('shift_allocations.status', $filters['status']);
        }

        return $builder->orderBy('shift_allocations.id', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Determine active shift for an employee on a given date
     *
     * @param int $employeeId
     * @param string $date Y-m-d
     * @return array|null
     */
    public function getActiveShift(int $employeeId, string $date): ?array
    {
        return $this->select('shifts.*, shift_allocations.from_date, shift_allocations.to_date, shift_allocations.rotation_pattern')
            ->join('shifts', 'shifts.id = shift_allocations.shift_id')
            ->where('shift_allocations.employee_id', $employeeId)
            ->where('shift_allocations.from_date <=', $date)
            ->groupStart()
                ->where('shift_allocations.to_date >=', $date)
                ->orWhere('shift_allocations.to_date', null)
            ->groupEnd()
            ->where('shift_allocations.status', 'active')
            ->orderBy('shift_allocations.id', 'DESC')
            ->first();
    }
}
