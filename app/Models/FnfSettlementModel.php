<?php

namespace App\Models;

class FnfSettlementModel extends BaseModel
{
    protected $table            = 'fnf_settlements';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'resignation_id',
        'employee_id',
        'settlement_date',
        'unpaid_salary_days',
        'unpaid_salary_amount',
        'leave_encashment_days',
        'leave_encashment_amount',
        'gratuity_amount',
        'bonus_amount',
        'total_earnings',
        'notice_shortfall_recovery',
        'asset_damage_deduction',
        'statutory_tax_deduction',
        'total_deductions',
        'net_payable_amount',
        'payment_mode',
        'payment_reference',
        'settlement_status',
        'approved_by',
        'remarks',
    ];

    public function getSettlementFull(int $settlementId): ?array
    {
        return $this->select('fnf_settlements.*, employees.employee_code, employees.first_name, employees.last_name, employees.joining_date,
                              employees.email, departments.name AS department_name, designations.name AS designation_title,
                              resignations.resignation_date, resignations.approved_last_working_day,
                              employee_bank_details.bank_name, employee_bank_details.account_number, employee_bank_details.ifsc_swift_code')
                    ->join('employees', 'employees.id = fnf_settlements.employee_id', 'left')
                    ->join('departments', 'departments.id = employees.department_id', 'left')
                    ->join('designations', 'designations.id = employees.designation_id', 'left')
                    ->join('resignations', 'resignations.id = fnf_settlements.resignation_id', 'left')
                    ->join('employee_bank_details', 'employee_bank_details.employee_id = employees.id', 'left')
                    ->where('fnf_settlements.id', $settlementId)
                    ->first();
    }
}
