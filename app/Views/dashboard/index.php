<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
      Executive Overview
    </h2>
    <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
      Welcome to Infosof Enterprise HRMS. System operating under <span class="badge badge-primary"><?= esc($currentUser['role_name'] ?? 'Super Admin') ?></span> tier.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <?php if (($currentRoleSlug ?? '') !== 'employee' && (in_array('employee.create', $userPermissions ?? []) || in_array($currentRoleSlug ?? '', ['super_admin', 'hr_admin', 'hr_executive']))): ?>
      <a href="<?= site_url('employees/create') ?>" id="btnQuickAddEmployee" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        Onboard Employee
      </a>
    <?php else: ?>
      <a href="<?= site_url('leaves') ?>" id="btnQuickApplyLeave" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        Apply Leave
      </a>
      <a href="<?= site_url('attendance') ?>" id="btnQuickClock" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Clock In / Out
      </a>
    <?php endif; ?>
    <a href="<?= site_url('employees') ?>" id="btnQuickDirectory" class="btn btn-outline">
      View Master Directory
    </a>
  </div>
</div>

<!-- 4 PRIMARY KPI CARDS -->
<div class="grid-4">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Workforce</div>
      <div class="stat-value"><?= esc($totalHeadcount) ?></div>
      <div class="stat-subtext"><span style="color: #10b981; font-weight: 600;">&bull; <?= esc($activeEmployees) ?> active</span> across 3 branches</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </div>
  </div>

  <div class="stat-card sky">
    <div class="stat-content">
      <div class="stat-label">Departments &amp; Branches</div>
      <div class="stat-value"><?= esc($totalDepartments) ?> / <?= esc($totalBranches) ?></div>
      <div class="stat-subtext">Operating across India </div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
    </div>
  </div>

    <div class="stat-card emerald">
    <div class="stat-content">
      <div class="stat-label">Monthly Gross Payroll</div>
      <div class="stat-value">₹<?= number_format($monthlyGrossPayroll, 2) ?></div>
      <div class="stat-subtext">Estimated net: ₹<?= number_format($monthlyNetPayroll, 2) ?></div>
    </div>
    <!-- UPDATED: INDIAN RUPEE (₹) SVG ICON -->
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 3h12"/>
        <path d="M6 8h12"/>
        <path d="m6 13 8.5 8"/>
        <path d="M6 13h3"/>
        <path d="M9 13c6.667 0 6.667-10 0-10"/>
      </svg>
    </div>
  </div>


  <div class="stat-card amber">
    <div class="stat-content">
      <div class="stat-label">Pending Approvals</div>
      <div class="stat-value"><?= esc($pendingLeaves) ?></div>
      <div class="stat-subtext"><span style="color: #f59e0b; font-weight: 600;">Action required</span> in queue</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>
</div>

<!-- EMPLOYEE SELF-SERVICE HIGHLIGHT CARD (If viewing as Employee) -->
<?php if (!empty($employeeEss)): ?>
<div class="card" style="border-left: 4px solid var(--primary); background: #fdfefe;">
  <div class="card-header">
    <div class="card-title" style="display: flex; align-items: center; gap: 8px;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      Employee Self-Service (ESS) Quick Status
    </div>
    <a href="<?= site_url('employees/view/' . $employeeEss['id']) ?>" class="btn btn-outline btn-sm">View My Full 360° Profile</a>
  </div>
  <div class="card-body">
    <div class="grid-3" style="margin-bottom: 0;">
      <div>
        <div style="font-size: 12px; color: var(--text-muted); font-weight: 600;">EMPLOYEE CODE</div>
        <div style="font-size: 16px; font-weight: 700; color: var(--text-main);"><?= esc($employeeEss['employee_code']) ?></div>
        <div style="font-size: 13px; color: var(--text-muted);"><?= esc($employeeEss['designation_name']) ?> &bull; <?= esc($employeeEss['department_name']) ?></div>
      </div>
      <div>
        <div style="font-size: 12px; color: var(--text-muted); font-weight: 600;">LEAVE BALANCES (2026)</div>
        <div style="display: flex; gap: 12px; margin-top: 4px;">
          <?php foreach ($employeeEss['leave_balances'] as $lb): ?>
            <div style="background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-size: 12px;">
              <strong><?= esc($lb['leave_type_code']) ?>:</strong> <?= esc($lb['remaining_days']) ?> left
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div>
        <div style="font-size: 12px; color: var(--text-muted); font-weight: 600;">REPORTING MANAGER</div>
        <div style="font-size: 14px; font-weight: 600; color: var(--text-main); margin-top: 2px;">
          <?= esc($employeeEss['manager_first_name'] ? ($employeeEss['manager_first_name'] . ' ' . $employeeEss['manager_last_name']) : 'Direct to C-Suite') ?>
        </div>
        <div style="font-size: 12px; color: var(--text-muted);"><?= esc($employeeEss['manager_email'] ?? 'hr@infosof.com') ?></div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- 2-COLUMN MAIN WIDGETS -->
<div class="grid-2-1">
  <!-- Left: Department Headcount Distribution -->
  <div class="card">
    <div class="card-header">
      <div class="card-title">Department Workforce Distribution</div>
      <a href="<?= site_url('departments') ?>" class="btn btn-outline btn-sm">Manage Departments</a>
    </div>
    <div class="card-body">
      <div style="display: flex; flex-direction: column; gap: 16px;">
        <?php foreach ($departmentsWithStats as $dept): 
          $pct = ($totalHeadcount > 0) ? round(($dept['employee_count'] / $totalHeadcount) * 100) : 0;
        ?>
          <div>
            <div style="display: flex; justify-content: space-between; font-size: 13.5px; font-weight: 600; margin-bottom: 6px;">
              <span><?= esc($dept['name']) ?> <span style="font-size: 11.5px; color: #64748b; font-weight: 400;">(<?= esc($dept['code']) ?>)</span></span>
              <span><?= esc($dept['employee_count']) ?> staff <span style="color: #64748b; font-weight: 400;">(<?= $pct ?>%)</span></span>
            </div>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 9999px; overflow: hidden;">
              <div style="width: <?= max($pct, 6) ?>%; height: 100%; background: var(--primary); border-radius: 9999px;"></div>
            </div>
            <div style="font-size: 11.5px; color: #94a3b8; margin-top: 4px;">
              Head: <?= esc($dept['head_first_name'] ? ($dept['head_first_name'] . ' ' . $dept['head_last_name']) : 'Unassigned') ?> &bull; Branch: <?= esc($dept['branch_name'] ?? 'HQ') ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Right: Audit Activity Log Feed -->
  <div class="card">
    <div class="card-header">
      <div class="card-title">Audit Activity Feed</div>
      <a href="<?= site_url('audit') ?>" class="btn btn-outline btn-sm">Full Trail</a>
    </div>
    <div class="card-body" style="padding: 12px 16px;">
      <div style="display: flex; flex-direction: column; gap: 12px;">
        <?php foreach ($recentLogs as $log): ?>
          <div style="display: flex; gap: 10px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
            <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary); margin-top: 6px; flex-shrink: 0;"></div>
            <div style="flex: 1;">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span class="badge badge-secondary" style="font-size: 10px;"><?= esc($log['action']) ?></span>
                <span style="font-size: 11px; color: #94a3b8;"><?= esc(date('M d, H:i', strtotime($log['created_at']))) ?></span>
              </div>
              <p style="font-size: 12.5px; color: var(--text-main); margin-top: 4px; line-height: 1.35;">
                <?= esc($log['description']) ?>
              </p>
              <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                User: <strong><?= esc($log['username'] ?? 'System') ?></strong> (IP: <?= esc($log['ip_address']) ?>)
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- RECENT WORKFORCE JOINERS TABLE -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Recent Workforce Profiles</div>
    <a href="<?= site_url('employees') ?>" class="btn btn-outline btn-sm">View All <?= esc($totalHeadcount) ?> Employees</a>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Employee Code</th>
          <th>Full Name</th>
          <th>Designation</th>
          <th>Department</th>
          <th>Branch</th>
          <th>Joining Date</th>
          <th>Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recentEmployees as $emp): ?>
          <tr>
            <td>
              <span class="badge badge-primary"><?= esc($emp['employee_code']) ?></span>
            </td>
            <td>
              <div style="display: flex; align-items: center; gap: 10px;">
                <div class="avatar-sm" style="width: 32px; height: 32px; font-size: 12px; background: #4f46e5;">
                  <?= esc(substr($emp['first_name'], 0, 1) . substr($emp['last_name'], 0, 1)) ?>
                </div>
                <div>
                  <div style="font-weight: 600;"><?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?></div>
                  <div style="font-size: 11.5px; color: #64748b;"><?= esc($emp['email']) ?></div>
                </div>
              </div>
            </td>
            <td><?= esc($emp['designation_name'] ?? 'Not set') ?></td>
            <td><?= esc($emp['department_name'] ?? 'Not set') ?></td>
            <td><?= esc($emp['branch_name'] ?? 'HQ') ?></td>
            <td><?= esc($emp['joining_date']) ?></td>
            <td>
              <span class="badge badge-success"><?= esc(ucfirst($emp['employment_status'])) ?></span>
            </td>
            <td style="text-align: right;">
              <a href="<?= site_url('employees/view/' . $emp['id']) ?>" id="viewEmp_<?= $emp['id'] ?>" class="btn btn-outline btn-sm">
                View 360° Profile
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
