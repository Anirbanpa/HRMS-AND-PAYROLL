<?php

namespace App\Models;

/**
 * Class ShiftModel
 *
 * Module 12: Shift Management & Rotational Roster
 */
class ShiftModel extends BaseModel
{
    protected $table         = 'shifts';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'name',
        'code',
        'shift_type',
        'start_time',
        'end_time',
        'break_duration_mins',
        'late_grace_mins',
        'early_exit_grace_mins',
        'half_day_hours',
        'full_day_hours',
        'overtime_eligible',
        'min_overtime_mins',
        'is_night_shift',
        'status',
    ];

    /**
     * Get active shifts with count of currently allocated employees
     *
     * @param int $companyId
     * @return array
     */
    public function getShiftsWithAllocationStats(int $companyId = 1): array
    {
        return $this->select('shifts.*, COUNT(shift_allocations.id) as allocated_count')
            ->join('shift_allocations', 'shift_allocations.shift_id = shifts.id AND (shift_allocations.to_date IS NULL OR shift_allocations.to_date >= CURDATE())', 'left')
            ->where('shifts.company_id', $companyId)
            ->groupBy('shifts.id')
            ->orderBy('shifts.start_time', 'ASC')
            ->findAll();
    }
}
