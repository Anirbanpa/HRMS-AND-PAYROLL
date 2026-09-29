<?php

namespace App\Models;

class PayrollRunModel extends BaseModel
{
    protected $table         = 'payroll_runs';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'financial_year_id',
        'month',
        'year',
        'title',
        'status',
        'processed_by',
        'processed_at',
        'total_employees',
        'total_gross',
        'total_deductions',
        'total_net',
    ];
}
