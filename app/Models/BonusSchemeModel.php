<?php

namespace App\Models;

/**
 * Class BonusSchemeModel
 *
 * Module 25: Bonus, Incentive & Sales Commission Schemes
 */
class BonusSchemeModel extends BaseModel
{
    protected $table         = 'bonus_schemes';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'title',
        'scheme_code',
        'scheme_type',
        'calculation_type',
        'default_value',
        'description',
        'status',
    ];
}
