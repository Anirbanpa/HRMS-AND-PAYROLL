<?php

namespace App\Models;

/**
 * Class EmployeeAppraisalModel
 *
 * Module 28: Performance Review Ratings, Bands & Promotions
 */
class EmployeeAppraisalModel extends BaseModel
{
    protected $table         = 'employee_appraisals';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'cycle_id',
        'employee_id',
        'reviewer_manager_id',
        'overall_self_score',
        'overall_manager_score',
        'final_rating_band',
        'promotion_recommended',
        'recommended_increment_percent',
        'key_strengths',
        'development_areas',
        'status',
        'completed_at',
    ];
}
