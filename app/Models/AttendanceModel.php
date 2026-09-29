<?php

namespace App\Models;

class AttendanceModel extends BaseModel
{
    protected $table         = 'attendance';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'date',
        'shift_id',
        'clock_in',
        'clock_out',
        'total_hours',
        'late_minutes',
        'early_leaving_minutes',
        'overtime_minutes',
        'status',
        'clock_in_ip',
        'clock_out_ip',
        'source',
        'notes',
        'late_waived',
        'early_exit_waived',
        'waived_by',
        'waived_reason',
        'waived_at',
    ];

    /**
     * Get attendance records with employee details and optional filters
     */
    public function getDetailedAttendance(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $builder = $this->select('attendance.*, emp.first_name, emp.last_name, emp.employee_code, emp.department_id, emp.branch_id,
            dept.name as department_name, br.name as branch_name, s.name as shift_name')
            ->join('employees emp', 'emp.id = attendance.employee_id')
            ->join('departments dept', 'dept.id = emp.department_id', 'left')
            ->join('branches br', 'br.id = emp.branch_id', 'left')
            ->join('shifts s', 's.id = attendance.shift_id', 'left');

        if (!empty($filters['date'])) {
            $builder->where('attendance.date', $filters['date']);
        }

        if (!empty($filters['department_id'])) {
            $builder->where('emp.department_id', $filters['department_id']);
        }

        if (!empty($filters['branch_id'])) {
            $builder->where('emp.branch_id', $filters['branch_id']);
        }

        if (!empty($filters['status'])) {
            $builder->where('attendance.status', $filters['status']);
        }

        if (!empty($filters['employee_id'])) {
            $builder->where('attendance.employee_id', $filters['employee_id']);
        }

        return $builder->orderBy('attendance.date', 'DESC')
            ->orderBy('attendance.id', 'DESC')
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }

    /**
     * Get today's record for a specific employee
     */
    public function getTodayRecord(int $employeeId, string $date = null): ?array
    {
        $date = $date ?: date('Y-m-d');
        return $this->where('employee_id', $employeeId)
            ->where('date', $date)
            ->first();
    }
}
