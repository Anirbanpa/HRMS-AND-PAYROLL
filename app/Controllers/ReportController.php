<?php

namespace App\Controllers;

use App\Models\EmployeeModel;
use App\Models\DepartmentModel;
use App\Models\AttendanceModel;
use App\Models\PayrollRunModel;
use App\Models\PayrollItemModel;
use CodeIgniter\HTTP\ResponseInterface;

class ReportController extends BaseController
{
    protected EmployeeModel $employeeModel;
    protected DepartmentModel $deptModel;
    protected AttendanceModel $attendanceModel;
    protected PayrollRunModel $payrollRunModel;
    protected PayrollItemModel $payrollItemModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->deptModel = new DepartmentModel();
        $this->attendanceModel = new AttendanceModel();
        $this->payrollRunModel = new PayrollRunModel();
        $this->payrollItemModel = new PayrollItemModel();
    }

    /**
     * Reports Hub Dashboard
     */
    public function index()
    {
        if (!$this->hasPermission('reports.view')) {
            $this->session->setFlashdata('error', 'Access Denied: You do not have authorization to view reports and analytics.');
            return redirect()->to(site_url('dashboard'));
        }

        $departments = $this->deptModel->findAll();
        $payrollRuns = $this->payrollRunModel->orderBy('id', 'DESC')->findAll();

        $totalEmployees = $this->employeeModel->where('deleted_at', null)->countAllResults();
        $totalPayrollDisbursed = array_sum(array_column($payrollRuns, 'total_net'));

        $data = [
            'pageTitle'             => 'Reports & Compliance Export Center',
            'departments'           => $departments,
            'payrollRuns'           => $payrollRuns,
            'totalEmployees'        => $totalEmployees,
            'totalPayrollDisbursed' => $totalPayrollDisbursed,
        ];

        return $this->render('reports/index', $data);
    }

    /**
     * Export Employee Directory CSV
     */
    public function exportEmployees(): ResponseInterface
    {
        $deptId = (int)$this->request->getGet('department_id');
        $status = $this->request->getGet('status');

        $builder = $this->employeeModel->select('employees.*, departments.name AS department_name, designations.name AS designation_title,
                                                employee_bank_details.bank_name, employee_bank_details.account_number, employee_bank_details.ifsc_swift_code')
                                       ->join('departments', 'departments.id = employees.department_id', 'left')
                                       ->join('designations', 'designations.id = employees.designation_id', 'left')
                                       ->join('employee_bank_details', 'employee_bank_details.employee_id = employees.id', 'left')
                                       ->where('employees.deleted_at', null);

        if (!empty($deptId)) {
            $builder->where('employees.department_id', $deptId);
        }
        if (!empty($status)) {
            $builder->where('employees.employment_status', $status);
        }

        $employees = $builder->orderBy('employees.id', 'ASC')->findAll();

        $filename = 'employees_export_' . date('Ymd_His') . '.csv';
        $output = "\xEF\xBB\xBF"; // UTF-8 BOM
        
        $headers = [
            'Employee Code', 'First Name', 'Last Name', 'Work Email', 'Phone',
            'Department', 'Designation', 'Joining Date', 'Employment Type', 'Status',
            'Bank Name', 'Account Number', 'IFSC / Routing'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($employees as $e) {
            $row = [
                $e['employee_code'],
                $e['first_name'],
                $e['last_name'],
                $e['official_email'] ?: $e['email'],
                $e['phone'] ?? '',
                $e['department_name'] ?? 'General',
                $e['designation_title'] ?? 'Staff',
                $e['joining_date'] ?? '',
                $e['employment_type'] ?? '',
                $e['employment_status'] ?? '',
                $e['bank_name'] ?? '',
                $e['account_number'] ?? '',
                $e['ifsc_swift_code'] ?? '',
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'employees', "Exported employee directory CSV (" . count($employees) . " records)");

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * Export Monthly Attendance Summary CSV
     */
    public function exportAttendance(): ResponseInterface
    {
        $month = (int)($this->request->getGet('month') ?: date('n'));
        $year = (int)($this->request->getGet('year') ?: date('Y'));

        $startDate = sprintf('%04d-%02d-01', $year, $month);
        $endDate = date('Y-m-t', strtotime($startDate));
        $totalDaysInMonth = (int)date('t', strtotime($startDate));

        $employees = $this->employeeModel->where('deleted_at', null)->findAll();

        $filename = "attendance_summary_{$year}_{$month}.csv";
        $output = "\xEF\xBB\xBF";

        $headers = [
            'Employee Code', 'Employee Name', 'Month', 'Calendar Days',
            'Present Days', 'Late Arrivals', 'Leaves Approved', 'Absent Days', 'Attendance %'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($employees as $e) {
            // Count attendance metrics
            $records = $this->attendanceModel->where('employee_id', $e['id'])
                                            ->where('date >=', $startDate)
                                            ->where('date <=', $endDate)
                                            ->findAll();

            $present = count(array_filter($records, fn($r) => in_array($r['status'], ['present', 'late', 'half_day'])));
            $late = count(array_filter($records, fn($r) => $r['status'] === 'late'));
            $leave = count(array_filter($records, fn($r) => in_array($r['status'], ['on_leave', 'half_day'])));
            $absent = max(0, 22 - $present); // assuming 22 working days
            $attPercentage = ($present > 0) ? round(($present / 22.0) * 100, 1) : 0.0;

            $row = [
                $e['employee_code'],
                $e['first_name'] . ' ' . $e['last_name'],
                date('F Y', strtotime($startDate)),
                $totalDaysInMonth,
                $present,
                $late,
                $leave,
                $absent,
                $attPercentage . '%',
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'attendance', "Exported attendance summary for {$year}-{$month}");

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * Export Payroll Bank Payout File (Corporate ACH / NEFT Batch Upload)
     */
    public function exportPayrollBank(): ResponseInterface
    {
        $payrollRunId = (int)$this->request->getGet('payroll_run_id');
        $run = $this->payrollRunModel->find($payrollRunId);

        if (!$run) {
            return redirect()->back()->with('error', 'Selected payroll run does not exist.');
        }

        $items = $this->payrollItemModel->getItemsWithEmployee($payrollRunId);

        $filename = "bank_disbursement_{$run['month']}_{$run['year']}.csv";
        $output = "\xEF\xBB\xBF";

        $headers = [
            'Beneficiary Code', 'Beneficiary Name', 'Bank Name', 'Account Number',
            'IFSC / Routing Code', 'Payout Amount (₹)', 'Payment Reference', 'Narration'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($items as $item) {
            $row = [
                $item['employee_code'],
                $item['first_name'] . ' ' . $item['last_name'],
                $item['bank_name'] ?: 'Corporate Bank',
                $item['account_number'] ?: 'ACCOUNT_ON_FILE',
                $item['ifsc_swift_code'] ?: 'CORP0001',
                number_format((float)$item['net_salary'], 2, '.', ''),
                $item['payslip_number'],
                "Salary for " . date('F Y', mktime(0, 0, 0, (int)$run['month'], 1, (int)$run['year'])),
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'payroll_runs', "Exported bank disbursement file for payroll run #{$payrollRunId}", $payrollRunId);

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * Export Statutory PF & Tax Summary
     */
    public function exportStatutory(): ResponseInterface
    {
        $payrollRunId = (int)$this->request->getGet('payroll_run_id');
        $run = $this->payrollRunModel->find($payrollRunId);

        if (!$run) {
            return redirect()->back()->with('error', 'Selected payroll run does not exist.');
        }

        $items = $this->payrollItemModel->getItemsWithEmployee($payrollRunId);

        $filename = "statutory_tax_pf_{$run['month']}_{$run['year']}.csv";
        $output = "\xEF\xBB\xBF";

        $headers = [
            'Employee Code', 'Employee Name', 'Basic Pay (₹)', 'Gross Pay (₹)',
            'PF Employee Contribution (12%)', 'PF Employer Contribution (12%)',
            'Income Tax Withholding (₹)', 'Health Insurance (₹)', 'Net Disbursed (₹)'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($items as $item) {
            $basic = (float)$item['basic_salary'];
            $pfEmp = (float)$item['pf_deduction'];
            $pfOrg = $pfEmp; // 1:1 statutory match
            $tax = (float)$item['tax_deduction'];
            $insurance = (float)$item['insurance_deduction'];
            $net = (float)$item['net_salary'];
            $gross = (float)$item['gross_salary'];

            $row = [
                $item['employee_code'],
                $item['first_name'] . ' ' . $item['last_name'],
                number_format($basic, 2, '.', ''),
                number_format($gross, 2, '.', ''),
                number_format($pfEmp, 2, '.', ''),
                number_format($pfOrg, 2, '.', ''),
                number_format($tax, 2, '.', ''),
                number_format($insurance, 2, '.', ''),
                number_format($net, 2, '.', ''),
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'payroll_runs', "Exported statutory compliance report for payroll run #{$payrollRunId}", $payrollRunId);

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * Export Performance Appraisals & Scorecard Matrix CSV
     */
    public function exportAppraisals(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $records = $db->table('employee_appraisals ea')
            ->select('ea.*, ac.title as cycle_title, ac.start_date as cycle_start, ac.end_date as cycle_end, e.first_name, e.last_name, e.employee_code, d.name as department_name, des.name as designation_name, m.first_name as mgr_first, m.last_name as mgr_last')
            ->join('appraisal_cycles ac', 'ac.id = ea.appraisal_cycle_id')
            ->join('employees e', 'e.id = ea.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('designations des', 'des.id = e.designation_id', 'left')
            ->join('employees m', 'm.id = ea.manager_id', 'left')
            ->orderBy('ea.id', 'DESC')
            ->get()
            ->getResultArray();

        $filename = 'performance_appraisals_' . date('Ymd_His') . '.csv';
        $output = "\xEF\xBB\xBF"; // UTF-8 BOM
        
        $headers = [
            'Appraisal ID', 'Cycle Title', 'Employee Code', 'Employee Name', 'Department',
            'Designation', 'Reviewing Manager', 'Self Rating (1-5)', 'Manager Rating (1-5)',
            'Final Rating Band', 'Promotion Recommended', 'Recommended Increment %', 'Appraisal Status', 'Review Date'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($records as $r) {
            $row = [
                'APP-' . str_pad($r['id'], 4, '0', STR_PAD_LEFT),
                $r['cycle_title'],
                $r['employee_code'],
                $r['first_name'] . ' ' . $r['last_name'],
                $r['department_name'] ?? 'General',
                $r['designation_name'] ?? 'Staff',
                ($r['mgr_first'] ? $r['mgr_first'] . ' ' . $r['mgr_last'] : 'HR Lead'),
                $r['self_rating'] ?: 'N/A',
                $r['manager_rating'] ?: 'N/A',
                $r['final_rating'] ?: 'Pending',
                $r['promotion_recommended'] ? 'Yes' : 'No',
                number_format((float)($r['increment_percentage'] ?? 0), 2) . '%',
                ucfirst($r['status']),
                $r['manager_submitted_at'] ? date('Y-m-d', strtotime($r['manager_submitted_at'])) : ($r['self_submitted_at'] ? date('Y-m-d', strtotime($r['self_submitted_at'])) : date('Y-m-d')),
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'performance', "Exported performance appraisal matrix CSV (" . count($records) . " records)");

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * Export Training Programs, Attendance & Skills Matrix CSV
     */
    public function exportTraining(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $records = $db->table('training_participants tp')
            ->select('tp.*, t.title as course_title, t.course_code, t.category, t.trainer_name, t.total_hours, t.start_date, t.end_date, e.first_name, e.last_name, e.employee_code, d.name as department_name, des.name as designation_name')
            ->join('training_programs t', 't.id = tp.training_id')
            ->join('employees e', 'e.id = tp.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('designations des', 'des.id = e.designation_id', 'left')
            ->orderBy('t.start_date', 'DESC')
            ->get()
            ->getResultArray();

        $filename = 'training_skills_matrix_' . date('Ymd_His') . '.csv';
        $output = "\xEF\xBB\xBF";
        
        $headers = [
            'Course Code', 'Course Title', 'Category', 'Trainer', 'Duration (Hours)',
            'Start Date', 'End Date', 'Employee Code', 'Employee Name', 'Department',
            'Nomination Status', 'Attendance %', 'Completion Status', 'Assessment Score %', 'Certified Date'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($records as $r) {
            $row = [
                $r['course_code'],
                $r['course_title'],
                $r['category'],
                $r['trainer_name'] ?? 'Corporate Trainer',
                $r['total_hours'],
                $r['start_date'],
                $r['end_date'],
                $r['employee_code'],
                $r['first_name'] . ' ' . $r['last_name'],
                $r['department_name'] ?? 'General',
                ucfirst($r['nomination_status']),
                number_format((float)$r['attendance_percent'], 1) . '%',
                ucfirst($r['completion_status']),
                $r['score_rating'] ? $r['score_rating'] . '%' : 'N/A',
                $r['completed_date'] ?: 'Pending',
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'training', "Exported training and skill records CSV (" . count($records) . " records)");

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * Export Recruitment ATS & Talent Pipeline CSV
     */
    public function exportRecruitment(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $records = $db->table('candidates c')
            ->select('c.*, jo.title as job_title, jo.job_code, d.name as department_name')
            ->join('job_openings jo', 'jo.id = c.job_opening_id', 'left')
            ->join('departments d', 'd.id = jo.department_id', 'left')
            ->orderBy('c.id', 'DESC')
            ->get()
            ->getResultArray();

        $filename = 'recruitment_ats_pipeline_' . date('Ymd_His') . '.csv';
        $output = "\xEF\xBB\xBF";
        
        $headers = [
            'Candidate ID', 'Candidate Name', 'Email', 'Phone', 'Applied Position',
            'Department', 'Current ATS Stage', 'Status', 'Rating (1-5)', 'Application Date', 'Converted to Employee'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($records as $r) {
            $row = [
                'CAN-' . str_pad($r['id'], 4, '0', STR_PAD_LEFT),
                $r['first_name'] . ' ' . $r['last_name'],
                $r['email'],
                $r['phone'] ?? '',
                $r['job_title'] ?? 'Direct Application',
                $r['department_name'] ?? 'General',
                ucfirst($r['stage']),
                ucfirst($r['status']),
                $r['rating'] ? $r['rating'] . ' / 5' : 'Unrated',
                date('Y-m-d', strtotime($r['created_at'] ?? date('Y-m-d'))),
                !empty($r['employee_id']) ? 'Yes (EMP #' . $r['employee_id'] . ')' : 'No',
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'recruitment', "Exported ATS recruitment pipeline CSV (" . count($records) . " records)");

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * Export Separation, Exit Clearance & FnF Settlements CSV
     */
    public function exportSeparation(): ResponseInterface
    {
        $db = \Config\Database::connect();
        $records = $db->table('resignations r')
            ->select('r.*, e.first_name, e.last_name, e.employee_code, d.name as department_name, des.name as designation_name, fnf.gratuity_amount, fnf.leave_encashment_amount, fnf.bonus_incentive_amount, fnf.deductions_amount, fnf.net_payable_amount as fnf_net, fnf.payment_status as fnf_status')
            ->join('employees e', 'e.id = r.employee_id')
            ->join('departments d', 'd.id = e.department_id', 'left')
            ->join('designations des', 'des.id = e.designation_id', 'left')
            ->join('full_and_final_settlements fnf', 'fnf.resignation_id = r.id', 'left')
            ->orderBy('r.id', 'DESC')
            ->get()
            ->getResultArray();

        $filename = 'separation_fnf_clearance_' . date('Ymd_His') . '.csv';
        $output = "\xEF\xBB\xBF";
        
        $headers = [
            'Resignation ID', 'Employee Code', 'Employee Name', 'Department', 'Designation',
            'Resignation Date', 'Notice Period (Days)', 'Requested LWD', 'Approved LWD',
            'Resignation Reason', 'Exit Status', 'Clearance Progress', 'Gratuity (₹)', 'Leave Encashment (₹)',
            'FnF Net Payable (₹)', 'FnF Settlement Status'
        ];
        $output .= implode(',', array_map([$this, 'escapeCsv'], $headers)) . "\r\n";

        foreach ($records as $r) {
            $row = [
                'RES-' . str_pad($r['id'], 4, '0', STR_PAD_LEFT),
                $r['employee_code'],
                $r['first_name'] . ' ' . $r['last_name'],
                $r['department_name'] ?? 'General',
                $r['designation_name'] ?? 'Staff',
                $r['resignation_date'],
                $r['notice_period_days'] ?? 30,
                $r['requested_last_working_day'],
                $r['approved_last_working_day'] ?? $r['requested_last_working_day'],
                $r['reason'] ?? 'Career Progression',
                ucfirst($r['status']),
                ucfirst($r['clearance_status'] ?? 'pending'),
                number_format((float)($r['gratuity_amount'] ?? 0), 2),
                number_format((float)($r['leave_encashment_amount'] ?? 0), 2),
                number_format((float)($r['fnf_net'] ?? $r['net_payable_amount'] ?? 0), 2),
                ucfirst($r['fnf_status'] ?? 'pending'),
            ];
            $output .= implode(',', array_map([$this, 'escapeCsv'], $row)) . "\r\n";
        }

        $this->logAudit('EXPORT_CSV', 'separation', "Exported employee separation and FnF settlement CSV (" . count($records) . " records)");

        return $this->response
                    ->setHeader('Content-Type', 'text/csv; charset=utf-8')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->setBody($output);
    }

    /**
     * CSV Injection Protection helper
     */
    protected function escapeCsv($value): string
    {
        $str = (string)$value;
        // Prefix with quote if starts with formula trigger
        if (in_array(substr($str, 0, 1), ['=', '+', '-', '@'])) {
            $str = "'" . $str;
        }
        return '"' . str_replace('"', '""', $str) . '"';
    }
}
