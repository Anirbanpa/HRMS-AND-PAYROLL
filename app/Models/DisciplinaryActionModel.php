<?php

namespace App\Models;

/**
 * Class DisciplinaryActionModel
 *
 * Module 33: Employee Warning & Disciplinary Records
 */
class DisciplinaryActionModel extends BaseModel
{
    protected $table         = 'disciplinary_actions';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'case_number',
        'employee_id',
        'incident_date',
        'action_type',
        'severity_level',
        'title',
        'description',
        'action_taken',
        'pip_start_date',
        'pip_end_date',
        'suspension_days',
        'attachment_path',
        'status',
        'employee_explanation',
        'employee_acknowledged_at',
        'appeal_notes',
        'closure_notes',
        'closed_at',
        'is_confidential',
        'issued_by',
    ];

    /**
     * Get detailed disciplinary records with employee and issuer details
     *
     * @param array $filters
     * @param int $limit
     * @return array
     */
    public function getDetailedCases(array $filters = [], int $limit = 100): array
    {
        $builder = $this->select('disciplinary_actions.*,
                e.first_name, e.last_name, e.employee_code, e.official_email,
                d.name as department_name, des.name as designation_name,
                u.username as issuer_username')
            ->join('employees e', 'e.id = disciplinary_actions.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('designations des', 'des.id = e.designation_id', 'left')
            ->join('users u', 'u.id = disciplinary_actions.issued_by', 'left');

        if (!empty($filters['employee_id'])) {
            $builder->where('disciplinary_actions.employee_id', $filters['employee_id']);
        }
        if (!empty($filters['action_type'])) {
            $builder->where('disciplinary_actions.action_type', $filters['action_type']);
        }
        if (!empty($filters['status'])) {
            $builder->where('disciplinary_actions.status', $filters['status']);
        }

        return $builder->orderBy('disciplinary_actions.id', 'DESC')->limit($limit)->findAll();
    }
}
