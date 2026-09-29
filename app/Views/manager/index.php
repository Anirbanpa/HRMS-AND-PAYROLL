<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Manager Self-Service (MSS) &amp; Team Hub
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      <?= $isAdmin ? 'Executive & managerial supervision across all enterprise departments.' : 'Direct managerial supervision, live team attendance, and unified approval queues.' ?>
    </p>
  </div>
  <div style="display: flex; align-items: center; gap: 8px;">
    <?php if ($isAdmin): ?>
      <span class="badge badge-primary" style="font-size: 12px; padding: 6px 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: -2px; margin-right: 4px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        Admin Oversight Mode
      </span>
    <?php endif; ?>
    <span class="badge badge-secondary" style="font-size: 12px; padding: 6px 12px;">
      Today: <strong><?= date('M j, Y') ?></strong>
    </span>
  </div>
</div>

<!-- TOP METRIC CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Team Strength</div>
      <div class="stat-value"><?= count($team) ?></div>
      <div class="stat-subtext">Active direct reports</div>
    </div>
    <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Present Today</div>
      <div class="stat-value"><?= count($teamAttendance) ?></div>
      <div class="stat-subtext">Clocked in</div>
    </div>
    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Pending Approvals</div>
      <?php $totalPending = count($pendingLeaves) + count($pendingOvertime) + count($pendingReimbursements) + count($pendingCorrections); ?>
      <div class="stat-value" style="color: <?= $totalPending > 0 ? '#f59e0b' : 'inherit' ?>;"><?= $totalPending ?></div>
      <div class="stat-subtext">Requests awaiting review</div>
    </div>
    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Attendance Rate</div>
      <?php $rate = count($team) > 0 ? round((count($teamAttendance) / count($team)) * 100) : 0; ?>
      <div class="stat-value"><?= $rate ?>%</div>
      <div class="stat-subtext">Daily team coverage</div>
    </div>
    <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>
    </div>
  </div>
</div>

<!-- TEAM ATTENDANCE TODAY -->
<div class="card" style="margin-bottom: 24px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <div>
      <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 2px;">
        <?= $isAdmin ? 'Supervised Employees' : 'Direct Reporting Team' ?> (<?= count($team) ?> Staff)
      </h3>
      <span style="font-size: 12.5px; color: var(--color-slate-500);">Live status &amp; daily punch records</span>
    </div>
  </div>

  <div class="grid-3">
    <?php if (empty($team)): ?>
      <div style="grid-column: span 3; text-align: center; color: var(--color-slate-500); padding: 24px; background: var(--color-slate-50); border-radius: 8px;">
        No active employees currently mapped to this manager queue.
      </div>
    <?php else: ?>
      <?php 
      $attMap = [];
      foreach ($teamAttendance as $ta) {
        $attMap[$ta['employee_id']] = $ta;
      }
      ?>
      <?php foreach ($team as $member): 
        $rec = $attMap[$member['id']] ?? null;
      ?>
        <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--color-slate-50); border-radius: 8px; border: 1px solid var(--color-slate-200);">
          <div style="width: 42px; height: 42px; border-radius: 50%; background: var(--color-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0;">
            <?= esc(substr($member['first_name'], 0, 1) . substr($member['last_name'], 0, 1)) ?>
          </div>
          <div style="flex: 1; min-width: 0;">
            <div style="font-weight: 700; font-size: 13.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
              <?= esc($member['first_name'] . ' ' . $member['last_name']) ?>
            </div>
            <div style="font-size: 11.5px; color: var(--color-slate-500);">
              <?= esc($member['designation_name'] ?? 'Associate') ?> &bull; <?= esc($member['department_name'] ?? 'General') ?>
            </div>
            <div style="margin-top: 4px;">
              <?php if ($rec): ?>
                <span class="badge badge-success" style="font-size: 10.5px; padding: 2px 6px;">
                  Present &bull; In: <?= date('H:i', strtotime($rec['clock_in'])) ?>
                </span>
              <?php else: ?>
                <span class="badge badge-secondary" style="font-size: 10.5px; padding: 2px 6px;">
                  Not Clocked In
                </span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<!-- UNIFIED APPROVAL QUEUES: 4 TABS / SECTIONS -->
<div class="card" style="margin-bottom: 24px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid var(--color-slate-200); padding-bottom: 12px; flex-wrap: wrap; gap: 10px;">
    <div>
      <h3 style="font-size: 16px; font-weight: 700;">Unified Manager Approval Queues</h3>
      <span style="font-size: 12.5px; color: var(--color-slate-500);">Review and act upon pending team requests across 4 operational streams</span>
    </div>
    <div style="display: flex; gap: 8px;">
      <span class="badge badge-warning" style="font-size: 11.5px;">Leaves: <?= count($pendingLeaves) ?></span>
      <span class="badge badge-primary" style="font-size: 11.5px;">Punches: <?= count($pendingCorrections) ?></span>
      <span class="badge badge-info" style="font-size: 11.5px;">Overtime: <?= count($pendingOvertime) ?></span>
      <span class="badge badge-success" style="font-size: 11.5px;">Claims: <?= count($pendingReimbursements) ?></span>
    </div>
  </div>

  <div class="grid-2">
    <!-- 1. PENDING LEAVE REQUESTS -->
    <div style="background: #fafafa; border: 1px solid var(--color-slate-200); border-radius: 8px; padding: 16px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
        <h4 style="font-size: 14.5px; font-weight: 700; color: var(--color-slate-800); display: flex; align-items: center; gap: 6px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          Leave Applications (<?= count($pendingLeaves) ?>)
        </h4>
      </div>

      <?php if (empty($pendingLeaves)): ?>
        <div style="text-align: center; color: var(--color-slate-500); padding: 24px; font-size: 12.5px;">
          No pending leave applications from your team.
        </div>
      <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <?php foreach ($pendingLeaves as $pl): ?>
            <div style="padding: 12px; background: #fff; border-radius: 6px; border: 1px solid var(--color-slate-200); border-left: 3px solid #f59e0b;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                <div>
                  <strong><?= esc($pl['first_name'] . ' ' . $pl['last_name']) ?></strong>
                  <span style="font-size: 11px; color: var(--color-slate-500); margin-left: 4px;">(<?= esc($pl['employee_code']) ?>)</span>
                  <div style="font-size: 12px; color: var(--color-slate-600); margin-top: 2px;">
                    <?= esc($pl['leave_type_name']) ?> &bull; <?= date('M j', strtotime($pl['start_date'])) ?> to <?= date('M j', strtotime($pl['end_date'])) ?> 
                    <strong>(<?= esc($pl['total_days']) ?> days)</strong>
                  </div>
                  <div style="font-size: 12px; margin-top: 4px; color: var(--color-slate-700); font-style: italic;">
                    "<?= esc($pl['reason']) ?>"
                  </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
                  <form action="<?= site_url('manager/leave/approve/' . $pl['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 3px 8px; font-size: 11px; background: #10b981; border-color: #10b981; width: 100%;">
                      Approve
                    </button>
                  </form>
                  <form action="<?= site_url('manager/leave/reject/' . $pl['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <input type="hidden" name="remarks" value="Operational conflict">
                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 3px 8px; font-size: 11px; width: 100%;" onclick="return confirm('Reject this leave request?');">
                      Reject
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- 2. PENDING PUNCH CORRECTIONS -->
    <div style="background: #fafafa; border: 1px solid var(--color-slate-200); border-radius: 8px; padding: 16px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
        <h4 style="font-size: 14.5px; font-weight: 700; color: var(--color-slate-800); display: flex; align-items: center; gap: 6px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Punch Corrections (<?= count($pendingCorrections) ?>)
        </h4>
      </div>

      <?php if (empty($pendingCorrections)): ?>
        <div style="text-align: center; color: var(--color-slate-500); padding: 24px; font-size: 12.5px;">
          No attendance punch corrections requested.
        </div>
      <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <?php foreach ($pendingCorrections as $pc): ?>
            <div style="padding: 12px; background: #fff; border-radius: 6px; border: 1px solid var(--color-slate-200); border-left: 3px solid #6366f1;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                <div>
                  <strong><?= esc($pc['first_name'] . ' ' . $pc['last_name']) ?></strong>
                  <span style="font-size: 11px; color: var(--color-slate-500); margin-left: 4px;">(<?= esc($pc['employee_code']) ?>)</span>
                  <div style="font-size: 12px; color: var(--color-slate-600); margin-top: 2px;">
                    Date: <?= date('M j, Y', strtotime($pc['attendance_date'])) ?> &bull; 
                    Times: <?= date('H:i', strtotime($pc['requested_clock_in'])) ?> &ndash; <?= date('H:i', strtotime($pc['requested_clock_out'])) ?>
                  </div>
                  <div style="font-size: 12px; margin-top: 4px; color: var(--color-slate-700); font-style: italic;">
                    "<?= esc($pc['reason']) ?>"
                  </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
                  <form action="<?= site_url('manager/correction/approve/' . $pc['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 3px 8px; font-size: 11px; background: #10b981; border-color: #10b981; width: 100%;">
                      Approve Punch
                    </button>
                  </form>
                  <form action="<?= site_url('manager/correction/reject/' . $pc['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 3px 8px; font-size: 11px; width: 100%;" onclick="return confirm('Reject punch correction?');">
                      Reject
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- 3. PENDING OVERTIME REQUESTS -->
    <div style="background: #fafafa; border: 1px solid var(--color-slate-200); border-radius: 8px; padding: 16px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
        <h4 style="font-size: 14.5px; font-weight: 700; color: var(--color-slate-800); display: flex; align-items: center; gap: 6px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0ea5e9" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 10"/></svg>
          Overtime Requests (<?= count($pendingOvertime) ?>)
        </h4>
      </div>

      <?php if (empty($pendingOvertime)): ?>
        <div style="text-align: center; color: var(--color-slate-500); padding: 24px; font-size: 12.5px;">
          No overtime approvals in queue.
        </div>
      <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <?php foreach ($pendingOvertime as $ot): ?>
            <div style="padding: 12px; background: #fff; border-radius: 6px; border: 1px solid var(--color-slate-200); border-left: 3px solid #0ea5e9;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                <div>
                  <strong><?= esc($ot['first_name'] . ' ' . $ot['last_name']) ?></strong>
                  <span style="font-size: 11px; color: var(--color-slate-500); margin-left: 4px;">(<?= esc($ot['employee_code']) ?>)</span>
                  <div style="font-size: 12px; color: var(--color-slate-600); margin-top: 2px;">
                    Date: <?= date('M j, Y', strtotime($ot['request_date'])) ?> &bull; 
                    <strong><?= esc($ot['total_hours']) ?> Hours</strong> (<?= date('H:i', strtotime($ot['start_time'])) ?> - <?= date('H:i', strtotime($ot['end_time'])) ?>)
                  </div>
                  <div style="font-size: 12px; margin-top: 4px; color: var(--color-slate-700); font-style: italic;">
                    "<?= esc($ot['reason']) ?>"
                  </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
                  <form action="<?= site_url('manager/overtime/approve/' . $ot['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 3px 8px; font-size: 11px; background: #10b981; border-color: #10b981; width: 100%;">
                      Approve OT
                    </button>
                  </form>
                  <form action="<?= site_url('manager/overtime/reject/' . $ot['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 3px 8px; font-size: 11px; width: 100%;" onclick="return confirm('Reject overtime?');">
                      Reject
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- 4. PENDING EXPENSE REIMBURSEMENTS -->
    <div style="background: #fafafa; border: 1px solid var(--color-slate-200); border-radius: 8px; padding: 16px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
        <h4 style="font-size: 14.5px; font-weight: 700; color: var(--color-slate-800); display: flex; align-items: center; gap: 6px;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
          Reimbursement Claims (<?= count($pendingReimbursements) ?>)
        </h4>
      </div>

      <?php if (empty($pendingReimbursements)): ?>
        <div style="text-align: center; color: var(--color-slate-500); padding: 24px; font-size: 12.5px;">
          No expense claims awaiting manager endorsement.
        </div>
      <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 10px;">
          <?php foreach ($pendingReimbursements as $rc): ?>
            <div style="padding: 12px; background: #fff; border-radius: 6px; border: 1px solid var(--color-slate-200); border-left: 3px solid #10b981;">
              <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                <div>
                  <strong><?= esc($rc['first_name'] . ' ' . $rc['last_name']) ?></strong>
                  <span style="font-size: 11px; color: var(--color-slate-500); margin-left: 4px;">(<?= esc($rc['claim_number']) ?>)</span>
                  <div style="font-size: 12px; color: var(--color-slate-600); margin-top: 2px;">
                    <?= esc($rc['claim_title']) ?> &bull; <strong style="color: #10b981;">₹<?= number_format((float)$rc['amount'], 2) ?></strong>
                  </div>
                  <div style="font-size: 11.5px; color: var(--color-slate-500); margin-top: 2px;">
                    Category: <?= esc($rc['category_name']) ?> &bull; Date: <?= date('M j, Y', strtotime($rc['expense_date'])) ?>
                  </div>
                  <?php if (!empty($rc['receipt_path'])): ?>
                    <div style="margin-top: 4px;">
                      <a href="<?= base_url($rc['receipt_path']) ?>" target="_blank" style="font-size: 11.5px; color: var(--color-primary); text-decoration: underline;">
                        View Receipt Attachment
                      </a>
                    </div>
                  <?php endif; ?>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
                  <form action="<?= site_url('manager/reimbursement/approve/' . $rc['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 3px 8px; font-size: 11px; background: #10b981; border-color: #10b981; width: 100%;">
                      Endorse Claim
                    </button>
                  </form>
                  <form action="<?= site_url('manager/reimbursement/reject/' . $rc['id']) ?>" method="POST" style="margin: 0;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 3px 8px; font-size: 11px; width: 100%;" onclick="return confirm('Reject expense claim?');">
                      Reject
                    </button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
