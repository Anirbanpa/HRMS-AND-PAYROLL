<?php

namespace App\Controllers;

use App\Models\AttendanceModel;
use App\Models\EmployeeModel;
use App\Models\DepartmentModel;
use App\Models\BranchModel;
use App\Models\ShiftModel;

class AttendanceController extends BaseController
{
    /**
     * Daily & Monthly Attendance Register (Module 10)
     */
    public function index()
    {
        $attendanceModel = new AttendanceModel();
        $departmentModel = new DepartmentModel();
        $branchModel     = new BranchModel();
        $shiftModel      = new ShiftModel();

        $selectedDate = $this->request->getGet('date') ?: date('Y-m-d');
        $departmentId = $this->request->getGet('department_id');
        $status       = $this->request->getGet('status');

        $filters = array_filter([
            'date'          => $selectedDate,
            'department_id' => $departmentId,
            'status'        => $status,
        ]);

        $records = $attendanceModel->getDetailedAttendance($filters, 100);

        // Calculate daily stats
        $db = \Config\Database::connect();
        $allToday = $db->table('attendance')->where('date', $selectedDate)->get()->getResultArray();
        $presentCount = 0;
        $lateCount    = 0;
        $halfDayCount = 0;
        foreach ($allToday as $a) {
            if ($a['status'] === 'Present') $presentCount++;
            if ($a['status'] === 'Late') $lateCount++;
            if ($a['status'] === 'Half-Day') $halfDayCount++;
        }

        // Employee ESS: Check if current user has clocked in today
        $userEmployeeId = $this->currentUser['employee_id'] ?? null;
        $myTodayRecord  = null;
        if ($userEmployeeId) {
            $myTodayRecord = $attendanceModel->getTodayRecord((int)$userEmployeeId, date('Y-m-d'));
        }

        $employeeModel   = new EmployeeModel();
        $employees       = $employeeModel->select('id, employee_code, first_name, last_name, department_id')
            ->whereIn('employment_status', ['active', 'probation', 'notice_period'])
            ->where('deleted_at', null)
            ->orderBy('first_name', 'ASC')
            ->findAll();

        // Biometric Hardware Devices Registry
        $biometricDevices = [
            [
                'device_id'   => 'BIO-GATE-01',
                'device_name' => 'Main Turnstile Gateway A',
                'ip_address'  => '192.168.1.201',
                'port'        => 4370,
                'location'    => 'Ground Floor - Main Lobby',
                'status'      => 'Online',
                'last_ping'   => date('H:i:s', strtotime('-2 minutes')),
                'firmware'    => 'ZKTeco BioStation v4.2',
            ],
            [
                'device_id'   => 'BIO-GATE-02',
                'device_name' => 'Basement & Operations Entrance',
                'ip_address'  => '192.168.1.202',
                'port'        => 4370,
                'location'    => 'Basement Service Entrance',
                'status'      => 'Online',
                'last_ping'   => date('H:i:s', strtotime('-5 minutes')),
                'firmware'    => 'eSSL SilkBio 100-TC',
            ],
            [
                'device_id'   => 'BIO-FACIAL-03',
                'device_name' => 'Executive Suite Facial Scanner',
                'ip_address'  => '192.168.1.203',
                'port'        => 8000,
                'location'    => 'Floor 4 - Management Suite',
                'status'      => 'Online',
                'last_ping'   => date('H:i:s', strtotime('-1 minute')),
                'firmware'    => 'Hikvision MinMoe Face DS-K1T671',
            ]
        ];

        // Biometric live punch stream
        $biometricPunches = $db->table('attendance a')
            ->select('a.*, e.employee_code, e.first_name, e.last_name, d.name as department_name')
            ->join('employees e', 'e.id = a.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->where('a.source', 'biometric')
            ->orderBy('a.id', 'DESC')
            ->limit(20)
            ->get()
            ->getResultArray();

        $data = [
            'records'          => $records,
            'selectedDate'     => $selectedDate,
            'departments'      => $departmentModel->findAll(),
            'branches'         => $branchModel->findAll(),
            'shifts'           => $shiftModel->findAll(),
            'employees'        => $employees,
            'presentCount'     => $presentCount,
            'lateCount'        => $lateCount,
            'halfDayCount'     => $halfDayCount,
            'myTodayRecord'    => $myTodayRecord,
            'biometricDevices' => $biometricDevices,
            'biometricPunches' => $biometricPunches,
            'activeTab'        => $this->request->getGet('tab') ?: 'register',
            'filters'          => [
                'department_id' => $departmentId,
                'status'        => $status,
            ],
        ];

        return $this->render('attendance/index', $data, 'Attendance & Time Register');
    }

    /**
     * Manually Record or Adjust Attendance Entry (Module 10)
     */
    public function manualStore()
    {
        if (!$this->hasPermission('attendance.manage')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to manually record or adjust attendance.');
            return redirect()->to(site_url('attendance'));
        }

        $attId      = (int)$this->request->getPost('id');
        $employeeId = (int)$this->request->getPost('employee_id');
        $date       = trim((string)$this->request->getPost('date'));
        $shiftId    = (int)($this->request->getPost('shift_id') ?: 1);
        $status     = trim((string)$this->request->getPost('status')) ?: 'Present';
        $inTimeStr  = trim((string)$this->request->getPost('clock_in'));
        $outTimeStr = trim((string)$this->request->getPost('clock_out'));
        $lateMins   = (int)($this->request->getPost('late_minutes') ?: 0);
        $notes      = trim((string)$this->request->getPost('notes'));

        if (!$employeeId || !$date) {
            $this->session->setFlashdata('error', 'Employee and Date are mandatory.');
            return redirect()->to(site_url('attendance'));
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $this->session->setFlashdata('error', 'Invalid date format provided.');
            return redirect()->to(site_url('attendance'));
        }

        // Format timestamps
        $clockIn    = null;
        $clockOut   = null;
        $totalHours = 0.00;

        if ($inTimeStr !== '' && !in_array($status, ['Absent', 'On Leave', 'Holiday', 'Week Off'], true)) {
            $clockIn = $date . ' ' . (strlen($inTimeStr) === 5 ? $inTimeStr . ':00' : $inTimeStr);
        }

        if ($outTimeStr !== '' && !in_array($status, ['Absent', 'On Leave', 'Holiday', 'Week Off'], true)) {
            $outDate = $date;
            // Cross-midnight adjustment
            if ($inTimeStr !== '' && strtotime($outTimeStr) < strtotime($inTimeStr)) {
                $outDate = date('Y-m-d', strtotime($date . ' +1 day'));
            }
            $clockOut = $outDate . ' ' . (strlen($outTimeStr) === 5 ? $outTimeStr . ':00' : $outTimeStr);
        }

        if ($clockIn && $clockOut) {
            $diffSeconds = max(0, strtotime($clockOut) - strtotime($clockIn));
            $totalHours  = round($diffSeconds / 3600, 2);
        }

        // Auto-calculate late minutes if status is Late and late_minutes is not manually set
        if ($clockIn && $lateMins === 0 && $status === 'Late') {
            $shiftStart = strtotime($date . ' 09:00:00');
            $clockInTs  = strtotime($clockIn);
            if ($clockInTs > ($shiftStart + (15 * 60))) {
                $lateMins = (int)round(($clockInTs - $shiftStart) / 60);
            }
        }

        $attendanceModel = new AttendanceModel();

        // Check if existing record by ID or by (employee_id, date)
        $existing = null;
        if ($attId > 0) {
            $existing = $attendanceModel->find($attId);
        }
        if (!$existing) {
            $existing = $attendanceModel->where('employee_id', $employeeId)->where('date', $date)->first();
        }

        $payload = [
            'employee_id'           => $employeeId,
            'date'                  => $date,
            'shift_id'              => $shiftId ?: 1,
            'clock_in'              => $clockIn,
            'clock_out'             => $clockOut,
            'total_hours'           => $totalHours,
            'late_minutes'          => $lateMins,
            'early_leaving_minutes' => 0,
            'status'                => $status,
            'source'                => 'manual_adjustment',
            'notes'                 => $notes ?: 'Manually recorded by HR / Supervisor',
        ];

        if ($existing) {
            $attendanceModel->update($existing['id'], $payload);
            $this->logAudit('MANUAL_ATTENDANCE_UPDATE', 'attendance', "Updated attendance for Employee #{$employeeId} on {$date} (Status: {$status})", $existing['id']);
            $this->session->setFlashdata('success', "Attendance record for {$date} updated successfully.");
        } else {
            $recordId = $attendanceModel->insert($payload);
            $this->logAudit('MANUAL_ATTENDANCE_INSERT', 'attendance', "Manually entered attendance for Employee #{$employeeId} on {$date} (Status: {$status})", $recordId);
            $this->session->setFlashdata('success', "Manual attendance for {$date} saved successfully.");
        }

        return redirect()->to(site_url("attendance?date={$date}"));
    }

    /**
     * Employee Self-Service Web Clock-In / Clock-Out (Module 10)
     */
    public function clock()
    {
        $employeeId = $this->currentUser['employee_id'] ?? null;
        if (!$employeeId) {
            $this->session->setFlashdata('error', 'No active employee profile linked to your user account.');
            return redirect()->back();
        }

        $attendanceModel = new AttendanceModel();
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        $ip = $this->request->getIPAddress();

        $existing = $attendanceModel->getTodayRecord((int)$employeeId, $today);

        if (!$existing) {
            // CLOCK IN
            // Standard shift starts at 09:00 with 15 min grace (after 09:15 is Late)
            $shiftStart = strtotime($today . ' 09:00:00');
            $clockTime  = strtotime($now);
            $lateMins   = 0;
            $status     = 'Present';

            if ($clockTime > ($shiftStart + (15 * 60))) {
                $lateMins = (int)round(($clockTime - $shiftStart) / 60);
                $status   = 'Late';
            }

            $id = $attendanceModel->insert([
                'employee_id'   => $employeeId,
                'date'          => $today,
                'shift_id'      => 1,
                'clock_in'      => $now,
                'status'        => $status,
                'late_minutes'  => $lateMins,
                'clock_in_ip'   => $ip,
                'source'        => 'web',
            ]);

            $this->logAudit('CLOCK_IN', 'attendance', "Employee #{$employeeId} clocked IN at " . date('H:i:s'), $id);
            $this->session->setFlashdata('success', "Clocked IN successfully at " . date('H:i:s') . ($status === 'Late' ? " (Late by {$lateMins} minutes)" : ""));
        } elseif (empty($existing['clock_out'])) {
            // CLOCK OUT
            $inTime = strtotime($existing['clock_in']);
            $outTime = strtotime($now);
            $diffSeconds = max(0, $outTime - $inTime);
            $hours = round($diffSeconds / 3600, 2);

            $status = $existing['status'];
            if ($hours < 4.5 && $status !== 'Late') {
                $status = 'Half-Day';
            }

            $attendanceModel->update($existing['id'], [
                'clock_out'    => $now,
                'total_hours'  => $hours,
                'clock_out_ip' => $ip,
                'status'       => $status,
            ]);

            $this->logAudit('CLOCK_OUT', 'attendance', "Employee #{$employeeId} clocked OUT at " . date('H:i:s') . " (Total {$hours} hrs)", $existing['id']);
            $this->session->setFlashdata('success', "Clocked OUT successfully at " . date('H:i:s') . ". Total logged today: {$hours} hours.");
        } else {
            $this->session->setFlashdata('error', 'You have already completed your clock-in and clock-out cycles for today.');
        }

        return redirect()->back();
    }

    /**
     * REST API Biometric Device Ingestion Webhook (Module 11)
     */
    public function biometricPunch()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();

        $employeeCode = trim((string)($json['employee_code'] ?? ''));
        $punchType    = strtoupper((string)($json['punch_type'] ?? 'IN'));
        $punchTime    = $json['timestamp'] ?? date('Y-m-d H:i:s');
        $deviceId     = $json['device_id'] ?? 'BIO-GATE-01';

        if (empty($employeeCode)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'employee_code is required'])->setStatusCode(400);
        }

        $empModel = new EmployeeModel();
        $employee = $empModel->where('employee_code', $employeeCode)->first();
        if (!$employee) {
            return $this->response->setJSON(['status' => 'error', 'message' => "Employee '{$employeeCode}' not found"])->setStatusCode(404);
        }

        $attendanceModel = new AttendanceModel();
        $date = date('Y-m-d', strtotime($punchTime));
        $existing = $attendanceModel->getTodayRecord((int)$employee['id'], $date);

        if ($punchType === 'IN') {
            if (!$existing) {
                $attendanceModel->insert([
                    'employee_id' => $employee['id'],
                    'date'        => $date,
                    'shift_id'    => 1,
                    'clock_in'    => $punchTime,
                    'status'      => 'Present',
                    'source'      => 'biometric',
                    'notes'       => "Biometric device: {$deviceId}",
                ]);
            }
        } else {
            if ($existing) {
                $inTime = strtotime($existing['clock_in']);
                $outTime = strtotime($punchTime);
                $hours = round(($outTime - $inTime) / 3600, 2);

                $attendanceModel->update($existing['id'], [
                    'clock_out'   => $punchTime,
                    'total_hours' => $hours,
                    'source'      => 'biometric',
                    'notes'       => ($existing['notes'] ?? '') . " | Out: {$deviceId}",
                ]);
            }
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => "Biometric punch {$punchType} recorded for {$employeeCode} from device {$deviceId}.",
        ]);
    }

    /**
     * UI Trigger for Biometric Device Punch Simulation & Test
     */
    public function triggerBiometricTest()
    {
        if (!$this->hasRole(['super_admin', 'hr_admin', 'manager'])) {
            $this->session->setFlashdata('error', 'Unauthorized.');
            return redirect()->to(site_url('attendance?tab=biometric'));
        }

        $employeeCode = trim((string)$this->request->getPost('employee_code'));
        $punchType    = strtoupper((string)$this->request->getPost('punch_type') ?: 'IN');
        $deviceId     = trim((string)$this->request->getPost('device_id') ?: 'BIO-GATE-01');

        $empModel = new EmployeeModel();
        $employee = $empModel->where('employee_code', $employeeCode)->first();
        if (!$employee) {
            $this->session->setFlashdata('error', "Employee code '{$employeeCode}' not found.");
            return redirect()->to(site_url('attendance?tab=biometric'));
        }

        $attendanceModel = new AttendanceModel();
        $date = date('Y-m-d');
        $punchTime = date('Y-m-d H:i:s');
        $existing = $attendanceModel->getTodayRecord((int)$employee['id'], $date);

        if ($punchType === 'IN') {
            if (!$existing) {
                $attendanceModel->insert([
                    'employee_id' => $employee['id'],
                    'date'        => $date,
                    'shift_id'    => 1,
                    'clock_in'    => $punchTime,
                    'status'      => 'Present',
                    'source'      => 'biometric',
                    'notes'       => "Biometric device: {$deviceId}",
                ]);
            } else {
                $attendanceModel->update($existing['id'], [
                    'clock_in' => $punchTime,
                    'source'   => 'biometric',
                    'notes'    => ($existing['notes'] ?? '') . " | Sync In: {$deviceId}",
                ]);
            }
        } else {
            if ($existing) {
                $inTime = strtotime($existing['clock_in'] ?: $punchTime);
                $outTime = strtotime($punchTime);
                $hours = max(0.5, round(($outTime - $inTime) / 3600, 2));

                $attendanceModel->update($existing['id'], [
                    'clock_out'   => $punchTime,
                    'total_hours' => $hours,
                    'source'      => 'biometric',
                    'notes'       => ($existing['notes'] ?? '') . " | Out: {$deviceId}",
                ]);
            } else {
                $attendanceModel->insert([
                    'employee_id' => $employee['id'],
                    'date'        => $date,
                    'shift_id'    => 1,
                    'clock_in'    => date('Y-m-d 09:00:00'),
                    'clock_out'   => $punchTime,
                    'total_hours' => 8.0,
                    'status'      => 'Present',
                    'source'      => 'biometric',
                    'notes'       => "Biometric device Out: {$deviceId}",
                ]);
            }
        }

        $this->session->setFlashdata('success', "Simulated biometric {$punchType} punch from {$deviceId} for {$employee['first_name']} {$employee['last_name']} ({$employeeCode}) recorded successfully!");
        return redirect()->to(site_url('attendance?tab=biometric'));
    }
}
