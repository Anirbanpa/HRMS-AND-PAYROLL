<!-- ============================================================== -->
<!-- 1. EMPLOYEE SELF-SERVICE (ESS) DASHBOARD                       -->
<!-- ============================================================== -->
<?php if ($roleSlug === 'employee'): 
  $prof = $employeeData['profile'] ?? [];
  $punch = $employeeData['todayPunch'] ?? null;
  $balances = $employeeData['leaveBalances'] ?? [];
  $leaves = $employeeData['recentLeaves'] ?? [];
  $punches = $employeeData['recentPunches'] ?? [];
  $payslip = $employeeData['latestPayslip'] ?? null;
  $holidays = $employeeData['upcomingHolidays'] ?? [];
?>
  <!-- ESS Header -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
      <h2 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em; margin: 0;">
        Welcome, <?= esc($currentUser['full_name'] ?: $currentUser['username']) ?> 👋
      </h2>
      <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 3px; margin-bottom: 0;">
        Employee Self-Service (ESS) &bull; <?= esc($prof['employee_code'] ?? 'EMP') ?> &bull; <?= esc($prof['designation_name'] ?? 'Staff') ?> (<?= esc($prof['department_name'] ?? 'General') ?>)
      </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <a href="<?= site_url('attendance') ?>" class="btn btn-primary" style="font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <?= empty($punch['clock_in']) ? 'Clock In' : (empty($punch['clock_out']) ? 'Clock Out' : 'Attendance Clock') ?>
      </a>
      <a href="<?= site_url('leaves') ?>" class="btn btn-outline" style="font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        Apply Leave
      </a>
      <a href="<?= site_url('reimbursements') ?>" class="btn btn-outline" style="font-size: 13px;">
        Submit Claim
      </a>
      <a href="<?= site_url('profile') ?>" class="btn btn-outline" style="font-size: 13px;">
        My 360° Profile
      </a>
    </div>
  </div>

  <!-- ESS 4 Personal KPI Metric Cards -->
  <div class="grid-4" style="gap: 16px; margin-bottom: 22px;">
    <!-- Metric 1: Today's Attendance -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-primary); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Today's Clock</span>
        <?php if (!empty($punch['clock_in'])): ?>
          <span class="badge badge-success" style="font-size: 11px;">Clocked In</span>
        <?php else: ?>
          <span class="badge badge-warning" style="font-size: 11px;">Not Clocked In</span>
        <?php endif; ?>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); margin: 0;">
          <?= !empty($punch['clock_in']) ? date('h:i A', strtotime($punch['clock_in'])) : '—:—' ?>
        </h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">
          <?= !empty($punch['total_hours']) ? (float)$punch['total_hours'] . ' hrs today' : '0.0 hrs' ?>
        </span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('attendance') ?>" style="color: var(--color-primary); font-weight: 600; text-decoration: none;">View Timesheet &rarr;</a>
      </div>
    </div>

    <!-- Metric 2: Leave Balance -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #0284c7; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Leave Balances</span>
        <span class="badge badge-info" style="font-size: 11px;">2026 Year</span>
      </div>
      <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 6px; margin-top: 4px;">
        <?php if (!empty($balances)): ?>
          <?php foreach ($balances as $b): ?>
            <span style="background: var(--bg-main); padding: 2px 7px; border-radius: 5px; font-size: 12px; border: 1px solid var(--border-color); color: var(--color-slate-800);">
              <strong><?= esc($b['leave_type_code']) ?>:</strong> <?= (float)$b['remaining_days'] ?>d
            </span>
          <?php endforeach; ?>
        <?php else: ?>
          <span style="font-size: 13px; color: var(--color-slate-500);">Standard allocation active</span>
        <?php endif; ?>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('leaves') ?>" style="color: #0284c7; font-weight: 600; text-decoration: none;">Apply For Leave &rarr;</a>
      </div>
    </div>

    <!-- Metric 3: Latest Payslip -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-emerald-500); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Latest Payslip</span>
        <?php if ($payslip): ?>
          <span class="badge badge-success" style="font-size: 11px;">Processed</span>
        <?php else: ?>
          <span class="badge badge-secondary" style="font-size: 11px;">Current Cycle</span>
        <?php endif; ?>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 22px; font-weight: 800; color: var(--color-emerald-600); margin: 0;">
          <?= $payslip ? '₹' . number_format($payslip['net_salary'], 2) : 'Active' ?>
        </h3>
        <span style="font-size: 12px; color: var(--color-slate-500);">
          <?= $payslip ? date('M Y', mktime(0, 0, 0, (int)($payslip['month'] ?? 1), 1, (int)($payslip['year'] ?? date('Y')))) : 'Next run upcoming' ?>
        </span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <?php if ($payslip): ?>
          <a href="<?= site_url('payroll/payslip/' . $payslip['id']) ?>" style="color: var(--color-emerald-600); font-weight: 600; text-decoration: none;">Download Payslip &rarr;</a>
        <?php else: ?>
          <span style="color: var(--color-slate-400);">Payslip will be published post payroll</span>
        <?php endif; ?>
      </div>
    </div>

    <!-- Metric 4: OKRs & Goals -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #8b5cf6; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">My OKRs / Goals</span>
        <span class="badge badge-primary" style="font-size: 11px;"><?= (int)($employeeData['goalsCount'] ?? 0) ?> Goals</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); margin: 0;">
          <?= (int)($employeeData['goalsCount'] ?? 0) ?>
        </h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">Active deliverables</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('performance') ?>" style="color: #8b5cf6; font-weight: 600; text-decoration: none;">Self-Assessment &amp; OKRs &rarr;</a>
      </div>
    </div>
  </div>

  <!-- ESS 2-Column Content Layout -->
  <div style="display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start;">
    <!-- Left: Recent Punches & Leave Requests -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <!-- Recent Attendance Register -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Recent Attendance Logs</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Your last 5 daily punch records and working hours.</p>
          </div>
          <a href="<?= site_url('attendance') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">Full Register</a>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
              <tr>
                <th>Date</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Total Hours</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($punches)): ?>
                <tr><td colspan="5" style="text-align: center; color: var(--color-slate-400); padding: 24px;">No recent attendance punches found.</td></tr>
              <?php else: ?>
                <?php foreach ($punches as $p): ?>
                  <tr>
                    <td><strong><?= date('M d, Y', strtotime($p['date'])) ?></strong></td>
                    <td><?= !empty($p['clock_in']) ? date('h:i A', strtotime($p['clock_in'])) : '—' ?></td>
                    <td><?= !empty($p['clock_out']) ? date('h:i A', strtotime($p['clock_out'])) : '—' ?></td>
                    <td><?= !empty($p['total_hours']) ? (float)$p['total_hours'] . ' hrs' : '—' ?></td>
                    <td>
                      <span class="badge <?= $p['status'] === 'Present' ? 'badge-success' : 'badge-secondary' ?>" style="font-size: 11px;">
                        <?= esc($p['status']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Recent Leave Applications -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">My Leave Applications</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Recent requests submitted to your reporting supervisor.</p>
          </div>
          <a href="<?= site_url('leaves') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">View All</a>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
              <tr>
                <th>Leave Type</th>
                <th>Period</th>
                <th>Days</th>
                <th>Reason</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($leaves)): ?>
                <tr><td colspan="5" style="text-align: center; color: var(--color-slate-400); padding: 24px;">No leave requests filed yet.</td></tr>
              <?php else: ?>
                <?php foreach ($leaves as $l): ?>
                  <tr>
                    <td><strong><?= esc($l['leave_type_name'] ?? 'Leave') ?></strong></td>
                    <td><?= date('M d', strtotime($l['start_date'])) ?> &ndash; <?= date('M d, Y', strtotime($l['end_date'])) ?></td>
                    <td><?= (float)$l['total_days'] ?>d</td>
                    <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--color-slate-600);"><?= esc($l['reason']) ?></td>
                    <td>
                      <?php if ($l['status'] === 'manager_approved' || $l['status'] === 'hr_approved'): ?>
                        <span class="badge badge-success" style="font-size: 11px;">Approved</span>
                      <?php elseif ($l['status'] === 'rejected'): ?>
                        <span class="badge badge-danger" style="font-size: 11px;">Rejected</span>
                      <?php else: ?>
                        <span class="badge badge-warning" style="font-size: 11px;">Pending</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right: Upcoming Holidays & Profile Summary -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <!-- Reporting Structure Card -->
      <div class="card" style="padding: 18px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 14px; font-weight: 700; margin: 0 0 12px 0; color: var(--color-slate-900);">Reporting Structure</h4>
        <div style="font-size: 12px; color: var(--color-slate-500); margin-bottom: 4px;">REPORTING SUPERVISOR</div>
        <div style="font-size: 14.5px; font-weight: 700; color: var(--color-slate-900);">
          <?= esc(!empty($prof['manager_first_name']) ? ($prof['manager_first_name'] . ' ' . $prof['manager_last_name']) : 'Direct to C-Suite') ?>
        </div>
        <div style="font-size: 12px; color: var(--color-slate-500); margin-top: 2px;">
          <?= esc($prof['manager_email'] ?? 'management@infosof.com') ?>
        </div>

        <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 8px;">
          <div style="display: flex; justify-content: space-between; font-size: 12px;">
            <span style="color: var(--color-slate-500);">Branch Location:</span>
            <strong style="color: var(--color-slate-800);"><?= esc($prof['branch_name'] ?? 'HQ') ?></strong>
          </div>
          <div style="display: flex; justify-content: space-between; font-size: 12px;">
            <span style="color: var(--color-slate-500);">Joining Date:</span>
            <strong style="color: var(--color-slate-800);"><?= esc($prof['joining_date'] ?? 'N/A') ?></strong>
          </div>
        </div>
      </div>

      <!-- Upcoming Holidays -->
      <div class="card" style="padding: 18px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
          <h4 style="font-size: 14px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Upcoming Holidays</h4>
          <a href="<?= site_url('holidays') ?>" style="font-size: 11.5px; color: var(--color-primary); font-weight: 600; text-decoration: none;">Calendar &rarr;</a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <?php if (empty($holidays)): ?>
            <div style="font-size: 12px; color: var(--color-slate-400); text-align: center; padding: 12px;">No upcoming holidays in current month.</div>
          <?php else: ?>
            <?php foreach ($holidays as $h): ?>
              <div style="display: flex; gap: 10px; align-items: center; padding: 8px 10px; background: var(--bg-main); border-radius: 8px; border: 1px solid var(--border-color);">
                <div style="width: 38px; height: 38px; border-radius: 6px; background: rgba(99, 102, 241, 0.1); color: var(--color-primary); display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0; line-height: 1;">
                  <span style="font-size: 12px; font-weight: 800;"><?= date('d', strtotime($h['date'])) ?></span>
                  <span style="font-size: 9px; text-transform: uppercase; font-weight: 600;"><?= date('M', strtotime($h['date'])) ?></span>
                </div>
                <div>
                  <div style="font-size: 13px; font-weight: 600; color: var(--color-slate-900);"><?= esc($h['title']) ?></div>
                  <div style="font-size: 11px; color: var(--color-slate-500);"><?= ucfirst(esc($h['holiday_type'] ?? 'National')) ?> Holiday</div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>


<!-- ============================================================== -->
<!-- 2. MANAGER SELF-SERVICE (MSS) & SUPERVISORY DASHBOARD          -->
<!-- ============================================================== -->
<?php elseif ($roleSlug === 'manager'): 
  $team = $managerData['directReports'] ?? [];
  $pendingLeaves = $managerData['pendingTeamLeaves'] ?? [];
?>
  <!-- Manager Header -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
      <h2 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em; margin: 0;">
        Manager &amp; Supervisory Hub
      </h2>
      <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 3px; margin-bottom: 0;">
        Department &amp; Team Management Portal &bull; Welcome, <?= esc($currentUser['full_name'] ?: $currentUser['username']) ?>
      </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <a href="<?= site_url('manager') ?>" class="btn btn-primary" style="font-size: 13px;">
        MSS Approval Queue
      </a>
      <a href="<?= site_url('shifts/roster') ?>" class="btn btn-outline" style="font-size: 13px;">
        Team Roster
      </a>
      <a href="<?= site_url('performance') ?>" class="btn btn-outline" style="font-size: 13px;">
        Team Appraisals
      </a>
    </div>
  </div>

  <!-- Manager 4 Team KPI Cards -->
  <div class="grid-4" style="gap: 16px; margin-bottom: 22px;">
    <!-- Metric 1: Direct Reports -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-primary); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Direct Reports</span>
        <span class="badge badge-primary" style="font-size: 11px;">My Team</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); margin: 0;"><?= (int)($managerData['teamCount'] ?? 0) ?></h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">team members</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        Active reporting staff
      </div>
    </div>

    <!-- Metric 2: Team Present Today -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-emerald-500); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Present Today</span>
        <span class="badge badge-success" style="font-size: 11px;">Attendance</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: var(--color-emerald-600); margin: 0;">
          <?= (int)($managerData['teamPresentToday'] ?? 0) ?> / <?= (int)($managerData['teamCount'] ?? 0) ?>
        </h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">clocked in</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        Daily team attendance status
      </div>
    </div>

    <!-- Metric 3: Pending Team Approvals -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #f59e0b; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Pending Approvals</span>
        <span class="badge badge-warning" style="font-size: 11px;">Action Req.</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: #d97706; margin: 0;">
          <?= (int)($managerData['pendingTeamLeavesCount'] ?? 0) ?>
        </h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">leave requests</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('manager') ?>" style="color: #d97706; font-weight: 600; text-decoration: none;">Open Approval Queue &rarr;</a>
      </div>
    </div>

    <!-- Metric 4: Team Performance Appraisals -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #8b5cf6; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Appraisals Due</span>
        <span class="badge badge-info" style="font-size: 11px;">Review</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: #8b5cf6; margin: 0;">
          <?= (int)($managerData['pendingEvaluations'] ?? 0) ?>
        </h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">evaluations</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('performance') ?>" style="color: #8b5cf6; font-weight: 600; text-decoration: none;">Evaluate Team &rarr;</a>
      </div>
    </div>
  </div>

  <!-- Manager Main Content -->
  <div style="display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start;">
    <!-- Left: Pending Leave Approvals & Direct Reports -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <!-- Pending Team Leave Requests -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Pending Team Leave Requests</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Review and act on leave applications from your direct reports.</p>
          </div>
          <a href="<?= site_url('manager') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">MSS Center</a>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
              <tr>
                <th>Employee</th>
                <th>Leave Type</th>
                <th>Dates</th>
                <th>Days</th>
                <th>Reason</th>
                <th style="text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($pendingLeaves)): ?>
                <tr><td colspan="6" style="text-align: center; color: var(--color-slate-400); padding: 28px;">No pending leave requests in your supervisory queue.</td></tr>
              <?php else: ?>
                <?php foreach ($pendingLeaves as $pl): ?>
                  <tr>
                    <td>
                      <strong><?= esc($pl['first_name'] . ' ' . $pl['last_name']) ?></strong>
                      <div style="font-size: 11px; color: var(--color-slate-500);"><?= esc($pl['employee_code']) ?></div>
                    </td>
                    <td><?= esc($pl['leave_type_name']) ?></td>
                    <td><?= date('M d', strtotime($pl['start_date'])) ?> &ndash; <?= date('M d', strtotime($pl['end_date'])) ?></td>
                    <td><strong><?= (float)$pl['total_days'] ?>d</strong></td>
                    <td style="max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= esc($pl['reason']) ?></td>
                    <td style="text-align: right;">
                      <a href="<?= site_url('leaves/approve/' . $pl['id']) ?>" class="btn btn-primary btn-sm" style="font-size: 11px; padding: 3px 8px;">Approve</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Direct Reports Team List -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">My Direct Reports</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Active employees assigned to your supervisory hierarchy.</p>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
              <tr>
                <th>Member</th>
                <th>Designation</th>
                <th>Email</th>
                <th style="text-align: right;">Profile</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($team)): ?>
                <tr><td colspan="4" style="text-align: center; color: var(--color-slate-400); padding: 24px;">No direct reports linked.</td></tr>
              <?php else: ?>
                <?php foreach ($team as $tm): ?>
                  <tr>
                    <td>
                      <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--bg-main); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">
                          <?= strtoupper(substr($tm['first_name'], 0, 1) . substr($tm['last_name'], 0, 1)) ?>
                        </div>
                        <div>
                          <strong><?= esc($tm['first_name'] . ' ' . $tm['last_name']) ?></strong>
                          <div style="font-size: 10.5px; color: var(--color-slate-400);"><?= esc($tm['employee_code']) ?></div>
                        </div>
                      </div>
                    </td>
                    <td><?= esc($tm['desig_name'] ?? 'Staff') ?></td>
                    <td><span style="color: var(--color-slate-600);"><?= esc($tm['email']) ?></span></td>
                    <td style="text-align: right;">
                      <a href="<?= site_url('employees/view/' . $tm['id']) ?>" class="btn btn-outline btn-sm" style="font-size: 11px; padding: 3px 8px;">360° Profile</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right: Quick Manager Tools -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <div class="card" style="padding: 18px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 14px; font-weight: 700; margin: 0 0 12px 0; color: var(--color-slate-900);">Manager Operations</h4>
        <div style="display: flex; flex-direction: column; gap: 8px;">
          <a href="<?= site_url('manager') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            📋 MSS Approvals Queue
          </a>
          <a href="<?= site_url('shifts/roster') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            🕒 Department Shift Roster
          </a>
          <a href="<?= site_url('attendance/late-early') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            ⏱️ Late &amp; Early Waivers
          </a>
          <a href="<?= site_url('performance') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            🎯 Supervisory OKR Evaluations
          </a>
        </div>
      </div>
    </div>
  </div>


<!-- ============================================================== -->
<!-- 3. PAYROLL MANAGER & ACCOUNTANT DASHBOARD                      -->
<!-- ============================================================== -->
<?php elseif (in_array($roleSlug, ['payroll_manager', 'accountant'])): 
  $gross = $payrollData['monthlyGross'] ?? 0;
  $net   = $payrollData['monthlyNet'] ?? 0;
  $lRun  = $payrollData['latestRun'] ?? null;
  $rRuns = $payrollData['recentPayrollRuns'] ?? [];
?>
  <!-- Payroll Header -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
      <h2 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em; margin: 0;">
        Payroll &amp; Financial Operations
      </h2>
      <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 3px; margin-bottom: 0;">
        Operating under <span class="badge badge-primary"><?= esc($currentUser['role_name']) ?></span> tier &bull; Compensation and disbursements
      </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <a href="<?= site_url('payroll') ?>" class="btn btn-primary" style="font-size: 13px;">
        Process Monthly Payroll
      </a>
      <a href="<?= site_url('reports/export/payroll-bank') ?>" class="btn btn-outline" style="font-size: 13px;">
        Export Bank Advice
      </a>
      <a href="<?= site_url('reimbursements') ?>" class="btn btn-outline" style="font-size: 13px;">
        Reimbursements
      </a>
      <a href="<?= site_url('loans') ?>" class="btn btn-outline" style="font-size: 13px;">
        Loans &amp; Advances
      </a>
    </div>
  </div>

  <!-- Payroll 4 Financial KPI Cards -->
  <div class="grid-4" style="gap: 16px; margin-bottom: 22px;">
    <!-- Metric 1: Monthly Gross Payroll -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-primary); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Gross Payroll</span>
        <span class="badge badge-primary" style="font-size: 11px;">Monthly</span>
      </div>
      <div style="margin-bottom: 4px;">
        <h3 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); margin: 0;">₹<?= number_format($gross, 2) ?></h3>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        Total compensation liability
      </div>
    </div>

    <!-- Metric 2: Monthly Net Pay -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-emerald-500); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Net Disbursement</span>
        <span class="badge badge-success" style="font-size: 11px;">Disbursement</span>
      </div>
      <div style="margin-bottom: 4px;">
        <h3 style="font-size: 22px; font-weight: 800; color: var(--color-emerald-600); margin: 0;">₹<?= number_format($net, 2) ?></h3>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        Net bank transfer commitment
      </div>
    </div>

    <!-- Metric 3: Pending Claims -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #f59e0b; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Claims Queue</span>
        <span class="badge badge-warning" style="font-size: 11px;">Pending</span>
      </div>
      <div style="margin-bottom: 4px;">
        <h3 style="font-size: 22px; font-weight: 800; color: #d97706; margin: 0;"><?= (int)($payrollData['pendingReimbursements'] ?? 0) ?></h3>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('reimbursements') ?>" style="color: #d97706; font-weight: 600; text-decoration: none;">Review Claims &rarr;</a>
      </div>
    </div>

    <!-- Metric 4: Active Loans -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #8b5cf6; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Loans &amp; Advances</span>
        <span class="badge badge-info" style="font-size: 11px;">Active</span>
      </div>
      <div style="margin-bottom: 4px;">
        <h3 style="font-size: 22px; font-weight: 800; color: #8b5cf6; margin: 0;"><?= (int)($payrollData['pendingLoans'] ?? 0) ?></h3>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('loans') ?>" style="color: #8b5cf6; font-weight: 600; text-decoration: none;">Manage Advances &rarr;</a>
      </div>
    </div>
  </div>

  <!-- Payroll Main Content -->
  <div style="display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start;">
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <!-- Recent Payroll Runs -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Recent Monthly Payroll Runs</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Batches processed across organizational pay bands.</p>
          </div>
          <a href="<?= site_url('payroll') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">Full Payroll Ledger</a>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
              <tr>
                <th>Period</th>
                <th>Employees</th>
                <th>Gross Salary</th>
                <th>Net Disbursement</th>
                <th>Status</th>
                <th style="text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($rRuns)): ?>
                <tr><td colspan="6" style="text-align: center; color: var(--color-slate-400); padding: 24px;">No payroll runs processed yet.</td></tr>
              <?php else: ?>
                <?php foreach ($rRuns as $run): ?>
                  <tr>
                    <td><strong><?= date('F Y', mktime(0, 0, 0, (int)($run['month'] ?? 1), 1, (int)($run['year'] ?? date('Y')))) ?></strong></td>
                    <td><?= esc($run['total_employees'] ?? ($run['employee_count'] ?? $activeEmployees)) ?> staff</td>
                    <td>₹<?= number_format((float)($run['total_gross'] ?? 0), 2) ?></td>
                    <td><strong style="color: var(--color-emerald-600);">₹<?= number_format((float)($run['total_net'] ?? 0), 2) ?></strong></td>
                    <td>
                      <span class="badge <?= $run['status'] === 'completed' || $run['status'] === 'approved' ? 'badge-success' : 'badge-primary' ?>" style="font-size: 11px;">
                        <?= ucfirst(esc($run['status'])) ?>
                      </span>
                    </td>
                    <td style="text-align: right;">
                      <a href="<?= site_url('payroll/view/' . $run['id']) ?>" class="btn btn-outline btn-sm" style="font-size: 11px; padding: 3px 8px;">View Batch</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right: Finance & Statutory Operations -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <div class="card" style="padding: 18px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 14px; font-weight: 700; margin: 0 0 12px 0; color: var(--color-slate-900);">Finance &amp; Statutory Exports</h4>
        <div style="display: flex; flex-direction: column; gap: 8px;">
          <a href="<?= site_url('reports/export/payroll-bank') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            🏦 Bank Transfer Advice (CSV)
          </a>
          <a href="<?= site_url('reports/export/statutory') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            📑 Statutory PF &amp; ESI Filing Export
          </a>
          <a href="<?= site_url('reports/export/attendance') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            📊 Monthly Attendance Summary
          </a>
          <a href="<?= site_url('bonuses') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            🎁 Incentives &amp; Bonus Batches
          </a>
        </div>
      </div>
    </div>
  </div>


<!-- ============================================================== -->
<!-- 4. HR ADMIN & HR EXECUTIVE DASHBOARD                           -->
<!-- ============================================================== -->
<?php elseif (in_array($roleSlug, ['hr_admin', 'hr_executive'])): 
  $deptStats = $hrData['departmentsWithStats'] ?? [];
  $recentEmp = $hrData['recentEmployees'] ?? [];
?>
  <!-- HR Header -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
      <h2 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em; margin: 0;">
        Human Resources Operations
      </h2>
      <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 3px; margin-bottom: 0;">
        Operating under <span class="badge badge-primary"><?= esc($currentUser['role_name']) ?></span> tier &bull; Workforce, attendance, and recruitment
      </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <a href="<?= site_url('employees/create') ?>" class="btn btn-primary" style="font-size: 13px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        Onboard Employee
      </a>
      <a href="<?= site_url('leaves') ?>" class="btn btn-outline" style="font-size: 13px;">
        Leave Approvals
      </a>
      <a href="<?= site_url('recruitment') ?>" class="btn btn-outline" style="font-size: 13px;">
        Recruitment ATS
      </a>
      <a href="<?= site_url('attendance') ?>" class="btn btn-outline" style="font-size: 13px;">
        Attendance Register
      </a>
    </div>
  </div>

  <!-- HR 4 Operations KPI Cards -->
  <div class="grid-4" style="gap: 16px; margin-bottom: 22px;">
    <!-- Metric 1: Active Workforce -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-primary); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Total Workforce</span>
        <span class="badge badge-primary" style="font-size: 11px;">Active</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); margin: 0;"><?= esc($activeEmployees) ?></h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">employees</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        Across <?= esc($totalBranches) ?> operating branches
      </div>
    </div>

    <!-- Metric 2: Today's Attendance -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-emerald-500); box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Today's Attendance</span>
        <span class="badge badge-success" style="font-size: 11px;">Present</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: var(--color-emerald-600); margin: 0;"><?= (int)($hrData['presentToday'] ?? 0) ?></h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">present &bull; <?= (int)($hrData['lateToday'] ?? 0) ?> late</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('attendance') ?>" style="color: var(--color-emerald-600); font-weight: 600; text-decoration: none;">View Register &rarr;</a>
      </div>
    </div>

    <!-- Metric 3: Pending Leaves -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #f59e0b; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Pending Leaves</span>
        <span class="badge badge-warning" style="font-size: 11px;">Queue</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: #d97706; margin: 0;"><?= (int)($hrData['pendingLeaves'] ?? 0) ?></h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">leave requests</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('leaves') ?>" style="color: #d97706; font-weight: 600; text-decoration: none;">Review Leaves &rarr;</a>
      </div>
    </div>

    <!-- Metric 4: Recruitment & Probations -->
    <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #8b5cf6; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
        <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Talent Pipeline</span>
        <span class="badge badge-info" style="font-size: 11px;">Hiring</span>
      </div>
      <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
        <h3 style="font-size: 24px; font-weight: 800; color: #8b5cf6; margin: 0;"><?= (int)($hrData['openJobs'] ?? 0) ?></h3>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">open requisitions</span>
      </div>
      <div style="font-size: 11.5px; color: var(--color-slate-500);">
        <a href="<?= site_url('recruitment') ?>" style="color: #8b5cf6; font-weight: 600; text-decoration: none;">Recruitment Pipeline &rarr;</a>
      </div>
    </div>
  </div>

  <!-- HR Main Content -->
  <div style="display: grid; grid-template-columns: 1fr 360px; gap: 20px; align-items: start;">
    <!-- Left: Department Breakdown & Recent Joiners -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <!-- Department Workforce Distribution -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Department Workforce Distribution</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Headcount allocation across company departments.</p>
          </div>
          <a href="<?= site_url('departments') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">Manage Departments</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px;">
          <?php foreach ($deptStats as $dept): 
            $pct = ($totalHeadcount > 0) ? round(($dept['employee_count'] / $totalHeadcount) * 100) : 0;
          ?>
            <div>
              <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 5px;">
                <span style="color: var(--color-slate-900);"><?= esc($dept['name']) ?></span>
                <span style="color: var(--color-slate-600);"><?= esc($dept['employee_count']) ?> staff (<?= $pct ?>%)</span>
              </div>
              <div style="width: 100%; height: 7px; background: var(--color-slate-100); border-radius: 99px; overflow: hidden;">
                <div style="width: <?= max($pct, 6) ?>%; height: 100%; background: var(--color-primary); border-radius: 99px;"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Recent Employee Joiners -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Recently Onboarded Employees</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Latest additions to the workforce directory.</p>
          </div>
          <a href="<?= site_url('employees') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">All Employees</a>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
              <tr>
                <th>Code</th>
                <th>Employee Name</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Status</th>
                <th style="text-align: right;">Profile</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentEmp as $emp): ?>
                <tr>
                  <td><code><?= esc($emp['employee_code']) ?></code></td>
                  <td><strong><?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?></strong></td>
                  <td><?= esc($emp['designation_name'] ?? 'Staff') ?></td>
                  <td><?= esc($emp['department_name'] ?? 'General') ?></td>
                  <td><span class="badge badge-success" style="font-size: 10.5px;"><?= ucfirst(esc($emp['employment_status'])) ?></span></td>
                  <td style="text-align: right;">
                    <a href="<?= site_url('employees/view/' . $emp['id']) ?>" class="btn btn-outline btn-sm" style="font-size: 11px; padding: 3px 8px;">360° Profile</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right: HR Quick Actions -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <div class="card" style="padding: 18px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <h4 style="font-size: 14px; font-weight: 700; margin: 0 0 12px 0; color: var(--color-slate-900);">HR Core Workflows</h4>
        <div style="display: flex; flex-direction: column; gap: 8px;">
          <a href="<?= site_url('employees/create') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            ➕ Onboard New Employee
          </a>
          <a href="<?= site_url('leaves') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            📋 Leave Approvals Queue
          </a>
          <a href="<?= site_url('probation') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            ⏳ Probation &amp; Confirmation
          </a>
          <a href="<?= site_url('career-movements') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            🔄 Transfers &amp; Promotions
          </a>
          <a href="<?= site_url('recruitment') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            💼 Recruitment &amp; ATS Pipeline
          </a>
          <a href="<?= site_url('training') ?>" class="btn btn-outline" style="width: 100%; justify-content: flex-start; font-size: 12.5px;">
            🎓 Training &amp; Development
          </a>
        </div>
      </div>
    </div>
  </div>


<!-- ============================================================== -->
<!-- 5. SUPER ADMIN EXECUTIVE GOVERNANCE DASHBOARD                  -->
<!-- ============================================================== -->
<?php else: 
  $gross = $payrollData['monthlyGross'] ?? 0;
  $net   = $payrollData['monthlyNet'] ?? 0;
  $deptStats = $hrData['departmentsWithStats'] ?? [];
  $recentEmp = $hrData['recentEmployees'] ?? [];
  $logs = $recentLogs ?? [];
?>
  <!-- Super Admin Header -->
  <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
    <div>
      <h2 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em; margin: 0;">
        Enterprise Executive Overview
      </h2>
      <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 3px; margin-bottom: 0;">
        Welcome to Infosof Enterprise HRMS &bull; Platform operating under <span class="badge badge-primary">Super Admin</span> governance
      </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <a href="<?= site_url('employees/create') ?>" class="btn btn-primary" style="font-size: 13px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        Onboard Employee
      </a>
      <a href="<?= site_url('payroll') ?>" class="btn btn-outline" style="font-size: 13px;">
        Monthly Payroll
      </a>
      <a href="<?= site_url('audit') ?>" class="btn btn-outline" style="font-size: 13px;">
        Audit Trail
      </a>
      <a href="<?= site_url('roles') ?>" class="btn btn-outline" style="font-size: 13px;">
        Roles &amp; RBAC
      </a>
    </div>
  </div>

  <!-- Super Admin 4 Primary KPI Cards -->
  <div class="grid-4" style="gap: 16px; margin-bottom: 22px;">
    <div class="stat-card" style="box-shadow: var(--shadow-sm); border-radius: 10px;">
      <div class="stat-content">
        <div class="stat-label">Total Workforce</div>
        <div class="stat-value"><?= esc($totalHeadcount) ?></div>
        <div class="stat-subtext"><span style="color: #10b981; font-weight: 600;">&bull; <?= esc($activeEmployees) ?> active</span> across <?= esc($totalBranches) ?> branches</div>
      </div>
      <div class="stat-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
    </div>

    <div class="stat-card sky" style="box-shadow: var(--shadow-sm); border-radius: 10px;">
      <div class="stat-content">
        <div class="stat-label">Departments &amp; Branches</div>
        <div class="stat-value"><?= esc($totalDepartments) ?> / <?= esc($totalBranches) ?></div>
        <div class="stat-subtext">Operating across India</div>
      </div>
      <div class="stat-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
      </div>
    </div>

    <div class="stat-card emerald" style="box-shadow: var(--shadow-sm); border-radius: 10px;">
      <div class="stat-content">
        <div class="stat-label">Monthly Gross Payroll</div>
        <div class="stat-value">₹<?= number_format($gross, 2) ?></div>
        <div class="stat-subtext">Estimated net: ₹<?= number_format($net, 2) ?></div>
      </div>
      <div class="stat-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/>
        </svg>
      </div>
    </div>

    <div class="stat-card amber" style="box-shadow: var(--shadow-sm); border-radius: 10px;">
      <div class="stat-content">
        <div class="stat-label">Pending Approvals</div>
        <div class="stat-value"><?= (int)($hrData['pendingLeaves'] ?? 0) ?></div>
        <div class="stat-subtext"><span style="color: #f59e0b; font-weight: 600;">Action required</span> in queue</div>
      </div>
      <div class="stat-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
    </div>
  </div>

  <!-- Super Admin 2-Column Widgets -->
  <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">
    <!-- Left: Department Headcount Distribution -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div class="card-header" style="padding: 0 0 14px 0; margin-bottom: 14px; border-bottom: 1px solid var(--border-color);">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Department Workforce Distribution</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Enterprise staffing distribution by department.</p>
          </div>
          <a href="<?= site_url('departments') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">Manage Departments</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 14px;">
          <?php foreach ($deptStats as $dept): 
            $pct = ($totalHeadcount > 0) ? round(($dept['employee_count'] / $totalHeadcount) * 100) : 0;
          ?>
            <div>
              <div style="display: flex; justify-content: space-between; font-size: 13px; font-weight: 600; margin-bottom: 5px;">
                <span style="color: var(--color-slate-900);"><?= esc($dept['name']) ?></span>
                <span style="color: var(--color-slate-600);"><?= esc($dept['employee_count']) ?> staff (<?= $pct ?>%)</span>
              </div>
              <div style="width: 100%; height: 7px; background: var(--color-slate-100); border-radius: 99px; overflow: hidden;">
                <div style="width: <?= max($pct, 6) ?>%; height: 100%; background: var(--color-primary); border-radius: 99px;"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Recent Workforce Profiles -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div class="card-header" style="padding: 0 0 14px 0; margin-bottom: 14px; border-bottom: 1px solid var(--border-color);">
          <div>
            <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Recent Workforce Profiles</h3>
            <p style="font-size: 12px; color: var(--color-slate-500); margin: 2px 0 0 0;">Latest employee records in system.</p>
          </div>
          <a href="<?= site_url('employees') ?>" class="btn btn-outline btn-sm" style="font-size: 12px;">View Directory</a>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
            <thead>
              <tr>
                <th>Code</th>
                <th>Employee Name</th>
                <th>Role &bull; Dept</th>
                <th>Status</th>
                <th style="text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentEmp as $emp): ?>
                <tr>
                  <td><code><?= esc($emp['employee_code']) ?></code></td>
                  <td><strong><?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?></strong></td>
                  <td><?= esc($emp['designation_name'] ?? 'Staff') ?> &bull; <?= esc($emp['department_name'] ?? 'General') ?></td>
                  <td><span class="badge badge-success" style="font-size: 10.5px;"><?= ucfirst(esc($emp['employment_status'])) ?></span></td>
                  <td style="text-align: right;">
                    <a href="<?= site_url('employees/view/' . $emp['id']) ?>" class="btn btn-outline btn-sm" style="font-size: 11px; padding: 3px 8px;">360° Profile</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Right: Audit Activity Log Feed -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
      <div class="card" style="padding: 18px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
          <h4 style="font-size: 14px; font-weight: 700; margin: 0; color: var(--color-slate-900);">System Audit Trail</h4>
          <a href="<?= site_url('audit') ?>" style="font-size: 11.5px; color: var(--color-primary); font-weight: 600; text-decoration: none;">Full Trail &rarr;</a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 12px;">
          <?php foreach ($logs as $log): ?>
            <div style="display: flex; gap: 10px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color);">
              <div style="width: 7px; height: 7px; border-radius: 50%; background: var(--color-primary); margin-top: 5px; flex-shrink: 0;"></div>
              <div style="flex: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                  <span class="badge badge-secondary" style="font-size: 9.5px; padding: 1px 5px;"><?= esc($log['action']) ?></span>
                  <span style="font-size: 10.5px; color: var(--color-slate-400);"><?= esc(date('M d, H:i', strtotime($log['created_at']))) ?></span>
                </div>
                <p style="font-size: 12px; color: var(--color-slate-700); margin: 3px 0 0 0; line-height: 1.35;">
                  <?= esc($log['description']) ?>
                </p>
                <div style="font-size: 10.5px; color: var(--color-slate-500); margin-top: 2px;">
                  User: <strong><?= esc($log['username'] ?? 'System') ?></strong>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
