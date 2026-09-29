<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
      Leave Management &amp; Approvals
    </h2>
    <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
      Multi-policy leave accrual, balance deductions, and dual-layer approval escalation (Manager &rarr; HR).
    </p>
  </div>
  <div>
    <?php if (!empty($currentUser['employee_id'])): ?>
      <button type="button" class="btn btn-primary" onclick="document.getElementById('modalApplyLeave').style.display='flex';" id="btnOpenApplyModal">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
        Apply for Leave
      </button>
    <?php endif; ?>
  </div>
</div>

<!-- LEAVE BALANCES FOR LOGGED IN EMPLOYEE -->
<?php if (!empty($myBalances)): ?>
  <div class="card" style="border-left: 4px solid #4f46e5; margin-bottom: 24px;">
    <div class="card-header">
      <div class="card-title">My Leave Entitlements &amp; Remaining Days (<?= date('Y') ?>)</div>
      <span style="font-size: 12px; color: #64748b;">Annual Accrual Engine Active</span>
    </div>
    <div class="card-body">
      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <?php foreach ($myBalances as $b): ?>
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 18px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
              <span style="font-size: 13px; font-weight: 700; color: #0f172a;"><?= esc($b['leave_type_name']) ?></span>
              <span class="badge badge-primary"><?= esc($b['leave_type_code']) ?></span>
            </div>
            <div style="font-size: 24px; font-weight: 800; color: #4f46e5;">
              <?= esc($b['remaining_days']) ?> <span style="font-size: 12px; font-weight: 500; color: #64748b;">days left</span>
            </div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 4px; display: flex; justify-content: space-between;">
              <span>Allocated: <?= esc($b['allocated_days']) ?>d</span>
              <span>Used: <?= esc($b['used_days']) ?>d</span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- LEAVE REQUESTS TABLE -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Leave Applications &amp; Approval Requests (<?= count($requests) ?>)</div>
    <div style="display: flex; gap: 8px;">
      <span class="badge badge-warning"><?= esc($pendingCount) ?> Pending</span>
      <span class="badge badge-success"><?= esc($approvedCount) ?> Approved</span>
    </div>
  </div>
  <div class="card-body" style="padding: 0;">
    <table class="table" style="margin-bottom: 0;">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Department</th>
          <th>Leave Type</th>
          <th>Date Range</th>
          <th>Duration</th>
          <th>Reason</th>
          <th>Approval Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($requests)): ?>
          <tr>
            <td colspan="8" style="text-align: center; color: #94a3b8; padding: 36px;">
              No leave requests in queue. Click "Apply for Leave" above to submit a new application.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($requests as $r): ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: #0f172a;"><?= esc($r['first_name'] . ' ' . $r['last_name']) ?></div>
                <code style="font-size: 11px; color: #64748b;"><?= esc($r['employee_code']) ?></code>
              </td>
              <td><?= esc($r['department_name'] ?? 'General') ?></td>
              <td>
                <span class="badge badge-primary"><?= esc($r['leave_type_name']) ?></span>
              </td>
              <td style="font-size: 12.5px;">
                <strong><?= esc(date('M j, Y', strtotime($r['start_date']))) ?></strong> &rarr; <strong><?= esc(date('M j, Y', strtotime($r['end_date']))) ?></strong>
              </td>
              <td>
                <strong style="color: #0f172a; font-size: 13.5px;"><?= esc($r['total_days']) ?> day<?= ($r['total_days'] > 1) ? 's' : '' ?></strong>
                <?php if ($r['is_half_day']): ?>
                  <span style="font-size: 10.5px; color: #3b82f6;">(Half Day)</span>
                <?php endif; ?>
              </td>
              <td style="max-width: 220px; font-size: 12px; color: #475569;">
                <?= esc($r['reason']) ?>
              </td>
              <td>
                <?php if ($r['status'] === 'pending'): ?>
                  <span class="badge badge-warning">Pending Approval</span>
                <?php elseif ($r['status'] === 'manager_approved'): ?>
                  <span class="badge badge-primary">Manager Approved</span>
                <?php elseif ($r['status'] === 'hr_approved'): ?>
                  <span class="badge badge-success">HR Approved &amp; Settled</span>
                <?php elseif ($r['status'] === 'rejected'): ?>
                  <span class="badge badge-danger">Rejected</span>
                <?php else: ?>
                  <span class="badge badge-secondary"><?= esc(ucfirst($r['status'])) ?></span>
                <?php endif; ?>
              </td>
              <td style="text-align: right; white-space: nowrap;">
                <?php if ($r['status'] === 'pending' || $r['status'] === 'manager_approved'): ?>
                  <a href="<?= site_url('leaves/approve/' . $r['id']) ?>" class="btn btn-primary btn-sm" style="background: #10b981; border-color: #10b981; font-size: 11.5px; padding: 4px 10px;" onclick="return confirm('Confirm approval for this leave request?');">
                    <?= ($r['status'] === 'pending' && $roleSlug === 'manager') ? 'Approve (Mgr)' : 'Final Approve (HR)' ?>
                  </a>

                  <button type="button" class="btn btn-outline btn-sm" style="color: #ef4444; border-color: #ef4444; font-size: 11.5px; padding: 4px 10px;" onclick="rejectLeave(<?= (int)$r['id'] ?>)">
                    Reject
                  </button>
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

<!-- APPLY LEAVE MODAL -->
<div id="modalApplyLeave" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 520px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="card-title">Apply for Time Off / Leave</div>
      <button type="button" onclick="document.getElementById('modalApplyLeave').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form action="<?= site_url('leaves/apply') ?>" method="POST" id="formSubmitLeave">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label" for="leave_type_id">Leave Category <span style="color: #ef4444;">*</span></label>
          <select name="leave_type_id" id="leave_type_id" class="form-control" required>
            <?php foreach ($leaveTypes as $lt): ?>
              <option value="<?= esc($lt['id']) ?>"><?= esc($lt['name']) ?> (<?= esc($lt['days_allowed_per_year']) ?> days allowed/yr)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label" for="start_date">Start Date <span style="color: #ef4444;">*</span></label>
            <input type="date" name="start_date" id="start_date" class="form-control date-input-clickable" required value="<?= date('Y-m-d') ?>" onclick="try{this.showPicker()}catch(e){}">
          </div>

          <div class="form-group">
            <label class="form-label" for="end_date">End Date <span style="color: #ef4444;">*</span></label>
            <input type="date" name="end_date" id="end_date" class="form-control date-input-clickable" required value="<?= date('Y-m-d') ?>" onclick="try{this.showPicker()}catch(e){}">
          </div>
        </div>

        <div class="form-group">
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; color: #334155;">
            <input type="checkbox" name="is_half_day" value="1" style="accent-color: #4f46e5;">
            <span>Apply as Half-Day leave (0.5 day deduction)</span>
          </label>
        </div>

        <div class="form-group">
          <label class="form-label" for="leave_reason">Reason for Absence <span style="color: #ef4444;">*</span></label>
          <textarea name="reason" id="leave_reason" class="form-control" rows="3" placeholder="Provide details for manager and HR sign-off..." required></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalApplyLeave').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btnSubmitLeaveApp">Submit Application</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- REJECT LEAVE HIDDEN FORM & SCRIPT -->
<form id="formRejectLeave" method="POST" style="display: none;">
  <?= csrf_field() ?>
  <input type="hidden" name="rejection_reason" id="rejectionReasonInput">
</form>

<script>
function rejectLeave(id) {
  const reason = prompt('Please enter the reason for rejection:');
  if (reason !== null && reason.trim() !== '') {
    const form = document.getElementById('formRejectLeave');
    form.action = '<?= site_url('leaves/reject/') ?>' + id;
    document.getElementById('rejectionReasonInput').value = reason.trim();
    form.submit();
  }
}
</script>

