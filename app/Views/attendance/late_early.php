<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Late Coming &amp; Early Leaving Management
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Automated shift punctuality tracking, grace period thresholds, waiver approvals, and payroll impact auditing.
    </p>
  </div>
  <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
    <form method="GET" action="<?= site_url('attendance/late-early') ?>" style="display: flex; align-items: center; gap: 6px; margin: 0;">
      <input type="month" name="month" class="form-control" style="padding: 6px 12px; font-size: 13px;" value="<?= esc($selectedMonth) ?>" onchange="this.form.submit()">
    </form>
    <?php if ($isHR): ?>
      <button type="button" class="btn btn-outline" onclick="document.getElementById('modalConfigPolicy').style.display='flex'">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: -2px; margin-right: 4px;"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
        Configure Thresholds
      </button>
    <?php endif; ?>
  </div>
</div>

<!-- TOP KPI METRIC CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Late Arrivals</div>
      <div class="stat-value" style="color: #f59e0b;"><?= $lateCount ?></div>
      <div class="stat-subtext">Cumulative: <strong><?= $totalLateMinutes ?> mins</strong></div>
    </div>
    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Early Departures</div>
      <div class="stat-value" style="color: #ef4444;"><?= $earlyCount ?></div>
      <div class="stat-subtext">Cumulative: <strong><?= $totalEarlyMinutes ?> mins</strong></div>
    </div>
    <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 8 14"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Waived Instances</div>
      <div class="stat-value" style="color: #10b981;"><?= $waivedCount ?></div>
      <div class="stat-subtext">Authorized exemptions</div>
    </div>
    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Active Rule Tolerance</div>
      <div class="stat-value"><?= (int)($activePolicy['grace_period_mins'] ?? 15) ?>m</div>
      <div class="stat-subtext">Max <?= (int)($activePolicy['max_monthly_late_count'] ?? 3) ?> allowed / mo</div>
    </div>
    <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    </div>
  </div>
</div>

<!-- FLAGGED PUNCHES TABLE -->
<div class="card" style="margin-bottom: 24px;">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <div class="card-title">Flagged Punctuality Exceptions (<?= count($flaggedLogs) ?>)</div>
      <span style="font-size: 12.5px; color: var(--color-slate-500);">Shift breaches for <?= date('F Y', strtotime($selectedMonth . '-01')) ?></span>
    </div>
  </div>
  <div class="card-body" style="padding: 0;">
    <div class="table-responsive">
      <table class="table" style="margin-bottom: 0;">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Date &amp; Shift</th>
            <th>Scheduled In/Out</th>
            <th>Actual Punches</th>
            <th>Late Mins</th>
            <th>Early Mins</th>
            <th>Waiver Status</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($flaggedLogs)): ?>
            <tr>
              <td colspan="8" style="text-align: center; color: var(--color-slate-500); padding: 32px;">
                No late arrivals or early departures logged for this period. Perfect punctuality!
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($flaggedLogs as $log): ?>
              <tr>
                <td>
                  <strong><?= esc($log['first_name'] . ' ' . $log['last_name']) ?></strong>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($log['employee_code']) ?> &bull; <?= esc($log['department_name'] ?? 'General') ?></div>
                </td>
                <td>
                  <strong><?= date('M j, Y', strtotime($log['date'])) ?></strong>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($log['shift_name'] ?? 'Standard Shift') ?></div>
                </td>
                <td>
                  <?= $log['shift_start'] ? date('H:i', strtotime($log['shift_start'])) : '09:00' ?> &ndash; 
                  <?= $log['shift_end'] ? date('H:i', strtotime($log['shift_end'])) : '18:00' ?>
                </td>
                <td>
                  <span style="font-weight: 600; color: <?= $log['late_minutes'] > 0 ? '#f59e0b' : 'inherit' ?>;">
                    In: <?= $log['clock_in'] ? date('H:i', strtotime($log['clock_in'])) : '--:--' ?>
                  </span><br>
                  <span style="font-size: 12px; color: <?= $log['early_leaving_minutes'] > 0 ? '#ef4444' : 'inherit' ?>;">
                    Out: <?= $log['clock_out'] ? date('H:i', strtotime($log['clock_out'])) : '--:--' ?>
                  </span>
                </td>
                <td>
                  <?php if ($log['late_minutes'] > 0): ?>
                    <span class="badge badge-warning">+<?= esc($log['late_minutes']) ?>m Late</span>
                  <?php else: ?>
                    <span style="color: #94a3b8;">--</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($log['early_leaving_minutes'] > 0): ?>
                    <span class="badge badge-danger">-<?= esc($log['early_leaving_minutes']) ?>m Early</span>
                  <?php else: ?>
                    <span style="color: #94a3b8;">--</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($log['late_waived']) || !empty($log['early_exit_waived'])): ?>
                    <span class="badge badge-success" title="Waived: <?= esc($log['waived_reason']) ?>">Waived</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Unwaived</span>
                  <?php endif; ?>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <?php if (empty($log['late_waived']) && empty($log['early_exit_waived'])): ?>
                    <button type="button" class="btn btn-outline btn-sm" onclick="openWaiverModal(<?= (int)$log['id'] ?>, '<?= esc($log['first_name'] . ' ' . $log['last_name']) ?>', '<?= esc($log['date']) ?>', <?= (int)$log['late_minutes'] ?>, <?= (int)$log['early_leaving_minutes'] ?>)">
                      Request Waiver
                    </button>
                  <?php else: ?>
                    <span style="font-size: 11.5px; color: #10b981; font-weight: 600;">Authorized</span>
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

<!-- WAIVER APPROVAL QUEUE TABLE -->
<div class="card">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <div class="card-title">Waiver Requests &amp; Audit Trail (<?= count($waivers) ?>)</div>
      <span style="font-size: 12.5px; color: var(--color-slate-500);">Managerial and HR exemption approvals</span>
    </div>
  </div>
  <div class="card-body" style="padding: 0;">
    <div class="table-responsive">
      <table class="table" style="margin-bottom: 0;">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Date &amp; Type</th>
            <th>Minutes</th>
            <th>Reason &amp; Remarks</th>
            <th>Status</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($waivers)): ?>
            <tr>
              <td colspan="6" style="text-align: center; color: var(--color-slate-500); padding: 24px;">
                No waiver applications logged in this queue.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($waivers as $w): ?>
              <tr>
                <td>
                  <strong><?= esc($w['first_name'] . ' ' . $w['last_name']) ?></strong>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($w['employee_code']) ?></div>
                </td>
                <td>
                  <strong><?= date('M j, Y', strtotime($w['waiver_date'])) ?></strong>
                  <div style="font-size: 11.5px; text-transform: capitalize; color: var(--color-slate-600);"><?= str_replace('_', ' ', $w['waiver_type']) ?></div>
                </td>
                <td><strong><?= esc($w['minutes_recorded']) ?> mins</strong></td>
                <td>
                  <div style="font-size: 12.5px; max-width: 320px; white-space: normal; line-height: 1.4;">
                    <em>"<?= esc($w['reason']) ?>"</em>
                  </div>
                  <?php if (!empty($w['manager_remarks'])): ?>
                    <div style="font-size: 11px; color: #10b981; margin-top: 4px;">Mgr: <?= esc($w['manager_remarks']) ?></div>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($w['status'] === 'pending'): ?>
                    <span class="badge badge-warning">Pending Review</span>
                  <?php elseif (in_array($w['status'], ['manager_approved', 'hr_approved'])): ?>
                    <span class="badge badge-success">Approved / Waived</span>
                  <?php else: ?>
                    <span class="badge badge-danger">Rejected</span>
                  <?php endif; ?>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <?php if ($w['status'] === 'pending' && ($isHR || $isManager)): ?>
                    <form action="<?= site_url('attendance/late-early/waive-action/' . $w['id']) ?>" method="POST" style="display: inline-block; margin: 0;">
                      <?= csrf_field() ?>
                      <input type="hidden" name="action" value="approve">
                      <input type="hidden" name="remarks" value="Approved by supervisor">
                      <button type="submit" class="btn btn-primary btn-sm" style="padding: 3px 8px; font-size: 11px; background: #10b981; border-color: #10b981;">
                        Approve
                      </button>
                    </form>
                    <form action="<?= site_url('attendance/late-early/waive-action/' . $w['id']) ?>" method="POST" style="display: inline-block; margin: 0;">
                      <?= csrf_field() ?>
                      <input type="hidden" name="action" value="reject">
                      <input type="hidden" name="remarks" value="Waiver rejected">
                      <button type="submit" class="btn btn-danger btn-sm" style="padding: 3px 8px; font-size: 11px;" onclick="return confirm('Reject this waiver?');">
                        Reject
                      </button>
                    </form>
                  <?php else: ?>
                    <span style="font-size: 11.5px; color: #94a3b8;">Processed</span>
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

<!-- MODAL: CONFIGURE THRESHOLD POLICY -->
<?php if ($isHR): ?>
<div id="modalConfigPolicy" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 520px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="card-title">Late &amp; Early Leaving Threshold Policy</div>
      <button type="button" onclick="document.getElementById('modalConfigPolicy').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form action="<?= site_url('attendance/late-early/policy') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= esc($activePolicy['id'] ?? '') ?>">

        <div class="form-group">
          <label class="form-label">Policy Name *</label>
          <input type="text" name="name" class="form-control" required value="<?= esc($activePolicy['name'] ?? 'Standard Enterprise Attendance Policy') ?>">
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Policy Code *</label>
            <input type="text" name="policy_code" class="form-control" required value="<?= esc($activePolicy['policy_code'] ?? 'LE-POL-STD') ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Grace Period (Minutes) *</label>
            <input type="number" name="grace_period_mins" class="form-control" min="0" max="120" required value="<?= esc($activePolicy['grace_period_mins'] ?? 15) ?>">
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Early Exit Tolerance (Mins) *</label>
            <input type="number" name="early_exit_tolerance_mins" class="form-control" min="0" max="120" required value="<?= esc($activePolicy['early_exit_tolerance_mins'] ?? 15) ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Monthly Late Limit *</label>
            <input type="number" name="max_monthly_late_count" class="form-control" min="1" max="10" required value="<?= esc($activePolicy['max_monthly_late_count'] ?? 3) ?>">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Payroll Penalty Rule (When Limit Exceeded) *</label>
          <select name="deduction_rule" class="form-control" required>
            <option value="none" <?= ($activePolicy['deduction_rule'] ?? '') === 'none' ? 'selected' : '' ?>>None (Warning Only)</option>
            <option value="quarter_day" <?= ($activePolicy['deduction_rule'] ?? '') === 'quarter_day' ? 'selected' : '' ?>>Quarter Day Salary Deduction</option>
            <option value="half_day" <?= ($activePolicy['deduction_rule'] ?? '') === 'half_day' ? 'selected' : '' ?>>Half Day Salary Deduction (Standard)</option>
            <option value="full_day" <?= ($activePolicy['deduction_rule'] ?? '') === 'full_day' ? 'selected' : '' ?>>Full Day Salary Deduction</option>
          </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalConfigPolicy').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Policy Rules</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- MODAL: REQUEST WAIVER -->
<div id="modalRequestWaiver" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 480px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="card-title">Request Exception Waiver</div>
      <button type="button" onclick="document.getElementById('modalRequestWaiver').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form action="<?= site_url('attendance/late-early/waive-request') ?>" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="attendance_id" id="waiverAttendanceId">

        <div style="padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 16px; font-size: 13px;">
          <div>Employee: <strong id="waiverEmpName">--</strong></div>
          <div style="margin-top: 4px;">Date: <strong id="waiverDate">--</strong></div>
        </div>

        <div class="form-group">
          <label class="form-label">Waiver Type *</label>
          <select name="waiver_type" id="waiverTypeSelect" class="form-control" required>
            <option value="late_arrival">Late Arrival</option>
            <option value="early_departure">Early Departure</option>
            <option value="both">Both Late &amp; Early</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Justification / Reason *</label>
          <textarea name="reason" class="form-control" rows="3" placeholder="Provide valid business or transit reason..." required></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalRequestWaiver').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit Waiver Request</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openWaiverModal(attId, empName, attDate, lateMins, earlyMins) {
  document.getElementById('waiverAttendanceId').value = attId;
  document.getElementById('waiverEmpName').textContent = empName;
  document.getElementById('waiverDate').textContent = attDate;
  const sel = document.getElementById('waiverTypeSelect');
  if (lateMins > 0 && earlyMins > 0) {
    sel.value = 'both';
  } else if (earlyMins > 0) {
    sel.value = 'early_departure';
  } else {
    sel.value = 'late_arrival';
  }
  document.getElementById('modalRequestWaiver').style.display = 'flex';
}
</script>
