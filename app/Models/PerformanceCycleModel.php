<?php

namespace App\Models;

/**
 * Class PerformanceCycleModel
 *
 * Module 28: Performance Appraisal Cycles
 */
class PerformanceCycleModel extends BaseModel
{
    protected $table         = 'performance_cycles';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'title',
        'cycle_type',
        'start_date',
        'end_date',
        'self_review_deadline',
        'manager_review_deadline',
        'status',
        'description',
    ];
}
