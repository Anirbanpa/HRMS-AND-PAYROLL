<?php

namespace App\Models;

/**
 * Class WorkingDayConfigModel
 *
 * Module 14: Weekly Working Days & Alternate Off Configuration
 */
class WorkingDayConfigModel extends BaseModel
{
    protected $table         = 'working_day_configurations';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'branch_id',
        'department_id',
        'day_of_week',
        'is_working',
        'working_type',
        'alternate_week_off',
    ];

    /**
     * Check whether a specific date is a working day, half day, or week off
     *
     * @param string $date Y-m-d
     * @param int $companyId
     * @return array
     */
    public function evaluateWorkingDay(string $date, int $companyId = 1): array
    {
        $dayName = strtolower(date('l', strtotime($date)));
        $config = $this->where('company_id', $companyId)
            ->where('day_of_week', $dayName)
            ->first();

        if (!$config) {
            // Standard fallback: Sunday off, others working full day
            return [
                'is_working'   => ($dayName !== 'sunday') ? 1 : 0,
                'working_type' => ($dayName !== 'sunday') ? 'full_day' : 'off',
            ];
        }

        if ($config['alternate_week_off'] === '2nd_4th_saturday' && $dayName === 'saturday') {
            $dayOfMonth = (int)date('j', strtotime($date));
            $weekNumber = (int)ceil($dayOfMonth / 7);
            if ($weekNumber === 2 || $weekNumber === 4) {
                return [
                    'is_working'   => 0,
                    'working_type' => 'off',
                    'reason'       => '2nd/4th Saturday Week Off',
                ];
            }
        }

        return [
            'is_working'   => (int)$config['is_working'],
            'working_type' => $config['working_type'],
        ];
    }
}
