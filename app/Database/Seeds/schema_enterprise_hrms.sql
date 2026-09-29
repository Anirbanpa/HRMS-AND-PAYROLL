-- ==============================================================================
-- Enterprise HRMS & Payroll Management System
-- Schema Definition (MySQL 5.7+ and MySQL 8.x Compatible)
-- Character Set: utf8mb4, Collation: utf8mb4_unicode_ci, Engine: InnoDB
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------------
-- 1. ROLES & RBAC PERMISSIONS (Module 1, 43)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `role_permissions`;
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `hierarchy_level` TINYINT UNSIGNED NOT NULL DEFAULT 7,
    `description` VARCHAR(255) NULL,
    `is_system` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `module` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `description` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_permissions` (
    `role_id` INT UNSIGNED NOT NULL,
    `permission_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    CONSTRAINT `fk_rp_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_rp_perm` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NULL,
    `username` VARCHAR(60) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role_id` INT UNSIGNED NOT NULL,
    `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    `two_factor_secret` VARCHAR(100) NULL,
    `two_factor_enabled` TINYINT(1) DEFAULT 0,
    `last_login_at` DATETIME NULL,
    `last_login_ip` VARCHAR(45) NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME NULL,
    CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 2. COMPANY & ORGANIZATION STRUCTURE (Modules 3, 7, 41)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(120) NOT NULL,
    `code` VARCHAR(30) NOT NULL UNIQUE,
    `tax_id` VARCHAR(50) NULL,
    `email` VARCHAR(100) NULL,
    `phone` VARCHAR(30) NULL,
    `website` VARCHAR(150) NULL,
    `currency` VARCHAR(10) DEFAULT 'USD',
    `timezone` VARCHAR(50) DEFAULT 'America/New_York',
    `fiscal_year_start_month` TINYINT DEFAULT 1,
    `logo` VARCHAR(255) NULL,
    `address` TEXT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `branches`;
CREATE TABLE `branches` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `branch_code` VARCHAR(30) NOT NULL UNIQUE,
    `email` VARCHAR(100) NULL,
    `phone` VARCHAR(30) NULL,
    `address` TEXT NULL,
    `city` VARCHAR(60) NULL,
    `state` VARCHAR(60) NULL,
    `country` VARCHAR(60) DEFAULT 'United States',
    `postal_code` VARCHAR(20) NULL,
    `is_head_office` TINYINT(1) DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_branch_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `name` VARCHAR(100) NOT NULL,
    `code` VARCHAR(30) NOT NULL UNIQUE,
    `head_employee_id` INT UNSIGNED NULL,
    `parent_id` INT UNSIGNED NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_dept_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_dept_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_dept_parent` FOREIGN KEY (`parent_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `pay_grades`;
CREATE TABLE `pay_grades` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `grade_name` VARCHAR(60) NOT NULL,
    `grade_code` VARCHAR(20) NOT NULL UNIQUE,
    `min_salary` DECIMAL(12,2) DEFAULT 0.00,
    `max_salary` DECIMAL(12,2) DEFAULT 0.00,
    `description` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pg_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `designations`;
CREATE TABLE `designations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `department_id` INT UNSIGNED NULL,
    `name` VARCHAR(100) NOT NULL,
    `code` VARCHAR(30) NOT NULL UNIQUE,
    `grade_band_id` INT UNSIGNED NULL,
    `description` VARCHAR(255) NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_desig_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_desig_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_desig_grade` FOREIGN KEY (`grade_band_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `financial_years`;
CREATE TABLE `financial_years` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(50) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `is_current` TINYINT(1) DEFAULT 0,
    `status` ENUM('active', 'closed') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_fy_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 3. EMPLOYEE MASTER & LIFECYCLE (Modules 4, 5, 6, 9)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `employee_custom_fields`;
DROP TABLE IF EXISTS `employee_documents`;
DROP TABLE IF EXISTS `employee_bank_details`;
DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NULL,
    `company_id` INT UNSIGNED NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `department_id` INT UNSIGNED NULL,
    `designation_id` INT UNSIGNED NULL,
    `pay_grade_id` INT UNSIGNED NULL,
    `employee_code` VARCHAR(30) NOT NULL UNIQUE,
    `first_name` VARCHAR(50) NOT NULL,
    `middle_name` VARCHAR(50) NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `official_email` VARCHAR(100) NULL,
    `phone` VARCHAR(25) NOT NULL,
    `gender` ENUM('male', 'female', 'non_binary', 'other') DEFAULT 'male',
    `date_of_birth` DATE NULL,
    `marital_status` ENUM('single', 'married', 'divorced', 'widowed') DEFAULT 'single',
    `blood_group` VARCHAR(10) NULL,
    `joining_date` DATE NOT NULL,
    `confirmation_date` DATE NULL,
    `probation_end_date` DATE NULL,
    `employment_type` ENUM('full_time', 'part_time', 'contract', 'intern', 'probation') DEFAULT 'full_time',
    `employment_status` ENUM('active', 'on_leave', 'probation', 'notice_period', 'terminated', 'resigned', 'retired') DEFAULT 'active',
    `reporting_to` INT UNSIGNED NULL,
    `present_address` TEXT NULL,
    `permanent_address` TEXT NULL,
    `city` VARCHAR(60) NULL,
    `state` VARCHAR(60) NULL,
    `country` VARCHAR(60) DEFAULT 'United States',
    `postal_code` VARCHAR(20) NULL,
    `national_id_ssn` VARCHAR(50) NULL,
    `tax_identification_number` VARCHAR(50) NULL,
    `passport_number` VARCHAR(50) NULL,
    `driving_license` VARCHAR(50) NULL,
    `emergency_contact_name` VARCHAR(100) NULL,
    `emergency_contact_relation` VARCHAR(50) NULL,
    `emergency_contact_phone` VARCHAR(25) NULL,
    `profile_photo` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` DATETIME NULL,
    CONSTRAINT `fk_emp_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_emp_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_emp_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_emp_desig` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_emp_grade` FOREIGN KEY (`pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_emp_manager` FOREIGN KEY (`reporting_to`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Complete loopback foreign key for users and departments
ALTER TABLE `users` ADD CONSTRAINT `fk_users_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;
ALTER TABLE `departments` ADD CONSTRAINT `fk_dept_head` FOREIGN KEY (`head_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

CREATE TABLE `employee_bank_details` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `bank_name` VARCHAR(100) NOT NULL,
    `account_name` VARCHAR(100) NOT NULL,
    `account_number` VARCHAR(50) NOT NULL,
    `ifsc_swift_code` VARCHAR(30) NULL,
    `branch_name` VARCHAR(100) NULL,
    `payment_method` ENUM('bank_transfer', 'cheque', 'cash') DEFAULT 'bank_transfer',
    `is_primary` TINYINT(1) DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_bank_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `employee_documents` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `document_type` ENUM('national_id', 'passport', 'resume', 'contract', 'degree', 'tax_form', 'certificate', 'other') NOT NULL,
    `document_title` VARCHAR(120) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_size` INT UNSIGNED DEFAULT 0,
    `expiry_date` DATE NULL,
    `is_verified` TINYINT(1) DEFAULT 0,
    `verified_by` INT UNSIGNED NULL,
    `uploaded_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_doc_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `employee_custom_fields` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `field_name` VARCHAR(60) NOT NULL,
    `field_value` TEXT NULL,
    `field_type` VARCHAR(30) DEFAULT 'text',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_custom_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 4. TIME, ATTENDANCE & SHIFTS (Modules 10, 11, 12, 14, 15, 16)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `attendance`;
DROP TABLE IF EXISTS `shift_allocations`;
DROP TABLE IF EXISTS `shifts`;
DROP TABLE IF EXISTS `holidays`;

CREATE TABLE `shifts` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(60) NOT NULL,
    `code` VARCHAR(20) NOT NULL UNIQUE,
    `start_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,
    `late_grace_mins` INT DEFAULT 15,
    `early_exit_grace_mins` INT DEFAULT 15,
    `is_night_shift` TINYINT(1) DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_shift_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `shift_allocations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `shift_id` INT UNSIGNED NOT NULL,
    `from_date` DATE NOT NULL,
    `to_date` DATE NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_sa_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_sa_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `attendance` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    `shift_id` INT UNSIGNED NULL,
    `clock_in` DATETIME NULL,
    `clock_out` DATETIME NULL,
    `total_hours` DECIMAL(5,2) DEFAULT 0.00,
    `late_minutes` INT DEFAULT 0,
    `early_leaving_minutes` INT DEFAULT 0,
    `overtime_minutes` INT DEFAULT 0,
    `status` ENUM('Present', 'Absent', 'Late', 'Half-Day', 'On Leave', 'Holiday', 'Week Off') DEFAULT 'Present',
    `clock_in_ip` VARCHAR(45) NULL,
    `clock_out_ip` VARCHAR(45) NULL,
    `source` ENUM('web', 'biometric', 'manual_adjustment') DEFAULT 'web',
    `notes` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_emp_date` (`employee_id`, `date`),
    CONSTRAINT `fk_att_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_att_shift` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `holidays` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `title` VARCHAR(100) NOT NULL,
    `date` DATE NOT NULL,
    `is_recurring` TINYINT(1) DEFAULT 0,
    `description` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_hol_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_hol_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 5. LEAVE MANAGEMENT (Module 13)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `leave_requests`;
DROP TABLE IF EXISTS `leave_balances`;
DROP TABLE IF EXISTS `leave_types`;

CREATE TABLE `leave_types` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `code` VARCHAR(20) NOT NULL UNIQUE,
    `days_allowed_per_year` DECIMAL(4,1) NOT NULL DEFAULT 12.0,
    `is_paid` TINYINT(1) DEFAULT 1,
    `carry_forward_allowed` TINYINT(1) DEFAULT 0,
    `max_carry_forward` DECIMAL(4,1) DEFAULT 0.0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_lt_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `leave_balances` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `leave_type_id` INT UNSIGNED NOT NULL,
    `year` INT NOT NULL,
    `allocated_days` DECIMAL(4,1) DEFAULT 0.0,
    `used_days` DECIMAL(4,1) DEFAULT 0.0,
    `pending_days` DECIMAL(4,1) DEFAULT 0.0,
    `remaining_days` DECIMAL(4,1) DEFAULT 0.0,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_emp_lt_yr` (`employee_id`, `leave_type_id`, `year`),
    CONSTRAINT `fk_lb_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_lb_lt` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `leave_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `leave_type_id` INT UNSIGNED NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `total_days` DECIMAL(4,1) NOT NULL,
    `is_half_day` TINYINT(1) DEFAULT 0,
    `reason` TEXT NOT NULL,
    `status` ENUM('pending', 'manager_approved', 'hr_approved', 'rejected', 'cancelled') DEFAULT 'pending',
    `manager_id` INT UNSIGNED NULL,
    `manager_action_at` DATETIME NULL,
    `hr_id` INT UNSIGNED NULL,
    `hr_action_at` DATETIME NULL,
    `rejection_reason` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_lr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_lr_lt` FOREIGN KEY (`leave_type_id`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 6. PAYROLL CONFIGURATION & MONTHLY PROCESSING (Modules 17, 18, 19, 20, 21, 22)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `payroll_items`;
DROP TABLE IF EXISTS `payroll_runs`;
DROP TABLE IF EXISTS `salary_structures`;

CREATE TABLE `salary_structures` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `effective_date` DATE NOT NULL,
    `basic_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `hra` DECIMAL(12,2) DEFAULT 0.00,
    `conveyance_allowance` DECIMAL(12,2) DEFAULT 0.00,
    `special_allowance` DECIMAL(12,2) DEFAULT 0.00,
    `medical_allowance` DECIMAL(12,2) DEFAULT 0.00,
    `other_allowances` DECIMAL(12,2) DEFAULT 0.00,
    `gross_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `pf_deduction` DECIMAL(12,2) DEFAULT 0.00,
    `tax_deduction` DECIMAL(12,2) DEFAULT 0.00,
    `insurance_deduction` DECIMAL(12,2) DEFAULT 0.00,
    `total_deductions` DECIMAL(12,2) DEFAULT 0.00,
    `net_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_ss_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `payroll_runs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `financial_year_id` INT UNSIGNED NOT NULL,
    `month` TINYINT NOT NULL,
    `year` INT NOT NULL,
    `title` VARCHAR(80) NOT NULL,
    `status` ENUM('draft', 'processed', 'approved', 'paid', 'frozen') DEFAULT 'draft',
    `processed_by` INT UNSIGNED NULL,
    `processed_at` DATETIME NULL,
    `total_employees` INT DEFAULT 0,
    `total_gross` DECIMAL(14,2) DEFAULT 0.00,
    `total_deductions` DECIMAL(14,2) DEFAULT 0.00,
    `total_net` DECIMAL(14,2) DEFAULT 0.00,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_comp_mo_yr` (`company_id`, `month`, `year`),
    CONSTRAINT `fk_pr_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pr_fy` FOREIGN KEY (`financial_year_id`) REFERENCES `financial_years` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `payroll_items` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `payroll_run_id` INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `payslip_number` VARCHAR(40) NOT NULL UNIQUE,
    `present_days` DECIMAL(4,1) DEFAULT 0.0,
    `unpaid_leave_days` DECIMAL(4,1) DEFAULT 0.0,
    `overtime_hours` DECIMAL(5,2) DEFAULT 0.00,
    `basic_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `hra` DECIMAL(12,2) DEFAULT 0.00,
    `conveyance` DECIMAL(12,2) DEFAULT 0.00,
    `special_allowance` DECIMAL(12,2) DEFAULT 0.00,
    `medical_allowance` DECIMAL(12,2) DEFAULT 0.00,
    `overtime_amount` DECIMAL(12,2) DEFAULT 0.00,
    `bonus_incentive` DECIMAL(12,2) DEFAULT 0.00,
    `gross_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `pf_deduction` DECIMAL(12,2) DEFAULT 0.00,
    `tax_deduction` DECIMAL(12,2) DEFAULT 0.00,
    `insurance_deduction` DECIMAL(12,2) DEFAULT 0.00,
    `loan_emi_deduction` DECIMAL(12,2) DEFAULT 0.00,
    `unpaid_cut` DECIMAL(12,2) DEFAULT 0.00,
    `total_deductions` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `net_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `payment_status` ENUM('unpaid', 'pending', 'paid') DEFAULT 'unpaid',
    `payment_date` DATE NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pi_run` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pi_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 7. AUDIT TRAIL, SYSTEM SETTINGS & NOTIFICATIONS (Modules 36, 42, 44)
-- ------------------------------------------------------------------------------
DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE `activity_logs` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NULL,
    `action` VARCHAR(50) NOT NULL,
    `module` VARCHAR(50) NOT NULL,
    `description` TEXT NOT NULL,
    `record_id` INT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_act_user` (`user_id`),
    INDEX `idx_act_mod` (`module`),
    INDEX `idx_act_time` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `category` VARCHAR(50) NOT NULL DEFAULT 'general',
    `key_name` VARCHAR(80) NOT NULL UNIQUE,
    `key_value` TEXT NULL,
    `description` VARCHAR(255) NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ==============================================================================
-- DEFAULT SEED DATA
-- ==============================================================================

-- 1. Insert 7 Predefined Roles
INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `is_system`) VALUES
(1, 'Super Admin', 'super_admin', 'Global system administrative access with full control over all modules and tenant settings.', 1),
(2, 'HR Admin', 'hr_admin', 'Full Human Resources management access across employees, departments, onboarding, and policies.', 1),
(3, 'HR Executive', 'hr_executive', 'Operational HR staff handling daily records, attendance adjustments, and employee documents.', 1),
(4, 'Payroll Manager', 'payroll_manager', 'Responsible for payroll calculation, salary structures, tax deductions, and disbursement approval.', 1),
(5, 'Accountant', 'accountant', 'Financial auditor and accounting access for payslips, reimbursements, loans, and statutory exports.', 1),
(6, 'Manager / Department Head', 'manager', 'Head of department or team lead with manager self-service, approval queues for leave and attendance.', 1),
(7, 'Employee', 'employee', 'Individual employee self-service (ESS) portal access for attendance, leave requests, and payslips.', 1);

-- 2. Core RBAC Permissions
INSERT INTO `permissions` (`module`, `name`, `slug`, `description`) VALUES
('users', 'Manage Users', 'users.manage', 'Create, update, and manage system user accounts'),
('roles', 'Manage Roles & RBAC', 'roles.manage', 'Assign and configure roles and permissions'),
('company', 'Manage Organization', 'company.manage', 'Manage companies, branches, and fiscal years'),
('department', 'Manage Departments', 'department.manage', 'Create and modify departments'),
('designation', 'Manage Designations', 'designation.manage', 'Create and modify designations and pay grades'),
('employee', 'View Employees', 'employee.view', 'View employee directory and profiles'),
('employee', 'Create Employee', 'employee.create', 'Add new employees into the system'),
('employee', 'Edit Employee', 'employee.edit', 'Update employee records, bank details, and documents'),
('employee', 'Delete Employee', 'employee.delete', 'Archive or delete employee records'),
('attendance', 'View Attendance', 'attendance.view', 'Inspect daily and monthly attendance logs'),
('attendance', 'Manage Attendance', 'attendance.manage', 'Perform attendance corrections and manual adjustments'),
('leave', 'Apply Leave', 'leave.apply', 'Submit leave requests through self service'),
('leave', 'Approve Leave', 'leave.approve', 'Manager and HR approval workflows for leaves'),
('payroll', 'View Payroll', 'payroll.view', 'View payroll runs and employee payslips'),
('payroll', 'Process Payroll', 'payroll.process', 'Execute monthly payroll calculations and lock runs'),
('reports', 'View Reports', 'reports.view', 'Access executive dashboards and analytics reports'),
('audit', 'View Audit Logs', 'audit.view', 'Inspect non-editable activity logs and security events'),
('settings', 'Manage Settings', 'settings.manage', 'Configure application parameters and policies');

-- Assign All Permissions to Super Admin (Role 1)
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 1, `id` FROM `permissions`;

-- Assign HR Admin Permissions (Role 2)
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 2, `id` FROM `permissions` WHERE `slug` NOT IN ('roles.manage', 'settings.manage');

-- Assign Manager Permissions (Role 6)
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 6, `id` FROM `permissions` WHERE `slug` IN ('employee.view', 'attendance.view', 'leave.apply', 'leave.approve');

-- Assign Employee Permissions (Role 7)
INSERT INTO `role_permissions` (`role_id`, `permission_id`)
SELECT 7, `id` FROM `permissions` WHERE `slug` IN ('leave.apply');

-- 3. Default Organization Entity
INSERT INTO `companies` (`id`, `name`, `code`, `tax_id`, `email`, `phone`, `website`, `currency`, `timezone`, `address`, `status`) VALUES
(1, 'Apex Enterprise Solutions Corp.', 'APEX-CORP', 'US-EIN-94827104', 'contact@apexenterprise.com', '+1 (415) 890-5000', 'https://apexenterprise.com', 'USD', 'America/New_York', '100 Montgomery Street, Suite 2400, Financial District, San Francisco, CA 94104', 'active');

INSERT INTO `branches` (`id`, `company_id`, `name`, `branch_code`, `email`, `phone`, `address`, `city`, `state`, `country`, `postal_code`, `is_head_office`, `status`) VALUES
(1, 1, 'San Francisco Headquarters', 'BR-SFO-01', 'sfo@apexenterprise.com', '+1 (415) 890-5001', '100 Montgomery St, Suite 2400', 'San Francisco', 'CA', 'United States', '94104', 1, 'active'),
(2, 1, 'New York Tech Hub', 'BR-NYC-02', 'nyc@apexenterprise.com', '+1 (212) 555-0199', '350 5th Avenue, Empire Tower', 'New York', 'NY', 'United States', '10118', 0, 'active'),
(3, 1, 'London International Office', 'BR-LON-03', 'london@apexenterprise.com', '+44 20 7946 0912', '25 Bank Street, Canary Wharf', 'London', 'Greater London', 'United Kingdom', 'E14 5JP', 0, 'active');

INSERT INTO `financial_years` (`id`, `company_id`, `title`, `start_date`, `end_date`, `is_current`, `status`) VALUES
(1, 1, 'FY 2026 - 2027', '2026-01-01', '2026-12-31', 1, 'active');

-- 4. Pay Grades
INSERT INTO `pay_grades` (`id`, `company_id`, `grade_name`, `grade_code`, `min_salary`, `max_salary`, `description`) VALUES
(1, 1, 'Executive Band 1 (C-Suite / VP)', 'BAND-EX-01', 160000.00, 260000.00, 'Executive leadership and strategic decision makers'),
(2, 1, 'Senior Management Band 2', 'BAND-MG-02', 110000.00, 160000.00, 'Department heads, directors, and principal leads'),
(3, 1, 'Professional / Senior Band 3', 'BAND-PR-03', 75000.00, 110000.00, 'Senior engineers, HR business partners, senior analysts'),
(4, 1, 'Associate / Entry Band 4', 'BAND-AS-04', 45000.00, 75000.00, 'Junior associates, coordinators, and operational staff'),
(5, 1, 'Junior / Trainee Band 5', 'BAND-TR-05', 0.00, 45000.00, 'Trainees, interns, apprentices, and foundational support staff');

-- 5. Departments
INSERT INTO `departments` (`id`, `company_id`, `branch_id`, `name`, `code`, `parent_id`, `status`) VALUES
(1, 1, 1, 'Executive Leadership', 'DEP-EXEC', NULL, 'active'),
(2, 1, 1, 'Human Resources', 'DEP-HR', NULL, 'active'),
(3, 1, 1, 'Engineering & Technology', 'DEP-ENG', NULL, 'active'),
(4, 1, 1, 'Finance & Accounting', 'DEP-FIN', NULL, 'active'),
(5, 1, 2, 'Sales & Marketing', 'DEP-SLS', NULL, 'active'),
(6, 1, 1, 'Operations & Facilities', 'DEP-OPS', NULL, 'active');

-- 6. Designations
INSERT INTO `designations` (`id`, `company_id`, `department_id`, `name`, `code`, `grade_band_id`, `description`, `status`) VALUES
(1, 1, 1, 'Chief Executive Officer', 'DES-CEO', 1, 'Chief Executive Officer of the enterprise', 'active'),
(2, 1, 2, 'Director of Human Resources', 'DES-HRDIR', 2, 'Oversees all global human resources policies and personnel', 'active'),
(3, 1, 2, 'HR Operations Specialist', 'DES-HROPS', 4, 'Coordinates daily onboarding and employee records', 'active'),
(4, 1, 3, 'Engineering Director', 'DES-ENGDIR', 2, 'Leads software engineering and cloud infrastructure teams', 'active'),
(5, 1, 3, 'Lead Full Stack Architect', 'DES-ARCH', 3, 'Designs enterprise software architectures and frameworks', 'active'),
(6, 1, 4, 'Payroll & Compliance Controller', 'DES-PAYCTRL', 2, 'Oversees monthly payroll runs and statutory audits', 'active'),
(7, 1, 4, 'Senior Financial Accountant', 'DES-ACCT', 3, 'Handles financial ledgers and disbursement balance reconciliations', 'active');

-- 7. Shifts
INSERT INTO `shifts` (`id`, `company_id`, `name`, `code`, `start_time`, `end_time`, `late_grace_mins`, `early_exit_grace_mins`, `is_night_shift`, `status`) VALUES
(1, 1, 'General Day Shift (9 AM - 6 PM)', 'SH-GEN', '09:00:00', '18:00:00', 15, 15, 0, 'active'),
(2, 1, 'Morning Shift (7 AM - 4 PM)', 'SH-MORN', '07:00:00', '16:00:00', 15, 15, 0, 'active'),
(3, 1, 'Evening Tech Support (2 PM - 11 PM)', 'SH-EVE', '14:00:00', '23:00:00', 15, 15, 0, 'active');

-- 8. Leave Types
INSERT INTO `leave_types` (`id`, `company_id`, `name`, `code`, `days_allowed_per_year`, `is_paid`, `carry_forward_allowed`, `max_carry_forward`, `status`) VALUES
(1, 1, 'Paid Annual Leave', 'AL', 18.0, 1, 1, 6.0, 'active'),
(2, 1, 'Casual Leave', 'CL', 10.0, 1, 0, 0.0, 'active'),
(3, 1, 'Medical / Sick Leave', 'SL', 12.0, 1, 0, 0.0, 'active'),
(4, 1, 'Unpaid Leave / LOP', 'LOP', 0.0, 0, 0, 0.0, 'active');

-- 9. Sample Initial Employees
-- Password for all seed users is: Admin@123
-- Hash: $2y$10$5rsYP75Z0/QrTvrGfImLgOJUAU2kp466V64nMRqNCANAcAFpRuemO

INSERT INTO `employees` (`id`, `company_id`, `branch_id`, `department_id`, `designation_id`, `pay_grade_id`, `employee_code`, `first_name`, `last_name`, `email`, `official_email`, `phone`, `gender`, `joining_date`, `employment_type`, `employment_status`, `city`, `state`) VALUES
(1, 1, 1, 1, 1, 1, 'EMP0001', 'Arthur', 'Pendleton', 'superadmin@apexenterprise.com', 'arthur.pendleton@apexenterprise.com', '+1 (415) 782-9011', 'male', '2020-01-15', 'full_time', 'active', 'San Francisco', 'CA'),
(2, 1, 1, 2, 2, 2, 'EMP0002', 'Eleanor', 'Vance', 'hradmin@apexenterprise.com', 'eleanor.vance@apexenterprise.com', '+1 (415) 782-9012', 'female', '2021-03-01', 'full_time', 'active', 'San Francisco', 'CA'),
(3, 1, 1, 3, 4, 2, 'EMP0003', 'Marcus', 'Sterling', 'manager@apexenterprise.com', 'marcus.sterling@apexenterprise.com', '+1 (415) 782-9013', 'male', '2021-06-15', 'full_time', 'active', 'San Francisco', 'CA'),
(4, 1, 1, 3, 5, 3, 'EMP0004', 'Sophia', 'Chen', 'employee@apexenterprise.com', 'sophia.chen@apexenterprise.com', '+1 (415) 782-9014', 'female', '2022-08-01', 'full_time', 'active', 'San Francisco', 'CA'),
(5, 1, 1, 4, 6, 2, 'EMP0005', 'Julian', 'Mercer', 'payroll@apexenterprise.com', 'julian.mercer@apexenterprise.com', '+1 (415) 782-9015', 'male', '2022-01-10', 'full_time', 'active', 'San Francisco', 'CA');

-- Map department heads and reporting managers
UPDATE `departments` SET `head_employee_id` = 1 WHERE `id` = 1;
UPDATE `departments` SET `head_employee_id` = 2 WHERE `id` = 2;
UPDATE `departments` SET `head_employee_id` = 3 WHERE `id` = 3;
UPDATE `departments` SET `head_employee_id` = 5 WHERE `id` = 4;
UPDATE `employees` SET `reporting_to` = 3 WHERE `id` = 4; -- Sophia reports to Marcus

-- 10. User Accounts for the Seed Employees
INSERT INTO `users` (`id`, `employee_id`, `username`, `email`, `password_hash`, `role_id`, `status`) VALUES
(1, 1, 'superadmin', 'superadmin@apexenterprise.com', '$2y$10$5rsYP75Z0/QrTvrGfImLgOJUAU2kp466V64nMRqNCANAcAFpRuemO', 1, 'active'),
(2, 2, 'hradmin', 'hradmin@apexenterprise.com', '$2y$10$5rsYP75Z0/QrTvrGfImLgOJUAU2kp466V64nMRqNCANAcAFpRuemO', 2, 'active'),
(3, 3, 'manager', 'manager@apexenterprise.com', '$2y$10$5rsYP75Z0/QrTvrGfImLgOJUAU2kp466V64nMRqNCANAcAFpRuemO', 6, 'active'),
(4, 4, 'employee', 'employee@apexenterprise.com', '$2y$10$5rsYP75Z0/QrTvrGfImLgOJUAU2kp466V64nMRqNCANAcAFpRuemO', 7, 'active'),
(5, 5, 'payroll', 'payroll@apexenterprise.com', '$2y$10$5rsYP75Z0/QrTvrGfImLgOJUAU2kp466V64nMRqNCANAcAFpRuemO', 4, 'active');

UPDATE `employees` SET `user_id` = 1 WHERE `id` = 1;
UPDATE `employees` SET `user_id` = 2 WHERE `id` = 2;
UPDATE `employees` SET `user_id` = 3 WHERE `id` = 3;
UPDATE `employees` SET `user_id` = 4 WHERE `id` = 4;
UPDATE `employees` SET `user_id` = 5 WHERE `id` = 5;

-- 11. Bank Details for Sample Employees
INSERT INTO `employee_bank_details` (`employee_id`, `bank_name`, `account_name`, `account_number`, `ifsc_swift_code`, `branch_name`, `payment_method`, `is_primary`) VALUES
(1, 'JPMorgan Chase Bank', 'Arthur Pendleton', '98273641829', 'CHASUS33', 'Market St, San Francisco', 'bank_transfer', 1),
(2, 'Bank of America', 'Eleanor Vance', '47281938472', 'BOFAUS3N', 'Montgomery St, San Francisco', 'bank_transfer', 1),
(3, 'Wells Fargo Bank', 'Marcus Sterling', '58392019482', 'WFBIUS6S', 'California St, San Francisco', 'bank_transfer', 1),
(4, 'Citibank N.A.', 'Sophia Chen', '83920194827', 'CITIUS33', 'Sutter St, San Francisco', 'bank_transfer', 1),
(5, 'Silicon Valley Bank', 'Julian Mercer', '39201948273', 'SVBKUS6S', 'Sand Hill Rd, Menlo Park', 'bank_transfer', 1);

-- 12. Salary Structure for Sample Employees
INSERT INTO `salary_structures` (`employee_id`, `effective_date`, `basic_salary`, `hra`, `conveyance_allowance`, `special_allowance`, `medical_allowance`, `gross_salary`, `pf_deduction`, `tax_deduction`, `total_deductions`, `net_salary`) VALUES
(1, '2026-01-01', 12000.00, 3000.00, 800.00, 2200.00, 500.00, 18500.00, 1200.00, 2800.00, 4000.00, 14500.00),
(2, '2026-01-01', 8000.00, 2000.00, 600.00, 1400.00, 400.00, 12400.00, 800.00, 1600.00, 2400.00, 10000.00),
(3, '2026-01-01', 7500.00, 1800.00, 500.00, 1200.00, 400.00, 11400.00, 750.00, 1450.00, 2200.00, 9200.00),
(4, '2026-01-01', 6000.00, 1500.00, 400.00, 1100.00, 300.00, 9300.00, 600.00, 1100.00, 1700.00, 7600.00),
(5, '2026-01-01', 7000.00, 1700.00, 500.00, 1200.00, 400.00, 10800.00, 700.00, 1300.00, 2000.00, 8800.00);

-- 13. Leave Balances for 2026
INSERT INTO `leave_balances` (`employee_id`, `leave_type_id`, `year`, `allocated_days`, `used_days`, `pending_days`, `remaining_days`) VALUES
(1, 1, 2026, 18.0, 2.0, 0.0, 16.0),
(1, 2, 2026, 10.0, 1.0, 0.0, 9.0),
(1, 3, 2026, 12.0, 0.0, 0.0, 12.0),
(2, 1, 2026, 18.0, 3.0, 0.0, 15.0),
(2, 2, 2026, 10.0, 2.0, 0.0, 8.0),
(2, 3, 2026, 12.0, 1.0, 0.0, 11.0),
(3, 1, 2026, 18.0, 4.0, 0.0, 14.0),
(3, 2, 2026, 10.0, 1.0, 0.0, 9.0),
(3, 3, 2026, 12.0, 0.0, 0.0, 12.0),
(4, 1, 2026, 18.0, 1.0, 0.0, 17.0),
(4, 2, 2026, 10.0, 0.0, 0.0, 10.0),
(4, 3, 2026, 12.0, 0.0, 0.0, 12.0),
(5, 1, 2026, 18.0, 2.0, 0.0, 16.0),
(5, 2, 2026, 10.0, 1.0, 0.0, 9.0),
(5, 3, 2026, 12.0, 0.0, 0.0, 12.0);

-- 14. System Settings
INSERT INTO `system_settings` (`category`, `key_name`, `key_value`, `description`) VALUES
('general', 'app_name', 'Apex HRMS & Payroll Enterprise', 'Full application title displayed in header and reports'),
('general', 'company_name', 'Apex Enterprise Solutions Corp.', 'Default registered enterprise entity'),
('general', 'company_email', 'hr@apexenterprise.com', 'System communication and alert email'),
('general', 'default_currency', 'USD', 'Primary accounting and payroll disbursement currency'),
('general', 'date_format', 'Y-m-d', 'Standard system date formatting'),
('attendance', 'standard_work_hours', '8.0', 'Expected daily working hours per full-time employee'),
('attendance', 'allow_web_clock_in', '1', 'Enables or restricts browser based clock-in/out'),
('security', 'session_timeout_minutes', '120', 'Idle session lifetime before auto logout'),
('security', 'max_login_attempts', '5', 'Rate limiting threshold for user authentication');

-- 15. Initial Activity Log
INSERT INTO `activity_logs` (`user_id`, `action`, `module`, `description`, `ip_address`) VALUES
(1, 'SYSTEM_INIT', 'core', 'Enterprise HRMS database initialized and seeded with Phase 1 configurations and default access roles.', '127.0.0.1');
