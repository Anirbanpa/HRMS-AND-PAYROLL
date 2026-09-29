-- ==============================================================================
-- PHASE 6: ENTERPRISE HRMS MODULES (RECRUITMENT, ASSETS, EXIT & F&F, TEMPLATES)
-- MySQL 5.7+ and MySQL 8.x Compatible
-- ==============================================================================

USE enterprise_hrms;

-- ------------------------------------------------------------------------------
-- 1. RECRUITMENT & APPLICANT TRACKING SYSTEM (MODULE 8)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS job_openings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    job_code VARCHAR(30) NOT NULL UNIQUE,
    department_id INT UNSIGNED NOT NULL,
    designation_id INT UNSIGNED NULL,
    vacancies INT UNSIGNED NOT NULL DEFAULT 1,
    job_type ENUM('full_time', 'part_time', 'contract', 'remote') NOT NULL DEFAULT 'full_time',
    experience_required VARCHAR(50) DEFAULT '1-3 years',
    location VARCHAR(100) DEFAULT 'Headquarters',
    min_salary DECIMAL(12,2) DEFAULT 0.00,
    max_salary DECIMAL(12,2) DEFAULT 0.00,
    description TEXT NULL,
    requirements TEXT NULL,
    status ENUM('open', 'closed', 'on_hold') NOT NULL DEFAULT 'open',
    closing_date DATE NULL,
    created_by INT UNSIGNED NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_jobs_dept FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS candidates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    job_opening_id INT UNSIGNED NOT NULL,
    candidate_code VARCHAR(30) NOT NULL UNIQUE,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NULL,
    experience_years DECIMAL(4,1) DEFAULT 0.0,
    current_company VARCHAR(150) NULL,
    current_ctc DECIMAL(12,2) DEFAULT 0.00,
    expected_ctc DECIMAL(12,2) DEFAULT 0.00,
    notice_period_days INT DEFAULT 30,
    resume_path VARCHAR(255) NULL,
    stage ENUM('applied', 'screening', 'interview', 'offered', 'hired', 'rejected') NOT NULL DEFAULT 'applied',
    scorecard_rating INT DEFAULT 0, -- 1 to 5
    interviewer_feedback TEXT NULL,
    hired_as_employee_id INT UNSIGNED NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_cand_job FOREIGN KEY (job_opening_id) REFERENCES job_openings(id) ON DELETE CASCADE,
    CONSTRAINT fk_cand_emp FOREIGN KEY (hired_as_employee_id) REFERENCES employees(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 2. EMPLOYEE ASSET MANAGEMENT (MODULE 30)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS assets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    asset_code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    category ENUM('laptop', 'desktop', 'monitor', 'mobile', 'access_card', 'peripherals', 'furniture') NOT NULL DEFAULT 'laptop',
    brand VARCHAR(100) NULL,
    model VARCHAR(100) NULL,
    serial_number VARCHAR(100) NOT NULL UNIQUE,
    purchase_date DATE NULL,
    purchase_cost DECIMAL(12,2) DEFAULT 0.00,
    warranty_expiry DATE NULL,
    current_employee_id INT UNSIGNED NULL,
    status ENUM('available', 'allocated', 'maintenance', 'retired') NOT NULL DEFAULT 'available',
    condition_status ENUM('brand_new', 'good', 'fair', 'damaged') NOT NULL DEFAULT 'good',
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_asset_emp FOREIGN KEY (current_employee_id) REFERENCES employees(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS asset_allocations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    asset_id INT UNSIGNED NOT NULL,
    employee_id INT UNSIGNED NOT NULL,
    allocated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    returned_at DATETIME NULL,
    condition_on_allocation VARCHAR(100) DEFAULT 'Good working condition',
    condition_on_return VARCHAR(100) NULL,
    allocated_by INT UNSIGNED NULL,
    notes TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_alloc_asset FOREIGN KEY (asset_id) REFERENCES assets(id) ON DELETE CASCADE,
    CONSTRAINT fk_alloc_emp FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 3. EMPLOYEE SEPARATION & EXIT CLEARANCE & F&F SETTLEMENT (MODULES 34 & 35)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS resignations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_id INT UNSIGNED NOT NULL,
    resignation_date DATE NOT NULL,
    requested_last_working_day DATE NOT NULL,
    approved_last_working_day DATE NULL,
    reason TEXT NOT NULL,
    status ENUM('submitted', 'manager_approved', 'hr_approved', 'in_clearance', 'settled', 'rejected') NOT NULL DEFAULT 'submitted',
    approver_remarks TEXT NULL,
    notice_period_shortfall_days INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_resig_emp FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS exit_clearances (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resignation_id INT UNSIGNED NOT NULL,
    department_type ENUM('IT', 'Finance', 'HR', 'Admin') NOT NULL,
    status ENUM('pending', 'cleared', 'flagged') NOT NULL DEFAULT 'pending',
    cleared_by_user_id INT UNSIGNED NULL,
    cleared_at DATETIME NULL,
    remarks TEXT NULL,
    dues_or_recoveries DECIMAL(12,2) DEFAULT 0.00,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_clear_resig FOREIGN KEY (resignation_id) REFERENCES resignations(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS fnf_settlements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resignation_id INT UNSIGNED NOT NULL UNIQUE,
    employee_id INT UNSIGNED NOT NULL,
    settlement_date DATE NOT NULL,
    unpaid_salary_days INT DEFAULT 0,
    unpaid_salary_amount DECIMAL(12,2) DEFAULT 0.00,
    leave_encashment_days INT DEFAULT 0,
    leave_encashment_amount DECIMAL(12,2) DEFAULT 0.00,
    gratuity_amount DECIMAL(12,2) DEFAULT 0.00,
    bonus_amount DECIMAL(12,2) DEFAULT 0.00,
    total_earnings DECIMAL(12,2) DEFAULT 0.00,
    notice_shortfall_recovery DECIMAL(12,2) DEFAULT 0.00,
    asset_damage_deduction DECIMAL(12,2) DEFAULT 0.00,
    statutory_tax_deduction DECIMAL(12,2) DEFAULT 0.00,
    total_deductions DECIMAL(12,2) DEFAULT 0.00,
    net_payable_amount DECIMAL(12,2) DEFAULT 0.00,
    payment_mode ENUM('bank_transfer', 'cheque', 'neft') DEFAULT 'bank_transfer',
    payment_reference VARCHAR(100) NULL,
    settlement_status ENUM('draft', 'calculated', 'approved', 'disbursed') NOT NULL DEFAULT 'draft',
    approved_by INT UNSIGNED NULL,
    remarks TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_fnf_resig FOREIGN KEY (resignation_id) REFERENCES resignations(id) ON DELETE CASCADE,
    CONSTRAINT fk_fnf_emp FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- 4. DOCUMENT TEMPLATES & GENERATION SYSTEM (MODULES 37 & 38)
-- ------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS document_templates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    category ENUM('offer_letter', 'appointment_letter', 'experience_certificate', 'relieving_letter', 'increment_letter') NOT NULL,
    subject VARCHAR(200) NOT NULL,
    body_content MEDIUMTEXT NOT NULL,
    available_tokens VARCHAR(255) DEFAULT '{{EMPLOYEE_NAME}}, {{EMPLOYEE_CODE}}, {{DESIGNATION}}, {{DEPARTMENT}}, {{JOIN_DATE}}, {{GROSS_SALARY}}, {{COMPANY_NAME}}, {{TODAY_DATE}}',
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------------------------
-- SEED ENTERPRISE DEMO DATA FOR NEW MODULES
-- ------------------------------------------------------------------------------

-- Seed Job Openings
INSERT INTO job_openings (title, job_code, department_id, designation_id, vacancies, job_type, experience_required, location, min_salary, max_salary, description, status)
VALUES
('Senior Full-Stack Engineer', 'JOB-2026-001', 1, 1, 2, 'full_time', '4-7 years', 'San Francisco HQ', 95000.00, 130000.00, 'Responsible for architecting scalable cloud-native microservices and responsive web platforms.', 'open'),
('HR Business Partner', 'JOB-2026-002', 2, 3, 1, 'full_time', '3-5 years', 'San Francisco HQ', 70000.00, 90000.00, 'Lead talent acquisition, employee relations, and policy compliance initiatives.', 'open'),
('Financial Planning Analyst', 'JOB-2026-003', 3, 5, 1, 'full_time', '2-4 years', 'London Branch', 65000.00, 85000.00, 'Perform corporate budgeting, variance analysis, and statutory tax modeling.', 'open')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- Seed Candidates
INSERT INTO candidates (job_opening_id, candidate_code, full_name, email, phone, experience_years, current_company, current_ctc, expected_ctc, notice_period_days, stage, scorecard_rating, interviewer_feedback)
VALUES
(1, 'CAND-001', 'Arjun Mehta', 'arjun.mehta@example.com', '+1-555-0199', 5.5, 'CloudTech Systems', 92000.00, 115000.00, 30, 'interview', 4, 'Solid architectural knowledge in PHP, React, and MySQL. Excellent communication.'),
(1, 'CAND-002', 'Elena Rostova', 'elena.rostova@example.com', '+1-555-0245', 6.0, 'Global Software Ltd', 98000.00, 120000.00, 15, 'offered', 5, 'Exceptional problem solver, strong system design background. Offer issued with ₹120k base.'),
(2, 'CAND-003', 'Liam Chen', 'liam.chen@example.com', '+1-555-0377', 3.2, 'Apex Recruiting', 68000.00, 78000.00, 30, 'screening', 3, 'Good HR operations and compliance awareness. Scheduling second-round interview.')
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name);

-- Seed Assets
INSERT INTO assets (asset_code, name, category, brand, model, serial_number, purchase_date, purchase_cost, warranty_expiry, current_employee_id, status, condition_status)
VALUES
('AST-LAP-001', 'MacBook Pro 16" M3 Max', 'laptop', 'Apple', 'MacBook Pro 16', 'SN-APL-998811', '2025-01-15', 3200.00, '2028-01-15', 1, 'allocated', 'brand_new'),
('AST-LAP-002', 'ThinkPad X1 Carbon Gen 11', 'laptop', 'Lenovo', 'X1 Carbon', 'SN-LNV-445522', '2025-03-10', 2100.00, '2028-03-10', 2, 'allocated', 'good'),
('AST-LAP-003', 'Dell XPS 15 9530', 'laptop', 'Dell', 'XPS 15', 'SN-DEL-773311', '2025-04-20', 2400.00, '2028-04-20', 3, 'allocated', 'good'),
('AST-MON-001', 'Dell UltraSharp 27" 4K', 'monitor', 'Dell', 'U2723QE', 'SN-DEL-MN0099', '2025-02-01', 650.00, '2028-02-01', 1, 'allocated', 'good'),
('AST-LAP-004', 'MacBook Air 15" M2', 'laptop', 'Apple', 'MacBook Air 15', 'SN-APL-882200', '2025-05-12', 1499.00, '2027-05-12', NULL, 'available', 'brand_new'),
('AST-SEC-001', 'YubiKey 5C NFC Security Key', 'access_card', 'Yubico', '5C NFC', 'SN-YUB-001122', '2025-01-10', 55.00, '2030-01-10', 1, 'allocated', 'good')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Seed Asset Allocations
INSERT INTO asset_allocations (asset_id, employee_id, allocated_at, condition_on_allocation, notes)
VALUES
(1, 1, '2025-01-16 10:00:00', 'Brand new in box with charger and thunderbolt cable', 'Assigned on employee onboarding'),
(2, 2, '2025-03-11 09:30:00', 'Excellent condition', 'Standard HR workstation issuance'),
(3, 3, '2025-04-21 10:15:00', 'Good condition', 'Engineering lead hardware allocation'),
(4, 1, '2025-02-02 11:00:00', 'Brand new dual-display setup', 'Desk monitor allocation'),
(6, 1, '2025-01-16 10:05:00', 'Pre-configured hardware token', 'MFA Hardware key')
ON DUPLICATE KEY UPDATE notes=VALUES(notes);

-- Seed Document Templates
INSERT INTO document_templates (template_code, name, category, subject, body_content)
VALUES
('TPL_OFFER_LETTER', 'Offer Letter', 'offer_letter', 'Offer of Employment at Infosof Technologies - {{EMPLOYEE_NAME}}', 
'<h3>INFOSOF TECHNOLOGIES</h3>
<p>Date: <strong>{{TODAY_DATE}}</strong></p>
<p>Dear <strong>{{EMPLOYEE_NAME}}</strong>,</p>
<p>We are delighted to extend you an offer of employment for the position of <strong>{{DESIGNATION}}</strong> within our <strong>{{DEPARTMENT}}</strong> department at Infosof Technologies.</p>
<p>Your joining date is scheduled for <strong>{{JOIN_DATE}}</strong>. Your initial compensation package will be an annual gross salary of <strong>{{GROSS_SALARY}}</strong>, payable monthly subject to statutory taxes and deductions.</p>
<p>Please review and sign this offer letter within 5 business days to confirm your acceptance.</p>
<br>
<p>Sincerely,</p>
<p><strong>Talent Acquisition & People Operations</strong><br>Infosof Technologies</p>'),

('TPL_EXPERIENCE_LETTER', 'Experience Letter', 'experience_certificate', 'Experience Letter & Certificate of Service - {{EMPLOYEE_NAME}}',
'<h3>TO WHOMSOEVER IT MAY CONCERN</h3>
<p>Date: <strong>{{TODAY_DATE}}</strong></p>
<p>This is to certify that <strong>{{EMPLOYEE_NAME}}</strong> (Employee Code: <strong>{{EMPLOYEE_CODE}}</strong>) was employed with <strong>Infosof Technologies</strong> as a <strong>{{DESIGNATION}}</strong> in the <strong>{{DEPARTMENT}}</strong> department from <strong>{{JOIN_DATE}}</strong> to <strong>{{TODAY_DATE}}</strong>.</p>
<p>During their tenure with us, they demonstrated exceptional professionalism, dedication, and technical competence. Their conduct was exemplary and we wish them every success in their future endeavors.</p>
<br>
<p>For <strong>Infosof Technologies</strong>,</p>
<p><strong>Director of Human Resources</strong><br>Infosof Technologies</p>'),

('TPL_INCREMENT_LETTER', 'Increment Letter', 'increment_letter', 'Annual Compensation Increment & Appraisal - {{EMPLOYEE_NAME}}',
'<h3>INFOSOF TECHNOLOGIES</h3>
<p>Date: <strong>{{TODAY_DATE}}</strong></p>
<p>Dear <strong>{{EMPLOYEE_NAME}}</strong> (Code: <strong>{{EMPLOYEE_CODE}}</strong>),</p>
<p>In recognition of your outstanding contributions and performance in the <strong>{{DEPARTMENT}}</strong> department as <strong>{{DESIGNATION}}</strong>, management is pleased to announce a revision of your compensation.</p>
<p>Effective from the current pay cycle, your revised annual gross compensation will be <strong>{{GROSS_SALARY}}</strong>. All other terms and conditions of your employment contract remain unchanged.</p>
<p>We appreciate your dedication and look forward to your continued impact.</p>
<br>
<p>Warm regards,</p>
<p><strong>Chief Executive Officer & Head of HR</strong><br>Infosof Technologies</p>')
ON DUPLICATE KEY UPDATE name=VALUES(name), body_content=VALUES(body_content), subject=VALUES(subject);
