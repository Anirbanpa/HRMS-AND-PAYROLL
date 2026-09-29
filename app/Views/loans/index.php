<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Salary Advance &amp; Employee Loans
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Manage employee loans, salary advances, automated EMI deductions, and repayment balance histories.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalApplyLoan').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Apply for Loan / Advance
    </button>
  </div>
</div>

<!-- STATS SUMMARY -->
<div class="grid-3" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Active Loans Count</div>
      <div class="stat-value"><?= esc($activeLoansCount) ?></div>
      <div class="stat-subtext">Currently amortizing</div>
    </div>
    <div class="stat-icon emerald">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Outstanding Balance</div>
      <div class="stat-value" style="color: var(--color-rose-600);">₹<?= number_format($totalOutstanding, 2) ?></div>
      <div class="stat-subtext">Remaining to be deducted</div>
    </div>
    <div class="stat-icon amber">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Principal Disbursed</div>
      <div class="stat-value">₹<?= number_format($totalDisbursed, 2) ?></div>
      <div class="stat-subtext">Cumulative loan issuance</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
  </div>
</div>

<!-- LOANS TABLE -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h3 style="font-size: 16px; font-weight: 700;">Loan Applications &amp; Amortization Portfolio</h3>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Loan No &amp; Employee</th>
          <th>Type</th>
          <th>Principal &amp; Tenure</th>
          <th>Monthly EMI</th>
          <th>Repayment Progress</th>
          <th>Status</th>
          <?php if ($isFinance): ?><th>Action</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($loans)): ?>
          <tr><td colspan="<?= $isFinance ? '7' : '6' ?>" style="text-align: center; color: var(--color-slate-500); padding: 24px;">No loan or advance records found.</td></tr>
        <?php else: ?>
          <?php foreach ($loans as $l): ?>
            <tr>
              <td>
                <strong><?= esc($l['loan_application_no']) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($l['first_name'] . ' ' . $l['last_name']) ?> (<?= esc($l['employee_code']) ?>)</div>
              </td>
              <td>
                <span class="badge badge-info" style="font-size: 11px; text-transform: uppercase;">
                  <?= esc(str_replace('_', ' ', $l['loan_type'])) ?>
                </span>
              </td>
              <td>
                <strong>₹<?= number_format((float)$l['principal_amount'], 2) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($l['tenure_months']) ?> installments</div>
              </td>
              <td>
                <strong style="color: var(--color-primary);">₹<?= number_format((float)$l['monthly_emi'], 2) ?>/mo</strong>
              </td>
              <td style="width: 200px;">
                <div style="display: flex; justify-content: space-between; font-size: 11.5px; margin-bottom: 4px;">
                  <span>Paid: ₹<?= number_format((float)$l['total_paid'], 0) ?></span>
                  <span>Bal: ₹<?= number_format((float)$l['outstanding_balance'], 0) ?></span>
                </div>
                <?php 
                  $percent = ($l['total_repayable'] > 0) ? min(100, round(($l['total_paid'] / $l['total_repayable']) * 100)) : 0;
                ?>
                <div style="background: var(--color-slate-200); height: 6px; border-radius: 3px; overflow: hidden;">
                  <div style="background: var(--color-emerald-500); height: 100%; width: <?= $percent ?>%;"></div>
                </div>
              </td>
              <td>
                <?php if ($l['status'] === 'submitted'): ?>
                  <span class="badge badge-warning">Awaiting Approval</span>
                <?php elseif ($l['status'] === 'active'): ?>
                  <span class="badge badge-success">Active Amortizing</span>
                <?php elseif ($l['status'] === 'repaid'): ?>
                  <span class="badge badge-primary">Fully Repaid</span>
                <?php else: ?>
                  <span class="badge badge-danger"><?= esc(ucfirst($l['status'])) ?></span>
                <?php endif; ?>
              </td>
              <?php if ($isFinance): ?>
                <td>
                  <?php if ($l['status'] === 'submitted'): ?>
                    <form action="<?= site_url('loans/approve/' . $l['id']) ?>" method="POST" style="margin: 0;">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn btn-success btn-sm" style="background-color: #059669; border-color: #047857; color: #ffffff !important; padding: 5px 14px; font-weight: 600; cursor: pointer; border-radius: 6px;">
                        Approve &amp; Disburse
                      </button>
                    </form>
                  <?php else: ?>
                    <span style="font-size: 12px; color: var(--color-slate-400);">Processed</span>
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

<!-- MODAL: APPLY LOAN -->
<div id="modalApplyLoan" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Apply for Salary Advance / Loan</h3>
      <button type="button" onclick="document.getElementById('modalApplyLoan').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('loans/apply') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Loan / Advance Type *</label>
        <select name="loan_type" class="form-control" required>
          <option value="salary_advance">Salary Advance (1-3 Months)</option>
          <option value="emergency_advance">Emergency Medical Advance</option>
          <option value="personal_loan">Personal Loan (6-12 Months)</option>
          <option value="education_loan">Skill &amp; Education Loan</option>
        </select>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Requested Amount (₹) *</label>
          <input type="number" step="0.01" name="principal_amount" class="form-control" placeholder="1000.00" required>
        </div>
        <div class="form-group">
          <label class="form-label">Repayment Tenure (Months) *</label>
          <input type="number" name="tenure_months" class="form-control" value="3" min="1" max="24" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Purpose / Reason *</label>
        <textarea name="reason" class="form-control" rows="3" placeholder="Provide details on the advance requirement" required></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalApplyLoan').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Application</button>
      </div>
    </form>
  </div>
</div>
