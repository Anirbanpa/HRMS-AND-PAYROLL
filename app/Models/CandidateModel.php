<?php

namespace App\Models;

class CandidateModel extends BaseModel
{
    protected $table            = 'candidates';
    protected $primaryKey       = 'id';
    protected $useSoftDeletes   = false;
    protected $useTimestamps    = false; // Handled natively by MySQL
    protected $allowedFields    = [
        'job_opening_id',
        'candidate_code',
        'full_name',
        'email',
        'phone',
        'experience_years',
        'current_company',
        'current_ctc',
        'expected_ctc',
        'notice_period_days',
        'resume_path',
        'stage',
        'scorecard_rating',
        'interviewer_feedback',
        'hired_as_employee_id',
    ];

    public function getCandidatesWithJob(array $filters = []): array
    {
        $builder = $this->select('candidates.*, job_openings.title AS job_title, job_openings.job_code, departments.name AS department_name, employees.employee_code AS converted_emp_code')
                        ->join('job_openings', 'job_openings.id = candidates.job_opening_id', 'left')
                        ->join('departments', 'departments.id = job_openings.department_id', 'left')
                        ->join('employees', 'employees.id = candidates.hired_as_employee_id', 'left');

        if (!empty($filters['stage'])) {
            $builder->where('candidates.stage', $filters['stage']);
        }
        if (!empty($filters['job_id'])) {
            $builder->where('candidates.job_opening_id', $filters['job_id']);
        }

        return $builder->orderBy('candidates.id', 'DESC')->findAll();
    }
}
