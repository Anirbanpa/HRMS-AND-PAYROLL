-- =====================================================
-- Enterprise HRMS Complete Database Snapshot
-- Database: enterprise_hrms
-- Generated: 2026-09-29 11:44:47
-- Compatible with MySQL 5.7+ / MySQL 8.0+ / MariaDB 10+
-- =====================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

-- -----------------------------------------------------
-- Table structure for `activity_logs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `record_id` int unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_act_user` (`user_id`),
  KEY `idx_act_mod` (`module`),
  KEY `idx_act_time` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=1059 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `activity_logs` (1058 rows)
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('1', '1', 'SYSTEM_INIT', 'core', 'Enterprise HRMS database initialized and seeded with Phase 1 configurations and default access roles.', NULL, '127.0.0.1', NULL, '2026-09-25 12:26:51'),
('2', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-IN) WindowsPowerShell/5.1.26100.9457', '2026-09-25 12:29:05'),
('3', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-25 12:29:27'),
('4', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:31:07'),
('5', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:33:08'),
('6', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:33:10'),
('7', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:34:25'),
('8', '5', 'LOGOUT', 'auth', 'User payroll logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:34:27'),
('9', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:34:32'),
('10', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Subham Das (EMP0006) with user account \'subhamdas\'.', '6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:35:35'),
('11', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:37:49'),
('12', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:37:51'),
('13', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:37:55'),
('14', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:38:17'),
('15', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:38:23'),
('16', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Anirban PAUL (EMP0007) with user account \'anirbanpaul\'.', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:40:55'),
('17', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee KARAN Up (EMP0008) with user account \'karanup\'.', '8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 12:44:15'),
('18', '1', 'UPLOAD_DOCUMENT', 'employee_docs', 'Uploaded document \'Executive Passport Scan\' (passport) for employee #1.', '1', '::1', 'curl/8.21.0', '2026-09-25 12:46:21'),
('19', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (8 payslips, Net: $72840).', '1', '::1', 'curl/8.21.0', '2026-09-25 12:52:13'),
('20', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (8 payslips, Net: $72840).', '2', '::1', 'curl/8.21.0', '2026-09-25 12:58:30'),
('21', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:05:04'),
('22', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:05:15'),
('23', '3', 'LOGOUT', 'auth', 'User manager logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:05:19'),
('24', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:05:21'),
('25', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:05:26'),
('26', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:05:41'),
('27', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:05:53'),
('28', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-25 13:08:38'),
('29', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:11:01'),
('30', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:11:08'),
('31', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:11:11'),
('32', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:11:54'),
('33', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:11:56'),
('34', '1', 'EXPORT_CSV', 'employees', 'Exported employee directory CSV (8 records)', NULL, '::1', 'curl/8.21.0', '2026-09-25 13:23:48'),
('35', '1', 'EXPORT_CSV', 'attendance', 'Exported attendance summary for 2026-9', NULL, '::1', 'curl/8.21.0', '2026-09-25 13:23:48'),
('36', '1', 'EXPORT_CSV', 'payroll_runs', 'Exported bank disbursement file for payroll run #2', '2', '::1', 'curl/8.21.0', '2026-09-25 13:23:49'),
('37', '1', 'EXPORT_CSV', 'payroll_runs', 'Exported statutory compliance report for payroll run #2', '2', '::1', 'curl/8.21.0', '2026-09-25 13:23:49'),
('38', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:25:31'),
('39', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0001', '1', '::1', 'curl/8.21.0', '2026-09-25 13:25:49'),
('40', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0001', '1', '::1', 'curl/8.21.0', '2026-09-25 13:25:57'),
('41', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 13:29:34'),
('42', '2', 'EXPORT_CSV', 'attendance', 'Exported attendance summary for 2026-9', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:04:57'),
('43', '2', 'EXPORT_CSV', 'attendance', 'Exported attendance summary for 2026-9', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:08:42'),
('44', '2', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0007', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:09:40'),
('45', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-25 14:13:28'),
('46', '1', 'HIRE_CANDIDATE_CONVERT', 'employees', 'Converted candidate #2 (Elena Rostova) into active employee EMP0009', '11', '::1', 'curl/8.21.0', '2026-09-25 14:16:09'),
('47', '1', 'ALLOCATE_ASSET', 'assets', 'Allocated asset AST-LAP-004 to Elena Rostova', '5', '::1', 'curl/8.21.0', '2026-09-25 14:17:35'),
('48', '1', 'RETURN_ASSET', 'assets', 'Returned asset AST-LAP-004 as Available (Condition: Pristine condition returned)', '5', '::1', 'curl/8.21.0', '2026-09-25 14:17:52'),
('49', '1', 'SUBMIT_RESIGNATION', 'resignations', 'Submitted resignation notice for EMP0004 (Sophia Chen)', '1', '::1', 'curl/8.21.0', '2026-09-25 14:19:34'),
('50', '1', 'APPROVE_RESIGNATION', 'resignations', 'Approved resignation for case #1 with LWD 2026-10-25', '1', '::1', 'curl/8.21.0', '2026-09-25 14:28:44'),
('51', '1', 'UPDATE_EXIT_CLEARANCE', 'exit_clearances', 'Updated IT clearance to cleared (Dues: $0)', '1', '::1', 'curl/8.21.0', '2026-09-25 14:30:59'),
('52', '1', 'UPDATE_EXIT_CLEARANCE', 'exit_clearances', 'Updated Finance clearance to cleared (Dues: $0)', '2', '::1', 'curl/8.21.0', '2026-09-25 14:31:00'),
('53', '1', 'UPDATE_EXIT_CLEARANCE', 'exit_clearances', 'Updated HR clearance to cleared (Dues: $0)', '3', '::1', 'curl/8.21.0', '2026-09-25 14:31:00'),
('54', '1', 'UPDATE_EXIT_CLEARANCE', 'exit_clearances', 'Updated Admin clearance to cleared (Dues: $0)', '4', '::1', 'curl/8.21.0', '2026-09-25 14:31:00'),
('55', '1', 'CALCULATE_FNF', 'fnf_settlements', 'Computed F&F settlement for EMP0004: Net $10035', '1', '::1', 'curl/8.21.0', '2026-09-25 14:31:24'),
('56', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:36:33'),
('57', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:36:36'),
('58', NULL, 'LOGIN', 'auth', 'User employee logged in successfully.', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:40:09'),
('59', '4', 'LOGOUT', 'auth', 'User employee logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:40:30'),
('60', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 14:40:33'),
('61', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 14:59:20'),
('62', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:10:42'),
('63', '2', 'APPLY_LEAVE', 'leaves', 'Submitted leave request #1 (0.5 days from 2026-09-25 to 2026-09-25)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:12:06'),
('64', '2', 'HR_APPROVE_LEAVE', 'leaves', 'HR fully approved leave request #1. Deducted 0.5 days from balance.', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:12:28'),
('65', '2', 'CREATE_DEPT', 'department', 'Created department it (DEP-IT)', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:15:35'),
('66', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:16:38'),
('67', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:17:40'),
('68', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:17:49'),
('69', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:19:28'),
('70', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-25 15:25:55'),
('71', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-25 15:26:25'),
('72', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-25 15:29:10'),
('73', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:04'),
('74', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:06'),
('75', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:12'),
('76', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:15'),
('77', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:24'),
('78', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:31'),
('79', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:34'),
('80', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:37'),
('81', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-25 15:30:54'),
('82', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-25 15:33:46'),
('83', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-25 15:35:30'),
('84', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:37:01'),
('85', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:37:06'),
('86', '1', 'CLOCK_IN', 'attendance', 'Employee #1 clocked IN at 10:07:38', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:37:38'),
('87', '1', 'CLOCK_OUT', 'attendance', 'Employee #1 clocked OUT at 10:07:41 (Total 0 hrs)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 15:37:41'),
('88', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-25 15:58:12'),
('89', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:15:32'),
('90', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:16:34'),
('91', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-25 16:19:01'),
('92', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:22:19'),
('93', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:22:28'),
('94', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:55:21'),
('95', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:55:26'),
('96', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:55:37'),
('97', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 16:59:09'),
('98', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 17:54:22'),
('99', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 18:23:58'),
('100', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 18:25:45');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('101', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-25 18:26:32'),
('102', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 11:09:16'),
('103', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: $65240).', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 11:32:58'),
('104', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 11:37:46'),
('105', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 11:39:00'),
('106', '1', 'CLOCK_IN', 'attendance', 'Employee #1 clocked IN at 06:38:19', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 12:08:19'),
('107', '1', 'CLOCK_OUT', 'attendance', 'Employee #1 clocked OUT at 06:38:28 (Total 0 hrs)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 12:08:28'),
('108', NULL, 'LOGIN', 'auth', 'User manager logged in successfully.', '3', '::1', '', '2026-09-26 12:30:50'),
('109', '3', 'CORRECTION_APPROVE', 'manager', 'Approved punch correction for Employee ID 6', NULL, '::1', '', '2026-09-26 12:31:13'),
('110', '3', 'OVERTIME_APPROVE_MSS', 'overtime', 'Manager portal approved overtime #1', NULL, '::1', '', '2026-09-26 12:31:14'),
('111', '3', 'REIMBURSEMENT_APPROVE_MSS', 'reimbursements', 'Approved claim ID 1', NULL, '::1', '', '2026-09-26 12:31:15'),
('112', '3', 'LEAVE_APPROVE_MSS', 'leaves', 'Manager Portal approved leave request #2', NULL, '::1', '', '2026-09-26 12:31:16'),
('113', NULL, 'LOGIN', 'auth', 'User manager logged in successfully.', '3', '::1', '', '2026-09-26 12:32:41'),
('114', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', '', '2026-09-26 12:55:16'),
('115', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', '', '2026-09-26 13:01:21'),
('116', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 13:01:58'),
('117', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 13:02:10'),
('118', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 13:02:26'),
('119', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 13:02:38'),
('120', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 13:04:07'),
('121', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-IN) WindowsPowerShell/5.1.26100.9457', '2026-09-26 13:23:27'),
('122', '1', 'CREATE_TEMPLATE', 'document_templates', 'Created template \'OL\' (TPL_OL)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:21:57'),
('123', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OL for EMP0006', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:22:19'),
('124', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OL for EMP0002', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:22:45'),
('125', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_INCREMENT_LETTER for EMP0004', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:23:21'),
('126', '1', 'CREATE_TEMPLATE', 'document_templates', 'Created template \'ii\' (TPL_II)', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:25:57'),
('127', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_II for EMP0007', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:26:08'),
('128', '1', 'CREATE_TEMPLATE', 'document_templates', 'Created template \'demo\' (TPL_DEMO)', '6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:28:06'),
('129', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_DEMO for EMP0008', '6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:28:22'),
('130', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0007', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:28:50'),
('131', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Vishal Ojha (EMP0001).', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:37:53'),
('132', '1', 'DISCIPLINARY_ISSUE', 'disciplinary', 'Issued termination case DIS-20260926-7138 for Employee ID 1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:42:26'),
('133', '1', 'DISCIPLINARY_CLOSE', 'disciplinary', 'Closed disciplinary case ID 1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:42:47'),
('134', '1', 'CAREER_MOVEMENT_SUBMIT', 'career', 'Initiated promotion requisition MOV-20260926-0322 for Employee ID 2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:57:43'),
('135', '1', 'CAREER_MOVEMENT_SUBMIT', 'career', 'Initiated transfer requisition MOV-20260926-CCB9 for Employee ID 8', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 14:59:50'),
('136', '1', 'CAREER_MOVEMENT_REJECT', 'career', 'Rejected career movement record #2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:00:27'),
('137', '1', 'CAREER_MOVEMENT_APPROVE', 'career', 'Approved and synchronized promotion for Employee ID 2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:00:40'),
('138', '1', 'SAVE_LATE_POLICY', 'attendance', 'Configured policy Standard Enterprise Attendance Policy', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:03:21'),
('139', '1', 'SAVE_LATE_POLICY', 'attendance', 'Configured policy Standard Enterprise Attendance Policy', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:03:39'),
('140', '1', 'SHIFT_CREATE', 'shifts', 'Created shift Day', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:05:40'),
('141', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 4 to Employee ID 6', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:16:44'),
('142', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-26 15:20:56'),
('143', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 1 to Employee ID 1', NULL, '::1', '', '2026-09-26 15:20:57'),
('144', '1', 'OVERTIME_REJECT', 'overtime', 'Rejected overtime ID 2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:22:53'),
('145', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 2 to Employee ID 3', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:23:45'),
('146', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 1 to Employee ID 3', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:26:32'),
('147', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36 Edg/153.0.0.0', '2026-09-26 15:37:32'),
('148', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:43:18'),
('149', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:43:35'),
('150', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:43:53'),
('151', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:44:05'),
('152', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:44:12'),
('153', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:44:21'),
('154', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:45:41'),
('155', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:45:44'),
('156', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:50:36'),
('157', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:50:43'),
('158', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-26 15:58:43'),
('159', '1', 'WAIVER_REQUEST', 'attendance', 'Requested waiver for attendance log ID 3', NULL, '::1', '', '2026-09-26 15:58:44'),
('160', '1', 'WAIVER_REQUEST', 'attendance', 'Requested waiver for attendance log ID 1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 15:59:26'),
('161', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-26 16:01:12'),
('162', '1', 'WAIVER_REQUEST', 'attendance', 'Requested waiver for attendance log ID 3', NULL, '::1', '', '2026-09-26 16:01:13'),
('163', '1', 'WAIVER_ACTION', 'attendance', 'Marked waiver #3 as hr_approved', NULL, '::1', '', '2026-09-26 16:01:14'),
('164', '1', 'WAIVER_REQUEST', 'attendance', 'Requested waiver for attendance log ID 1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:01:50'),
('165', '1', 'WAIVER_ACTION', 'attendance', 'Marked waiver #4 as rejected', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:03:29'),
('166', '1', 'WAIVER_ACTION', 'attendance', 'Marked waiver #2 as hr_approved', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:04:23'),
('167', '1', 'HOLIDAY_CREATE', 'holidays', 'Added holiday Ind on 2027-08-15', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:26:39'),
('168', '1', 'HOLIDAY_CREATE', 'holidays', 'Added holiday ind on 2026-08-15', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:27:11'),
('169', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', '', '2026-09-26 16:28:34'),
('170', '1', 'MANUAL_ATTENDANCE_INSERT', 'attendance', 'Manually entered attendance for Employee #2 on 2026-09-26 (Status: Present)', '5', '::1', '', '2026-09-26 16:28:35'),
('171', '1', 'MANUAL_ATTENDANCE_UPDATE', 'attendance', 'Updated attendance for Employee #2 on 2026-09-26 (Status: Late)', '5', '::1', '', '2026-09-26 16:28:36'),
('172', '1', 'HOLIDAY_DELETE', 'holidays', 'Deleted holiday ID 2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:29:51'),
('173', '1', 'HOLIDAY_CREATE', 'holidays', 'Added holiday ind on 2026-08-15', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:30:29'),
('174', '1', 'HOLIDAY_DELETE', 'holidays', 'Deleted holiday ID 3', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:30:35'),
('175', '1', 'MANUAL_ATTENDANCE_INSERT', 'attendance', 'Manually entered attendance for Employee #7 on 2026-09-26 (Status: Present)', '6', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:31:37'),
('176', '1', 'MANUAL_ATTENDANCE_INSERT', 'attendance', 'Manually entered attendance for Employee #8 on 2026-09-26 (Status: Late)', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:44:48'),
('177', '1', 'WAIVER_REQUEST', 'attendance', 'Requested waiver for attendance log ID 7', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:45:31'),
('178', '1', 'WAIVER_ACTION', 'attendance', 'Marked waiver #5 as hr_approved', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:45:39'),
('179', '1', 'WAIVER_ACTION', 'attendance', 'Marked waiver #1 as rejected', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:45:53'),
('180', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 3 to Employee ID 8', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 16:55:37'),
('181', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-26 16:58:21'),
('182', '1', 'REIMBURSEMENT_REJECT', 'reimbursements', 'Rejected claim ID 3', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:02:15'),
('183', '1', 'REIMBURSEMENT_FINANCE_APPROVE', 'reimbursements', 'Finance approved claim ID 1 for ₹45.5', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:02:18'),
('184', '1', 'REIMBURSEMENT_SUBMIT', 'reimbursements', 'Submitted claim CLM-20260926-0C65 for ₹300', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:04:37'),
('185', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-26 17:14:36'),
('186', '1', 'SHIFT_UPDATE', 'shifts', 'Updated shift Day (ID: 4)', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:17:07'),
('187', '1', 'SHIFT_UPDATE', 'shifts', 'Updated shift General Day Shift (ID: 4)', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:17:39'),
('188', '1', 'SHIFT_UPDATE', 'shifts', 'Updated shift General Shift (ID: 4)', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:17:54'),
('189', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 2 to Employee ID 6', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:18:27'),
('190', '1', 'SHIFT_DELETE', 'shifts', 'Deleted shift General Shift (ID: 4)', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:18:44'),
('191', '1', 'SHIFT_CREATE', 'shifts', 'Created shift general', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:19:39'),
('192', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 5 to Employee ID 2', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:19:49'),
('193', '1', 'SHIFT_DELETE', 'shifts', 'Deleted shift general (ID: 5)', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-26 17:20:02'),
('194', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-26 17:28:43'),
('195', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-26 17:28:55'),
('196', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', 'curl/8.21.0', '2026-09-26 17:51:33'),
('197', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:03:39'),
('198', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role HR Admin (assigned 16 permissions).', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:17:12'),
('199', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:17:20'),
('200', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:17:57');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('201', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role HR Admin (assigned 16 permissions).', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:18:53'),
('202', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:18:57'),
('203', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:20:14'),
('204', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:20:16'),
('205', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:20:55'),
('206', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', '', '2026-09-28 11:23:39'),
('207', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:24:08'),
('208', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:25:17'),
('209', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', '', '2026-09-28 11:33:47'),
('210', '1', 'CREATE_TEMPLATE', 'document_templates', 'Created template \'Automated Test Certificate\' (TPL_AUTOMATED_TEST_CERTIFICATE)', '7', '::1', '', '2026-09-28 11:33:48'),
('211', '1', 'UPDATE_TEMPLATE', 'document_templates', 'Updated template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '1', '::1', '', '2026-09-28 11:33:50'),
('212', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '1', '::1', '', '2026-09-28 11:33:51'),
('213', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_AUTOMATED_TEST_CERTIFICATE for EMP0002', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:37:47'),
('214', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_EXPERIENCE_CERT for EMP0002', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:37:56'),
('215', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_INCREMENT_LETTER for EMP0002', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:38:13'),
('216', '1', 'UPDATE_TEMPLATE', 'document_templates', 'Updated template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '2', '::1', '', '2026-09-28 11:38:46'),
('217', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '2', '::1', '', '2026-09-28 11:38:48'),
('218', '1', 'UPDATE_TEMPLATE', 'document_templates', 'Updated template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '3', '::1', '', '2026-09-28 11:39:47'),
('219', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '3', '::1', '', '2026-09-28 11:39:48'),
('220', '1', 'UPDATE_TEMPLATE', 'document_templates', 'Updated template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '4', '::1', '', '2026-09-28 11:40:31'),
('221', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'Automated Test Certificate (Updated)\' (TPL_TEST_UPDATED)', '4', '::1', '', '2026-09-28 11:40:32'),
('222', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:41:55'),
('223', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:42:27'),
('224', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'ii\' (TPL_II)', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:44:25'),
('225', '1', 'CREATE_TEMPLATE', 'document_templates', 'Created template \'Offer letter\' (TPL_OFFER_LETTER)', '11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:46:54'),
('226', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0007', '11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:47:03'),
('227', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:47:24'),
('228', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:47:44'),
('229', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:50:10'),
('230', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:57:00'),
('231', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:59:25'),
('232', '1', 'HOLIDAY_CREATE', 'holidays', 'Added holiday gandhi janati on 2026-10-02', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 11:59:56'),
('233', '1', 'LOAN_APPLY', 'loans', 'Submitted loan request LN-20260928-AEEC for ₹100000', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:02:32'),
('234', '1', 'LOAN_APPROVE', 'loans', 'Approved loan ID 1 and generated 3 EMI schedule rows.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:02:51'),
('235', '1', 'REIMBURSEMENT_REJECT', 'reimbursements', 'Rejected claim ID 4', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:03:33'),
('236', '1', 'BONUS_ENTRY_ADD', 'bonuses', 'Allocated ₹200 incentive to Employee ID 1', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:04:18'),
('237', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:05:05'),
('238', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:08:26'),
('239', '1', 'LOAN_APPLY', 'loans', 'Submitted loan request LN-20260928-6E72 for ₹10000', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:09:07'),
('240', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:09:21'),
('241', '4', 'LOAN_APPLY', 'loans', 'Submitted loan request LN-20260928-CE86 for ₹10000', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:09:48'),
('242', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:10:19'),
('243', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:10:32'),
('244', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:11:16'),
('245', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:11:28'),
('246', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:11:39'),
('247', '5', 'LOAN_APPLY', 'loans', 'Submitted loan request LN-20260928-FCA1 for ₹20000', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:12:14'),
('248', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:12:22'),
('249', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', '', '2026-09-28 12:12:59'),
('250', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:13:09'),
('251', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Jack Jha (EMP0010) with user account \'jackjha\'.', '12', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:15:21'),
('252', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:15:52'),
('253', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:16:49'),
('254', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:17:29'),
('255', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:18:10'),
('256', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:18:14'),
('257', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:18:18'),
('258', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:18:47'),
('259', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:19:29'),
('260', NULL, 'LOGIN', 'auth', 'User employee logged in successfully.', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:19:44'),
('261', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:20:10'),
('262', '1', 'LOAN_APPROVE', 'loans', 'Approved loan ID 4 and generated 3 EMI schedule rows.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:20:19'),
('263', '1', 'LOAN_APPROVE', 'loans', 'Approved loan ID 3 and generated 3 EMI schedule rows.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:20:22'),
('264', '1', 'LOAN_APPROVE', 'loans', 'Approved loan ID 2 and generated 3 EMI schedule rows.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:20:25'),
('265', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:20:29'),
('266', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:20:43'),
('267', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:23:49'),
('268', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:24:02'),
('269', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:24:06'),
('270', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:25:43'),
('271', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:28:24'),
('272', NULL, 'LOGIN', 'auth', 'User anirbanpaul logged in successfully.', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:28:35'),
('273', '7', 'LOGOUT', 'auth', 'User anirbanpaul logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:28:43'),
('274', NULL, 'LOGIN', 'auth', 'User anirbanpaul logged in successfully.', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:29:07'),
('275', '7', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Anirban Paul (EMP0011) with user account \'anirbanpaul33\'.', '13', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:29:45'),
('276', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:30:16'),
('277', '4', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Anirban Paul (EMP0012) with user account \'anirbanpaul18\'.', '14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:30:43'),
('278', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 1 permissions).', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:31:14'),
('279', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 1 permissions).', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:31:20'),
('280', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:31:23'),
('281', '4', 'LOGOUT', 'auth', 'User employee logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:31:28'),
('282', NULL, 'LOGIN', 'auth', 'User anirbanpaul logged in successfully.', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:31:37'),
('283', '7', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Anirban Paul (EMP0013) with user account \'anirbanpaul53\'.', '15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:31:53'),
('284', '7', 'PASSWORD_CHANGE', 'auth', 'User anirbanpaul changed their security password.', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:34:13'),
('285', '7', 'LOGOUT', 'auth', 'User anirbanpaul logged out.', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:34:20'),
('286', NULL, 'LOGIN', 'auth', 'User anirbanpaul logged in successfully.', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:34:31'),
('287', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', '', '2026-09-28 12:49:36'),
('288', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee TestManager Lead6769 (EMPTEST6769) with role \'Manager / Department Head\' and user account \'mgr.test6769\'.', '16', '::1', '', '2026-09-28 12:49:37'),
('289', NULL, 'LOGIN', 'auth', 'User mgr.test6769 logged in successfully.', '14', '::1', '', '2026-09-28 12:49:39'),
('290', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee TestHRAdmin Lead2631 (EMPHR2631) with role \'HR Admin\' and user account \'hradmin.test2631\'.', '17', '::1', '', '2026-09-28 12:50:33'),
('291', NULL, 'LOGIN', 'auth', 'User hradmin.test2631 logged in successfully.', '15', '::1', '', '2026-09-28 12:50:34'),
('292', '7', 'CLOCK_IN', 'attendance', 'Employee #7 clocked IN at 07:23:04', '8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:04'),
('293', '7', 'CLOCK_OUT', 'attendance', 'Employee #7 clocked OUT at 07:23:07 (Total 0 hrs)', '8', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:07'),
('294', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:29'),
('295', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:37'),
('296', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:40'),
('297', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:42'),
('298', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:53'),
('299', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:53:59'),
('300', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:54:08');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('301', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:54:48'),
('302', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 1 permissions).', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:55:30'),
('303', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 1 permissions).', '7', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 12:55:36'),
('304', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '::1', '', '2026-09-28 13:05:25'),
('305', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '::1', '', '2026-09-28 13:05:27'),
('306', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.18', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Mobile Safari/537.36', '2026-09-28 13:06:43'),
('307', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:07:15'),
('308', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:07:23'),
('309', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:07:30'),
('310', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:07:37'),
('311', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:07:50'),
('312', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:08:01'),
('313', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:08:28'),
('314', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.7', 'Mozilla/5.0 (iPhone; CPU iPhone OS 27_0_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/154.0.8037.55 Mobile/15E148 Safari/604.1', '2026-09-28 13:10:52'),
('315', '4', 'CREATE_DEPT', 'department', 'Created department PRIYANSHU PAUL (sh-nigh)', '8', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:10:53'),
('316', '4', 'CREATE_JOB', 'job_openings', 'Created job requisition JOB-2026-004 (kmlnm)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:11:57'),
('317', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'demo\' (TPL_DEMO)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:12:34'),
('318', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'Automated Test Certificate\' (TPL_AUTOMATED_TEST_CERTIFICATE)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:12:39'),
('319', '1', 'DELETE_TEMPLATE', 'document_templates', 'Deleted template \'Offer letter\' (TPL_OFFER_LETTER)', '11', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:12:44'),
('320', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:14:24'),
('321', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:14:27'),
('322', '4', 'HR_APPROVE_LEAVE', 'leaves', 'HR fully approved leave request #3. Deducted 3.0 days from balance.', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:15:11'),
('323', '4', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for November 2026 (14 payslips, Net: ₹72007.02).', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:15:31'),
('324', '4', 'LOAN_APPLY', 'loans', 'Submitted loan request LN-20260928-8CA0 for ₹10000000', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:16:13'),
('325', '4', 'SUBMIT_RESIGNATION', 'resignations', 'Submitted resignation notice for EMP0013 (Anirban Paul)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:18:32'),
('326', '4', 'EXPORT_CSV', 'payroll_runs', 'Exported statutory compliance report for payroll run #2', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:22:25'),
('327', '4', 'EXPORT_CSV', 'employees', 'Exported employee directory CSV (15 records)', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:22:32'),
('328', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 3 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:22:33'),
('329', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:23:12'),
('330', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 6 permissions).', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:23:49'),
('331', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 7 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:24:19'),
('332', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Accountant (assigned 5 permissions).', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:24:56'),
('333', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Payroll Manager (assigned 6 permissions).', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:25:52'),
('334', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 6 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:27:02'),
('335', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:27:20'),
('336', NULL, 'LOGIN', 'auth', 'User anirbanpaul logged in successfully.', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 13:27:41'),
('337', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:02:58'),
('338', '4', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0007', '12', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:03:25'),
('339', '4', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_EXPERIENCE_LETTER for EMP0007', '13', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:03:46'),
('340', '4', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_INCREMENT_LETTER for EMP0007', '14', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:04:09'),
('341', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:04:53'),
('342', '4', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0007', '12', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:05:20'),
('343', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:06:06'),
('344', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '::1', '', '2026-09-28 14:09:02'),
('345', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0001', '12', '::1', '', '2026-09-28 14:09:18'),
('346', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_EXPERIENCE_LETTER for EMP0001', '13', '::1', '', '2026-09-28 14:09:18'),
('347', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_INCREMENT_LETTER for EMP0001', '14', '::1', '', '2026-09-28 14:09:19'),
('348', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0007', '12', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:11:00'),
('349', '4', 'APPLY_LEAVE', 'leaves', 'Submitted leave request #4 (3 days from 2026-09-28 to 2026-09-30)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:12:10'),
('350', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:12:36'),
('351', '1', 'HR_APPROVE_LEAVE', 'leaves', 'HR fully approved leave request #4. Deducted 3.0 days from balance.', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:12:52'),
('352', '1', 'HR_APPROVE_LEAVE', 'leaves', 'HR fully approved leave request #2. Deducted 3.0 days from balance.', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:12:59'),
('353', '1', 'CORRECTION_APPROVE', 'manager', 'Approved punch correction for Employee ID 6', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:15:29'),
('354', '1', 'SUBMIT_RESIGNATION', 'resignations', 'Submitted resignation notice for EMP0009 (Elena Rostova)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:18:30'),
('355', '1', 'APPROVE_RESIGNATION', 'resignations', 'Approved resignation for case #3 with LWD 2026-09-29', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:18:44'),
('356', '1', 'CALCULATE_FNF', 'fnf_settlements', 'Computed F&F settlement for EMP0009: Net ₹4500', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:18:54'),
('357', '1', 'DISCIPLINARY_ISSUE', 'disciplinary', 'Issued verbal_warning case DIS-20260928-EE94 for Employee ID 14', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:20:44'),
('358', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_EXPERIENCE_LETTER for EMP0007', '13', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:21:32'),
('359', '1', 'UPLOAD_DOCUMENT', 'employee_docs', 'Uploaded document \'adhaar card scan completed\' (national_id) for employee #1.', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:24:02'),
('360', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:25:14'),
('361', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:25:26'),
('362', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:25:32'),
('363', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:25:35'),
('364', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:25:39'),
('365', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:25:42'),
('366', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:26:51'),
('367', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:27:01'),
('368', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:27:12'),
('369', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:27:18'),
('370', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:27:26'),
('371', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:27:33'),
('372', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:28:12'),
('373', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:28:26'),
('374', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:28:43'),
('375', '5', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for November 2026 (14 payslips, Net: ₹118320).', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:29:50'),
('376', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 5 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:30:37'),
('377', '5', 'LOAN_APPROVE', 'loans', 'Approved loan ID 5 and generated 12 EMI schedule rows.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:30:41'),
('378', '4', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 5 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:30:47'),
('379', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:34:34'),
('380', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:34:53'),
('381', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:35:04'),
('382', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:35:17'),
('383', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:36:29'),
('384', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:36:52'),
('385', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:41:13'),
('386', '4', 'CLOCK_IN', 'attendance', 'Employee #4 clocked IN at 09:13:50', '9', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:43:50'),
('387', '4', 'CLOCK_OUT', 'attendance', 'Employee #4 clocked OUT at 09:13:52 (Total 0 hrs)', '9', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:43:52'),
('388', '4', 'APPLY_LEAVE', 'leaves', 'Submitted leave request #5 (1 days from 2026-09-28 to 2026-09-28)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:46:26'),
('389', '4', 'OVERTIME_APPLY', 'overtime', 'Submitted 2 hours overtime request for 2026-09-28', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:48:23'),
('390', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:49:22'),
('391', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:49:32'),
('392', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '127.0.0.1', '', '2026-09-28 14:50:10'),
('393', NULL, 'LOGIN', 'auth', 'User hradmin logged in successfully.', '2', '127.0.0.1', '', '2026-09-28 14:50:13'),
('394', NULL, 'LOGIN', 'auth', 'User hrexecutive logged in successfully.', '17', '127.0.0.1', '', '2026-09-28 14:50:17'),
('395', NULL, 'LOGIN', 'auth', 'User payroll logged in successfully.', '5', '127.0.0.1', '', '2026-09-28 14:50:20'),
('396', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:50:22'),
('397', NULL, 'LOGIN', 'auth', 'User accountant logged in successfully.', '16', '127.0.0.1', '', '2026-09-28 14:50:24'),
('398', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:50:35'),
('399', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:04'),
('400', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:15');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('401', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:25'),
('402', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (anirbanpaul)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:30'),
('403', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:36'),
('404', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (accountant)', '16', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:40'),
('405', '1', 'MANUAL_ATTENDANCE_INSERT', 'attendance', 'Manually entered attendance for Employee #14 on 2026-09-28 (Status: Late)', '10', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:43'),
('406', '16', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:44'),
('407', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:48'),
('408', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:58'),
('409', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:51:59'),
('410', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:04'),
('411', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (anirbanpaul)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:06'),
('412', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:19'),
('413', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:40'),
('414', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 6 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:41'),
('415', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 4 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:48'),
('416', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:52'),
('417', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (accountant)', '16', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:52:56'),
('418', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:53:24'),
('419', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 5 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:53:58'),
('420', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 5 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:54:12'),
('421', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:54:22'),
('422', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:54:28'),
('423', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:54:33'),
('424', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 6 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:54:54'),
('425', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 4 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:55:02'),
('426', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:55:09'),
('427', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:55:14'),
('428', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:55:29'),
('429', '16', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:55:49'),
('430', '4', 'OVERTIME_APPLY', 'overtime', 'Submitted 3 hours overtime request for 2026-09-28', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:56:21'),
('431', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0009', '12', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:57:03'),
('432', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:57:23'),
('433', '1', 'HOLIDAY_CREATE', 'holidays', 'Added holiday chirsmas  on 2026-12-25', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:57:58'),
('434', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:58:19'),
('435', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 14:58:28'),
('436', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:00:19'),
('437', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '127.0.0.1', '', '2026-09-28 15:07:26'),
('438', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee DeleteMe Tester (DELTEST001).', '18', '127.0.0.1', '', '2026-09-28 15:07:30'),
('439', NULL, 'LOGIN', 'auth', 'User hrexecutive logged in successfully.', '17', '127.0.0.1', '', '2026-09-28 15:07:30'),
('440', '3', 'LEAVE_APPROVE_MSS', 'leaves', 'Manager Portal approved leave request #5', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:10:06'),
('441', '3', 'OVERTIME_APPROVE_MSS', 'overtime', 'Manager portal approved overtime #4', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:10:11'),
('442', '3', 'OVERTIME_APPROVE_MSS', 'overtime', 'Manager portal approved overtime #3', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:10:14'),
('443', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:10:41'),
('444', NULL, 'LOGIN', 'auth', 'User hrexecutive logged in successfully.', '17', '127.0.0.1', '', '2026-09-28 15:10:51'),
('445', NULL, 'LOGIN', 'auth', 'User superadmin logged in successfully.', '1', '127.0.0.1', '', '2026-09-28 15:11:53'),
('446', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee DeleteMe Tester (DELTEST001).', '19', '127.0.0.1', '', '2026-09-28 15:11:55'),
('447', NULL, 'LOGIN', 'auth', 'User hrexecutive logged in successfully.', '17', '127.0.0.1', '', '2026-09-28 15:11:56'),
('448', '1', 'PROBATION_ASSESSMENT', 'probation', 'Manager evaluated probation record #1 with recommendation: confirm', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:12:25'),
('449', '1', 'PROBATION_CONFIRM', 'probation', 'Confirmed Employee ID 11 into full-time employment', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:12:52'),
('450', '1', 'CREATE_DEPT', 'department', 'Created department Quality Assurance (QA)', '9', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:13:32'),
('451', '1', 'HR_APPROVE_LEAVE', 'leaves', 'HR fully approved leave request #5. Deducted 1.0 days from balance.', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:14:59'),
('452', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Anirban PAUL (EMP0007).', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:17:49'),
('453', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Jack Jha (EMP0010).', '12', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:18:06'),
('454', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:26:09'),
('455', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:26:20'),
('456', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 5 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:26:34'),
('457', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:26:38'),
('458', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:26:51'),
('459', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 4 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:27:06'),
('460', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:27:09'),
('461', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:27:49'),
('462', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:32:44'),
('463', NULL, 'LOGIN', 'auth', 'User hradmin logged in successfully.', '2', '127.0.0.1', '', '2026-09-28 15:33:18'),
('464', '2', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee David Miller2740 (EMP0014) with role \'Employee\' and user account \'dmiller2740\'.', '23', '127.0.0.1', '', '2026-09-28 15:33:19'),
('465', NULL, 'LOGIN', 'auth', 'User hradmin logged in successfully.', '2', '127.0.0.1', '', '2026-09-28 15:36:02'),
('466', '2', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Sarah Connor2697 (EMP0015) with role \'Employee\' and user account \'sconnor2697\'.', '24', '127.0.0.1', '', '2026-09-28 15:36:03'),
('467', NULL, 'LOGIN', 'auth', 'User hradmin logged in successfully.', '2', '127.0.0.1', '', '2026-09-28 15:37:04'),
('468', '2', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee David Miller4742 (EMP0014) with role \'Employee\' and user account \'dmiller4742\'.', '25', '127.0.0.1', '', '2026-09-28 15:37:05'),
('469', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Subham Das (EMP00001) with role \'Super Admin\' and user account \'subham.das\'.', '26', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:39:16'),
('470', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (anirbanpaul)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:41:11'),
('471', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Subham Das (EMP00001).', '26', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:42:10'),
('472', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:43:03'),
('473', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Subham Das (EMP00001).', '26', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:43:28'),
('474', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (accountant)', '16', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:45:13'),
('475', '16', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:50:57'),
('476', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:53:29'),
('477', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:53:34'),
('478', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:54:16'),
('479', '3', 'CLOCK_IN', 'attendance', 'Employee #3 clocked IN at 10:24:58', '11', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:54:58'),
('480', '3', 'MANUAL_ATTENDANCE_UPDATE', 'attendance', 'Updated attendance for Employee #4 on 2026-09-28 (Status: Present)', '9', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:57:59'),
('481', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:58:21'),
('482', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Karan Upadhyay (EMP0014) with role \'Manager / Department Head\' and user account \'karan.upadhyay\'.', '27', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:59:19'),
('483', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee hiloo kumar (EMP0015) with role \'Super Admin\' and user account \'hiloo.kumar\'.', '28', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:59:34'),
('484', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for hiloo kumar (EMP0015).', '28', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 15:59:53'),
('485', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:00:07'),
('486', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:00:34'),
('487', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:00:39'),
('488', NULL, 'LOGIN', 'auth', 'User hiloo.kumar logged in successfully.', '26', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:00:40'),
('489', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Priyanshu Paul (EMP0001). Portal password updated.', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:03:20'),
('490', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee KARAN Up (EMP0008).', '8', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:04:10'),
('491', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Eleanor Vance (EMP0002).', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:04:21'),
('492', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Marcus Sterling (EMP0003).', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:04:26'),
('493', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Sophia Chen (EMP0004).', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:04:31'),
('494', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Julian Mercer (EMP0005).', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:04:37'),
('495', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Elena Rostova (EMP0009).', '11', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:04:44'),
('496', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee TestManager Lead6769 (EMPTEST6769).', '16', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:04:52'),
('497', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee TestHRAdmin Lead2631 (EMPHR2631).', '17', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:05:00'),
('498', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee hiloo kumar (EMP0015).', '28', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:05:08'),
('499', '26', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_INCREMENT_LETTER for EMP00001', '14', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:09:33'),
('500', '26', 'DISCIPLINARY_CLOSE', 'disciplinary', 'Closed disciplinary case ID 2', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:14:28');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('501', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', '', '2026-09-28 16:17:02'),
('502', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', '', '2026-09-28 16:18:42'),
('503', '2', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Marcus Vance2359 (EMP0016) with role \'Employee\' and user account \'mvance2359\'.', '29', '192.168.1.19', '', '2026-09-28 16:18:43'),
('504', '26', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:21:00'),
('505', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:21:36'),
('506', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:27:14'),
('507', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', '', '2026-09-28 16:27:56'),
('508', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', '', '2026-09-28 16:28:52'),
('509', '2', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee David Miller8718 (EMP0016) with role \'Employee\' and user account \'dmiller8718\'.', '30', '192.168.1.19', '', '2026-09-28 16:28:52'),
('510', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Subham Das (EMP0006).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:30:21'),
('511', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Anirban Paul (EMP0011).', '13', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:30:26'),
('512', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Anirban Paul (EMP0012).', '14', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:30:31'),
('513', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Anirban Paul (EMP0013).', '15', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:30:39'),
('514', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Subham Das (EMP00001).', '26', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:30:46'),
('515', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee alexender saha (EMP0016) with role \'Employee\' and user account \'alexender.saha\'.', '31', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:31:04'),
('516', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for alexender saha (EMP0016).', '31', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:37:45'),
('517', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (accountant)', '16', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:40:17'),
('518', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', '', '2026-09-28 16:42:51'),
('519', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', '', '2026-09-28 16:43:33'),
('520', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', '', '2026-09-28 16:44:29'),
('521', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', '', '2026-09-28 16:44:29'),
('522', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (hrexecutive)', '3', '192.168.1.19', '', '2026-09-28 16:44:30'),
('523', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '4', '192.168.1.19', '', '2026-09-28 16:44:30'),
('524', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (accountant)', '5', '192.168.1.19', '', '2026-09-28 16:44:31'),
('525', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (manager)', '6', '192.168.1.19', '', '2026-09-28 16:44:31'),
('526', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '7', '192.168.1.19', '', '2026-09-28 16:44:32'),
('527', '1', 'LOGOUT', 'auth', 'User superadmin logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:52:02'),
('528', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:52:20'),
('529', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', '', '2026-09-28 16:52:29'),
('530', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.19', '', '2026-09-28 16:52:30'),
('531', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:52:35'),
('532', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', '', '2026-09-28 16:53:25'),
('533', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.19', '', '2026-09-28 16:53:26'),
('534', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:11'),
('535', '16', 'LOGOUT', 'auth', 'User accountant logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:21'),
('536', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:26'),
('537', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:27'),
('538', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:30'),
('539', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:33'),
('540', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:35'),
('541', '2', 'LOGOUT', 'auth', 'User hradmin logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:38'),
('542', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:42'),
('543', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:45'),
('544', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:45'),
('545', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:51'),
('546', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:55:52'),
('547', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (payroll)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:56:00'),
('548', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:56:04'),
('549', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (priyanshu)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:56:06'),
('550', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 16:56:20'),
('551', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:05:45'),
('552', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:05:54'),
('553', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', '', '2026-09-28 17:07:03'),
('554', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', '', '2026-09-28 17:07:04'),
('555', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.19', '', '2026-09-28 17:07:04'),
('556', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', '', '2026-09-28 17:07:05'),
('557', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.19', '', '2026-09-28 17:07:05'),
('558', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', '', '2026-09-28 17:07:06'),
('559', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', '', '2026-09-28 17:07:07'),
('560', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', '', '2026-09-28 17:07:07'),
('561', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:07:15'),
('562', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:07:30'),
('563', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:07:59'),
('564', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:09:11'),
('565', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:09:17'),
('566', '6', 'LOGOUT', 'auth', 'User demo.manager logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:09:23'),
('567', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:09:33'),
('568', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', '', '2026-09-28 17:10:08'),
('569', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', '', '2026-09-28 17:10:08'),
('570', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.19', '', '2026-09-28 17:10:09'),
('571', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', '', '2026-09-28 17:10:10'),
('572', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.19', '', '2026-09-28 17:10:10'),
('573', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', '', '2026-09-28 17:10:11'),
('574', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', '', '2026-09-28 17:10:11'),
('575', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', '', '2026-09-28 17:10:12'),
('576', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:10:18'),
('577', NULL, 'LOGIN', 'auth', 'User demo.superadmin logged in successfully.', '1', '192.168.1.19', '', '2026-09-28 17:13:03'),
('578', NULL, 'LOGIN', 'auth', 'User demo.superadmin logged in successfully.', '1', '192.168.1.19', '', '2026-09-28 17:13:04'),
('579', NULL, 'LOGIN', 'auth', 'User demo.hradmin logged in successfully.', '2', '192.168.1.19', '', '2026-09-28 17:13:05'),
('580', NULL, 'LOGIN', 'auth', 'User demo.hradmin logged in successfully.', '2', '192.168.1.19', '', '2026-09-28 17:13:05'),
('581', NULL, 'LOGIN', 'auth', 'User demo.employee logged in successfully.', '7', '192.168.1.19', '', '2026-09-28 17:13:06'),
('582', NULL, 'LOGIN', 'auth', 'User demo.employee logged in successfully.', '7', '192.168.1.19', '', '2026-09-28 17:13:06'),
('583', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', '', '2026-09-28 17:17:57'),
('584', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', '', '2026-09-28 17:18:15'),
('585', '1', 'CREATE_DEPT', 'department', 'Created department Cloud Infrastructure & DevOps (DEP-CLD)', '10', '192.168.1.19', '', '2026-09-28 17:18:16'),
('586', '1', 'UPDATE_DEPT', 'department', 'Updated department Cloud Platform & SRE Engineering (DEP-SRE)', '10', '192.168.1.19', '', '2026-09-28 17:18:16'),
('587', '1', 'DELETE_DEPT', 'department', 'Deleted department Cloud Platform & SRE Engineering (DEP-SRE)', '10', '192.168.1.19', '', '2026-09-28 17:18:17'),
('588', '1', 'DELETE_DEPT', 'department', 'Deleted department it (DEP-IT)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:19:28'),
('589', '1', 'UPDATE_DEPT', 'department', 'Updated department abc (SH-NIGH)', '8', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:19:43'),
('590', '1', 'DELETE_DEPT', 'department', 'Deleted department abc (SH-NIGH)', '8', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:19:50'),
('591', '1', 'LOGOUT', 'auth', 'User priyanshu logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:20:13'),
('592', '1', 'CREATE_DEPT', 'department', 'Created department Information Technology (DEP-IT)', '11', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:21:34'),
('593', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:23:48'),
('594', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:23:54'),
('595', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:24:03'),
('596', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹53060).', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:24:12'),
('597', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for October 2026 (7 payslips, Net: ₹53060).', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:24:55'),
('598', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹53060).', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:25:25'),
('599', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹53060).', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:25:28'),
('600', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for April 2026 (7 payslips, Net: ₹53060).', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:26:27');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('601', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for November 2026 (7 payslips, Net: ₹53060).', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:26:36'),
('602', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee vishal jha (EMP0008) with role \'Employee\' and user account \'vishal.jha\'.', '8', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:32:23'),
('603', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:32:33'),
('604', NULL, 'LOGIN', 'auth', 'User vishal.jha logged in successfully.', '8', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:32:50'),
('605', '8', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:33:12'),
('606', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:34:11'),
('607', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '127.0.0.1', '', '2026-09-28 17:34:15'),
('608', '1', 'UPDATE_PAYROLL_RUN', 'payroll', 'Updated payroll cycle #5 (Payroll Run - Special Revision 5) - Status: frozen, Month: 8/2026.', '5', '127.0.0.1', '', '2026-09-28 17:34:16'),
('609', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #5 (Payroll Run - Special Revision 5) and associated payslips.', '5', '127.0.0.1', '', '2026-09-28 17:34:16'),
('610', '7', 'LOGOUT', 'auth', 'User demo.employee logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:34:17'),
('611', NULL, 'LOGIN', 'auth', 'User vishal.jha logged in successfully.', '8', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:34:33'),
('612', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '127.0.0.1', '', '2026-09-28 17:35:33'),
('613', '8', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:35:53'),
('614', '1', 'UPDATE_PAYROLL_RUN', 'payroll', 'Updated payroll cycle #2 (Payroll Run - September 2026) - Status: disbursed, Month: 9/2026.', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:41:13'),
('615', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:43:19'),
('616', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:43:22'),
('617', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #4 (Payroll Run - October 2026) and associated payslips.', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:44:19'),
('618', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #3 (Payroll Run - November 2026) and associated payslips.', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:44:25'),
('619', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #2 (Payroll Run - September 2026) and associated payslips.', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:44:36'),
('620', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for August 2026 (8 payslips, Net: ₹60640).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:44:50'),
('621', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #6 (Payroll Run - August 2026) and associated payslips.', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:47:51'),
('622', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee vishal jha (EMP0008).', '8', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:48:16'),
('623', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹53060).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:48:28'),
('624', '1', 'CREATE_DEPT', 'department', 'Created department Data (Dat)', '12', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:51:16'),
('625', '1', 'SAVE_LATE_POLICY', 'attendance', 'Configured policy Standard Enterprise Attendance Policy', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:52:14'),
('626', '1', 'SHIFT_CREATE', 'shifts', 'Created shift night shift', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:53:17'),
('627', '1', 'HOLIDAY_CREATE', 'holidays', 'Added holiday Mohaloya on 2026-09-28', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:54:50'),
('628', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:55:27'),
('629', '7', 'APPLY_LEAVE', 'leaves', 'Submitted leave request #1 (1 days from 2026-09-28 to 2026-09-28)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:55:59'),
('630', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:56:27'),
('631', '2', 'HR_APPROVE_LEAVE', 'leaves', 'HR fully approved leave request #1. Deducted 1.0 days from balance.', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:56:36'),
('632', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:56:43'),
('633', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:56:45'),
('634', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:56:48'),
('635', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:56:50'),
('636', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:56:53'),
('637', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:57:02'),
('638', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:57:32'),
('639', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '127.0.0.1', '', '2026-09-28 17:57:52'),
('640', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:57:56'),
('641', '1', 'SHIFT_UPDATE', 'shifts', 'Updated shift Night Shift(9 PM - 06 AM) (ID: 6)', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 17:59:55'),
('642', '1', 'SHIFT_UPDATE', 'shifts', 'Updated shift Night Shift(9 PM - 06 AM) (ID: 6)', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:00:02'),
('643', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '127.0.0.1', '', '2026-09-28 18:00:06'),
('644', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Rohan Trainee (TEST-SAL-4495) with role \'Employee\' and user account \'rohantrainee\'.', '9', '127.0.0.1', '', '2026-09-28 18:00:07'),
('645', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Rohan Trainee (TEST-SAL-4495).', '9', '127.0.0.1', '', '2026-09-28 18:00:08'),
('646', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:00:13'),
('647', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:00:38'),
('648', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:00:51'),
('649', '1', 'UPDATE_DEPT', 'department', 'Updated department Data (DAT)', '12', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:01:24'),
('650', '7', 'REIMBURSEMENT_SUBMIT', 'reimbursements', 'Submitted claim CLM-20260928-27E8 for ₹120', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:01:27'),
('651', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:01:34'),
('652', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:01:55'),
('653', '1', 'UPDATE_DEPT', 'department', 'Updated department Data Analyst (DAT)', '12', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:01:58'),
('654', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:02:14'),
('655', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:02:25'),
('656', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:02:29'),
('657', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:02:38'),
('658', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:02:41'),
('659', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:02:45'),
('660', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:02:47'),
('661', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:03:03'),
('662', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:03:10'),
('663', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:03:18'),
('664', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:03:25'),
('665', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 8 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:04'),
('666', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:09'),
('667', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:18'),
('668', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:20'),
('669', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:21'),
('670', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:27'),
('671', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:31'),
('672', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:32'),
('673', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:38'),
('674', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:04:40'),
('675', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:05:14'),
('676', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.18', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Mobile Safari/537.36', '2026-09-28 18:05:29'),
('677', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.18', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 18:05:36'),
('678', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Manager / Department Head (assigned 6 permissions).', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:05:41'),
('679', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.18', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-28 18:05:42'),
('680', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:05:54'),
('681', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:06:09'),
('682', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:06:13'),
('683', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:06:30'),
('684', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:06:38'),
('685', '4', 'REIMBURSEMENT_FINANCE_APPROVE', 'reimbursements', 'Finance approved claim ID 1 for ₹120', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:06:45'),
('686', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:07:02'),
('687', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:07:28'),
('688', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:07:42'),
('689', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:08:23'),
('690', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:08:26'),
('691', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:08:47'),
('692', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:09:07'),
('693', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:09:11'),
('694', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:09:20'),
('695', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:09:22'),
('696', '4', 'REIMBURSEMENT_SUBMIT', 'reimbursements', 'Submitted claim CLM-20260928-DF9C for ₹349', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:09:57'),
('697', '4', 'REIMBURSEMENT_FINANCE_APPROVE', 'reimbursements', 'Finance approved claim ID 2 for ₹349', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:10:02'),
('698', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:10:14'),
('699', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:10:20'),
('700', '1', 'UPDATE_DEPT', 'department', 'Updated department Data Analyst (DEP-DAT)', '12', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:10:50');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('701', '1', 'POLICY_ACKNOWLEDGE', 'policies', 'Employee ID 1 signed policy ID 1', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:11:08'),
('702', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹53529).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:12:16'),
('703', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '127.0.0.1', '', '2026-09-28 18:12:48'),
('704', '1', 'POLICY_ACKNOWLEDGE', 'policies', 'Employee ID 1 signed policy ID 1', NULL, '127.0.0.1', '', '2026-09-28 18:12:48'),
('705', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:16:28'),
('706', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:16:39'),
('707', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:17:25'),
('708', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:19:02'),
('709', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:19:07'),
('710', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:19:11'),
('711', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:19:16'),
('712', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:19:20'),
('713', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:19:30'),
('714', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:22:46'),
('715', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:22:48'),
('716', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:23:11'),
('717', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:23:28'),
('718', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:24:02'),
('719', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:24:29'),
('720', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:26:16'),
('721', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:26:26'),
('722', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:26:28'),
('723', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:26:33'),
('724', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:26:36'),
('725', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:26:59'),
('726', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 3 permissions).', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:28:20'),
('727', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:31:05'),
('728', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:31:08'),
('729', '4', 'REIMBURSEMENT_SUBMIT', 'reimbursements', 'Submitted claim CLM-20260928-B50B for ₹349', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:31:58'),
('730', '4', 'REIMBURSEMENT_FINANCE_APPROVE', 'reimbursements', 'Finance approved claim ID 3 for ₹349', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:01'),
('731', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:24'),
('732', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:25'),
('733', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:28'),
('734', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:33'),
('735', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:36'),
('736', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:36'),
('737', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:39'),
('738', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:46'),
('739', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:50'),
('740', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:32:51'),
('741', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:33:07'),
('742', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:33:22'),
('743', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:33:24'),
('744', '3', 'REIMBURSEMENT_SUBMIT', 'reimbursements', 'Submitted claim CLM-20260928-1F8D for ₹100', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:33:48'),
('745', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:33:54'),
('746', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:33:59'),
('747', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:34:12'),
('748', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:34:18'),
('749', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:34:24'),
('750', '5', 'REIMBURSEMENT_REJECT', 'reimbursements', 'Rejected claim ID 4', NULL, '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:34:33'),
('751', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '127.0.0.1', '', '2026-09-28 18:35:03'),
('752', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '127.0.0.1', '', '2026-09-28 18:35:04'),
('753', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '127.0.0.1', '', '2026-09-28 18:35:05'),
('754', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '127.0.0.1', '', '2026-09-28 18:35:07'),
('755', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '127.0.0.1', '', '2026-09-28 18:35:08'),
('756', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '127.0.0.1', '', '2026-09-28 18:35:09'),
('757', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '127.0.0.1', '', '2026-09-28 18:35:10'),
('758', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '127.0.0.1', '', '2026-09-28 18:35:11'),
('759', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.19', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-28 18:35:49'),
('760', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:02:17'),
('761', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:03:25'),
('762', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:08:47'),
('763', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:08:54'),
('764', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:13:09'),
('765', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:13:18'),
('766', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Demo Employee (EMP0007).', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:16:32'),
('767', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹93359).', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:18:49'),
('768', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for October 2026 (7 payslips, Net: ₹93010).', '8', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:19:09'),
('769', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Rishav xyz (EMP0009) with role \'Employee\' and user account \'rishav.xyz\'.', '10', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:21:40'),
('770', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Ronaldo cr7 (EMP0010) with role \'Employee\' and user account \'ronaldo.cr7\'.', '11', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:23:54'),
('771', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Ronaldo cr7 (EMP0010).', '11', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:24:12'),
('772', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Ronaldo cr7 (EMP0011) with role \'HR Executive\' and user account \'ronaldocr7\'.', '12', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:25:32'),
('773', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Ronaldo cr7 (EMP0011).', '12', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:26:10'),
('774', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Rishav xyz (EMP0009).', '10', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:26:20'),
('775', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹93010).', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:27:24'),
('776', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #8 (Payroll Run - October 2026) and associated payslips.', '8', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:27:37'),
('777', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:28:55'),
('778', '1', 'CREATE_DESIGNATION', 'designation', 'Created designation Analysis (DES-analysis)', '8', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:29:31'),
('779', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for December 2026 (7 payslips, Net: ₹93010).', '9', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:30:49'),
('780', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:30:56'),
('781', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #9 (Payroll Run - December 2026) and associated payslips.', '9', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:31:04'),
('782', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #7 (Payroll Run - September 2026) and associated payslips.', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:31:08'),
('783', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (7 payslips, Net: ₹93010).', '10', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:31:18'),
('784', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '::1', 'curl/8.21.0', '2026-09-29 11:35:04'),
('785', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Ronaldo CR7 (EMP0012) with role \'Employee\' and user account \'ronaldo.cr714\'.', '13', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:42:58'),
('786', '1', 'CAREER_MOVEMENT_SUBMIT', 'career', 'Initiated transfer requisition MOV-20260929-6168 for Employee ID 13', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:44:52'),
('787', '1', 'CAREER_MOVEMENT_APPROVE', 'career', 'Approved and synchronized transfer for Employee ID 13', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:45:00'),
('788', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee messi m10 (EMP0013) with role \'Employee\' and user account \'messi.m10\'.', '14', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:52:54'),
('789', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee messi m10 (EMP0013).', '14', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:53:13'),
('790', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Messi paul (EMP0014) with role \'Employee\' and user account \'messipaul\'.', '15', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:55:01'),
('791', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Messi paul (EMP0014).', '15', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:55:29'),
('792', '1', 'CREATE_JOB', 'job_openings', 'Created job requisition JOB-2026-005 (Senior Backend Engineer)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:56:16'),
('793', '1', 'CREATE_CANDIDATE', 'candidates', 'Added candidate Rupam (CAND-001) to pipeline', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:57:19'),
('794', '1', 'UPDATE_CANDIDATE_STAGE', 'candidates', 'Moved candidate #1 (Rupam) to stage \'screening\'', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:57:38'),
('795', '1', 'UPDATE_CANDIDATE_STAGE', 'candidates', 'Moved candidate #1 (Rupam) to stage \'interview\'', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:58:09'),
('796', '1', 'UPDATE_CANDIDATE_STAGE', 'candidates', 'Moved candidate #1 (Rupam) to stage \'hired\'', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:58:22'),
('797', '1', 'HIRE_CANDIDATE_CONVERT', 'employees', 'Converted candidate #1 (Rupam) into active employee EMP0015', '16', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 11:58:34'),
('798', '1', 'PROBATION_ASSESSMENT', 'probation', 'Manager evaluated probation record #1 with recommendation: confirm', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:01:55'),
('799', '1', 'PROBATION_CONFIRM', 'probation', 'Confirmed Employee ID 16 into full-time employment', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:02:07'),
('800', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:03:54');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('801', '7', 'CLOCK_IN', 'attendance', 'Employee #7 clocked IN at 06:34:02', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:04:02'),
('802', '7', 'CLOCK_OUT', 'attendance', 'Employee #7 clocked OUT at 06:34:06 (Total 0 hrs)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:04:06'),
('803', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:04:17'),
('804', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:07:24'),
('805', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:07:42'),
('806', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0002', '12', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:21:47'),
('807', '1', 'GENERATE_DOCUMENT', 'document_templates', 'Generated TPL_OFFER_LETTER for EMP0012', '12', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:22:03'),
('808', '1', 'SUBMIT_RESIGNATION', 'resignations', 'Submitted resignation notice for EMP0012 (Ronaldo CR7)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:23:31'),
('809', '1', 'SUBMIT_RESIGNATION', 'resignations', 'Submitted resignation notice for EMP0012 (Ronaldo CR7)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:23:35'),
('810', '1', 'APPROVE_RESIGNATION', 'resignations', 'Approved resignation for case #1 with LWD 2026-09-29', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:23:52'),
('811', '1', 'CALCULATE_FNF', 'fnf_settlements', 'Computed F&F settlement for EMP0012: Net ₹56407.5', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:24:03'),
('812', '1', 'APPROVE_RESIGNATION', 'resignations', 'Approved resignation for case #2 with LWD 2026-09-02', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:24:11'),
('813', '1', 'CALCULATE_FNF', 'fnf_settlements', 'Computed F&F settlement for EMP0012: Net ₹56407.5', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:24:23'),
('814', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:27:12'),
('815', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:27:23'),
('816', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:27:52'),
('817', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:27:57'),
('818', '1', 'PROBATION_EXTEND', 'probation', 'Extended probation for Employee ID 15 by 3 months', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:35:14'),
('819', '1', 'PROBATION_CONFIRM', 'probation', 'Confirmed Employee ID 13 into full-time employment', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:35:26'),
('820', '1', 'PROBATION_ASSESSMENT', 'probation', 'Manager evaluated probation record #1 with recommendation: confirm', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:35:37'),
('821', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 2 to Employee ID 16', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:35:37'),
('822', '1', 'PROBATION_CONFIRM', 'probation', 'Confirmed Employee ID 15 into full-time employment', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:35:48'),
('823', '1', 'PROBATION_CONFIRM', 'probation', 'Confirmed Employee ID 7 into full-time employment', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:35:53'),
('824', '1', 'SHIFT_DEALLOCATE', 'shifts', 'Removed shift assignment ID 1', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:35:56'),
('825', '1', 'MANUAL_ATTENDANCE_INSERT', 'attendance', 'Manually entered attendance for Employee #4 on 2026-09-29 (Status: Present)', '2', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:39:27'),
('826', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.6', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Mobile Safari/537.36', '2026-09-29 12:39:43'),
('827', '1', 'MANUAL_ATTENDANCE_UPDATE', 'attendance', 'Updated attendance for Employee #7 on 2026-09-29 (Status: Present)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:40:03'),
('828', '1', 'WAIVER_REQUEST', 'attendance', 'Requested waiver for attendance log ID 1', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:40:23'),
('829', '1', 'WAIVER_ACTION', 'attendance', 'Marked waiver #1 as hr_approved', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:40:31'),
('830', '1', 'SHIFT_ALLOCATE', 'shifts', 'Assigned Shift ID 6 to Employee ID 13', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:42:07'),
('831', '1', 'OVERTIME_APPLY', 'overtime', 'Submitted 3 hours overtime request for 2026-09-29', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:45:09'),
('832', '1', 'OVERTIME_REJECT', 'overtime', 'Rejected overtime ID 1', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:45:30'),
('833', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:45:33'),
('834', '7', 'OVERTIME_APPLY', 'overtime', 'Submitted 3 hours overtime request for 2026-09-29', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:46:20'),
('835', '7', 'LOGOUT', 'auth', 'User demo.employee logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:46:34'),
('836', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:46:42'),
('837', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:47:05'),
('838', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Ronaldo CR7 (EMP0012). Portal password updated.', '13', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:47:33'),
('839', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:47:38'),
('840', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:47:44'),
('841', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:48:06'),
('842', NULL, 'LOGIN', 'auth', 'User ronaldo.cr714 logged in successfully.', '13', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:48:25'),
('843', '13', 'OVERTIME_APPLY', 'overtime', 'Submitted 3 hours overtime request for 2026-09-29', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:48:43'),
('844', '13', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:48:46'),
('845', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:48:51'),
('846', '2', 'OVERTIME_APPROVE', 'overtime', 'Approved overtime ID 3 with calculated payout 757.23', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:48:57'),
('847', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:49:10'),
('848', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:49:16'),
('849', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:54:31'),
('850', '7', 'REIMBURSEMENT_SUBMIT', 'reimbursements', 'Submitted claim CLM-20260929-9BD3 for ₹190', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:55:14'),
('851', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:55:20'),
('852', '1', 'REIMBURSEMENT_FINANCE_APPROVE', 'reimbursements', 'Finance approved claim ID 5 for ₹190', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:55:28'),
('853', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:55:41'),
('854', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:56:02'),
('855', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:56:05'),
('856', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 12:57:28'),
('857', '1', 'EXPORT_CSV', 'payroll_runs', 'Exported bank disbursement file for payroll run #10', '10', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 13:05:22'),
('858', '1', 'DELETE_PAYROLL_RUN', 'payroll', 'Deleted payroll cycle #10 (Payroll Run - September 2026) and associated payslips.', '10', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 13:06:39'),
('859', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for September 2026 (10 payslips, Net: ₹196597.23).', '11', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 13:06:44'),
('860', '1', 'EXPORT_CSV', 'payroll_runs', 'Exported bank disbursement file for payroll run #11', '11', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 13:07:07'),
('861', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:11:05'),
('862', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:11:14'),
('863', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee sample Employee (EMP0016) with role \'Employee\' and user account \'sample.employee\'.', '17', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:13:21'),
('864', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:13:38'),
('865', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:14:02'),
('866', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:14:07'),
('867', '2', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for sample Employee (EMP0016). Portal password updated.', '17', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:14:43'),
('868', '2', 'LOGOUT', 'auth', 'User demo.hradmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:14:47'),
('869', NULL, 'LOGIN', 'auth', 'User sample.employee logged in successfully.', '17', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:15:01'),
('870', '17', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:15:21'),
('871', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:15:54'),
('872', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:16:19'),
('873', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 5 permissions).', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:16:38'),
('874', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:16:42'),
('875', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:16:53'),
('876', '7', 'LOGOUT', 'auth', 'User demo.employee logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:17:12'),
('877', NULL, 'LOGIN', 'auth', 'User sample.employee logged in successfully.', '17', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:17:21'),
('878', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:17:34'),
('879', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 4 permissions).', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:17:54'),
('880', '17', 'LOAN_APPLY', 'loans', 'Submitted loan request LN-20260929-3F9F for ₹100000', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:17:56'),
('881', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:00'),
('882', '17', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:04'),
('883', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:17'),
('884', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:22'),
('885', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:25'),
('886', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:33'),
('887', '4', 'LOAN_APPROVE', 'loans', 'Approved loan ID 1 and generated 3 EMI schedule rows.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:41'),
('888', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:18:52'),
('889', '7', 'LOGOUT', 'auth', 'User demo.employee logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:19:00'),
('890', NULL, 'LOGIN', 'auth', 'User sample.employee logged in successfully.', '17', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:19:10'),
('891', '1', 'PROCESS_PAYROLL', 'payroll', 'Generated payroll cycle for November 2026 (11 payslips, Net: ₹184246.67).', '12', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:21:09'),
('892', '17', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:24:15'),
('893', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:25:53'),
('894', NULL, 'LOGIN', 'auth', 'User sample.employee logged in successfully.', '17', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:26:08'),
('895', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:26:19'),
('896', '17', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:26:28'),
('897', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:26:39'),
('898', '7', 'LOAN_APPLY', 'loans', 'Submitted loan request LN-20260929-238A for ₹30000', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:26:49'),
('899', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:26:57'),
('900', '2', 'BONUS_ENTRY_ADD', 'bonuses', 'Allocated ₹50000 incentive to Employee ID 17', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:27:03');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('901', '5', 'LOAN_APPROVE', 'loans', 'Approved loan ID 2 and generated 3 EMI schedule rows.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:27:04'),
('902', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:27:18'),
('903', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:28:12'),
('904', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 14:53:39'),
('905', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:55:14'),
('906', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:59:16'),
('907', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 14:59:25'),
('908', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 15:00:31'),
('909', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:08:50'),
('910', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:09:28'),
('911', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:09:32'),
('912', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:09:33'),
('913', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', '2026-09-29 15:10:28'),
('914', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:12:52'),
('915', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:13:20'),
('916', '1', 'DATABASE_BACKUP', 'system', 'Generated full database dump hrms_backup_enterprise_hrms_20260929_094458.sql (62 tables)', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:14:58'),
('917', '1', 'DATABASE_BACKUP', 'system', 'Generated full database dump hrms_backup_enterprise_hrms_20260929_094519.sql (62 tables)', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:15:19'),
('918', '1', 'DATABASE_BACKUP', 'system', 'Generated full database dump hrms_backup_enterprise_hrms_20260929_094531.sql (62 tables)', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:15:31'),
('919', '1', 'DATABASE_BACKUP', 'system', 'Generated full database dump hrms_backup_enterprise_hrms_20260929_094649.sql (62 tables)', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:16:49'),
('920', '1', 'ANNOUNCEMENT_CREATE', 'communication', 'Broadcasted announcement \'leave for today\' to 11 employees', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:21:15'),
('921', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:22:51'),
('922', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:22:56'),
('923', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:23:18'),
('924', NULL, 'LOGIN', 'auth', 'User sample.employee logged in successfully.', '17', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:23:31'),
('925', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:23:41'),
('926', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:23:48'),
('927', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:24:49'),
('928', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:24:53'),
('929', '17', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:24:54'),
('930', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:24:58'),
('931', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:25:03'),
('932', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:27:14'),
('933', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 3 permissions).', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:27:35'),
('934', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:27:38'),
('935', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Sample Demo 2 (EMP0017) with role \'Employee\' and user account \'sample.demo2\'.', '18', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:28:10'),
('936', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:28:51'),
('937', '1', 'UPDATE_EMPLOYEE', 'employee', 'Updated employee details for Sample Demo 2 (EMP0017).', '18', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:31:24'),
('938', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:31:29'),
('939', NULL, 'LOGIN', 'auth', 'User sample.demo2 logged in successfully.', '18', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:31:49'),
('940', '18', 'APPLY_LEAVE', 'leaves', 'Submitted leave request #2 (0.5 days from 2026-09-30 to 2026-09-30)', '2', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:32:32'),
('941', '18', 'APPLY_LEAVE', 'leaves', 'Submitted leave request #3 (0.5 days from 2026-09-30 to 2026-09-30)', '3', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:32:35'),
('942', '1', 'HR_APPROVE_LEAVE', 'leaves', 'HR fully approved leave request #3. Deducted 0.5 days from balance.', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:33:13'),
('943', '1', 'REJECT_LEAVE', 'leaves', 'Rejected leave request #2. Reason: you are lying', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:33:33'),
('944', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:33:41'),
('945', '18', 'CLOCK_IN', 'attendance', 'Employee #18 clocked IN at 10:03:42', '3', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:33:42'),
('946', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:33:45'),
('947', '1', 'CREATE_EMPLOYEE', 'employee', 'Onboarded employee Priyanshu Paul (EMP0018) with role \'Employee\' and user account \'priyanshu.paul\'.', '19', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:34:04'),
('948', '1', 'TEST_NOTIFICATION', 'communication', 'Triggered EMAIL dispatch for employee #19 using template leave_applied', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:34:53'),
('949', '1', 'TEST_NOTIFICATION', 'communication', 'Triggered IN_APP, EMAIL dispatch for employee #19 using template leave_applied', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:37:41'),
('950', '18', 'WAIVER_REQUEST', 'attendance', 'Requested waiver for attendance log ID 3', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:37:54'),
('951', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:38:10'),
('952', '18', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:38:22'),
('953', NULL, 'LOGIN', 'auth', 'User priyanshu.paul logged in successfully.', '19', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:38:23'),
('954', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:38:39'),
('955', '7', 'LOGOUT', 'auth', 'User demo.employee logged out.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:38:45'),
('956', NULL, 'LOGIN', 'auth', 'User sample.demo2 logged in successfully.', '18', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:39:04'),
('957', '19', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:39:35'),
('958', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:39:39'),
('959', '18', 'OVERTIME_APPLY', 'overtime', 'Submitted 3 hours overtime request for 2026-09-29', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:40:33'),
('960', '18', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:40:53'),
('961', '1', 'OVERTIME_APPROVE', 'overtime', 'Approved overtime ID 4 with calculated payout 757.23', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:41:03'),
('962', '7', 'LOGOUT', 'auth', 'User demo.employee logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:44:14'),
('963', NULL, 'LOGIN', 'auth', 'User priyanshu.paul logged in successfully.', '19', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:44:26'),
('964', '1', 'GOAL_CREATE', 'performance', 'Created goal Achivement', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:48:46'),
('965', '1', 'MANAGER_APPRAISAL_SUBMIT', 'performance', 'Completed manager appraisal for employee #19 (Band: Outstanding (Grade A))', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:51:22'),
('966', '1', 'CAREER_MOVEMENT_SUBMIT', 'career', 'Initiated promotion requisition MOV-20260929-779C for Employee ID 19', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:53:40'),
('967', '1', 'CAREER_MOVEMENT_APPROVE', 'career', 'Approved and synchronized promotion for Employee ID 19', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:55:00'),
('968', '1', 'MANAGER_APPRAISAL_SUBMIT', 'performance', 'Completed manager appraisal for employee #17 (Band: Outstanding (Grade A))', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:55:58'),
('969', '19', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:56:03'),
('970', '7', 'LOGOUT', 'auth', 'User demo.employee logged out.', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:56:41'),
('971', NULL, 'LOGIN', 'auth', 'User priyanshu.paul logged in successfully.', '19', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:56:59'),
('972', '1', 'PROBATION_CONFIRM', 'probation', 'Confirmed Employee ID 18 into full-time employment', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:57:03'),
('973', '19', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 15:57:47'),
('974', '1', 'CREATE_DESIGNATION', 'designation', 'Created designation software developer (soft)', '9', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:00:45'),
('975', '1', 'TRAVEL_APPLY', 'travel', 'Submitted travel request TRV-20260929-F762', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:00:53'),
('976', '1', 'EXPENSE_CLAIM_APPLY', 'travel', 'Submitted expense claim of ₹5000', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:01:23'),
('977', '1', 'EXPENSE_CLAIM_APPROVE', 'travel', 'Approved expense claim #1 for ₹5000', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:01:29'),
('978', '1', 'TRAVEL_APPLY', 'travel', 'Submitted travel request TRV-20260929-4911', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:01:57'),
('979', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:02:12'),
('980', '7', 'TRAVEL_APPLY', 'travel', 'Submitted travel request TRV-20260929-225B', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:02:40'),
('981', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:03:11'),
('982', '1', 'EXPENSE_CLAIM_APPLY', 'travel', 'Submitted expense claim of ₹5000', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:03:58'),
('983', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:04:07'),
('984', '1', 'TRAVEL_APPROVE', 'travel', 'Approved travel request #3 with advance 5000', '3', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:04:34'),
('985', '1', 'TRAVEL_APPROVE', 'travel', 'Approved travel request #2 with advance 5000', '2', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:04:42'),
('986', '1', 'TRAVEL_APPROVE', 'travel', 'Approved travel request #1 with advance 5000', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:04:50'),
('987', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:07:22'),
('988', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:08:01'),
('989', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Executive (demo.hrexecutive)', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:08:08'),
('990', '3', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:08:17'),
('991', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:11:21'),
('992', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:13:14'),
('993', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:13:18'),
('994', '7', 'EXPENSE_CLAIM_APPLY', 'travel', 'Submitted expense claim of ₹10000', '3', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:14:37'),
('995', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:14:46'),
('996', '7', 'EXPENSE_CLAIM_APPLY', 'travel', 'Submitted expense claim of ₹10000', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:15:17'),
('997', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:15:29'),
('998', '1', 'EXPENSE_CLAIM_APPROVE', 'travel', 'Approved expense claim #2 for ₹100000', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:16:05'),
('999', '1', 'EXPENSE_CLAIM_APPROVE', 'travel', 'Approved expense claim #4 for ₹10000', '4', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:16:11'),
('1000', '1', 'EXPENSE_CLAIM_APPROVE', 'travel', 'Approved expense claim #3 for ₹10000', '3', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:16:16');
INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `module`, `description`, `record_id`, `ip_address`, `user_agent`, `created_at`) VALUES
('1001', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:16:22'),
('1002', '7', 'TRAVEL_APPLY', 'travel', 'Submitted travel request TRV-20260929-CC52', '4', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:17:44'),
('1003', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to HR Admin (demo.hradmin)', '2', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:17:56'),
('1004', '2', 'TRAVEL_APPROVE', 'travel', 'Approved travel request #4 with advance 15000', '4', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:18:12'),
('1005', '2', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:18:16'),
('1006', '7', 'EXPENSE_CLAIM_APPLY', 'travel', 'Submitted expense claim of ₹35000', '5', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:18:56'),
('1007', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:19:03'),
('1008', '1', 'EXPENSE_CLAIM_APPROVE', 'travel', 'Approved expense claim #5 for ₹35000', '5', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:19:22'),
('1009', '7', 'GOAL_CREATE', 'performance', 'Created goal project ', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:20:01'),
('1010', '1', 'MANAGER_APPRAISAL_SUBMIT', 'performance', 'Completed manager appraisal for employee #19 (Band: Outstanding (Grade A))', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:20:20'),
('1011', '7', 'SELF_APPRAISAL_SUBMIT', 'performance', 'Submitted self-assessment (Score: 4.2) for cycle #2', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:20:29'),
('1012', '7', 'SELF_APPRAISAL_SUBMIT', 'performance', 'Submitted self-assessment (Score: 4.2) for cycle #2', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:21:28'),
('1013', '1', 'MANAGER_APPRAISAL_SUBMIT', 'performance', 'Completed manager appraisal for employee #7 (Band: Outstanding (Grade A))', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:22:41'),
('1014', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:23:43'),
('1015', '6', 'MANAGER_APPRAISAL_SUBMIT', 'performance', 'Completed manager appraisal for employee #7 (Band: Outstanding (Grade A))', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:24:22'),
('1016', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:27:18'),
('1017', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:27:38'),
('1018', '6', 'MANAGER_APPRAISAL_SUBMIT', 'performance', 'Completed manager appraisal for employee #7 (Band: Outstanding (Grade A))', NULL, '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:27:58'),
('1019', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:28:15'),
('1020', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:28:45'),
('1021', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:28:58'),
('1022', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Manager / Department Head (demo.manager)', '6', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:29:12'),
('1023', '6', 'DEMO_SWITCH', 'auth', 'Switched role context to Accountant (demo.accountant)', '5', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:29:20'),
('1024', '5', 'DEMO_SWITCH', 'auth', 'Switched role context to Payroll Manager (demo.payroll)', '4', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:29:28'),
('1025', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:29:35'),
('1026', '4', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:29:48'),
('1027', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:29:53'),
('1028', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:33:00'),
('1029', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:33:26'),
('1030', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:33:35'),
('1031', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:33:48'),
('1032', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:34:00'),
('1033', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:34:15'),
('1034', '1', 'UPDATE_RBAC', 'roles', 'Updated permissions for role Employee (assigned 4 permissions).', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:34:50'),
('1035', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:34:55'),
('1036', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:43:45'),
('1037', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:43:47'),
('1038', '1', 'CREATE_CANDIDATE', 'candidates', 'Added candidate dhurv vikram (CAND-002) to pipeline', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:45:32'),
('1039', '1', 'UPDATE_CANDIDATE_STAGE', 'candidates', 'Moved candidate #2 (dhurv vikram) to stage \'applied\'', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:45:49'),
('1040', '1', 'UPDATE_CANDIDATE_STAGE', 'candidates', 'Moved candidate #2 (dhurv vikram) to stage \'screening\'', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:46:02'),
('1041', '1', 'UPDATE_CANDIDATE_STAGE', 'candidates', 'Moved candidate #2 (dhurv vikram) to stage \'interview\'', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:46:27'),
('1042', '1', 'UPDATE_CANDIDATE_STAGE', 'candidates', 'Moved candidate #2 (dhurv vikram) to stage \'offered\'', '2', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:46:38'),
('1043', '1', 'HIRE_CANDIDATE_CONVERT', 'employees', 'Converted candidate #2 (dhurv vikram) into active employee EMP0019', '20', '192.168.1.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:46:54'),
('1044', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:49:34'),
('1045', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:55:04'),
('1046', '1', 'TRAINING_CREATE', 'training', 'Scheduled training program TRN-2026-B0B5', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:55:49'),
('1047', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:55:54'),
('1048', '7', 'TRAINING_NOMINATE', 'training', 'Nominated employee #2 for training #1', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:58:50'),
('1049', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 16:59:33'),
('1050', '1', 'DEMO_SWITCH', 'auth', 'Switched role context to Employee (demo.employee)', '7', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:00:40'),
('1051', '7', 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:00:43'),
('1052', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Priyanshu Paul (EMP0018).', '19', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:00:55'),
('1053', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Sample Demo 2 (EMP0017).', '18', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:01:08'),
('1054', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Rupam Staff (EMP0015).', '16', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:01:19'),
('1055', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Ronaldo CR7 (EMP0012).', '13', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:01:31'),
('1056', '1', 'DELETE_EMPLOYEE', 'employees', 'Archived and removed employee Messi paul (EMP0014).', '15', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:01:38'),
('1057', '1', 'LOGOUT', 'auth', 'User demo.superadmin logged out.', NULL, '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:14:31'),
('1058', NULL, 'DEMO_SWITCH', 'auth', 'Switched role context to Super Admin (demo.superadmin)', '1', '192.168.1.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '2026-09-29 17:14:37');

-- -----------------------------------------------------
-- Table structure for `asset_allocations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `asset_allocations`;
CREATE TABLE `asset_allocations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `allocated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `returned_at` datetime DEFAULT NULL,
  `condition_on_allocation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Good working condition',
  `condition_on_return` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allocated_by` int unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_alloc_asset` (`asset_id`),
  KEY `fk_alloc_emp` (`employee_id`),
  CONSTRAINT `fk_alloc_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_alloc_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table structure for `assets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `assets`;
CREATE TABLE `assets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('laptop','desktop','monitor','mobile','access_card','peripherals','furniture') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'laptop',
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `purchase_cost` decimal(12,2) DEFAULT '0.00',
  `warranty_expiry` date DEFAULT NULL,
  `current_employee_id` int unsigned DEFAULT NULL,
  `status` enum('available','allocated','maintenance','retired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `condition_status` enum('brand_new','good','fair','damaged') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'good',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asset_code` (`asset_code`),
  UNIQUE KEY `serial_number` (`serial_number`),
  KEY `fk_asset_emp` (`current_employee_id`),
  CONSTRAINT `fk_asset_emp` FOREIGN KEY (`current_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `assets` (6 rows)
INSERT INTO `assets` (`id`, `asset_code`, `name`, `category`, `brand`, `model`, `serial_number`, `purchase_date`, `purchase_cost`, `warranty_expiry`, `current_employee_id`, `status`, `condition_status`, `notes`, `created_at`, `updated_at`) VALUES
('1', 'AST-LAP-001', 'MacBook Pro 16\" M3 Max', 'laptop', 'Apple', 'MacBook Pro 16', 'SN-APL-998811', '2025-01-15', '3200.00', '2028-01-15', NULL, 'allocated', 'brand_new', NULL, '2026-09-25 13:02:59', '2026-09-28 16:42:05'),
('2', 'AST-LAP-002', 'ThinkPad X1 Carbon Gen 11', 'laptop', 'Lenovo', 'X1 Carbon', 'SN-LNV-445522', '2025-03-10', '2100.00', '2028-03-10', NULL, 'allocated', 'good', NULL, '2026-09-25 13:02:59', '2026-09-28 16:42:05'),
('3', 'AST-LAP-003', 'Dell XPS 15 9530', 'laptop', 'Dell', 'XPS 15', 'SN-DEL-773311', '2025-04-20', '2400.00', '2028-04-20', NULL, 'allocated', 'good', NULL, '2026-09-25 13:02:59', '2026-09-28 16:42:05'),
('4', 'AST-MON-001', 'Dell UltraSharp 27\" 4K', 'monitor', 'Dell', 'U2723QE', 'SN-DEL-MN0099', '2025-02-01', '650.00', '2028-02-01', NULL, 'allocated', 'good', NULL, '2026-09-25 13:02:59', '2026-09-28 16:42:05'),
('5', 'AST-LAP-004', 'MacBook Air 15\" M2', 'laptop', 'Apple', 'MacBook Air 15', 'SN-APL-882200', '2025-05-12', '1499.00', '2027-05-12', NULL, 'available', 'good', NULL, '2026-09-25 13:02:59', '2026-09-25 14:17:52'),
('6', 'AST-SEC-001', 'YubiKey 5C NFC Security Key', 'access_card', 'Yubico', '5C NFC', 'SN-YUB-001122', '2025-01-10', '55.00', '2030-01-10', NULL, 'allocated', 'good', NULL, '2026-09-25 13:02:59', '2026-09-28 16:42:05');

-- -----------------------------------------------------
-- Table structure for `attendance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `attendance`;
CREATE TABLE `attendance` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `date` date NOT NULL,
  `shift_id` int unsigned DEFAULT NULL,
  `clock_in` datetime DEFAULT NULL,
  `clock_out` datetime DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT '0.00',
  `late_minutes` int DEFAULT '0',
  `late_waived` tinyint(1) NOT NULL DEFAULT '0',
  `early_leaving_minutes` int DEFAULT '0',
  `early_exit_waived` tinyint(1) NOT NULL DEFAULT '0',
  `waived_by` int unsigned DEFAULT NULL,
  `waived_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waived_at` datetime DEFAULT NULL,
  `overtime_minutes` int DEFAULT '0',
  `status` enum('Present','Absent','Late','Half-Day','On Leave','Holiday','Week Off') COLLATE utf8mb4_unicode_ci DEFAULT 'Present',
  `clock_in_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clock_out_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` enum('web','biometric','manual_adjustment') COLLATE utf8mb4_unicode_ci DEFAULT 'web',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_emp_date` (`employee_id`,`date`),
  KEY `fk_att_shift` (`shift_id`),
  CONSTRAINT `fk_att_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_att_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `attendance` (3 rows)
INSERT INTO `attendance` (`id`, `employee_id`, `date`, `shift_id`, `clock_in`, `clock_out`, `total_hours`, `late_minutes`, `late_waived`, `early_leaving_minutes`, `early_exit_waived`, `waived_by`, `waived_reason`, `waived_at`, `overtime_minutes`, `status`, `clock_in_ip`, `clock_out_ip`, `source`, `notes`, `created_at`, `updated_at`) VALUES
('1', '7', '2026-09-29', '1', '2026-09-29 09:00:00', '2026-09-29 18:00:00', '9.00', '10', '1', '0', '0', '1', 'Approved by supervisor', '2026-09-29 07:10:31', '0', 'Present', '192.168.1.13', '192.168.1.13', 'manual_adjustment', 'Manual entry by HR', '2026-09-29 06:34:02', '2026-09-29 07:10:31'),
('2', '4', '2026-09-29', '1', '2026-09-29 09:00:00', '2026-09-29 18:00:00', '9.00', '0', '0', '0', '0', NULL, NULL, NULL, '0', 'Present', NULL, NULL, 'manual_adjustment', 'Manual entry by HR', '2026-09-29 07:09:27', '2026-09-29 07:09:27'),
('3', '18', '2026-09-29', '1', '2026-09-29 10:03:42', NULL, '0.00', '64', '0', '0', '0', NULL, NULL, NULL, '0', 'Late', '192.168.1.11', NULL, 'web', NULL, '2026-09-29 10:03:42', '2026-09-29 10:03:42');

-- -----------------------------------------------------
-- Table structure for `attendance_corrections`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `attendance_corrections`;
CREATE TABLE `attendance_corrections` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `attendance_id` int unsigned DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `requested_clock_in` datetime NOT NULL,
  `requested_clock_out` datetime NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `manager_id` int unsigned DEFAULT NULL,
  `manager_action_at` datetime DEFAULT NULL,
  `manager_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_attcorr_emp` (`employee_id`,`attendance_date`),
  KEY `fk_attcorr_att` (`attendance_id`),
  KEY `fk_attcorr_mgr` (`manager_id`),
  CONSTRAINT `fk_attcorr_att` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_attcorr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attcorr_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table structure for `attendance_time_waivers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `attendance_time_waivers`;
CREATE TABLE `attendance_time_waivers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `attendance_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `waiver_type` enum('late_arrival','early_departure','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'late_arrival',
  `waiver_date` date NOT NULL,
  `minutes_recorded` int NOT NULL DEFAULT '0',
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','manager_approved','hr_approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `manager_id` int unsigned DEFAULT NULL,
  `manager_action_at` datetime DEFAULT NULL,
  `manager_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_id` int unsigned DEFAULT NULL,
  `hr_action_at` datetime DEFAULT NULL,
  `hr_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_atw_att` (`attendance_id`),
  KEY `fk_atw_emp` (`employee_id`),
  KEY `fk_atw_mgr` (`manager_id`),
  KEY `fk_atw_hr` (`hr_id`),
  CONSTRAINT `fk_atw_att` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_atw_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_atw_hr` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_atw_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `attendance_time_waivers` (2 rows)
INSERT INTO `attendance_time_waivers` (`id`, `attendance_id`, `employee_id`, `waiver_type`, `waiver_date`, `minutes_recorded`, `reason`, `status`, `manager_id`, `manager_action_at`, `manager_remarks`, `hr_id`, `hr_action_at`, `hr_remarks`, `created_at`, `updated_at`) VALUES
('1', '1', '7', 'late_arrival', '2026-09-29', '10', 'OK', 'hr_approved', '1', '2026-09-29 07:10:31', 'Approved by supervisor', '1', '2026-09-29 07:10:31', 'Approved by supervisor', '2026-09-29 07:10:23', '2026-09-29 07:10:31'),
('2', '3', '18', 'late_arrival', '2026-09-29', '64', 'hh', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 10:07:54', '2026-09-29 10:07:54');

-- -----------------------------------------------------
-- Table structure for `bonus_schemes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bonus_schemes`;
CREATE TABLE `bonus_schemes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheme_code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheme_type` enum('annual_bonus','performance_incentive','sales_commission','festival_bonus','spot_award','retention_bonus') COLLATE utf8mb4_unicode_ci NOT NULL,
  `calculation_type` enum('fixed_amount','percentage_of_basic','percentage_of_gross') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed_amount',
  `default_value` decimal(12,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scheme_code` (`scheme_code`),
  KEY `fk_bs_company` (`company_id`),
  CONSTRAINT `fk_bs_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `bonus_schemes` (4 rows)
INSERT INTO `bonus_schemes` (`id`, `company_id`, `title`, `scheme_code`, `scheme_type`, `calculation_type`, `default_value`, `description`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', 'Annual Performance Incentive', 'SCH-PERF-ANN', 'performance_incentive', 'percentage_of_basic', '15.00', 'Annual performance bonus based on appraisal score rating', 'active', '2026-09-26 12:18:59', '2026-09-26 15:13:53'),
('2', '1', 'Quarterly Sales Revenue Commission', 'SCH-SLS-COMM', 'sales_commission', 'fixed_amount', '1200.00', 'Direct incentive on exceeding quarterly team sales pipeline quota', 'active', '2026-09-26 12:18:59', '2026-09-26 15:13:53'),
('3', '1', 'CEO Spot Excellence Award', 'SCH-SPOT-AWD', 'spot_award', 'fixed_amount', '500.00', 'Discretionary executive peer recognition for exceptional project impact', 'active', '2026-09-26 12:18:59', '2026-09-26 15:13:53'),
('4', '1', 'Festive Holiday Bonus', 'SCH-FEST-2026', 'festival_bonus', 'percentage_of_basic', '10.00', 'Year-end company-wide holiday celebration disbursement', 'active', '2026-09-26 12:18:59', '2026-09-26 15:13:53');

-- -----------------------------------------------------
-- Table structure for `branches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'United States',
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_head_office` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `branch_code` (`branch_code`),
  KEY `fk_branch_company` (`company_id`),
  CONSTRAINT `fk_branch_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `branches` (3 rows)
INSERT INTO `branches` (`id`, `company_id`, `name`, `branch_code`, `email`, `phone`, `address`, `city`, `state`, `country`, `postal_code`, `is_head_office`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', 'Kolkata Headquarters', 'BR-KOL-01', 'kolkata@infosof.com', '+91 33 2357 5001', 'Plot Y-12, Sector V, Salt Lake Electronics Complex', 'Kolkata', 'West Bengal', 'India', '700091', '1', 'active', '2026-09-25 12:26:51', '2026-09-26 12:53:13'),
('2', '1', 'Noida Tech Hub', 'BR-NOI-02', 'noida@infosof.com', '+91 120 456 0199', 'Sector 62, Electronic City', 'Noida', 'Uttar Pradesh', 'India', '201301', '0', 'active', '2026-09-25 12:26:51', '2026-09-26 12:53:13'),
('3', '1', 'Bangalore Office', 'BR-BLR-03', 'bangalore@infosof.com', '+91 80 6789 0912', 'Electronic City Phase 1, Hosur Road', 'Bangalore', 'Karnataka', 'India', '560100', '0', 'active', '2026-09-25 12:26:51', '2026-09-26 12:53:13');

-- -----------------------------------------------------
-- Table structure for `candidates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `candidates`;
CREATE TABLE `candidates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `job_opening_id` int unsigned NOT NULL,
  `candidate_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience_years` decimal(4,1) DEFAULT '0.0',
  `current_company` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_ctc` decimal(12,2) DEFAULT '0.00',
  `expected_ctc` decimal(12,2) DEFAULT '0.00',
  `notice_period_days` int DEFAULT '30',
  `resume_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stage` enum('applied','screening','interview','offered','hired','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'applied',
  `scorecard_rating` int DEFAULT '0',
  `interviewer_feedback` text COLLATE utf8mb4_unicode_ci,
  `hired_as_employee_id` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `candidate_code` (`candidate_code`),
  KEY `fk_cand_job` (`job_opening_id`),
  KEY `fk_cand_emp` (`hired_as_employee_id`),
  CONSTRAINT `fk_cand_emp` FOREIGN KEY (`hired_as_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_cand_job` FOREIGN KEY (`job_opening_id`) REFERENCES `job_openings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `candidates` (2 rows)
INSERT INTO `candidates` (`id`, `job_opening_id`, `candidate_code`, `full_name`, `email`, `phone`, `experience_years`, `current_company`, `current_ctc`, `expected_ctc`, `notice_period_days`, `resume_path`, `stage`, `scorecard_rating`, `interviewer_feedback`, `hired_as_employee_id`, `created_at`, `updated_at`) VALUES
('1', '5', 'CAND-001', 'Rupam', 'rupam2003@gmail.com', '+919510011944', '1.0', '', '0.00', '0.00', '30', NULL, 'hired', '4', '', '16', '2026-09-29 11:57:19', '2026-09-29 11:58:34'),
('2', '5', 'CAND-002', 'dhurv vikram', 'vikram@gmail.com', '7412589635', '2.5', '', '74000.00', '80000.00', '30', NULL, 'hired', '3', '', '20', '2026-09-29 16:45:32', '2026-09-29 16:46:54');

-- -----------------------------------------------------
-- Table structure for `companies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'USD',
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'America/New_York',
  `fiscal_year_start_month` tinyint DEFAULT '1',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `companies` (1 rows)
INSERT INTO `companies` (`id`, `name`, `code`, `tax_id`, `email`, `phone`, `website`, `currency`, `timezone`, `fiscal_year_start_month`, `logo`, `address`, `status`, `created_at`, `updated_at`) VALUES
('1', 'Infosof Technologies', 'INFOSOF-CORP', 'US-EIN-94827104', 'contact@infosof.com', '+1 (415) 890-5000', 'https://infosof.com', 'INR', 'Asia/Kolkata', '1', 'assets/images/infosof-logo.png', 'Plot Y-12, Sector V, Salt Lake Electronics Complex, Kolkata, West Bengal 700091', 'active', '2026-09-25 12:26:51', '2026-09-26 12:53:13');

-- -----------------------------------------------------
-- Table structure for `company_policies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `company_policies`;
CREATE TABLE `company_policies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `policy_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('code_of_conduct','leave_attendance','it_security','compensation','health_safety','anti_harassment','general') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1.0',
  `effective_date` date NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  `requires_acknowledgement` tinyint(1) NOT NULL DEFAULT '1',
  `department_restriction_id` int unsigned DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policy_code` (`policy_code`),
  KEY `fk_pol_company` (`company_id`),
  KEY `fk_pol_dept` (`department_restriction_id`),
  CONSTRAINT `fk_pol_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pol_dept` FOREIGN KEY (`department_restriction_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `company_policies` (2 rows)
INSERT INTO `company_policies` (`id`, `company_id`, `policy_code`, `title`, `category`, `version`, `effective_date`, `file_path`, `summary`, `content`, `requires_acknowledgement`, `department_restriction_id`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
('1', '1', 'POL-HR-001', 'Enterprise Code of Business Conduct & Ethics', 'code_of_conduct', '2.0', '2026-01-01', NULL, 'Governs professional standards, anti-bribery, conflict of interest, and workplace integrity.', '<h3>1. Objective</h3><p>Infosof Technologies is committed to conducting business with highest standards of ethics, integrity, and regulatory compliance. Every employee is expected to act truthfully and respect organizational property, colleagues, and customer confidentiality.</p><h3>2. Scope & Applicability</h3><p>Applies to all full-time, part-time, and contractual staff globally.</p><h3>3. Confidentiality</h3><p>Proprietary enterprise data, trade secrets, and client repositories must never be disclosed to third parties without prior written executive authorization.</p>', '1', NULL, 'published', '2026-09-26 12:18:59', '2026-09-26 12:18:59', '2026-09-26 15:13:53'),
('2', '1', 'POL-HR-002', 'Hybrid Workplace & Attendance Guidelines', 'leave_attendance', '1.5', '2026-01-01', NULL, 'Outlines core working hours (9 AM - 6 PM), biometric clock-in grace periods, and web clock-in policies.', '<h3>1. Standard Hours</h3><p>Standard working hours are 8 operational hours per day excluding lunch break. A 15-minute grace period applies to morning clock-ins.</p><h3>2. Overtime Policy</h3><p>Overtime must be pre-approved by the reporting manager prior to execution.</p>', '1', NULL, 'published', '2026-09-26 12:18:59', '2026-09-26 12:18:59', '2026-09-26 15:13:53');

-- -----------------------------------------------------
-- Table structure for `departments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `branch_id` int unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_employee_id` int unsigned DEFAULT NULL,
  `parent_id` int unsigned DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_dept_company` (`company_id`),
  KEY `fk_dept_branch` (`branch_id`),
  KEY `fk_dept_parent` (`parent_id`),
  KEY `fk_dept_head` (`head_employee_id`),
  CONSTRAINT `fk_dept_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_dept_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_dept_head` FOREIGN KEY (`head_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_dept_parent` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `departments` (9 rows)
INSERT INTO `departments` (`id`, `company_id`, `branch_id`, `name`, `code`, `head_employee_id`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', '1', 'Executive Leadership', 'DEP-EXEC', '1', NULL, 'active', '2026-09-25 12:26:51', '2026-09-28 17:06:10'),
('2', '1', '1', 'Human Resources', 'DEP-HR', '2', NULL, 'active', '2026-09-25 12:26:51', '2026-09-28 17:06:10'),
('3', '1', '1', 'Engineering & Technology', 'DEP-ENG', '6', NULL, 'active', '2026-09-25 12:26:51', '2026-09-28 17:06:10'),
('4', '1', '1', 'Finance & Accounting', 'DEP-FIN', '4', NULL, 'active', '2026-09-25 12:26:51', '2026-09-28 17:06:10'),
('5', '1', '2', 'Sales & Marketing', 'DEP-SLS', NULL, NULL, 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('6', '1', '1', 'Operations & Facilities', 'DEP-OPS', NULL, NULL, 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('9', '1', '2', 'Quality Assurance', 'QA', NULL, NULL, 'active', '2026-09-28 09:43:31', '2026-09-28 09:43:31'),
('11', '1', '3', 'Information Technology', 'DEP-IT', '6', NULL, 'active', '2026-09-28 11:51:34', '2026-09-28 11:51:34'),
('12', '1', '3', 'Data Analyst', 'DEP-DAT', NULL, NULL, 'active', '2026-09-28 12:21:16', '2026-09-28 12:40:50');

-- -----------------------------------------------------
-- Table structure for `designations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `designations`;
CREATE TABLE `designations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `department_id` int unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_band_id` int unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_desig_company` (`company_id`),
  KEY `fk_desig_dept` (`department_id`),
  KEY `fk_desig_grade` (`grade_band_id`),
  CONSTRAINT `fk_desig_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_desig_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_desig_grade` FOREIGN KEY (`grade_band_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `designations` (9 rows)
INSERT INTO `designations` (`id`, `company_id`, `department_id`, `name`, `code`, `grade_band_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', '1', 'Chief Executive Officer', 'DES-CEO', '1', 'Chief Executive Officer of the enterprise', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('2', '1', '2', 'Director of Human Resources', 'DES-HRDIR', '2', 'Oversees all global human resources policies and personnel', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('3', '1', '2', 'HR Operations Specialist', 'DES-HROPS', '4', 'Coordinates daily onboarding and employee records', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('4', '1', '3', 'Engineering Director', 'DES-ENGDIR', '2', 'Leads software engineering and cloud infrastructure teams', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('5', '1', '3', 'Lead Full Stack Architect', 'DES-ARCH', '3', 'Designs enterprise software architectures and frameworks', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('6', '1', '4', 'Payroll & Compliance Controller', 'DES-PAYCTRL', '2', 'Oversees monthly payroll runs and statutory audits', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('7', '1', '4', 'Senior Financial Accountant', 'DES-ACCT', '3', 'Handles financial ledgers and disbursement balance reconciliations', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('8', '1', '12', 'Analysis', 'DES-ANALYSIS', NULL, 'Analysis data', 'active', '2026-09-29 05:59:31', '2026-09-29 05:59:31'),
('9', '1', '3', 'software developer', 'SOFT', NULL, NULL, 'active', '2026-09-29 10:30:45', '2026-09-29 10:30:45');

-- -----------------------------------------------------
-- Table structure for `disciplinary_actions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `disciplinary_actions`;
CREATE TABLE `disciplinary_actions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `case_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `incident_date` date NOT NULL,
  `action_type` enum('verbal_warning','written_warning','final_warning','pip','suspension','demotion','termination') COLLATE utf8mb4_unicode_ci NOT NULL,
  `severity_level` enum('minor','moderate','severe','critical') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'minor',
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_taken` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pip_start_date` date DEFAULT NULL,
  `pip_end_date` date DEFAULT NULL,
  `suspension_days` int unsigned DEFAULT NULL,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','issued','acknowledged','appealed','closed','revoked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'issued',
  `employee_explanation` text COLLATE utf8mb4_unicode_ci,
  `employee_acknowledged_at` datetime DEFAULT NULL,
  `appeal_notes` text COLLATE utf8mb4_unicode_ci,
  `closure_notes` text COLLATE utf8mb4_unicode_ci,
  `closed_at` datetime DEFAULT NULL,
  `is_confidential` tinyint(1) NOT NULL DEFAULT '1',
  `issued_by` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `case_number` (`case_number`),
  KEY `fk_da_emp` (`employee_id`),
  KEY `fk_da_usr` (`issued_by`),
  CONSTRAINT `fk_da_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_da_usr` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table structure for `document_templates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `document_templates`;
CREATE TABLE `document_templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `template_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('offer_letter','appointment_letter','experience_certificate','relieving_letter','increment_letter') COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `available_tokens` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '{{EMPLOYEE_NAME}}, {{EMPLOYEE_CODE}}, {{DESIGNATION}}, {{DEPARTMENT}}, {{JOIN_DATE}}, {{GROSS_SALARY}}, {{COMPANY_NAME}}, {{TODAY_DATE}}',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_code` (`template_code`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `document_templates` (3 rows)
INSERT INTO `document_templates` (`id`, `template_code`, `name`, `category`, `subject`, `body_content`, `available_tokens`, `is_active`, `created_at`, `updated_at`) VALUES
('12', 'TPL_OFFER_LETTER', 'Offer Letter', 'offer_letter', 'Offer of Employment at Infosof Technologies - {{EMPLOYEE_NAME}}', '<div style=\"font-family: inherit; line-height: 1.8; color: #1e293b;\">
    <div style=\"text-align: right; margin-bottom: 20px;\">
        <p style=\"margin: 0; font-size: 13px; color: #64748b;\">Date: <strong style=\"color: #0f172a;\">{{TODAY_DATE}}</strong></p>
    </div>

    <p style=\"margin: 0 0 16px 0;\">To,<br>
    <strong style=\"color: #0f172a; font-size: 15px;\">{{EMPLOYEE_NAME}}</strong><br>
    Candidate ID / Ref: <code style=\"background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 13px;\">{{EMPLOYEE_CODE}}</code></p>

    <p style=\"margin: 0 0 16px 0;\"><strong>Dear {{EMPLOYEE_NAME}},</strong></p>

    <p style=\"margin: 0 0 16px 0;\">On behalf of <strong>Infosof Technologies</strong>, we are thrilled to extend an official offer of employment for the position of <strong>{{DESIGNATION}}</strong> within our <strong>{{DEPARTMENT}}</strong> department.</p>

    <p style=\"margin: 0 0 16px 0;\">We were deeply impressed by your skills, qualifications, and past achievements, and we firmly believe that your expertise will be a tremendous asset to our growing team and technological innovations.</p>

    <div style=\"background: #f8fafc; border-left: 4px solid #2563eb; padding: 16px 20px; border-radius: 4px; margin: 24px 0;\">
        <h4 style=\"margin: 0 0 12px 0; color: #1e3a8a; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;\">Summary of Employment Terms:</h4>
        <table style=\"width: 100%; border-collapse: collapse; font-size: 13px;\">
            <tr>
                <td style=\"padding: 6px 0; color: #64748b; width: 200px;\">Position / Designation:</td>
                <td style=\"padding: 6px 0; font-weight: 700; color: #0f172a;\">{{DESIGNATION}}</td>
            </tr>
            <tr>
                <td style=\"padding: 6px 0; color: #64748b;\">Department:</td>
                <td style=\"padding: 6px 0; font-weight: 700; color: #0f172a;\">{{DEPARTMENT}}</td>
            </tr>
            <tr>
                <td style=\"padding: 6px 0; color: #64748b;\">Date of Joining:</td>
                <td style=\"padding: 6px 0; font-weight: 700; color: #0f172a;\">{{JOIN_DATE}}</td>
            </tr>
            <tr>
                <td style=\"padding: 6px 0; color: #64748b;\">Annual Compensation (CTC):</td>
                <td style=\"padding: 6px 0; font-weight: 700; color: #16a34a; font-size: 14px;\">{{GROSS_SALARY}}</td>
            </tr>
            <tr>
                <td style=\"padding: 6px 0; color: #64748b;\">Work Location:</td>
                <td style=\"padding: 6px 0; font-weight: 600; color: #0f172a;\">Infosof Technologies, Salt Lake Sector V, Kolkata</td>
            </tr>
        </table>
    </div>

    <h4 style=\"color: #0f172a; margin: 20px 0 8px 0; font-size: 14px;\">Key Terms & Conditions:</h4>
    <ul style=\"margin: 0 0 20px 20px; padding: 0; color: #334155; font-size: 13.5px; line-height: 1.7;\">
        <li><strong>Probation Period:</strong> You will be on probation for a period of six (6) months from your date of joining, after which your performance will be evaluated for formal confirmation.</li>
        <li><strong>Confidentiality & Intellectual Property:</strong> You will be required to execute our Non-Disclosure and Proprietary Rights Agreement upon reporting. All proprietary codes, software architectures, designs, and innovations developed during your tenure remain the exclusive property of Infosof Technologies.</li>
        <li><strong>Statutory Compliance:</strong> Compensation is subject to mandatory tax deductions (TDS), Provident Fund (EPF), and professional tax deductions in compliance with prevailing statutory regulations.</li>
    </ul>

    <p style=\"margin: 0 0 16px 0;\">Please indicate your acceptance of this offer by signing and returning a duplicate copy of this letter within five (5) business days.</p>

    <p style=\"margin: 0 0 24px 0;\">We welcome you warmly to the <strong>Infosof Technologies</strong> family and look forward to a rewarding and mutually prosperous professional journey together.</p>

    <div style=\"display: flex; justify-content: space-between; align-items: flex-end; margin-top: 36px; padding-top: 16px;\">
        <div>
            <p style=\"margin: 0 0 4px 0; font-weight: 700; color: #0f172a;\">Sincerely,</p>
            <p style=\"margin: 0; color: #475569; font-size: 13px;\">
                <strong>Talent Acquisition & People Operations</strong><br>
                Infosof Technologies
            </p>
        </div>
        <div style=\"text-align: right;\">
            <p style=\"margin: 0 0 4px 0; font-weight: 700; color: #0f172a;\">Accepted & Confirmed:</p>
            <p style=\"margin: 0; color: #64748b; font-size: 13px;\">Signature: __________________________</p>
            <p style=\"margin: 4px 0 0 0; color: #64748b; font-size: 12px;\">Candidate Name: {{EMPLOYEE_NAME}}</p>
        </div>
    </div>
</div>', '{{EMPLOYEE_NAME}}, {{EMPLOYEE_CODE}}, {{DESIGNATION}}, {{DEPARTMENT}}, {{JOIN_DATE}}, {{GROSS_SALARY}}, {{COMPANY_NAME}}, {{TODAY_DATE}}', '1', '2026-09-28 14:03:04', '2026-09-28 14:03:04'),
('13', 'TPL_EXPERIENCE_LETTER', 'Experience Letter', 'experience_certificate', 'Experience Letter & Certificate of Service - {{EMPLOYEE_NAME}}', '<div style=\"font-family: inherit; line-height: 1.8; color: #1e293b;\">
    <div style=\"text-align: center; margin-bottom: 28px;\">
        <h3 style=\"margin: 0 0 4px 0; color: #0f172a; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; font-weight: 800;\">TO WHOMSOEVER IT MAY CONCERN</h3>
        <div style=\"width: 80px; height: 3px; background: #2563eb; margin: 0 auto 16px auto; border-radius: 2px;\"></div>
        <p style=\"margin: 0; font-size: 13px; color: #64748b;\">Ref No: <strong>INF/EXP/{{EMPLOYEE_CODE}}/2026</strong> &nbsp;|&nbsp; Date: <strong>{{TODAY_DATE}}</strong></p>
    </div>

    <p style=\"margin: 0 0 16px 0; font-size: 14px;\">This is to certify that <strong>{{EMPLOYEE_NAME}}</strong> (Employee Code: <strong>{{EMPLOYEE_CODE}}</strong>) was employed with <strong>Infosof Technologies</strong> from <strong>{{JOIN_DATE}}</strong> to <strong>{{TODAY_DATE}}</strong>.</p>

    <p style=\"margin: 0 0 16px 0; font-size: 14px;\">During the period of tenure with us, {{EMPLOYEE_NAME}} served as <strong>{{DESIGNATION}}</strong> in the <strong>{{DEPARTMENT}}</strong> department.</p>

    <div style=\"background: #f8fafc; border-left: 4px solid #059669; padding: 16px 20px; border-radius: 4px; margin: 24px 0;\">
        <h4 style=\"margin: 0 0 10px 0; color: #065f46; font-size: 13.5px; text-transform: uppercase;\">Professional Record & Conduct:</h4>
        <p style=\"margin: 0; color: #334155; font-size: 13.5px;\">During their service, we found them to be exceptionally dedicated, diligent, proactive, and possessing exemplary technical skills. Their professional ethics, peer collaboration, and commitment to excellence were commendable throughout their association with Infosof Technologies.</p>
    </div>

    <p style=\"margin: 0 0 16px 0; font-size: 14px;\">All official assets, project responsibilities, and access tokens have been properly transitioned, and there are no financial, contractual, or intellectual property dues pending against them as of their formal relieving date.</p>

    <p style=\"margin: 0 0 28px 0; font-size: 14px;\">We thank <strong>{{EMPLOYEE_NAME}}</strong> for their valuable service and contributions to Infosof Technologies, and we sincerely wish them the very best in all their future personal and professional endeavors.</p>

    <div style=\"margin-top: 48px; display: flex; justify-content: space-between; align-items: flex-end;\">
        <div>
            <div style=\"width: 140px; border-bottom: 1.5px solid #0f172a; margin-bottom: 8px;\"></div>
            <p style=\"margin: 0; font-size: 14px; font-weight: 700; color: #0f172a;\">Authorized HR Signatory</p>
            <p style=\"margin: 2px 0 0 0; font-size: 13px; color: #475569;\">Directorate of People & Culture</p>
            <p style=\"margin: 2px 0 0 0; font-size: 13px; font-weight: 600; color: #2563eb;\">Infosof Technologies</p>
        </div>
        <div style=\"text-align: right; color: #64748b; font-size: 12px;\">
            <p style=\"margin: 0;\">Infosof Technologies Global Operations</p>
            <p style=\"margin: 2px 0 0 0;\">HR Verification Desk: hr@infosof.com</p>
        </div>
    </div>
</div>', '{{EMPLOYEE_NAME}}, {{EMPLOYEE_CODE}}, {{DESIGNATION}}, {{DEPARTMENT}}, {{JOIN_DATE}}, {{TODAY_DATE}}, {{COMPANY_NAME}}', '1', '2026-09-28 14:03:04', '2026-09-28 14:03:04'),
('14', 'TPL_INCREMENT_LETTER', 'Increment Letter', 'increment_letter', 'Annual Compensation Increment & Appraisal - {{EMPLOYEE_NAME}}', '<div style=\"font-family: inherit; line-height: 1.8; color: #1e293b;\">
    <div style=\"text-align: right; margin-bottom: 20px;\">
        <p style=\"margin: 0; font-size: 13px; color: #64748b;\">Date: <strong style=\"color: #0f172a;\">{{TODAY_DATE}}</strong></p>
        <p style=\"margin: 2px 0 0 0; font-size: 12px; color: #94a3b8;\">Ref: INF/INC/{{EMPLOYEE_CODE}}/2026</p>
    </div>

    <p style=\"margin: 0 0 16px 0;\">To,<br>
    <strong style=\"color: #0f172a; font-size: 15px;\">{{EMPLOYEE_NAME}}</strong><br>
    Employee Code: <code style=\"background: #f1f5f9; padding: 2px 6px; border-radius: 4px; font-size: 13px;\">{{EMPLOYEE_CODE}}</code><br>
    Designation: <strong>{{DESIGNATION}}</strong> | Department: <strong>{{DEPARTMENT}}</strong></p>

    <p style=\"margin: 0 0 16px 0;\"><strong>Dear {{EMPLOYEE_NAME}},</strong></p>

    <p style=\"margin: 0 0 16px 0;\">Following the recent annual performance review and appraisal cycle, we are delighted to inform you that the Management of <strong>Infosof Technologies</strong> has approved a revision in your compensation package in recognition of your steadfast performance, dedication, and contributions to the company.</p>

    <div style=\"background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 4px solid #16a34a; padding: 18px 24px; border-radius: 6px; margin: 24px 0;\">
        <h4 style=\"margin: 0 0 12px 0; color: #166534; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;\">Revised Compensation Structure:</h4>
        <table style=\"width: 100%; border-collapse: collapse; font-size: 13.5px;\">
            <tr>
                <td style=\"padding: 6px 0; color: #166534; width: 220px;\">Current Designation:</td>
                <td style=\"padding: 6px 0; font-weight: 700; color: #0f172a;\">{{DESIGNATION}}</td>
            </tr>
            <tr>
                <td style=\"padding: 6px 0; color: #166534;\">Department:</td>
                <td style=\"padding: 6px 0; font-weight: 700; color: #0f172a;\">{{DEPARTMENT}}</td>
            </tr>
            <tr>
                <td style=\"padding: 6px 0; color: #166534;\">Effective Date of Increment:</td>
                <td style=\"padding: 6px 0; font-weight: 700; color: #0f172a;\">{{TODAY_DATE}}</td>
            </tr>
            <tr>
                <td style=\"padding: 6px 0; color: #166534;\">Revised Annual Gross CTC:</td>
                <td style=\"padding: 6px 0; font-weight: 800; color: #15803d; font-size: 15px;\">{{GROSS_SALARY}}</td>
            </tr>
        </table>
    </div>

    <p style=\"margin: 0 0 16px 0;\">Your detailed monthly salary breakdown reflecting the revised basic salary, allowances, and statutory benefits will be updated in your self-service portal under your payroll profile.</p>

    <p style=\"margin: 0 0 16px 0;\">All other terms, covenants, and conditions of your original employment contract with <strong>Infosof Technologies</strong> continue to remain in full force and effect.</p>

    <p style=\"margin: 0 0 24px 0;\">We take this opportunity to thank you for your commitment and look forward to your continued dedication, leadership, and impactful contributions towards the continued growth of <strong>Infosof Technologies</strong>.</p>

    <div style=\"display: flex; justify-content: space-between; align-items: flex-end; margin-top: 40px; padding-top: 16px;\">
        <div>
            <div style=\"width: 140px; border-bottom: 1.5px solid #0f172a; margin-bottom: 8px;\"></div>
            <p style=\"margin: 0; font-weight: 700; color: #0f172a; font-size: 14px;\">Authorized Signatory</p>
            <p style=\"margin: 2px 0 0 0; color: #475569; font-size: 13px;\">Human Resources & Compensation Committee</p>
            <p style=\"margin: 2px 0 0 0; font-size: 13px; font-weight: 600; color: #2563eb;\">Infosof Technologies</p>
        </div>
        <div style=\"text-align: right;\">
            <p style=\"margin: 0; color: #64748b; font-size: 12px;\">Infosof Technologies People Operations</p>
            <p style=\"margin: 2px 0 0 0; color: #64748b; font-size: 12px;\">Confidential - For Internal Circulation Only</p>
        </div>
    </div>
</div>', '{{EMPLOYEE_NAME}}, {{EMPLOYEE_CODE}}, {{DESIGNATION}}, {{DEPARTMENT}}, {{GROSS_SALARY}}, {{TODAY_DATE}}, {{COMPANY_NAME}}', '1', '2026-09-28 14:03:04', '2026-09-28 14:03:04');

-- -----------------------------------------------------
-- Table structure for `employee_appraisals`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_appraisals`;
CREATE TABLE `employee_appraisals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cycle_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `reviewer_manager_id` int unsigned NOT NULL,
  `overall_self_score` decimal(4,2) NOT NULL DEFAULT '0.00',
  `overall_manager_score` decimal(4,2) NOT NULL DEFAULT '0.00',
  `final_rating_band` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promotion_recommended` tinyint(1) NOT NULL DEFAULT '0',
  `recommended_increment_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `key_strengths` text COLLATE utf8mb4_unicode_ci,
  `development_areas` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending_self_review','pending_manager_review','completed','acknowledged') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending_self_review',
  `completed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_appr_cycle_emp` (`cycle_id`,`employee_id`),
  KEY `fk_appr_emp` (`employee_id`),
  KEY `fk_appr_mgr` (`reviewer_manager_id`),
  CONSTRAINT `fk_appr_cycle` FOREIGN KEY (`cycle_id`) REFERENCES `performance_cycles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_appr_mgr` FOREIGN KEY (`reviewer_manager_id`) REFERENCES `employees` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `employee_appraisals` (4 rows)
INSERT INTO `employee_appraisals` (`id`, `cycle_id`, `employee_id`, `reviewer_manager_id`, `overall_self_score`, `overall_manager_score`, `final_rating_band`, `promotion_recommended`, `recommended_increment_percent`, `key_strengths`, `development_areas`, `status`, `completed_at`, `created_at`, `updated_at`) VALUES
('1', '1', '19', '1', '0.00', '4.30', 'Outstanding (Grade A)', '1', '4.50', '', '', 'completed', '2026-09-29 10:21:19', '2026-09-29 10:21:19', '2026-09-29 10:21:19'),
('2', '2', '17', '1', '0.00', '4.90', 'Outstanding (Grade A)', '1', '5.00', '', '', 'completed', '2026-09-29 10:25:56', '2026-09-29 10:25:56', '2026-09-29 10:25:56'),
('3', '2', '19', '1', '0.00', '4.30', 'Outstanding (Grade A)', '1', '5.00', '', '', 'completed', '2026-09-29 10:50:18', '2026-09-29 10:50:18', '2026-09-29 10:50:18'),
('4', '2', '7', '6', '4.20', '5.00', 'Outstanding (Grade A)', '0', '75.00', '', '', 'completed', '2026-09-29 10:57:56', '2026-09-29 10:50:29', '2026-09-29 10:57:56');

-- -----------------------------------------------------
-- Table structure for `employee_bank_details`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_bank_details`;
CREATE TABLE `employee_bank_details` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ifsc_swift_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method` enum('bank_transfer','cheque','cash') COLLATE utf8mb4_unicode_ci DEFAULT 'bank_transfer',
  `is_primary` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_bank_emp` (`employee_id`),
  CONSTRAINT `fk_bank_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `employee_bank_details` (11 rows)
INSERT INTO `employee_bank_details` (`id`, `employee_id`, `bank_name`, `account_name`, `account_number`, `ifsc_swift_code`, `branch_name`, `payment_method`, `is_primary`, `created_at`, `updated_at`) VALUES
('1', '1', 'JPMorgan Chase Bank', 'Demo Super Admin', '100020003001', 'DEMOUS33', 'Demo Downtown Branch', 'bank_transfer', '1', '2026-09-28 17:06:10', '2026-09-28 17:06:10'),
('2', '2', 'Bank of America', 'Demo HR Admin', '100020003002', 'DEMOUS33', 'Demo Downtown Branch', 'bank_transfer', '1', '2026-09-28 17:06:10', '2026-09-28 17:06:10'),
('3', '3', 'Wells Fargo Bank', 'Demo HR Executive', '100020003003', 'DEMOUS33', 'Demo Downtown Branch', 'bank_transfer', '1', '2026-09-28 17:06:10', '2026-09-28 17:06:10'),
('4', '4', 'Citibank NA', 'Demo Payroll Manager', '100020003004', 'DEMOUS33', 'Demo Downtown Branch', 'bank_transfer', '1', '2026-09-28 17:06:10', '2026-09-28 17:06:10'),
('5', '5', 'US Bank', 'Demo Accountant', '100020003005', 'DEMOUS33', 'Demo Downtown Branch', 'bank_transfer', '1', '2026-09-28 17:06:10', '2026-09-28 17:06:10'),
('6', '6', 'Silicon Valley Bank', 'Demo Manager', '100020003006', 'DEMOUS33', 'Demo Downtown Branch', 'bank_transfer', '1', '2026-09-28 17:06:10', '2026-09-28 17:06:10'),
('7', '7', 'Capital One', 'Demo Employee', '100020003007', 'DEMOUS33', 'Demo Downtown Branch', 'bank_transfer', '1', '2026-09-28 17:06:10', '2026-09-28 17:06:10'),
('8', '13', 'JPM', 'Ronaldo CR7', '12345678910', 'CHASU98', NULL, 'bank_transfer', '1', '2026-09-29 11:42:58', '2026-09-29 11:42:58'),
('9', '14', 'JPM', 'messi m10', '12345678123', 'CHAS101', NULL, 'bank_transfer', '1', '2026-09-29 11:52:54', '2026-09-29 11:52:54'),
('10', '17', 'JPM', 'sample Employee', '12345608525', 'CHAS641', NULL, 'bank_transfer', '1', '2026-09-29 14:13:21', '2026-09-29 14:13:21'),
('11', '18', 'STATE BANK OF INDIA', 'Sample Demo 2', '123456754321', 'SBIN000876', NULL, 'bank_transfer', '1', '2026-09-29 15:28:10', '2026-09-29 15:28:10');

-- -----------------------------------------------------
-- Table structure for `employee_custom_fields`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_custom_fields`;
CREATE TABLE `employee_custom_fields` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `field_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_value` text COLLATE utf8mb4_unicode_ci,
  `field_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_custom_emp` (`employee_id`),
  CONSTRAINT `fk_custom_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table structure for `employee_documents`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_documents`;
CREATE TABLE `employee_documents` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `document_type` enum('national_id','passport','resume','contract','degree','tax_form','certificate','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int unsigned DEFAULT '0',
  `expiry_date` date DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verified_by` int unsigned DEFAULT NULL,
  `uploaded_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_doc_emp` (`employee_id`),
  CONSTRAINT `fk_doc_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table structure for `employee_incentive_entries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_incentive_entries`;
CREATE TABLE `employee_incentive_entries` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `bonus_scheme_id` int unsigned NOT NULL,
  `reference_period` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'e.g. 2026-Q1, 2026-03',
  `target_achieved` decimal(12,2) NOT NULL DEFAULT '0.00',
  `calculated_amount` decimal(12,2) NOT NULL,
  `final_amount` decimal(12,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','manager_approved','hr_approved','payroll_batched','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `approved_by` int unsigned DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `payroll_run_id` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_inc_emp_period` (`employee_id`,`reference_period`),
  KEY `fk_inc_scheme` (`bonus_scheme_id`),
  KEY `fk_inc_approver` (`approved_by`),
  KEY `fk_inc_payroll` (`payroll_run_id`),
  CONSTRAINT `fk_inc_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_inc_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_inc_payroll` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_inc_scheme` FOREIGN KEY (`bonus_scheme_id`) REFERENCES `bonus_schemes` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `employee_incentive_entries` (1 rows)
INSERT INTO `employee_incentive_entries` (`id`, `employee_id`, `bonus_scheme_id`, `reference_period`, `target_achieved`, `calculated_amount`, `final_amount`, `notes`, `status`, `approved_by`, `approved_at`, `payroll_run_id`, `created_at`, `updated_at`) VALUES
('1', '17', '4', '2026-09', '0.00', '50000.00', '50000.00', '', 'hr_approved', '2', '2026-09-29 08:57:03', NULL, '2026-09-29 08:57:03', '2026-09-29 08:57:03');

-- -----------------------------------------------------
-- Table structure for `employee_loans`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_loans`;
CREATE TABLE `employee_loans` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `loan_application_no` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `loan_type` enum('salary_advance','personal_loan','emergency_advance','education_loan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'salary_advance',
  `principal_amount` decimal(12,2) NOT NULL,
  `interest_rate_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_repayable` decimal(12,2) NOT NULL,
  `tenure_months` int unsigned NOT NULL DEFAULT '1',
  `monthly_emi` decimal(12,2) NOT NULL,
  `disbursement_date` date DEFAULT NULL,
  `first_deduction_month` tinyint unsigned DEFAULT NULL,
  `first_deduction_year` int unsigned DEFAULT NULL,
  `total_paid` decimal(12,2) NOT NULL DEFAULT '0.00',
  `outstanding_balance` decimal(12,2) NOT NULL,
  `status` enum('submitted','manager_approved','finance_approved','disbursed','active','repaid','settled','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `approved_by` int unsigned DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `settlement_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loan_application_no` (`loan_application_no`),
  KEY `idx_loan_emp` (`employee_id`,`status`),
  KEY `fk_loan_approver` (`approved_by`),
  CONSTRAINT `fk_loan_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_loan_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `employee_loans` (2 rows)
INSERT INTO `employee_loans` (`id`, `loan_application_no`, `employee_id`, `loan_type`, `principal_amount`, `interest_rate_percent`, `total_repayable`, `tenure_months`, `monthly_emi`, `disbursement_date`, `first_deduction_month`, `first_deduction_year`, `total_paid`, `outstanding_balance`, `status`, `reason`, `approved_by`, `approved_at`, `settlement_notes`, `created_at`, `updated_at`) VALUES
('1', 'LN-20260929-3F9F', '17', 'emergency_advance', '100000.00', '0.00', '100000.00', '3', '33333.33', '2026-09-29', '10', '2026', '33333.33', '66666.67', 'active', 'Medical issue', '4', '2026-09-29 08:48:41', NULL, '2026-09-29 08:47:56', '2026-09-29 14:21:09'),
('2', 'LN-20260929-238A', '7', 'salary_advance', '30000.00', '0.00', '30000.00', '3', '10000.00', '2026-09-29', '10', '2026', '0.00', '30000.00', 'active', 'For house', '5', '2026-09-29 08:57:04', NULL, '2026-09-29 08:56:48', '2026-09-29 08:57:04');

-- -----------------------------------------------------
-- Table structure for `employee_skills`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_skills`;
CREATE TABLE `employee_skills` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `skill_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proficiency_level` enum('beginner','intermediate','advanced','expert') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'intermediate',
  `verified_by_training_id` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_es_emp` (`employee_id`),
  KEY `fk_es_train` (`verified_by_training_id`),
  CONSTRAINT `fk_es_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_es_train` FOREIGN KEY (`verified_by_training_id`) REFERENCES `training_programs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table structure for `employee_transfers_promotions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employee_transfers_promotions`;
CREATE TABLE `employee_transfers_promotions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `request_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `movement_type` enum('transfer','promotion','transfer_and_promotion','redesignation') COLLATE utf8mb4_unicode_ci NOT NULL,
  `effective_date` date NOT NULL,
  `from_branch_id` int unsigned DEFAULT NULL,
  `to_branch_id` int unsigned DEFAULT NULL,
  `from_department_id` int unsigned DEFAULT NULL,
  `to_department_id` int unsigned DEFAULT NULL,
  `from_designation_id` int unsigned DEFAULT NULL,
  `to_designation_id` int unsigned DEFAULT NULL,
  `from_pay_grade_id` int unsigned DEFAULT NULL,
  `to_pay_grade_id` int unsigned DEFAULT NULL,
  `from_reporting_to` int unsigned DEFAULT NULL,
  `to_reporting_to` int unsigned DEFAULT NULL,
  `current_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `revised_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','submitted','manager_endorsed','approved','rejected','implemented') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `requested_by` int unsigned DEFAULT NULL,
  `approved_by` int unsigned DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `implemented_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `request_number` (`request_number`),
  KEY `fk_etp_emp` (`employee_id`),
  KEY `fk_etp_fbr` (`from_branch_id`),
  KEY `fk_etp_tbr` (`to_branch_id`),
  KEY `fk_etp_fdept` (`from_department_id`),
  KEY `fk_etp_tdept` (`to_department_id`),
  KEY `fk_etp_fdes` (`from_designation_id`),
  KEY `fk_etp_tdes` (`to_designation_id`),
  KEY `fk_etp_fpg` (`from_pay_grade_id`),
  KEY `fk_etp_tpg` (`to_pay_grade_id`),
  KEY `fk_etp_req` (`requested_by`),
  KEY `fk_etp_app` (`approved_by`),
  CONSTRAINT `fk_etp_app` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_etp_fbr` FOREIGN KEY (`from_branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_fdept` FOREIGN KEY (`from_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_fdes` FOREIGN KEY (`from_designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_fpg` FOREIGN KEY (`from_pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_req` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_tbr` FOREIGN KEY (`to_branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_tdept` FOREIGN KEY (`to_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_tdes` FOREIGN KEY (`to_designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_etp_tpg` FOREIGN KEY (`to_pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `employee_transfers_promotions` (2 rows)
INSERT INTO `employee_transfers_promotions` (`id`, `request_number`, `employee_id`, `movement_type`, `effective_date`, `from_branch_id`, `to_branch_id`, `from_department_id`, `to_department_id`, `from_designation_id`, `to_designation_id`, `from_pay_grade_id`, `to_pay_grade_id`, `from_reporting_to`, `to_reporting_to`, `current_salary`, `revised_salary`, `reason`, `remarks`, `status`, `requested_by`, `approved_by`, `approved_at`, `implemented_at`, `created_at`, `updated_at`) VALUES
('1', 'MOV-20260929-6168', '13', 'transfer', '2026-09-29', '1', '2', '1', '11', '1', '5', '1', '2', NULL, '2', '15000.00', '30000.00', 'There is a need of  employee in noida branch', '', 'implemented', '1', '1', '2026-09-29 06:15:00', '2026-09-29 06:15:00', '2026-09-29 06:14:52', '2026-09-29 06:15:00'),
('2', 'MOV-20260929-779C', '19', 'promotion', '2026-09-29', '1', '1', '1', '3', '1', '4', '1', '2', NULL, NULL, '200000.00', '9000000.00', 'good employee', '', 'implemented', '1', '1', '2026-09-29 10:25:00', '2026-09-29 10:25:00', '2026-09-29 10:23:40', '2026-09-29 10:25:00');

-- -----------------------------------------------------
-- Table structure for `employees`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `company_id` int unsigned NOT NULL,
  `branch_id` int unsigned DEFAULT NULL,
  `department_id` int unsigned DEFAULT NULL,
  `designation_id` int unsigned DEFAULT NULL,
  `pay_grade_id` int unsigned DEFAULT NULL,
  `employee_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `official_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female','non_binary','other') COLLATE utf8mb4_unicode_ci DEFAULT 'male',
  `date_of_birth` date DEFAULT NULL,
  `marital_status` enum('single','married','divorced','widowed') COLLATE utf8mb4_unicode_ci DEFAULT 'single',
  `blood_group` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date NOT NULL,
  `confirmation_date` date DEFAULT NULL,
  `probation_end_date` date DEFAULT NULL,
  `employment_type` enum('full_time','part_time','contract','intern','probation') COLLATE utf8mb4_unicode_ci DEFAULT 'full_time',
  `employment_status` enum('active','on_leave','probation','notice_period','terminated','resigned','retired') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `reporting_to` int unsigned DEFAULT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci,
  `permanent_address` text COLLATE utf8mb4_unicode_ci,
  `city` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'United States',
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id_ssn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_identification_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `passport_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driving_license` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_relation` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact_phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_code` (`employee_code`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_emp_company` (`company_id`),
  KEY `fk_emp_branch` (`branch_id`),
  KEY `fk_emp_dept` (`department_id`),
  KEY `fk_emp_desig` (`designation_id`),
  KEY `fk_emp_grade` (`pay_grade_id`),
  KEY `fk_emp_manager` (`reporting_to`),
  CONSTRAINT `fk_emp_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_emp_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_emp_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_emp_desig` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_emp_grade` FOREIGN KEY (`pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_emp_manager` FOREIGN KEY (`reporting_to`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `employees` (19 rows)
INSERT INTO `employees` (`id`, `user_id`, `company_id`, `branch_id`, `department_id`, `designation_id`, `pay_grade_id`, `employee_code`, `first_name`, `middle_name`, `last_name`, `email`, `official_email`, `phone`, `gender`, `date_of_birth`, `marital_status`, `blood_group`, `joining_date`, `confirmation_date`, `probation_end_date`, `employment_type`, `employment_status`, `reporting_to`, `present_address`, `permanent_address`, `city`, `state`, `country`, `postal_code`, `national_id_ssn`, `tax_identification_number`, `passport_number`, `driving_license`, `emergency_contact_name`, `emergency_contact_relation`, `emergency_contact_phone`, `profile_photo`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1', '1', '1', '1', '1', '1', '1', 'EMP0001', 'Demo', NULL, 'Super Admin', 'demo.superadmin@infosof.com', 'demo.superadmin@infosof.com', '+1 555-0101', 'other', NULL, 'single', 'O+', '2024-01-15', NULL, NULL, 'full_time', 'active', NULL, '100 Enterprise Way, Suite 100, Demo City', '100 Enterprise Way, Suite 100, Demo City', 'Demo City', 'California', 'United States', '90001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('2', '2', '1', '1', '2', '2', '2', 'EMP0002', 'Demo', NULL, 'HR Admin', 'demo.hradmin@infosof.com', 'demo.hradmin@infosof.com', '+1 555-0102', 'female', NULL, 'married', 'A+', '2024-01-15', NULL, NULL, 'full_time', 'active', NULL, '200 Human Resources Blvd, Demo City', '200 Human Resources Blvd, Demo City', 'Demo City', 'California', 'United States', '90001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('3', '3', '1', '1', '2', '3', '3', 'EMP0003', 'Demo', NULL, 'HR Executive', 'demo.hrexecutive@infosof.com', 'demo.hrexecutive@infosof.com', '+1 555-0103', 'male', NULL, 'single', 'B+', '2024-01-15', NULL, NULL, 'full_time', 'active', NULL, '205 Talent Plaza, Demo City', '205 Talent Plaza, Demo City', 'Demo City', 'California', 'United States', '90001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('4', '4', '1', '1', '4', '6', '2', 'EMP0004', 'Demo', NULL, 'Payroll Manager', 'demo.payroll@infosof.com', 'demo.payroll@infosof.com', '+1 555-0104', 'female', NULL, 'married', 'AB+', '2024-01-15', NULL, NULL, 'full_time', 'active', NULL, '300 Finance Avenue, Demo City', '300 Finance Avenue, Demo City', 'Demo City', 'California', 'United States', '90001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('5', '5', '1', '1', '4', '7', '3', 'EMP0005', 'Demo', NULL, 'Accountant', 'demo.accountant@infosof.com', 'demo.accountant@infosof.com', '+1 555-0105', 'male', NULL, 'single', 'O-', '2024-01-15', NULL, NULL, 'full_time', 'active', NULL, '305 Ledger Park, Demo City', '305 Ledger Park, Demo City', 'Demo City', 'California', 'United States', '90001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('6', '6', '1', '1', '3', '4', '2', 'EMP0006', 'Demo', NULL, 'Manager', 'demo.manager@infosof.com', 'demo.manager@infosof.com', '+1 555-0106', 'male', NULL, 'married', 'A+', '2024-01-15', NULL, NULL, 'full_time', 'active', NULL, '400 Engineering Circle, Demo City', '400 Engineering Circle, Demo City', 'Demo City', 'California', 'United States', '90001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('7', '7', '1', '2', '3', '5', '3', 'EMP0007', 'Demo', '', 'Employee', 'demo.employee@infosof.com', 'demo.employee@infosof.com', '+1 555-0107', 'non_binary', NULL, 'single', 'B+', '2024-01-15', '2026-09-29', '2026-11-13', 'full_time', 'active', '6', '500 Developer Parkway, Demo City', '500 Developer Parkway, Demo City', 'Demo City', 'UP', 'India', '90001', NULL, NULL, NULL, NULL, '', '', '', NULL, '2026-09-28 17:06:10', '2026-09-29 07:05:53', NULL),
('8', '8', '1', '1', '3', '4', '4', 'EMP0008', 'vishal', '', 'jha', 'vishal@gmail.com', 'vishal@gmail.com', '7458961236', 'male', NULL, 'single', '', '2026-09-28', NULL, NULL, 'full_time', 'terminated', NULL, 'bally,howrah', '', 'kolkata', 'west bengal', 'India', '700458', NULL, NULL, NULL, NULL, '', NULL, '', NULL, '2026-09-28 12:02:23', '2026-09-28 12:18:16', '2026-09-28 12:18:16'),
('10', '10', '1', '1', '1', '1', '1', 'EMP0009', 'Rishav', '', 'xyz', 'rishav@gmail.com', 'rishav@gmail.com', '+919123011944', 'male', NULL, 'single', '', '2026-09-29', NULL, NULL, 'full_time', 'terminated', NULL, 'Adamas university', 'Adamas university', 'barasat', 'West Bengal', 'India', '700126', NULL, NULL, NULL, NULL, '', NULL, '', NULL, '2026-09-29 05:51:40', '2026-09-29 05:56:20', '2026-09-29 05:56:20'),
('11', '11', '1', '1', '1', '1', '1', 'EMP0010', 'Ronaldo', '', 'cr7', 'cr7@gmail.com', 'cr7@gmail.com', '+919804321944', 'male', NULL, 'single', '', '2026-09-29', NULL, NULL, 'full_time', 'terminated', NULL, 'Adamas university', 'Adamas university', 'barasat', 'West Bengal', 'India', '700126', NULL, NULL, NULL, NULL, '', NULL, '', NULL, '2026-09-29 05:53:54', '2026-09-29 05:54:12', '2026-09-29 05:54:12'),
('12', '12', '1', '1', '1', '1', '1', 'EMP0011', 'Ronaldo', '', 'cr7', 'cekdoteen@gmail.com', 'cekdoteen@gmail.com', '+919800011213', 'male', NULL, 'single', '', '2026-09-29', NULL, NULL, 'full_time', 'terminated', NULL, 'Adamas university', '', 'barasat', 'West Bengal', 'United States', '700126', NULL, NULL, NULL, NULL, '', NULL, '', NULL, '2026-09-29 05:55:31', '2026-09-29 05:56:10', '2026-09-29 05:56:10'),
('13', '13', '1', '2', '11', '5', '2', 'EMP0012', 'Ronaldo', '', 'CR7', 'Ronaldo@gmail.com', 'Ronaldo@gmail.com', '+919800011234', 'male', NULL, 'single', '', '2026-09-29', '2026-09-29', '2026-11-28', 'full_time', 'terminated', '6', 'kolkata', 'salt lake', 'portugal para', 'West Bengal', 'India', '700091', NULL, NULL, NULL, NULL, '', '', '', NULL, '2026-09-29 06:12:58', '2026-09-29 11:31:31', '2026-09-29 11:31:31'),
('14', '14', '1', '1', '1', '1', '1', 'EMP0013', 'messi', '', 'm10', 'messi@gmail.com', 'messi@gmail.com', '+91980001765', 'male', NULL, 'single', '', '2026-09-29', NULL, NULL, 'full_time', 'terminated', NULL, 'Adamas university', 'Adamas university', 'barasat', 'West Bengal', 'India', '700126', NULL, NULL, NULL, NULL, '', NULL, '', NULL, '2026-09-29 06:22:54', '2026-09-29 06:23:13', '2026-09-29 06:23:13'),
('15', '15', '1', '1', '1', '1', '1', 'EMP0014', 'Messi', '', 'paul', 'messi123@gmail.com', 'messi123@gmail.com', '1234567890', 'male', NULL, 'single', '', '2026-09-29', '2026-09-29', '2027-01-04', 'full_time', 'terminated', '6', '', '', '', '', 'United States', '', NULL, NULL, NULL, NULL, '', '', '', NULL, '2026-09-29 06:25:01', '2026-09-29 11:31:38', '2026-09-29 11:31:38'),
('16', '16', '1', '1', '11', '1', NULL, 'EMP0015', 'Rupam', NULL, 'Staff', 'rupam2003@gmail.com', 'rupam.staff@infosof.com', '+919510011944', 'other', NULL, 'single', NULL, '2026-09-29', '2026-09-19', NULL, 'full_time', 'terminated', NULL, NULL, NULL, NULL, NULL, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 06:28:34', '2026-09-29 11:31:19', '2026-09-29 11:31:19'),
('17', '17', '1', '3', '4', '7', '1', 'EMP0016', 'sample', '', 'Employee', 'sample@gmail.com', 'sample@gmail.com', '+919800097531', 'male', NULL, 'single', '', '2026-09-29', NULL, NULL, 'full_time', 'active', NULL, 'kolkata', 'salt lake', 'mahish bathan', 'West Bengal', 'India', '700091', NULL, NULL, NULL, NULL, '', '', '', NULL, '2026-09-29 08:43:21', '2026-09-29 08:44:43', NULL),
('18', '18', '1', '1', '3', '4', '2', 'EMP0017', 'Sample', '', 'Demo 2', 'demo2@gmail.com', 'demo2@gmail.com', '9000000123', 'male', NULL, 'single', 'o+', '2026-09-29', '2026-09-29', '2026-12-29', 'full_time', 'terminated', '6', 'Newtown ,Kolkata', 'Newtown ,Kolkata', 'kolkata', '', 'India', '', NULL, NULL, NULL, NULL, '', '', '', NULL, '2026-09-29 09:58:09', '2026-09-29 11:31:08', '2026-09-29 11:31:08'),
('19', '19', '1', '1', '3', '4', '2', 'EMP0018', 'Priyanshu', '', 'Paul', 'priyanshupaul.mng2003@gmail.com', 'priyanshupaul.mng2003@gmail.com', '+919800011944', 'male', NULL, 'single', '', '2026-09-29', NULL, NULL, 'full_time', 'terminated', NULL, 'Adamas university', '', 'barasat', 'West Bengal', 'India', '700126', NULL, NULL, NULL, NULL, '', NULL, '', NULL, '2026-09-29 10:04:04', '2026-09-29 11:30:55', '2026-09-29 11:30:55'),
('20', '20', '1', '1', '11', '1', NULL, 'EMP0019', 'dhurv', NULL, 'vikram', 'vikram@gmail.com', 'dhurv.vikram@infosof.com', '7412589635', 'other', NULL, 'single', NULL, '2026-09-29', NULL, '2026-12-29', 'probation', 'probation', NULL, NULL, NULL, NULL, NULL, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-09-29 11:16:54', '2026-09-29 11:32:08', NULL);

-- -----------------------------------------------------
-- Table structure for `exit_clearances`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exit_clearances`;
CREATE TABLE `exit_clearances` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `resignation_id` int unsigned NOT NULL,
  `department_type` enum('IT','Finance','HR','Admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','cleared','flagged') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `cleared_by_user_id` int unsigned DEFAULT NULL,
  `cleared_at` datetime DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `dues_or_recoveries` decimal(12,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_clear_resig` (`resignation_id`),
  CONSTRAINT `fk_clear_resig` FOREIGN KEY (`resignation_id`) REFERENCES `resignations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `exit_clearances` (12 rows)
INSERT INTO `exit_clearances` (`id`, `resignation_id`, `department_type`, `status`, `cleared_by_user_id`, `cleared_at`, `remarks`, `dues_or_recoveries`, `created_at`, `updated_at`) VALUES
('1', '1', 'IT', 'cleared', '1', '2026-09-25 09:00:59', 'All laptops and tokens returned', '0.00', '2026-09-25 14:28:44', '2026-09-25 14:30:59'),
('2', '1', 'Finance', 'cleared', '1', '2026-09-25 09:01:00', 'Expense claims settled', '0.00', '2026-09-25 14:28:44', '2026-09-25 14:31:00'),
('3', '1', 'HR', 'cleared', '1', '2026-09-25 09:01:00', 'Exit interview complete', '0.00', '2026-09-25 14:28:44', '2026-09-25 14:31:00'),
('4', '1', 'Admin', 'cleared', '1', '2026-09-25 09:01:00', 'Access card and desk vacated', '0.00', '2026-09-25 14:28:44', '2026-09-25 14:31:00'),
('5', '3', 'IT', 'pending', NULL, NULL, 'Laptop, monitors, peripherals, and SSO credentials revocation', '0.00', '2026-09-28 14:18:44', '2026-09-28 14:18:44'),
('6', '3', 'Finance', 'pending', NULL, NULL, 'Travel advance reconciliation and corporate credit card clearance', '0.00', '2026-09-28 14:18:44', '2026-09-28 14:18:44'),
('7', '3', 'HR', 'pending', NULL, NULL, 'Exit interview completion, non-disclosure agreement, ID badge return', '0.00', '2026-09-28 14:18:44', '2026-09-28 14:18:44'),
('8', '3', 'Admin', 'pending', NULL, NULL, 'Desk clearance, parking tags, and facility access card deactivation', '0.00', '2026-09-28 14:18:44', '2026-09-28 14:18:44'),
('9', '2', 'IT', 'pending', NULL, NULL, 'Laptop, monitors, peripherals, and SSO credentials revocation', '0.00', '2026-09-29 12:24:11', '2026-09-29 12:24:11'),
('10', '2', 'Finance', 'pending', NULL, NULL, 'Travel advance reconciliation and corporate credit card clearance', '0.00', '2026-09-29 12:24:11', '2026-09-29 12:24:11'),
('11', '2', 'HR', 'pending', NULL, NULL, 'Exit interview completion, non-disclosure agreement, ID badge return', '0.00', '2026-09-29 12:24:11', '2026-09-29 12:24:11'),
('12', '2', 'Admin', 'pending', NULL, NULL, 'Desk clearance, parking tags, and facility access card deactivation', '0.00', '2026-09-29 12:24:11', '2026-09-29 12:24:11');

-- -----------------------------------------------------
-- Table structure for `expense_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `expense_categories`;
CREATE TABLE `expense_categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_limit_per_claim` decimal(12,2) DEFAULT NULL,
  `requires_receipt` tinyint(1) NOT NULL DEFAULT '1',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_expcat_company` (`company_id`),
  CONSTRAINT `fk_expcat_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `expense_categories` (5 rows)
INSERT INTO `expense_categories` (`id`, `company_id`, `name`, `code`, `max_limit_per_claim`, `requires_receipt`, `description`, `status`, `updated_at`) VALUES
('1', '1', 'Client Meals & Entertainment', 'EXP-MEAL', '250.00', '1', 'Official business meal expenses with external clients', 'active', '2026-09-26 15:13:53'),
('2', '1', 'Local Conveyance & Fuel', 'EXP-TRANS', '150.00', '1', 'Local taxi, rideshare, and fuel recharges for office visits', 'active', '2026-09-26 15:13:53'),
('3', '1', 'Mobile & High-Speed Internet', 'EXP-COMM', '100.00', '1', 'Work-from-home broadband and official telecom bills', 'active', '2026-09-26 15:13:53'),
('4', '1', 'Books & Professional Certifications', 'EXP-CERT', '500.00', '1', 'Professional membership and training exam fee reimbursements', 'active', '2026-09-26 15:13:53'),
('5', '1', 'Office Supplies & Peripherals', 'EXP-SUPPLY', '200.00', '1', 'Mouse, keyboards, cables, and home workspace accessories', 'active', '2026-09-26 15:13:53');

-- -----------------------------------------------------
-- Table structure for `financial_years`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `financial_years`;
CREATE TABLE `financial_years` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_current` tinyint(1) DEFAULT '0',
  `status` enum('active','closed') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_fy_company` (`company_id`),
  CONSTRAINT `fk_fy_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `financial_years` (1 rows)
INSERT INTO `financial_years` (`id`, `company_id`, `title`, `start_date`, `end_date`, `is_current`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', 'FY 2026 - 2027', '2026-01-01', '2026-12-31', '1', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51');

-- -----------------------------------------------------
-- Table structure for `fnf_settlements`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fnf_settlements`;
CREATE TABLE `fnf_settlements` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `resignation_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `settlement_date` date NOT NULL,
  `unpaid_salary_days` int DEFAULT '0',
  `unpaid_salary_amount` decimal(12,2) DEFAULT '0.00',
  `leave_encashment_days` int DEFAULT '0',
  `leave_encashment_amount` decimal(12,2) DEFAULT '0.00',
  `gratuity_amount` decimal(12,2) DEFAULT '0.00',
  `bonus_amount` decimal(12,2) DEFAULT '0.00',
  `total_earnings` decimal(12,2) DEFAULT '0.00',
  `notice_shortfall_recovery` decimal(12,2) DEFAULT '0.00',
  `asset_damage_deduction` decimal(12,2) DEFAULT '0.00',
  `statutory_tax_deduction` decimal(12,2) DEFAULT '0.00',
  `total_deductions` decimal(12,2) DEFAULT '0.00',
  `net_payable_amount` decimal(12,2) DEFAULT '0.00',
  `payment_mode` enum('bank_transfer','cheque','neft') COLLATE utf8mb4_unicode_ci DEFAULT 'bank_transfer',
  `payment_reference` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settlement_status` enum('draft','calculated','approved','disbursed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `approved_by` int unsigned DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resignation_id` (`resignation_id`),
  KEY `fk_fnf_emp` (`employee_id`),
  CONSTRAINT `fk_fnf_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_fnf_resig` FOREIGN KEY (`resignation_id`) REFERENCES `resignations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `fnf_settlements` (2 rows)
INSERT INTO `fnf_settlements` (`id`, `resignation_id`, `employee_id`, `settlement_date`, `unpaid_salary_days`, `unpaid_salary_amount`, `leave_encashment_days`, `leave_encashment_amount`, `gratuity_amount`, `bonus_amount`, `total_earnings`, `notice_shortfall_recovery`, `asset_damage_deduction`, `statutory_tax_deduction`, `total_deductions`, `net_payable_amount`, `payment_mode`, `payment_reference`, `settlement_status`, `approved_by`, `remarks`, `created_at`, `updated_at`) VALUES
('1', '1', '13', '2026-09-29', '15', '27675.00', '30', '35000.00', '0.00', '0.00', '62675.00', '0.00', '0.00', '6267.50', '6267.50', '56407.50', 'bank_transfer', NULL, 'calculated', '1', NULL, '2026-09-29 12:24:03', '2026-09-29 12:24:03'),
('2', '2', '13', '2026-09-29', '15', '27675.00', '30', '35000.00', '0.00', '0.00', '62675.00', '0.00', '0.00', '6267.50', '6267.50', '56407.50', 'bank_transfer', NULL, 'calculated', '1', NULL, '2026-09-29 12:24:23', '2026-09-29 12:24:23');

-- -----------------------------------------------------
-- Table structure for `holidays`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `holidays`;
CREATE TABLE `holidays` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `branch_id` int unsigned DEFAULT NULL,
  `department_id` int unsigned DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `holiday_type` enum('national','regional','company','restricted','optional') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'company',
  `date` date NOT NULL,
  `is_recurring` tinyint(1) DEFAULT '0',
  `is_working_day` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_hol_company` (`company_id`),
  KEY `fk_hol_branch` (`branch_id`),
  KEY `fk_hol_dept` (`department_id`),
  CONSTRAINT `fk_hol_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_hol_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_hol_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `holidays` (4 rows)
INSERT INTO `holidays` (`id`, `company_id`, `branch_id`, `department_id`, `title`, `holiday_type`, `date`, `is_recurring`, `is_working_day`, `description`, `created_at`, `updated_at`) VALUES
('1', '1', NULL, NULL, 'Ind', 'national', '2027-08-15', '0', '0', '', '2026-09-26 10:56:39', '2026-09-26 10:56:39'),
('4', '1', NULL, NULL, 'gandhi janati', 'company', '2026-10-02', '0', '0', '', '2026-09-28 06:29:56', '2026-09-28 06:29:56'),
('5', '1', NULL, NULL, 'chirsmas ', 'company', '2026-12-25', '0', '0', '', '2026-09-28 09:27:58', '2026-09-28 09:27:58'),
('6', '1', NULL, NULL, 'Mohaloya', 'company', '2026-09-28', '0', '0', '', '2026-09-28 12:24:50', '2026-09-28 12:24:50');

-- -----------------------------------------------------
-- Table structure for `hr_announcements`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `hr_announcements`;
CREATE TABLE `hr_announcements` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `title` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_audience` enum('all','department','branch','roles') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `target_id` int unsigned DEFAULT NULL,
  `priority` enum('low','normal','urgent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `published_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expires_at` date DEFAULT NULL,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int unsigned NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_ann_company` (`company_id`),
  KEY `fk_ann_creator` (`created_by`),
  CONSTRAINT `fk_ann_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ann_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `hr_announcements` (1 rows)
INSERT INTO `hr_announcements` (`id`, `company_id`, `title`, `content`, `target_audience`, `target_id`, `priority`, `is_published`, `published_at`, `expires_at`, `attachment_path`, `created_by`, `created_at`, `updated_at`) VALUES
('1', '1', 'leave for today', 'leave for today for the earth quake', 'all', NULL, 'normal', '1', '2026-09-29 09:51:15', NULL, NULL, '1', '2026-09-29 09:51:15', '2026-09-29 09:51:15');

-- -----------------------------------------------------
-- Table structure for `job_openings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `job_openings`;
CREATE TABLE `job_openings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int unsigned NOT NULL,
  `designation_id` int unsigned DEFAULT NULL,
  `vacancies` int unsigned NOT NULL DEFAULT '1',
  `job_type` enum('full_time','part_time','contract','remote') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full_time',
  `experience_required` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '1-3 years',
  `location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Headquarters',
  `min_salary` decimal(12,2) DEFAULT '0.00',
  `max_salary` decimal(12,2) DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `requirements` text COLLATE utf8mb4_unicode_ci,
  `status` enum('open','closed','on_hold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `closing_date` date DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_code` (`job_code`),
  KEY `fk_jobs_dept` (`department_id`),
  CONSTRAINT `fk_jobs_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `job_openings` (5 rows)
INSERT INTO `job_openings` (`id`, `title`, `job_code`, `department_id`, `designation_id`, `vacancies`, `job_type`, `experience_required`, `location`, `min_salary`, `max_salary`, `description`, `requirements`, `status`, `closing_date`, `created_by`, `created_at`, `updated_at`) VALUES
('1', 'Senior Full-Stack Engineer', 'JOB-2026-001', '1', '1', '2', 'full_time', '4-7 years', 'Kolkata Headquarters', '95000.00', '130000.00', 'Responsible for architecting scalable cloud-native microservices and responsive web platforms.', NULL, 'open', NULL, NULL, '2026-09-25 13:02:59', '2026-09-26 12:53:13'),
('2', 'HR Business Partner', 'JOB-2026-002', '2', '3', '1', 'full_time', '3-5 years', 'Kolkata Headquarters', '70000.00', '90000.00', 'Lead talent acquisition, employee relations, and policy compliance initiatives.', NULL, 'open', NULL, NULL, '2026-09-25 13:02:59', '2026-09-26 12:53:13'),
('3', 'Financial Planning Analyst', 'JOB-2026-003', '3', '5', '1', 'full_time', '2-4 years', 'Bangalore Office', '65000.00', '85000.00', 'Perform corporate budgeting, variance analysis, and statutory tax modeling.', NULL, 'open', NULL, NULL, '2026-09-25 13:02:59', '2026-09-26 12:53:13'),
('4', 'kmlnm', 'JOB-2026-004', '2', NULL, '1', 'part_time', '15', 'Headquarters', '80000.00', '85000.00', '', NULL, 'open', NULL, '4', '2026-09-28 13:11:57', '2026-09-28 13:11:57'),
('5', 'Senior Backend Engineer', 'JOB-2026-005', '11', NULL, '1', 'full_time', '0-1', 'Headquarters', '15000.00', '18000.00', '', NULL, 'open', NULL, '1', '2026-09-29 11:56:16', '2026-09-29 11:56:16');

-- -----------------------------------------------------
-- Table structure for `late_early_policies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `late_early_policies`;
CREATE TABLE `late_early_policies` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL DEFAULT '1',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `policy_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grace_period_mins` int unsigned NOT NULL DEFAULT '15',
  `early_exit_tolerance_mins` int unsigned NOT NULL DEFAULT '15',
  `max_monthly_late_count` int unsigned NOT NULL DEFAULT '3',
  `deduction_rule` enum('none','quarter_day','half_day','full_day','hourly_rate') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'half_day',
  `deduction_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `policy_code` (`policy_code`),
  KEY `fk_lep_company` (`company_id`),
  CONSTRAINT `fk_lep_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `late_early_policies` (2 rows)
INSERT INTO `late_early_policies` (`id`, `company_id`, `name`, `policy_code`, `grace_period_mins`, `early_exit_tolerance_mins`, `max_monthly_late_count`, `deduction_rule`, `deduction_rate`, `is_active`, `created_at`, `updated_at`) VALUES
('1', '1', 'Standard Enterprise Attendance Policy', 'LE-POL-STD', '15', '15', '10', 'half_day', '0.00', '1', '2026-09-26 13:12:05', '2026-09-28 12:22:14'),
('2', '1', 'Executive Strict Punch Policy', 'LE-POL-EXEC', '10', '10', '2', 'quarter_day', '0.25', '1', '2026-09-26 13:12:05', '2026-09-26 13:12:05');

-- -----------------------------------------------------
-- Table structure for `leave_balances`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `leave_balances`;
CREATE TABLE `leave_balances` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `leave_type_id` int unsigned NOT NULL,
  `year` int NOT NULL,
  `allocated_days` decimal(4,1) DEFAULT '0.0',
  `used_days` decimal(4,1) DEFAULT '0.0',
  `pending_days` decimal(4,1) DEFAULT '0.0',
  `remaining_days` decimal(4,1) DEFAULT '0.0',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_emp_lt_yr` (`employee_id`,`leave_type_id`,`year`),
  KEY `fk_lb_lt` (`leave_type_id`),
  CONSTRAINT `fk_lb_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lb_lt` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `leave_balances` (69 rows)
INSERT INTO `leave_balances` (`id`, `employee_id`, `leave_type_id`, `year`, `allocated_days`, `used_days`, `pending_days`, `remaining_days`, `updated_at`) VALUES
('1', '1', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-28 17:06:10'),
('2', '1', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:06:10'),
('3', '1', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:06:10'),
('4', '2', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-28 17:06:10'),
('5', '2', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:06:10'),
('6', '2', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:06:10'),
('7', '3', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-28 17:06:10'),
('8', '3', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:06:10'),
('9', '3', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:06:10'),
('10', '4', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-28 17:06:10'),
('11', '4', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:06:10'),
('12', '4', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:06:10'),
('13', '5', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-28 17:06:10'),
('14', '5', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:06:10'),
('15', '5', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:06:10'),
('16', '6', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-28 17:06:10'),
('17', '6', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:06:10'),
('18', '6', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:06:10'),
('19', '7', '1', '2026', '18.0', '1.0', '0.0', '17.0', '2026-09-28 17:56:36'),
('20', '7', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:06:10'),
('21', '7', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:06:10'),
('22', '8', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-28 17:32:23'),
('23', '8', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-28 17:32:23'),
('24', '8', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-28 17:32:23'),
('25', '8', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-28 17:32:23'),
('30', '10', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 11:21:40'),
('31', '10', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 11:21:40'),
('32', '10', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 11:21:40'),
('33', '10', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 11:21:40'),
('34', '11', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 11:23:54'),
('35', '11', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 11:23:54'),
('36', '11', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 11:23:54'),
('37', '11', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 11:23:54'),
('38', '12', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 11:25:32'),
('39', '12', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 11:25:32'),
('40', '12', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 11:25:32'),
('41', '12', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 11:25:32'),
('42', '13', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 11:42:58'),
('43', '13', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 11:42:58'),
('44', '13', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 11:42:58'),
('45', '13', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 11:42:58'),
('46', '14', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 11:52:54'),
('47', '14', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 11:52:54'),
('48', '14', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 11:52:54'),
('49', '14', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 11:52:54'),
('50', '15', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 11:55:01'),
('51', '15', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 11:55:01'),
('52', '15', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 11:55:01'),
('53', '15', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 11:55:01'),
('54', '16', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 11:58:34'),
('55', '16', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 11:58:34'),
('56', '16', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 11:58:34'),
('57', '16', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 11:58:34'),
('58', '17', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 14:13:21'),
('59', '17', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 14:13:21'),
('60', '17', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 14:13:21'),
('61', '17', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 14:13:21'),
('62', '18', '1', '2026', '18.0', '0.5', '0.0', '17.5', '2026-09-29 15:33:11'),
('63', '18', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 15:28:10'),
('64', '18', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 15:28:10'),
('65', '18', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 15:28:10'),
('66', '19', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 15:34:04'),
('67', '19', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 15:34:04'),
('68', '19', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 15:34:04'),
('69', '19', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 15:34:04'),
('70', '20', '1', '2026', '18.0', '0.0', '0.0', '18.0', '2026-09-29 16:46:54'),
('71', '20', '2', '2026', '10.0', '0.0', '0.0', '10.0', '2026-09-29 16:46:54'),
('72', '20', '3', '2026', '12.0', '0.0', '0.0', '12.0', '2026-09-29 16:46:54'),
('73', '20', '4', '2026', '0.0', '0.0', '0.0', '0.0', '2026-09-29 16:46:54');

-- -----------------------------------------------------
-- Table structure for `leave_requests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `leave_requests`;
CREATE TABLE `leave_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `leave_type_id` int unsigned NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days` decimal(4,1) NOT NULL,
  `is_half_day` tinyint(1) DEFAULT '0',
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','manager_approved','hr_approved','rejected','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `manager_id` int unsigned DEFAULT NULL,
  `manager_action_at` datetime DEFAULT NULL,
  `hr_id` int unsigned DEFAULT NULL,
  `hr_action_at` datetime DEFAULT NULL,
  `rejection_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_lr_emp` (`employee_id`),
  KEY `fk_lr_lt` (`leave_type_id`),
  CONSTRAINT `fk_lr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lr_lt` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `leave_requests` (3 rows)
INSERT INTO `leave_requests` (`id`, `employee_id`, `leave_type_id`, `start_date`, `end_date`, `total_days`, `is_half_day`, `reason`, `status`, `manager_id`, `manager_action_at`, `hr_id`, `hr_action_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
('1', '7', '1', '2026-09-28', '2026-09-28', '1.0', '0', 'Holiday for rakhi', 'hr_approved', NULL, NULL, '2', '2026-09-28 12:26:36', NULL, '2026-09-28 12:25:59', '2026-09-28 12:26:36'),
('2', '18', '1', '2026-09-30', '2026-09-30', '0.5', '1', 'fever', 'rejected', NULL, NULL, NULL, NULL, 'you are lying', '2026-09-29 10:02:32', '2026-09-29 10:03:33'),
('3', '18', '1', '2026-09-30', '2026-09-30', '0.5', '1', 'fever', 'hr_approved', NULL, NULL, '1', '2026-09-29 10:03:11', NULL, '2026-09-29 10:02:35', '2026-09-29 10:03:11');

-- -----------------------------------------------------
-- Table structure for `leave_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `leave_types`;
CREATE TABLE `leave_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `days_allowed_per_year` decimal(4,1) NOT NULL DEFAULT '12.0',
  `is_paid` tinyint(1) DEFAULT '1',
  `carry_forward_allowed` tinyint(1) DEFAULT '0',
  `max_carry_forward` decimal(4,1) DEFAULT '0.0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_lt_company` (`company_id`),
  CONSTRAINT `fk_lt_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `leave_types` (4 rows)
INSERT INTO `leave_types` (`id`, `company_id`, `name`, `code`, `days_allowed_per_year`, `is_paid`, `carry_forward_allowed`, `max_carry_forward`, `status`, `created_at`) VALUES
('1', '1', 'Paid Annual Leave', 'AL', '18.0', '1', '1', '6.0', 'active', '2026-09-25 12:26:51'),
('2', '1', 'Casual Leave', 'CL', '10.0', '1', '0', '0.0', 'active', '2026-09-25 12:26:51'),
('3', '1', 'Medical / Sick Leave', 'SL', '12.0', '1', '0', '0.0', 'active', '2026-09-25 12:26:51'),
('4', '1', 'Unpaid Leave / LOP', 'LOP', '0.0', '0', '0', '0.0', 'active', '2026-09-25 12:26:51');

-- -----------------------------------------------------
-- Table structure for `loan_repayment_schedules`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `loan_repayment_schedules`;
CREATE TABLE `loan_repayment_schedules` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `loan_id` int unsigned NOT NULL,
  `installment_number` int unsigned NOT NULL,
  `due_month` tinyint unsigned NOT NULL,
  `due_year` int unsigned NOT NULL,
  `emi_amount` decimal(12,2) NOT NULL,
  `principal_component` decimal(12,2) NOT NULL,
  `interest_component` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `paid_date` date DEFAULT NULL,
  `payroll_run_id` int unsigned DEFAULT NULL,
  `status` enum('scheduled','deducted','paid_manually','waived','deferred') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_lrs_due` (`due_year`,`due_month`,`status`),
  KEY `fk_lrs_loan` (`loan_id`),
  KEY `fk_lrs_payroll` (`payroll_run_id`),
  CONSTRAINT `fk_lrs_loan` FOREIGN KEY (`loan_id`) REFERENCES `employee_loans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lrs_payroll` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `loan_repayment_schedules` (30 rows)
INSERT INTO `loan_repayment_schedules` (`id`, `loan_id`, `installment_number`, `due_month`, `due_year`, `emi_amount`, `principal_component`, `interest_component`, `paid_amount`, `paid_date`, `payroll_run_id`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', '1', '10', '2026', '33333.33', '33333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:32:51', '2026-09-28 06:32:51'),
('2', '1', '2', '11', '2026', '33333.33', '33333.33', '0.00', '33333.33', '2026-09-28', NULL, 'deducted', '2026-09-28 06:32:51', '2026-09-28 13:15:31'),
('3', '1', '3', '12', '2026', '33333.33', '33333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:32:51', '2026-09-28 06:32:51'),
('4', '4', '1', '10', '2026', '6666.67', '6666.67', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:50:19', '2026-09-28 06:50:19'),
('5', '4', '2', '11', '2026', '6666.67', '6666.67', '0.00', '6666.67', '2026-09-28', NULL, 'deducted', '2026-09-28 06:50:19', '2026-09-28 13:15:31'),
('6', '4', '3', '12', '2026', '6666.67', '6666.67', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:50:19', '2026-09-28 06:50:19'),
('7', '3', '1', '10', '2026', '3333.33', '3333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:50:22', '2026-09-28 06:50:22'),
('8', '3', '2', '11', '2026', '3333.33', '3333.33', '0.00', '3333.33', '2026-09-28', NULL, 'deducted', '2026-09-28 06:50:22', '2026-09-28 13:15:31'),
('9', '3', '3', '12', '2026', '3333.33', '3333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:50:22', '2026-09-28 06:50:22'),
('10', '2', '1', '10', '2026', '3333.33', '3333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:50:25', '2026-09-28 06:50:25'),
('11', '2', '2', '11', '2026', '3333.33', '3333.33', '0.00', '3333.33', '2026-09-28', NULL, 'deducted', '2026-09-28 06:50:25', '2026-09-28 13:15:31'),
('12', '2', '3', '12', '2026', '3333.33', '3333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 06:50:25', '2026-09-28 06:50:25'),
('13', '5', '1', '10', '2026', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('14', '5', '2', '11', '2026', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('15', '5', '3', '12', '2026', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('16', '5', '4', '1', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('17', '5', '5', '2', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('18', '5', '6', '3', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('19', '5', '7', '4', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('20', '5', '8', '5', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('21', '5', '9', '6', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('22', '5', '10', '7', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('23', '5', '11', '8', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('24', '5', '12', '9', '2027', '833333.33', '833333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-28 09:00:41', '2026-09-28 09:00:41'),
('25', '1', '1', '10', '2026', '33333.33', '33333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-29 08:48:41', '2026-09-29 08:48:41'),
('26', '1', '2', '11', '2026', '33333.33', '33333.33', '0.00', '33333.33', '2026-09-29', '12', 'deducted', '2026-09-29 08:48:41', '2026-09-29 14:21:09'),
('27', '1', '3', '12', '2026', '33333.33', '33333.33', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-29 08:48:41', '2026-09-29 08:48:41'),
('28', '2', '1', '10', '2026', '10000.00', '10000.00', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-29 08:57:04', '2026-09-29 08:57:04'),
('29', '2', '2', '11', '2026', '10000.00', '10000.00', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-29 08:57:04', '2026-09-29 08:57:04'),
('30', '2', '3', '12', '2026', '10000.00', '10000.00', '0.00', '0.00', NULL, NULL, 'scheduled', '2026-09-29 08:57:04', '2026-09-29 08:57:04');

-- -----------------------------------------------------
-- Table structure for `notification_templates`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `notification_templates`;
CREATE TABLE `notification_templates` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `template_key` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` enum('email','sms','whatsapp','in_app','all') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_app',
  `subject` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `variables` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{{EMPLOYEE_NAME}}, {{ACTION_DATE}}, {{DETAILS}}, {{COMPANY_NAME}}',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_key` (`template_key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `notification_templates` (5 rows)
INSERT INTO `notification_templates` (`id`, `template_key`, `title`, `channel`, `subject`, `body_content`, `variables`, `is_active`, `updated_at`) VALUES
('1', 'leave_applied', 'Leave Request Submitted', 'all', 'New Leave Request from {{EMPLOYEE_NAME}}', 'Employee {{EMPLOYEE_NAME}} has submitted a leave application for {{DETAILS}} on {{ACTION_DATE}}. Please review in Manager Portal.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{ACTION_DATE}}, {{COMPANY_NAME}}', '1', '2026-09-26 12:18:59'),
('2', 'overtime_approved', 'Overtime Approved', 'all', 'Overtime Hours Confirmed', 'Dear {{EMPLOYEE_NAME}}, your overtime claim for {{DETAILS}} has been approved and logged for payroll inclusion.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', '1', '2026-09-26 12:18:59'),
('3', 'loan_disbursed', 'Loan Disbursement Notice', 'all', 'Salary Advance / Loan Disbursed', 'Dear {{EMPLOYEE_NAME}}, your loan application of {{DETAILS}} has been approved and scheduled for payroll deduction.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', '1', '2026-09-26 12:18:59'),
('4', 'payroll_ready', 'Monthly Payslip Generated', 'all', 'Your Payslip is Ready for {{DETAILS}}', 'Dear {{EMPLOYEE_NAME}}, your payslip for {{DETAILS}} is now ready. Log in to your portal to inspect details and download PDF.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', '1', '2026-09-26 12:18:59'),
('5', 'appraisal_assigned', 'Performance Appraisal Initiated', 'in_app', 'Self-Appraisal Form Available', 'Dear {{EMPLOYEE_NAME}}, the performance appraisal cycle {{DETAILS}} is now active. Please complete your self-evaluation.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', '1', '2026-09-26 12:18:59');

-- -----------------------------------------------------
-- Table structure for `overtime_requests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `overtime_requests`;
CREATE TABLE `overtime_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `overtime_rule_id` int unsigned DEFAULT NULL,
  `request_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_hours` decimal(5,2) NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','manager_approved','hr_approved','rejected','payroll_processed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `manager_id` int unsigned DEFAULT NULL,
  `manager_action_at` datetime DEFAULT NULL,
  `manager_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_id` int unsigned DEFAULT NULL,
  `hr_action_at` datetime DEFAULT NULL,
  `hr_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hourly_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payout_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payroll_run_id` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_ot_emp_date` (`employee_id`,`request_date`),
  KEY `fk_ot_rule` (`overtime_rule_id`),
  KEY `fk_ot_manager` (`manager_id`),
  KEY `fk_ot_hr` (`hr_id`),
  KEY `fk_ot_run` (`payroll_run_id`),
  CONSTRAINT `fk_ot_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ot_hr` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_ot_manager` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_ot_rule` FOREIGN KEY (`overtime_rule_id`) REFERENCES `overtime_rules` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_ot_run` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `overtime_requests` (4 rows)
INSERT INTO `overtime_requests` (`id`, `employee_id`, `overtime_rule_id`, `request_date`, `start_time`, `end_time`, `total_hours`, `reason`, `status`, `manager_id`, `manager_action_at`, `manager_remarks`, `hr_id`, `hr_action_at`, `hr_remarks`, `hourly_rate`, `payout_amount`, `payroll_run_id`, `created_at`, `updated_at`) VALUES
('1', '1', '1', '2026-09-29', '18:30:00', '21:30:00', '3.00', 'extra task', 'rejected', '1', '2026-09-29 07:15:30', 'Rejected by manager', NULL, NULL, NULL, '0.00', '0.00', NULL, '2026-09-29 07:15:09', '2026-09-29 07:15:30'),
('2', '7', '1', '2026-09-29', '18:30:00', '21:30:00', '3.00', 'extra task', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', NULL, '2026-09-29 07:16:20', '2026-09-29 07:16:20'),
('3', '13', '1', '2026-09-29', '18:30:00', '21:30:00', '3.00', 'extra task', 'payroll_processed', '2', '2026-09-29 07:18:57', 'Approved', NULL, NULL, NULL, '252.41', '757.23', '11', '2026-09-29 07:18:43', '2026-09-29 13:06:44'),
('4', '18', '1', '2026-09-29', '18:30:00', '21:30:00', '3.00', 'overtime', 'hr_approved', '1', '2026-09-29 10:11:03', 'Approved', NULL, NULL, NULL, '252.41', '757.23', NULL, '2026-09-29 10:10:33', '2026-09-29 10:11:03');

-- -----------------------------------------------------
-- Table structure for `overtime_rules`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `overtime_rules`;
CREATE TABLE `overtime_rules` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rule_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_multiplier` decimal(4,2) NOT NULL DEFAULT '1.50' COMMENT '1.5x on normal, 2.0x on holiday',
  `applicable_days` enum('all','workday','weekend','holiday') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `min_hours` decimal(4,2) NOT NULL DEFAULT '1.00',
  `max_hours_per_day` decimal(4,2) NOT NULL DEFAULT '4.00',
  `monthly_cap_hours` decimal(5,2) NOT NULL DEFAULT '40.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rule_code` (`rule_code`),
  KEY `fk_otr_company` (`company_id`),
  CONSTRAINT `fk_otr_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `overtime_rules` (2 rows)
INSERT INTO `overtime_rules` (`id`, `company_id`, `name`, `rule_code`, `rate_multiplier`, `applicable_days`, `min_hours`, `max_hours_per_day`, `monthly_cap_hours`, `is_active`, `created_at`, `updated_at`) VALUES
('1', '1', 'Standard Workday Overtime (1.5x)', 'OT-NORM-1.5', '1.50', 'workday', '1.00', '4.00', '40.00', '1', '2026-09-26 12:18:59', '2026-09-26 15:13:54'),
('2', '1', 'Weekend & Holiday Overtime (2.0x)', 'OT-HOL-2.0', '2.00', 'holiday', '2.00', '8.00', '50.00', '1', '2026-09-26 12:18:59', '2026-09-26 15:13:54');

-- -----------------------------------------------------
-- Table structure for `pay_grades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pay_grades`;
CREATE TABLE `pay_grades` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `grade_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_salary` decimal(12,2) DEFAULT '0.00',
  `max_salary` decimal(12,2) DEFAULT '0.00',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `grade_code` (`grade_code`),
  KEY `fk_pg_company` (`company_id`),
  CONSTRAINT `fk_pg_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `pay_grades` (5 rows)
INSERT INTO `pay_grades` (`id`, `company_id`, `grade_name`, `grade_code`, `min_salary`, `max_salary`, `description`, `created_at`, `updated_at`) VALUES
('1', '1', 'Executive Band 1 (C-Suite / VP)', 'BAND-EX-01', '160000.00', '260000.00', 'Executive leadership and strategic decision makers', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('2', '1', 'Senior Management Band 2', 'BAND-MG-02', '110000.00', '160000.00', 'Department heads, directors, and principal leads', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('3', '1', 'Professional / Senior Band 3', 'BAND-PR-03', '75000.00', '110000.00', 'Senior engineers, HR business partners, senior analysts', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('4', '1', 'Associate / Entry Band 4', 'BAND-AS-04', '45000.00', '75000.00', 'Junior associates, coordinators, and operational staff', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('5', '1', 'Junior / Trainee Band 5', 'BAND-TR-05', '0.00', '45000.00', 'Trainees, interns, apprentices, and foundational support staff', '2026-09-28 17:49:05', '2026-09-28 17:49:05');

-- -----------------------------------------------------
-- Table structure for `payroll_items`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `payroll_items`;
CREATE TABLE `payroll_items` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `payroll_run_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `payslip_number` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_days` decimal(4,1) DEFAULT '0.0',
  `unpaid_leave_days` decimal(4,1) DEFAULT '0.0',
  `overtime_hours` decimal(5,2) DEFAULT '0.00',
  `basic_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `hra` decimal(12,2) DEFAULT '0.00',
  `conveyance` decimal(12,2) DEFAULT '0.00',
  `special_allowance` decimal(12,2) DEFAULT '0.00',
  `medical_allowance` decimal(12,2) DEFAULT '0.00',
  `overtime_amount` decimal(12,2) DEFAULT '0.00',
  `bonus_incentive` decimal(12,2) DEFAULT '0.00',
  `reimbursement_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `gross_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pf_deduction` decimal(12,2) DEFAULT '0.00',
  `tax_deduction` decimal(12,2) DEFAULT '0.00',
  `insurance_deduction` decimal(12,2) DEFAULT '0.00',
  `loan_emi_deduction` decimal(12,2) DEFAULT '0.00',
  `loan_deduction` decimal(12,2) NOT NULL DEFAULT '0.00',
  `unpaid_cut` decimal(12,2) DEFAULT '0.00',
  `total_deductions` decimal(12,2) NOT NULL DEFAULT '0.00',
  `net_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('unpaid','pending','paid') COLLATE utf8mb4_unicode_ci DEFAULT 'unpaid',
  `payment_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payslip_number` (`payslip_number`),
  KEY `fk_pi_run` (`payroll_run_id`),
  KEY `fk_pi_emp` (`employee_id`),
  CONSTRAINT `fk_pi_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pi_run` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `payroll_items` (21 rows)
INSERT INTO `payroll_items` (`id`, `payroll_run_id`, `employee_id`, `payslip_number`, `present_days`, `unpaid_leave_days`, `overtime_hours`, `basic_salary`, `hra`, `conveyance`, `special_allowance`, `medical_allowance`, `overtime_amount`, `bonus_incentive`, `reimbursement_amount`, `gross_salary`, `pf_deduction`, `tax_deduction`, `insurance_deduction`, `loan_emi_deduction`, `loan_deduction`, `unpaid_cut`, `total_deductions`, `net_salary`, `payment_status`, `payment_date`, `created_at`, `updated_at`) VALUES
('100', '11', '1', 'PAY-202609-EMP0001', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 13:06:43', '2026-09-29 13:06:43'),
('101', '11', '2', 'PAY-202609-EMP0002', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 13:06:43', '2026-09-29 13:06:43'),
('102', '11', '3', 'PAY-202609-EMP0003', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 13:06:43', '2026-09-29 13:06:43'),
('103', '11', '4', 'PAY-202609-EMP0004', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 13:06:43', '2026-09-29 13:06:43'),
('104', '11', '5', 'PAY-202609-EMP0005', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 13:06:43', '2026-09-29 13:06:43'),
('105', '11', '6', 'PAY-202609-EMP0006', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 13:06:44', '2026-09-29 13:06:44'),
('106', '11', '7', 'PAY-202609-EMP0007', '22.0', '0.0', '0.00', '35000.00', '14000.00', '1600.00', '3500.00', '1250.00', '0.00', '0.00', '190.00', '55350.00', '4200.00', '3500.00', '120.00', '0.00', '0.00', '0.00', '7820.00', '47720.00', 'paid', '2026-09-29', '2026-09-29 13:06:44', '2026-09-29 13:06:44'),
('107', '11', '13', 'PAY-202609-EMP0012', '22.0', '0.0', '3.00', '35000.00', '14000.00', '1600.00', '3500.00', '1250.00', '757.23', '0.00', '0.00', '56107.23', '4200.00', '3500.00', '120.00', '0.00', '0.00', '0.00', '7820.00', '48287.23', 'paid', '2026-09-29', '2026-09-29 13:06:44', '2026-09-29 13:06:44'),
('108', '11', '15', 'PAY-202609-EMP0014', '22.0', '0.0', '0.00', '35000.00', '14000.00', '1600.00', '3500.00', '1250.00', '0.00', '0.00', '0.00', '55350.00', '4200.00', '3500.00', '120.00', '0.00', '0.00', '0.00', '7820.00', '47530.00', 'paid', '2026-09-29', '2026-09-29 13:06:44', '2026-09-29 13:06:44'),
('109', '11', '16', 'PAY-202609-EMP0015', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 13:06:44', '2026-09-29 13:06:44'),
('110', '12', '1', 'PAY-202611-EMP0001', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('111', '12', '2', 'PAY-202611-EMP0002', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('112', '12', '3', 'PAY-202611-EMP0003', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('113', '12', '4', 'PAY-202611-EMP0004', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('114', '12', '5', 'PAY-202611-EMP0005', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('115', '12', '6', 'PAY-202611-EMP0006', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('116', '12', '7', 'PAY-202611-EMP0007', '22.0', '0.0', '0.00', '35000.00', '14000.00', '1600.00', '3500.00', '1250.00', '0.00', '0.00', '0.00', '55350.00', '4200.00', '3500.00', '120.00', '0.00', '0.00', '0.00', '7820.00', '47530.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('117', '12', '13', 'PAY-202611-EMP0012', '22.0', '0.0', '0.00', '35000.00', '14000.00', '1600.00', '3500.00', '1250.00', '0.00', '0.00', '0.00', '55350.00', '4200.00', '3500.00', '120.00', '0.00', '0.00', '0.00', '7820.00', '47530.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('118', '12', '15', 'PAY-202611-EMP0014', '22.0', '0.0', '0.00', '35000.00', '14000.00', '1600.00', '3500.00', '1250.00', '0.00', '0.00', '0.00', '55350.00', '4200.00', '3500.00', '120.00', '0.00', '0.00', '0.00', '7820.00', '47530.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('119', '12', '16', 'PAY-202611-EMP0015', '22.0', '0.0', '0.00', '5000.00', '2000.00', '500.00', '1000.00', '300.00', '0.00', '0.00', '0.00', '8800.00', '600.00', '500.00', '120.00', '0.00', '0.00', '0.00', '1220.00', '7580.00', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09'),
('120', '12', '17', 'PAY-202611-EMP0016', '22.0', '0.0', '0.00', '15000.00', '6000.00', '1600.00', '1500.00', '1250.00', '0.00', '0.00', '0.00', '25350.00', '1800.00', '1500.00', '120.00', '33333.33', '0.00', '0.00', '36753.33', '-11403.33', 'paid', '2026-09-29', '2026-09-29 14:21:09', '2026-09-29 14:21:09');

-- -----------------------------------------------------
-- Table structure for `payroll_runs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `payroll_runs`;
CREATE TABLE `payroll_runs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `financial_year_id` int unsigned NOT NULL,
  `month` tinyint NOT NULL,
  `year` int NOT NULL,
  `title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','processed','approved','paid','frozen') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `processed_by` int unsigned DEFAULT NULL,
  `processed_at` datetime DEFAULT NULL,
  `total_employees` int DEFAULT '0',
  `total_gross` decimal(14,2) DEFAULT '0.00',
  `total_deductions` decimal(14,2) DEFAULT '0.00',
  `total_net` decimal(14,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_comp_mo_yr` (`company_id`,`month`,`year`),
  KEY `fk_pr_fy` (`financial_year_id`),
  CONSTRAINT `fk_pr_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pr_fy` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `payroll_runs` (2 rows)
INSERT INTO `payroll_runs` (`id`, `company_id`, `financial_year_id`, `month`, `year`, `title`, `status`, `processed_by`, `processed_at`, `total_employees`, `total_gross`, `total_deductions`, `total_net`, `created_at`, `updated_at`) VALUES
('11', '1', '1', '9', '2026', 'Payroll Run - September 2026', 'processed', '1', '2026-09-29 07:36:43', '10', '228407.23', '32000.00', '196597.23', '2026-09-29 07:36:43', '2026-09-29 07:36:44'),
('12', '1', '1', '11', '2026', 'Payroll Run - November 2026', 'processed', '1', '2026-09-29 08:51:09', '11', '253000.00', '68753.33', '184246.67', '2026-09-29 08:51:09', '2026-09-29 08:51:09');

-- -----------------------------------------------------
-- Table structure for `performance_cycles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `performance_cycles`;
CREATE TABLE `performance_cycles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cycle_type` enum('quarterly','half_yearly','annual') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'annual',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `self_review_deadline` date NOT NULL,
  `manager_review_deadline` date NOT NULL,
  `status` enum('upcoming','active','evaluation','closed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pcyc_company` (`company_id`),
  CONSTRAINT `fk_pcyc_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `performance_cycles` (2 rows)
INSERT INTO `performance_cycles` (`id`, `company_id`, `title`, `cycle_type`, `start_date`, `end_date`, `self_review_deadline`, `manager_review_deadline`, `status`, `description`, `created_at`, `updated_at`) VALUES
('1', '1', 'Annual Appraisal Cycle 2026-2027', 'annual', '2026-04-01', '2027-03-31', '2027-03-15', '2027-03-25', 'active', 'Corporate Annual Performance Review, OKR Evaluation & Merit Appraisal Cycle 2026-27', '2026-09-29 10:18:43', '2026-09-29 10:18:43'),
('2', '1', 'H1 Mid-Year Appraisal 2026', 'half_yearly', '2026-04-01', '2026-09-30', '2026-09-20', '2026-09-30', '', 'Mid-Year OKR Assessment & Interim Developmental Review', '2026-09-29 10:18:43', '2026-09-29 10:18:43');

-- -----------------------------------------------------
-- Table structure for `performance_goals`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `performance_goals`;
CREATE TABLE `performance_goals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `cycle_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `weightage_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `target_metric` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `self_rating` decimal(3,2) DEFAULT NULL COMMENT 'Scale 1.0 to 5.0',
  `self_comments` text COLLATE utf8mb4_unicode_ci,
  `manager_rating` decimal(3,2) DEFAULT NULL COMMENT 'Scale 1.0 to 5.0',
  `manager_comments` text COLLATE utf8mb4_unicode_ci,
  `status` enum('draft','submitted','reviewed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pgoal_cycle` (`cycle_id`),
  KEY `fk_pgoal_emp` (`employee_id`),
  CONSTRAINT `fk_pgoal_cycle` FOREIGN KEY (`cycle_id`) REFERENCES `performance_cycles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pgoal_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `performance_goals` (2 rows)
INSERT INTO `performance_goals` (`id`, `cycle_id`, `employee_id`, `title`, `description`, `weightage_percent`, `target_metric`, `self_rating`, `self_comments`, `manager_rating`, `manager_comments`, `status`, `created_at`, `updated_at`) VALUES
('9', '1', '1', 'Achivement', '', '25.00', '90', NULL, NULL, NULL, NULL, 'draft', '2026-09-29 10:18:46', '2026-09-29 10:18:46'),
('11', '2', '7', 'project ', '', '25.00', '1000', '4.00', '', NULL, NULL, '', '2026-09-29 10:50:01', '2026-09-29 10:51:28');

-- -----------------------------------------------------
-- Table structure for `permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `permissions` (18 rows)
INSERT INTO `permissions` (`id`, `module`, `name`, `slug`, `description`, `created_at`) VALUES
('1', 'users', 'Manage Users', 'users.manage', 'Create, update, and manage system user accounts', '2026-09-25 12:26:51'),
('2', 'roles', 'Manage Roles & RBAC', 'roles.manage', 'Assign and configure roles and permissions', '2026-09-25 12:26:51'),
('3', 'company', 'Manage Organization', 'company.manage', 'Manage companies, branches, and fiscal years', '2026-09-25 12:26:51'),
('4', 'department', 'Manage Departments', 'department.manage', 'Create and modify departments', '2026-09-25 12:26:51'),
('5', 'designation', 'Manage Designations', 'designation.manage', 'Create and modify designations and pay grades', '2026-09-25 12:26:51'),
('6', 'employee', 'View Employees', 'employee.view', 'View employee directory and profiles', '2026-09-25 12:26:51'),
('7', 'employee', 'Create Employee', 'employee.create', 'Add new employees into the system', '2026-09-25 12:26:51'),
('8', 'employee', 'Edit Employee', 'employee.edit', 'Update employee records, bank details, and documents', '2026-09-25 12:26:51'),
('9', 'employee', 'Delete Employee', 'employee.delete', 'Archive or delete employee records', '2026-09-25 12:26:51'),
('10', 'attendance', 'View Attendance', 'attendance.view', 'Inspect daily and monthly attendance logs', '2026-09-25 12:26:51'),
('11', 'attendance', 'Manage Attendance', 'attendance.manage', 'Perform attendance corrections and manual adjustments', '2026-09-25 12:26:51'),
('12', 'leave', 'Apply Leave', 'leave.apply', 'Submit leave requests through self service', '2026-09-25 12:26:51'),
('13', 'leave', 'Approve Leave', 'leave.approve', 'Manager and HR approval workflows for leaves', '2026-09-25 12:26:51'),
('14', 'payroll', 'View Payroll', 'payroll.view', 'View payroll runs and employee payslips', '2026-09-25 12:26:51'),
('15', 'payroll', 'Process Payroll', 'payroll.process', 'Execute monthly payroll calculations and lock runs', '2026-09-25 12:26:51'),
('16', 'reports', 'View Reports', 'reports.view', 'Access executive dashboards and analytics reports', '2026-09-25 12:26:51'),
('17', 'audit', 'View Audit Logs', 'audit.view', 'Inspect non-editable activity logs and security events', '2026-09-25 12:26:51'),
('18', 'settings', 'Manage Settings', 'settings.manage', 'Configure application parameters and policies', '2026-09-25 12:26:51');

-- -----------------------------------------------------
-- Table structure for `policy_acknowledgements`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `policy_acknowledgements`;
CREATE TABLE `policy_acknowledgements` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `policy_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `acknowledged_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_pol_emp` (`policy_id`,`employee_id`),
  KEY `fk_pack_emp` (`employee_id`),
  CONSTRAINT `fk_pack_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pack_policy` FOREIGN KEY (`policy_id`) REFERENCES `company_policies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `policy_acknowledgements` (1 rows)
INSERT INTO `policy_acknowledgements` (`id`, `policy_id`, `employee_id`, `acknowledged_at`, `ip_address`, `user_agent`, `updated_at`, `created_at`) VALUES
('2', '1', '1', '2026-09-28 12:42:48', '127.0.0.1', '', '2026-09-28 18:12:48', '2026-09-28 18:12:48');

-- -----------------------------------------------------
-- Table structure for `probation_assessments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `probation_assessments`;
CREATE TABLE `probation_assessments` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `joining_date` date NOT NULL,
  `initial_probation_end_date` date NOT NULL,
  `current_probation_end_date` date NOT NULL,
  `assessment_status` enum('due','under_review','confirmed','extended','terminated') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'due',
  `manager_id` int unsigned DEFAULT NULL,
  `manager_rating` tinyint unsigned DEFAULT NULL COMMENT '1 to 5',
  `technical_competence_rating` tinyint unsigned DEFAULT NULL,
  `punctuality_attendance_rating` tinyint unsigned DEFAULT NULL,
  `teamwork_culture_rating` tinyint unsigned DEFAULT NULL,
  `manager_feedback` text COLLATE utf8mb4_unicode_ci,
  `manager_recommendation` enum('confirm','extend_probation','terminate') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_submitted_at` datetime DEFAULT NULL,
  `extension_months` int unsigned DEFAULT '0',
  `extended_until` date DEFAULT NULL,
  `extension_reason` text COLLATE utf8mb4_unicode_ci,
  `confirmation_date` date DEFAULT NULL,
  `hr_id` int unsigned DEFAULT NULL,
  `hr_decision` enum('confirmed','extended','terminated') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hr_remarks` text COLLATE utf8mb4_unicode_ci,
  `hr_action_at` datetime DEFAULT NULL,
  `letter_generated` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_pa_emp` (`employee_id`),
  KEY `fk_pa_mgr` (`manager_id`),
  KEY `fk_pa_hr` (`hr_id`),
  CONSTRAINT `fk_pa_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pa_hr` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_pa_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `probation_assessments` (6 rows)
INSERT INTO `probation_assessments` (`id`, `employee_id`, `joining_date`, `initial_probation_end_date`, `current_probation_end_date`, `assessment_status`, `manager_id`, `manager_rating`, `technical_competence_rating`, `punctuality_attendance_rating`, `teamwork_culture_rating`, `manager_feedback`, `manager_recommendation`, `manager_submitted_at`, `extension_months`, `extended_until`, `extension_reason`, `confirmation_date`, `hr_id`, `hr_decision`, `hr_remarks`, `hr_action_at`, `letter_generated`, `created_at`, `updated_at`) VALUES
('1', '15', '2026-07-06', '2026-10-04', '2027-01-04', 'confirmed', '1', '4', '4', '4', '4', 'ok', 'confirm', '2026-09-29 07:05:37', '3', '2027-01-04', 'not justified', '2026-09-29', '1', 'confirmed', 'Confirmed upon satisfactory completion of probation period.', '2026-09-29 07:05:48', '1', '2026-09-29 07:00:24', '2026-09-29 07:05:48'),
('2', '13', '2026-08-30', '2026-11-28', '2026-11-28', 'confirmed', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, '2026-09-29', '1', 'confirmed', 'ok', '2026-09-29 07:05:26', '1', '2026-09-29 07:00:24', '2026-09-29 07:05:26'),
('3', '16', '2026-06-21', '2026-09-19', '2026-09-19', 'confirmed', '1', '5', '5', '4', '5', 'Outstanding performance throughout the 90-day evaluation period.', 'confirm', '2026-09-17 07:00:24', '0', NULL, NULL, '2026-09-19', '1', 'confirmed', 'Formally confirmed with standard benefits package.', '2026-09-19 07:00:24', '1', '2026-09-29 07:00:24', '2026-09-29 07:00:24'),
('4', '7', '2026-07-01', '2026-09-29', '2026-11-13', 'confirmed', '6', '3', '3', '2', '3', 'Requires improvement in punctuality and sprint deliverable turnaround.', 'extend_probation', '2026-09-26 07:00:24', '2', '2026-11-13', 'Punctuality criteria and project delivery milestone evaluation', '2026-09-29', '1', 'confirmed', 'Confirmed upon satisfactory completion of probation period.', '2026-09-29 07:05:53', '1', '2026-09-29 07:00:24', '2026-09-29 07:05:53'),
('5', '18', '2026-09-29', '2026-12-29', '2026-12-29', 'confirmed', '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, '2026-09-29', '1', 'confirmed', 'Confirmed upon satisfactory completion of probation period.', '2026-09-29 10:27:03', '1', '2026-09-29 10:24:28', '2026-09-29 10:27:03'),
('6', '20', '2026-09-29', '2026-12-29', '2026-12-29', 'under_review', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', '2026-09-29 11:32:08', '2026-09-29 11:32:08');

-- -----------------------------------------------------
-- Table structure for `reimbursement_requests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `reimbursement_requests`;
CREATE TABLE `reimbursement_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `claim_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `expense_category_id` int unsigned NOT NULL,
  `claim_title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expense_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `approved_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('submitted','manager_approved','finance_approved','rejected','payroll_processed','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `manager_id` int unsigned DEFAULT NULL,
  `manager_action_at` datetime DEFAULT NULL,
  `manager_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finance_approver_id` int unsigned DEFAULT NULL,
  `finance_action_at` datetime DEFAULT NULL,
  `finance_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payroll_run_id` int unsigned DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `claim_number` (`claim_number`),
  KEY `idx_reimb_emp` (`employee_id`,`status`),
  KEY `fk_reimb_cat` (`expense_category_id`),
  KEY `fk_reimb_manager` (`manager_id`),
  KEY `fk_reimb_finance` (`finance_approver_id`),
  KEY `fk_reimb_payroll` (`payroll_run_id`),
  CONSTRAINT `fk_reimb_cat` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_reimb_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reimb_finance` FOREIGN KEY (`finance_approver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_reimb_manager` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_reimb_payroll` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `reimbursement_requests` (5 rows)
INSERT INTO `reimbursement_requests` (`id`, `claim_number`, `employee_id`, `expense_category_id`, `claim_title`, `expense_date`, `amount`, `approved_amount`, `description`, `receipt_path`, `status`, `manager_id`, `manager_action_at`, `manager_remarks`, `finance_approver_id`, `finance_action_at`, `finance_remarks`, `payroll_run_id`, `paid_date`, `created_at`, `updated_at`) VALUES
('1', 'CLM-20260928-27E8', '7', '2', 'Tra All', '2026-09-28', '120.00', '120.00', 'Travelling allowance', NULL, 'payroll_processed', NULL, NULL, NULL, '4', '2026-09-28 12:36:45', 'Finance Verified', NULL, '2026-09-28', '2026-09-28 12:31:27', '2026-09-28 18:12:16'),
('2', 'CLM-20260928-DF9C', '4', '3', 'recharge', '2026-09-28', '349.00', '349.00', 'recharge', NULL, 'payroll_processed', NULL, NULL, NULL, '4', '2026-09-28 12:40:02', 'Finance Verified', NULL, '2026-09-28', '2026-09-28 12:39:57', '2026-09-28 18:12:16'),
('3', 'CLM-20260928-B50B', '4', '3', 'recharge', '2026-09-28', '349.00', '349.00', 'Mobile recharge', NULL, 'payroll_processed', NULL, NULL, NULL, '4', '2026-09-28 13:02:01', 'Finance Verified', NULL, '2026-09-29', '2026-09-28 13:01:58', '2026-09-29 11:18:49'),
('4', 'CLM-20260928-1F8D', '3', '3', 'recharge', '2026-09-28', '100.00', '100.00', 'Recharge', NULL, 'rejected', '5', '2026-09-28 13:04:33', 'Claim rejected', NULL, NULL, NULL, NULL, NULL, '2026-09-28 13:03:48', '2026-09-28 13:04:33'),
('5', 'CLM-20260929-9BD3', '7', '1', 'recharge', '2026-09-29', '190.00', '190.00', 'recharge', NULL, 'payroll_processed', NULL, NULL, NULL, '1', '2026-09-29 07:25:28', 'Finance Verified', '11', '2026-09-29', '2026-09-29 07:25:14', '2026-09-29 13:06:44');

-- -----------------------------------------------------
-- Table structure for `resignations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `resignations`;
CREATE TABLE `resignations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `resignation_date` date NOT NULL,
  `requested_last_working_day` date NOT NULL,
  `approved_last_working_day` date DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('submitted','manager_approved','hr_approved','in_clearance','settled','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `approver_remarks` text COLLATE utf8mb4_unicode_ci,
  `notice_period_shortfall_days` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_resig_emp` (`employee_id`),
  CONSTRAINT `fk_resig_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `resignations` (2 rows)
INSERT INTO `resignations` (`id`, `employee_id`, `resignation_date`, `requested_last_working_day`, `approved_last_working_day`, `reason`, `status`, `approver_remarks`, `notice_period_shortfall_days`, `created_at`, `updated_at`) VALUES
('1', '13', '2026-09-29', '2026-10-29', '2026-09-29', 'better oppurtunuty', 'settled', 'ok', '0', '2026-09-29 12:23:31', '2026-09-29 12:24:03'),
('2', '13', '2026-09-29', '2026-10-29', '2026-09-02', 'personal reason', 'settled', '', '0', '2026-09-29 12:23:35', '2026-09-29 12:24:23');

-- -----------------------------------------------------
-- Table structure for `role_permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `role_id` int unsigned NOT NULL,
  `permission_id` int unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `fk_rp_perm` (`permission_id`),
  CONSTRAINT `fk_rp_perm` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_rp_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `role_permissions` (62 rows)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
('1', '1'),
('2', '1'),
('1', '2'),
('1', '3'),
('2', '3'),
('1', '4'),
('2', '4'),
('1', '5'),
('2', '5'),
('1', '6'),
('2', '6'),
('3', '6'),
('4', '6'),
('5', '6'),
('6', '6'),
('7', '6'),
('1', '7'),
('2', '7'),
('3', '7'),
('1', '8'),
('2', '8'),
('3', '8'),
('1', '9'),
('2', '9'),
('1', '10'),
('2', '10'),
('3', '10'),
('4', '10'),
('5', '10'),
('6', '10'),
('7', '10'),
('1', '11'),
('2', '11'),
('3', '11'),
('6', '11'),
('1', '12'),
('2', '12'),
('3', '12'),
('4', '12'),
('5', '12'),
('6', '12'),
('7', '12'),
('1', '13'),
('2', '13'),
('6', '13'),
('1', '14'),
('2', '14'),
('4', '14'),
('5', '14'),
('7', '14'),
('1', '15'),
('2', '15'),
('4', '15'),
('1', '16'),
('2', '16'),
('3', '16'),
('4', '16'),
('5', '16'),
('6', '16'),
('1', '17'),
('2', '17'),
('1', '18');

-- -----------------------------------------------------
-- Table structure for `roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hierarchy_level` tinyint unsigned NOT NULL DEFAULT '7',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `roles` (7 rows)
INSERT INTO `roles` (`id`, `name`, `slug`, `hierarchy_level`, `description`, `is_system`, `created_at`, `updated_at`) VALUES
('1', 'Super Admin', 'super_admin', '1', 'Global system administrative access with full control over all modules and tenant settings.', '1', '2026-09-25 12:26:51', '2026-09-28 18:28:10'),
('2', 'HR Admin', 'hr_admin', '2', 'Full Human Resources management access across employees, departments, onboarding, and policies.', '1', '2026-09-25 12:26:51', '2026-09-28 18:28:10'),
('3', 'HR Executive', 'hr_executive', '3', 'Operational HR staff handling daily records, attendance adjustments, and employee documents.', '1', '2026-09-25 12:26:51', '2026-09-28 18:28:10'),
('4', 'Payroll Manager', 'payroll_manager', '4', 'Responsible for payroll calculation, salary structures, tax deductions, and disbursement approval.', '1', '2026-09-25 12:26:51', '2026-09-28 18:28:10'),
('5', 'Accountant', 'accountant', '5', 'Financial auditor and accounting access for payslips, reimbursements, loans, and statutory exports.', '1', '2026-09-25 12:26:51', '2026-09-28 18:28:10'),
('6', 'Manager / Department Head', 'manager', '6', 'Head of department or team lead with manager self-service, approval queues for leave and attendance.', '1', '2026-09-25 12:26:51', '2026-09-28 18:28:10'),
('7', 'Employee', 'employee', '7', 'Individual employee self-service (ESS) portal access for attendance, leave requests, and payslips.', '1', '2026-09-25 12:26:51', '2026-09-25 12:26:51');

-- -----------------------------------------------------
-- Table structure for `salary_structures`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `salary_structures`;
CREATE TABLE `salary_structures` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `effective_date` date NOT NULL,
  `basic_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `hra` decimal(12,2) DEFAULT '0.00',
  `conveyance_allowance` decimal(12,2) DEFAULT '0.00',
  `special_allowance` decimal(12,2) DEFAULT '0.00',
  `medical_allowance` decimal(12,2) DEFAULT '0.00',
  `other_allowances` decimal(12,2) DEFAULT '0.00',
  `gross_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `pf_deduction` decimal(12,2) DEFAULT '0.00',
  `tax_deduction` decimal(12,2) DEFAULT '0.00',
  `insurance_deduction` decimal(12,2) DEFAULT '0.00',
  `total_deductions` decimal(12,2) DEFAULT '0.00',
  `net_salary` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_ss_emp` (`employee_id`),
  CONSTRAINT `fk_ss_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `salary_structures` (2 rows)
INSERT INTO `salary_structures` (`id`, `employee_id`, `effective_date`, `basic_salary`, `hra`, `conveyance_allowance`, `special_allowance`, `medical_allowance`, `other_allowances`, `gross_salary`, `pf_deduction`, `tax_deduction`, `insurance_deduction`, `total_deductions`, `net_salary`, `created_at`, `updated_at`) VALUES
('2', '7', '2024-01-15', '35000.00', '14000.00', '1600.00', '3500.00', '1250.00', '0.00', '55350.00', '4200.00', '3500.00', '120.00', '7820.00', '47530.00', '2026-09-29 11:16:32', '2026-09-29 11:16:32'),
('9', '17', '2026-09-29', '15000.00', '6000.00', '1600.00', '1500.00', '1250.00', '0.00', '25350.00', '1800.00', '1500.00', '120.00', '3420.00', '21930.00', '2026-09-29 14:13:21', '2026-09-29 14:13:21');

-- -----------------------------------------------------
-- Table structure for `shift_allocations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `shift_allocations`;
CREATE TABLE `shift_allocations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned NOT NULL,
  `shift_id` int unsigned NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date DEFAULT NULL,
  `rotation_pattern` enum('fixed','weekly','bi_weekly','monthly') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `assigned_by` int unsigned DEFAULT NULL,
  `status` enum('active','inactive','transferred') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_sa_emp` (`employee_id`),
  KEY `fk_sa_shift` (`shift_id`),
  KEY `fk_sa_assigner` (`assigned_by`),
  CONSTRAINT `fk_sa_assigner` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_sa_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sa_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `shift_allocations` (1 rows)
INSERT INTO `shift_allocations` (`id`, `employee_id`, `shift_id`, `from_date`, `to_date`, `rotation_pattern`, `assigned_by`, `status`, `notes`, `created_at`, `updated_at`) VALUES
('2', '13', '6', '2026-09-29', NULL, 'fixed', '1', 'active', NULL, '2026-09-29 07:12:07', '2026-09-29 07:12:07');

-- -----------------------------------------------------
-- Table structure for `shifts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `shifts`;
CREATE TABLE `shifts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_type` enum('regular','rotational','split','night','flexible') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regular',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `break_duration_mins` int unsigned NOT NULL DEFAULT '60',
  `half_day_hours` decimal(4,2) NOT NULL DEFAULT '4.50',
  `full_day_hours` decimal(4,2) NOT NULL DEFAULT '8.00',
  `overtime_eligible` tinyint(1) NOT NULL DEFAULT '1',
  `min_overtime_mins` int unsigned NOT NULL DEFAULT '30',
  `late_grace_mins` int DEFAULT '15',
  `early_exit_grace_mins` int DEFAULT '15',
  `is_night_shift` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_shift_company` (`company_id`),
  CONSTRAINT `fk_shift_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `shifts` (4 rows)
INSERT INTO `shifts` (`id`, `company_id`, `name`, `code`, `shift_type`, `start_time`, `end_time`, `break_duration_mins`, `half_day_hours`, `full_day_hours`, `overtime_eligible`, `min_overtime_mins`, `late_grace_mins`, `early_exit_grace_mins`, `is_night_shift`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', 'General Day Shift (9 AM - 6 PM)', 'SH-GEN', 'regular', '09:00:00', '18:00:00', '60', '4.50', '8.00', '1', '30', '15', '15', '0', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('2', '1', 'Morning Shift (7 AM - 4 PM)', 'SH-MORN', 'regular', '07:00:00', '16:00:00', '60', '4.50', '8.00', '1', '30', '15', '15', '0', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('3', '1', 'Evening Tech Support (2 PM - 11 PM)', 'SH-EVE', 'regular', '14:00:00', '23:00:00', '60', '4.50', '8.00', '1', '30', '15', '15', '0', 'active', '2026-09-25 12:26:51', '2026-09-25 12:26:51'),
('6', '1', 'Night Shift(9 PM - 06 AM)', 'SH-NGH', 'night', '21:00:00', '06:00:00', '60', '4.50', '8.00', '0', '30', '15', '15', '1', 'active', '2026-09-28 12:23:17', '2026-09-28 12:30:02');

-- -----------------------------------------------------
-- Table structure for `system_notifications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `system_notifications`;
CREATE TABLE `system_notifications` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned DEFAULT NULL,
  `employee_id` int unsigned DEFAULT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` enum('in_app','email','sms','whatsapp') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_app',
  `action_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` datetime DEFAULT NULL,
  `status` enum('queued','sent','delivered','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_sysnotif_user` (`user_id`,`is_read`),
  KEY `idx_sysnotif_emp` (`employee_id`,`is_read`),
  CONSTRAINT `fk_sysnotif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `system_notifications` (36 rows)
INSERT INTO `system_notifications` (`id`, `user_id`, `employee_id`, `title`, `message`, `channel`, `action_url`, `is_read`, `read_at`, `status`, `created_at`, `updated_at`) VALUES
('2', '1', '1', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '1', '2026-09-29 10:41:05', 'sent', '2026-09-29 09:51:15', '2026-09-29 16:11:05'),
('3', '2', '2', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('4', '3', '3', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('5', '4', '4', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('6', '5', '5', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('7', '6', '6', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('8', '7', '7', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 09:51:15', '2026-09-29 16:25:17'),
('9', '13', '13', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('10', '15', '15', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('11', '16', '16', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 09:51:15', '2026-09-29 09:51:15'),
('12', '17', '17', '📢 Announcement: leave for today', 'leave for today for the earth quake', 'in_app', NULL, '1', '2026-09-29 09:54:48', 'sent', '2026-09-29 09:51:15', '2026-09-29 15:24:48'),
('13', '18', '18', 'New Leave Request from Sample Demo 2', 'Employee Sample Demo 2 has submitted a leave application for 0.5 day(s) from 2026-09-30 to 2026-09-30 on September 29, 2026. Please review in Manager Portal.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:02:33', '2026-09-29 10:02:33'),
('14', '18', '18', 'New Leave Request from Sample Demo 2', 'Employee Sample Demo 2 has submitted a leave application for 0.5 day(s) from 2026-09-30 to 2026-09-30 on September 29, 2026. Please review in Manager Portal.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:02:35', '2026-09-29 10:02:35'),
('15', '18', '18', 'New Leave Request from Sample Demo 2', 'Employee Sample Demo 2 has submitted a leave application for Leave request #3 (0.5 days) has been APPROVED on September 29, 2026. Please review in Manager Portal.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:03:11', '2026-09-29 10:03:11'),
('16', '19', '19', 'New Leave Request from Priyanshu Paul', 'Employee Priyanshu Paul has submitted a leave application for {{leavee aprove}}  on September 29, 2026. Please review in Manager Portal.', 'in_app', NULL, '1', '2026-09-29 10:09:29', 'sent', '2026-09-29 10:07:38', '2026-09-29 15:39:29'),
('17', '18', '18', 'Overtime Hours Confirmed', 'Dear Sample Demo 2, your overtime claim for 3.00 overtime hours on 2026-09-29 (Payout: ₹757.23) has been approved and logged for payroll inclusion.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:11:03', '2026-09-29 10:11:03'),
('18', '19', '19', 'Self-Appraisal Form Available', 'Dear Priyanshu Paul, the performance appraisal cycle Manager appraisal completed. Rating Band: Outstanding (Grade A) is now active. Please complete your self-evaluation.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:21:19', '2026-09-29 10:21:19'),
('19', '17', '17', 'Self-Appraisal Form Available', 'Dear sample Employee, the performance appraisal cycle Manager appraisal completed. Rating Band: Outstanding (Grade A) is now active. Please complete your self-evaluation.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:25:56', '2026-09-29 10:25:56'),
('20', '1', '1', 'New Leave Request from Demo Super Admin', 'Employee Demo Super Admin has submitted a leave application for New travel request TRV-20260929-F762 for travel on October 2, 2026. Please review in Manager Portal.', 'in_app', NULL, '1', '2026-09-29 10:41:05', 'sent', '2026-09-29 10:30:53', '2026-09-29 16:11:05'),
('21', '1', '1', 'Enterprise HRMS Alert', 'Your travel expense claim #1 () has been approved for ₹5,000.00', 'in_app', NULL, '1', '2026-09-29 10:41:05', 'sent', '2026-09-29 10:31:29', '2026-09-29 16:11:05'),
('22', '1', '1', 'New Leave Request from Demo Super Admin', 'Employee Demo Super Admin has submitted a leave application for New travel request TRV-20260929-4911 for bussiness meeting on October 2, 2026. Please review in Manager Portal.', 'in_app', NULL, '1', '2026-09-29 10:41:05', 'sent', '2026-09-29 10:31:57', '2026-09-29 16:11:05'),
('23', '7', '7', 'New Leave Request from Demo Employee', 'Employee Demo Employee has submitted a leave application for New travel request TRV-20260929-225B for bussiness meeting on October 2, 2026. Please review in Manager Portal.', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:32:40', '2026-09-29 16:25:17'),
('24', '7', '7', 'Enterprise HRMS Alert', 'Your travel request TRV-20260929-225B (bangalore to whitefiled) has been approved with Advance of ₹5,000.00', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:34:32', '2026-09-29 16:25:17'),
('25', '1', '1', 'Enterprise HRMS Alert', 'Your travel request TRV-20260929-4911 (bangalore to whitefiled) has been approved with Advance of ₹5,000.00', 'in_app', NULL, '1', '2026-09-29 10:41:05', 'sent', '2026-09-29 10:34:39', '2026-09-29 16:11:05'),
('26', '1', '1', 'Enterprise HRMS Alert', 'Your travel request TRV-20260929-F762 (mumbai to bengaluru) has been approved with Advance of ₹5,000.00', 'in_app', NULL, '1', '2026-09-29 10:41:05', 'sent', '2026-09-29 10:34:48', '2026-09-29 16:11:05'),
('27', '1', '1', 'Enterprise HRMS Alert', 'Your travel expense claim #2 () has been approved for ₹100,000.00', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:46:05', '2026-09-29 10:46:05'),
('28', '7', '7', 'Enterprise HRMS Alert', 'Your travel expense claim #4 (Flight / Airfare) has been approved for ₹10,000.00', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:46:11', '2026-09-29 16:25:17'),
('29', '7', '7', 'Enterprise HRMS Alert', 'Your travel expense claim #3 (Flight / Airfare) has been approved for ₹10,000.00', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:46:16', '2026-09-29 16:25:17'),
('30', '7', '7', 'New Leave Request from Demo Employee', 'Employee Demo Employee has submitted a leave application for New travel request TRV-20260929-CC52 for office work on October 2, 2026. Please review in Manager Portal.', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:47:44', '2026-09-29 16:25:17'),
('31', '7', '7', 'Enterprise HRMS Alert', 'Your travel request TRV-20260929-CC52 (kolkata to mumbai) has been approved with Advance of ₹15,000.00', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:48:10', '2026-09-29 16:25:17'),
('32', '7', '7', 'Enterprise HRMS Alert', 'Your travel expense claim #5 (Flight / Airfare) has been approved for ₹35,000.00', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:49:22', '2026-09-29 16:25:17'),
('33', '19', '19', 'Self-Appraisal Form Available', 'Dear Priyanshu Paul, the performance appraisal cycle Manager appraisal completed. Rating Band: Outstanding (Grade A) is now active. Please complete your self-evaluation.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:50:18', '2026-09-29 10:50:18'),
('34', '7', '7', 'Self-Appraisal Form Available', 'Dear Demo Employee, the performance appraisal cycle Manager appraisal completed. Rating Band: Outstanding (Grade A) is now active. Please complete your self-evaluation.', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:52:39', '2026-09-29 16:25:17'),
('35', '7', '7', 'Self-Appraisal Form Available', 'Dear Demo Employee, the performance appraisal cycle Manager appraisal completed. Rating Band: Outstanding (Grade A) is now active. Please complete your self-evaluation.', 'in_app', NULL, '1', '2026-09-29 10:55:17', 'sent', '2026-09-29 10:54:20', '2026-09-29 16:25:17'),
('36', '7', '7', 'Self-Appraisal Form Available', 'Dear Demo Employee, the performance appraisal cycle Manager appraisal completed. Rating Band: Outstanding (Grade A) is now active. Please complete your self-evaluation.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 10:57:56', '2026-09-29 10:57:56'),
('37', '2', '2', 'Self-Appraisal Form Available', 'Dear Demo HR Admin, the performance appraisal cycle Enrolled in training: Traning (TRN-2026-B0B5) is now active. Please complete your self-evaluation.', 'in_app', NULL, '0', NULL, 'sent', '2026-09-29 11:28:47', '2026-09-29 11:28:47');

-- -----------------------------------------------------
-- Table structure for `system_settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `key_name` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8mb4_unicode_ci,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `system_settings` (9 rows)
INSERT INTO `system_settings` (`id`, `category`, `key_name`, `key_value`, `description`, `updated_at`) VALUES
('1', 'general', 'app_name', 'Apex HRMS & Payroll Enterprise', 'Full application title displayed in header and reports', '2026-09-25 12:26:51'),
('2', 'general', 'company_name', 'Apex Enterprise Solutions Corp.', 'Default registered enterprise entity', '2026-09-25 12:26:51'),
('3', 'general', 'company_email', 'hr@apexenterprise.com', 'System communication and alert email', '2026-09-25 12:26:51'),
('4', 'general', 'default_currency', 'INR', 'Primary accounting and payroll disbursement currency', '2026-09-26 14:48:06'),
('5', 'general', 'date_format', 'Y-m-d', 'Standard system date formatting', '2026-09-25 12:26:51'),
('6', 'attendance', 'standard_work_hours', '8.0', 'Expected daily working hours per full-time employee', '2026-09-25 12:26:51'),
('7', 'attendance', 'allow_web_clock_in', '1', 'Enables or restricts browser based clock-in/out', '2026-09-25 12:26:51'),
('8', 'security', 'session_timeout_minutes', '120', 'Idle session lifetime before auto logout', '2026-09-25 12:26:51'),
('9', 'security', 'max_login_attempts', '5', 'Rate limiting threshold for user authentication', '2026-09-25 12:26:51');

-- -----------------------------------------------------
-- Table structure for `training_participants`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `training_participants`;
CREATE TABLE `training_participants` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `training_id` int unsigned NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `nominated_by` int unsigned DEFAULT NULL,
  `nomination_status` enum('nominated','approved','attended','absent','dropped') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nominated',
  `attendance_percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `completion_status` enum('in_progress','completed','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_progress',
  `score_rating` decimal(4,2) DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `certificate_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_tp_train_emp` (`training_id`,`employee_id`),
  KEY `fk_tp_emp` (`employee_id`),
  KEY `fk_tp_nominator` (`nominated_by`),
  CONSTRAINT `fk_tp_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tp_nominator` FOREIGN KEY (`nominated_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tp_train` FOREIGN KEY (`training_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `training_participants` (1 rows)
INSERT INTO `training_participants` (`id`, `training_id`, `employee_id`, `nominated_by`, `nomination_status`, `attendance_percent`, `completion_status`, `score_rating`, `feedback`, `certificate_path`, `completed_date`, `created_at`, `updated_at`) VALUES
('1', '1', '2', '7', 'nominated', '0.00', 'in_progress', NULL, NULL, NULL, NULL, '2026-09-29 11:28:47', '2026-09-29 11:28:47');

-- -----------------------------------------------------
-- Table structure for `training_programs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `training_programs`;
CREATE TABLE `training_programs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Technical Skills',
  `trainer_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `training_type` enum('internal','external','online','workshop') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_hours` decimal(5,2) NOT NULL DEFAULT '0.00',
  `max_participants` int unsigned NOT NULL DEFAULT '30',
  `location` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Headquarters Training Room',
  `cost_per_employee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('scheduled','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'scheduled',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_code` (`course_code`),
  KEY `fk_train_company` (`company_id`),
  CONSTRAINT `fk_train_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `training_programs` (1 rows)
INSERT INTO `training_programs` (`id`, `company_id`, `title`, `course_code`, `category`, `trainer_name`, `training_type`, `start_date`, `end_date`, `total_hours`, `max_participants`, `location`, `cost_per_employee`, `description`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', 'Traning', 'TRN-2026-B0B5', 'HRMS', 'SUBHAM', 'internal', '2026-09-29', '2026-10-02', '8.00', '30', 'Training Room A & Zoom Virtual Link', '0.00', '', 'scheduled', '2026-09-29 11:25:49', '2026-09-29 11:25:49');

-- -----------------------------------------------------
-- Table structure for `travel_expense_claims`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `travel_expense_claims`;
CREATE TABLE `travel_expense_claims` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `travel_request_id` int unsigned DEFAULT NULL,
  `employee_id` int unsigned NOT NULL,
  `expense_category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'General',
  `bill_date` date NOT NULL,
  `bill_number` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `approved_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `receipt_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_tec_req` (`travel_request_id`),
  KEY `fk_tec_emp` (`employee_id`),
  CONSTRAINT `fk_tec_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tec_req` FOREIGN KEY (`travel_request_id`) REFERENCES `travel_requests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `travel_expense_claims` (5 rows)
INSERT INTO `travel_expense_claims` (`id`, `travel_request_id`, `employee_id`, `expense_category`, `bill_date`, `bill_number`, `amount`, `approved_amount`, `receipt_path`, `remarks`, `status`, `created_at`, `updated_at`) VALUES
('1', '1', '1', '', '2026-09-29', 'INV-B0DF23', '5000.00', '5000.00', 'receipts/rcpt_1790677883.pdf', 'Verified against submitted receipt vouchers.', 'approved', '2026-09-29 10:31:23', '2026-09-29 10:31:29'),
('2', '2', '1', '', '2026-09-29', 'INV-6CEE8C', '5000.00', '100000.00', 'receipts/rcpt_1790678038.pdf', 'Verified against submitted receipt vouchers.', 'approved', '2026-09-29 10:33:58', '2026-09-29 10:46:05'),
('3', NULL, '7', 'Flight / Airfare', '2026-09-29', 'INV-517A1C', '10000.00', '10000.00', 'receipts/rcpt_1790678677.pdf', 'Verified against submitted receipt vouchers.', 'approved', '2026-09-29 10:44:37', '2026-09-29 10:46:16'),
('4', NULL, '7', 'Flight / Airfare', '2026-09-29', 'INV-D73A2C', '10000.00', '10000.00', 'receipts/rcpt_1790678717.pdf', 'Verified against submitted receipt vouchers.', 'approved', '2026-09-29 10:45:17', '2026-09-29 10:46:11'),
('5', NULL, '7', 'Flight / Airfare', '2026-10-05', 'INV-875C5A', '35000.00', '35000.00', 'receipts/rcpt_1790678936.pdf', 'Verified against submitted receipt vouchers.', 'approved', '2026-09-29 10:48:56', '2026-09-29 10:49:22');

-- -----------------------------------------------------
-- Table structure for `travel_requests`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `travel_requests`;
CREATE TABLE `travel_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `request_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int unsigned NOT NULL,
  `purpose` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `travel_type` enum('domestic','international') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'domestic',
  `source_city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `estimated_budget` decimal(12,2) NOT NULL DEFAULT '0.00',
  `advance_required` decimal(12,2) NOT NULL DEFAULT '0.00',
  `advance_disbursed` decimal(12,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('submitted','manager_approved','finance_approved','in_progress','completed','claims_submitted','settled','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'submitted',
  `manager_id` int unsigned DEFAULT NULL,
  `manager_action_at` datetime DEFAULT NULL,
  `manager_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finance_id` int unsigned DEFAULT NULL,
  `finance_action_at` datetime DEFAULT NULL,
  `finance_remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `request_number` (`request_number`),
  KEY `idx_tr_emp` (`employee_id`,`status`),
  KEY `fk_tr_mgr` (`manager_id`),
  KEY `fk_tr_fin` (`finance_id`),
  CONSTRAINT `fk_tr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_tr_fin` FOREIGN KEY (`finance_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tr_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `travel_requests` (4 rows)
INSERT INTO `travel_requests` (`id`, `request_number`, `employee_id`, `purpose`, `travel_type`, `source_city`, `destination_city`, `start_date`, `end_date`, `estimated_budget`, `advance_required`, `advance_disbursed`, `notes`, `status`, `manager_id`, `manager_action_at`, `manager_remarks`, `finance_id`, `finance_action_at`, `finance_remarks`, `created_at`, `updated_at`) VALUES
('1', 'TRV-20260929-F762', '1', 'travel', 'domestic', 'mumbai', 'bengaluru', '2026-10-02', '2026-10-05', '150000.00', '5000.00', '5000.00', '', '', '1', '2026-09-29 10:34:48', 'Travel and travel advance approved.', '1', '2026-09-29 10:34:48', 'Travel and travel advance approved.', '2026-09-29 10:30:53', '2026-09-29 10:34:48'),
('2', 'TRV-20260929-4911', '1', 'bussiness meeting', 'domestic', 'bangalore', 'whitefiled', '2026-10-02', '2026-10-05', '15000.00', '5000.00', '5000.00', 'the filght cost', '', '1', '2026-09-29 10:34:39', 'Travel and travel advance approved.', '1', '2026-09-29 10:34:39', 'Travel and travel advance approved.', '2026-09-29 10:31:57', '2026-09-29 10:34:39'),
('3', 'TRV-20260929-225B', '7', 'bussiness meeting', 'domestic', 'bangalore', 'whitefiled', '2026-10-02', '2026-10-05', '15000.00', '5000.00', '5000.00', '', '', '1', '2026-09-29 10:34:32', 'Travel and travel advance approved.', '1', '2026-09-29 10:34:32', 'Travel and travel advance approved.', '2026-09-29 10:32:40', '2026-09-29 10:34:32'),
('4', 'TRV-20260929-CC52', '7', 'office work', 'domestic', 'kolkata', 'mumbai', '2026-10-02', '2026-10-05', '50000.00', '15000.00', '15000.00', 'for adv', '', '2', '2026-09-29 10:48:10', 'Travel and travel advance approved.', '2', '2026-09-29 10:48:10', 'Travel and travel advance approved.', '2026-09-29 10:47:44', '2026-09-29 10:48:10');

-- -----------------------------------------------------
-- Table structure for `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int unsigned DEFAULT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int unsigned NOT NULL,
  `status` enum('active','inactive','suspended') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `two_factor_secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_enabled` tinyint(1) DEFAULT '0',
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_users_role` (`role_id`),
  KEY `fk_users_employee` (`employee_id`),
  CONSTRAINT `fk_users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users` (20 rows)
INSERT INTO `users` (`id`, `employee_id`, `username`, `email`, `password_hash`, `role_id`, `status`, `two_factor_secret`, `two_factor_enabled`, `last_login_at`, `last_login_ip`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1', '1', 'demo.superadmin', 'demo.superadmin@infosof.com', '$2y$10$UG3O0UFF13QLaZrmQ6VjKOT2jeZgGqYkhgUqINgThZJGX2Zjl6yOi', '1', 'active', NULL, '0', '2026-09-28 11:43:04', '192.168.1.19', NULL, '2026-09-28 17:06:10', '2026-09-28 11:43:04', NULL),
('2', '2', 'demo.hradmin', 'demo.hradmin@infosof.com', '$2y$10$UG3O0UFF13QLaZrmQ6VjKOT2jeZgGqYkhgUqINgThZJGX2Zjl6yOi', '2', 'active', NULL, '0', '2026-09-28 11:43:05', '192.168.1.19', NULL, '2026-09-28 17:06:10', '2026-09-28 11:43:05', NULL),
('3', '3', 'demo.hrexecutive', 'demo.hrexecutive@infosof.com', '$2y$10$UG3O0UFF13QLaZrmQ6VjKOT2jeZgGqYkhgUqINgThZJGX2Zjl6yOi', '3', 'active', NULL, '0', NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('4', '4', 'demo.payroll', 'demo.payroll@infosof.com', '$2y$10$UG3O0UFF13QLaZrmQ6VjKOT2jeZgGqYkhgUqINgThZJGX2Zjl6yOi', '4', 'active', NULL, '0', NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('5', '5', 'demo.accountant', 'demo.accountant@infosof.com', '$2y$10$UG3O0UFF13QLaZrmQ6VjKOT2jeZgGqYkhgUqINgThZJGX2Zjl6yOi', '5', 'active', NULL, '0', NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('6', '6', 'demo.manager', 'demo.manager@infosof.com', '$2y$10$UG3O0UFF13QLaZrmQ6VjKOT2jeZgGqYkhgUqINgThZJGX2Zjl6yOi', '6', 'active', NULL, '0', NULL, NULL, NULL, '2026-09-28 17:06:10', '2026-09-28 17:06:10', NULL),
('7', '7', 'demo.employee', 'demo.employee@infosof.com', '$2y$10$UG3O0UFF13QLaZrmQ6VjKOT2jeZgGqYkhgUqINgThZJGX2Zjl6yOi', '7', 'active', NULL, '0', '2026-09-28 11:43:06', '192.168.1.19', NULL, '2026-09-28 17:06:10', '2026-09-29 05:46:32', NULL),
('8', '8', 'vishal.jha', 'vishal@gmail.com', '$2y$10$EvMnPNIFcGKN2kTiNMB5Yu8nwzZpz9fcPFWX8cA.RVc6Xs4VPmfLa', '7', 'suspended', NULL, '0', '2026-09-28 12:04:33', '192.168.1.13', NULL, '2026-09-28 12:02:23', '2026-09-28 17:48:16', NULL),
('9', NULL, 'rohantrainee', 'trainee.9109@example.com', '$2y$10$RyOD.nb5z6Cddckoj3yHSuitGwItGuzEoCeP5vb4R2611OEnYjcPW', '7', 'active', NULL, '0', NULL, NULL, NULL, '2026-09-28 12:30:07', '2026-09-28 12:30:08', NULL),
('10', '10', 'rishav.xyz', 'rishav@gmail.com', '$2y$10$iUmnwSFf9sA6v.g16c16peszUHifgylbz8XhZ26JmUTTsITTOYqJK', '7', 'suspended', NULL, '0', NULL, NULL, NULL, '2026-09-29 05:51:40', '2026-09-29 11:26:20', NULL),
('11', '11', 'ronaldo.cr7', 'cr7@gmail.com', '$2y$10$w9qVN3F6C2g1aYqTZ6ndfu1GMmCEi0v7tyRJY/HQVOCgdzNIO6yfa', '7', 'suspended', NULL, '0', NULL, NULL, NULL, '2026-09-29 05:53:54', '2026-09-29 11:24:12', NULL),
('12', '12', 'ronaldocr7', 'cekdoteen@gmail.com', '$2y$10$HaACjlPImba2uhK4BwCJKOnoxoIUY/4UtoA.jYvKSNnIC3QkGxCZe', '3', 'suspended', NULL, '0', NULL, NULL, NULL, '2026-09-29 05:55:32', '2026-09-29 11:26:10', NULL),
('13', '13', 'ronaldo.cr714', 'Ronaldo@gmail.com', '$2y$10$X525Sc5MVpHhQPiBuX3Df.ye0eOp5OsxkmGgJm7ighWUJr5xNdNvK', '7', 'suspended', NULL, '0', '2026-09-29 07:18:25', '192.168.1.13', NULL, '2026-09-29 06:12:58', '2026-09-29 17:01:31', NULL),
('14', '14', 'messi.m10', 'messi@gmail.com', '$2y$10$/gZnRaOD6GeQ2G9ur.rxRuKqaAU29CeFUsR/Cimg6OyePH0Vku4v2', '7', 'suspended', NULL, '0', NULL, NULL, NULL, '2026-09-29 06:22:54', '2026-09-29 11:53:13', NULL),
('15', '15', 'messipaul', 'messi123@gmail.com', '$2y$10$M6hqfN8Yow4txjHPsN/18u8h4YybTrFmU0j84NvQPYviM.KH2ZiDW', '7', 'suspended', NULL, '0', NULL, NULL, NULL, '2026-09-29 06:25:01', '2026-09-29 17:01:38', NULL),
('16', '16', 'rupam.s45', 'rupam2003@gmail.com', '$2y$10$n8bw3dY13LZeyamzIfmCzet51h6IVS1Uhug0Ap0vZGv653Cz1mam2', '7', 'suspended', NULL, '0', NULL, NULL, NULL, '2026-09-29 06:28:34', '2026-09-29 17:01:19', NULL),
('17', '17', 'sample.employee', 'sample@gmail.com', '$2y$10$aJ6Qu51XyFx3iMhmO8M5tedrSkCdO8W0EGHBc2irEM4W2feC99fmC', '7', 'active', NULL, '0', '2026-09-29 09:53:31', '192.168.1.13', NULL, '2026-09-29 08:43:21', '2026-09-29 09:53:31', NULL),
('18', '18', 'sample.demo2', 'demo2@gmail.com', '$2y$10$GrHbZLVBub5ALmZ.j2xi9uwjYxbbnqm7J0C6dORUhRTvW84VVzBwC', '7', 'suspended', NULL, '0', '2026-09-29 10:09:04', '192.168.1.11', NULL, '2026-09-29 09:58:10', '2026-09-29 17:01:08', NULL),
('19', '19', 'priyanshu.paul', 'priyanshupaul.mng2003@gmail.com', '$2y$10$SVnkb02to8NBFWvb7FJcAufGp9K0Xa7HXaQNSz6FGT9eRQ.IyYvmC', '7', 'suspended', NULL, '0', '2026-09-29 10:26:59', '192.168.1.13', NULL, '2026-09-29 10:04:04', '2026-09-29 17:00:55', NULL),
('20', '20', 'dhurv.v63', 'vikram@gmail.com', '$2y$10$KbQlVgSKbkZXfIvwA6pCB.lX.6jfMNOB6O8iT.paxD052.EadiHiq', '7', 'active', NULL, '0', NULL, NULL, NULL, '2026-09-29 11:16:54', '2026-09-29 11:16:54', NULL);

-- -----------------------------------------------------
-- Table structure for `working_day_configurations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `working_day_configurations`;
CREATE TABLE `working_day_configurations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int unsigned NOT NULL,
  `branch_id` int unsigned DEFAULT NULL,
  `department_id` int unsigned DEFAULT NULL,
  `day_of_week` enum('monday','tuesday','wednesday','thursday','friday','saturday','sunday') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_working` tinyint(1) NOT NULL DEFAULT '1',
  `working_type` enum('full_day','half_day','off') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full_day',
  `alternate_week_off` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'e.g. 2nd_4th_saturday',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_wdc_comp_branch` (`company_id`,`branch_id`),
  KEY `fk_wdc_branch` (`branch_id`),
  KEY `fk_wdc_dept` (`department_id`),
  CONSTRAINT `fk_wdc_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_wdc_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_wdc_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `working_day_configurations` (7 rows)
INSERT INTO `working_day_configurations` (`id`, `company_id`, `branch_id`, `department_id`, `day_of_week`, `is_working`, `working_type`, `alternate_week_off`, `created_at`, `updated_at`) VALUES
('1', '1', NULL, NULL, 'monday', '1', 'full_day', NULL, '2026-09-26 12:18:59', '2026-09-26 12:18:59'),
('2', '1', NULL, NULL, 'tuesday', '1', 'full_day', NULL, '2026-09-26 12:18:59', '2026-09-26 12:18:59'),
('3', '1', NULL, NULL, 'wednesday', '1', 'full_day', NULL, '2026-09-26 12:18:59', '2026-09-26 12:18:59'),
('4', '1', NULL, NULL, 'thursday', '1', 'full_day', NULL, '2026-09-26 12:18:59', '2026-09-26 12:18:59'),
('5', '1', NULL, NULL, 'friday', '1', 'full_day', NULL, '2026-09-26 12:18:59', '2026-09-26 12:18:59'),
('6', '1', NULL, NULL, 'saturday', '1', 'half_day', '2nd_4th_saturday', '2026-09-26 12:18:59', '2026-09-26 12:18:59'),
('7', '1', NULL, NULL, 'sunday', '0', 'off', NULL, '2026-09-26 12:18:59', '2026-09-26 12:18:59');

SET FOREIGN_KEY_CHECKS=1;
-- Snapshot complete
