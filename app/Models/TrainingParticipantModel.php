<?php

namespace App\Models;

/**
 * Class TrainingParticipantModel
 *
 * Module 29: Training Nominations, Attendance & Certifications
 */
class TrainingParticipantModel extends BaseModel
{
    protected $table         = 'training_participants';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'training_id',
        'employee_id',
        'nominated_by',
        'nomination_status',
        'attendance_percent',
        'completion_status',
        'score_rating',
        'feedback',
        'certificate_path',
        'completed_date',
    ];

    /**
     * Get participants joined with employee details
     */
    public function getParticipantsWithDetails(int $trainingId): array
    {
        return $this->select('training_participants.*, e.first_name, e.last_name, e.employee_code, e.official_email, d.name as department_name, des.name as designation_name')
            ->join('employees e', 'e.id = training_participants.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('designations des', 'des.id = e.designation_id', 'left')
            ->where('training_participants.training_id', $trainingId)
            ->findAll();
    }
}
