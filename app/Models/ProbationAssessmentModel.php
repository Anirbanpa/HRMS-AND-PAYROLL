<?php

namespace App\Models;

/**
 * Class ProbationAssessmentModel
 *
 * Module 32: Employee Confirmation & Probation Management
 */
class ProbationAssessmentModel extends BaseModel
{
    protected $table         = 'probation_assessments';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'employee_id',
        'joining_date',
        'initial_probation_end_date',
        'current_probation_end_date',
        'assessment_status',
        'manager_id',
        'manager_rating',
        'technical_competence_rating',
        'punctuality_attendance_rating',
        'teamwork_culture_rating',
        'manager_feedback',
        'manager_recommendation',
        'manager_submitted_at',
        'extension_months',
        'extended_until',
        'extension_reason',
        'confirmation_date',
        'hr_id',
        'hr_decision',
        'hr_remarks',
        'hr_action_at',
        'letter_generated',
    ];

    /**
     * Get detailed probation records with employee and supervisor information
     *
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function getDetailedProbations(array $filters = [], int $limit = 100): array
    {
        $builder = $this->select('probation_assessments.*,
                e.first_name, e.last_name, e.employee_code, e.official_email, e.employment_status,
                d.name as department_name, des.name as designation_name,
                m.first_name as manager_first_name, m.last_name as manager_last_name,
                u.username as hr_username')
            ->join('employees e', 'e.id = probation_assessments.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('designations des', 'des.id = e.designation_id', 'left')
            ->join('employees m', 'm.id = probation_assessments.manager_id', 'left')
            ->join('users u', 'u.id = probation_assessments.hr_id', 'left');

        $builder->where('e.deleted_at', null)
            ->whereNotIn('e.employment_status', ['terminated', 'resigned', 'retired']);

        if (!empty($filters['employee_id'])) {
            $builder->where('probation_assessments.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['assessment_status'])) {
            $builder->where('probation_assessments.assessment_status', $filters['assessment_status']);
        }
        if (!empty($filters['manager_id'])) {
            $builder->where('e.reporting_to', $filters['manager_id']);
        }

        return $builder->orderBy("CASE WHEN probation_assessments.assessment_status IN ('due', 'under_review', 'extended') THEN 0 ELSE 1 END", 'ASC', false)
            ->orderBy('probation_assessments.current_probation_end_date', 'ASC')
            ->limit($limit)
            ->findAll();
    }
}
