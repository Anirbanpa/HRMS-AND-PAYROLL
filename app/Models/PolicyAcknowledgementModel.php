<?php

namespace App\Models;

/**
 * Class PolicyAcknowledgementModel
 *
 * Module 38: Employee Policy Acknowledgement Audit Trail
 */
class PolicyAcknowledgementModel extends BaseModel
{
    protected $table         = 'policy_acknowledgements';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'policy_id',
        'employee_id',
        'acknowledged_at',
        'ip_address',
        'user_agent',
        'created_at',
        'updated_at',
    ];
}
