<?php

namespace App\Controllers;

use App\Models\TrainingProgramModel;
use App\Models\TrainingParticipantModel;
use App\Models\EmployeeSkillModel;
use App\Models\EmployeeModel;

/**
 * Class TrainingController
 *
 * Module 29: Training Programs & Skill Development
 */
class TrainingController extends BaseController
{
    /**
     * Training Catalog, Calendar & My Learnings Hub
     */
    public function index()
    {
        $trainingModel    = new TrainingProgramModel();
        $participantModel = new TrainingParticipantModel();
        $skillModel       = new EmployeeSkillModel();
        $employeeModel    = new EmployeeModel();
        $db               = \Config\Database::connect();

        $trainings = $trainingModel->orderBy('start_date', 'DESC')->findAll();
        $employees = $employeeModel->where('employment_status', 'active')->where('deleted_at', null)->findAll();
        $currentEmpId = $this->currentUser['employee_id'] ?? null;
        $isHR = $this->hasRole(['super_admin', 'hr_admin', 'hr_executive']);

        // Attach participant count and enrolled participants to each training
        foreach ($trainings as &$t) {
            $t['participants'] = $participantModel->getParticipantsWithDetails($t['id']);
            $t['enrolled_count'] = count($t['participants']);
        }

        // My enrolled courses & completed certifications
        $myEnrollments = [];
        $mySkills = [];
        if ($currentEmpId) {
            $myEnrollments = $db->table('training_participants tp')
                ->select('tp.*, tp.id as participant_id, tp.completion_status, tp.score_rating, tp.completed_date, tp.attendance_percent, t.title as course_title, t.course_code, t.category, t.trainer_name, t.start_date, t.end_date, t.total_hours')
                ->join('training_programs t', 't.id = tp.training_id')
                ->where('tp.employee_id', $currentEmpId)
                ->orderBy('t.start_date', 'DESC')
                ->get()
                ->getResultArray();

            $mySkills = $skillModel->where('employee_id', $currentEmpId)->findAll();
        }

        $data = [
            'trainings'     => $trainings,
            'employees'     => $employees,
            'myEnrollments' => $myEnrollments,
            'mySkills'      => $mySkills,
            'isHR'          => $isHR,
        ];

        return $this->render('training/index', $data, 'Training Programs, Calendar & Skills');
    }

    /**
     * Store New Training Program
     */
    public function store()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Unauthorized to schedule training.');
            return redirect()->to(site_url('training'));
        }

        $rules = [
            'title'       => 'required|min_length[3]|max_length[150]',
            'category'    => 'required',
            'start_date'  => 'required|valid_date',
            'end_date'    => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('training'));
        }

        $code = 'TRN-' . date('Y') . '-' . strtoupper(substr(uniqid(), -4));
        $trainingModel = new TrainingProgramModel();

        $newId = $trainingModel->insert([
            'company_id'        => 1,
            'title'             => $this->request->getPost('title'),
            'course_code'       => $code,
            'category'          => $this->request->getPost('category'),
            'trainer_name'      => $this->request->getPost('trainer_name'),
            'training_type'     => $this->request->getPost('training_type') ?: 'internal',
            'start_date'        => $this->request->getPost('start_date'),
            'end_date'          => $this->request->getPost('end_date'),
            'total_hours'       => (float)($this->request->getPost('total_hours') ?: 8.0),
            'max_participants'  => (int)($this->request->getPost('max_participants') ?: 30),
            'location'          => $this->request->getPost('location') ?: 'Main Hall',
            'description'       => $this->request->getPost('description'),
            'status'            => 'scheduled',
        ]);

        $this->logAudit('TRAINING_CREATE', 'training', "Scheduled training program {$code}", $newId);
        $this->session->setFlashdata('success', 'Training program scheduled successfully.');
        return redirect()->to(site_url('training'));
    }

    /**
     * Nominate / Enroll Employee into Training
     */
    public function nominate()
    {
        $trainingId = (int)$this->request->getPost('training_id');
        $employeeId = (int)$this->request->getPost('employee_id');

        if (empty($trainingId) || empty($employeeId)) {
            $this->session->setFlashdata('error', 'Training program and employee must be selected.');
            return redirect()->to(site_url('training'));
        }

        $participantModel = new TrainingParticipantModel();
        $existing = $participantModel->where('training_id', $trainingId)->where('employee_id', $employeeId)->first();
        if ($existing) {
            $this->session->setFlashdata('warning', 'Employee is already enrolled in this training program.');
            return redirect()->to(site_url('training'));
        }

        $trainingModel = new TrainingProgramModel();
        $training = $trainingModel->find($trainingId);

        $currentCount = $participantModel->where('training_id', $trainingId)->countAllResults();
        if ($training && $currentCount >= (int)$training['max_participants']) {
            $this->session->setFlashdata('error', "Maximum participant capacity ({$training['max_participants']}) reached for this program.");
            return redirect()->to(site_url('training'));
        }

        $participantModel->insert([
            'training_id'        => $trainingId,
            'employee_id'        => $employeeId,
            'nominated_by'       => $this->currentUser['employee_id'] ?? null,
            'nomination_status'  => 'nominated',
            'completion_status'  => 'in_progress',
            'attendance_percent' => 0.00,
        ]);

        // Dispatch in-app alert to employee
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('appraisal_assigned', $employeeId, [
            '{{DETAILS}}'     => "Enrolled in training: {$training['title']} ({$training['course_code']})",
            '{{ACTION_DATE}}' => date('F j, Y', strtotime($training['start_date'])),
        ], ['in_app', 'email']);

        $this->logAudit('TRAINING_NOMINATE', 'training', "Nominated employee #{$employeeId} for training #{$trainingId}");
        $this->session->setFlashdata('success', 'Employee successfully enrolled in training program.');
        return redirect()->to(site_url('training'));
    }

    /**
     * Mark Attendance & Roll-Call for Participant
     */
    public function markAttendance()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to record attendance.');
            return redirect()->to(site_url('training'));
        }

        $participantId = (int)$this->request->getPost('participant_id');
        $status        = $this->request->getPost('nomination_status') ?: 'attended';
        $percent       = (float)($this->request->getPost('attendance_percent') ?: 100.0);

        $participantModel = new TrainingParticipantModel();
        $participantModel->update($participantId, [
            'nomination_status'  => $status,
            'attendance_percent' => $percent,
        ]);

        $this->logAudit('TRAINING_ATTENDANCE', 'training', "Marked attendance for participant #{$participantId} as {$status} ({$percent}%)");
        $this->session->setFlashdata('success', 'Training attendance updated.');
        return redirect()->to(site_url('training'));
    }

    /**
     * Complete Training & Issue Credential / Skill
     */
    public function complete()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Unauthorized to certify training completion.');
            return redirect()->to(site_url('training'));
        }

        $participantId = (int)$this->request->getPost('participant_id');
        $completion    = $this->request->getPost('completion_status') ?: 'completed';
        $score         = (float)$this->request->getPost('score_rating');
        $skillName     = trim($this->request->getPost('skill_name') ?? '');
        $feedback      = trim($this->request->getPost('feedback') ?? '');

        $participantModel = new TrainingParticipantModel();
        $participant = $participantModel->find($participantId);

        if (!$participant) {
            $this->session->setFlashdata('error', 'Participant record not found.');
            return redirect()->to(site_url('training'));
        }

        $participantModel->update($participantId, [
            'completion_status' => $completion,
            'score_rating'      => $score,
            'feedback'          => $feedback,
            'completed_date'    => ($completion === 'completed') ? date('Y-m-d') : null,
            'certificate_path'  => ($completion === 'completed') ? "certificates/cert_{$participantId}.pdf" : null,
        ]);

        // Auto-award skill if completed
        if ($completion === 'completed' && !empty($skillName)) {
            $skillModel = new EmployeeSkillModel();
            $existingSkill = $skillModel->where('employee_id', $participant['employee_id'])->where('skill_name', $skillName)->first();
            if (!$existingSkill) {
                $skillModel->insert([
                    'employee_id'             => $participant['employee_id'],
                    'skill_name'              => $skillName,
                    'proficiency_level'       => ($score >= 85) ? 'advanced' : 'intermediate',
                    'verified_by_training_id' => $participant['training_id'],
                ]);
            }
        }

        $this->logAudit('TRAINING_COMPLETE', 'training', "Recorded completion status '{$completion}' for participant #{$participantId}");
        $this->session->setFlashdata('success', 'Participant training completion and certification recorded.');
        return redirect()->to(site_url('training'));
    }

    /**
     * Render & Print Official Training Certificate of Completion
     */
    public function certificate(int $participantId)
    {
        $db = \Config\Database::connect();
        $record = $db->table('training_participants tp')
            ->select('tp.*, e.first_name, e.last_name, e.employee_code, d.name as department_name, des.name as designation_name, t.title as course_title, t.course_code, t.category, t.trainer_name, t.total_hours, t.start_date, t.end_date')
            ->join('employees e', 'e.id = tp.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('designations des', 'des.id = e.designation_id', 'left')
            ->join('training_programs t', 't.id = tp.training_id')
            ->where('tp.id', $participantId)
            ->get()
            ->getFirstRow('array');

        if (!$record || $record['completion_status'] !== 'completed') {
            return redirect()->to(site_url('training'))->with('error', 'No verified completion certificate found for this participant.');
        }

        $data = [
            'cert'      => $record,
            'pageTitle' => 'Certificate of Training Completion - ' . $record['first_name'] . ' ' . $record['last_name'],
        ];

        return view('training/certificate', $data);
    }
}
