<?php

namespace App\Controllers;

use App\Models\LateEarlyPolicyModel;
use App\Models\AttendanceTimeWaiverModel;
use App\Models\AttendanceModel;
use App\Models\EmployeeModel;

/**
 * Class LateEarlyController
 *
 * Module 16: Late Coming & Early Leaving Management
 */
class LateEarlyController extends BaseController
{
    /**
     * Late Coming & Early Leaving Dashboard & Waivers Hub
     */
    public function index()
    {
        $policyModel = new LateEarlyPolicyModel();
        $waiverModel = new AttendanceTimeWaiverModel();
        $attModel    = new AttendanceModel();
        $empModel    = new EmployeeModel();

        $policies    = $policyModel->where('company_id', 1)->findAll();
        $activePolicy= $policyModel->where('is_active', 1)->first() ?? [
            'grace_period_mins' => 15,
            'early_exit_tolerance_mins' => 15,
            'max_monthly_late_count' => 3,
            'deduction_rule' => 'half_day',
            'deduction_rate' => 0.50
        ];

        $currentEmpId = $this->currentUser['employee_id'] ?? null;
        $isHR         = $this->hasRole(['super_admin', 'hr_admin', 'hr_executive', 'payroll_manager']);
        $isManager    = $this->hasRole(['manager']);

        $selectedMonth = $this->request->getGet('month') ?: date('Y-m');
        $startDate     = $selectedMonth . '-01';
        $endDate       = date('Y-m-t', strtotime($startDate));

        // 1. Fetch Late / Early Attendance Records
        $db = \Config\Database::connect();
        $builder = $db->table('attendance a')
            ->select('a.*, e.first_name, e.last_name, e.employee_code, d.name as department_name, s.name as shift_name, s.start_time as shift_start, s.end_time as shift_end')
            ->join('employees e', 'e.id = a.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('shifts s', 's.id = a.shift_id', 'left')
            ->where('a.date >=', $startDate)
            ->where('a.date <=', $endDate)
            ->groupStart()
                ->where('a.late_minutes >', 0)
                ->orWhere('a.early_leaving_minutes >', 0)
            ->groupEnd();

        if (!$isHR && !$isManager && $currentEmpId) {
            $builder->where('a.employee_id', $currentEmpId);
        } elseif ($isManager && !$isHR && $currentEmpId) {
            $builder->where('e.reporting_to', $currentEmpId);
        }

        $flaggedLogs = $builder->orderBy('a.date', 'DESC')->get()->getResultArray();

        // 2. Fetch Waivers
        $waiverFilters = [];
        if (!$isHR && !$isManager && $currentEmpId) {
            $waiverFilters['employee_id'] = $currentEmpId;
        } elseif ($isManager && !$isHR && $currentEmpId) {
            $waiverFilters['manager_id'] = $currentEmpId;
        }
        $waivers = $waiverModel->getDetailedWaivers($waiverFilters, 50);

        // 3. Compute Metrics
        $totalLateMinutes  = 0;
        $totalEarlyMinutes = 0;
        $lateCount         = 0;
        $earlyCount        = 0;
        $waivedCount       = 0;

        foreach ($flaggedLogs as $log) {
            if ($log['late_minutes'] > 0) {
                $lateCount++;
                $totalLateMinutes += (int)$log['late_minutes'];
            }
            if ($log['early_leaving_minutes'] > 0) {
                $earlyCount++;
                $totalEarlyMinutes += (int)$log['early_leaving_minutes'];
            }
            if (!empty($log['late_waived']) || !empty($log['early_exit_waived'])) {
                $waivedCount++;
            }
        }

        // Available employees for manual waiver / admin assignment
        $employees = $isHR ? $empModel->whereIn('employment_status', ['active', 'probation'])->findAll() : [];

        $data = [
            'policies'          => $policies,
            'activePolicy'      => $activePolicy,
            'flaggedLogs'       => $flaggedLogs,
            'waivers'           => $waivers,
            'selectedMonth'     => $selectedMonth,
            'totalLateMinutes'  => $totalLateMinutes,
            'totalEarlyMinutes' => $totalEarlyMinutes,
            'lateCount'         => $lateCount,
            'earlyCount'        => $earlyCount,
            'waivedCount'       => $waivedCount,
            'isHR'              => $isHR,
            'isManager'         => $isManager,
            'employees'         => $employees,
        ];

        return $this->render('attendance/late_early', $data, 'Late Coming & Early Leaving Management');
    }

    /**
     * Configure or Update Attendance Policy
     */
    public function savePolicy()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin'])) {
            $this->session->setFlashdata('error', 'Unauthorized to modify late/early policies.');
            return redirect()->to(site_url('attendance/late-early'));
        }

        $policyModel = new LateEarlyPolicyModel();
        $id          = $this->request->getPost('id');

        $data = [
            'company_id'                => 1,
            'name'                      => trim((string)$this->request->getPost('name')),
            'policy_code'               => strtoupper(trim((string)$this->request->getPost('policy_code'))),
            'grace_period_mins'         => (int)$this->request->getPost('grace_period_mins'),
            'early_exit_tolerance_mins' => (int)$this->request->getPost('early_exit_tolerance_mins'),
            'max_monthly_late_count'    => (int)$this->request->getPost('max_monthly_late_count'),
            'deduction_rule'            => $this->request->getPost('deduction_rule'),
            'deduction_rate'            => (float)$this->request->getPost('deduction_rate'),
            'is_active'                 => 1,
        ];

        if ($id) {
            $policyModel->update((int)$id, $data);
            $this->session->setFlashdata('success', 'Late coming & early leaving policy updated successfully.');
        } else {
            $policyModel->insert($data);
            $this->session->setFlashdata('success', 'New attendance threshold policy created.');
        }

        $this->logAudit('SAVE_LATE_POLICY', 'attendance', "Configured policy {$data['name']}");
        return redirect()->to(site_url('attendance/late-early'));
    }

    /**
     * Request a Waiver for a Flagged Punch
     */
    public function requestWaiver()
    {
        $waiverModel = new AttendanceTimeWaiverModel();
        $attModel    = new AttendanceModel();

        $attId   = (int)$this->request->getPost('attendance_id');
        $reason  = trim((string)$this->request->getPost('reason'));
        $type    = $this->request->getPost('waiver_type') ?: 'late_arrival';

        $att = $attModel->find($attId);
        if (!$att) {
            $this->session->setFlashdata('error', 'Attendance record not found.');
            return redirect()->to(site_url('attendance/late-early'));
        }

        $minutes = ($type === 'late_arrival') ? (int)($att['late_minutes'] ?? 0) : (int)($att['early_leaving_minutes'] ?? 0);
        if ($type === 'both') {
            $minutes = (int)($att['late_minutes'] ?? 0) + (int)($att['early_leaving_minutes'] ?? 0);
        }

        $waiverModel->insert([
            'attendance_id'    => $attId,
            'employee_id'      => $att['employee_id'],
            'waiver_type'      => $type,
            'waiver_date'      => $att['date'],
            'minutes_recorded' => $minutes,
            'reason'           => $reason,
            'status'           => 'pending',
        ]);

        $this->logAudit('WAIVER_REQUEST', 'attendance', "Requested waiver for attendance log ID {$attId}");
        $this->session->setFlashdata('success', 'Waiver request submitted for managerial review.');
        return redirect()->to(site_url('attendance/late-early'));
    }

    /**
     * Approve or Reject a Waiver Request
     */
    public function actionWaiver(int $id)
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized to action attendance waivers.');
            return redirect()->to(site_url('attendance/late-early'));
        }

        $waiverModel = new AttendanceTimeWaiverModel();
        $attModel    = new AttendanceModel();

        $waiver = $waiverModel->find($id);
        if (!$waiver) {
            $this->session->setFlashdata('error', 'Waiver request not found.');
            return redirect()->to(site_url('attendance/late-early'));
        }

        $action   = $this->request->getPost('action'); // approve or reject
        $remarks  = trim((string)$this->request->getPost('remarks')) ?: 'Processed by supervisor';
        $now      = date('Y-m-d H:i:s');
        $isAdmin  = $this->hasRole(['super_admin', 'hr_admin']);
        $newStatus= ($action === 'approve') ? ($isAdmin ? 'hr_approved' : 'manager_approved') : 'rejected';

        $db = \Config\Database::connect();
        $db->transStart();

        $waiverModel->update($id, [
            'status'            => $newStatus,
            'manager_id'        => $this->currentUser['employee_id'] ?? null,
            'manager_action_at' => $now,
            'manager_remarks'   => $remarks,
            'hr_id'             => $isAdmin ? $this->userId() : null,
            'hr_action_at'      => $isAdmin ? $now : null,
            'hr_remarks'        => $isAdmin ? $remarks : null,
        ]);

        if ($action === 'approve') {
            $updateData = [
                'waived_by'     => $this->userId(),
                'waived_reason' => $remarks,
                'waived_at'     => $now,
            ];
            if ($waiver['waiver_type'] === 'late_arrival' || $waiver['waiver_type'] === 'both') {
                $updateData['late_waived'] = 1;
            }
            if ($waiver['waiver_type'] === 'early_departure' || $waiver['waiver_type'] === 'both') {
                $updateData['early_exit_waived'] = 1;
            }
            $attModel->update($waiver['attendance_id'], $updateData);
        }

        $db->transComplete();

        $this->logAudit('WAIVER_ACTION', 'attendance', "Marked waiver #{$id} as {$newStatus}");
        $this->session->setFlashdata('success', "Waiver request #{$id} has been " . ucfirst($action) . "d.");
        return redirect()->to(site_url('attendance/late-early'));
    }
}
