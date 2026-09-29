<?php

namespace App\Models;

class JobOpeningModel extends BaseModel
{
    protected $table            = 'job_openings';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false; // Handled natively by MySQL
    protected $allowedFields    = [
        'title',
        'job_code',
        'department_id',
        'designation_id',
        'vacancies',
        'job_type',
        'experience_required',
        'location',
        'min_salary',
        'max_salary',
        'description',
        'requirements',
        'status',
        'closing_date',
        'created_by',
    ];

    public function getOpeningsWithDetails(): array
    {
        return $this->select('job_openings.*, departments.name AS department_name, designations.name AS designation_title,
                              (SELECT COUNT(*) FROM candidates WHERE candidates.job_opening_id = job_openings.id) AS total_applicants,
                              (SELECT COUNT(*) FROM candidates WHERE candidates.job_opening_id = job_openings.id AND candidates.stage = "hired") AS hired_count')
                    ->join('departments', 'departments.id = job_openings.department_id', 'left')
                    ->join('designations', 'designations.id = job_openings.designation_id', 'left')
                    ->orderBy('job_openings.id', 'DESC')
                    ->findAll();
    }
}
