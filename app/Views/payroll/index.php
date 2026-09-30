<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
      Monthly Payroll Processing &amp; Disbursement Engine
    </h2>
    <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
      Comprehensive compensation calculations, statutory PF/Tax deductions, and pixel-perfect payslips.
    </p>
  </div>
  <?php if (in_array('payroll.process', $userPermissions ?? []) || ($currentRoleSlug === 'super_admin')): ?>
  <div>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalProcessPayroll').style.display='flex';" id="btnOpenProcessModal">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
      Run Monthly Payroll
    </button>
  </div>
  <?php endif; ?>
</div>

<!-- PAYROLL KPI CARDS -->
<div class="grid-3" style="margin-bottom: 24px;">
  <div class="stat-card emerald">
    <div class="stat-content">
      <div class="stat-label">Total Historical Net Disbursed</div>
      <div class="stat-value">₹<?= number_format($totalDisbursed, 2) ?></div>
      <div class="stat-subtext">Across <?= esc($totalRunsCount) ?> payroll cycles</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
    </div>
  </div>

  <div class="stat-card sky">
    <div class="stat-content">
      <div class="stat-label">Active Salary Structures</div>
      <div class="stat-value"><?= esc($activeStructuresCount) ?> Profiles</div>
      <div class="stat-subtext">Configured with Basic, HRA &amp; Allowances</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Statutory Compliance Status</div>
      <div class="stat-value" style="font-size: 20px; color: #10b981;">100% Compliant</div>
      <div class="stat-subtext">Automated PF (12%) &amp; Tax Withholding</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
    </div>
  </div>
</div>

<!-- PAYROLL RUNS TABLE -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Completed Payroll Run Audit Logs (<?= count($runs) ?>)</div>
    <span class="badge badge-primary">Modules 18, 21 &amp; 22</span>
  </div>
  <div class="card-body" style="padding: 0;">
    <div class="table-responsive">
      <table class="table" style="margin-bottom: 0;">
        <thead>
          <tr>
            <th>Cycle Title</th>
            <th>Month / Year</th>
            <th>Headcount</th>
            <th>Gross Outlay</th>
            <th>Statutory Deductions</th>
            <th>Net Payout</th>
            <th>Status</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($runs)): ?>
            <tr>
              <td colspan="8" style="text-align: center; color: #94a3b8; padding: 36px;">
                No payroll cycles processed yet. Click "Run Monthly Payroll" above to generate employee payouts.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($runs as $r): ?>
              <tr>
                <td>
                  <strong style="color: #0f172a; font-size: 14px;"><?= esc($r['title']) ?></strong>
                </td>
                <td><?= esc(date('F', mktime(0,0,0, $r['month'], 10))) ?> <?= esc($r['year']) ?></td>
                <td>
                  <span class="badge badge-secondary"><?= esc($r['total_employees']) ?> employees</span>
                </td>
                <td style="font-weight: 600; color: #0f172a;">
                  ₹<?= number_format($r['total_gross'], 2) ?>
                </td>
                <td style="color: #b91c1c; font-weight: 600;">
                  -₹<?= number_format($r['total_deductions'], 2) ?>
                </td>
                <td>
                  <strong style="color: #4338ca; font-size: 15px;">₹<?= number_format($r['total_net'], 2) ?></strong>
                </td>
                <td>
                  <?php if ($r['status'] === 'disbursed'): ?>
                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3);">Disbursed</span>
                  <?php elseif ($r['status'] === 'frozen'): ?>
                    <span class="badge" style="background: rgba(99, 102, 241, 0.15); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.3);">Frozen</span>
                  <?php elseif ($r['status'] === 'draft'): ?>
                    <span class="badge badge-warning">Draft</span>
                  <?php else: ?>
                    <span class="badge badge-success">Processed</span>
                  <?php endif; ?>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <div style="display: inline-flex; gap: 6px; align-items: center; justify-content: flex-end;">
                    <a href="<?= site_url('payroll/view/' . $r['id']) ?>" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 12px;" title="View Run &amp; Payslips">
                      View Run &amp; Payslips &rarr;
                    </a>
                    <?php if (in_array('payroll.process', $userPermissions ?? []) || ($currentRoleSlug === 'super_admin')): ?>
                      <button type="button" class="btn btn-outline btn-sm btn-edit-payroll"
                              data-run="<?= htmlspecialchars(json_encode($r), ENT_QUOTES, 'UTF-8') ?>"
                              onclick="openEditPayrollModal(this)"
                              title="Edit Payroll Cycle"
                              style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 12px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                      </button>
                      <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
                      <button type="button" class="btn btn-sm btn-delete-payroll"
                              onclick="openDeletePayrollModal(<?= (int)$r['id'] ?>, '<?= esc($r['title'], 'js') ?>', '₹<?= number_format($r['total_net'], 2) ?>', <?= (int)$r['total_employees'] ?>)"
                              title="Delete Payroll Cycle"
                              style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 12px; background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.25);">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        Delete
                      </button>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- 1. RUN MONTHLY PAYROLL MODAL                                   -->
<!-- ============================================================== -->
<div id="modalProcessPayroll" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
  <div class="card" style="width: 100%; max-width: 480px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); border: 1px solid var(--border-color, #e2e8f0); border-radius: 14px; overflow: hidden; background: var(--bg-card, #ffffff); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color, #e2e8f0); padding: 18px 24px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(79, 70, 229, 0.1); color: #4f46e5; display: flex; align-items: center; justify-content: center;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
        </div>
        <div>
          <div class="card-title" style="font-size: 16px; margin: 0; font-weight: 700;">Execute Monthly Payroll Run</div>
          <div style="font-size: 12px; color: #64748b;">Automated statutory salary calculation engine</div>
        </div>
      </div>
      <button type="button" onclick="document.getElementById('modalProcessPayroll').style.display='none';" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8; line-height: 1;">&times;</button>
    </div>
    <div class="card-body" style="padding: 24px;">
      <form action="<?= site_url('payroll/process') ?>" method="POST" id="formRunPayroll">
        <?= csrf_field() ?>

        <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
          The calculation engine will compute gross earnings, statutory PF (12%), income tax withholding, and insurance deductions for all active personnel.
        </p>

        <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="pay_month" style="font-weight: 600; font-size: 13px;">Processing Month <span style="color: #ef4444;">*</span></label>
            <select name="month" id="pay_month" class="form-control" required style="font-size: 14px;">
              <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= ($m === $currentMonth) ? 'selected' : '' ?>>
                  <?= date('F', mktime(0,0,0, $m, 10)) ?>
                </option>
              <?php endfor; ?>
            </select>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="pay_year" style="font-weight: 600; font-size: 13px;">Year <span style="color: #ef4444;">*</span></label>
            <select name="year" id="pay_year" class="form-control" required style="font-size: 14px;">
              <option value="2027">2027</option>
              <option value="2026" selected>2026</option>
              <option value="2025">2025</option>
              <option value="2024">2024</option>
            </select>
          </div>
        </div>

        <div style="background: rgba(248, 250, 252, 0.9); border: 1px solid var(--border-color, #e2e8f0); border-radius: 8px; padding: 12px 14px; margin-bottom: 20px; font-size: 12px; color: #475569; line-height: 1.6;">
          &bull; Generates individual payslips with unique numbers<br>
          &bull; Applies salary structures from Employee Master<br>
          &bull; Automatically populates bank direct deposit batch
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalProcessPayroll').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btnSubmitRun" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            Execute Calculations
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- 2. EDIT PAYROLL RUN MODAL                                      -->
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
      <button type="button" onclick="closeEditPayrollModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8; line-height: 1;">&times;</button>
    </div>
    
    <div class="card-body" style="padding: 24px;">
      <form id="formEditPayroll" method="POST" action="">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="edit_payroll_id">

        <div class="form-group" style="margin-bottom: 16px;">
          <label class="form-label" for="edit_payroll_title" style="font-weight: 600; font-size: 13px;">Cycle Title <span style="color: #ef4444;">*</span></label>
          <input type="text" name="title" id="edit_payroll_title" class="form-control" required style="font-size: 14px;">
        </div>

        <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="edit_payroll_month" style="font-weight: 600; font-size: 13px;">Month <span style="color: #ef4444;">*</span></label>
            <select name="month" id="edit_payroll_month" class="form-control" required style="font-size: 14px;">
              <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>"><?= date('F', mktime(0,0,0, $m, 10)) ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="edit_payroll_year" style="font-weight: 600; font-size: 13px;">Year <span style="color: #ef4444;">*</span></label>
            <select name="year" id="edit_payroll_year" class="form-control" required style="font-size: 14px;">
              <option value="2027">2027</option>
              <option value="2026">2026</option>
              <option value="2025">2025</option>
              <option value="2024">2024</option>
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-bottom: 18px;">
          <label class="form-label" for="edit_payroll_status" style="font-weight: 600; font-size: 13px;">Processing Status <span style="color: #ef4444;">*</span></label>
          <select name="status" id="edit_payroll_status" class="form-control" required style="font-size: 14px;">
            <option value="processed">Processed (Active &amp; Calculated)</option>
            <option value="disbursed">Disbursed (Funds Distributed / Paid Out)</option>
            <option value="frozen">Frozen (Audit-Locked / Read-Only)</option>
            <option value="draft">Draft (Preliminary Run)</option>
          </select>
          <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">
            Setting status to <strong>Frozen</strong> locks line items from recalculations.
          </div>
        </div>

        <div id="editPayrollMetrics" style="background: rgba(248, 250, 252, 0.9); border: 1px solid var(--border-color, #e2e8f0); border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 12.5px; color: #475569; display: flex; justify-content: space-between; align-items: center;">
          <div>Headcount: <strong id="edit_metric_headcount" style="color: #0f172a;">-</strong></div>
          <div>Net Outlay: <strong id="edit_metric_net" style="color: #4338ca;">-</strong></div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-outline" onclick="closeEditPayrollModal()">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btnSavePayrollChanges" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- 3. DELETE PAYROLL RUN CONFIRMATION MODAL                       -->
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
      <button type="button" onclick="closeDeletePayrollModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8; line-height: 1;">&times;</button>
    </div>

    <div class="card-body" style="padding: 24px;">
      <form id="formDeletePayroll" method="POST" action="">
        <?= csrf_field() ?>

        <div style="font-size: 14px; color: #334155; margin-bottom: 16px; line-height: 1.5;">
          Are you sure you want to permanently delete <strong id="delete_payroll_title" style="color: #0f172a;"></strong>?
        </div>

        <div style="background: rgba(254, 242, 242, 0.85); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 10px; padding: 14px; margin-bottom: 20px;">
          <div style="font-size: 13px; font-weight: 600; color: #991b1b; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Permanent Cascading Removal:
          </div>
          <ul style="font-size: 12px; color: #b91c1c; margin: 0; padding-left: 20px; line-height: 1.5;">
            <li>All associated employee payslips (<strong id="delete_payroll_headcount">0</strong> records) will be deleted.</li>
            <li>Net payout of <strong id="delete_payroll_net">₹0.00</strong> will be deducted from historical totals.</li>
            <li>This action will be logged in the immutable system audit trail.</li>
          </ul>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-outline" onclick="closeDeletePayrollModal()">Cancel</button>
          <button type="submit" class="btn btn-danger" id="btnConfirmDeletePayroll" style="background: #dc2626; color: #fff; border: 1px solid #b91c1c; display: inline-flex; align-items: center; gap: 6px;">
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
function openEditPayrollModal(btn) {
  try {
    const run = JSON.parse(btn.getAttribute('data-run'));
    const form = document.getElementById('formEditPayroll');
    form.action = '<?= site_url('payroll/update/') ?>' + run.id;
    document.getElementById('edit_payroll_id').value = run.id;
    document.getElementById('edit_payroll_title').value = run.title || '';
    document.getElementById('edit_payroll_month').value = run.month || '1';
    document.getElementById('edit_payroll_year').value = run.year || '2026';
    document.getElementById('edit_payroll_status').value = run.status || 'processed';
    document.getElementById('edit_metric_headcount').innerText = (run.total_employees || 0) + ' personnel';
    document.getElementById('edit_metric_net').innerText = '₹' + Number(run.total_net || 0).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    
    document.getElementById('modalEditPayrollRun').style.display = 'flex';
  } catch (e) {
    console.error('Failed to parse payroll run data:', e);
  }
}

function closeEditPayrollModal() {
  document.getElementById('modalEditPayrollRun').style.display = 'none';
}

function openDeletePayrollModal(id, title, net, headcount) {
  const form = document.getElementById('formDeletePayroll');
  form.action = '<?= site_url('payroll/delete/') ?>' + id;
  document.getElementById('delete_payroll_title').innerText = title;
  document.getElementById('delete_payroll_net').innerText = net;
  document.getElementById('delete_payroll_headcount').innerText = headcount;
  document.getElementById('modalDeletePayrollRun').style.display = 'flex';
}

function closeDeletePayrollModal() {
  document.getElementById('modalDeletePayrollRun').style.display = 'none';
}

// Close modals when clicking backdrop
window.addEventListener('click', function(e) {
  const modalEdit = document.getElementById('modalEditPayrollRun');
  const modalDel = document.getElementById('modalDeletePayrollRun');
  const modalProc = document.getElementById('modalProcessPayroll');
  if (e.target === modalEdit) modalEdit.style.display = 'none';
  if (e.target === modalDel) modalDel.style.display = 'none';
  if (e.target === modalProc) modalProc.style.display = 'none';
});
</script>
