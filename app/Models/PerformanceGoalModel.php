<?php

namespace App\Models;

/**
 * Class PerformanceGoalModel
 *
 * Module 28: Employee KPI and OKR Goal Setting & Ratings
 */
class PerformanceGoalModel extends BaseModel
{
    protected $table         = 'performance_goals';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'cycle_id',
        'employee_id',
        'title',
        'description',
        'weightage_percent',
        'target_metric',
        'self_rating',
        'self_comments',
        'manager_rating',
        'manager_comments',
        'status',
    ];
}
