<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Confirmation &amp; Probation Management
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Probation timeline tracking, managerial competency appraisal, tenure confirmation, and extension workflows.
    </p>
  </div>
  <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
    <div style="display: flex; gap: 6px;">
      <a href="<?= site_url('probation') ?>" class="badge <?= empty($_GET['status']) ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">All Records</a>
      <a href="<?= site_url('probation?status=due') ?>" class="badge <?= ($_GET['status'] ?? '') === 'due' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">Due for Review</a>
      <a href="<?= site_url('probation?status=under_review') ?>" class="badge <?= ($_GET['status'] ?? '') === 'under_review' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">Under Review</a>
      <a href="<?= site_url('probation?status=confirmed') ?>" class="badge <?= ($_GET['status'] ?? '') === 'confirmed' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">Confirmed</a>
    </div>
    <?php if ($isHR): ?>
      <button type="button" class="btn btn-primary btn-sm" onclick="openEnrollModal()" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; padding: 6px 14px; font-size: 12.5px; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Enroll Employee
      </button>
    <?php endif; ?>
  </div>
</div>

<!-- TOP KPI METRIC CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Confirmation Due</div>
      <div class="stat-value" style="color: #f59e0b;"><?= $dueCount ?></div>
      <div class="stat-subtext">Action required within 15 days</div>
    </div>
    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Under Probation</div>
      <div class="stat-value" style="color: #0ea5e9;"><?= $activeCount ?></div>
      <div class="stat-subtext">Active observation period</div>
    </div>
    <div class="stat-icon" style="background: rgba(14, 165, 233, 0.1); color: #0ea5e9;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Confirmed Full-Time</div>
      <div class="stat-value" style="color: #10b981;"><?= $confirmedCount ?></div>
      <div class="stat-subtext">Successfully confirmed YTD</div>
    </div>
    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Probation Extensions</div>
      <div class="stat-value" style="color: #6366f1;"><?= $extendedCount ?></div>
      <div class="stat-subtext">Extended evaluation terms</div>
    </div>
    <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
    </div>
  </div>
</div>

<!-- PROBATION RECORDS TABLE -->
<div class="card">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <div class="card-title">Employee Probation &amp; Confirmation Roster (<?= count($records) ?>)</div>
      <span style="font-size: 12.5px; color: var(--color-slate-500);">Supervisor evaluations and formal employment transition decisions</span>
    </div>
    <?php if ($isHR): ?>
      <button type="button" class="btn btn-outline btn-sm" onclick="openEnrollModal()" style="display: inline-flex; align-items: center; gap: 5px; font-size: 12px; padding: 5px 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        + Enroll Staff
      </button>
    <?php endif; ?>
  </div>
  <div class="card-body" style="padding: 0;">
    <div class="table-responsive">
      <table class="table" style="margin-bottom: 0;">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Joining Date</th>
            <th>Probation End Date</th>
            <th>Supervisor Appraisal</th>
            <th>Status</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($records)): ?>
            <tr>
              <td colspan="6" style="text-align: center; color: var(--color-slate-500); padding: 48px 24px;">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: #f1f5f9; color: #94a3b8; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px;">
                  <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg>
                </div>
                <div style="font-size: 15px; font-weight: 700; color: var(--color-slate-800); margin-bottom: 5px;">No Employees in Probation Evaluation</div>
                <p style="font-size: 13px; color: var(--color-slate-500); max-width: 440px; margin: 0 auto 16px;">
                  <?= !empty($_GET['status']) ? 'No records match the selected status filter.' : 'All active staff have either been confirmed or are not yet enrolled in probation observation tracking.' ?>
                </p>
                <?php if ($isHR): ?>
                  <button type="button" class="btn btn-primary btn-sm" onclick="openEnrollModal()" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; padding: 7px 16px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Enroll an Employee into Probation
                  </button>
                <?php endif; ?>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($records as $r): ?>
              <tr>
                <td>
                  <strong><?= esc($r['first_name'] . ' ' . $r['last_name']) ?></strong>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($r['employee_code']) ?> &bull; <?= esc($r['designation_name'] ?? 'Associate') ?></div>
                </td>
                <td>
                  <strong><?= date('M j, Y', strtotime($r['joining_date'])) ?></strong>
                </td>
                <td>
                  <strong><?= date('M j, Y', strtotime($r['current_probation_end_date'])) ?></strong>
                  <?php 
                    $daysRemaining = (int)ceil((strtotime($r['current_probation_end_date']) - time()) / 86400);
                  ?>
                  <div style="font-size: 11px; margin-top: 2px;">
                    <?php if ($daysRemaining < 0 && $r['assessment_status'] !== 'confirmed'): ?>
                      <span style="color: #ef4444; font-weight: 700;">Overdue by <?= abs($daysRemaining) ?> days</span>
                    <?php elseif ($daysRemaining <= 15 && $r['assessment_status'] !== 'confirmed'): ?>
                      <span style="color: #f59e0b; font-weight: 700;"><?= $daysRemaining ?> days left</span>
                    <?php else: ?>
                      <span style="color: #64748b;"><?= max(0, $daysRemaining) ?> days remaining</span>
                    <?php endif; ?>
                  </div>
                </td>
                <td>
                  <?php if (!empty($r['manager_rating'])): ?>
                    <div style="font-size: 12.5px;">
                      Rating: <strong><?= esc($r['manager_rating']) ?> / 5</strong>
                      <span class="badge badge-secondary" style="font-size: 10.5px; text-transform: capitalize;"><?= str_replace('_', ' ', $r['manager_recommendation']) ?></span>
                    </div>
                    <?php if (!empty($r['manager_feedback'])): ?>
                      <div style="font-size: 11.5px; color: var(--color-slate-600); margin-top: 2px; font-style: italic; max-width: 280px; white-space: normal;">
                        "<?= esc($r['manager_feedback']) ?>"
                      </div>
                    <?php endif; ?>
                  <?php else: ?>
                    <span style="font-size: 12px; color: var(--color-slate-400);">No appraisal submitted</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($r['assessment_status'] === 'confirmed'): ?>
                    <span class="badge badge-success">Confirmed Full-Time</span>
                  <?php elseif ($r['assessment_status'] === 'due'): ?>
                    <span class="badge badge-warning">Confirmation Due</span>
                  <?php elseif ($r['assessment_status'] === 'extended'): ?>
                    <span class="badge badge-info">Extended (Until <?= date('M j', strtotime($r['extended_until'])) ?>)</span>
                  <?php else: ?>
                    <span class="badge badge-secondary">Under Review</span>
                  <?php endif; ?>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <?php if ($r['assessment_status'] !== 'confirmed'): ?>
                    <button type="button" class="btn btn-outline btn-sm" style="font-size: 11.5px; padding: 4px 8px;" onclick="openAppraisalModal(<?= (int)$r['id'] ?>, '<?= esc($r['first_name'] . ' ' . $r['last_name']) ?>')">
                      Appraise
                    </button>
                    <?php if ($isHR): ?>
                      <button type="button" class="btn btn-primary btn-sm" style="font-size: 11.5px; padding: 4px 8px; background: #10b981; border-color: #10b981;" onclick="openConfirmModal(<?= (int)$r['id'] ?>, '<?= esc($r['first_name'] . ' ' . $r['last_name']) ?>')">
                        Confirm
                      </button>
                      <button type="button" class="btn btn-secondary btn-sm" style="font-size: 11.5px; padding: 4px 8px;" onclick="openExtendModal(<?= (int)$r['id'] ?>, '<?= esc($r['first_name'] . ' ' . $r['last_name']) ?>')">
                        Extend
                      </button>
                    <?php endif; ?>
                  <?php else: ?>
                    <span style="font-size: 11.5px; color: #10b981; font-weight: 700;">Confirmed (<?= date('M Y', strtotime($r['confirmation_date'] ?: $r['updated_at'])) ?>)</span>
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

<!-- MODAL: MANAGER PROBATION APPRAISAL -->
<div id="modalAppraise" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 540px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="card-title">Manager Probation Assessment</div>
      <button type="button" onclick="document.getElementById('modalAppraise').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form id="formAppraise" method="POST">
        <?= csrf_field() ?>
        <div style="padding: 10px; background: #f8fafc; border-radius: 6px; margin-bottom: 16px; font-size: 13px;">
          Evaluating: <strong id="appraiseEmpName">--</strong>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Overall Rating (1 - 5) *</label>
            <select name="manager_rating" class="form-control" required>
              <option value="5">5 - Outstanding Performance</option>
              <option value="4" selected>4 - Exceeds Expectations</option>
              <option value="3">3 - Meets Expectations</option>
              <option value="2">2 - Needs Improvement</option>
              <option value="1">1 - Unsatisfactory</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Technical Competence *</label>
            <select name="technical_competence_rating" class="form-control" required>
              <option value="5">5 - Expert</option>
              <option value="4" selected>4 - Highly Competent</option>
              <option value="3">3 - Capable</option>
              <option value="2">2 - Learning curve</option>
              <option value="1">1 - Deficient</option>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Punctuality &amp; Attendance *</label>
            <select name="punctuality_attendance_rating" class="form-control" required>
              <option value="5">5 - Always on time</option>
              <option value="4" selected>4 - Good punctuality</option>
              <option value="3">3 - Acceptable</option>
              <option value="2">2 - Frequent late arrivals</option>
              <option value="1">1 - Chronic unpunctuality</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Teamwork &amp; Collaboration *</label>
            <select name="teamwork_culture_rating" class="form-control" required>
              <option value="5">5 - Role Model</option>
              <option value="4" selected>4 - Great Team Player</option>
              <option value="3">3 - Cooperative</option>
              <option value="2">2 - Isolated</option>
              <option value="1">1 - Disruptive</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Manager Recommendation *</label>
          <select name="manager_recommendation" class="form-control" required>
            <option value="confirm">Confirm into Regular Full-Time Employment</option>
            <option value="extend_probation">Extend Probation Period (Further Review Needed)</option>
            <option value="terminate">Do Not Confirm (Initiate Separation)</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Detailed Qualitative Feedback *</label>
          <textarea name="manager_feedback" class="form-control" rows="3" placeholder="Provide qualitative review on strengths, key deliverables, and growth areas..." required></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalAppraise').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit Appraisal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: CONFIRM FULL-TIME -->
<div id="modalConfirm" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 460px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="card-title">Confirm Employee Full-Time</div>
      <button type="button" onclick="document.getElementById('modalConfirm').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form id="formConfirm" method="POST">
        <?= csrf_field() ?>
        <p style="font-size: 13.5px; color: var(--color-slate-600); margin-bottom: 16px;">
          You are confirming <strong id="confirmEmpName">--</strong> into regular full-time employment. This will update their corporate status to <strong>Active Full-Time</strong>.
        </p>

        <div class="form-group">
          <label class="form-label">Effective Confirmation Date *</label>
          <input type="date" name="confirmation_date" class="form-control" required value="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
          <label class="form-label">HR Remarks / Endorsement</label>
          <textarea name="hr_remarks" class="form-control" rows="2" placeholder="Confirmed on satisfactory completion of probation term."></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalConfirm').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background: #10b981; border-color: #10b981;">Issue Confirmation</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: EXTEND PROBATION -->
<div id="modalExtend" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 460px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="card-title">Extend Probation Term</div>
      <button type="button" onclick="document.getElementById('modalExtend').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form id="formExtend" method="POST">
        <?= csrf_field() ?>
        <p style="font-size: 13px; color: var(--color-slate-600); margin-bottom: 16px;">
          Extend probation term for <strong id="extendEmpName">--</strong>.
        </p>

        <div class="form-group">
          <label class="form-label">Extension Duration (Months) *</label>
          <select name="extension_months" class="form-control" required>
            <option value="1">1 Month</option>
            <option value="2">2 Months</option>
            <option value="3" selected>3 Months</option>
            <option value="6">6 Months</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Extension Justification *</label>
          <textarea name="extension_reason" class="form-control" rows="2" placeholder="Explain targets and milestones required before next confirmation review..." required></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalExtend').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-warning">Apply Extension</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: ENROLL EMPLOYEE IN PROBATION -->
<div id="modalEnroll" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
  <div class="card" style="width: 100%; max-width: 580px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.4); margin: 0; max-height: 90vh; overflow-y: auto;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
      <div>
        <div class="card-title">Enroll Employee in Probation Evaluation</div>
        <span style="font-size: 12px; color: var(--color-slate-500);">Establish performance tracking, observation duration, and review schedule</span>
      </div>
      <button type="button" onclick="document.getElementById('modalEnroll').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
    </div>
    <div class="card-body">
      <form action="<?= site_url('probation/enroll') ?>" method="POST" id="formEnroll">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label">Select Employee <span style="color: #ef4444;">*</span></label>
          <select name="employee_id" id="enroll_emp_id" class="form-control" required onchange="handleEnrollEmployeeChange()">
            <option value="">-- Choose Employee to Enroll --</option>
            <?php foreach ($activeEmployees as $emp): ?>
              <option value="<?= esc($emp['id']) ?>" 
                      data-joining="<?= esc($emp['joining_date']) ?>" 
                      data-manager="<?= esc($emp['reporting_to']) ?>">
                <?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= esc($emp['employee_code']) ?>) &mdash; <?= esc($emp['designation_name'] ?? 'Associate') ?> [<?= esc($emp['department_name'] ?? 'General') ?>]
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Effective Joining Date <span style="color: #ef4444;">*</span></label>
            <input type="date" name="joining_date" id="enroll_joining_date" class="form-control" required value="<?= date('Y-m-d') ?>" onchange="recalculateProbationEndDate()">
          </div>
          <div class="form-group">
            <label class="form-label">Probation Duration <span style="color: #ef4444;">*</span></label>
            <select name="duration_months" id="enroll_duration_months" class="form-control" required onchange="recalculateProbationEndDate()">
              <option value="1">1 Month</option>
              <option value="2">2 Months</option>
              <option value="3" selected>3 Months (Standard)</option>
              <option value="6">6 Months (Executive/Tech)</option>
              <option value="9">9 Months</option>
              <option value="12">12 Months (1 Year)</option>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label class="form-label">Probation End Date <span style="color: #ef4444;">*</span></label>
            <input type="date" name="probation_end_date" id="enroll_end_date" class="form-control" required value="<?= date('Y-m-d', strtotime('+3 months')) ?>">
            <span style="font-size: 11px; color: var(--color-slate-500);">Auto-calculated from joining date + duration</span>
          </div>
          <div class="form-group">
            <label class="form-label">Initial Assessment Status <span style="color: #ef4444;">*</span></label>
            <select name="assessment_status" id="enroll_status" class="form-control" required>
              <option value="under_review" selected>Under Review (Active Observation)</option>
              <option value="due">Confirmation Due (Immediate Review)</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Assigned Supervisor / Manager</label>
          <select name="manager_id" id="enroll_manager_id" class="form-control">
            <option value="">-- Direct Executive / Auto Assign --</option>
            <?php foreach ($managers as $mgr): ?>
              <option value="<?= esc($mgr['id']) ?>">
                <?= esc($mgr['first_name'] . ' ' . $mgr['last_name']) ?> (<?= esc($mgr['employee_code']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Evaluation Goals &amp; Objectives</label>
          <textarea name="notes" class="form-control" rows="2" placeholder="Outline initial probation key deliverables, performance metrics, and evaluation expectations..."></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
          <button type="button" class="btn btn-outline" onclick="document.getElementById('modalEnroll').style.display='none';">Cancel</button>
          <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            Save &amp; Enroll Employee
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openEnrollModal() {
  document.getElementById('modalEnroll').style.display = 'flex';
}

function handleEnrollEmployeeChange() {
  const select = document.getElementById('enroll_emp_id');
  const selectedOption = select.options[select.selectedIndex];
  if (!selectedOption || !selectedOption.value) return;

  const joining = selectedOption.getAttribute('data-joining');
  const manager = selectedOption.getAttribute('data-manager');

  if (joining) {
    document.getElementById('enroll_joining_date').value = joining;
  }
  if (manager) {
    document.getElementById('enroll_manager_id').value = manager;
  }
  recalculateProbationEndDate();
}

function recalculateProbationEndDate() {
  const joinDateVal = document.getElementById('enroll_joining_date').value;
  const monthsVal = parseInt(document.getElementById('enroll_duration_months').value, 10);
  if (!joinDateVal || isNaN(monthsVal)) return;

  const joinDate = new Date(joinDateVal + 'T00:00:00');
  joinDate.setMonth(joinDate.getMonth() + monthsVal);

  const yyyy = joinDate.getFullYear();
  const mm = String(joinDate.getMonth() + 1).padStart(2, '0');
  const dd = String(joinDate.getDate()).padStart(2, '0');
  document.getElementById('enroll_end_date').value = `${yyyy}-${mm}-${dd}`;
}

function openAppraisalModal(id, empName) {
  document.getElementById('appraiseEmpName').textContent = empName;
  document.getElementById('formAppraise').action = '<?= site_url('probation/assess/') ?>' + id;
  document.getElementById('modalAppraise').style.display = 'flex';
}

function openConfirmModal(id, empName) {
  document.getElementById('confirmEmpName').textContent = empName;
  document.getElementById('formConfirm').action = '<?= site_url('probation/confirm/') ?>' + id;
  document.getElementById('modalConfirm').style.display = 'flex';
}

function openExtendModal(id, empName) {
  document.getElementById('extendEmpName').textContent = empName;
  document.getElementById('formExtend').action = '<?= site_url('probation/extend/') ?>' + id;
  document.getElementById('modalExtend').style.display = 'flex';
}
</script>
