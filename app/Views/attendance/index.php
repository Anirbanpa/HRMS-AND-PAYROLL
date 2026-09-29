<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
      Attendance &amp; Time Tracking
    </h2>
    <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
      Real-time shift logs, ESS web clock-in/out, and automated biometric punch pairing.
    </p>
  </div>
  <div style="display: flex; gap: 10px; align-items: center;">
    <?php 
      $canManageAttendance = in_array($currentRoleSlug ?? '', ['super_admin', 'hr_admin', 'manager'], true);
    ?>
    <?php if ($canManageAttendance): ?>
      <button type="button" class="btn btn-primary" id="btnOpenManualAttendance" onclick="openManualAttendanceModal()" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
        Manual Attendance
      </button>
    <?php endif; ?>

    <!-- ESS Web Clock In/Out Quick Button -->
    <?php if (!empty($currentUser['employee_id'])): ?>
      <form action="<?= site_url('attendance/clock') ?>" method="POST" style="margin: 0;">
        <?= csrf_field() ?>
        <?php if (!$myTodayRecord): ?>
          <button type="submit" class="btn btn-outline" id="btnClockIn" style="border-color: #10b981; color: #10b981; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Web Clock IN (<?= date('H:i') ?>)
          </button>
        <?php elseif (empty($myTodayRecord['clock_out'])): ?>
          <button type="submit" class="btn btn-outline" id="btnClockOut" style="border-color: #f59e0b; color: #d97706; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/></svg>
            Web Clock OUT (In at <?= date('H:i', strtotime($myTodayRecord['clock_in'])) ?>)
          </button>
        <?php else: ?>
          <span class="badge badge-success" style="padding: 8px 14px; font-size: 13px;">
            Completed (<?= esc($myTodayRecord['total_hours']) ?> hrs)
          </span>
        <?php endif; ?>
      </form>
    <?php endif; ?>
  </div>
</div>

<!-- Navigation Tabs -->
<div style="display: flex; border-bottom: 2px solid var(--color-slate-200); margin-bottom: 24px; gap: 20px;">
  <a href="<?= site_url('attendance?tab=register') ?>" style="padding: 10px 4px; font-weight: <?= ($activeTab !== 'biometric') ? '700' : '600' ?>; font-size: 14px; text-decoration: none; border-bottom: 2px solid <?= ($activeTab !== 'biometric') ? 'var(--color-primary)' : 'transparent' ?>; margin-bottom: -2px; color: <?= ($activeTab !== 'biometric') ? 'var(--color-primary)' : 'var(--color-slate-500)' ?>;">
    Attendance Register &amp; Daily Logs
  </a>
  <a href="<?= site_url('attendance?tab=biometric') ?>" style="padding: 10px 4px; font-weight: <?= ($activeTab === 'biometric') ? '700' : '600' ?>; font-size: 14px; text-decoration: none; border-bottom: 2px solid <?= ($activeTab === 'biometric') ? 'var(--color-primary)' : 'transparent' ?>; margin-bottom: -2px; color: <?= ($activeTab === 'biometric') ? 'var(--color-primary)' : 'var(--color-slate-500)' ?>;">
    Biometric Hardware &amp; Live Punch Monitor (Module 11)
  </a>
</div>

<?php if ($activeTab !== 'biometric'): ?>
<!-- DAILY SUMMARY STAT CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Active Selected Date</div>
      <div class="stat-value" style="font-size: 20px;"><?= esc(date('M j, Y', strtotime($selectedDate))) ?></div>
      <div class="stat-subtext">Real-time daily roster</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
    </div>
  </div>

  <div class="stat-card emerald">
    <div class="stat-content">
      <div class="stat-label">Punctual &amp; Present</div>
      <div class="stat-value"><?= esc($presentCount) ?></div>
      <div class="stat-subtext">On time within grace period</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
  </div>

  <div class="stat-card amber">
    <div class="stat-content">
      <div class="stat-label">Late Arrivals</div>
      <div class="stat-value"><?= esc($lateCount) ?></div>
      <div class="stat-subtext">Clocked after 15m grace</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>

  <div class="stat-card sky">
    <div class="stat-content">
      <div class="stat-label">Half-Day &amp; Partial</div>
      <div class="stat-value"><?= esc($halfDayCount) ?></div>
      <div class="stat-subtext">&lt; 4.5 hours logged</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a10 10 0 0 1 0 20Z"/></svg>
    </div>
  </div>
</div>

<!-- FILTER BAR -->
<div class="card" style="margin-bottom: 24px; padding: 16px 20px;">
  <form action="<?= site_url('attendance') ?>" method="GET" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 240px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
        <label class="form-label" for="dateFilter" style="margin-bottom: 0;">Select Date</label>
        <div style="display: flex; gap: 4px;">
          <a href="<?= site_url('attendance?date=' . date('Y-m-d', strtotime($selectedDate . ' -1 day')) . (!empty($filters['department_id']) ? '&department_id=' . $filters['department_id'] : '') . (!empty($filters['status']) ? '&status=' . $filters['status'] : '')) ?>" class="date-preset-btn" style="padding: 2px 7px; font-size: 11px;" title="Previous day">&larr;</a>
          <a href="<?= site_url('attendance?date=' . date('Y-m-d') . (!empty($filters['department_id']) ? '&department_id=' . $filters['department_id'] : '') . (!empty($filters['status']) ? '&status=' . $filters['status'] : '')) ?>" class="date-preset-btn <?= ($selectedDate === date('Y-m-d')) ? 'active' : '' ?>" style="padding: 2px 8px; font-size: 11px;" title="Today">Today</a>
          <a href="<?= site_url('attendance?date=' . date('Y-m-d', strtotime($selectedDate . ' +1 day')) . (!empty($filters['department_id']) ? '&department_id=' . $filters['department_id'] : '') . (!empty($filters['status']) ? '&status=' . $filters['status'] : '')) ?>" class="date-preset-btn" style="padding: 2px 7px; font-size: 11px;" title="Next day">&rarr;</a>
        </div>
      </div>
      <input type="date" name="date" id="dateFilter" class="form-control date-input-clickable" value="<?= esc($selectedDate) ?>" onclick="try{this.showPicker()}catch(e){}" onchange="this.form.submit()">
    </div>

    <div style="flex: 1; min-width: 200px;">
      <label class="form-label" for="deptFilter">Filter Department</label>
      <select name="department_id" id="deptFilter" class="form-control">
        <option value="">All Departments</option>
        <?php foreach ($departments as $d): ?>
          <option value="<?= esc($d['id']) ?>" <?= (($filters['department_id'] ?? '') == $d['id']) ? 'selected' : '' ?>>
            <?= esc($d['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div style="flex: 1; min-width: 160px;">
      <label class="form-label" for="statusFilter">Status</label>
      <select name="status" id="statusFilter" class="form-control">
        <option value="">All Statuses</option>
        <option value="Present" <?= (($filters['status'] ?? '') === 'Present') ? 'selected' : '' ?>>Present</option>
        <option value="Late" <?= (($filters['status'] ?? '') === 'Late') ? 'selected' : '' ?>>Late</option>
        <option value="Half-Day" <?= (($filters['status'] ?? '') === 'Half-Day') ? 'selected' : '' ?>>Half-Day</option>
      </select>
    </div>

    <div>
      <button type="submit" class="btn btn-primary" id="btnFilterAttendance">
        Filter Logs
      </button>
      <a href="<?= site_url('attendance') ?>" class="btn btn-outline" style="margin-left: 6px;">Reset</a>
    </div>
  </form>
</div>

<!-- ATTENDANCE REGISTER TABLE -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Daily Attendance Logs (<?= count($records) ?> records)</div>
    <span class="badge badge-primary">Date: <?= esc($selectedDate) ?></span>
  </div>
  <div class="card-body" style="padding: 0;">
    <table class="table" style="margin-bottom: 0;">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Department / Branch</th>
          <th>Shift</th>
          <th>Clock IN</th>
          <th>Clock OUT</th>
          <th>Total Hours</th>
          <th>Late Arrival</th>
          <th>Status</th>
          <th>Source</th>
          <?php if ($canManageAttendance): ?>
            <th style="text-align: right;">Action</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($records)): ?>
          <tr>
            <td colspan="<?= $canManageAttendance ? '10' : '9' ?>" style="text-align: center; color: #94a3b8; padding: 36px;">
              No attendance records logged for <strong><?= esc($selectedDate) ?></strong> yet. Employees can clock in using the button above or via Biometric sync.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($records as $row): ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: #0f172a;"><?= esc($row['first_name'] . ' ' . $row['last_name']) ?></div>
                <code style="font-size: 11px; color: #4f46e5;"><?= esc($row['employee_code']) ?></code>
              </td>
              <td>
                <div><?= esc($row['department_name'] ?? 'General') ?></div>
                <div style="font-size: 11.5px; color: #64748b;"><?= esc($row['branch_name'] ?? 'HQ') ?></div>
              </td>
              <td><?= esc($row['shift_name'] ?? 'General Day (09:00 - 18:00)') ?></td>
              <td>
                <strong><?= esc($row['clock_in'] ? date('H:i:s', strtotime($row['clock_in'])) : '--') ?></strong>
                <?php if ($row['clock_in_ip']): ?>
                  <div style="font-size: 10px; color: #94a3b8;">IP: <?= esc($row['clock_in_ip']) ?></div>
                <?php endif; ?>
              </td>
              <td>
                <strong><?= esc($row['clock_out'] ? date('H:i:s', strtotime($row['clock_out'])) : '--') ?></strong>
                <?php if ($row['clock_out_ip']): ?>
                  <div style="font-size: 10px; color: #94a3b8;">IP: <?= esc($row['clock_out_ip']) ?></div>
                <?php endif; ?>
              </td>
              <td>
                <strong style="color: #0f172a; font-size: 13.5px;"><?= esc($row['total_hours']) ?> hrs</strong>
              </td>
              <td>
                <?php if ($row['late_minutes'] > 0): ?>
                  <span style="color: #ef4444; font-weight: 700; font-size: 12px;">+<?= esc($row['late_minutes']) ?> mins</span>
                <?php else: ?>
                  <span style="color: #10b981; font-size: 12px;">On time</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($row['status'] === 'Present'): ?>
                  <span class="badge badge-success">Present</span>
                <?php elseif ($row['status'] === 'Late'): ?>
                  <span class="badge badge-warning">Late</span>
                <?php else: ?>
                  <span class="badge badge-secondary"><?= esc($row['status']) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <span class="badge badge-primary" style="font-size: 10.5px;"><?= esc(ucfirst($row['source'])) ?></span>
              </td>
              <?php if ($canManageAttendance): ?>
                <td style="text-align: right; white-space: nowrap;">
                  <button type="button" class="btn btn-outline btn-sm" onclick='editAttendanceLog(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8") ?>)' style="padding: 3px 8px; font-size: 11px;">
                    Edit
                  </button>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL: MANUAL ATTENDANCE ENTRY / OVERRIDE -->
<?php if ($canManageAttendance): ?>
<div id="modalManualAttendance" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 520px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0; max-height: 90vh; overflow-y: auto;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <div class="card-title" id="manualModalTitle">Mark Manual Attendance</div>
        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Record or adjust attendance entry with audit trail</div>
      </div>
      <button type="button" onclick="closeManualAttendanceModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #64748b; line-height: 1;">&times;</button>
    </div>
    <div class="card-body">
      <form action="<?= site_url('attendance/manual') ?>" method="POST" id="formManualAttendance">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="manualAttId" value="">

        <div class="form-group">
          <label class="form-label" for="manualEmployeeId">Employee *</label>
          <select name="employee_id" id="manualEmployeeId" class="form-control" required>
            <option value="">-- Select Employee --</option>
            <?php foreach (($employees ?? []) as $emp): ?>
              <option value="<?= esc($emp['id']) ?>">
                <?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= esc($emp['employee_code']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label" for="manualDate">Attendance Date *</label>
            <input type="date" name="date" id="manualDate" class="form-control date-input-clickable" required value="<?= esc($selectedDate) ?>" onclick="try{this.showPicker()}catch(e){}">
          </div>

          <div class="form-group">
            <label class="form-label" for="manualShiftId">Shift</label>
            <select name="shift_id" id="manualShiftId" class="form-control">
              <?php foreach ($shifts as $s): ?>
                <option value="<?= esc($s['id']) ?>">
                  <?= esc($s['name']) ?> (<?= esc(substr($s['start_time'], 0, 5)) ?> - <?= esc(substr($s['end_time'], 0, 5)) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label" for="manualStatus">Attendance Status *</label>
            <select name="status" id="manualStatus" class="form-control" required onchange="handleStatusChange(this.value)">
              <option value="Present">Present</option>
              <option value="Late">Late</option>
              <option value="Half-Day">Half-Day</option>
              <option value="Absent">Absent</option>
              <option value="On Leave">On Leave</option>
              <option value="Holiday">Holiday</option>
              <option value="Week Off">Week Off</option>
            </select>
          </div>

          <div class="form-group" id="groupLateMins">
            <label class="form-label" for="manualLateMins">Late Arrival (Mins)</label>
            <input type="number" name="late_minutes" id="manualLateMins" class="form-control" min="0" value="0" placeholder="0">
          </div>
        </div>

        <div class="grid-2" id="groupClockTimes">
          <div class="form-group">
            <label class="form-label" for="manualClockIn">Clock IN Time</label>
            <input type="time" name="clock_in" id="manualClockIn" class="form-control" value="09:00" step="1">
          </div>

          <div class="form-group">
            <label class="form-label" for="manualClockOut">Clock OUT Time</label>
            <input type="time" name="clock_out" id="manualClockOut" class="form-control" value="18:00" step="1">
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="manualNotes">Reason / Adjustment Notes *</label>
          <input type="text" name="notes" id="manualNotes" class="form-control" placeholder="e.g. On-duty client visit / Biometric turnstile issue / Manual supervisor entry" required value="Manual entry by HR">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;">
          <button type="button" class="btn btn-outline" onclick="closeManualAttendanceModal()">Cancel</button>
          <button type="submit" class="btn btn-primary" id="btnSaveManualAttendance">Save Attendance Record</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openManualAttendanceModal() {
  document.getElementById('manualModalTitle').textContent = 'Mark Manual Attendance';
  document.getElementById('manualAttId').value = '';
  document.getElementById('manualEmployeeId').value = '';
  document.getElementById('manualEmployeeId').removeAttribute('disabled');
  document.getElementById('manualDate').value = '<?= esc($selectedDate) ?>';
  document.getElementById('manualStatus').value = 'Present';
  document.getElementById('manualClockIn').value = '09:00';
  document.getElementById('manualClockOut').value = '18:00';
  document.getElementById('manualLateMins').value = '0';
  document.getElementById('manualNotes').value = 'Manual entry by HR';
  handleStatusChange('Present');
  document.getElementById('modalManualAttendance').style.display = 'flex';
}

function editAttendanceLog(row) {
  document.getElementById('manualModalTitle').textContent = 'Adjust / Override Attendance (' + row.employee_code + ')';
  document.getElementById('manualAttId').value = row.id || '';
  document.getElementById('manualEmployeeId').value = row.employee_id || '';
  document.getElementById('manualDate').value = row.date || '<?= esc($selectedDate) ?>';
  if (row.shift_id) {
    document.getElementById('manualShiftId').value = row.shift_id;
  }
  document.getElementById('manualStatus').value = row.status || 'Present';
  
  if (row.clock_in) {
    const dIn = new Date(row.clock_in.replace(/-/g, '/'));
    const hh = String(dIn.getHours()).padStart(2, '0');
    const mm = String(dIn.getMinutes()).padStart(2, '0');
    document.getElementById('manualClockIn').value = hh + ':' + mm;
  } else {
    document.getElementById('manualClockIn').value = '';
  }

  if (row.clock_out) {
    const dOut = new Date(row.clock_out.replace(/-/g, '/'));
    const hh = String(dOut.getHours()).padStart(2, '0');
    const mm = String(dOut.getMinutes()).padStart(2, '0');
    document.getElementById('manualClockOut').value = hh + ':' + mm;
  } else {
    document.getElementById('manualClockOut').value = '';
  }

  document.getElementById('manualLateMins').value = row.late_minutes || 0;
  document.getElementById('manualNotes').value = row.notes || 'Supervisor manual adjustment';
  
  handleStatusChange(row.status || 'Present');
  document.getElementById('modalManualAttendance').style.display = 'flex';
}

function closeManualAttendanceModal() {
  document.getElementById('modalManualAttendance').style.display = 'none';
}

function handleStatusChange(status) {
  const clockGroup = document.getElementById('groupClockTimes');
  const lateGroup = document.getElementById('groupLateMins');
  const inInput = document.getElementById('manualClockIn');
  const outInput = document.getElementById('manualClockOut');
  
  if (status === 'Absent' || status === 'On Leave' || status === 'Holiday' || status === 'Week Off') {
    clockGroup.style.opacity = '0.4';
    inInput.disabled = true;
    outInput.disabled = true;
    lateGroup.style.display = 'none';
  } else {
    clockGroup.style.opacity = '1';
    inInput.disabled = false;
    outInput.disabled = false;
    lateGroup.style.display = 'block';
    if (status === 'Late' && (!document.getElementById('manualLateMins').value || document.getElementById('manualLateMins').value === '0')) {
      document.getElementById('manualLateMins').value = '15';
    }
  }
}
</script>
<?php endif; ?>

<?php else: ?>
<!-- BIOMETRIC HARDWARE & REAL-TIME PUNCH MONITOR (Module 11) -->
<div style="margin-bottom: 24px;">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
    <div>
      <h3 style="font-size: 17px; font-weight: 700; color: #0f172a;">Registered Biometric &amp; Access Control Terminals</h3>
      <p style="font-size: 13px; color: #64748b;">Hardware devices deployed across facilities streaming real-time biometric timestamps.</p>
    </div>
    <span class="badge badge-success" style="padding: 6px 12px; font-size: 12px;">3 Devices Online (100% Health)</span>
  </div>

  <div class="grid-3" style="margin-bottom: 24px;">
    <?php foreach ($biometricDevices as $dev): ?>
      <div class="card" style="border-top: 3px solid #10b981; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
          <div>
            <span class="badge badge-secondary" style="font-family: monospace; font-size: 11px;"><?= esc($dev['device_id']) ?></span>
            <h4 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 4px;"><?= esc($dev['device_name']) ?></h4>
          </div>
          <span class="badge badge-success" style="display: inline-flex; align-items: center; gap: 4px;">
            <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
            <?= esc($dev['status']) ?>
          </span>
        </div>

        <div style="background: #f8fafc; border-radius: 6px; padding: 10px 12px; font-size: 12.5px; margin-bottom: 12px; border: 1px solid #e2e8f0;">
          <div style="margin-bottom: 4px; display: flex; justify-content: space-between;">
            <span style="color: #64748b;">IP Address:</span>
            <code><?= esc($dev['ip_address']) ?>:<?= esc($dev['port']) ?></code>
          </div>
          <div style="margin-bottom: 4px; display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Location:</span>
            <strong><?= esc($dev['location']) ?></strong>
          </div>
          <div style="margin-bottom: 4px; display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Firmware:</span>
            <span><?= esc($dev['firmware']) ?></span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Last Heartbeat:</span>
            <span style="color: #10b981; font-weight: 600;"><?= esc($dev['last_ping']) ?></span>
          </div>
        </div>

        <button type="button" class="btn btn-secondary btn-sm" style="width: 100%; justify-content: center;" onclick="quickTestDevice('<?= esc($dev['device_id']) ?>')">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
          Simulate Device Punch
        </button>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="grid-2" style="margin-bottom: 24px;">
  <!-- SIMULATION / PUNCH TEST DISPATCHER -->
  <div class="card">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 16px;">
      <div class="card-title" style="font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Biometric Hardware Test &amp; Manual Punch Dispatcher
      </div>
      <p style="font-size: 12.5px; color: #64748b; margin-top: 2px;">Simulate physical RFID badge or fingerprint reader pulse directly into HRMS database.</p>
    </div>

    <form action="<?= site_url('attendance/biometric/test') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Employee *</label>
        <select name="employee_code" id="bioTestEmpCode" class="form-control" required>
          <?php foreach ($employees as $e): ?>
            <option value="<?= esc($e['employee_code']) ?>">
              <?= esc($e['employee_code']) ?> &ndash; <?= esc($e['first_name'] . ' ' . $e['last_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid-2" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Punch Type *</label>
          <select name="punch_type" class="form-control" required>
            <option value="IN">Clock IN (Entry)</option>
            <option value="OUT">Clock OUT (Exit)</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Source Terminal *</label>
          <select name="device_id" id="bioTestDeviceId" class="form-control" required>
            <option value="BIO-GATE-01">BIO-GATE-01 (Main Turnstile)</option>
            <option value="BIO-GATE-02">BIO-GATE-02 (Basement Service)</option>
            <option value="BIO-FACIAL-03">BIO-FACIAL-03 (Executive Scanner)</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; font-weight: 600;">
        Dispatch Biometric Punch Event
      </button>
    </form>
  </div>

  <!-- REST API WEBHOOK INTEGRATION SPEC -->
  <div class="card" style="background: #0f172a; color: #f8fafc; border: 1px solid #1e293b;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; border-bottom: 1px solid #334155; padding-bottom: 10px;">
      <div>
        <div style="font-size: 15px; font-weight: 700; color: #38bdf8;">Device Integration Webhook Endpoint</div>
        <div style="font-size: 12px; color: #94a3b8;">Compatible with ZKTeco ADMS, Hikvision, Dahua &amp; eSSL Cloud</div>
      </div>
      <span class="badge" style="background: #065f46; color: #6ee7b7; font-size: 11px;">HTTP POST</span>
    </div>

    <div style="font-family: monospace; font-size: 12px; margin-bottom: 12px; color: #e2e8f0; background: #1e293b; padding: 10px 12px; border-radius: 6px;">
      <?= site_url('api/v1/attendance/punch') ?>
    </div>

    <div style="font-size: 12px; color: #94a3b8; margin-bottom: 8px;">JSON Payload Schema:</div>
    <pre style="background: #1e293b; color: #38bdf8; padding: 12px; border-radius: 6px; font-size: 11.5px; overflow-x: auto; margin: 0 0 12px 0;">{
  "employee_code": "EMP0001",
  "punch_type": "IN", // "IN" or "OUT"
  "timestamp": "<?= date('Y-m-d H:i:s') ?>",
  "device_id": "BIO-GATE-01"
}</pre>
    <div style="font-size: 11px; color: #94a3b8;">
      Devices automatically sync punch times; duplicates within 60s are automatically deduplicated.
    </div>
  </div>
</div>

<!-- LIVE BIOMETRIC PUNCH LOGS STREAM -->
<div class="card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
  <div style="padding: 16px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h3 style="font-size: 15px; font-weight: 700; color: #0f172a;">Live Biometric Ingestion Stream (Recent 20 Logs)</h3>
      <p style="font-size: 12px; color: #64748b;">Hardware punches streamed from turnstiles, biometric scanners, and facial recognition terminals.</p>
    </div>
    <span class="badge badge-info">Real-time Feed</span>
  </div>

  <div style="overflow-x: auto;">
    <table class="table" style="width: 100%; font-size: 13px;">
      <thead>
        <tr>
          <th>Employee</th>
          <th>Department</th>
          <th>Date</th>
          <th>Clock IN</th>
          <th>Clock OUT</th>
          <th>Total Hours</th>
          <th>Terminal &amp; Audit Notes</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($biometricPunches)): ?>
          <tr>
            <td colspan="7" style="text-align: center; color: #94a3b8; padding: 32px;">
              No biometric punches recorded yet. Use the test dispatcher above or send an API payload to <code>/api/v1/attendance/punch</code>.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($biometricPunches as $bp): ?>
            <tr>
              <td>
                <div style="font-weight: 600; color: #0f172a;"><?= esc($bp['first_name'] . ' ' . $bp['last_name']) ?></div>
                <code style="font-size: 11px; color: #4f46e5;"><?= esc($bp['employee_code']) ?></code>
              </td>
              <td><?= esc($bp['department_name'] ?? 'General') ?></td>
              <td><?= esc(date('M d, Y', strtotime($bp['date']))) ?></td>
              <td>
                <strong><?= esc($bp['clock_in'] ? date('H:i:s', strtotime($bp['clock_in'])) : '--') ?></strong>
              </td>
              <td>
                <strong><?= esc($bp['clock_out'] ? date('H:i:s', strtotime($bp['clock_out'])) : '--') ?></strong>
              </td>
              <td>
                <strong style="color: #0f172a;"><?= esc($bp['total_hours']) ?> hrs</strong>
              </td>
              <td>
                <span class="badge badge-secondary" style="font-size: 11px;"><?= esc($bp['notes'] ?? 'Biometric device') ?></span>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function quickTestDevice(deviceId) {
  document.getElementById('bioTestDeviceId').value = deviceId;
  window.scrollTo({ top: 300, behavior: 'smooth' });
}
</script>
<?php endif; ?>

