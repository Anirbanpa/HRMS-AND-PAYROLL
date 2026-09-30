<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle ?? 'Enterprise HRMS & Payroll') ?> | Infosof Technologies</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/flatpickr/flatpickr.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/hrms.css') ?>">
  <meta name="color-scheme" content="light dark">
  <script>
    (function() {
      try {
        const savedTheme = localStorage.getItem('hrms-theme');
        const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme ? savedTheme : (systemPrefersDark ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
      } catch (e) {}
    })();
  </script>
</head>
<body>
<div class="app-container">
  <!-- SIDEBAR -->
  <aside class="app-sidebar" id="appSidebar">
    <div class="sidebar-header">
      <div class="brand-icon" style="background: transparent; box-shadow: none; padding: 0; width: 44px; height: 44px;">
        <img src="<?= base_url('assets/images/infosof-logo.png') ?>" alt="Infosof Logo" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 2px solid var(--color-beige); box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
      </div>
      <div class="brand-text">
        <h1>Infosof HRMS</h1>
        <span>Technologies</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      <?php
      $can = function(string $perm) use ($currentRoleSlug, $userPermissions): bool {
          if ($currentRoleSlug === 'super_admin') {
              return true;
          }
          return in_array($perm, $userPermissions ?? [], true);
      };
      ?>
      <!-- ==========================================
           1. HR MANAGEMENT
           ========================================== -->
      <div class="nav-section-title">1. HR Management</div>
      <a href="<?= site_url('dashboard') ?>" id="navDashboard" class="nav-item <?= (current_url() == site_url('dashboard')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
        <span>Dashboard</span>
      </a>

      <?php if ($can('employee.view')): ?>
      <a href="<?= site_url('employees') ?>" id="navEmployees" class="nav-item <?= (strpos(current_url(), 'employees') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span>Employee Directory</span>
      </a>
      <?php endif; ?>

      <?php if ($can('employee.create')): ?>
      <a href="<?= site_url('recruitment') ?>" id="navRecruitment" class="nav-item <?= (strpos(current_url(), 'recruitment') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
        <span>Recruitment &amp; ATS</span>
      </a>
      <?php endif; ?>

      <?php if ($can('employee.edit')): ?>
      <a href="<?= site_url('career-movements') ?>" id="navCareerMovements" class="nav-item <?= (strpos(current_url(), 'career-movements') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 3h5v5"/><path d="M4 20L21 3"/><path d="M21 16v5h-5"/><path d="M15 15l6 6"/><path d="M4 4l5 5"/></svg>
        <span>Transfers &amp; Promotions</span>
      </a>

      <a href="<?= site_url('probation') ?>" id="navProbation" class="nav-item <?= (strpos(current_url(), 'probation') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
        <span>Probation &amp; Confirmation</span>
      </a>
      <?php endif; ?>

      <?php if ($can('department.manage') || $can('designation.manage')): ?>
      <a href="<?= site_url('departments') ?>" id="navDepartments" class="nav-item <?= (strpos(current_url(), 'departments') !== false || strpos(current_url(), 'designations') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
        <span>Departments</span>
      </a>
      <?php endif; ?>

      <?php if ($currentRoleSlug === 'manager' || $currentRoleSlug === 'super_admin' || $can('leave.approve')): ?>
      <a href="<?= site_url('manager') ?>" id="navManager" class="nav-item <?= (strpos(current_url(), 'manager') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        <span>Manager Portal (MSS)</span>
      </a>
      <?php endif; ?>

      <a href="<?= site_url('performance') ?>" id="navPerformance" class="nav-item <?= (strpos(current_url(), 'performance') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="m10 15 5-3-5-3v6Z"/></svg>
        <span>Performance &amp; OKRs</span>
      </a>

      <a href="<?= site_url('training') ?>" id="navTraining" class="nav-item <?= (strpos(current_url(), 'training') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        <span>Training &amp; Skills</span>
      </a>

      <?php if ($can('employee.edit')): ?>
      <a href="<?= site_url('disciplinary') ?>" id="navDisciplinary" class="nav-item <?= (strpos(current_url(), 'disciplinary') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <span>Disciplinary Records</span>
      </a>
      <?php endif; ?>

      <?php if (in_array($currentRoleSlug, ['super_admin', 'hr_admin', 'payroll_manager']) || $can('payroll.process')): ?>
      <a href="<?= site_url('separation') ?>" id="navSeparation" class="nav-item <?= (strpos(current_url(), 'separation') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
        <span>Separation &amp; F&amp;F</span>
      </a>
      <?php endif; ?>

      <!-- ==========================================
           2. ATTENDANCE & OPERATIONS
           ========================================== -->
      <div class="nav-section-title">2. Attendance &amp; Operations</div>

      <?php if ($can('attendance.view')): ?>
      <a href="<?= site_url('attendance') ?>" id="navAttendance" class="nav-item <?= (strpos(current_url(), 'attendance') !== false && strpos(current_url(), 'late-early') === false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span>Attendance &amp; Clock</span>
      </a>

      <a href="<?= site_url('attendance/late-early') ?>" id="navLateEarly" class="nav-item <?= (strpos(current_url(), 'attendance/late-early') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 8 14"/><path d="m15 15 3 3"/></svg>
        <span>Late &amp; Early Tracking</span>
      </a>
      <?php endif; ?>

      <?php if ($can('attendance.manage')): ?>
      <a href="<?= site_url('shifts') ?>" id="navShifts" class="nav-item <?= (strpos(current_url(), 'shifts') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><polyline points="12 14 12 17 14 17"/></svg>
        <span>Shifts &amp; Rota</span>
      </a>
      <?php endif; ?>

      <a href="<?= site_url('holidays') ?>" id="navHolidays" class="nav-item <?= (strpos(current_url(), 'holidays') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
        <span>Holiday Calendar</span>
      </a>

      <?php if ($can('leave.approve') || $can('leave.apply')): ?>
      <a href="<?= site_url('leaves') ?>" id="navLeaves" class="nav-item <?= (strpos(current_url(), 'leaves') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        <span><?= $can('leave.approve') ? 'Leave Approvals' : 'My Leaves &amp; Apply' ?></span>
      </a>
      <?php endif; ?>

      <?php if ($can('attendance.view') || $can('payroll.view')): ?>
      <a href="<?= site_url('overtime') ?>" id="navOvertime" class="nav-item <?= (strpos(current_url(), 'overtime') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 10"/><path d="M12 2v2"/><path d="M12 20v2"/></svg>
        <span>Overtime Claims</span>
      </a>
      <?php endif; ?>


      <a href="<?= site_url('communication') ?>" id="navCommunication" class="nav-item <?= (strpos(current_url(), 'communication') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
        <span>Announcements &amp; Comms</span>
      </a>

      <!-- ==========================================
           3. PAYROLL & FINANCE
           ========================================== -->
      <div class="nav-section-title">3. Payroll &amp; Finance</div>

      <?php if ($can('payroll.view')): ?>
      <a href="<?= site_url('payroll') ?>" id="navPayroll" class="nav-item <?= (strpos(current_url(), 'payroll') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
        <span>Monthly Payroll</span>
      </a>
      <?php endif; ?>

      <a href="<?= site_url('loans') ?>" id="navLoans" class="nav-item <?= (strpos(current_url(), 'loans') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
        <span><?= ($can('payroll.view')) ? 'Loans &amp; Advances' : 'My Loans &amp; Advances' ?></span>
      </a>

      <a href="<?= site_url('reimbursements') ?>" id="navReimbursements" class="nav-item <?= (strpos(current_url(), 'reimbursements') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
        <span><?= ($can('payroll.view') || $currentRoleSlug === 'manager') ? 'Reimbursements' : 'My Claims &amp; Reimbursements' ?></span>
      </a>

      <?php if ($can('payroll.process')): ?>
      <a href="<?= site_url('bonuses') ?>" id="navBonuses" class="nav-item <?= (strpos(current_url(), 'bonuses') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <span>Bonuses &amp; Incentives</span>
      </a>
      <?php endif; ?>

      <a href="<?= site_url('travel') ?>" id="navPayrollTravel" class="nav-item <?= (strpos(current_url(), 'travel') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/></svg>
        <span>Travel &amp; Expense</span>
      </a>

      <!-- ==========================================
           4. ASSET & ADMINISTRATION
           ========================================== -->
      <div class="nav-section-title">4. Asset &amp; Administration</div>

      <?php if ($can('company.manage')): ?>
      <a href="<?= site_url('asset-management') ?>" id="navAssets" class="nav-item <?= (strpos(current_url(), 'asset-management') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
        <span>Asset Management</span>
      </a>
      <?php endif; ?>

      <a href="<?= site_url('policies') ?>" id="navPolicies" class="nav-item <?= (strpos(current_url(), 'policies') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10M6 14h10"/></svg>
        <span>Policies &amp; Circulars</span>
      </a>

      <!-- ==========================================
           5. REPORTS & TOOLS
           ========================================== -->
      <?php if ($can('reports.view') || ($can('employee.view') && in_array($currentRoleSlug, ['super_admin', 'hr_admin', 'hr_executive'])) || $can('company.manage')): ?>
      <div class="nav-section-title">5. Reports &amp; Tools</div>

      <?php if ($can('reports.view')): ?>
      <a href="<?= site_url('reports') ?>" id="navReports" class="nav-item <?= (strpos(current_url(), 'reports') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        <span>Reports &amp; Exports</span>
      </a>
      <?php endif; ?>

      <?php if ($can('employee.view') && in_array($currentRoleSlug, ['super_admin', 'hr_admin', 'hr_executive'])): ?>
      <a href="<?= site_url('templates') ?>" id="navTemplates" class="nav-item <?= (strpos(current_url(), 'templates') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
        <span>Document Templates</span>
      </a>
      <?php endif; ?>
      <?php endif; ?>

      <!-- ==========================================
           6. ENTERPRISE SETUP
           ========================================== -->
      <div class="nav-section-title">6. Enterprise Setup</div>

      <?php if ($can('company.manage')): ?>
      <a href="<?= site_url('organization') ?>" id="navOrganization" class="nav-item <?= (strpos(current_url(), 'organization') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
        <span>Organization &amp; Branches</span>
      </a>
      <?php endif; ?>

      <?php if ($can('roles.manage')): ?>
      <a href="<?= site_url('roles') ?>" id="navRoles" class="nav-item <?= (strpos(current_url(), 'roles') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        <span>Roles &amp; RBAC Access</span>
      </a>
      <?php endif; ?>

      <?php if ($can('audit.view')): ?>
      <a href="<?= site_url('audit') ?>" id="navAudit" class="nav-item <?= (strpos(current_url(), 'audit') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/><path d="m9 12 2 2 4-4"/></svg>
        <span>Audit Trail &amp; Security</span>
      </a>
      <?php endif; ?>

      <?php if ($can('company.manage')): ?>
      <a href="<?= site_url('settings/integrations') ?>" id="navIntegrations" class="nav-item <?= (strpos(current_url(), 'settings/integrations') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        <span>API Integrations</span>
      </a>
      <a href="<?= site_url('settings/backup') ?>" id="navEnterpriseBackup" class="nav-item <?= (strpos(current_url(), 'settings/backup') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
        <span>Database Backup</span>
      </a>
      <?php endif; ?>

      <a href="<?= site_url('profile') ?>" id="navProfile" class="nav-item <?= (strpos(current_url(), 'profile') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        <span>Security &amp; Profile</span>
      </a>
    </nav>

    <div class="sidebar-footer">
      <a href="<?= site_url('profile') ?>" class="user-badge" style="text-decoration: none; display: flex;" title="View My Profile">
        <div class="avatar-sm">
          <?= esc(substr($currentUser['full_name'] ?? 'AD', 0, 2)) ?>
        </div>
        <div class="user-info-text">
          <div class="user-name"><?= esc($currentUser['full_name'] ?? 'Administrator') ?></div>
          <div class="user-role"><?= esc($currentUser['role_name'] ?? 'Super Admin') ?></div>
        </div>
      </a>
    </div>
  </aside>

  <!-- MAIN WRAPPER -->
  <div class="app-main">
    <!-- TOPBAR -->
    <header class="app-topbar">
      <div class="topbar-left">
        <h2 class="page-heading"><?= esc($pageTitle ?? 'Enterprise HRMS') ?></h2>
      </div>

      <div class="topbar-right">
        <!-- Interactive Role Switcher Demo Pills -->
        <div class="role-pills" title="Quick Role Switcher for Testing Predefined Tiers">
          <span style="font-size: 11px; font-weight: 700; color: #64748b; padding-left: 6px;">DEMO ROLE:</span>
          <a href="<?= site_url('auth/demo/super_admin') ?>" class="role-pill <?= ($currentRoleSlug === 'super_admin') ? 'active' : '' ?>" id="switchSuperAdmin">Super Admin</a>
          <a href="<?= site_url('auth/demo/hr_admin') ?>" class="role-pill <?= ($currentRoleSlug === 'hr_admin') ? 'active' : '' ?>" id="switchHrAdmin">HR Admin</a>
          <a href="<?= site_url('auth/demo/hr_executive') ?>" class="role-pill <?= ($currentRoleSlug === 'hr_executive') ? 'active' : '' ?>" id="switchHrExec">HR Exec</a>
          <a href="<?= site_url('auth/demo/payroll_manager') ?>" class="role-pill <?= ($currentRoleSlug === 'payroll_manager') ? 'active' : '' ?>" id="switchPayroll">Payroll</a>
          <a href="<?= site_url('auth/demo/accountant') ?>" class="role-pill <?= ($currentRoleSlug === 'accountant') ? 'active' : '' ?>" id="switchAccountant">Accountant</a>
          <a href="<?= site_url('auth/demo/manager') ?>" class="role-pill <?= ($currentRoleSlug === 'manager') ? 'active' : '' ?>" id="switchManager">Manager</a>
          <a href="<?= site_url('auth/demo/employee') ?>" class="role-pill <?= ($currentRoleSlug === 'employee') ? 'active' : '' ?>" id="switchEmployee">Employee</a>
        </div>

        <!-- Notifications Center Dropdown -->
        <div class="notif-wrapper" style="position: relative;">
          <button type="button" id="btnNotifBell" class="btn-theme-toggle" style="position: relative;" aria-label="Notifications" title="System Notifications" onclick="var d=document.getElementById('notifDropdown'); d.style.display=(d.style.display==='none'||d.style.display==='')?'block':'none';">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <?php if (!empty($unreadNotifCount)): ?>
              <span style="position: absolute; top: -3px; right: -3px; background: var(--color-rose-500); color: #fff; font-size: 10px; font-weight: 800; min-width: 17px; height: 17px; border-radius: 9px; display: flex; align-items: center; justify-content: center; padding: 0 4px; box-shadow: 0 2px 5px rgba(239, 68, 68, 0.4);">
                <?= (int)$unreadNotifCount ?>
              </span>
            <?php endif; ?>
          </button>

          <div id="notifDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; width: 340px; background: var(--bg-card, #ffffff); border: 1px solid var(--border-color, #e2e8f0); border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); z-index: 1000; overflow: hidden;">
            <div style="padding: 12px 16px; border-bottom: 1px solid var(--border-color, #e2e8f0); display: flex; justify-content: space-between; align-items: center; background: var(--color-slate-50, #f8fafc);">
              <strong style="font-size: 13.5px; color: var(--color-slate-900, #0f172a);">Notifications</strong>
              <form action="<?= site_url('notifications/read-all') ?>" method="POST" style="margin: 0;">
                <?= csrf_field() ?>
                <button type="submit" style="background: none; border: none; font-size: 11.5px; color: var(--color-primary, #4f46e5); cursor: pointer; padding: 0;">Mark Read</button>
              </form>
            </div>
            <div style="max-height: 280px; overflow-y: auto;">
              <?php if (empty($recentNotifications)): ?>
                <div style="padding: 24px; text-align: center; color: var(--color-slate-400, #94a3b8); font-size: 12.5px;">
                  No new notifications.
                </div>
              <?php else: ?>
                <?php foreach ($recentNotifications as $rn): ?>
                  <div style="padding: 10px 14px; border-bottom: 1px solid var(--border-color, #f1f5f9); <?= empty($rn['is_read']) ? 'background: rgba(79, 70, 229, 0.04);' : '' ?>">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                      <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-800, #1e293b);"><?= esc($rn['title']) ?></span>
                      <span class="badge badge-secondary" style="font-size: 9px; padding: 2px 4px;"><?= esc($rn['channel'] ?? 'in_app') ?></span>
                    </div>
                    <div style="font-size: 12px; color: var(--color-slate-600, #475569); line-height: 1.4;">
                      <?= esc(substr($rn['message'], 0, 85)) ?><?= (strlen($rn['message']) > 85) ? '...' : '' ?>
                    </div>
                    <div style="font-size: 10.5px; color: var(--color-slate-400, #94a3b8); margin-top: 4px;">
                      <?= date('M j, g:i A', strtotime($rn['created_at'])) ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div style="padding: 8px; text-align: center; border-top: 1px solid var(--border-color, #e2e8f0); background: var(--color-slate-50, #f8fafc);">
              <a href="<?= site_url('notifications') ?>" style="font-size: 12px; font-weight: 600; color: var(--color-primary, #4f46e5); text-decoration: none;">View All Notifications &rarr;</a>
            </div>
          </div>
        </div>

        <!-- Dark / Light Theme Toggle -->
        <button type="button" id="btnThemeToggle" class="btn-theme-toggle" aria-label="Toggle Dark Mode" title="Switch Theme (Light / Dark)">
          <svg class="theme-icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1" x2="12" y2="3"/>
            <line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/>
            <line x1="21" y1="12" x2="23" y2="12"/>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
          </svg>
          <svg class="theme-icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
          </svg>
          <span class="theme-toggle-label">Theme</span>
        </button>

        <a href="<?= site_url('logout') ?>" id="btnLogout" class="btn btn-outline btn-sm">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
          Sign Out
        </a>
      </div>
    </header>

    <!-- CONTENT BODY -->
    <main class="page-content">
      <?php if (!empty($flashSuccess)): ?>
        <div class="alert alert-success" id="alertSuccess">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <div><?= esc($flashSuccess) ?></div>
        </div>
      <?php endif; ?>

      <?php if (!empty($flashError)): ?>
        <div class="alert alert-danger" id="alertError">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
          <div><?= esc($flashError) ?></div>
        </div>
      <?php endif; ?>

      <?= $content ?? '' ?>
    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  if (typeof flatpickr === 'undefined') {
    document.write('<script src="<?= base_url('assets/vendor/flatpickr/flatpickr.min.js') ?>"><\/script>');
  }
</script>
<script>
  // Theme Switcher & Interactive Tabs Controller
  document.addEventListener('DOMContentLoaded', function() {
    // 1. Dark Mode Toggle
    const themeToggleBtn = document.getElementById('btnThemeToggle');
    if (themeToggleBtn) {
      function updateButtonTitle(theme) {
        themeToggleBtn.setAttribute('title', theme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode');
      }

      const initialTheme = document.documentElement.getAttribute('data-theme') || 'light';
      updateButtonTitle(initialTheme);

      themeToggleBtn.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('hrms-theme', newTheme);
        updateButtonTitle(newTheme);
      });

      // Listen for system theme changes if user hasn't explicitly set preference
      if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
          if (!localStorage.getItem('hrms-theme')) {
            const systemTheme = e.matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', systemTheme);
            updateButtonTitle(systemTheme);
          }
        });
      }
    }

    // 2. Interactive Tabs Controller
    const tabBtns = document.querySelectorAll('.tab-btn');
    tabBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        const target = this.getAttribute('data-target');
        const container = this.closest('.tabs-container');
        
        container.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        container.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
        
        this.classList.add('active');
        const activePane = container.querySelector(target);
        if (activePane) activePane.classList.add('active');
      });
    });

    // 3. Global Interactive Calendar & Datepicker Engine
    function initAppDatepickers() {
      if (typeof flatpickr === 'undefined') {
        setTimeout(initAppDatepickers, 100);
        return;
      }

      // Initialize all inputs with .datepicker-input
      document.querySelectorAll('.datepicker-input').forEach(function(input) {
        if (input._flatpickr) return;

        const initialVal = input.value || input.getAttribute('value') || '';
        flatpickr(input, {
          dateFormat: "Y-m-d",
          altInput: true,
          altFormat: "d-m-Y",
          altInputClass: (input.className || 'form-control') + " flatpickr-alt-input",
          allowInput: true,
          monthSelectorType: "dropdown",
          defaultDate: initialVal ? initialVal : undefined,
          onReady: function(selectedDates, dateStr, instance) {
            addCalendarFooter(instance);
            
            // Connect trigger button or prefix icon in parent container
            const container = instance.element.closest('.calendar-picker-wrapper') || instance.element.parentElement;
            if (container) {
              const triggerBtn = container.querySelector('.calendar-trigger-btn, .calendar-icon-prefix');
              if (triggerBtn && !triggerBtn._boundFp) {
                triggerBtn._boundFp = true;
                triggerBtn.addEventListener('click', function(e) {
                  e.preventDefault();
                  instance.toggle();
                });
              }
            }
          }
        });
      });

      // Also auto-enhance any standard input[type="date"]:not(.no-flatpickr) across the whole app
      document.querySelectorAll('input[type="date"]:not(.no-flatpickr)').forEach(function(input) {
        if (input._flatpickr) return;
        const val = input.value || '';
        input.type = 'text';
        input.classList.add('datepicker-input');

        flatpickr(input, {
          dateFormat: "Y-m-d",
          altInput: true,
          altFormat: "d-m-Y",
          altInputClass: (input.className || 'form-control') + " flatpickr-alt-input",
          allowInput: true,
          monthSelectorType: "dropdown",
          defaultDate: val ? val : undefined,
          onReady: function(selectedDates, dateStr, instance) {
            addCalendarFooter(instance);
          }
        });
      });

      // Handle Quick Date Chips (.date-chip)
      document.querySelectorAll('.date-chip').forEach(function(chip) {
        if (chip._boundChip) return;
        chip._boundChip = true;

        chip.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('data-target');
          const preset = this.getAttribute('data-preset');
          const targetEl = document.getElementById(targetId);
          if (!targetEl) return;

          const d = new Date();
          if (preset === 'today') {
            // today
          } else if (preset === 'yesterday') {
            d.setDate(d.getDate() - 1);
          } else if (preset === 'tomorrow') {
            d.setDate(d.getDate() + 1);
          } else if (preset === 'month_start') {
            d.setDate(1);
          } else if (preset === 'next_week') {
            d.setDate(d.getDate() + 7);
          } else if (preset === 'next_month') {
            d.setDate(d.getDate() + 30);
          } else if (preset === 'last_month') {
            d.setMonth(d.getMonth() - 1);
          }

          const yyyy = d.getFullYear();
          const mm = String(d.getMonth() + 1).padStart(2, '0');
          const dd = String(d.getDate()).padStart(2, '0');
          const formattedDate = `${yyyy}-${mm}-${dd}`;

          if (targetEl._flatpickr) {
            targetEl._flatpickr.setDate(formattedDate, true);
          } else {
            targetEl.value = formattedDate;
            targetEl.dispatchEvent(new Event('change'));
          }

          const parentChips = this.closest('.date-quick-chips');
          if (parentChips) {
            parentChips.querySelectorAll('.date-chip').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
          }
        });
      });
    }

    function addCalendarFooter(instance) {
      if (!instance.calendarContainer || instance.calendarContainer.querySelector('.flatpickr-footer-bar')) return;
      const footer = document.createElement('div');
      footer.className = 'flatpickr-footer-bar';
      footer.innerHTML = `
        <div style="display:flex; gap:6px;">
          <button type="button" class="flatpickr-footer-btn btn-today" title="Jump to Today">⚡ Today</button>
          <button type="button" class="flatpickr-footer-btn btn-clear" title="Clear date">Clear</button>
        </div>
        <button type="button" class="flatpickr-footer-btn btn-close" title="Done">Done ✓</button>
      `;
      footer.querySelector('.btn-today').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        instance.setDate(new Date(), true);
        instance.close();
      });
      footer.querySelector('.btn-clear').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        instance.clear();
      });
      footer.querySelector('.btn-close').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        instance.close();
      });
      instance.calendarContainer.appendChild(footer);
    }

    document.addEventListener('click', function(e) {
      const wrapper = document.querySelector('.notif-wrapper');
      const dropdown = document.getElementById('notifDropdown');
      if (wrapper && dropdown && !wrapper.contains(e.target)) {
        dropdown.style.display = 'none';
      }
    });

    initAppDatepickers();
  });
</script>
</body>
</html>
