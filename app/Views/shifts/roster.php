<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Shift and Rotation Planner
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Multi-department shift rotation matrix and staff scheduling calendar.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <a href="<?= site_url('shifts') ?>" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 6px;">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
      Back to Shifts
    </a>
  </div>
</div>

<!-- FILTER & DATE CONTROLS BAR -->
<div class="card" style="margin-bottom: 20px; padding: 20px;">
  <!-- Quick Date Presets & Month Navigation -->
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px solid var(--border-color);">
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
      <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.04em;">
        Quick Ranges:
      </span>
      <button type="button" class="date-preset-btn" onclick="setDatePreset('this-month')" title="Full current calendar month">
        This Month
      </button>
      <button type="button" class="date-preset-btn" onclick="setDatePreset('next-month')" title="Full next calendar month">
        Next Month
      </button>
      <button type="button" class="date-preset-btn" onclick="setDatePreset('this-week')" title="Current week (Monday - Sunday)">
        This Week
      </button>
      <button type="button" class="date-preset-btn" onclick="setDatePreset('14-days')" title="Next 14 days starting today">
        Next 14 Days
      </button>
      <button type="button" class="date-preset-btn" onclick="setDatePreset('30-days')" title="Next 30 days starting today">
        30 Days
      </button>
    </div>

    <div style="display: flex; align-items: center; gap: 6px;">
      <button type="button" class="date-preset-btn" onclick="shiftMonth(-1)" title="Go to previous month">
        &larr; Prev Month
      </button>
      <button type="button" class="date-preset-btn" onclick="shiftMonth(1)" title="Go to next month">
        Next Month &rarr;
      </button>
    </div>
  </div>

  <form id="rosterFilterForm" action="<?= site_url('shifts/roster') ?>" method="GET" style="display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap;">
    <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
      <label class="form-label" style="font-weight: 600;">Department</label>
      <select name="department_id" id="departmentFilter" class="form-control" onchange="document.getElementById('rosterFilterForm').submit()">
        <option value="all" <?= ($selectedDept === 'all' || empty($selectedDept)) ? 'selected' : '' ?>>All Departments</option>
        <?php foreach ($departments as $dept): ?>
          <option value="<?= $dept['id'] ?>" <?= ((string)$dept['id'] === (string)$selectedDept) ? 'selected' : '' ?>>
            <?= esc($dept['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group" style="margin-bottom: 0; min-width: 160px;">
      <label class="form-label" for="startDate" style="font-weight: 600;">Start Date</label>
      <div style="position: relative;">
        <input type="date" name="start_date" id="startDate" class="form-control date-input-clickable" value="<?= esc($startDate) ?>" onchange="onStartDateChange()" onclick="try{this.showPicker()}catch(e){}" required>
      </div>
    </div>

    <div class="form-group" style="margin-bottom: 0; min-width: 160px;">
      <label class="form-label" for="endDate" style="font-weight: 600;">End Date</label>
      <div style="position: relative;">
        <input type="date" name="end_date" id="endDate" class="form-control date-input-clickable" value="<?= esc($endDate) ?>" onclick="try{this.showPicker()}catch(e){}" required>
      </div>
    </div>

    <div style="display: flex; gap: 8px;">
      <button type="submit" class="btn btn-primary" style="height: 42px; display: inline-flex; align-items: center; gap: 6px;">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Load Roster
      </button>
      <a href="<?= site_url('shifts/roster?department_id=all') ?>" class="btn btn-secondary" style="height: 42px; display: inline-flex; align-items: center;" title="Reset filters to current month">
        Reset
      </a>
    </div>
  </form>
</div>

<?php 
$start = new DateTime($startDate);
$end   = new DateTime($endDate);
if ($start > $end) {
  $end = clone $start;
}
$interval = new DateInterval('P1D');
$period   = new DatePeriod($start, $interval, (clone $end)->modify('+1 day'));
$dates = [];
$maxDays = 45; // Up to 45 days supported smoothly with horizontal scroll
$count = 0;
$todayStr = date('Y-m-d');
foreach ($period as $dt) {
  if ($count++ >= $maxDays) break;
  $dates[] = $dt->format('Y-m-d');
}
$daysCount = count($dates);
?>

<!-- ROSTER MATRIX TABLE -->
<div class="card">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
    <div>
      <h3 style="font-size: 16px; font-weight: 700; color: var(--color-slate-900);">
        <?= ($selectedDept === 'all') ? 'All Departments Rotation Matrix' : 'Department Staffing Schedule' ?>
      </h3>
      <div style="font-size: 12.5px; color: var(--color-slate-500); margin-top: 3px;">
        Showing <strong><?= $daysCount ?> days</strong> (<?= date('M j, Y', strtotime($startDate)) ?> &ndash; <?= !empty($dates) ? date('M j, Y', strtotime(end($dates))) : date('M j, Y', strtotime($endDate)) ?>) &bull; <strong><?= count($team) ?> team members</strong>
      </div>
    </div>
    <div style="display: flex; gap: 8px; font-size: 12px; flex-wrap: wrap;">
      <?php foreach ($shifts as $sh): ?>
        <span class="badge badge-secondary" title="<?= esc($sh['name']) ?>"><?= esc($sh['code']) ?>: <?= date('H:i', strtotime($sh['start_time'])) ?>-<?= date('H:i', strtotime($sh['end_time'])) ?></span>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="table-responsive" style="max-height: 700px; overflow-x: auto;">
    <table class="table" style="min-width: <?= max(800, 220 + ($daysCount * 65)) ?>px; border-collapse: separate; border-spacing: 0;">
      <thead>
        <tr>
          <th style="min-width: 200px; position: sticky; left: 0; background: var(--bg-card); z-index: 2; border-right: 2px solid var(--border-color);">
            Team Member
          </th>
          <?php foreach ($dates as $d): 
            $dt = new DateTime($d);
            $isWeekend = in_array($dt->format('N'), [6, 7]);
            $isToday = ($d === $todayStr);
            $thStyle = 'text-align: center; min-width: 60px; padding: 8px 4px;';
            if ($isToday) {
              $thStyle .= ' background: var(--color-purple-light); border-top: 3px solid var(--primary); border-bottom: 2px solid var(--primary);';
            } elseif ($isWeekend) {
              $thStyle .= ' background: var(--color-slate-100); color: var(--color-slate-600);';
            }
          ?>
            <th style="<?= $thStyle ?>">
              <?php if ($isToday): ?>
                <span class="badge badge-primary" style="font-size: 8.5px; padding: 1px 4px; display: inline-block; margin-bottom: 2px; line-height: 1.1;">TODAY</span>
                <br>
              <?php endif; ?>
              <span style="<?= $isToday ? 'font-weight: 800; color: var(--primary);' : '' ?>"><?= $dt->format('M j') ?></span>
              <br>
              <small style="font-weight: normal; opacity: 0.8; font-size: 11px;"><?= $dt->format('D') ?></small>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($team)): ?>
          <tr><td colspan="<?= $daysCount + 1 ?>" style="text-align: center; color: var(--color-slate-500); padding: 36px;">No active personnel found for the selected department.</td></tr>
        <?php else: ?>
          <?php foreach ($team as $member): ?>
            <tr>
              <td style="position: sticky; left: 0; background: var(--bg-card); z-index: 1; border-right: 2px solid var(--border-color);">
                <strong style="color: var(--text-main); font-size: 13.5px;"><?= esc($member['first_name'] . ' ' . $member['last_name']) ?></strong>
                <div style="font-size: 11px; color: var(--color-slate-500); margin-top: 1px;">
                  <?= esc($member['employee_code']) ?><?= !empty($member['department_name']) ? ' &bull; ' . esc($member['department_name']) : '' ?>
                </div>
              </td>
              <?php foreach ($dates as $d): 
                $dtObj = new DateTime($d);
                $isWeekend = in_array($dtObj->format('N'), [6, 7]);
                $isToday = ($d === $todayStr);
                $cellStyle = 'text-align: center; vertical-align: middle; padding: 6px 4px;';
                if ($isToday) {
                  $cellStyle .= ' background: rgba(140, 122, 169, 0.08); font-weight: 700;';
                } elseif ($isWeekend) {
                  $cellStyle .= ' background: var(--color-slate-50);';
                }
              ?>
                <td style="<?= $cellStyle ?>">
                  <?php if ($isWeekend): ?>
                    <span style="font-size: 11px; color: var(--color-slate-400); font-weight: 600;">OFF</span>
                  <?php else: 
                    $assignedCode = $shifts[0]['code'] ?? 'SH-GEN';
                    if (!empty($empShiftMap[$member['id']])) {
                      foreach ($empShiftMap[$member['id']] as $al) {
                        $from = $al['from_date'];
                        $to   = $al['to_date'];
                        if ($d >= $from && (empty($to) || $d <= $to)) {
                          $assignedCode = $al['shift_code'];
                          break;
                        }
                      }
                    }
                  ?>
                    <span class="badge badge-success" style="font-size: 11px; padding: 3px 6px;">
                      <?= esc($assignedCode) ?>
                    </span>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function formatDate(d) {
  const year = d.getFullYear();
  const month = String(d.getMonth() + 1).padStart(2, '0');
  const day = String(d.getDate()).padStart(2, '0');
  return year + '-' + month + '-' + day;
}

function onStartDateChange() {
  const startInput = document.getElementById('startDate');
  const endInput = document.getElementById('endDate');
  if (!startInput.value) return;

  // Set min on end date
  endInput.min = startInput.value;
  
  // If end date is earlier than start date, bump it to 30 days or month end
  if (endInput.value && endInput.value < startInput.value) {
    const sDate = new Date(startInput.value);
    const y = sDate.getFullYear();
    const m = sDate.getMonth();
    const lastDayOfMonth = new Date(y, m + 1, 0);
    endInput.value = formatDate(lastDayOfMonth);
  }
}

function setDatePreset(preset) {
  const startInput = document.getElementById('startDate');
  const endInput = document.getElementById('endDate');
  const form = document.getElementById('rosterFilterForm');
  const now = new Date();

  if (preset === 'this-month') {
    const y = now.getFullYear();
    const m = now.getMonth();
    startInput.value = formatDate(new Date(y, m, 1));
    endInput.value = formatDate(new Date(y, m + 1, 0));
  } else if (preset === 'next-month') {
    const y = now.getFullYear();
    const m = now.getMonth() + 1;
    startInput.value = formatDate(new Date(y, m, 1));
    endInput.value = formatDate(new Date(y, m + 1, 0));
  } else if (preset === 'this-week') {
    const day = now.getDay();
    const diffToMonday = now.getDate() - day + (day === 0 ? -6 : 1);
    const monday = new Date(now.getFullYear(), now.getMonth(), diffToMonday);
    const sunday = new Date(monday.getFullYear(), monday.getMonth(), monday.getDate() + 6);
    startInput.value = formatDate(monday);
    endInput.value = formatDate(sunday);
  } else if (preset === '14-days') {
    const start = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const end = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 13);
    startInput.value = formatDate(start);
    endInput.value = formatDate(end);
  } else if (preset === '30-days') {
    const start = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    const end = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 29);
    startInput.value = formatDate(start);
    endInput.value = formatDate(end);
  }

  form.submit();
}

function shiftMonth(offset) {
  const startInput = document.getElementById('startDate');
  const endInput = document.getElementById('endDate');
  const form = document.getElementById('rosterFilterForm');

  let currentStart = new Date(startInput.value || Date.now());
  if (isNaN(currentStart.getTime())) currentStart = new Date();

  let y = currentStart.getFullYear();
  let m = currentStart.getMonth() + offset;

  const newStart = new Date(y, m, 1);
  const newEnd = new Date(y, m + 1, 0);

  startInput.value = formatDate(newStart);
  endInput.value = formatDate(newEnd);
  form.submit();
}
</script>
