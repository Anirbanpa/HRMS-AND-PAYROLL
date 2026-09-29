<?php

namespace App\Models;

class CompanyModel extends BaseModel
{
    protected $table            = 'companies';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'name',
        'code',
        'tax_id',
        'email',
        'phone',
        'website',
        'currency',
        'timezone',
        'fiscal_year_start_month',
        'logo',
        'address',
        'status',
    ];
}
