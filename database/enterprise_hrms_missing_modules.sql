-- ==============================================================================
-- Enterprise HRMS & Payroll Management System
-- Schema Upgrade: Missing Modules (12, 14, 15, 23, 24, 25, 27, 28, 29, 36, 38, 39)
-- MySQL 5.7+ & MySQL 8.x Compatible
-- Engine: InnoDB, Charset: utf8mb4, Collation: utf8mb4_unicode_ci
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ==============================================================================
-- STEP 1: ALTER EXISTING TABLES TO SUPPORT ADVANCED WORKFLOWS
-- ==============================================================================

-- 1.1 Alter `shifts` table: Add rotational, break, and overtime configuration
ALTER TABLE `shifts`
    ADD COLUMN `shift_type` ENUM('regular', 'rotational', 'split', 'night', 'flexible') NOT NULL DEFAULT 'regular' AFTER `code`,
    ADD COLUMN `break_duration_mins` INT UNSIGNED NOT NULL DEFAULT 60 AFTER `end_time`,
    ADD COLUMN `half_day_hours` DECIMAL(4,2) NOT NULL DEFAULT 4.50 AFTER `break_duration_mins`,
    ADD COLUMN `full_day_hours` DECIMAL(4,2) NOT NULL DEFAULT 8.00 AFTER `half_day_hours`,
    ADD COLUMN `overtime_eligible` TINYINT(1) NOT NULL DEFAULT 1 AFTER `full_day_hours`,
    ADD COLUMN `min_overtime_mins` INT UNSIGNED NOT NULL DEFAULT 30 AFTER `overtime_eligible`;

-- 1.2 Alter `shift_allocations` table: Add rotation patterns and audit trail
ALTER TABLE `shift_allocations`
    ADD COLUMN `rotation_pattern` ENUM('fixed', 'weekly', 'bi_weekly', 'monthly') NOT NULL DEFAULT 'fixed' AFTER `to_date`,
    ADD COLUMN `assigned_by` INT UNSIGNED NULL AFTER `rotation_pattern`,
    ADD COLUMN `status` ENUM('active', 'inactive', 'transferred') NOT NULL DEFAULT 'active' AFTER `assigned_by`,
    ADD COLUMN `notes` VARCHAR(255) NULL AFTER `status`,
    ADD COLUMN `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`,
    ADD CONSTRAINT `fk_sa_assigner` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- 1.3 Alter `holidays` table: Support department-specific calendars and working-day overrides
ALTER TABLE `holidays`
    ADD COLUMN `department_id` INT UNSIGNED NULL AFTER `branch_id`,
    ADD COLUMN `holiday_type` ENUM('national', 'regional', 'company', 'restricted', 'optional') NOT NULL DEFAULT 'company' AFTER `title`,
    ADD COLUMN `is_working_day` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_recurring`,
    ADD CONSTRAINT `fk_hol_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

-- 1.4 Alter `payroll_items` table: Add dedicated reimbursement and loan tracking columns
ALTER TABLE `payroll_items`
    ADD COLUMN `reimbursement_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `bonus_incentive`,
    ADD COLUMN `loan_deduction` DECIMAL(12,2) NOT NULL DEFAULT 0.00 AFTER `loan_emi_deduction`;


-- ==============================================================================
-- STEP 2: CREATE NEW TABLES FOR MODULE INTEGRATION
-- ==============================================================================

-- ------------------------------------------------------------------------------
-- MODULE 14: WORKING DAY & WEEKLY CALENDAR CONFIGURATION
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `working_day_configurations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `branch_id` INT UNSIGNED NULL,
    `department_id` INT UNSIGNED NULL,
    `day_of_week` ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday') NOT NULL,
    `is_working` TINYINT(1) NOT NULL DEFAULT 1,
    `working_type` ENUM('full_day', 'half_day', 'off') NOT NULL DEFAULT 'full_day',
    `alternate_week_off` VARCHAR(50) NULL COMMENT 'e.g. 2nd_4th_saturday',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_wdc_comp_branch` (`company_id`, `branch_id`),
    CONSTRAINT `fk_wdc_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_wdc_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_wdc_dept` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 15: OVERTIME MANAGEMENT (RULES & WORKFLOWS)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `overtime_rules` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `rule_code` VARCHAR(30) NOT NULL UNIQUE,
    `rate_multiplier` DECIMAL(4,2) NOT NULL DEFAULT 1.50 COMMENT '1.5x on normal, 2.0x on holiday',
    `applicable_days` ENUM('all', 'workday', 'weekend', 'holiday') NOT NULL DEFAULT 'all',
    `min_hours` DECIMAL(4,2) NOT NULL DEFAULT 1.00,
    `max_hours_per_day` DECIMAL(4,2) NOT NULL DEFAULT 4.00,
    `monthly_cap_hours` DECIMAL(5,2) NOT NULL DEFAULT 40.00,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_otr_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `overtime_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `overtime_rule_id` INT UNSIGNED NULL,
    `request_date` DATE NOT NULL,
    `start_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,
    `total_hours` DECIMAL(5,2) NOT NULL,
    `reason` TEXT NOT NULL,
    `status` ENUM('pending', 'manager_approved', 'hr_approved', 'rejected', 'payroll_processed') NOT NULL DEFAULT 'pending',
    `manager_id` INT UNSIGNED NULL,
    `manager_action_at` DATETIME NULL,
    `manager_remarks` VARCHAR(255) NULL,
    `hr_id` INT UNSIGNED NULL,
    `hr_action_at` DATETIME NULL,
    `hr_remarks` VARCHAR(255) NULL,
    `hourly_rate` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `payout_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `payroll_run_id` INT UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_ot_emp_date` (`employee_id`, `request_date`),
    CONSTRAINT `fk_ot_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_ot_rule` FOREIGN KEY (`overtime_rule_id`) REFERENCES `overtime_rules` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_ot_manager` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_ot_hr` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_ot_run` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 23: SALARY ADVANCE & LOAN MANAGEMENT
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `employee_loans` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `loan_application_no` VARCHAR(50) NOT NULL UNIQUE,
    `employee_id` INT UNSIGNED NOT NULL,
    `loan_type` ENUM('salary_advance', 'personal_loan', 'emergency_advance', 'education_loan') NOT NULL DEFAULT 'salary_advance',
    `principal_amount` DECIMAL(12,2) NOT NULL,
    `interest_rate_percent` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    `total_repayable` DECIMAL(12,2) NOT NULL,
    `tenure_months` INT UNSIGNED NOT NULL DEFAULT 1,
    `monthly_emi` DECIMAL(12,2) NOT NULL,
    `disbursement_date` DATE NULL,
    `first_deduction_month` TINYINT UNSIGNED NULL,
    `first_deduction_year` INT UNSIGNED NULL,
    `total_paid` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `outstanding_balance` DECIMAL(12,2) NOT NULL,
    `status` ENUM('submitted', 'manager_approved', 'finance_approved', 'disbursed', 'active', 'repaid', 'settled', 'rejected') NOT NULL DEFAULT 'submitted',
    `reason` TEXT NOT NULL,
    `approved_by` INT UNSIGNED NULL,
    `approved_at` DATETIME NULL,
    `settlement_notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_loan_emp` (`employee_id`, `status`),
    CONSTRAINT `fk_loan_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_loan_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `loan_repayment_schedules` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `loan_id` INT UNSIGNED NOT NULL,
    `installment_number` INT UNSIGNED NOT NULL,
    `due_month` TINYINT UNSIGNED NOT NULL,
    `due_year` INT UNSIGNED NOT NULL,
    `emi_amount` DECIMAL(12,2) NOT NULL,
    `principal_component` DECIMAL(12,2) NOT NULL,
    `interest_component` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `paid_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `paid_date` DATE NULL,
    `payroll_run_id` INT UNSIGNED NULL,
    `status` ENUM('scheduled', 'deducted', 'paid_manually', 'waived', 'deferred') NOT NULL DEFAULT 'scheduled',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_lrs_due` (`due_year`, `due_month`, `status`),
    CONSTRAINT `fk_lrs_loan` FOREIGN KEY (`loan_id`) REFERENCES `employee_loans` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_lrs_payroll` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 24: REIMBURSEMENT MANAGEMENT
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `expense_categories` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `code` VARCHAR(30) NOT NULL UNIQUE,
    `max_limit_per_claim` DECIMAL(12,2) NULL,
    `requires_receipt` TINYINT(1) NOT NULL DEFAULT 1,
    `description` VARCHAR(255) NULL,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    CONSTRAINT `fk_expcat_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `reimbursement_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `claim_number` VARCHAR(50) NOT NULL UNIQUE,
    `employee_id` INT UNSIGNED NOT NULL,
    `expense_category_id` INT UNSIGNED NOT NULL,
    `claim_title` VARCHAR(150) NOT NULL,
    `expense_date` DATE NOT NULL,
    `amount` DECIMAL(12,2) NOT NULL,
    `approved_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `description` TEXT NOT NULL,
    `receipt_path` VARCHAR(255) NULL,
    `status` ENUM('submitted', 'manager_approved', 'finance_approved', 'rejected', 'payroll_processed', 'paid') NOT NULL DEFAULT 'submitted',
    `manager_id` INT UNSIGNED NULL,
    `manager_action_at` DATETIME NULL,
    `manager_remarks` VARCHAR(255) NULL,
    `finance_approver_id` INT UNSIGNED NULL,
    `finance_action_at` DATETIME NULL,
    `finance_remarks` VARCHAR(255) NULL,
    `payroll_run_id` INT UNSIGNED NULL,
    `paid_date` DATE NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_reimb_emp` (`employee_id`, `status`),
    CONSTRAINT `fk_reimb_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_reimb_cat` FOREIGN KEY (`expense_category_id`) REFERENCES `expense_categories` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_reimb_manager` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_reimb_finance` FOREIGN KEY (`finance_approver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_reimb_payroll` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 25: BONUS, INCENTIVE & COMMISSION MANAGEMENT
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `bonus_schemes` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(120) NOT NULL,
    `scheme_code` VARCHAR(40) NOT NULL UNIQUE,
    `scheme_type` ENUM('annual_bonus', 'performance_incentive', 'sales_commission', 'festival_bonus', 'spot_award', 'retention_bonus') NOT NULL,
    `calculation_type` ENUM('fixed_amount', 'percentage_of_basic', 'percentage_of_gross') NOT NULL DEFAULT 'fixed_amount',
    `default_value` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `description` TEXT NULL,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_bs_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `employee_incentive_entries` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `bonus_scheme_id` INT UNSIGNED NOT NULL,
    `reference_period` VARCHAR(30) NOT NULL COMMENT 'e.g. 2026-Q1, 2026-03',
    `target_achieved` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `calculated_amount` DECIMAL(12,2) NOT NULL,
    `final_amount` DECIMAL(12,2) NOT NULL,
    `notes` TEXT NULL,
    `status` ENUM('draft', 'manager_approved', 'hr_approved', 'payroll_batched', 'paid') NOT NULL DEFAULT 'draft',
    `approved_by` INT UNSIGNED NULL,
    `approved_at` DATETIME NULL,
    `payroll_run_id` INT UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_inc_emp_period` (`employee_id`, `reference_period`),
    CONSTRAINT `fk_inc_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_inc_scheme` FOREIGN KEY (`bonus_scheme_id`) REFERENCES `bonus_schemes` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_inc_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_inc_payroll` FOREIGN KEY (`payroll_run_id`) REFERENCES `payroll_runs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 27: MANAGER SELF-SERVICE (ATTENDANCE CORRECTIONS)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `attendance_corrections` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `attendance_id` INT UNSIGNED NULL,
    `attendance_date` DATE NOT NULL,
    `requested_clock_in` DATETIME NOT NULL,
    `requested_clock_out` DATETIME NOT NULL,
    `reason` TEXT NOT NULL,
    `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    `manager_id` INT UNSIGNED NULL,
    `manager_action_at` DATETIME NULL,
    `manager_remarks` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_attcorr_emp` (`employee_id`, `attendance_date`),
    CONSTRAINT `fk_attcorr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_attcorr_att` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_attcorr_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 28: PERFORMANCE MANAGEMENT SYSTEM (PMS)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `performance_cycles` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(120) NOT NULL,
    `cycle_type` ENUM('quarterly', 'half_yearly', 'annual') NOT NULL DEFAULT 'annual',
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `self_review_deadline` DATE NOT NULL,
    `manager_review_deadline` DATE NOT NULL,
    `status` ENUM('upcoming', 'active', 'evaluation', 'closed') NOT NULL DEFAULT 'upcoming',
    `description` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pcyc_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `performance_goals` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cycle_id` INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `description` TEXT NULL,
    `weightage_percent` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    `target_metric` VARCHAR(100) NULL,
    `self_rating` DECIMAL(3,2) NULL COMMENT 'Scale 1.0 to 5.0',
    `self_comments` TEXT NULL,
    `manager_rating` DECIMAL(3,2) NULL COMMENT 'Scale 1.0 to 5.0',
    `manager_comments` TEXT NULL,
    `status` ENUM('draft', 'submitted', 'reviewed') NOT NULL DEFAULT 'draft',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pgoal_cycle` FOREIGN KEY (`cycle_id`) REFERENCES `performance_cycles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pgoal_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `employee_appraisals` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `cycle_id` INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `reviewer_manager_id` INT UNSIGNED NOT NULL,
    `overall_self_score` DECIMAL(4,2) NOT NULL DEFAULT 0.00,
    `overall_manager_score` DECIMAL(4,2) NOT NULL DEFAULT 0.00,
    `final_rating_band` VARCHAR(50) NULL,
    `promotion_recommended` TINYINT(1) NOT NULL DEFAULT 0,
    `recommended_increment_percent` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    `key_strengths` TEXT NULL,
    `development_areas` TEXT NULL,
    `status` ENUM('pending_self_review', 'pending_manager_review', 'completed', 'acknowledged') NOT NULL DEFAULT 'pending_self_review',
    `completed_at` DATETIME NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_appr_cycle_emp` (`cycle_id`, `employee_id`),
    CONSTRAINT `fk_appr_cycle` FOREIGN KEY (`cycle_id`) REFERENCES `performance_cycles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_appr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_appr_mgr` FOREIGN KEY (`reviewer_manager_id`) REFERENCES `employees` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 29: TRAINING & DEVELOPMENT
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `training_programs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `course_code` VARCHAR(50) NOT NULL UNIQUE,
    `category` VARCHAR(100) NOT NULL DEFAULT 'Technical Skills',
    `trainer_name` VARCHAR(100) NULL,
    `training_type` ENUM('internal', 'external', 'online', 'workshop') NOT NULL DEFAULT 'internal',
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `total_hours` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    `max_participants` INT UNSIGNED NOT NULL DEFAULT 30,
    `location` VARCHAR(150) NOT NULL DEFAULT 'Headquarters Training Room',
    `cost_per_employee` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `description` TEXT NULL,
    `status` ENUM('scheduled', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'scheduled',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_train_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `training_participants` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `training_id` INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `nominated_by` INT UNSIGNED NULL,
    `nomination_status` ENUM('nominated', 'approved', 'attended', 'absent', 'dropped') NOT NULL DEFAULT 'nominated',
    `attendance_percent` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    `completion_status` ENUM('in_progress', 'completed', 'failed') NOT NULL DEFAULT 'in_progress',
    `score_rating` DECIMAL(4,2) NULL,
    `feedback` TEXT NULL,
    `certificate_path` VARCHAR(255) NULL,
    `completed_date` DATE NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_tp_train_emp` (`training_id`, `employee_id`),
    CONSTRAINT `fk_tp_train` FOREIGN KEY (`training_id`) REFERENCES `training_programs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tp_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tp_nominator` FOREIGN KEY (`nominated_by`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `employee_skills` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `skill_name` VARCHAR(100) NOT NULL,
    `proficiency_level` ENUM('beginner', 'intermediate', 'advanced', 'expert') NOT NULL DEFAULT 'intermediate',
    `verified_by_training_id` INT UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_es_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_es_train` FOREIGN KEY (`verified_by_training_id`) REFERENCES `training_programs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 36: COMMUNICATION & NOTIFICATION SYSTEM
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notification_templates` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `template_key` VARCHAR(60) NOT NULL UNIQUE,
    `title` VARCHAR(150) NOT NULL,
    `channel` ENUM('email', 'sms', 'whatsapp', 'in_app', 'all') NOT NULL DEFAULT 'in_app',
    `subject` VARCHAR(200) NULL,
    `body_content` TEXT NOT NULL,
    `variables` VARCHAR(255) NOT NULL DEFAULT '{{EMPLOYEE_NAME}}, {{ACTION_DATE}}, {{DETAILS}}, {{COMPANY_NAME}}',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `hr_announcements` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(180) NOT NULL,
    `content` TEXT NOT NULL,
    `target_audience` ENUM('all', 'department', 'branch', 'roles') NOT NULL DEFAULT 'all',
    `target_id` INT UNSIGNED NULL,
    `priority` ENUM('low', 'normal', 'urgent') NOT NULL DEFAULT 'normal',
    `is_published` TINYINT(1) NOT NULL DEFAULT 1,
    `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `expires_at` DATE NULL,
    `attachment_path` VARCHAR(255) NULL,
    `created_by` INT UNSIGNED NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_ann_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_ann_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `system_notifications` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `message` TEXT NOT NULL,
    `channel` ENUM('in_app', 'email', 'sms', 'whatsapp') NOT NULL DEFAULT 'in_app',
    `action_url` VARCHAR(255) NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `read_at` DATETIME NULL,
    `status` ENUM('queued', 'sent', 'delivered', 'failed') NOT NULL DEFAULT 'sent',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_sysnotif_user` (`user_id`, `is_read`),
    CONSTRAINT `fk_sysnotif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 38: HR POLICIES & KNOWLEDGE CENTER
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `company_policies` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL,
    `policy_code` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(150) NOT NULL,
    `category` ENUM('code_of_conduct', 'leave_attendance', 'it_security', 'compensation', 'health_safety', 'anti_harassment', 'general') NOT NULL DEFAULT 'general',
    `version` VARCHAR(20) NOT NULL DEFAULT '1.0',
    `effective_date` DATE NOT NULL,
    `file_path` VARCHAR(255) NULL,
    `summary` TEXT NULL,
    `content` MEDIUMTEXT NULL,
    `requires_acknowledgement` TINYINT(1) NOT NULL DEFAULT 1,
    `department_restriction_id` INT UNSIGNED NULL,
    `status` ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'published',
    `published_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pol_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pol_dept` FOREIGN KEY (`department_restriction_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `policy_acknowledgements` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `policy_id` INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `acknowledged_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_pol_emp` (`policy_id`, `employee_id`),
    CONSTRAINT `fk_pack_policy` FOREIGN KEY (`policy_id`) REFERENCES `company_policies` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pack_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- MODULE 39: EXPENSE & TRAVEL MANAGEMENT
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `travel_requests` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `request_number` VARCHAR(50) NOT NULL UNIQUE,
    `employee_id` INT UNSIGNED NOT NULL,
    `purpose` VARCHAR(150) NOT NULL,
    `travel_type` ENUM('domestic', 'international') NOT NULL DEFAULT 'domestic',
    `source_city` VARCHAR(100) NOT NULL,
    `destination_city` VARCHAR(100) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `estimated_budget` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `advance_required` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `advance_disbursed` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `notes` TEXT NULL,
    `status` ENUM('submitted', 'manager_approved', 'finance_approved', 'in_progress', 'completed', 'claims_submitted', 'settled', 'rejected') NOT NULL DEFAULT 'submitted',
    `manager_id` INT UNSIGNED NULL,
    `manager_action_at` DATETIME NULL,
    `manager_remarks` VARCHAR(255) NULL,
    `finance_id` INT UNSIGNED NULL,
    `finance_action_at` DATETIME NULL,
    `finance_remarks` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_tr_emp` (`employee_id`, `status`),
    CONSTRAINT `fk_tr_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tr_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_tr_fin` FOREIGN KEY (`finance_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `travel_expense_claims` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `travel_request_id` INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `expense_category` ENUM('flight', 'train', 'cab_transport', 'hotel_lodging', 'meals', 'client_entertainment', 'other') NOT NULL,
    `bill_date` DATE NOT NULL,
    `bill_number` VARCHAR(80) NULL,
    `amount` DECIMAL(12,2) NOT NULL,
    `approved_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `receipt_path` VARCHAR(255) NULL,
    `remarks` TEXT NULL,
    `status` ENUM('submitted', 'verified', 'approved', 'rejected') NOT NULL DEFAULT 'submitted',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_tec_req` (`travel_request_id`),
    CONSTRAINT `fk_tec_req` FOREIGN KEY (`travel_request_id`) REFERENCES `travel_requests` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_tec_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ==============================================================================
-- STEP 3: SEED ESSENTIAL BASE CONFIGURATIONS FOR NEW MODULES
-- ==============================================================================

-- 3.1 Overtime Rules
INSERT INTO `overtime_rules` (`company_id`, `name`, `rule_code`, `rate_multiplier`, `applicable_days`, `min_hours`, `max_hours_per_day`, `monthly_cap_hours`, `is_active`)
VALUES
(1, 'Standard Workday Overtime (1.5x)', 'OT-NORM-1.5', 1.50, 'workday', 1.00, 4.00, 40.00, 1),
(1, 'Weekend & Holiday Overtime (2.0x)', 'OT-HOL-2.0', 2.00, 'holiday', 2.00, 8.00, 50.00, 1)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- 3.2 Expense Categories
INSERT INTO `expense_categories` (`company_id`, `name`, `code`, `max_limit_per_claim`, `requires_receipt`, `description`, `status`)
VALUES
(1, 'Client Meals & Entertainment', 'EXP-MEAL', 250.00, 1, 'Official business meal expenses with external clients', 'active'),
(1, 'Local Conveyance & Fuel', 'EXP-TRANS', 150.00, 1, 'Local taxi, rideshare, and fuel recharges for office visits', 'active'),
(1, 'Mobile & High-Speed Internet', 'EXP-COMM', 100.00, 1, 'Work-from-home broadband and official telecom bills', 'active'),
(1, 'Books & Professional Certifications', 'EXP-CERT', 500.00, 1, 'Professional membership and training exam fee reimbursements', 'active'),
(1, 'Office Supplies & Peripherals', 'EXP-SUPPLY', 200.00, 1, 'Mouse, keyboards, cables, and home workspace accessories', 'active')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- 3.3 Bonus & Incentive Schemes
INSERT INTO `bonus_schemes` (`company_id`, `title`, `scheme_code`, `scheme_type`, `calculation_type`, `default_value`, `description`, `status`)
VALUES
(1, 'Annual Performance Incentive', 'SCH-PERF-ANN', 'performance_incentive', 'percentage_of_basic', 15.00, 'Annual performance bonus based on appraisal score rating', 'active'),
(1, 'Quarterly Sales Revenue Commission', 'SCH-SLS-COMM', 'sales_commission', 'fixed_amount', 1200.00, 'Direct incentive on exceeding quarterly team sales pipeline quota', 'active'),
(1, 'CEO Spot Excellence Award', 'SCH-SPOT-AWD', 'spot_award', 'fixed_amount', 500.00, 'Discretionary executive peer recognition for exceptional project impact', 'active'),
(1, 'Festive Holiday Bonus', 'SCH-FEST-2026', 'festival_bonus', 'percentage_of_basic', 10.00, 'Year-end company-wide holiday celebration disbursement', 'active')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 3.4 Working Day Configurations (Default: Mon-Fri Full, Sat 2nd/4th Off, Sun Off)
INSERT INTO `working_day_configurations` (`company_id`, `day_of_week`, `is_working`, `working_type`, `alternate_week_off`)
VALUES
(1, 'monday', 1, 'full_day', NULL),
(1, 'tuesday', 1, 'full_day', NULL),
(1, 'wednesday', 1, 'full_day', NULL),
(1, 'thursday', 1, 'full_day', NULL),
(1, 'friday', 1, 'full_day', NULL),
(1, 'saturday', 1, 'half_day', '2nd_4th_saturday'),
(1, 'sunday', 0, 'off', NULL)
ON DUPLICATE KEY UPDATE working_type=VALUES(working_type);

-- 3.5 Notification Templates
INSERT INTO `notification_templates` (`template_key`, `title`, `channel`, `subject`, `body_content`, `variables`, `is_active`)
VALUES
('leave_applied', 'Leave Request Submitted', 'all', 'New Leave Request from {{EMPLOYEE_NAME}}', 'Employee {{EMPLOYEE_NAME}} has submitted a leave application for {{DETAILS}} on {{ACTION_DATE}}. Please review in Manager Portal.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{ACTION_DATE}}, {{COMPANY_NAME}}', 1),
('overtime_approved', 'Overtime Approved', 'all', 'Overtime Hours Confirmed', 'Dear {{EMPLOYEE_NAME}}, your overtime claim for {{DETAILS}} has been approved and logged for payroll inclusion.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', 1),
('loan_disbursed', 'Loan Disbursement Notice', 'all', 'Salary Advance / Loan Disbursed', 'Dear {{EMPLOYEE_NAME}}, your loan application of {{DETAILS}} has been approved and scheduled for payroll deduction.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', 1),
('payroll_ready', 'Monthly Payslip Generated', 'all', 'Your Payslip is Ready for {{DETAILS}}', 'Dear {{EMPLOYEE_NAME}}, your payslip for {{DETAILS}} is now ready. Log in to your portal to inspect details and download PDF.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', 1),
('appraisal_assigned', 'Performance Appraisal Initiated', 'in_app', 'Self-Appraisal Form Available', 'Dear {{EMPLOYEE_NAME}}, the performance appraisal cycle {{DETAILS}} is now active. Please complete your self-evaluation.', '{{EMPLOYEE_NAME}}, {{DETAILS}}, {{COMPANY_NAME}}', 1)
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 3.6 Sample Company Policies
INSERT INTO `company_policies` (`company_id`, `policy_code`, `title`, `category`, `version`, `effective_date`, `summary`, `content`, `requires_acknowledgement`, `status`)
VALUES
(1, 'POL-HR-001', 'Enterprise Code of Business Conduct & Ethics', 'code_of_conduct', '2.0', '2026-01-01', 
'Governs professional standards, anti-bribery, conflict of interest, and workplace integrity.',
'<h3>1. Objective</h3><p>Infosof Technologies is committed to conducting business with highest standards of ethics, integrity, and regulatory compliance. Every employee is expected to act truthfully and respect organizational property, colleagues, and customer confidentiality.</p><h3>2. Scope & Applicability</h3><p>Applies to all full-time, part-time, and contractual staff globally.</p><h3>3. Confidentiality</h3><p>Proprietary enterprise data, trade secrets, and client repositories must never be disclosed to third parties without prior written executive authorization.</p>', 1, 'published'),

(1, 'POL-HR-002', 'Hybrid Workplace & Attendance Guidelines', 'leave_attendance', '1.5', '2026-01-01',
'Outlines core working hours (9 AM - 6 PM), biometric clock-in grace periods, and web clock-in policies.',
'<h3>1. Standard Hours</h3><p>Standard working hours are 8 operational hours per day excluding lunch break. A 15-minute grace period applies to morning clock-ins.</p><h3>2. Overtime Policy</h3><p>Overtime must be pre-approved by the reporting manager prior to execution.</p>', 1, 'published')
ON DUPLICATE KEY UPDATE title=VALUES(title);

SET FOREIGN_KEY_CHECKS = 1;
