<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Overtime Management &amp; Approvals
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Employee overtime applications, multi-tier approvals, hourly wage rates, and payroll integration.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalApplyOvertime').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Apply Overtime
    </button>
  </div>
</div>

<!-- STATS SUMMARY -->
<div class="grid-3" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Pending Approval</div>
      <div class="stat-value"><?= esc($pendingCount) ?></div>
      <div class="stat-subtext">Requests awaiting review</div>
    </div>
    <div class="stat-icon amber">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Approved Overtime Hours</div>
      <div class="stat-value"><?= number_format($totalHoursApproved, 1) ?> hrs</div>
      <div class="stat-subtext">Cumulative approved volume</div>
    </div>
    <div class="stat-icon emerald">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Overtime Payout</div>
      <div class="stat-value">₹<?= number_format($totalPayoutApproved, 2) ?></div>
      <div class="stat-subtext">Computed wage value for payroll</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
    </div>
  </div>
</div>

<!-- OVERTIME REQUESTS TABLE -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h3 style="font-size: 16px; font-weight: 700;">Overtime Requests Register</h3>
    <div style="display: flex; gap: 8px;">
      <a href="<?= site_url('overtime') ?>" class="btn btn-secondary btn-sm">All</a>
      <a href="<?= site_url('overtime?status=pending') ?>" class="btn btn-secondary btn-sm">Pending</a>
      <a href="<?= site_url('overtime?status=hr_approved') ?>" class="btn btn-secondary btn-sm">Approved</a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Date</th>
          <th>Hours &amp; Timing</th>
          <th>Multiplier / Rule</th>
          <th>Computed Payout</th>
          <th>Status</th>
          <?php if ($isManager): ?><th>Actions</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($requests)): ?>
          <tr><td colspan="<?= $isManager ? '7' : '6' ?>" style="text-align: center; color: var(--color-slate-500); padding: 24px;">No overtime claims recorded.</td></tr>
        <?php else: ?>
          <?php foreach ($requests as $r): ?>
            <tr>
              <td>
                <strong><?= esc($r['first_name'] . ' ' . $r['last_name']) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($r['department_name'] ?? 'General') ?> &bull; <?= esc($r['employee_code']) ?></div>
              </td>
              <td>
                <strong><?= date('M j, Y', strtotime($r['request_date'])) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc(substr($r['reason'], 0, 30)) ?>...</div>
              </td>
              <td>
                <strong><?= esc($r['total_hours']) ?> hrs</strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= date('H:i', strtotime($r['start_time'])) ?> - <?= date('H:i', strtotime($r['end_time'])) ?></div>
              </td>
              <td>
                <span class="badge badge-info"><?= esc($r['rule_name'] ?? 'Standard') ?> (<?= esc($r['rate_multiplier'] ?? '1.50') ?>x)</span>
              </td>
              <td>
                <?php if ((float)$r['payout_amount'] > 0): ?>
                  <strong style="color: var(--color-emerald-600);">₹<?= number_format((float)$r['payout_amount'], 2) ?></strong>
                  <div style="font-size: 11px; color: var(--color-slate-500);">Rate: ₹<?= number_format((float)$r['hourly_rate'], 2) ?>/hr</div>
                <?php else: ?>
                  <span style="color: var(--color-slate-400);">Calculated on approval</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($r['status'] === 'pending'): ?>
                  <span class="badge badge-warning">Pending Review</span>
                <?php elseif (in_array($r['status'], ['manager_approved', 'hr_approved'])): ?>
                  <span class="badge badge-success">Approved</span>
                <?php elseif ($r['status'] === 'payroll_processed'): ?>
                  <span class="badge badge-primary">Paid in Payroll</span>
                <?php else: ?>
                  <span class="badge badge-danger">Rejected</span>
                <?php endif; ?>
              </td>
              <?php if ($isManager): ?>
                <td>
                  <?php if ($r['status'] === 'pending'): ?>
                    <div style="display: flex; gap: 6px;">
                      <form action="<?= site_url('overtime/approve/' . $r['id']) ?>" method="POST" style="margin: 0;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-success btn-sm" style="background-color: #059669; border-color: #047857; color: #ffffff !important; padding: 5px 12px; font-weight: 600; cursor: pointer; border-radius: 6px;">
                          Approve
                        </button>
                      </form>
                      <form action="<?= site_url('overtime/reject/' . $r['id']) ?>" method="POST" style="margin: 0;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm" style="background-color: #dc2626; border-color: #b91c1c; color: #ffffff !important; padding: 5px 12px; font-weight: 600; cursor: pointer; border-radius: 6px;" onclick="return confirm('Reject this overtime claim?');">
                          Reject
                        </button>
                      </form>
                    </div>
                  <?php else: ?>
                    <span style="font-size: 12px; color: var(--color-slate-400);">Reviewed</span>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL: APPLY OVERTIME -->
<div id="modalApplyOvertime" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Submit Overtime Claim</h3>
      <button type="button" onclick="document.getElementById('modalApplyOvertime').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('overtime/apply') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Overtime Date *</label>
        <input type="date" name="request_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Start Time *</label>
          <input type="time" name="start_time" class="form-control" value="18:30" required>
        </div>
        <div class="form-group">
          <label class="form-label">End Time *</label>
          <input type="time" name="end_time" class="form-control" value="21:30" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Applicable Rule / Multiplier</label>
        <select name="overtime_rule_id" class="form-control">
          <?php foreach ($rules as $rl): ?>
            <option value="<?= $rl['id'] ?>">
              <?= esc($rl['name']) ?> (<?= esc($rl['rate_multiplier']) ?>x)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Reason / Work Justification *</label>
        <textarea name="reason" class="form-control" rows="3" placeholder="Provide business justification and tasks performed during overtime" required></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalApplyOvertime').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Overtime</button>
      </div>
    </form>
  </div>
</div>
