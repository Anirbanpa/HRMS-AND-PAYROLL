<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Holiday Calendar &amp; Working Days Configuration
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Manage company-wide, branch-specific, and department holidays alongside weekly work schedules.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalAddHoliday').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Holiday
    </button>
  </div>
</div>

<div class="grid-3" style="margin-bottom: 24px;">
  <!-- LEFT: WORKING DAY CONFIGURATION -->
  <div class="card" style="grid-column: span 1;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">Weekly Schedule Config</h3>
    <p style="font-size: 12.5px; color: var(--color-slate-500); margin-bottom: 16px;">
      Set standard working days and weekend policies (e.g. 2nd &amp; 4th Saturday off).
    </p>

    <form action="<?= site_url('holidays/working-days') ?>" method="POST">
      <?= csrf_field() ?>
      <?php 
      $days = ['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday'];
      $configMap = [];
      foreach ($workingDays as $wd) {
        $configMap[$wd['day_of_week']] = $wd;
      }
      ?>

      <?php foreach ($days as $key => $label): 
        $cfg = $configMap[$key] ?? ['is_working' => ($key !== 'sunday' ? 1 : 0), 'working_type' => 'full_day', 'alternate_week_off' => null];
      ?>
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--color-slate-100);">
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            <input type="checkbox" name="is_working_<?= $key ?>" value="1" <?= $cfg['is_working'] ? 'checked' : '' ?>>
            <?= esc($label) ?>
          </label>
          <select name="working_type_<?= $key ?>" class="form-control" style="width: 120px; font-size: 12px; padding: 4px 8px;">
            <option value="full_day" <?= ($cfg['working_type'] === 'full_day') ? 'selected' : '' ?>>Full Day</option>
            <option value="half_day" <?= ($cfg['working_type'] === 'half_day') ? 'selected' : '' ?>>Half Day</option>
            <option value="off" <?= ($cfg['working_type'] === 'off') ? 'selected' : '' ?>>Week Off</option>
          </select>
        </div>
      <?php endforeach; ?>

      <div style="margin-top: 16px;">
        <label class="form-label" style="font-size: 12px;">Saturday Alternate Off Policy</label>
        <select name="alternate_saturday" class="form-control" style="font-size: 12.5px;">
          <option value="">None (Standard Every Week)</option>
          <option value="2nd_4th_saturday" selected>2nd and 4th Saturday Off</option>
          <option value="1st_3rd_saturday">1st and 3rd Saturday Off</option>
        </select>
      </div>

      <button type="submit" class="btn btn-secondary btn-sm" style="width: 100%; margin-top: 16px; justify-content: center;">
        Save Workday Schedule
      </button>
    </form>
  </div>

  <!-- RIGHT: HOLIDAY CALENDAR LIST -->
  <div class="card" style="grid-column: span 2;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
      <h3 style="font-size: 16px; font-weight: 700;">Holidays Calendar (<?= esc($selectedYear) ?>)</h3>
      <div style="display: flex; gap: 8px;">
        <a href="<?= site_url('holidays?year=' . ($selectedYear - 1)) ?>" class="btn btn-secondary btn-sm">&larr; <?= $selectedYear - 1 ?></a>
        <a href="<?= site_url('holidays?year=' . ($selectedYear + 1)) ?>" class="btn btn-secondary btn-sm"><?= $selectedYear + 1 ?> &rarr;</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Date &amp; Day</th>
            <th>Holiday Title</th>
            <th>Type</th>
            <th>Scope / Applicability</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($holidays)): ?>
            <tr><td colspan="5" style="text-align: center; color: var(--color-slate-500); padding: 24px;">No holidays scheduled for <?= esc($selectedYear) ?>.</td></tr>
          <?php else: ?>
            <?php foreach ($holidays as $h): ?>
              <tr>
                <td>
                  <strong><?= date('M j, Y', strtotime($h['date'])) ?></strong>
                  <div style="font-size: 12px; color: var(--color-slate-500);"><?= date('l', strtotime($h['date'])) ?></div>
                </td>
                <td>
                  <strong><?= esc($h['title']) ?></strong>
                  <?php if (!empty($h['description'])): ?>
                    <div style="font-size: 12px; color: var(--color-slate-500);"><?= esc($h['description']) ?></div>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="badge badge-info" style="font-size: 11px; text-transform: uppercase;">
                    <?= esc($h['holiday_type']) ?>
                  </span>
                </td>
                <td>
                  <?php if ($h['branch_name']): ?>
                    <span class="badge badge-secondary"><?= esc($h['branch_name']) ?></span>
                  <?php elseif ($h['department_name']): ?>
                    <span class="badge badge-secondary"><?= esc($h['department_name']) ?></span>
                  <?php else: ?>
                    <span class="badge badge-success">Company Wide</span>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="<?= site_url('holidays/delete/' . $h['id']) ?>" 
                     class="btn btn-danger btn-sm" 
                     onclick="return confirm('Are you sure you want to remove this holiday?')"
                     style="padding: 4px 10px; font-weight: 600;">
                    &times; Delete
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL: ADD HOLIDAY -->
<div id="modalAddHoliday" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Add Holiday to Calendar</h3>
      <button type="button" onclick="document.getElementById('modalAddHoliday').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('holidays/store') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Holiday Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Independence Day" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Date *</label>
          <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Holiday Type *</label>
          <select name="holiday_type" class="form-control" required>
            <option value="national">National Holiday</option>
            <option value="regional">Regional Holiday</option>
            <option value="company" selected>Company Holiday</option>
            <option value="restricted">Restricted / Optional</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Branch Scope (Optional)</label>
          <select name="branch_id" class="form-control">
            <option value="">All Branches</option>
            <?php foreach ($branches as $b): ?>
              <option value="<?= $b['id'] ?>"><?= esc($b['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Department Scope (Optional)</label>
          <select name="department_id" class="form-control">
            <option value="">All Departments</option>
            <?php foreach ($departments as $d): ?>
              <option value="<?= $d['id'] ?>"><?= esc($d['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Description / Remarks</label>
        <input type="text" name="description" class="form-control" placeholder="Optional notes">
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddHoliday').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Holiday</button>
      </div>
    </form>
  </div>
</div>
