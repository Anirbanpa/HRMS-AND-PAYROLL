<?php

namespace App\Models;

/**
 * Class EmployeeSkillModel
 *
 * Module 29: Employee Skill Inventory & Competency Matrix
 */
class EmployeeSkillModel extends BaseModel
{
    protected $table         = 'employee_skills';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'skill_name',
        'proficiency_level',
        'verified_by_training_id',
    ];
}
