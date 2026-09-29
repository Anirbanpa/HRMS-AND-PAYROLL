<?php

namespace App\Models;

/**
 * Class AttendanceTimeWaiverModel
 *
 * Module 16: Late & Early Exit Waivers and Manager Approvals
 */
class AttendanceTimeWaiverModel extends BaseModel
{
    protected $table         = 'attendance_time_waivers';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'attendance_id',
        'employee_id',
        'waiver_type',
        'waiver_date',
        'minutes_recorded',
        'reason',
        'status',
        'manager_id',
        'manager_action_at',
        'manager_remarks',
        'hr_id',
        'hr_action_at',
        'hr_remarks',
        'created_at',
        'updated_at',
    ];

    /**
     * Get detailed waiver requests with employee, department, and manager info
     *
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function getDetailedWaivers(array $filters = [], int $limit = 100): array
    {
        $builder = $this->select('attendance_time_waivers.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name,
                m.first_name as manager_first_name, m.last_name as manager_last_name,
                u.username as hr_username')
            ->join('employees e', 'e.id = attendance_time_waivers.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('employees m', 'm.id = attendance_time_waivers.manager_id', 'left')
            ->join('users u', 'u.id = attendance_time_waivers.hr_id', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('attendance_time_waivers.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('attendance_time_waivers.status', $filters['status']);
        }
        if (!empty($filters['manager_id'])) {
            $builder->where('e.reporting_to', $filters['manager_id']);
        }

        return $builder->orderBy('attendance_time_waivers.id', 'DESC')->limit($limit)->findAll();
    }
}
