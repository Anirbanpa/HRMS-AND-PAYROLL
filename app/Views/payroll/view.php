<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
  <a href="<?= site_url('payroll') ?>" class="btn btn-outline btn-sm">&larr; Back to All Payroll Runs</a>
  
  <div style="display: flex; align-items: center; gap: 10px;">
    <?php if ($run['status'] === 'disbursed'): ?>
      <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 13px;">Status: Disbursed</span>
    <?php elseif ($run['status'] === 'frozen'): ?>
      <span class="badge" style="background: rgba(99, 102, 241, 0.15); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.3); font-size: 13px;">Status: Frozen</span>
    <?php elseif ($run['status'] === 'draft'): ?>
      <span class="badge badge-warning" style="font-size: 13px;">Status: Draft</span>
    <?php else: ?>
      <span class="badge badge-success" style="font-size: 13px;">Status: Processed</span>
    <?php endif; ?>

    <?php if (in_array('payroll.process', $userPermissions ?? []) || ($currentRoleSlug === 'super_admin')): ?>
      <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('modalEditPayrollRun').style.display='flex';" style="display: inline-flex; align-items: center; gap: 4px;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit Cycle
      </button>
      <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
      <button type="button" class="btn btn-sm" onclick="document.getElementById('modalDeletePayrollRun').style.display='flex';" style="display: inline-flex; align-items: center; gap: 4px; background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.25);">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        Delete Cycle
      </button>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</div>

<div class="card" style="border-top: 4px solid #10b981; margin-bottom: 24px;">
  <div class="card-header">
    <div>
      <div class="card-title"><?= esc($run['title']) ?></div>
      <p style="font-size: 13px; color: #64748b; margin-top: 2px;">
        Processed on <?= esc(date('F j, Y \a\t H:i', strtotime($run['processed_at']))) ?> for <?= esc($run['total_employees']) ?> workforce personnel.
      </p>
    </div>
  </div>
  <div class="card-body">
    <div class="grid-4" style="margin-bottom: 0;">
      <div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600;">ELIGIBLE WORKFORCE</div>
        <div style="font-size: 20px; font-weight: 800; color: #0f172a;"><?= esc($run['total_employees']) ?> Personnel</div>
      </div>
      <div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600;">TOTAL GROSS EARNINGS</div>
        <div style="font-size: 20px; font-weight: 800; color: #0f172a;">₹<?= number_format($run['total_gross'], 2) ?></div>
      </div>
      <div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600;">STATUTORY DEDUCTIONS</div>
        <div style="font-size: 20px; font-weight: 800; color: #b91c1c;">-₹<?= number_format($run['total_deductions'], 2) ?></div>
      </div>
      <div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600;">NET DISBURSEMENT PAYOUT</div>
        <div style="font-size: 22px; font-weight: 800; color: #4338ca;">₹<?= number_format($run['total_net'], 2) ?></div>
      </div>
    </div>
  </div>
</div>

<!-- PAYROLL ITEMS TABLE -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Employee Payout &amp; Payslip Ledger (<?= count($items) ?> Records)</div>
  </div>
  <div class="card-body" style="padding: 0;">
    <table class="table" style="margin-bottom: 0;">
      <thead>
        <tr>
          <th>Payslip #</th>
          <th>Employee</th>
          <th>Department</th>
          <th style="text-align: right;">Basic Pay</th>
          <th style="text-align: right;">Gross Salary</th>
          <th style="text-align: right;">Total Deductions</th>
          <th style="text-align: right;">Net Payout</th>
          <th>Disbursement</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
          <tr>
            <td>
              <code style="font-weight: 700; color: #4f46e5; font-size: 12px;"><?= esc($item['payslip_number']) ?></code>
            </td>
            <td>
              <div style="font-weight: 700; color: #0f172a;"><?= esc($item['first_name'] . ' ' . $item['last_name']) ?></div>
              <div style="font-size: 11px; color: #64748b;"><?= esc($item['employee_code']) ?></div>
            </td>
            <td><?= esc($item['department_name'] ?? 'General') ?></td>
            <td style="text-align: right; font-size: 13px;">₹<?= number_format($item['basic_salary'], 2) ?></td>
            <td style="text-align: right; font-weight: 600; color: #0f172a; font-size: 13.5px;">₹<?= number_format($item['gross_salary'], 2) ?></td>
            <td style="text-align: right; color: #b91c1c; font-size: 13px;">-₹<?= number_format($item['total_deductions'], 2) ?></td>
            <td style="text-align: right;">
              <strong style="color: #4338ca; font-size: 14.5px;">₹<?= number_format($item['net_salary'], 2) ?></strong>
            </td>
            <td>
              <span class="badge badge-success"><?= esc(ucfirst($item['payment_status'])) ?></span>
            </td>
            <td style="text-align: right;">
              <a href="<?= site_url('payroll/payslip/' . $item['id']) ?>" target="_blank" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 4px;">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                View Payslip
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php if (in_array('payroll.process', $userPermissions ?? []) || ($currentRoleSlug === 'super_admin')): ?>
<!-- ============================================================== -->
<!-- 1. EDIT PAYROLL RUN MODAL                                      -->
<!-- ============================================================== -->
<div id="modalEditPayrollRun" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
  <div class="card" style="width: 100%; max-width: 520px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid var(--border-color, #e2e8f0); border-radius: 14px; overflow: hidden; background: var(--bg-card, #ffffff); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color, #e2e8f0); padding: 18px 24px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(79, 70, 229, 0.1); color: #4f46e5; display: flex; align-items: center; justify-content: center;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div>
          <div class="card-title" style="font-size: 16px; margin: 0; font-weight: 700;">Edit Payroll Cycle</div>
          <div style="font-size: 12px; color: #64748b;">Update cycle title, processing period, or status</div>
        </div>
      </div>
      <button type="button" onclick="document.getElementById('modalEditPayrollRun').style.display='none';" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8; line-height: 1;">&times;</button>
    </div>
    
    <div class="card-body" style="padding: 24px;">
      <form id="formEditPayroll" method="POST" action="<?= site_url('payroll/update/' . $run['id']) ?>">
        <?= csrf_field() ?>

        <div class="form-group" style="margin-bottom: 16px;">
          <label class="form-label" for="edit_payroll_title" style="font-weight: 600; font-size: 13px;">Cycle Title <span style="color: #ef4444;">*</span></label>
          <input type="text" name="title" id="edit_payroll_title" class="form-control" value="<?= esc($run['title']) ?>" required style="font-size: 14px;">
        </div>

        <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="edit_payroll_month" style="font-weight: 600; font-size: 13px;">Month <span style="color: #ef4444;">*</span></label>
            <select name="month" id="edit_payroll_month" class="form-control" required style="font-size: 14px;">
              <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= ((int)$run['month'] === $m) ? 'selected' : '' ?>><?= date('F', mktime(0,0,0, $m, 10)) ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="edit_payroll_year" style="font-weight: 600; font-size: 13px;">Year <span style="color: #ef4444;">*</span></label>
            <select name="year" id="edit_payroll_year" class="form-control" required style="font-size: 14px;">
              <?php foreach ([2027, 2026, 2025, 2024] as $yr): ?>
                <option value="<?= $yr ?>" <?= ((int)$run['year'] === $yr) ? 'selected' : '' ?>><?= $yr ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-bottom: 18px;">
          <label class="form-label" for="edit_payroll_status" style="font-weight: 600; font-size: 13px;">Processing Status <span style="color: #ef4444;">*</span></label>
          <select name="status" id="edit_payroll_status" class="form-control" required style="font-size: 14px;">
            <option value="processed" <?= ($run['status'] === 'processed') ? 'selected' : '' ?>>Processed (Active &amp; Calculated)</option>
            <option value="disbursed" <?= ($run['status'] === 'disbursed') ? 'selected' : '' ?>>Disbursed (Funds Distributed / Paid Out)</option>
            <option value="frozen" <?= ($run['status'] === 'frozen') ? 'selected' : '' ?>>Frozen (Audit-Locked / Read-Only)</option>
            <option value="draft" <?= ($run['status'] === 'draft') ? 'selected' : '' ?>>Draft (Preliminary Run)</option>
          </select>
          <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">
            Setting status to <strong>Frozen</strong> locks line items from recalculations.
          </div>
        </div>

        <div style="background: rgba(248, 250, 252, 0.9); border: 1px solid var(--border-color, #e2e8f0); border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 12.5px; color: #475569; display: flex; justify-content: space-between; align-items: center;">
          <div>Headcount: <strong style="color: #0f172a;"><?= esc($run['total_employees']) ?> personnel</strong></div>
          <div>Net Outlay: <strong style="color: #4338ca;">₹<?= number_format($run['total_net'], 2) ?></strong></div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalEditPayrollRun').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- 2. DELETE PAYROLL RUN CONFIRMATION MODAL                       -->
<!-- ============================================================== -->
<?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
<div id="modalDeletePayrollRun" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
  <div class="card" style="width: 100%; max-width: 480px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid var(--border-color, #e2e8f0); border-radius: 14px; overflow: hidden; background: var(--bg-card, #ffffff); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color, #e2e8f0); padding: 18px 24px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(239, 68, 68, 0.12); color: #dc2626; display: flex; align-items: center; justify-content: center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div>
          <div class="card-title" style="font-size: 16px; margin: 0; font-weight: 700; color: #b91c1c;">Confirm Payroll Deletion</div>
          <div style="font-size: 12px; color: #64748b;">Permanent financial record removal</div>
        </div>
      </div>
      <button type="button" onclick="document.getElementById('modalDeletePayrollRun').style.display='none';" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8; line-height: 1;">&times;</button>
    </div>

    <div class="card-body" style="padding: 24px;">
      <form method="POST" action="<?= site_url('payroll/delete/' . $run['id']) ?>">
        <?= csrf_field() ?>

        <div style="font-size: 14px; color: #334155; margin-bottom: 16px; line-height: 1.5;">
          Are you sure you want to permanently delete <strong style="color: #0f172a;"><?= esc($run['title']) ?></strong>?
        </div>

        <div style="background: rgba(254, 242, 242, 0.85); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 10px; padding: 14px; margin-bottom: 20px;">
          <div style="font-size: 13px; font-weight: 600; color: #991b1b; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Permanent Cascading Removal:
          </div>
          <ul style="font-size: 12px; color: #b91c1c; margin: 0; padding-left: 20px; line-height: 1.5;">
            <li>All associated employee payslips (<strong><?= esc($run['total_employees']) ?></strong> records) will be deleted.</li>
            <li>Net payout of <strong>₹<?= number_format($run['total_net'], 2) ?></strong> will be deducted from historical totals.</li>
            <li>This action will be logged in the immutable system audit trail.</li>
          </ul>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalDeletePayrollRun').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-danger" style="background: #dc2626; color: #fff; border: 1px solid #b91c1c; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            Yes, Delete Payroll Run
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
window.addEventListener('click', function(e) {
  const modalEdit = document.getElementById('modalEditPayrollRun');
  const modalDel = document.getElementById('modalDeletePayrollRun');
  if (e.target === modalEdit) modalEdit.style.display = 'none';
  if (e.target === modalDel) modalDel.style.display = 'none';
});
</script>
<?php endif; ?>
