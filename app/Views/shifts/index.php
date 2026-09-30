<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Shift and Rotation
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Define multi-shift timings, grace periods, rotational assignments, and department rosters.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <a href="<?= site_url('shifts/roster') ?>" class="btn btn-secondary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
      Rotation Planner
    </a>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalCreateShift').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Create New Shift
    </button>
  </div>
</div>

<!-- SHIFT CARDS GRID -->
<div class="grid-3" style="margin-bottom: 24px;">
  <?php foreach ($shifts as $s): ?>
    <div class="card" style="border-left: 4px solid var(--color-primary); display: flex; flex-direction: column; justify-content: space-between;">
      <div>
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
          <div>
            <span class="badge badge-info" style="font-size: 11px; text-transform: uppercase;">
              <?= esc(str_replace('_', ' ', $s['shift_type'] ?? 'regular')) ?>
            </span>
            <h3 style="font-size: 17px; font-weight: 700; margin-top: 6px;"><?= esc($s['name']) ?></h3>
            <span style="font-size: 12px; color: var(--color-slate-500);"><?= esc($s['code']) ?></span>
          </div>
          <span class="badge <?= ($s['status'] === 'active') ? 'badge-success' : 'badge-danger' ?>"><?= esc($s['status']) ?></span>
        </div>

        <div style="background: var(--color-slate-50); padding: 12px; border-radius: 8px; margin-bottom: 14px; font-size: 13px;">
          <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
            <span style="color: var(--color-slate-500);">Working Hours:</span>
            <strong><?= date('g:i A', strtotime($s['start_time'])) ?> - <?= date('g:i A', strtotime($s['end_time'])) ?></strong>
          </div>
          <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
            <span style="color: var(--color-slate-500);">Grace Period:</span>
            <span>Late: <strong><?= esc($s['late_grace_mins']) ?>m</strong> | Early: <strong><?= esc($s['early_exit_grace_mins']) ?>m</strong></span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <span style="color: var(--color-slate-500);">Allocated Staff:</span>
            <strong><?= esc($s['allocated_count'] ?? 0) ?> active</strong>
          </div>
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 1fr auto auto; gap: 6px; margin-top: 6px;">
        <button type="button" class="btn btn-secondary btn-sm" style="justify-content: center; font-size: 12px; padding: 6px 10px;"
                onclick="openAllocateModal(<?= (int)$s['id'] ?>, '<?= esc(addslashes($s['name'])) ?>')">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
          Assign
        </button>
        <button type="button" class="btn btn-outline btn-sm" style="padding: 6px 10px; font-size: 12px;" title="Edit Shift"
                onclick='openEditShiftModal(<?= htmlspecialchars(json_encode($s), ENT_QUOTES, 'UTF-8') ?>)'>
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit
        </button>
        <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
        <a href="<?= site_url('shifts/delete/' . $s['id']) ?>" class="btn btn-danger btn-sm" style="padding: 6px 10px; font-size: 12px;" title="Delete Shift"
           onclick="return confirm('Are you sure you want to delete shift &quot;<?= esc(addslashes($s['name'])) ?>&quot;? All associated assignments will also be removed.');">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          Delete
        </a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- ACTIVE SHIFT ALLOCATIONS TABLE -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <h3 style="font-size: 16px; font-weight: 700;">Active Employee Shift Assignments</h3>
    <span style="font-size: 13px; color: var(--color-slate-500);">Showing latest <?= count($allocations) ?> records</span>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Department</th>
          <th>Assigned Shift</th>
          <th>Timings</th>
          <th>Effective Period</th>
          <th>Rotation</th>
          <th>Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($allocations)): ?>
          <tr><td colspan="8" style="text-align: center; color: var(--color-slate-500); padding: 24px;">No shift allocations found.</td></tr>
        <?php else: ?>
          <?php foreach ($allocations as $a): ?>
            <tr>
              <td>
                <strong><?= esc($a['first_name'] . ' ' . $a['last_name']) ?></strong>
                <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($a['employee_code']) ?></div>
              </td>
              <td><?= esc($a['department_name'] ?? 'General') ?></td>
              <td><strong><?= esc($a['shift_name']) ?></strong></td>
              <td><?= date('g:i A', strtotime($a['start_time'])) ?> - <?= date('g:i A', strtotime($a['end_time'])) ?></td>
              <td>
                <?= esc($a['from_date']) ?> to <?= esc($a['to_date'] ?? 'Ongoing') ?>
              </td>
              <td>
                <span class="badge badge-info"><?= esc(ucfirst($a['rotation_pattern'] ?? 'fixed')) ?></span>
              </td>
              <td>
                <span class="badge badge-success"><?= esc(ucfirst($a['status'])) ?></span>
              </td>
              <td style="text-align: right;">
                <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
                <a href="<?= site_url('shifts/deallocate/' . $a['id']) ?>" class="btn btn-danger btn-sm" style="padding: 4px 8px; font-size: 11px;"
                   onclick="return confirm('Remove shift assignment for <?= esc(addslashes($a['first_name'] . ' ' . $a['last_name'])) ?>?');">
                  Remove
                </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL: CREATE SHIFT -->
<div id="modalCreateShift" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 540px; max-width: 90vw; max-height: 90vh; overflow-y: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Define New Shift</h3>
      <button type="button" onclick="document.getElementById('modalCreateShift').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('shifts/store') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Shift Name *</label>
        <input type="text" name="name" class="form-control" placeholder="e.g. Morning Tech Support" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Shift Code *</label>
          <input type="text" name="code" class="form-control" placeholder="SH-MORN-01" required>
        </div>
        <div class="form-group">
          <label class="form-label">Shift Type *</label>
          <select name="shift_type" class="form-control" required>
            <option value="regular">Regular Day Shift</option>
            <option value="rotational">Rotational Shift</option>
            <option value="split">Split Shift</option>
            <option value="night">Night Shift</option>
            <option value="flexible">Flexible Timing</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Start Time *</label>
          <input type="time" name="start_time" class="form-control" value="09:00" required>
        </div>
        <div class="form-group">
          <label class="form-label">End Time *</label>
          <input type="time" name="end_time" class="form-control" value="18:00" required>
        </div>
      </div>

      <div class="grid-3" style="margin-bottom: 16px;">
        <div class="form-group">
          <label class="form-label">Break (Mins)</label>
          <input type="number" name="break_duration_mins" class="form-control" value="60">
        </div>
        <div class="form-group">
          <label class="form-label">Late Grace (Mins)</label>
          <input type="number" name="late_grace_mins" class="form-control" value="15">
        </div>
        <div class="form-group">
          <label class="form-label">Early Grace (Mins)</label>
          <input type="number" name="early_exit_grace_mins" class="form-control" value="15">
        </div>
      </div>

      <div style="display: flex; gap: 15px; margin-bottom: 20px;">
        <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
          <input type="checkbox" name="overtime_eligible" value="1" checked> Overtime Eligible
        </label>
        <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
          <input type="checkbox" name="is_night_shift" value="1"> Night Shift Allowance
        </label>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalCreateShift').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Shift</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: ALLOCATE SHIFT -->
<div id="modalAllocateShift" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Assign Shift to Employee</h3>
      <button type="button" onclick="document.getElementById('modalAllocateShift').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('shifts/allocate') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="shift_id" id="allocShiftId">
      
      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Selected Shift</label>
        <input type="text" id="allocShiftName" class="form-control" readonly style="background: var(--color-slate-100);">
      </div>

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Select Employee *</label>
        <select name="employee_id" class="form-control" required>
          <option value="">-- Choose Employee --</option>
          <?php foreach ($employees as $e): ?>
            <option value="<?= $e['id'] ?>">
              <?= esc($e['first_name'] . ' ' . $e['last_name']) ?> (<?= esc($e['employee_code']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid-2" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Effective From *</label>
          <input type="date" name="from_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Effective To (Optional)</label>
          <input type="date" name="to_date" class="form-control">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Rotation Pattern</label>
        <select name="rotation_pattern" class="form-control">
          <option value="fixed">Fixed Permanent Shift</option>
          <option value="weekly">Weekly Rotation</option>
          <option value="bi_weekly">Bi-Weekly Rotation</option>
          <option value="monthly">Monthly Rotation</option>
        </select>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAllocateShift').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Confirm Allocation</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: EDIT SHIFT -->
<div id="modalEditShift" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 560px; max-width: 90vw; max-height: 90vh; overflow-y: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Edit Shift Definition</h3>
      <button type="button" onclick="document.getElementById('modalEditShift').style.display='none'" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--text-muted);">&times;</button>
    </div>

    <form id="formEditShift" action="" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="shift_id" id="editShiftId">

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Shift Name *</label>
        <input type="text" name="name" id="editShiftName" class="form-control" placeholder="e.g. Morning Shift" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Shift Code *</label>
          <input type="text" name="code" id="editShiftCode" class="form-control" placeholder="SH-MORN" required>
        </div>
        <div class="form-group">
          <label class="form-label">Shift Type *</label>
          <select name="shift_type" id="editShiftType" class="form-control" required>
            <option value="regular">Regular Day Shift</option>
            <option value="rotational">Rotational Shift</option>
            <option value="split">Split Shift</option>
            <option value="night">Night Shift</option>
            <option value="flexible">Flexible Timing</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Start Time *</label>
          <input type="time" name="start_time" id="editStartTime" class="form-control" required>
        </div>
        <div class="form-group">
          <label class="form-label">End Time *</label>
          <input type="time" name="end_time" id="editEndTime" class="form-control" required>
        </div>
      </div>

      <div class="grid-3" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Break (Mins)</label>
          <input type="number" name="break_duration_mins" id="editBreakDuration" class="form-control" value="60">
        </div>
        <div class="form-group">
          <label class="form-label">Late Grace (Mins)</label>
          <input type="number" name="late_grace_mins" id="editLateGrace" class="form-control" value="15">
        </div>
        <div class="form-group">
          <label class="form-label">Early Grace (Mins)</label>
          <input type="number" name="early_exit_grace_mins" id="editEarlyExitGrace" class="form-control" value="15">
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Shift Status</label>
          <select name="status" id="editStatus" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Min Overtime (Mins)</label>
          <input type="number" name="min_overtime_mins" id="editMinOvertime" class="form-control" value="30">
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 16px;">
        <div class="form-group">
          <label class="form-label">Half Day Hours</label>
          <input type="number" step="0.5" name="half_day_hours" id="editHalfDayHours" class="form-control" value="4.5">
        </div>
        <div class="form-group">
          <label class="form-label">Full Day Hours</label>
          <input type="number" step="0.5" name="full_day_hours" id="editFullDayHours" class="form-control" value="8.0">
        </div>
      </div>

      <div style="display: flex; gap: 18px; margin-bottom: 20px;">
        <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
          <input type="checkbox" name="overtime_eligible" id="editOvertimeEligible" value="1"> Overtime Eligible
        </label>
        <label style="display: flex; align-items: center; gap: 6px; font-size: 13px; cursor: pointer;">
          <input type="checkbox" name="is_night_shift" id="editIsNightShift" value="1"> Night Shift Allowance
        </label>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalEditShift').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
function openAllocateModal(shiftId, shiftName) {
  document.getElementById('allocShiftId').value = shiftId;
  document.getElementById('allocShiftName').value = shiftName;
  document.getElementById('modalAllocateShift').style.display = 'flex';
}

function openEditShiftModal(s) {
  document.getElementById('formEditShift').action = '<?= site_url('shifts/update') ?>/' + s.id;
  document.getElementById('editShiftId').value = s.id;
  document.getElementById('editShiftName').value = s.name || '';
  document.getElementById('editShiftCode').value = s.code || '';
  document.getElementById('editShiftType').value = s.shift_type || 'regular';
  document.getElementById('editStartTime').value = s.start_time ? s.start_time.substring(0, 5) : '09:00';
  document.getElementById('editEndTime').value = s.end_time ? s.end_time.substring(0, 5) : '18:00';
  document.getElementById('editBreakDuration').value = s.break_duration_mins !== undefined ? s.break_duration_mins : 60;
  document.getElementById('editLateGrace').value = s.late_grace_mins !== undefined ? s.late_grace_mins : 15;
  document.getElementById('editEarlyExitGrace').value = s.early_exit_grace_mins !== undefined ? s.early_exit_grace_mins : 15;
  document.getElementById('editStatus').value = s.status || 'active';
  document.getElementById('editMinOvertime').value = s.min_overtime_mins !== undefined ? s.min_overtime_mins : 30;
  document.getElementById('editHalfDayHours').value = s.half_day_hours || 4.5;
  document.getElementById('editFullDayHours').value = s.full_day_hours || 8.0;
  document.getElementById('editOvertimeEligible').checked = (s.overtime_eligible == 1);
  document.getElementById('editIsNightShift').checked = (s.is_night_shift == 1);
  document.getElementById('modalEditShift').style.display = 'flex';
}

window.addEventListener('click', function(e) {
  ['modalCreateShift', 'modalAllocateShift', 'modalEditShift'].forEach(function(id) {
    var modal = document.getElementById(id);
    if (modal && e.target === modal) {
      modal.style.display = 'none';
    }
  });
});
</script>
