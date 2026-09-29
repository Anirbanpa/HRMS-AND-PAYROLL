<?php

namespace App\Models;

/**
 * Class LateEarlyPolicyModel
 *
 * Module 16: Late Coming & Early Leaving Policies
 */
class LateEarlyPolicyModel extends BaseModel
{
    protected $table         = 'late_early_policies';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'name',
        'policy_code',
        'grace_period_mins',
        'early_exit_tolerance_mins',
        'max_monthly_late_count',
        'deduction_rule',
        'deduction_rate',
        'is_active',
    ];
}
