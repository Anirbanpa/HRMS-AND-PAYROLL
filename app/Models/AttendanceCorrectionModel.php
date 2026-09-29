<?php

namespace App\Models;

/**
 * Class AttendanceCorrectionModel
 *
 * Module 27: Manager Self-Service Attendance Corrections
 */
class AttendanceCorrectionModel extends BaseModel
{
    protected $table         = 'attendance_corrections';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'attendance_id',
        'attendance_date',
        'requested_clock_in',
        'requested_clock_out',
        'reason',
        'status',
        'manager_id',
        'manager_action_at',
        'manager_remarks',
    ];

    /**
     * Get detailed corrections for reporting manager
     *
     * @param int|null $managerId
     * @param string|null $status
     * @return array
     */
    public function getManagerQueue(?int $managerId = null, ?string $status = 'pending'): array
    {
        $builder = $this->select('attendance_corrections.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name')
            ->join('employees e', 'e.id = attendance_corrections.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left');

        if ($managerId !== null) {
            $builder->where('e.reporting_to', $managerId);
        }
        if ($status !== null) {
            $builder->where('attendance_corrections.status', $status);
        }

        return $builder->orderBy('attendance_corrections.id', 'DESC')->findAll();
    }
}
