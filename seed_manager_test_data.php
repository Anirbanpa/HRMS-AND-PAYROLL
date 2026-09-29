<?php

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=enterprise_hrms;charset=utf8mb4', 'root', '12345678', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

echo "Updating reporting lines for employees...\n";
// Set Sophia Chen (4) active, reporting to Marcus Sterling (3)
$pdo->exec("UPDATE employees SET employment_status = 'active', reporting_to = 3 WHERE id = 4");
// Set Subham Das (6) reporting to Marcus Sterling (3)
$pdo->exec("UPDATE employees SET reporting_to = 3 WHERE id = 6");
// Set KARAN Up (8) reporting to Marcus Sterling (3)
$pdo->exec("UPDATE employees SET reporting_to = 3 WHERE id = 8");
// Set Anirban PAUL (7) reporting to Eleanor Vance (2)
$pdo->exec("UPDATE employees SET reporting_to = 2 WHERE id = 7");

echo "Checking pending items for Marcus Sterling's team (employees 4, 6, 8)...\n";

// 1. Pending Leave for Sophia Chen (4)
$leaveCount = $pdo->query("SELECT COUNT(*) as c FROM leave_requests WHERE employee_id = 4 AND status = 'pending'")->fetch()['c'];
if ($leaveCount == 0) {
    $pdo->prepare("INSERT INTO leave_requests (employee_id, leave_type_id, start_date, end_date, total_days, is_half_day, reason, status) 
        VALUES (4, 1, '2026-10-01', '2026-10-03', 3, 0, 'Attending family medical appointment and personal leave', 'pending')")->execute();
    echo "Inserted pending leave for Sophia Chen\n";
}

// 2. Pending Attendance Correction for Subham Das (6)
$corrCount = $pdo->query("SELECT COUNT(*) as c FROM attendance_corrections WHERE employee_id = 6 AND status = 'pending'")->fetch()['c'];
if ($corrCount == 0) {
    $pdo->prepare("INSERT INTO attendance_corrections (employee_id, attendance_date, requested_clock_in, requested_clock_out, reason, status)
        VALUES (6, '2026-09-25', '2026-09-25 09:00:00', '2026-09-25 18:15:00', 'Biometric device failed to log morning punch due to network lag', 'pending')")->execute();
    echo "Inserted pending correction for Subham Das\n";
}

// 3. Pending Overtime for KARAN Up (8)
$otCount = $pdo->query("SELECT COUNT(*) as c FROM overtime_requests WHERE employee_id = 8 AND status = 'pending'")->fetch()['c'];
if ($otCount == 0) {
    $pdo->prepare("INSERT INTO overtime_requests (employee_id, overtime_rule_id, request_date, start_time, end_time, total_hours, reason, status)
        VALUES (8, 1, '2026-09-25', '18:00:00', '21:00:00', 3.00, 'Server migration and critical release deployment', 'pending')")->execute();
    echo "Inserted pending overtime for KARAN Up\n";
}

// 4. Pending Reimbursement Claim for Sophia Chen (4)
$reimbCount = $pdo->query("SELECT COUNT(*) as c FROM reimbursement_requests WHERE employee_id = 4 AND status = 'submitted'")->fetch()['c'];
if ($reimbCount == 0) {
    $cNum = 'CLM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
    $pdo->prepare("INSERT INTO reimbursement_requests (claim_number, employee_id, expense_category_id, claim_title, expense_date, amount, approved_amount, description, status)
        VALUES ('{$cNum}', 4, 1, 'Client site travel taxi fare', '2026-09-24', 45.50, 45.50, 'Transportation expense for client on-site requirements review', 'submitted')")->execute();
    echo "Inserted pending reimbursement claim for Sophia Chen\n";
}

// 5. Clock in one of the team members today (Sophia Chen)
$today = date('Y-m-d');
$attExists = $pdo->query("SELECT id FROM attendance WHERE employee_id = 4 AND date = '{$today}'")->fetch();
if (!$attExists) {
    $nowIn = date('Y-m-d 09:05:00');
    $pdo->prepare("INSERT INTO attendance (employee_id, date, clock_in, status, source) VALUES (4, '{$today}', '{$nowIn}', 'Present', 'web')")->execute();
    echo "Recorded live attendance for Sophia Chen today\n";
}

echo "Demo data setup completed successfully!\n";

