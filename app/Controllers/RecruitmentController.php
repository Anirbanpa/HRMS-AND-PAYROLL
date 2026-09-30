<?php

namespace App\Controllers;

use App\Models\JobOpeningModel;
use App\Models\CandidateModel;
use App\Models\DepartmentModel;
use App\Models\DesignationModel;
use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\LeaveTypeModel;
use App\Models\LeaveBalanceModel;
use CodeIgniter\HTTP\ResponseInterface;

class RecruitmentController extends BaseController
{
    protected JobOpeningModel $jobModel;
    protected CandidateModel $candidateModel;

    public function __construct()
    {
        $this->jobModel = new JobOpeningModel();
        $this->candidateModel = new CandidateModel();
    }

    /**
     * Recruitment & ATS Dashboard / Pipeline
     */
    public function index()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'hr_executive'])) {
            $this->session->setFlashdata('error', 'Access Denied: Recruitment & ATS is restricted to Human Resources personnel.');
            return redirect()->to(site_url('dashboard'));
        }

        $jobs = $this->jobModel->getOpeningsWithDetails();
        $candidates = $this->candidateModel->getCandidatesWithJob();

        $deptModel = new DepartmentModel();
        $departments = $deptModel->findAll();

        $desigModel = new DesignationModel();
        $designations = $desigModel->findAll();

        // Calculate KPI Metrics
        $totalOpenings = count(array_filter($jobs, fn($j) => $j['status'] === 'open'));
        $totalCandidates = count($candidates);
        $interviews = count(array_filter($candidates, fn($c) => $c['stage'] === 'interview'));
        $offeredOrHired = count(array_filter($candidates, fn($c) => in_array($c['stage'], ['offered', 'hired'])));

        // Group Candidates by Stage
        $pipeline = [
            'applied'   => [],
            'screening' => [],
            'interview' => [],
            'offered'   => [],
            'hired'     => [],
            'rejected'  => [],
        ];

        foreach ($candidates as $cand) {
            $stage = $cand['stage'] ?? 'applied';
            if (isset($pipeline[$stage])) {
                $pipeline[$stage][] = $cand;
            }
        }

        $data = [
            'pageTitle'       => 'Recruitment & Applicant Pipeline',
            'jobs'            => $jobs,
            'candidates'      => $candidates,
            'pipeline'        => $pipeline,
            'departments'     => $departments,
            'designations'    => $designations,
            'totalOpenings'   => $totalOpenings,
            'totalCandidates' => $totalCandidates,
            'interviews'      => $interviews,
            'offeredOrHired'  => $offeredOrHired,
        ];

        return $this->render('recruitment/index', $data);
    }

    /**
     * Store new Job Requisition
     */
    public function storeJob(): ResponseInterface
    {
        $title = trim($this->request->getPost('title') ?? '');
        $deptId = (int)$this->request->getPost('department_id');
        $vacancies = (int)$this->request->getPost('vacancies') ?: 1;
        $jobType = $this->request->getPost('job_type') ?: 'full_time';
        $exp = trim($this->request->getPost('experience_required') ?? '1-3 years');
        $minSal = (float)$this->request->getPost('min_salary');
        $maxSal = (float)$this->request->getPost('max_salary');
        $desc = trim($this->request->getPost('description') ?? '');

        if (empty($title) || empty($deptId)) {
            return redirect()->back()->with('error', 'Job title and department are required.');
        }

        $count = $this->jobModel->countAllResults() + 1;
        $jobCode = 'JOB-' . date('Y') . '-' . str_pad((string)$count, 3, '0', STR_PAD_LEFT);

        $this->jobModel->insert([
            'title'               => $title,
            'job_code'            => $jobCode,
            'department_id'       => $deptId,
            'vacancies'           => $vacancies,
            'job_type'            => $jobType,
            'experience_required' => $exp,
            'min_salary'          => $minSal,
            'max_salary'          => $maxSal,
            'description'         => $desc,
            'status'              => 'open',
            'created_by'          => $this->userId(),
        ]);

        $newJobId = (int)$this->jobModel->getInsertID();
        $this->logAudit('CREATE_JOB', 'job_openings', "Created job requisition {$jobCode} ({$title})", $newJobId);

        return redirect()->to(site_url('recruitment'))->with('success', "Job requisition {$jobCode} created successfully.");
    }

    /**
     * Store new Candidate
     */
    public function storeCandidate(): ResponseInterface
    {
        $jobId = (int)$this->request->getPost('job_opening_id');
        $name = trim($this->request->getPost('full_name') ?? '');
        $email = trim($this->request->getPost('email') ?? '');
        $phone = trim($this->request->getPost('phone') ?? '');
        $exp = (float)$this->request->getPost('experience_years');
        $currComp = trim($this->request->getPost('current_company') ?? '');
        $currCtc = (float)$this->request->getPost('current_ctc');
        $expCtc = (float)$this->request->getPost('expected_ctc');
        $stage = $this->request->getPost('stage') ?: 'applied';

        if (empty($jobId) || empty($name) || empty($email)) {
            return redirect()->back()->with('error', 'Job Opening, Candidate Name, and Email are required.');
        }

        $count = $this->candidateModel->countAllResults() + 1;
        $candCode = 'CAND-' . str_pad((string)$count, 3, '0', STR_PAD_LEFT);

        $this->candidateModel->insert([
            'job_opening_id'     => $jobId,
            'candidate_code'     => $candCode,
            'full_name'          => $name,
            'email'              => $email,
            'phone'              => $phone,
            'experience_years'   => $exp,
            'current_company'    => $currComp,
            'current_ctc'        => $currCtc,
            'expected_ctc'       => $expCtc,
            'stage'              => $stage,
        ]);

        $newCandId = (int)$this->candidateModel->getInsertID();
        $this->logAudit('CREATE_CANDIDATE', 'candidates', "Added candidate {$name} ({$candCode}) to pipeline", $newCandId);

        return redirect()->to(site_url('recruitment'))->with('success', "Candidate application {$candCode} added to pipeline.");
    }

    /**
     * Update Candidate Stage & Evaluation
     */
    public function updateStage(int $candidateId): ResponseInterface
    {
        $candidate = $this->candidateModel->find($candidateId);
        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidate record not found.');
        }

        $stage = $this->request->getPost('stage') ?? $candidate['stage'];
        $rating = (int)($this->request->getPost('scorecard_rating') ?? $candidate['scorecard_rating']);
        $feedback = trim($this->request->getPost('interviewer_feedback') ?? $candidate['interviewer_feedback']);

        $this->candidateModel->update($candidateId, [
            'stage'                => $stage,
            'scorecard_rating'     => $rating,
            'interviewer_feedback' => $feedback,
        ]);

        $this->logAudit('UPDATE_CANDIDATE_STAGE', 'candidates', "Moved candidate #{$candidateId} ({$candidate['full_name']}) to stage '{$stage}'", $candidateId);

        return redirect()->to(site_url('recruitment'))->with('success', "Candidate status updated to " . ucfirst($stage) . ".");
    }

    /**
     * 1-Click Convert Candidate to Full Employee
     */
    public function convertCandidate(int $candidateId): ResponseInterface
    {
        $candidate = $this->candidateModel->find($candidateId);
        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidate not found.');
        }

        if (!empty($candidate['hired_as_employee_id'])) {
            return redirect()->to(site_url('employees/view/' . $candidate['hired_as_employee_id']))
                             ->with('info', 'Candidate is already converted to an active employee.');
        }

        $job = $this->jobModel->find($candidate['job_opening_id']);
        $deptId = $job['department_id'] ?? 1;
        $desigId = $job['designation_id'] ?? 1;

        // Split Name into First and Last
        $parts = explode(' ', trim($candidate['full_name']), 2);
        $firstName = $parts[0];
        $lastName = $parts[1] ?? 'Staff';

        // Auto-generate next Employee Code
        $empModel = new EmployeeModel();
        $lastEmp = $empModel->orderBy('id', 'DESC')->first();
        $nextNum = $lastEmp ? ((int)substr($lastEmp['employee_code'], 3) + 1) : 1;
        $empCode = 'EMP' . str_pad((string)$nextNum, 4, '0', STR_PAD_LEFT);

        $db = \Config\Database::connect();
        $db->transStart();

        // Check if user already exists
        $userModel = new UserModel();
        $existingUser = $userModel->where('email', $candidate['email'])->first();
        if ($existingUser) {
            $userId = (int)$existingUser['id'];
            $username = $existingUser['username'];
        } else {
            $username = strtolower($firstName . '.' . substr($lastName, 0, 1) . rand(10, 99));
            $userId = (int)$userModel->skipValidation(true)->insert([
                'username'      => $username,
                'email'         => $candidate['email'],
                'password_hash' => password_hash('Admin@123', PASSWORD_BCRYPT),
                'role_id'       => 7, // standard employee role (ESS)
                'status'        => 'active',
            ]);
        }

        // Insert into employees table
        $existingEmp = $empModel->where('email', $candidate['email'])->first();
        if ($existingEmp) {
            $empId = (int)$existingEmp['id'];
            $empCode = $existingEmp['employee_code'];
        } else {
            $empId = (int)$empModel->insert([
                'user_id'           => $userId,
                'company_id'        => 1,
                'branch_id'         => 1,
                'department_id'     => $deptId,
                'designation_id'    => $desigId,
                'employee_code'     => $empCode,
                'first_name'        => $firstName,
                'last_name'         => $lastName,
                'email'             => $candidate['email'],
                'official_email'    => strtolower($firstName . '.' . $lastName . '@infosof.com'),
                'phone'             => $candidate['phone'] ?? '+1-555-0100',
                'gender'            => 'other',
                'joining_date'      => date('Y-m-d'),
                'employment_type'   => 'full_time',
                'employment_status' => 'probation',
            ]);

            // Link employee_id back to user
            $userModel->skipValidation(true)->update($userId, ['employee_id' => $empId]);
        }

        // Provision Default Leave Balances
        $leaveTypeModel = new LeaveTypeModel();
        $leaveBalanceModel = new LeaveBalanceModel();
        $leaveTypes = $leaveTypeModel->findAll();
        $currentYear = (int)date('Y');

        foreach ($leaveTypes as $lt) {
            $existingLb = $leaveBalanceModel->where('employee_id', $empId)->where('leave_type_id', $lt['id'])->where('year', $currentYear)->first();
            if (!$existingLb) {
                $leaveBalanceModel->insert([
                    'employee_id'   => $empId,
                    'leave_type_id' => $lt['id'],
                    'year'          => $currentYear,
                    'allocated_days'=> $lt['days_allowed_per_year'],
                    'used_days'     => 0,
                    'pending_days'  => 0,
                    'remaining_days'=> $lt['days_allowed_per_year'],
                ]);
            }
        }

        // Update Candidate record
        $this->candidateModel->update($candidateId, [
            'stage'                => 'hired',
            'hired_as_employee_id' => $empId,
        ]);

        $this->logAudit('HIRE_CANDIDATE_CONVERT', 'employees', "Converted candidate #{$candidateId} ({$candidate['full_name']}) into active employee {$empCode}", (int)$empId);

        $db->transComplete();

        return redirect()->to(site_url('employees/view/' . $empId))
                         ->with('success', "Candidate {$candidate['full_name']} successfully converted to Employee {$empCode}! Default credentials: {$username} / Admin@123");
    }
}
