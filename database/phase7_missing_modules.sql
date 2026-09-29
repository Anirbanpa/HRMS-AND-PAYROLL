-- ==============================================================================
-- Enterprise HRMS & Payroll Management System
-- Schema Upgrade: Modules 16, 31, 32, 33
-- 16. Late Coming & Early Leaving Management
-- 31. Employee Transfer & Promotion
-- 32. Confirmation & Probation Management
-- 33. Employee Warning & Disciplinary Records
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------------------------
-- 1. ALTER ATTENDANCE TABLE (Module 16)
-- ------------------------------------------------------------------------------
ALTER TABLE `attendance`
    ADD COLUMN `late_waived` TINYINT(1) NOT NULL DEFAULT 0 AFTER `late_minutes`,
    ADD COLUMN `early_exit_waived` TINYINT(1) NOT NULL DEFAULT 0 AFTER `early_leaving_minutes`,
    ADD COLUMN `waived_by` INT UNSIGNED NULL AFTER `early_exit_waived`,
    ADD COLUMN `waived_reason` VARCHAR(255) NULL AFTER `waived_by`,
    ADD COLUMN `waived_at` DATETIME NULL AFTER `waived_reason`;

-- ------------------------------------------------------------------------------
-- 2. CREATE TABLE: late_early_policies (Module 16)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `late_early_policies` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `company_id` INT UNSIGNED NOT NULL DEFAULT 1,
    `name` VARCHAR(100) NOT NULL,
    `policy_code` VARCHAR(30) NOT NULL UNIQUE,
    `grace_period_mins` INT UNSIGNED NOT NULL DEFAULT 15,
    `early_exit_tolerance_mins` INT UNSIGNED NOT NULL DEFAULT 15,
    `max_monthly_late_count` INT UNSIGNED NOT NULL DEFAULT 3,
    `deduction_rule` ENUM('none', 'quarter_day', 'half_day', 'full_day', 'hourly_rate') NOT NULL DEFAULT 'half_day',
    `deduction_rate` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_lep_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 3. CREATE TABLE: attendance_time_waivers (Module 16)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `attendance_time_waivers` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `attendance_id` INT UNSIGNED NOT NULL,
    `employee_id` INT UNSIGNED NOT NULL,
    `waiver_type` ENUM('late_arrival', 'early_departure', 'both') NOT NULL DEFAULT 'late_arrival',
    `waiver_date` DATE NOT NULL,
    `minutes_recorded` INT NOT NULL DEFAULT 0,
    `reason` TEXT NOT NULL,
    `status` ENUM('pending', 'manager_approved', 'hr_approved', 'rejected') NOT NULL DEFAULT 'pending',
    `manager_id` INT UNSIGNED NULL,
    `manager_action_at` DATETIME NULL,
    `manager_remarks` VARCHAR(255) NULL,
    `hr_id` INT UNSIGNED NULL,
    `hr_action_at` DATETIME NULL,
    `hr_remarks` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_atw_att` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_atw_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_atw_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_atw_hr` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 4. CREATE TABLE: employee_transfers_promotions (Module 31)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `employee_transfers_promotions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `request_number` VARCHAR(30) NOT NULL UNIQUE,
    `employee_id` INT UNSIGNED NOT NULL,
    `movement_type` ENUM('transfer', 'promotion', 'transfer_and_promotion', 'redesignation') NOT NULL,
    `effective_date` DATE NOT NULL,
    `from_branch_id` INT UNSIGNED NULL,
    `to_branch_id` INT UNSIGNED NULL,
    `from_department_id` INT UNSIGNED NULL,
    `to_department_id` INT UNSIGNED NULL,
    `from_designation_id` INT UNSIGNED NULL,
    `to_designation_id` INT UNSIGNED NULL,
    `from_pay_grade_id` INT UNSIGNED NULL,
    `to_pay_grade_id` INT UNSIGNED NULL,
    `from_reporting_to` INT UNSIGNED NULL,
    `to_reporting_to` INT UNSIGNED NULL,
    `current_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `revised_salary` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `reason` TEXT NOT NULL,
    `remarks` VARCHAR(255) NULL,
    `status` ENUM('draft', 'submitted', 'manager_endorsed', 'approved', 'rejected', 'implemented') NOT NULL DEFAULT 'submitted',
    `requested_by` INT UNSIGNED NULL,
    `approved_by` INT UNSIGNED NULL,
    `approved_at` DATETIME NULL,
    `implemented_at` DATETIME NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_etp_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_etp_fbr` FOREIGN KEY (`from_branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_tbr` FOREIGN KEY (`to_branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_fdept` FOREIGN KEY (`from_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_tdept` FOREIGN KEY (`to_department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_fdes` FOREIGN KEY (`from_designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_tdes` FOREIGN KEY (`to_designation_id`) REFERENCES `designations` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_fpg` FOREIGN KEY (`from_pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_tpg` FOREIGN KEY (`to_pay_grade_id`) REFERENCES `pay_grades` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_req` FOREIGN KEY (`requested_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_etp_app` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 5. CREATE TABLE: probation_assessments (Module 32)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `probation_assessments` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `employee_id` INT UNSIGNED NOT NULL,
    `joining_date` DATE NOT NULL,
    `initial_probation_end_date` DATE NOT NULL,
    `current_probation_end_date` DATE NOT NULL,
    `assessment_status` ENUM('due', 'under_review', 'confirmed', 'extended', 'terminated') NOT NULL DEFAULT 'due',
    `manager_id` INT UNSIGNED NULL,
    `manager_rating` TINYINT UNSIGNED NULL COMMENT '1 to 5',
    `technical_competence_rating` TINYINT UNSIGNED NULL,
    `punctuality_attendance_rating` TINYINT UNSIGNED NULL,
    `teamwork_culture_rating` TINYINT UNSIGNED NULL,
    `manager_feedback` TEXT NULL,
    `manager_recommendation` ENUM('confirm', 'extend_probation', 'terminate') NULL,
    `manager_submitted_at` DATETIME NULL,
    `extension_months` INT UNSIGNED NULL DEFAULT 0,
    `extended_until` DATE NULL,
    `extension_reason` TEXT NULL,
    `confirmation_date` DATE NULL,
    `hr_id` INT UNSIGNED NULL,
    `hr_decision` ENUM('confirmed', 'extended', 'terminated') NULL,
    `hr_remarks` TEXT NULL,
    `hr_action_at` DATETIME NULL,
    `letter_generated` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pa_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_pa_mgr` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_pa_hr` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 6. CREATE TABLE: disciplinary_actions (Module 33)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `disciplinary_actions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `case_number` VARCHAR(30) NOT NULL UNIQUE,
    `employee_id` INT UNSIGNED NOT NULL,
    `incident_date` DATE NOT NULL,
    `action_type` ENUM('verbal_warning', 'written_warning', 'final_warning', 'pip', 'suspension', 'demotion', 'termination') NOT NULL,
    `severity_level` ENUM('minor', 'moderate', 'severe', 'critical') NOT NULL DEFAULT 'minor',
    `title` VARCHAR(150) NOT NULL,
    `description` TEXT NOT NULL,
    `action_taken` TEXT NOT NULL,
    `pip_start_date` DATE NULL,
    `pip_end_date` DATE NULL,
    `suspension_days` INT UNSIGNED NULL,
    `attachment_path` VARCHAR(255) NULL,
    `status` ENUM('draft', 'issued', 'acknowledged', 'appealed', 'closed', 'revoked') NOT NULL DEFAULT 'issued',
    `employee_explanation` TEXT NULL,
    `employee_acknowledged_at` DATETIME NULL,
    `appeal_notes` TEXT NULL,
    `closure_notes` TEXT NULL,
    `closed_at` DATETIME NULL,
    `is_confidential` TINYINT(1) NOT NULL DEFAULT 1,
    `issued_by` INT UNSIGNED NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_da_emp` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_da_usr` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 7. SEED INITIAL STANDARD POLICIES & DEMO RECORDS
-- ------------------------------------------------------------------------------
INSERT IGNORE INTO `late_early_policies` (`id`, `company_id`, `name`, `policy_code`, `grace_period_mins`, `early_exit_tolerance_mins`, `max_monthly_late_count`, `deduction_rule`, `deduction_rate`, `is_active`)
VALUES
(1, 1, 'Standard Enterprise Attendance Policy', 'LE-POL-STD', 15, 15, 3, 'half_day', 0.50, 1),
(2, 1, 'Executive Strict Punch Policy', 'LE-POL-EXEC', 10, 10, 2, 'quarter_day', 0.25, 1);

SET FOREIGN_KEY_CHECKS = 1;
