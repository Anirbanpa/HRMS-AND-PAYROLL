<?php

namespace App\Models;

class LeaveTypeModel extends BaseModel
{
    protected $table         = 'leave_types';
    protected $primaryKey    = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'company_id',
        'name',
        'code',
        'days_allowed_per_year',
        'is_paid',
        'carry_forward_allowed',
        'max_carry_forward',
        'status',
    ];
}
