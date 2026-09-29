<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Employee Transfer &amp; Promotion Management
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Inter-branch transfers, departmental rotations, promotions, salary escalations, and automated career record synchronization.
    </p>
  </div>
  <div>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalInitiateMovement').style.display='flex'">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: -2px; margin-right: 4px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Initiate Career Movement
    </button>
  </div>
</div>

<!-- TOP KPI METRIC CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Transfers</div>
      <div class="stat-value" style="color: #0ea5e9;"><?= $totalTransfers ?></div>
      <div class="stat-subtext">Branch &amp; department relocations</div>
    </div>
    <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 3h5v5"/><path d="M4 20L21 3"/><path d="M21 16v5h-5"/><path d="M15 15l6 6"/><path d="M4 4l5 5"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Total Promotions</div>
      <div class="stat-value" style="color: #10b981;"><?= $totalPromotions ?></div>
      <div class="stat-subtext">Designation &amp; grade elevations</div>
    </div>
    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Pending Approval</div>
      <div class="stat-value" style="color: <?= $pendingCount > 0 ? '#f59e0b' : 'inherit' ?>;"><?= $pendingCount ?></div>
      <div class="stat-subtext">Awaiting HR validation</div>
    </div>
    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Active Headcount</div>
      <div class="stat-value"><?= count($employees) ?></div>
      <div class="stat-subtext">Eligible talent pool</div>
    </div>
    <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
    </div>
  </div>
</div>

<!-- CAREER MOVEMENTS TABLE -->
<div class="card">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
    <div>
      <div class="card-title">Career Movement Records &amp; Transition History (<?= count($movements) ?>)</div>
      <span style="font-size: 12.5px; color: var(--color-slate-500);">Audit trail of structural changes across departments and branches</span>
    </div>
    <div style="display: flex; gap: 8px;">
      <a href="<?= site_url('career-movements') ?>" class="badge <?= empty($_GET['type']) ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 4px 8px;">All</a>
      <a href="<?= site_url('career-movements?type=promotion') ?>" class="badge <?= ($_GET['type'] ?? '') === 'promotion' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 4px 8px;">Promotions</a>
      <a href="<?= site_url('career-movements?type=transfer') ?>" class="badge <?= ($_GET['type'] ?? '') === 'transfer' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 4px 8px;">Transfers</a>
    </div>
  </div>

  <div class="card-body" style="padding: 0;">
    <div class="table-responsive">
      <table class="table" style="margin-bottom: 0;">
        <thead>
          <tr>
            <th>Requisition #</th>
            <th>Employee</th>
            <th>Movement Type</th>
            <th>Effective Date</th>
            <th>Transition Details</th>
            <th>Compensation</th>
            <th>Status</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($movements)): ?>
            <tr>
              <td colspan="8" style="text-align: center; color: var(--color-slate-500); padding: 32px;">
                No employee transfers or promotions recorded yet.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($movements as $m): ?>
              <tr>
                <td>
                  <strong><?= esc($m['request_number']) ?></strong>
                  <div style="font-size: 11px; color: var(--color-slate-500);"><?= date('M j, Y', strtotime($m['created_at'])) ?></div>
                </td>
                <td>
                  <strong><?= esc($m['first_name'] . ' ' . $m['last_name']) ?></strong>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($m['employee_code']) ?></div>
                </td>
                <td>
                  <?php if ($m['movement_type'] === 'promotion'): ?>
                    <span class="badge badge-success" style="font-weight: 700;">Promotion</span>
                  <?php elseif ($m['movement_type'] === 'transfer'): ?>
                    <span class="badge badge-info" style="font-weight: 700;">Transfer</span>
                  <?php elseif ($m['movement_type'] === 'transfer_and_promotion'): ?>
                    <span class="badge badge-primary" style="font-weight: 700;">Transfer &amp; Promo</span>
                  <?php else: ?>
                    <span class="badge badge-secondary" style="font-weight: 700;">Redesignation</span>
                  <?php endif; ?>
                </td>
                <td>
                  <strong><?= date('M j, Y', strtotime($m['effective_date'])) ?></strong>
                </td>
                <td>
                  <div style="font-size: 12px; line-height: 1.4;">
                    <?php if ($m['from_branch_name'] !== $m['to_branch_name'] && $m['to_branch_name']): ?>
                      <div><strong>Branch:</strong> <?= esc($m['from_branch_name']) ?> &rarr; <span style="color: #0ea5e9; font-weight: 600;"><?= esc($m['to_branch_name']) ?></span></div>
                    <?php endif; ?>
                    <?php if ($m['from_department_name'] !== $m['to_department_name'] && $m['to_department_name']): ?>
                      <div><strong>Dept:</strong> <?= esc($m['from_department_name']) ?> &rarr; <span style="color: #6366f1; font-weight: 600;"><?= esc($m['to_department_name']) ?></span></div>
                    <?php endif; ?>
                    <?php if ($m['from_designation_name'] !== $m['to_designation_name'] && $m['to_designation_name']): ?>
                      <div><strong>Role:</strong> <?= esc($m['from_designation_name']) ?> &rarr; <span style="color: #10b981; font-weight: 600;"><?= esc($m['to_designation_name']) ?></span></div>
                    <?php endif; ?>
                    <?php if ($m['from_mgr_first'] !== $m['to_mgr_first'] && $m['to_mgr_first']): ?>
                      <div><strong>Manager:</strong> <?= esc($m['from_mgr_first'] . ' ' . $m['from_mgr_last']) ?> &rarr; <span style="color: #f59e0b;"><?= esc($m['to_mgr_first'] . ' ' . $m['to_mgr_last']) ?></span></div>
                    <?php endif; ?>
                  </div>
                </td>
                <td>
                  <?php if ((float)$m['revised_salary'] > 0): ?>
                    <div style="font-size: 12px;">
                      Prev: ₹<?= number_format((float)$m['current_salary'], 2) ?><br>
                      <strong style="color: #10b981;">New: ₹<?= number_format((float)$m['revised_salary'], 2) ?></strong>
                    </div>
                  <?php else: ?>
                    <span style="font-size: 12px; color: var(--color-slate-500);">No salary delta</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($m['status'] === 'implemented'): ?>
                    <span class="badge badge-success">Implemented</span>
                  <?php elseif ($m['status'] === 'submitted'): ?>
                    <span class="badge badge-warning">Pending Sign-off</span>
                  <?php elseif ($m['status'] === 'rejected'): ?>
                    <span class="badge badge-danger">Rejected</span>
                  <?php else: ?>
                    <span class="badge badge-secondary"><?= esc(ucfirst($m['status'])) ?></span>
                  <?php endif; ?>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <?php if ($m['status'] === 'submitted' && $isHR): ?>
                    <form action="<?= site_url('career-movements/approve/' . $m['id']) ?>" method="POST" style="display: inline-block; margin: 0;">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn btn-primary btn-sm" style="padding: 4px 8px; font-size: 11.5px; background: #10b981; border-color: #10b981;" onclick="return confirm('Confirm approval and update employee master placement?');">
                        Approve &amp; Update
                      </button>
                    </form>
                    <form action="<?= site_url('career-movements/reject/' . $m['id']) ?>" method="POST" style="display: inline-block; margin: 0;">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn btn-danger btn-sm" style="padding: 4px 8px; font-size: 11.5px;" onclick="return confirm('Reject this requisition?');">
                        Reject
                      </button>
                    </form>
                  <?php else: ?>
                    <span style="font-size: 11.5px; color: #94a3b8;">Finalized</span>
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

<!-- MODAL: INITIATE CAREER MOVEMENT -->
<div id="modalInitiateMovement" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 650px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0; max-height: 90vh; overflow-y: auto;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="card-title">Initiate Transfer or Promotion Requisition</div>
      <button type="button" onclick="document.getElementById('modalInitiateMovement').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form action="<?= site_url('career-movements/store') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Select Employee *</label>
            <select name="employee_id" class="form-control" required id="movEmployeeSelect" onchange="updateEmpCurrentData(this)">
              <option value="">-- Choose Employee --</option>
              <?php foreach ($employees as $e): ?>
                <option value="<?= esc($e['id']) ?>" 
                        data-branch="<?= esc($e['branch_id']) ?>"
                        data-dept="<?= esc($e['department_id']) ?>"
                        data-desig="<?= esc($e['designation_id']) ?>"
                        data-mgr="<?= esc($e['reporting_to']) ?>">
                  <?= esc($e['first_name'] . ' ' . $e['last_name']) ?> (<?= esc($e['employee_code']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Movement Type *</label>
            <select name="movement_type" class="form-control" required>
              <option value="promotion">Promotion (Designation / Grade Elevation)</option>
              <option value="transfer">Transfer (Branch / Department Move)</option>
              <option value="transfer_and_promotion">Transfer &amp; Promotion (Both)</option>
              <option value="redesignation">Redesignation (Role Title Update)</option>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Effective Date *</label>
            <input type="date" name="effective_date" class="form-control" required value="<?= date('Y-m-d') ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Destination Branch</label>
            <select name="to_branch_id" class="form-control">
              <option value="">-- Retain Current Branch --</option>
              <?php foreach ($branches as $br): ?>
                <option value="<?= esc($br['id']) ?>"><?= esc($br['name']) ?> (<?= esc($br['city']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Destination Department</label>
            <select name="to_department_id" class="form-control">
              <option value="">-- Retain Current Department --</option>
              <?php foreach ($departments as $dept): ?>
                <option value="<?= esc($dept['id']) ?>"><?= esc($dept['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">New Designation / Role</label>
            <select name="to_designation_id" class="form-control">
              <option value="">-- Retain Current Designation --</option>
              <?php foreach ($designations as $des): ?>
                <option value="<?= esc($des['id']) ?>"><?= esc($des['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">New Reporting Manager</label>
            <select name="to_reporting_to" class="form-control">
              <option value="">-- Retain Current Manager --</option>
              <?php foreach ($employees as $mgr): ?>
                <option value="<?= esc($mgr['id']) ?>"><?= esc($mgr['first_name'] . ' ' . $mgr['last_name']) ?> (<?= esc($mgr['employee_code']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">New Pay Grade</label>
            <select name="to_pay_grade_id" class="form-control">
              <option value="">-- Retain Current Grade --</option>
              <?php foreach ($payGrades as $pg): ?>
                <option value="<?= esc($pg['id']) ?>"><?= esc($pg['grade_name']) ?> (<?= esc($pg['grade_code']) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Current Monthly Base (₹)</label>
            <input type="number" step="0.01" name="current_salary" class="form-control" placeholder="e.g. 50000.00">
          </div>
          <div class="form-group">
            <label class="form-label">Revised Monthly Base (₹)</label>
            <input type="number" step="0.01" name="revised_salary" class="form-control" placeholder="e.g. 65000.00">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Business Justification / Reason *</label>
          <textarea name="reason" class="form-control" rows="2" placeholder="Explain the rationale behind this career movement or promotion..." required></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalInitiateMovement').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit Requisition</button>
        </div>
      </form>
    </div>
  </div>
</div>
