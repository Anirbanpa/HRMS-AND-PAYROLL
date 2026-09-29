# Infosof Enterprise HRMS & Payroll Management System

A production-ready, full-stack Human Resource Management System (HRMS) built on **CodeIgniter 4** and **MySQL**. Engineered for scalable workforce operations, complete employee lifecycle management, multi-tier statutory payroll processing, biometric attendance streaming, OKR appraisals, and multi-channel notification dispatch.

---

## 🌟 Modules & Features Overview

### 1. Workforce & Core HR
- **Employee Directory & Lifecycle**: Onboarding wizard, profile management, document repository, dynamic org chart.
- **Probation & Confirmation**: Auto-enrollment, 30/60/90-day milestone reviews, confirmation or extension workflows.
- **Transfers & Promotions**: Department reassignments, designation upgrades, compensation adjustments with historical records.
- **Separation & Offboarding**: Resignations, department asset handovers, exit interviews, and automated Full & Final (FnF) settlement calculation.

### 2. Time & Attendance Register
- **Real-Time Attendance**: Web ESS clock-in/out, GPS/IP stamp capture, shift pairing, grace period monitoring, late arrivals and half-day computations.
- **Biometric Integration (Module 11)**: Hardware terminal monitoring (`BIO-GATE-01`, `BIO-GATE-02`, `BIO-FACIAL-03`), live punch stream, simulation testing, and REST API punch webhook (`POST /api/v1/attendance/punch`).
- **Shift & Roster Management**: Multi-shift scheduling, rotational rosters, shift swaps, and working calendar overrides.
- **Attendance Corrections & Waivers**: Late arrival waiver applications with supervisory review and approval routing.

### 3. Leave, Travel & Expense Management
- **Leave Management**: Leave policies, accrual rules, entitlement balances, multi-tier approval hierarchy, and calendar visualizer.
- **Travel & Expense Management (Module 39)**: Travel authorizations, multi-city itineraries, itemized expense claim filings, and finance settlement.
- **Reimbursements & Claims**: Medical, transit, utility vouchers, and receipt validation.

### 4. Payroll, Compensation & Benefits
- **Statutory Payroll Engine**: Monthly salary structures, earnings (Basic, HRA, DA, Special Allowance), deductions (PF, Professional Tax, ESI, TDS), loan recovery, and net pay computation.
- **Payslip Generator**: Printable, downloadable itemized PDF/HTML salary slips with company branding.
- **Employee Loans & Advances**: Loan applications, EMI repayment schedule generation, and automatic monthly payroll deduction.
- **Bonuses & Incentives**: Performance bonuses, festival incentives, commission structures, and bonus run approvals.

### 5. Performance, OKRs & Appraisals (Module 28)
- **Appraisal Cycles**: Multi-cycle tracking (Annual, Mid-Year, Quarterly) with review deadlines.
- **Goals & Key Results (OKRs)**: Weighted KPI allocation, milestone progress metrics, and task scoping.
- **360° Evaluation & Rating Bands**: Employee self-assessments, manager scorecards, merit rating bands, and promotion/increment recommendations.

### 6. Training & Talent Development (Module 29)
- **Programs & Calendar**: Workshop catalog, schedules, training budgets, and venue allocations.
- **Nomination & Attendance**: Employee roll-call and session tracking.
- **Skill Endorsements & Certificates**: Post-training completion scoring, auto-skill credentialing, and printable completion certificates.

### 7. Communication & Multi-Channel Alerts (Module 36)
- **Corporate Broadcasts**: Priority-flagged HR announcements with target audiences (All, Department, Branch).
- **In-App Notification Center**: Real-time notification badge, mark-all-as-read, and persistent alert delivery history.
- **Multi-Channel Dispatcher**: Pluggable notification service supporting In-App, Email (SMTP), SMS, and WhatsApp alerts with tokenized templates.

### 8. System Administration, Auditing & Backup (Module 44)
- **Role-Based Access Control (RBAC)**: Granular permission matrix across Super Admin, HR Admin, Manager, Accountant, and Employee roles.
- **Tamper-Resistant Audit Log**: Detailed activity history tracking IP addresses, user agents, actions, and record changes.
- **1-Click Database Snapshot**: Full database dump generator with automated table structure and dataset backup.
- **API & Credentials Manager**: Webhook configurations, SMTP settings, SMS gateways, and access tokens.

---

## 🚀 Quick Setup & Installation Guide

### Prerequisites
- **PHP**: `8.2` or higher (Extensions required: `mysqli`, `intl`, `mbstring`, `curl`, `json`)
- **Web Server**: Apache / Nginx or built-in PHP development server
- **Database**: MySQL `5.7+` or `8.0+` (or MariaDB `10.4+`)
- **Git** & **Composer**

---

### Step 1: Clone the Repository
```bash
git clone https://github.com/YOUR_USERNAME/YOUR_REPOSITORY.git
cd YOUR_REPOSITORY
```

### Step 2: Install Composer Dependencies
```bash
composer install
```

### Step 3: Configure Environment
Copy the environment template and configure your local settings:
```bash
cp env .env
```
Open `.env` and set your database connection and base URL:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = 127.0.0.1
database.default.database = enterprise_hrms
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

### Step 4: Import MySQL Database
Create the database and import the complete schema and seed dataset:
```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS enterprise_hrms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p enterprise_hrms < database/enterprise_hrms_full.sql
```

### Step 5: Start Development Server
```bash
php spark serve --host 0.0.0.0 --port 8080
```
Open your browser and navigate to:
**`http://localhost:8080`**

---

## 🔑 Default Demo Accounts

| Role | Username | Password | Access Level |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin` | `admin123` | Full enterprise control across all modules & settings |
| **HR Admin** | `hr_admin` | `admin123` | Workforce management, appraisals, and recruitment |
| **Manager** | `manager` | `admin123` | Direct reports approval, leave/overtime review, goal evaluations |
| **Payroll / Finance** | `accountant` | `admin123` | Payroll runs, payslip generation, expense claim settlements |
| **Employee** | `employee` | `admin123` | ESS portal, attendance, leave apply, self-assessment |

---

## 📁 Project Directory Structure

```text
├── app/
│   ├── Config/            # Application, route, filter, and database configuration
│   ├── Controllers/       # Controllers for all 44 HRMS business modules
│   ├── Database/          # Migrations and initial SQL definitions
│   ├── Filters/           # Authentication and RBAC permission guards
│   ├── Libraries/         # NotificationService and auxiliary business engines
│   ├── Models/            # Database entity models
│   └── Views/             # Responsive UI views, forms, and dashboard layouts
├── database/
│   └── enterprise_hrms_full.sql   # Complete snapshot with schema & initial demo data
├── public/                # Public document root (index.php, CSS, logos, assets)
├── writable/              # Cache, logs, uploads, and session files (git-ignored)
├── spark                  # CodeIgniter CLI tool
└── composer.json          # Dependency manifest
```

---

## 🛡️ License & Contributing
Distributed under the **MIT License**. Created for enterprise workforce administration and customizable business workflows.
