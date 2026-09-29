<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Bonus, Incentive &amp; Sales Commissions
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Manage performance incentives, executive spot awards, sales commissions, and monthly payroll batches.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalAddIncentive').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Assign Bonus / Incentive
    </button>
  </div>
</div>

<!-- SCHEMES OVERVIEW -->
<div class="grid-4" style="margin-bottom: 24px;">
  <?php foreach ($schemes as $sch): ?>
    <div class="card" style="border-top: 3px solid var(--color-primary);">
      <span class="badge badge-info" style="font-size: 11px; text-transform: uppercase;">
        <?= esc(str_replace('_', ' ', $sch['scheme_type'])) ?>
      </span>
      <h3 style="font-size: 15px; font-weight: 700; margin-top: 8px;"><?= esc($sch['title']) ?></h3>
      <div style="font-size: 12px; color: var(--color-slate-500); margin-top: 4px;">
        Type: <?= esc(str_replace('_', ' ', $sch['calculation_type'])) ?>
      </div>
      <div style="font-size: 18px; font-weight: 800; color: var(--color-emerald-600); margin-top: 10px;">
        <?php if ($sch['calculation_type'] === 'fixed_amount'): ?>
          ₹<?= number_format((float)$sch['default_value'], 2) ?>
        <?php else: ?>
          <?= esc($sch['default_value']) ?>% of Base
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- INCENTIVE ENTRIES TABLE -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h3 style="font-size: 16px; font-weight: 700;">Incentive &amp; Commission Disbursal Register</h3>
    <span style="font-size: 13px; color: var(--color-slate-500);">Total Batched: ₹<?= number_format($totalAllocated, 2) ?></span>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Scheme</th>
          <th>Period</th>
          <th>Allocated Amount</th>
          <th>Status</th>
          <th>Processed By</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($incentives)): ?>
          <tr><td colspan="6" style="text-align: center; color: var(--color-slate-500); padding: 24px;">No incentive or bonus allocations recorded yet.</td></tr>
        <?php else: ?>
          <?php foreach ($incentives as $inc): ?>
            <tr>
              <td>
                <strong><?= esc($inc['first_name'] . ' ' . $inc['last_name']) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($inc['employee_code']) ?></div>
              </td>
              <td>
                <strong><?= esc($inc['scheme_title']) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($inc['notes'] ?? 'Performance milestone') ?></div>
              </td>
              <td><span class="badge badge-secondary"><?= esc($inc['reference_period']) ?></span></td>
              <td>
                <strong style="color: var(--color-emerald-600); font-size: 15px;">
                  ₹<?= number_format((float)$inc['final_amount'], 2) ?>
                </strong>
              </td>
              <td>
                <?php if ($inc['status'] === 'hr_approved'): ?>
                  <span class="badge badge-success">Approved for Payroll</span>
                <?php elseif ($inc['status'] === 'payroll_batched'): ?>
                  <span class="badge badge-primary">Processed in Payroll</span>
                <?php else: ?>
                  <span class="badge badge-warning"><?= esc(ucfirst($inc['status'])) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <span style="font-size: 12.5px;"><?= esc($inc['approver_name'] ?? 'System') ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL: ADD INCENTIVE -->
<div id="modalAddIncentive" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Record Incentive / Commission</h3>
      <button type="button" onclick="document.getElementById('modalAddIncentive').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('bonuses/entry') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Employee *</label>
        <select name="employee_id" class="form-control" required>
          <option value="">-- Choose Employee --</option>
          <?php foreach ($employees as $e): ?>
            <option value="<?= $e['id'] ?>">
              <?= esc($e['first_name'] . ' ' . $e['last_name']) ?> (<?= esc($e['employee_code']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Bonus / Incentive Scheme *</label>
        <select name="bonus_scheme_id" class="form-control" required>
          <?php foreach ($schemes as $s): ?>
            <option value="<?= $s['id'] ?>"><?= esc($s['title']) ?> (<?= esc($s['scheme_code']) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Reference Period *</label>
          <input type="text" name="reference_period" class="form-control" value="<?= date('Y-m') ?>" placeholder="e.g. 2026-Q1 or 2026-03" required>
        </div>
        <div class="form-group">
          <label class="form-label">Amount (₹) *</label>
          <input type="number" step="0.01" name="final_amount" class="form-control" placeholder="500.00" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Justification / KPI Milestone</label>
        <input type="text" name="notes" class="form-control" placeholder="e.g. Exceeded Q1 enterprise sales target by 140%">
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddIncentive').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Allocate &amp; Approve</button>
      </div>
    </form>
  </div>
</div>
