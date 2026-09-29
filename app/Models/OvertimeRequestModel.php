<?php

namespace App\Models;

/**
 * Class OvertimeRequestModel
 *
 * Module 15: Overtime Requests, Approval Workflows & Payroll Calculation
 */
class OvertimeRequestModel extends BaseModel
{
    protected $table         = 'overtime_requests';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'overtime_rule_id',
        'request_date',
        'start_time',
        'end_time',
        'total_hours',
        'reason',
        'status',
        'manager_id',
        'manager_action_at',
        'manager_remarks',
        'hr_id',
        'hr_action_at',
        'hr_remarks',
        'hourly_rate',
        'payout_amount',
        'payroll_run_id',
    ];

    /**
     * Get detailed overtime requests with employee, department, and rule details
     *
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function getDetailedRequests(array $filters = [], int $limit = 100): array
    {
        $builder = $this->select('overtime_requests.*, 
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name,
                r.name as rule_name, r.rate_multiplier,
                m.first_name as manager_first_name, m.last_name as manager_last_name')
            ->join('employees e', 'e.id = overtime_requests.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('overtime_rules r', 'r.id = overtime_requests.overtime_rule_id', 'left')
            ->join('employees m', 'm.id = overtime_requests.manager_id', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('overtime_requests.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['manager_id'])) {
            $builder->where('e.reporting_to', $filters['manager_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('overtime_requests.status', $filters['status']);
        }
        if (!empty($filters['month']) && !empty($filters['year'])) {
            $builder->where("MONTH(overtime_requests.request_date)", $filters['month'])
                    ->where("YEAR(overtime_requests.request_date)", $filters['year']);
        }

        return $builder->orderBy('overtime_requests.id', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Calculate hourly wage rate from active employee salary structure
     *
     * @param int $employeeId
     * @param float $multiplier
     * @return float
     */
    public function calculateHourlyRate(int $employeeId, float $multiplier = 1.50): float
    {
        $db = \Config\Database::connect();
        $salary = $db->table('salary_structures')
            ->where('employee_id', $employeeId)
            ->orderBy('effective_date', 'DESC')
            ->get()
            ->getFirstRow('array');

        $basicSalary = $salary ? (float)$salary['basic_salary'] : 5000.00;
        // Standard formula: Hourly Rate = Basic / (26 working days * 8 hours)
        $standardHourly = round($basicSalary / (26 * 8), 2);
        return round($standardHourly * $multiplier, 2);
    }
}
