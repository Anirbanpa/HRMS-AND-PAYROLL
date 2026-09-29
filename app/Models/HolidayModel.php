<?php

namespace App\Models;

/**
 * Class HolidayModel
 *
 * Module 14: Holiday & Calendar Management
 */
class HolidayModel extends BaseModel
{
    protected $table         = 'holidays';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'branch_id',
        'department_id',
        'title',
        'holiday_type',
        'date',
        'is_recurring',
        'is_working_day',
        'description',
    ];

    /**
     * Get holidays filtered by branch, department, and year
     *
     * @param int $year
     * @param int|null $branchId
     * @param int|null $departmentId
     * @return array
     */
    public function getHolidaysByScope(int $year, ?int $branchId = null, ?int $departmentId = null): array
    {
        $builder = $this->select('holidays.*, b.name as branch_name, d.name as department_name')
            ->join('branches b', 'b.id = holidays.branch_id', 'left')
            ->join('departments d', 'd.id = holidays.department_id', 'left')
            ->where("YEAR(holidays.date)", $year);

        if ($branchId !== null) {
            $builder->groupStart()
                ->where('holidays.branch_id', $branchId)
                ->orWhere('holidays.branch_id', null)
            ->groupEnd();
        }

        if ($departmentId !== null) {
            $builder->groupStart()
                ->where('holidays.department_id', $departmentId)
                ->orWhere('holidays.department_id', null)
            ->groupEnd();
        }

        return $builder->orderBy('holidays.date', 'ASC')->findAll();
    }

    /**
     * Check if a specific date is recognized as a holiday
     *
     * @param string $date Y-m-d
     * @param int|null $branchId
     * @param int|null $departmentId
     * @return array|null
     */
    public function isHoliday(string $date, ?int $branchId = null, ?int $departmentId = null): ?array
    {
        $builder = $this->where('date', $date);

        if ($branchId !== null) {
            $builder->groupStart()
                ->where('branch_id', $branchId)
                ->orWhere('branch_id', null)
            ->groupEnd();
        }

        if ($departmentId !== null) {
            $builder->groupStart()
                ->where('department_id', $departmentId)
                ->orWhere('department_id', null)
            ->groupEnd();
        }

        return $builder->first();
    }
}
