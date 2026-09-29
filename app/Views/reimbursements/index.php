<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Expense Reimbursements &amp; Claims
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Employee expense claims, receipt validation, dual-stage approvals, and payroll reimbursement payouts.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalApplyClaim').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Submit Claim
    </button>
  </div>
</div>

<!-- STATS SUMMARY -->
<div class="grid-3" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Pending Verification</div>
      <div class="stat-value"><?= esc($pendingCount) ?></div>
      <div class="stat-subtext">Awaiting manager or finance sign-off</div>
    </div>
    <div class="stat-icon amber">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Approved &amp; Disbursed</div>
      <div class="stat-value" style="color: var(--color-emerald-600);">₹<?= number_format($totalPaid, 2) ?></div>
      <div class="stat-subtext">Disbursed to employees</div>
    </div>
    <div class="stat-icon emerald">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Claims Submitted</div>
      <div class="stat-value">₹<?= number_format($totalClaimed, 2) ?></div>
      <div class="stat-subtext">Gross claim filings</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
    </div>
  </div>
</div>

<!-- CLAIMS TABLE -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h3 style="font-size: 16px; font-weight: 700;">Reimbursement Claims Portfolio</h3>
    <div style="display: flex; gap: 8px;">
      <a href="<?= site_url('reimbursements') ?>" class="btn btn-secondary btn-sm">All</a>
      <a href="<?= site_url('reimbursements?status=submitted') ?>" class="btn btn-secondary btn-sm">Pending Manager</a>
      <a href="<?= site_url('reimbursements?status=manager_approved') ?>" class="btn btn-secondary btn-sm">Pending Finance</a>
      <a href="<?= site_url('reimbursements?status=finance_approved') ?>" class="btn btn-secondary btn-sm">Approved</a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Claim No &amp; Title</th>
          <th>Employee</th>
          <th>Category</th>
          <th>Date</th>
          <th>Claimed</th>
          <th>Receipt</th>
          <th>Status</th>
          <?php if ($isFinance): ?><th>Action</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($claims)): ?>
          <tr><td colspan="<?= $isFinance ? '8' : '7' ?>" style="text-align: center; color: var(--color-slate-500); padding: 24px;">No expense claims recorded.</td></tr>
        <?php else: ?>
          <?php foreach ($claims as $c): ?>
            <tr>
              <td>
                <strong><?= esc($c['claim_title']) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($c['claim_number']) ?></div>
              </td>
              <td>
                <strong><?= esc($c['first_name'] . ' ' . $c['last_name']) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($c['employee_code']) ?></div>
              </td>
              <td>
                <span class="badge badge-info"><?= esc($c['category_name']) ?></span>
              </td>
              <td><?= date('M j, Y', strtotime($c['expense_date'])) ?></td>
              <td>
                <strong>₹<?= number_format((float)$c['amount'], 2) ?></strong>
                <?php if ((float)$c['approved_amount'] > 0 && (float)$c['approved_amount'] !== (float)$c['amount']): ?>
                  <div style="font-size: 11px; color: var(--color-emerald-600);">Approved: ₹<?= number_format((float)$c['approved_amount'], 2) ?></div>
                <?php endif; ?>
              </td>
              <td>
                <?php if (!empty($c['receipt_path'])): ?>
                  <a href="<?= base_url(esc($c['receipt_path'])) ?>" target="_blank" class="btn btn-secondary btn-sm" style="padding: 2px 8px; font-size: 11.5px;">
                    View Receipt &rarr;
                  </a>
                <?php else: ?>
                  <span style="font-size: 12px; color: var(--color-slate-400);">None</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($c['status'] === 'submitted'): ?>
                  <span class="badge badge-warning">Awaiting Manager</span>
                <?php elseif ($c['status'] === 'manager_approved'): ?>
                  <span class="badge badge-info">Awaiting Finance</span>
                <?php elseif ($c['status'] === 'finance_approved'): ?>
                  <span class="badge badge-success">Approved for Payout</span>
                <?php elseif ($c['status'] === 'payroll_processed'): ?>
                  <span class="badge badge-primary">Paid via Payroll</span>
                <?php else: ?>
                  <span class="badge badge-danger">Rejected</span>
                <?php endif; ?>
              </td>
              <?php if ($isFinance): ?>
                <td>
                  <?php if (in_array($c['status'], ['submitted', 'manager_approved'])): ?>
                    <div style="display: flex; gap: 6px; align-items: center;">
                      <form action="<?= site_url('reimbursements/approve/' . $c['id']) ?>" method="POST" style="margin: 0; display: inline-flex;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="approved_amount" value="<?= esc($c['amount']) ?>">
                        <button type="submit" class="btn btn-success btn-sm" style="background-color: #059669; border-color: #047857; color: #ffffff !important; padding: 5px 12px; font-weight: 600; cursor: pointer; border-radius: 6px;">
                          Approve
                        </button>
                      </form>
                      <form action="<?= site_url('reimbursements/reject/' . $c['id']) ?>" method="POST" style="margin: 0; display: inline-flex;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm" style="background-color: #dc2626; border-color: #b91c1c; color: #ffffff !important; padding: 5px 12px; font-weight: 600; cursor: pointer; border-radius: 6px;" onclick="return confirm('Reject this reimbursement claim?');">
                          Reject
                        </button>
                      </form>
                    </div>
                  <?php else: ?>
                    <span style="font-size: 12px; color: var(--color-slate-400);">Settled</span>
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

<!-- MODAL: APPLY REIMBURSEMENT -->
<div id="modalApplyClaim" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 500px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Submit Expense Reimbursement</h3>
      <button type="button" onclick="document.getElementById('modalApplyClaim').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('reimbursements/apply') ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Expense Category *</label>
        <select name="expense_category_id" class="form-control" required>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>">
              <?= esc($cat['name']) ?> (Max: ₹<?= number_format((float)($cat['max_limit_per_claim'] ?? 500), 0) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Claim Title *</label>
        <input type="text" name="claim_title" class="form-control" placeholder="e.g. Client Dinner at Financial Center" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Expense Date *</label>
          <input type="date" name="expense_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Amount (₹) *</label>
          <input type="number" step="0.01" name="amount" class="form-control" placeholder="120.00" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Attach Receipt / Invoice (PDF / PNG / JPG)</label>
        <input type="file" name="receipt" class="form-control" accept="image/*,.pdf">
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Business Justification *</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Provide business justification for this expense claim" required></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalApplyClaim').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Claim</button>
      </div>
    </form>
  </div>
</div>
