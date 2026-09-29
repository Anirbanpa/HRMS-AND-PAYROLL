<?php

namespace App\Models;

class LeaveBalanceModel extends BaseModel
{
    protected $table         = 'leave_balances';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'employee_id',
        'leave_type_id',
        'year',
        'allocated_days',
        'used_days',
        'pending_days',
        'remaining_days',
    ];
}
