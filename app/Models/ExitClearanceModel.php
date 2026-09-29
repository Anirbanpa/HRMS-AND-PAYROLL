<?php

namespace App\Models;

class ExitClearanceModel extends BaseModel
{
    protected $table            = 'exit_clearances';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'resignation_id',
        'department_type',
        'status',
        'cleared_by_user_id',
        'cleared_at',
        'remarks',
        'dues_or_recoveries',
    ];

    public function getClearancesByResignation(int $resignationId): array
    {
        return $this->select('exit_clearances.*, users.username AS cleared_by_name')
                    ->join('users', 'users.id = exit_clearances.cleared_by_user_id', 'left')
                    ->where('exit_clearances.resignation_id', $resignationId)
                    ->orderBy('exit_clearances.id', 'ASC')
                    ->findAll();
    }
}
