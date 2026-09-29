<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Separation, Exit Clearance &amp; F&amp;F Settlement</h2>
    <p style="color: #64748b; font-size: 14px; margin: 0;">Manage employee exits, multi-departmental clearances (IT, Finance, HR, Admin), and automated Full &amp; Final settlement computations.</p>
  </div>
  <div>
    <button class="btn btn-primary" onclick="document.getElementById('modalSubmitResig').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
      Initiate Separation Notice
    </button>
  </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid" style="margin-bottom: 28px;">
  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Total Resignations</span>
      <div class="kpi-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($totalSeparations) ?></div>
    <div class="kpi-subtitle">Exit requests recorded</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">In Exit Clearance</span>
      <div class="kpi-icon" style="background: rgba(245,158,11,0.1); color: #d97706;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($inClearance) ?></div>
    <div class="kpi-subtitle">Pending department sign-offs</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">F&amp;F Settled</span>
      <div class="kpi-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($settledCount) ?></div>
    <div class="kpi-subtitle">Final settlements completed</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Total F&amp;F Payout</span>
      <div class="kpi-icon" style="background: rgba(124,58,237,0.1); color: #7c3aed;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
      </div>
    </div>
    <div class="kpi-value">₹<?= number_format((float)$totalPayout, 2) ?></div>
    <div class="kpi-subtitle">Disbursed net severance &amp; encashment</div>
  </div>
</div>

<!-- Separation Pipeline Table -->
<div class="card" style="margin-bottom: 24px;">
  <div class="card-header" style="border-bottom: 1px solid #e2e8f0;">
    <div class="card-title">Separation Cases &amp; Departmental Clearances</div>
  </div>

  <div style="padding: 20px;">
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Designation &amp; Dept</th>
            <th>Notice Date</th>
            <th>Last Working Day</th>
            <th>Clearance Status</th>
            <th>Exit Status</th>
            <th>F&amp;F Net</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($resignations)): ?>
            <tr><td colspan="8" style="text-align: center; color: #94a3b8; padding: 30px;">No separation notices on record.</td></tr>
          <?php else: ?>
            <?php foreach ($resignations as $r): ?>
              <tr>
                <td>
                  <a href="<?= site_url('employees/view/' . $r['employee_id']) ?>" style="text-decoration: none; font-weight: 700; color: #0f172a;">
                    <?= esc($r['first_name'] . ' ' . $r['last_name']) ?>
                  </a>
                  <div style="font-size: 11px; color: #64748b;">Code: <?= esc($r['employee_code']) ?></div>
                </td>
                <td>
                  <div style="font-weight: 600; color: #1e293b;"><?= esc($r['designation_title'] ?? 'Staff') ?></div>
                  <div style="font-size: 11px; color: #64748b;"><?= esc($r['department_name'] ?? 'General') ?></div>
                </td>
                <td><?= date('M d, Y', strtotime($r['resignation_date'])) ?></td>
                <td>
                  <strong><?= date('M d, Y', strtotime($r['approved_last_working_day'] ?? $r['requested_last_working_day'])) ?></strong>
                </td>
                <td>
                  <!-- 4-Pill Clearance Tracker -->
                  <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                    <?php if (empty($r['clearances'])): ?>
                      <span style="font-size: 11px; color: #94a3b8; font-style: italic;">Awaiting approval</span>
                    <?php else: ?>
                      <?php foreach ($r['clearances'] as $c): ?>
                        <span class="badge" style="font-size: 10px; padding: 2px 6px; cursor: pointer; <?= ($c['status'] === 'cleared') ? 'background: #dcfce7; color: #166534;' : 'background: #fef3c7; color: #92400e;' ?>" onclick="openClearanceModal(<?= htmlspecialchars(json_encode($c)) ?>)" title="Click to manage clearance">
                          <?= esc($c['department_type']) ?>: <?= esc(ucfirst($c['status'])) ?>
                        </span>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </td>
                <td>
                  <?php if ($r['status'] === 'settled'): ?>
                    <span class="badge badge-success">Settled</span>
                  <?php elseif ($r['status'] === 'in_clearance'): ?>
                    <span class="badge badge-warning">In Clearance</span>
                  <?php elseif ($r['status'] === 'submitted'): ?>
                    <span class="badge" style="background: #e0f2fe; color: #0369a1;">Submitted</span>
                  <?php else: ?>
                    <span class="badge badge-secondary"><?= esc(ucfirst($r['status'])) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($r['net_payable_amount'])): ?>
                    <strong style="color: #16a34a;">₹<?= number_format((float)$r['net_payable_amount'], 2) ?></strong>
                  <?php else: ?>
                    <span style="color: #94a3b8; font-size: 12px;">Pending</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div style="display: flex; gap: 6px;">
                    <?php if ($r['status'] === 'submitted'): ?>
                      <button class="btn btn-outline btn-sm" style="font-size: 11px; padding: 4px 8px;" onclick="openApproveModal(<?= htmlspecialchars(json_encode($r)) ?>)">
                        Approve Notice
                      </button>
                    <?php elseif (in_array($r['status'], ['in_clearance', 'manager_approved'])): ?>
                      <button class="btn btn-primary btn-sm" style="font-size: 11px; padding: 4px 8px; background: #7c3aed; border-color: #7c3aed;" onclick="openFnfModal(<?= htmlspecialchars(json_encode($r)) ?>)">
                        Calculate F&amp;F
                      </button>
                    <?php elseif ($r['status'] === 'settled' && !empty($r['fnf_id'])): ?>
                      <a href="<?= site_url('separation/fnf/view/' . $r['fnf_id']) ?>" class="btn btn-outline btn-sm" style="font-size: 11px; padding: 4px 8px; text-decoration: none; color: #2563eb;">
                        View F&amp;F Statement
                      </a>
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

<!-- MODAL: INITIATE SEPARATION -->
<div id="modalSubmitResig" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 550px;">
    <div class="modal-header">
      <h3 class="modal-title">Initiate Employee Separation</h3>
      <button class="modal-close" onclick="document.getElementById('modalSubmitResig').style.display='none'">&times;</button>
    </div>
    <form action="<?= site_url('separation/submit') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div class="form-group">
          <label class="form-label">Employee *</label>
          <select name="employee_id" class="form-control" required>
            <option value="">-- Choose Employee --</option>
            <?php foreach ($employees as $emp): ?>
              <option value="<?= $emp['id'] ?>"><?= esc($emp['employee_code']) ?> - <?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Resignation Submission Date *</label>
            <input type="date" name="resignation_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Requested Last Working Day (LWD) *</label>
            <input type="date" name="requested_last_working_day" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Reason for Separation *</label>
          <textarea name="reason" class="form-control" rows="3" required placeholder="Career advancement, relocation, personal reasons..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalSubmitResig').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Separation</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: APPROVE RESIGNATION -->
<div id="modalApproveResig" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h3 class="modal-title">Approve Resignation Notice</h3>
      <button class="modal-close" onclick="document.getElementById('modalApproveResig').style.display='none'">&times;</button>
    </div>
    <form id="formApproveResig" action="" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div id="approveEmployeeInfo" style="background: #f8fafc; padding: 12px; border-radius: 6px; font-weight: 600; color: #1e293b;"></div>
        <div class="form-group">
          <label class="form-label">Approved Last Working Day *</label>
          <input type="date" name="approved_last_working_day" id="approveLwdInput" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">Approver Remarks</label>
          <textarea name="approver_remarks" class="form-control" rows="2" placeholder="Exit clearance initiated..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalApproveResig').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Approve &amp; Start Clearances</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: MANAGE CLEARANCE -->
<div id="modalClearance" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h3 class="modal-title">Department Exit Sign-Off</h3>
      <button class="modal-close" onclick="document.getElementById('modalClearance').style.display='none'">&times;</button>
    </div>
    <form id="formClearance" action="" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div id="clearanceDeptTitle" style="font-size: 15px; font-weight: 700; color: #0f172a; padding: 10px; background: #f1f5f9; border-radius: 6px;"></div>
        <div class="form-group">
          <label class="form-label">Status *</label>
          <select name="status" id="clearanceStatusSelect" class="form-control" required>
            <option value="cleared">Cleared (Full Handover Complete)</option>
            <option value="pending">Pending</option>
            <option value="flagged">Flagged (Unreturned Assets / Outstanding Dues)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Recovery or Dues Amount (₹)</label>
          <input type="number" step="0.01" name="dues_or_recoveries" id="clearanceDuesInput" class="form-control" placeholder="0.00">
        </div>
        <div class="form-group">
          <label class="form-label">Remarks &amp; Checklist Notes</label>
          <textarea name="remarks" id="clearanceRemarksInput" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalClearance').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Department Clearance</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: CALCULATE FNF -->
<div id="modalFnF" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 550px;">
    <div class="modal-header">
      <h3 class="modal-title">Compute Full &amp; Final (F&amp;F) Settlement</h3>
      <button class="modal-close" onclick="document.getElementById('modalFnF').style.display='none'">&times;</button>
    </div>
    <form id="formFnF" action="" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div id="fnfEmployeeInfo" style="background: #f8fafc; padding: 12px; border-radius: 6px; font-weight: 600; color: #1e293b;"></div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Unpaid Working Days in Final Month</label>
            <input type="number" name="unpaid_salary_days" class="form-control" value="15" min="0" max="31">
          </div>
          <div class="form-group">
            <label class="form-label">Discretionary Ex-Gratia / Bonus (₹)</label>
            <input type="number" step="0.01" name="bonus_amount" class="form-control" value="0.00">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Notice Shortfall Recovery (₹)</label>
          <input type="number" step="0.01" name="notice_shortfall_recovery" class="form-control" value="0.00" placeholder="If employee left before serving notice">
        </div>
        <div style="background: #eff6ff; padding: 12px; border-radius: 6px; font-size: 12px; color: #1e40af;">
          💡 <strong>Automated Engine:</strong> Leave encashment, gratuity (tenure >= 5 yrs), and clearance deductions will be calculated automatically based on active salary structure and department clearances.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalFnF').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary" style="background: #7c3aed; border-color: #7c3aed;">Generate Final Statement</button>
      </div>
    </form>
  </div>
</div>

<script>
function openApproveModal(r) {
  document.getElementById('formApproveResig').action = '<?= site_url("separation/approve/") ?>' + r.id;
  document.getElementById('approveEmployeeInfo').innerHTML = 'Employee: <strong>' + r.first_name + ' ' + r.last_name + '</strong> (' + r.employee_code + ')<br>Requested LWD: ' + r.requested_last_working_day;
  document.getElementById('approveLwdInput').value = r.requested_last_working_day;
  document.getElementById('modalApproveResig').style.display = 'flex';
}

function openClearanceModal(c) {
  document.getElementById('formClearance').action = '<?= site_url("separation/clearance/") ?>' + c.id;
  document.getElementById('clearanceDeptTitle').innerText = c.department_type + ' Department Clearance';
  document.getElementById('clearanceStatusSelect').value = c.status;
  document.getElementById('clearanceDuesInput').value = c.dues_or_recoveries || '0.00';
  document.getElementById('clearanceRemarksInput').value = c.remarks || '';
  document.getElementById('modalClearance').style.display = 'flex';
}

function openFnfModal(r) {
  document.getElementById('formFnF').action = '<?= site_url("separation/fnf/calculate/") ?>' + r.id;
  document.getElementById('fnfEmployeeInfo').innerHTML = 'Employee: <strong>' + r.first_name + ' ' + r.last_name + '</strong> (' + r.employee_code + ')<br>Department: ' + (r.department_name || 'General') + '<br>Approved LWD: ' + (r.approved_last_working_day || r.requested_last_working_day);
  document.getElementById('modalFnF').style.display = 'flex';
}
</script>
