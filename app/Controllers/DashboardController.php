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

        $roleSlug = $this->currentUser['role_slug'] ?? 'super_admin';
        $currentEmpId = (int)($this->currentUser['employee_id'] ?? 0);
        $today = date('Y-m-d');

        // Core Aggregate Metrics (Company level)
        $totalHeadcount = $employeeModel->countFiltered(['deleted_at' => null]);
        $activeEmployees = $employeeModel->where('deleted_at', null)->whereIn('employment_status', ['active', 'probation'])->countAllResults();
        $totalDepartments = $departmentModel->countAllResults();
        $totalBranches = $branchModel->countAllResults();

        // 1. Employee-specific data (for ESS dashboard)
        $employeeData = [];
        if ($currentEmpId > 0) {
            $employee = $employeeModel->get360Profile($currentEmpId);
            $todayPunch = $db->table('attendance')
                ->where('employee_id', $currentEmpId)
                ->where('date', $today)
                ->get()
                ->getRowArray();

            $leaveBalances = $db->table('leave_balances lb')
                ->select('lb.*, lt.name as leave_type_name, lt.code as leave_type_code')
                ->join('leave_types lt', 'lt.id = lb.leave_type_id')
                ->where('lb.employee_id', $currentEmpId)
                ->get()
                ->getResultArray();

            $myRecentLeaves = $db->table('leave_requests lr')
                ->select('lr.*, lt.name as leave_type_name, lt.code as leave_type_code')
                ->join('leave_types lt', 'lt.id = lr.leave_type_id')
                ->where('lr.employee_id', $currentEmpId)
                ->orderBy('lr.id', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            $myRecentPunches = $db->table('attendance')
                ->where('employee_id', $currentEmpId)
                ->orderBy('date', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray();

            $myLatestPayslip = $db->table('payroll_items pi')
                ->select('pi.*, pr.month, pr.year, pr.status as run_status')
                ->join('payroll_runs pr', 'pr.id = pi.payroll_run_id')
                ->where('pi.employee_id', $currentEmpId)
                ->orderBy('pr.id', 'DESC')
                ->get()
                ->getRowArray();

            $myGoalsCount = $db->table('performance_goals')
                ->where('employee_id', $currentEmpId)
                ->countAllResults();

            $upcomingHolidays = $db->table('holidays')
                ->where('date >=', $today)
                ->orderBy('date', 'ASC')
                ->limit(4)
                ->get()
                ->getResultArray();

            $employeeData = [
                'profile'          => $employee,
                'todayPunch'       => $todayPunch,
                'leaveBalances'    => $leaveBalances,
                'recentLeaves'     => $myRecentLeaves,
                'recentPunches'    => $myRecentPunches,
                'latestPayslip'    => $myLatestPayslip,
                'goalsCount'       => $myGoalsCount,
                'upcomingHolidays' => $upcomingHolidays,
            ];
        }

        // 2. Manager-specific data (for MSS dashboard)
        $managerData = [];
        if ($roleSlug === 'manager' || $this->hasRole(['manager'])) {
            $directReports = $db->table('employees e')
                ->select('e.*, d.name as dept_name, des.name as desig_name')
                ->join('departments d', 'd.id = e.department_id', 'left')
                ->join('designations des', 'des.id = e.designation_id', 'left')
                ->where('e.reporting_to', $currentEmpId)
                ->where('e.employment_status', 'active')
                ->where('e.deleted_at', null)
                ->get()
                ->getResultArray();

            $teamIds = !empty($directReports) ? array_column($directReports, 'id') : [];

            $teamPresentToday = 0;
            $pendingTeamLeaves = [];
            $pendingTeamEvaluations = 0;

            if (!empty($teamIds)) {
                $teamPresentToday = $db->table('attendance')
                    ->whereIn('employee_id', $teamIds)
                    ->where('date', $today)
                    ->where('status', 'Present')
                    ->countAllResults();

                $pendingTeamLeaves = $db->table('leave_requests lr')
                    ->select('lr.*, e.first_name, e.last_name, e.employee_code, lt.name as leave_type_name')
                    ->join('employees e', 'e.id = lr.employee_id')
                    ->join('leave_types lt', 'lt.id = lr.leave_type_id')
                    ->whereIn('lr.employee_id', $teamIds)
                    ->where('lr.status', 'pending')
                    ->orderBy('lr.id', 'DESC')
                    ->limit(6)
                    ->get()
                    ->getResultArray();

                $pendingTeamEvaluations = $db->table('employee_appraisals')
                    ->whereIn('employee_id', $teamIds)
                    ->where('status !=', 'completed')
                    ->countAllResults();
            }

            $managerData = [
                'directReports'          => $directReports,
                'teamCount'              => count($directReports),
                'teamPresentToday'       => $teamPresentToday,
                'pendingTeamLeaves'      => $pendingTeamLeaves,
                'pendingTeamLeavesCount' => count($pendingTeamLeaves),
                'pendingEvaluations'     => $pendingTeamEvaluations,
            ];
        }

        // 3. Payroll & Finance data
        $payrollData = [];
        if (in_array($roleSlug, ['payroll_manager', 'accountant', 'super_admin'])) {
            $latestRun = $db->table('payroll_runs')->orderBy('id', 'DESC')->get()->getFirstRow('array');
            if ($latestRun && (float)$latestRun['total_gross'] > 0) {
                $monthlyGross = (float)$latestRun['total_gross'];
                $monthlyNet   = (float)$latestRun['total_net'];
            } else {
                $payrollEstimate = $db->table('salary_structures ss')
                    ->join('employees e', 'e.id = ss.employee_id')
                    ->where('e.deleted_at', null)
                    ->whereIn('e.employment_status', ['active', 'probation', 'notice_period'])
                    ->selectSum('ss.gross_salary', 'total_gross')
                    ->selectSum('ss.net_salary', 'total_net')
                    ->get()
                    ->getFirstRow('array');
                $monthlyGross = (float)($payrollEstimate['total_gross'] ?? 0);
                $monthlyNet   = (float)($payrollEstimate['total_net'] ?? 0);
            }

            $recentPayrollRuns = $db->table('payroll_runs')->orderBy('id', 'DESC')->limit(4)->get()->getResultArray();
            $pendingReimbursements = $db->table('reimbursement_requests')->where('status', 'submitted')->countAllResults();
            $pendingLoans = $db->table('employee_loans')->whereIn('status', ['submitted', 'manager_approved'])->countAllResults();

            $payrollData = [
                'monthlyGross'          => $monthlyGross,
                'monthlyNet'            => $monthlyNet,
                'latestRun'             => $latestRun,
                'recentPayrollRuns'     => $recentPayrollRuns,
                'pendingReimbursements' => $pendingReimbursements,
                'pendingLoans'          => $pendingLoans,
            ];
        }

        // 4. HR Operations data
        $hrData = [];
        if (in_array($roleSlug, ['hr_admin', 'hr_executive', 'super_admin'])) {
            $attendanceStats = $db->table('attendance')
                ->select('status, COUNT(*) as count')
                ->where('date', $today)
                ->groupBy('status')
                ->get()
                ->getResultArray();

            $presentToday = 0;
            $lateToday = 0;
            foreach ($attendanceStats as $stat) {
                if ($stat['status'] === 'Present') {
                    $presentToday = (int)$stat['count'];
                }
                if ($stat['status'] === 'Late') {
                    $lateToday = (int)$stat['count'];
                }
            }

            $pendingLeaves = $db->table('leave_requests')
                ->where('status', 'pending')
                ->countAllResults();

            $openJobs = $db->table('job_openings')
                ->where('status', 'published')
                ->countAllResults();

            $pendingProbations = $db->table('employees')
                ->where('employment_status', 'probation')
                ->where('deleted_at', null)
                ->countAllResults();

            $departmentsWithStats = $departmentModel->getDepartmentsWithStats();
            $recentEmployees = $employeeModel->getDetailedList([], 5, 0);

            $hrData = [
                'presentToday'         => $presentToday,
                'lateToday'            => $lateToday,
                'pendingLeaves'        => $pendingLeaves,
                'openJobs'             => $openJobs,
                'pendingProbations'    => $pendingProbations,
                'departmentsWithStats' => $departmentsWithStats,
                'recentEmployees'      => $recentEmployees,
            ];
        }

        // 5. Activity logs for Super Admin
        $recentLogs = [];
        if ($roleSlug === 'super_admin') {
            $recentLogs = $activityLogModel->getRecentLogs(8);
        }

        $data = [
            'roleSlug'         => $roleSlug,
            'totalHeadcount'   => $totalHeadcount,
            'activeEmployees'  => $activeEmployees,
            'totalDepartments' => $totalDepartments,
            'totalBranches'    => $totalBranches,
            'employeeData'     => $employeeData,
            'managerData'      => $managerData,
            'payrollData'      => $payrollData,
            'hrData'           => $hrData,
            'recentLogs'       => $recentLogs,
        ];

        return $this->render('dashboard/index', $data, 'Dashboard');
    }
}
