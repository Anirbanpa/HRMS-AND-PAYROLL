<?php

namespace App\Models;

/**
 * Class OvertimeRuleModel
 *
 * Module 15: Overtime Multiplier Rules & Daily/Monthly Caps
 */
class OvertimeRuleModel extends BaseModel
{
    protected $table         = 'overtime_rules';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'name',
        'rule_code',
        'rate_multiplier',
        'applicable_days',
        'min_hours',
        'max_hours_per_day',
        'monthly_cap_hours',
        'is_active',
    ];
}
