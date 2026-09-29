<?php

namespace App\Models;

/**
 * Class TrainingProgramModel
 *
 * Module 29: Training Programs & Skill Development
 */
class TrainingProgramModel extends BaseModel
{
    protected $table         = 'training_programs';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'company_id',
        'title',
        'course_code',
        'category',
        'trainer_name',
        'training_type',
        'start_date',
        'end_date',
        'total_hours',
        'max_participants',
        'location',
        'cost_per_employee',
        'description',
        'status',
    ];
}
