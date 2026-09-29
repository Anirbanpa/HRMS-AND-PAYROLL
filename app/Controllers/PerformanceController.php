<?php

namespace App\Controllers;

use App\Models\PerformanceCycleModel;
use App\Models\PerformanceGoalModel;
use App\Models\EmployeeAppraisalModel;
use App\Models\EmployeeModel;

/**
 * Class PerformanceController
 *
 * Module 28: Performance Management, OKRs & Appraisals
 */
class PerformanceController extends BaseController
{
    /**
     * Performance Cycles, Goals & Appraisals Dashboard
     */
    public function index()
    {
        $cycleModel     = new PerformanceCycleModel();
        $goalModel      = new PerformanceGoalModel();
        $appraisalModel = new EmployeeAppraisalModel();
        $empModel       = new EmployeeModel();
        $db             = \Config\Database::connect();

        $cycles = $cycleModel->orderBy('id', 'DESC')->findAll();
        if (empty($cycles)) {
            $cycleModel->insert([
                'company_id'              => 1,
                'title'                   => 'Annual Appraisal Cycle ' . date('Y') . '-' . (date('Y') + 1),
                'cycle_type'              => 'annual',
                'start_date'              => date('Y-04-01'),
                'end_date'                => date((date('Y') + 1) . '-03-31'),
                'self_review_deadline'    => date((date('Y') + 1) . '-03-15'),
                'manager_review_deadline' => date((date('Y') + 1) . '-03-25'),
                'status'                  => 'active',
                'description'             => 'Corporate Annual Performance Review, OKR Evaluation & Merit Appraisal Cycle',
            ]);
            $cycles = $cycleModel->orderBy('id', 'DESC')->findAll();
        }
        $selectedCycleId = (int)($this->request->getGet('cycle_id') ?: ($cycles[0]['id'] ?? 1));
        $currentEmpId   = $this->currentUser['employee_id'] ?? null;
        $isHR           = $this->hasRole(['super_admin', 'hr_admin', 'hr_executive']);
        $isManager      = $this->hasRole(['manager']);

        // 1. My Goals & Appraisal for selected cycle
        $myGoals = [];
        $myAppraisal = null;
        if ($currentEmpId && !empty($cycles)) {
            $myGoals = $goalModel->where('employee_id', $currentEmpId)
                ->where('cycle_id', $selectedCycleId)
                ->findAll();
            $myAppraisal = $appraisalModel->where('employee_id', $currentEmpId)
                ->where('cycle_id', $selectedCycleId)
                ->first();
        }

        // 2. Team Appraisals under review for Managers and HR
        $teamAppraisals = [];
        if ($isHR || $isManager) {
            $builder = $db->table('employees e')
                ->select('e.id as employee_id, e.first_name, e.last_name, e.employee_code, d.name as department_name, des.name as designation_name, ea.id as appraisal_id, ea.overall_self_score, ea.overall_manager_score, ea.final_rating_band, ea.promotion_recommended, ea.recommended_increment_percent, ea.status as appraisal_status')
                ->join('departments d', 'd.id = e.department_id', 'left')
                ->join('designations des', 'des.id = e.designation_id', 'left')
                ->join('employee_appraisals ea', "ea.employee_id = e.id AND ea.cycle_id = {$selectedCycleId}", 'left')
                ->where('e.employment_status', 'active')
                ->where('e.deleted_at', null);

            if (!$isHR && $currentEmpId) {
                $builder->where('e.reporting_to', $currentEmpId);
            }

            $teamAppraisals = $builder->orderBy('e.first_name', 'ASC')->get()->getResultArray();
        }

        $employees = $empModel->where('employment_status', 'active')->where('deleted_at', null)->findAll();

        $data = [
            'cycles'          => $cycles,
            'selectedCycleId' => $selectedCycleId,
            'myGoals'         => $myGoals,
            'myAppraisal'     => $myAppraisal,
            'teamAppraisals'  => $teamAppraisals,
            'employees'       => $employees,
            'isHR'            => $isHR,
            'isManager'       => $isManager,
        ];

        return $this->render('performance/index', $data, 'Performance Management & Appraisals');
    }

    /**
     * Submit Goal / KPI for Current Cycle
     */
    public function storeGoal()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee linked.');
            return redirect()->to(site_url('performance'));
        }

        $rules = [
            'cycle_id'          => 'required|numeric',
            'title'             => 'required|min_length[3]|max_length[150]',
            'weightage_percent' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            $this->session->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            return redirect()->to(site_url('performance'));
        }

        $cycleModel = new PerformanceCycleModel();
        $cycleId = (int)$this->request->getPost('cycle_id');
        $cycle = $cycleModel->find($cycleId);
        if (!$cycle) {
            $activeCycle = $cycleModel->where('status', 'active')->first() ?: $cycleModel->first();
            if ($activeCycle) {
                $cycleId = (int)$activeCycle['id'];
            } else {
                $cycleId = $cycleModel->insert([
                    'company_id'              => 1,
                    'title'                   => 'Annual Appraisal Cycle ' . date('Y') . '-' . (date('Y') + 1),
                    'cycle_type'              => 'annual',
                    'start_date'              => date('Y-04-01'),
                    'end_date'                => date((date('Y') + 1) . '-03-31'),
                    'self_review_deadline'    => date((date('Y') + 1) . '-03-15'),
                    'manager_review_deadline' => date((date('Y') + 1) . '-03-25'),
                    'status'                  => 'active',
                    'description'             => 'Corporate Annual Performance Review, OKR Evaluation & Merit Appraisal Cycle',
                ]);
            }
        }

        $goalModel = new PerformanceGoalModel();
        $goalModel->insert([
            'cycle_id'          => $cycleId,
            'employee_id'       => $employeeId,
            'title'             => $this->request->getPost('title'),
            'description'       => $this->request->getPost('description'),
            'weightage_percent' => (float)$this->request->getPost('weightage_percent'),
            'target_metric'     => $this->request->getPost('target_metric'),
            'status'            => 'draft',
        ]);

        $this->logAudit('GOAL_CREATE', 'performance', "Created goal {$this->request->getPost('title')}");
        $this->session->setFlashdata('success', 'Goal / KPI created successfully.');
        return redirect()->to(site_url('performance?cycle_id=' . $cycleId));
    }

    /**
     * Create New Performance Cycle (HR Admin)
     */
    public function storeCycle()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to create performance cycles.');
            return redirect()->to(site_url('performance'));
        }

        $title = trim($this->request->getPost('title') ?? '');
        $start = $this->request->getPost('start_date');
        $end   = $this->request->getPost('end_date');

        if (empty($title) || empty($start) || empty($end)) {
            $this->session->setFlashdata('error', 'Title, Start Date, and End Date are required.');
            return redirect()->to(site_url('performance'));
        }

        $cycleModel = new PerformanceCycleModel();
        $newId = $cycleModel->insert([
            'company_id'              => 1,
            'title'                   => $title,
            'cycle_type'              => $this->request->getPost('cycle_type') ?: 'annual',
            'start_date'              => $start,
            'end_date'                => $end,
            'self_review_deadline'    => $this->request->getPost('self_review_deadline') ?: $end,
            'manager_review_deadline' => $this->request->getPost('manager_review_deadline') ?: $end,
            'status'                  => 'active',
            'description'             => $this->request->getPost('description') ?: 'Enterprise performance appraisal cycle',
        ]);

        $this->logAudit('CYCLE_CREATE', 'performance', "Created appraisal cycle {$title}", $newId);
        $this->session->setFlashdata('success', "Appraisal Cycle '{$title}' created.");
        return redirect()->to(site_url('performance?cycle_id=' . $newId));
    }

    /**
     * Submit Self-Assessment on Goals & Overall Appraisal
     */
    public function submitSelfReview()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee linked.');
            return redirect()->to(site_url('performance'));
        }

        $cycleId = (int)$this->request->getPost('cycle_id');
        $cycleModel     = new PerformanceCycleModel();
        $cycle = $cycleModel->find($cycleId);
        if (!$cycle) {
            $activeCycle = $cycleModel->where('status', 'active')->first() ?: $cycleModel->first();
            $cycleId = (int)($activeCycle['id'] ?? 1);
        }

        $goalRatings = (array)$this->request->getPost('goal_ratings');
        $goalComments = (array)$this->request->getPost('goal_comments');
        $overallScore = (float)$this->request->getPost('overall_self_score');

        $goalModel      = new PerformanceGoalModel();
        $appraisalModel = new EmployeeAppraisalModel();

        // Update each goal's self rating
        foreach ($goalRatings as $goalId => $rating) {
            $goal = $goalModel->where('id', (int)$goalId)->where('employee_id', $employeeId)->first();
            if ($goal) {
                $goalModel->update((int)$goalId, [
                    'self_rating'   => (float)$rating,
                    'self_comments' => $goalComments[$goalId] ?? null,
                    'status'        => 'self_reviewed',
                ]);
            }
        }

        // Create or update employee_appraisals record
        $existing = $appraisalModel->where('employee_id', $employeeId)->where('cycle_id', $cycleId)->first();
        if ($existing) {
            $appraisalModel->update($existing['id'], [
                'overall_self_score' => $overallScore,
                'status'             => 'self_submitted',
            ]);
        } else {
            $empModel = new EmployeeModel();
            $emp = $empModel->find($employeeId);

            $appraisalModel->insert([
                'cycle_id'            => $cycleId,
                'employee_id'         => $employeeId,
                'reviewer_manager_id' => $emp['reporting_to'] ?? 1,
                'overall_self_score'  => $overallScore,
                'status'              => 'self_submitted',
            ]);
        }

        $this->logAudit('SELF_APPRAISAL_SUBMIT', 'performance', "Submitted self-assessment (Score: {$overallScore}) for cycle #{$cycleId}");
        $this->session->setFlashdata('success', 'Self-assessment ratings submitted successfully.');
        return redirect()->to(site_url('performance?cycle_id=' . $cycleId));
    }

    /**
     * Submit Manager Review & Rating Band for Direct Report
     */
    public function submitManagerReview()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to submit managerial evaluations.');
            return redirect()->to(site_url('performance'));
        }

        $employeeId = (int)$this->request->getPost('employee_id');
        $cycleId    = (int)$this->request->getPost('cycle_id');
        $cycleModel = new PerformanceCycleModel();
        $cycle = $cycleModel->find($cycleId);
        if (!$cycle) {
            $activeCycle = $cycleModel->where('status', 'active')->first() ?: $cycleModel->first();
            $cycleId = (int)($activeCycle['id'] ?? 1);
        }
        $mgrScore   = (float)$this->request->getPost('overall_manager_score');
        $ratingBand = $this->request->getPost('final_rating_band') ?: 'Meets Expectations';
        $promoRec   = (int)$this->request->getPost('promotion_recommended');
        $increment  = (float)$this->request->getPost('recommended_increment_percent');
        $strengths  = trim($this->request->getPost('key_strengths') ?? '');
        $devAreas   = trim($this->request->getPost('development_areas') ?? '');

        $appraisalModel = new EmployeeAppraisalModel();
        $existing = $appraisalModel->where('employee_id', $employeeId)->where('cycle_id', $cycleId)->first();

        $appraisalData = [
            'reviewer_manager_id'           => $this->currentUser['employee_id'] ?? 1,
            'overall_manager_score'         => $mgrScore,
            'final_rating_band'             => $ratingBand,
            'promotion_recommended'         => $promoRec,
            'recommended_increment_percent' => $increment,
            'key_strengths'                 => $strengths,
            'development_areas'             => $devAreas,
            'status'                        => 'completed',
            'completed_at'                  => date('Y-m-d H:i:s'),
        ];

        if ($existing) {
            $appraisalModel->update($existing['id'], $appraisalData);
        } else {
            $appraisalData['cycle_id']    = $cycleId;
            $appraisalData['employee_id'] = $employeeId;
            $appraisalModel->insert($appraisalData);
        }

        // Update goals with manager rating if provided
        $goalRatings = (array)$this->request->getPost('mgr_goal_ratings');
        $goalComments = (array)$this->request->getPost('mgr_goal_comments');
        $goalModel = new PerformanceGoalModel();
        foreach ($goalRatings as $gId => $rVal) {
            $goalModel->update((int)$gId, [
                'manager_rating'   => (float)$rVal,
                'manager_comments' => $goalComments[$gId] ?? null,
                'status'           => 'evaluated',
            ]);
        }

        // Notify employee
        $notifService = new \App\Libraries\NotificationService();
        $notifService->send('appraisal_assigned', $employeeId, [
            '{{DETAILS}}'     => "Manager appraisal completed. Rating Band: {$ratingBand}",
            '{{ACTION_DATE}}' => date('F j, Y'),
        ], ['in_app', 'email']);

        $this->logAudit('MANAGER_APPRAISAL_SUBMIT', 'performance', "Completed manager appraisal for employee #{$employeeId} (Band: {$ratingBand})");
        $this->session->setFlashdata('success', "Manager review and appraisal band '{$ratingBand}' saved successfully.");
        return redirect()->to(site_url('performance?cycle_id=' . $cycleId));
    }
}
