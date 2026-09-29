<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\DepartmentModel;
use App\Models\BranchModel;
use App\Models\ActivityLogModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $employeeModel = new EmployeeModel();
        $departmentModel = new DepartmentModel();
        $branchModel = new BranchModel();
        $activityLogModel = new ActivityLogModel();

        // Core Aggregate Metrics
        $totalHeadcount = $employeeModel->countFiltered(['deleted_at' => null]);
        $activeEmployees = $employeeModel->countFiltered(['employment_status' => 'active', 'deleted_at' => null]);
        $totalDepartments = $departmentModel->countAllResults();
        $totalBranches = $branchModel->countAllResults();

        // Monthly Payroll Figures (From latest run or salary structures estimate)
        $latestRun = $db->table('payroll_runs')->orderBy('id', 'DESC')->get()->getFirstRow('array');
        if ($latestRun && (float)$latestRun['total_gross'] > 0) {
            $monthlyGross = (float)$latestRun['total_gross'];
            $monthlyNet   = (float)$latestRun['total_net'];
        } else {
            $payrollEstimate = $db->table('salary_structures ss')
                ->join('employees e', 'e.id = ss.employee_id')
                ->where('e.deleted_at', null)
                ->where('e.employment_status', 'active')
                ->selectSum('ss.gross_salary', 'total_gross')
                ->selectSum('ss.net_salary', 'total_net')
                ->get()
                ->getFirstRow('array');
            $monthlyGross = (float)($payrollEstimate['total_gross'] ?? 0);
            $monthlyNet   = (float)($payrollEstimate['total_net'] ?? 0);
        }

        // Today's Attendance Snapshot
        $today = date('Y-m-d');
        $attendanceStats = $db->table('attendance')
            ->select('status, COUNT(*) as count')
            ->where('date', $today)
            ->groupBy('status')
            ->get()
            ->getResultArray();

        $presentToday = 0;
        foreach ($attendanceStats as $stat) {
            if ($stat['status'] === 'Present') {
                $presentToday = (int)$stat['count'];
            }
        }

        // Pending Leave Requests
        $pendingLeaves = $db->table('leave_requests')
            ->where('status', 'pending')
            ->countAllResults();

        // Department Headcount Breakdown
        $departmentsWithStats = $departmentModel->getDepartmentsWithStats();

        // Recent 5 Employees
        $recentEmployees = $employeeModel->getDetailedList([], 5, 0);

        // Recent 8 Activity Logs
        $recentLogs = $activityLogModel->getRecentLogs(8);

        // Employee ESS Profile Data if viewing as Employee
        $employeeEss = null;
        if ($this->hasRole(['employee']) && !empty($this->currentUser['employee_id'])) {
            $employeeEss = $employeeModel->get360Profile((int)$this->currentUser['employee_id']);
        }

        $data = [
            'totalHeadcount'        => $totalHeadcount,
            'activeEmployees'       => $activeEmployees,
            'totalDepartments'      => $totalDepartments,
            'totalBranches'         => $totalBranches,
            'monthlyGrossPayroll'   => $monthlyGross,
            'monthlyNetPayroll'     => $monthlyNet,
            'presentToday'          => $presentToday,
            'pendingLeaves'         => $pendingLeaves,
            'departmentsWithStats'  => $departmentsWithStats,
            'recentEmployees'       => $recentEmployees,
            'recentLogs'            => $recentLogs,
            'employeeEss'           => $employeeEss,
        ];

        return $this->render('dashboard/index', $data, 'Enterprise HRMS Dashboard');
    }
}
