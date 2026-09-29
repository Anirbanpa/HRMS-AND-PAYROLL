<?php

namespace App\Models;

class ResignationModel extends BaseModel
{
    protected $table            = 'resignations';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'employee_id',
        'resignation_date',
        'requested_last_working_day',
        'approved_last_working_day',
        'reason',
        'status',
        'approver_remarks',
        'notice_period_shortfall_days',
    ];

    public function getResignationsWithEmployee(): array
    {
        return $this->select('resignations.*, employees.employee_code, employees.first_name, employees.last_name, employees.joining_date,
                              departments.name AS department_name, designations.name AS designation_title,
                              fnf_settlements.id AS fnf_id, fnf_settlements.settlement_status, fnf_settlements.net_payable_amount')
                    ->join('employees', 'employees.id = resignations.employee_id', 'left')
                    ->join('departments', 'departments.id = employees.department_id', 'left')
                    ->join('designations', 'designations.id = employees.designation_id', 'left')
                    ->join('fnf_settlements', 'fnf_settlements.resignation_id = resignations.id', 'left')
                    ->orderBy('resignations.id', 'DESC')
                    ->findAll();
    }
}
