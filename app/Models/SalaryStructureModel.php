<?php

namespace App\Models;

class SalaryStructureModel extends BaseModel
{
    protected $table            = 'salary_structures';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'employee_id',
        'effective_date',
        'basic_salary',
        'hra',
        'conveyance_allowance',
        'special_allowance',
        'medical_allowance',
        'other_allowances',
        'gross_salary',
        'pf_deduction',
        'tax_deduction',
        'insurance_deduction',
        'total_deductions',
        'net_salary',
    ];
}
