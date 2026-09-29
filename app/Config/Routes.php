<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Root Redirect
$routes->get('/', static function () {
    if (session()->has('user_id')) {
        return redirect()->to(site_url('dashboard'));
    }
    return redirect()->to(site_url('login'));
});

// Authentication Routes
$routes->match(['GET', 'POST'], 'login', 'AuthController::login');
$routes->match(['GET', 'POST'], 'logout', 'AuthController::logout');
$routes->match(['GET', 'POST'], 'auth/logout', 'AuthController::logout');
$routes->get('auth/demo/(:segment)', 'AuthController::switchDemo/$1');
$routes->get('demo/switch/(:segment)', 'AuthController::switchDemo/$1');

// Protected Enterprise HRMS Application Routes
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // 1. Dashboard
    $routes->get('dashboard', 'DashboardController::index');

    // 2. Employee Master Management & 360° Profile (Modules 4, 5, 6, 9)
    $routes->get('employees', 'EmployeeController::index');
    $routes->get('employees/create', 'EmployeeController::create');
    $routes->post('employees/store', 'EmployeeController::store');
    $routes->get('employees/view/(:num)', 'EmployeeController::view/$1');
    $routes->get('employees/edit/(:num)', 'EmployeeController::edit/$1');
    $routes->post('employees/update/(:num)', 'EmployeeController::update/$1');
    $routes->match(['GET', 'POST'], 'employees/delete/(:num)', 'EmployeeController::delete/$1');
    $routes->post('employees/document/upload', 'EmployeeController::uploadDocument');
    $routes->get('employees/document/delete/(:num)', 'EmployeeController::deleteDocument/$1');

    // 3. Departments & Designations (Module 7 & Module 3/41)
    $routes->get('departments', 'DepartmentController::index');
    $routes->post('departments/store', 'DepartmentController::store');
    $routes->post('departments/update/(:num)', 'DepartmentController::update/$1');
    $routes->match(['GET', 'POST'], 'departments/delete/(:num)', 'DepartmentController::delete/$1');
    $routes->post('designations/store', 'DepartmentController::storeDesignation');
    $routes->post('designations/update/(:num)', 'DepartmentController::updateDesignation/$1');
    $routes->match(['GET', 'POST'], 'designations/delete/(:num)', 'DepartmentController::deleteDesignation/$1');
    $routes->get('designations', static function () {
        return redirect()->to(site_url('departments?tab=designations'));
    });

    // 4. Organization Setup (Branches, Designations, Pay Bands) (Modules 3, 41)
    $routes->get('organization', 'OrganizationController::index');

    // 5. RBAC Roles & Permissions Matrix (Modules 1, 43)
    $routes->get('roles', 'RoleController::index');
    $routes->post('roles/update/(:num)', 'RoleController::update/$1');

    // 6. User Profile & Security Settings (Module 43)
    $routes->get('profile', 'ProfileController::index');
    $routes->post('profile/password', 'ProfileController::updatePassword');

    // 7. Time & Attendance Register (Modules 10, 12, 16)
    $routes->get('attendance', 'AttendanceController::index');
    $routes->post('attendance/clock', 'AttendanceController::clock');
    $routes->post('attendance/manual', 'AttendanceController::manualStore');
    $routes->post('attendance/biometric/test', 'AttendanceController::triggerBiometricTest');

    // 8. Leave Management & Approvals (Module 13, 14)
    $routes->get('leaves', 'LeaveController::index');
    $routes->post('leaves/apply', 'LeaveController::apply');
    $routes->get('leaves/approve/(:num)', 'LeaveController::approve/$1');
    $routes->post('leaves/reject/(:num)', 'LeaveController::reject/$1');

    // 9. Payroll Processing & Payslips (Modules 17, 18, 19, 20, 21, 22)
    $routes->get('payroll', 'PayrollController::index');
    $routes->post('payroll/process', 'PayrollController::process');
    $routes->post('payroll/update/(:num)', 'PayrollController::update/$1');
    $routes->match(['GET', 'POST'], 'payroll/delete/(:num)', 'PayrollController::delete/$1');
    $routes->get('payroll/view/(:num)', 'PayrollController::view/$1');
    $routes->get('payroll/payslip/(:num)', 'PayrollController::payslip/$1');

    // 10. Audit Trail & Activity Logs (Module 42)
    $routes->get('audit', 'AuditController::index');

    // 11. Recruitment & ATS Pipeline (Module 8)
    $routes->get('recruitment', 'RecruitmentController::index');
    $routes->post('recruitment/jobs/store', 'RecruitmentController::storeJob');
    $routes->post('recruitment/candidates/store', 'RecruitmentController::storeCandidate');
    $routes->post('recruitment/candidates/stage/(:num)', 'RecruitmentController::updateStage/$1');
    $routes->post('recruitment/convert/(:num)', 'RecruitmentController::convertCandidate/$1');

    // 12. Employee Asset Management (Module 30)
    $routes->get('asset-management', 'AssetController::index');
    $routes->post('asset-management/store', 'AssetController::store');
    $routes->post('asset-management/allocate', 'AssetController::allocate');
    $routes->post('asset-management/return', 'AssetController::returnAsset');

    // 13. Separation, Exit Clearance & F&F (Modules 34, 35)
    $routes->get('separation', 'SeparationController::index');
    $routes->post('separation/submit', 'SeparationController::submit');
    $routes->post('separation/approve/(:num)', 'SeparationController::approve/$1');
    $routes->post('separation/clearance/(:num)', 'SeparationController::updateClearance/$1');
    $routes->post('separation/fnf/calculate/(:num)', 'SeparationController::calculateFnF/$1');
    $routes->get('separation/fnf/view/(:num)', 'SeparationController::viewFnF/$1');

    // 14. Reports & Data Export Center (Modules 22, 40, 44)
    $routes->get('reports', 'ReportController::index');
    $routes->get('reports/export/employees', 'ReportController::exportEmployees');
    $routes->get('reports/export/attendance', 'ReportController::exportAttendance');
    $routes->get('reports/export/payroll-bank', 'ReportController::exportPayrollBank');
    $routes->get('reports/export/statutory', 'ReportController::exportStatutory');
    $routes->get('reports/export/appraisals', 'ReportController::exportAppraisals');
    $routes->get('reports/export/training', 'ReportController::exportTraining');
    $routes->get('reports/export/recruitment', 'ReportController::exportRecruitment');
    $routes->get('reports/export/separation', 'ReportController::exportSeparation');

    // 15. Document Templates & Letter Builder (Modules 37, 38)
    $routes->get('templates', 'TemplateController::index');
    $routes->post('templates/store', 'TemplateController::store');
    $routes->get('templates/edit/(:num)', 'TemplateController::edit/$1');
    $routes->post('templates/update/(:num)', 'TemplateController::update/$1');
    $routes->match(['GET', 'POST'], 'templates/delete/(:num)', 'TemplateController::delete/$1');
    $routes->match(['GET', 'POST'], 'templates/generate', 'TemplateController::generate');

    // 16. Shift Management (Module 12)
    $routes->get('shifts', 'ShiftController::index');
    $routes->post('shifts/store', 'ShiftController::store');
    $routes->post('shifts/update/(:num)', 'ShiftController::update/$1');
    $routes->match(['GET', 'POST'], 'shifts/delete/(:num)', 'ShiftController::delete/$1');
    $routes->post('shifts/allocate', 'ShiftController::allocate');
    $routes->match(['GET', 'POST'], 'shifts/deallocate/(:num)', 'ShiftController::deallocate/$1');
    $routes->get('shifts/roster', 'ShiftController::roster');

    // 17. Holiday & Calendar Management (Module 14)
    $routes->get('holidays', 'HolidayController::index');
    $routes->post('holidays/store', 'HolidayController::store');
    $routes->get('holidays/delete/(:num)', 'HolidayController::delete/$1');
    $routes->post('holidays/working-days', 'HolidayController::updateWorkingDays');

    // 18. Overtime Management (Module 15)
    $routes->get('overtime', 'OvertimeController::index');
    $routes->post('overtime/apply', 'OvertimeController::apply');
    $routes->post('overtime/approve/(:num)', 'OvertimeController::approve/$1');
    $routes->post('overtime/reject/(:num)', 'OvertimeController::reject/$1');

    // 19. Salary Advance & Loan Management (Module 23)
    $routes->get('loans', 'LoanController::index');
    $routes->post('loans/apply', 'LoanController::apply');
    $routes->post('loans/approve/(:num)', 'LoanController::approve/$1');

    // 20. Reimbursement Management (Module 24)
    $routes->get('reimbursements', 'ReimbursementController::index');
    $routes->post('reimbursements/apply', 'ReimbursementController::apply');
    $routes->post('reimbursements/approve/(:num)', 'ReimbursementController::approve/$1');
    $routes->post('reimbursements/reject/(:num)', 'ReimbursementController::reject/$1');

    // 21. Bonus, Incentive & Commission (Module 25)
    $routes->get('bonuses', 'BonusController::index');
    $routes->post('bonuses/entry', 'BonusController::storeEntry');

    // 22. Manager Self-Service (Module 27)
    $routes->get('manager', 'ManagerController::index');
    $routes->post('manager/correction/approve/(:num)', 'ManagerController::approveCorrection/$1');
    $routes->post('manager/correction/reject/(:num)', 'ManagerController::rejectCorrection/$1');
    $routes->post('manager/leave/approve/(:num)', 'ManagerController::approveLeave/$1');
    $routes->post('manager/leave/reject/(:num)', 'ManagerController::rejectLeave/$1');
    $routes->post('manager/overtime/approve/(:num)', 'ManagerController::approveOvertime/$1');
    $routes->post('manager/overtime/reject/(:num)', 'ManagerController::rejectOvertime/$1');
    $routes->post('manager/reimbursement/approve/(:num)', 'ManagerController::approveReimbursement/$1');
    $routes->post('manager/reimbursement/reject/(:num)', 'ManagerController::rejectReimbursement/$1');

    // 23. Performance Management (Module 28)
    $routes->get('performance', 'PerformanceController::index');
    $routes->post('performance/goal', 'PerformanceController::storeGoal');
    $routes->post('performance/cycle', 'PerformanceController::storeCycle');
    $routes->post('performance/self-review', 'PerformanceController::submitSelfReview');
    $routes->post('performance/manager-review', 'PerformanceController::submitManagerReview');

    // 24. Training & Development (Module 29)
    $routes->get('training', 'TrainingController::index');
    $routes->post('training/store', 'TrainingController::store');
    $routes->post('training/nominate', 'TrainingController::nominate');
    $routes->post('training/attendance', 'TrainingController::markAttendance');
    $routes->post('training/complete', 'TrainingController::complete');
    $routes->get('training/certificate/(:num)', 'TrainingController::certificate/$1');

    // 25. Communication & Notification (Module 36)
    $routes->get('communication', 'CommunicationController::index');
    $routes->post('communication/announcement', 'CommunicationController::storeAnnouncement');
    $routes->post('communication/test-dispatch', 'CommunicationController::testDispatch');
    $routes->get('notifications', 'NotificationController::index');
    $routes->post('notifications/read-all', 'NotificationController::markAllRead');

    // 26. HR Policies & Knowledge Center (Module 38)
    $routes->get('policies', 'PolicyController::index');
    $routes->get('policies/acknowledge/(:num)', 'PolicyController::acknowledge/$1');

    // 27. Expense & Travel Management (Module 39)
    $routes->get('travel', 'TravelController::index');
    $routes->post('travel/apply', 'TravelController::apply');
    $routes->post('travel/approve/(:num)', 'TravelController::approve/$1');
    $routes->post('travel/reject/(:num)', 'TravelController::reject/$1');
    $routes->post('travel/claim', 'TravelController::claim');
    $routes->post('travel/claim/approve/(:num)', 'TravelController::approveClaim/$1');

    // 28. Late Coming & Early Leaving Management (Module 16)
    $routes->get('attendance/late-early', 'LateEarlyController::index');
    $routes->post('attendance/late-early/policy', 'LateEarlyController::savePolicy');
    $routes->post('attendance/late-early/waiver-request', 'LateEarlyController::requestWaiver');
    $routes->post('attendance/late-early/waive-request', 'LateEarlyController::requestWaiver');
    $routes->post('attendance/late-early/waiver-action/(:num)', 'LateEarlyController::actionWaiver/$1');
    $routes->post('attendance/late-early/waive-action/(:num)', 'LateEarlyController::actionWaiver/$1');

    // 29. Employee Transfer & Promotion (Module 31)
    $routes->get('career-movements', 'TransferPromotionController::index');
    $routes->post('career-movements/store', 'TransferPromotionController::store');
    $routes->post('career-movements/approve/(:num)', 'TransferPromotionController::approve/$1');
    $routes->post('career-movements/reject/(:num)', 'TransferPromotionController::reject/$1');

    // 30. Confirmation & Probation Management (Module 32)
    $routes->get('probation', 'ProbationController::index');
    $routes->post('probation/enroll', 'ProbationController::enroll');
    $routes->post('probation/assess/(:num)', 'ProbationController::submitAssessment/$1');
    $routes->post('probation/confirm/(:num)', 'ProbationController::confirm/$1');
    $routes->post('probation/extend/(:num)', 'ProbationController::extend/$1');

    // 31. Employee Warning & Disciplinary Records (Module 33)
    $routes->get('disciplinary', 'DisciplinaryController::index');
    $routes->post('disciplinary/store', 'DisciplinaryController::store');
    $routes->post('disciplinary/acknowledge/(:num)', 'DisciplinaryController::acknowledge/$1');
    $routes->post('disciplinary/close/(:num)', 'DisciplinaryController::close/$1');

    // 32. Database Backup & Disaster Recovery (Module 44)
    $routes->get('settings/backup', 'BackupController::index');
    $routes->get('settings/backup/download', 'BackupController::exportDatabase');

    // 33. System Integrations & Gateway Credentials (Module 44)
    $routes->get('settings/integrations', 'IntegrationController::index');
    $routes->post('settings/integrations/save', 'IntegrationController::save');
    $routes->post('settings/integrations/test', 'IntegrationController::testConnection');
});

// Biometric Hardware Webhook REST API (Module 11)
$routes->post('api/v1/attendance/punch', 'AttendanceController::biometricPunch');


