<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Training Programs, Calendar &amp; Skills Matrix
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Corporate learning catalog, employee nominations, attendance roll-calls, certification credentials, and skill records.
    </p>
  </div>
  <div style="display: flex; gap: 10px; flex-wrap: wrap;">
    <button type="button" class="btn btn-secondary" onclick="openNominateModal()">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
      Nominate Staff
    </button>
    <?php if ($isHR): ?>
      <button type="button" class="btn btn-primary" onclick="document.getElementById('modalAddTraining').style.display='flex'">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Schedule Training
      </button>
    <?php endif; ?>
  </div>
</div>

<!-- Tabs Navigation -->
<div style="display: flex; border-bottom: 2px solid var(--color-slate-200); margin-bottom: 24px; gap: 20px;">
  <button type="button" onclick="switchTrainingTab('tabPrograms')" id="btnTabPrograms" class="training-tab-btn active-tab" style="padding: 10px 4px; font-weight: 700; font-size: 14px; border: none; background: none; cursor: pointer; border-bottom: 2px solid var(--color-primary); margin-bottom: -2px; color: var(--color-primary);">
    Training Programs (<?= count($trainings) ?>)
  </button>
  <button type="button" onclick="switchTrainingTab('tabParticipants')" id="btnTabParticipants" class="training-tab-btn" style="padding: 10px 4px; font-weight: 600; font-size: 14px; border: none; background: none; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; color: var(--color-slate-500);">
    Attendance &amp; Certification Roll-Call
  </button>
  <button type="button" onclick="switchTrainingTab('tabMyEnrollments')" id="btnTabMyEnrollments" class="training-tab-btn" style="padding: 10px 4px; font-weight: 600; font-size: 14px; border: none; background: none; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; color: var(--color-slate-500);">
    My Courses &amp; Credentials (<?= count($myEnrollments) ?>)
  </button>
  <button type="button" onclick="switchTrainingTab('tabSkills')" id="btnTabSkills" class="training-tab-btn" style="padding: 10px 4px; font-weight: 600; font-size: 14px; border: none; background: none; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; color: var(--color-slate-500);">
    My Acquired Skills (<?= count($mySkills) ?>)
  </button>
</div>

<!-- TAB 1: PROGRAMS CATALOG -->
<div id="tabPrograms" class="training-tab-content">
  <div class="grid-3" style="margin-bottom: 24px;">
    <?php if (empty($trainings)): ?>
      <div class="card" style="grid-column: span 3; text-align: center; color: var(--color-slate-500); padding: 40px;">
        No training sessions scheduled yet. Click 'Schedule Training' to create a course catalog.
      </div>
    <?php else: ?>
      <?php foreach ($trainings as $t): ?>
        <?php 
          $pctFilled = ($t['max_participants'] > 0) ? min(100, round(($t['enrolled_count'] / $t['max_participants']) * 100)) : 0;
        ?>
        <div class="card" style="border-top: 3px solid var(--color-primary); display: flex; flex-direction: column; justify-content: space-between;">
          <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
              <span class="badge badge-info" style="font-size: 11px; text-transform: uppercase;">
                <?= esc($t['category']) ?>
              </span>
              <span class="badge <?= ($t['status'] === 'scheduled') ? 'badge-primary' : 'badge-success' ?>"><?= esc(ucfirst($t['status'])) ?></span>
            </div>

            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px; color: var(--color-slate-900);"><?= esc($t['title']) ?></h3>
            <div style="font-size: 12px; color: var(--color-slate-500); margin-bottom: 12px;">
              Course Code: <strong style="color: var(--color-slate-800);"><?= esc($t['course_code']) ?></strong>
            </div>

            <div style="background: var(--color-slate-50); padding: 10px 12px; border-radius: 6px; font-size: 12.5px; margin-bottom: 14px; border: 1px solid var(--color-slate-100);">
              <div style="margin-bottom: 4px; display: flex; justify-content: space-between;">
                <span style="color: var(--color-slate-500);">Trainer:</span>
                <strong><?= esc($t['trainer_name'] ?? 'Corporate Trainer') ?></strong>
              </div>
              <div style="margin-bottom: 4px; display: flex; justify-content: space-between;">
                <span style="color: var(--color-slate-500);">Duration:</span>
                <strong><?= esc($t['total_hours']) ?> hrs &bull; <?= esc(ucfirst($t['training_type'])) ?></strong>
              </div>
              <div style="margin-bottom: 4px; display: flex; justify-content: space-between;">
                <span style="color: var(--color-slate-500);">Venue:</span>
                <strong><?= esc($t['location'] ?? 'Online / Main Hall') ?></strong>
              </div>
              <div style="display: flex; justify-content: space-between;">
                <span style="color: var(--color-slate-500);">Dates:</span>
                <strong><?= date('M j', strtotime($t['start_date'])) ?> &ndash; <?= date('M j, Y', strtotime($t['end_date'])) ?></strong>
              </div>
            </div>

            <div style="font-size: 12.5px; color: var(--color-slate-600); margin-bottom: 14px; line-height: 1.5;">
              <?= esc(substr($t['description'] ?? 'Comprehensive enterprise skill building session.', 0, 95)) ?>...
            </div>

            <!-- Enrollment Capacity Progress Bar -->
            <div style="margin-bottom: 16px;">
              <div style="display: flex; justify-content: space-between; font-size: 11.5px; font-weight: 600; margin-bottom: 4px;">
                <span style="color: var(--color-slate-500);">Enrollment Capacity</span>
                <span style="color: var(--color-primary);"><?= $t['enrolled_count'] ?> / <?= $t['max_participants'] ?> (<?= $pctFilled ?>%)</span>
              </div>
              <div style="width: 100%; height: 6px; background: var(--color-slate-200); border-radius: 9999px; overflow: hidden;">
                <div style="width: <?= $pctFilled ?>%; height: 100%; background: <?= ($pctFilled >= 100) ? 'var(--color-danger)' : 'var(--color-primary)' ?>;"></div>
              </div>
            </div>
          </div>

          <button type="button" class="btn btn-secondary btn-sm" style="width: 100%; justify-content: center;" onclick="openNominateModal(<?= $t['id'] ?>)">
            Nominate Staff
          </button>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<!-- TAB 2: PARTICIPANTS & ATTENDANCE ROLL-CALL -->
<div id="tabParticipants" class="training-tab-content" style="display: none;">
  <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
    <div style="padding: 16px 20px; background: var(--color-slate-50); border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
      <div>
        <h3 style="font-size: 15px; font-weight: 700; color: var(--color-slate-800);">Participant Roster, Roll-Call &amp; Certification Assessments</h3>
        <p style="font-size: 12.5px; color: var(--color-slate-500);">Evaluate trainee attendance percentages, assign completion ratings, and award certified skills.</p>
      </div>
    </div>
    
    <div style="overflow-x: auto;">
      <table class="table" style="width: 100%; font-size: 13px;">
        <thead>
          <tr>
            <th>Training Program</th>
            <th>Employee</th>
            <th>Department</th>
            <th>Attendance Status</th>
            <th>Attendance %</th>
            <th>Score &amp; Status</th>
            <th>Credential</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $hasParticipants = false;
            foreach ($trainings as $tr): 
              foreach ($tr['participants'] as $p):
                $hasParticipants = true;
          ?>
            <tr>
              <td>
                <div style="font-weight: 700; color: var(--color-slate-800);"><?= esc($tr['title']) ?></div>
                <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($tr['course_code']) ?> &bull; <?= date('M d', strtotime($tr['start_date'])) ?></div>
              </td>
              <td>
                <div style="font-weight: 600; color: var(--color-slate-900);"><?= esc($p['first_name'] . ' ' . $p['last_name']) ?></div>
                <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($p['employee_code']) ?></div>
              </td>
              <td>
                <span class="badge badge-secondary"><?= esc($p['department_name'] ?? 'General') ?></span>
              </td>
              <td>
                <?php 
                  $statusBadges = [
                    'nominated' => 'badge-info',
                    'attended'  => 'badge-success',
                    'absent'    => 'badge-danger',
                    'dropped'   => 'badge-warning',
                  ];
                ?>
                <span class="badge <?= $statusBadges[$p['nomination_status']] ?? 'badge-secondary' ?>">
                  <?= esc(ucfirst($p['nomination_status'])) ?>
                </span>
              </td>
              <td>
                <div style="font-weight: 700; color: <?= ($p['attendance_percent'] >= 75) ? 'var(--color-success)' : 'var(--color-danger)' ?>;">
                  <?= number_format($p['attendance_percent'], 1) ?>%
                </div>
              </td>
              <td>
                <?php if ($p['completion_status'] === 'completed'): ?>
                  <span class="badge badge-success">Completed (<?= esc($p['score_rating'] ?? 90) ?>%)</span>
                <?php elseif ($p['completion_status'] === 'failed'): ?>
                  <span class="badge badge-danger">Failed</span>
                <?php else: ?>
                  <span class="badge badge-warning">In Progress</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($p['completion_status'] === 'completed'): ?>
                  <a href="<?= site_url('training/certificate/' . $p['id']) ?>" target="_blank" class="btn btn-secondary btn-sm" style="padding: 3px 8px; font-size: 11.5px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Certificate
                  </a>
                <?php else: ?>
                  <span style="color: var(--color-slate-400); font-size: 12px;">Pending</span>
                <?php endif; ?>
              </td>
              <td style="text-align: right;">
                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                  <button type="button" class="btn btn-secondary btn-sm" onclick='openAttendanceModal(<?= json_encode($p) ?>, <?= json_encode($tr['title']) ?>)'>
                    Roll-Call
                  </button>
                  <button type="button" class="btn btn-primary btn-sm" onclick='openCompleteModal(<?= json_encode($p) ?>, <?= json_encode($tr['title']) ?>)'>
                    Certify
                  </button>
                </div>
              </td>
            </tr>
          <?php 
              endforeach; 
            endforeach; 
          ?>
          <?php if (!$hasParticipants): ?>
            <tr>
              <td colspan="8" style="text-align: center; color: var(--color-slate-500); padding: 32px;">
                No employees enrolled in training programs yet. Click 'Nominate Staff' above to enroll participants.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- TAB 3: MY COURSES & CREDENTIALS -->
<div id="tabMyEnrollments" class="training-tab-content" style="display: none;">
  <div class="card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
    <div style="padding: 16px 20px; background: var(--color-slate-50); border-bottom: 1px solid var(--color-slate-200);">
      <h3 style="font-size: 15px; font-weight: 700; color: var(--color-slate-800);">My Learning Journey &amp; Certificates</h3>
      <p style="font-size: 12.5px; color: var(--color-slate-500);">Courses you are enrolled in, attendance records, final ratings, and verified completion credentials.</p>
    </div>

    <div style="overflow-x: auto;">
      <table class="table" style="width: 100%; font-size: 13px;">
        <thead>
          <tr>
            <th>Course Name</th>
            <th>Category &amp; Trainer</th>
            <th>Schedule</th>
            <th>Attendance %</th>
            <th>Status</th>
            <th>Assessment Score</th>
            <th style="text-align: right;">Official Credential</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($myEnrollments)): ?>
            <tr>
              <td colspan="7" style="text-align: center; color: var(--color-slate-500); padding: 32px;">
                You are currently not enrolled in any training program.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($myEnrollments as $me): ?>
              <tr>
                <td>
                  <div style="font-weight: 700; color: var(--color-slate-800);"><?= esc($me['course_title']) ?></div>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($me['course_code']) ?></div>
                </td>
                <td>
                  <div><?= esc($me['category']) ?></div>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($me['trainer_name'] ?? 'Instructor') ?></div>
                </td>
                <td>
                  <div><?= date('M j, Y', strtotime($me['start_date'])) ?></div>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($me['total_hours']) ?> Total Hours</div>
                </td>
                <td>
                  <span style="font-weight: 700;"><?= number_format($me['attendance_percent'] ?? 0, 1) ?>%</span>
                </td>
                <td>
                  <?php if ($me['completion_status'] === 'completed'): ?>
                    <span class="badge badge-success">Completed</span>
                  <?php elseif ($me['completion_status'] === 'failed'): ?>
                    <span class="badge badge-danger">Not Cleared</span>
                  <?php else: ?>
                    <span class="badge badge-warning">In Progress</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?= $me['score_rating'] ? esc($me['score_rating']) . '%' : '<span style="color:var(--color-slate-400)">Pending</span>' ?>
                </td>
                <td style="text-align: right;">
                  <?php if ($me['completion_status'] === 'completed'): ?>
                    <a href="<?= site_url('training/certificate/' . $me['participant_id']) ?>" target="_blank" class="btn btn-primary btn-sm">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                      Download Certificate
                    </a>
                  <?php else: ?>
                    <span style="color: var(--color-slate-400); font-size: 12px;">Available upon completion</span>
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

<!-- TAB 4: SKILL MATRIX -->
<div id="tabSkills" class="training-tab-content" style="display: none;">
  <div class="card" style="margin-bottom: 24px;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px; color: var(--color-slate-900);">My Verified Competencies &amp; Skills</h3>
    <p style="font-size: 13px; color: var(--color-slate-500); margin-bottom: 20px;">Skills certified and accredited through internal training assessments.</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
      <?php if (empty($mySkills)): ?>
        <div style="grid-column: 1/-1; text-align: center; color: var(--color-slate-500); padding: 30px;">
          No certified skills logged yet. Successfully clear training programs to earn badges.
        </div>
      <?php else: ?>
        <?php foreach ($mySkills as $sk): ?>
          <div style="padding: 16px; border-radius: 8px; border: 1px solid var(--color-slate-200); background: var(--color-slate-50);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
              <span style="font-weight: 700; font-size: 14.5px; color: var(--color-slate-900);"><?= esc($sk['skill_name']) ?></span>
              <span class="badge badge-success"><?= esc(ucfirst($sk['proficiency_level'])) ?></span>
            </div>
            <div style="font-size: 12px; color: var(--color-slate-500);">
              Verified through Enterprise Academy &bull; Active
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- MODAL: SCHEDULE TRAINING -->
<div id="modalAddTraining" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 540px; max-width: 90vw; max-height: 90vh; overflow-y: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Schedule Training Program</h3>
      <button type="button" onclick="document.getElementById('modalAddTraining').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('training/store') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Program Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Advanced Cybersecurity &amp; Incident Response" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Category *</label>
          <input type="text" name="category" class="form-control" placeholder="e.g. Information Technology" required>
        </div>
        <div class="form-group">
          <label class="form-label">Trainer Name</label>
          <input type="text" name="trainer_name" class="form-control" placeholder="e.g. Lead Engineer / Specialist">
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Start Date *</label>
          <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">End Date *</label>
          <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+3 days')) ?>" required>
        </div>
      </div>

      <div class="grid-3" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Type</label>
          <select name="training_type" class="form-control">
            <option value="internal">Internal</option>
            <option value="external">External</option>
            <option value="online">Virtual / Online</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Duration (Hrs)</label>
          <input type="number" step="0.5" name="total_hours" class="form-control" value="8">
        </div>
        <div class="form-group">
          <label class="form-label">Capacity (Max)</label>
          <input type="number" name="max_participants" class="form-control" value="30">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Location / Training Room</label>
        <input type="text" name="location" class="form-control" value="Training Room A &amp; Zoom Virtual Link">
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Description &amp; Syllabus</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Learning objectives, course prerequisites, and certification criteria"></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddTraining').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Schedule Session</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: NOMINATE EMPLOYEE -->
<div id="modalNominate" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 500px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Nominate Employee for Training</h3>
      <button type="button" onclick="document.getElementById('modalNominate').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('training/nominate') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Select Training Program *</label>
        <select name="training_id" id="nominate_training_id" class="form-control" required>
          <?php foreach ($trainings as $tr): ?>
            <option value="<?= $tr['id'] ?>"><?= esc($tr['title']) ?> (<?= esc($tr['course_code']) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Select Employee *</label>
        <select name="employee_id" class="form-control" required>
          <option value="">-- Choose Employee --</option>
          <?php foreach ($employees as $emp): ?>
            <option value="<?= $emp['id'] ?>">
              <?= esc($emp['employee_code']) ?> &ndash; <?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalNominate').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Enroll Participant</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: MARK ATTENDANCE (ROLL-CALL) -->
<div id="modalAttendance" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 480px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
      <h3 style="font-size: 18px; font-weight: 700;">Record Attendance Roll-Call</h3>
      <button type="button" onclick="document.getElementById('modalAttendance').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <div style="margin-bottom: 16px; padding: 10px; background: var(--color-slate-50); border-radius: 6px; font-size: 13px;">
      <div>Program: <strong id="att_course_title"></strong></div>
      <div>Participant: <strong id="att_participant_name"></strong></div>
    </div>

    <form action="<?= site_url('training/attendance') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="participant_id" id="att_participant_id">

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Attendance Status *</label>
        <select name="nomination_status" id="att_status" class="form-control" required>
          <option value="attended">Attended (Present)</option>
          <option value="absent">Absent</option>
          <option value="dropped">Dropped / Incomplete</option>
          <option value="nominated">Nominated / Enrolled</option>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Attendance Percentage (%) *</label>
        <input type="number" step="1" min="0" max="100" name="attendance_percent" id="att_percent" class="form-control" required>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAttendance').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Attendance</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: CERTIFY & COMPLETE TRAINING -->
<div id="modalComplete" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 520px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
      <h3 style="font-size: 18px; font-weight: 700;">Certify Training &amp; Award Skill</h3>
      <button type="button" onclick="document.getElementById('modalComplete').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <div style="margin-bottom: 16px; padding: 10px; background: var(--color-slate-50); border-radius: 6px; font-size: 13px;">
      <div>Program: <strong id="comp_course_title"></strong></div>
      <div>Trainee: <strong id="comp_participant_name"></strong></div>
    </div>

    <form action="<?= site_url('training/complete') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="participant_id" id="comp_participant_id">

      <div class="grid-2" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Completion Status *</label>
          <select name="completion_status" id="comp_status" class="form-control" required>
            <option value="completed">Completed (Passed)</option>
            <option value="failed">Failed / Not Cleared</option>
            <option value="in_progress">In Progress</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Score / Rating (0-100%) *</label>
          <input type="number" step="0.5" min="0" max="100" name="score_rating" id="comp_score" class="form-control" value="90" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Auto-Award Skill to Employee Profile</label>
        <input type="text" name="skill_name" class="form-control" placeholder="e.g. Cloud Architecture, Docker &amp; Kubernetes">
        <div style="font-size: 11.5px; color: var(--color-slate-500); margin-top: 3px;">
          If provided, this skill badge will be permanently added to the employee's skill development matrix.
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Trainer Evaluation &amp; Feedback</label>
        <textarea name="feedback" id="comp_feedback" class="form-control" rows="2" placeholder="Exceptional grasp of practical exercises and teamwork."></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalComplete').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Issue Official Certificate</button>
      </div>
    </form>
  </div>
</div>

<script>
function switchTrainingTab(tabId) {
  document.querySelectorAll('.training-tab-content').forEach(el => el.style.display = 'none');
  document.querySelectorAll('.training-tab-btn').forEach(btn => {
    btn.style.color = 'var(--color-slate-500)';
    btn.style.borderBottomColor = 'transparent';
    btn.style.fontWeight = '600';
  });

  const activeContent = document.getElementById(tabId);
  if (activeContent) activeContent.style.display = 'block';

  let activeBtnId = 'btnTabPrograms';
  if (tabId === 'tabParticipants') activeBtnId = 'btnTabParticipants';
  if (tabId === 'tabMyEnrollments') activeBtnId = 'btnTabMyEnrollments';
  if (tabId === 'tabSkills') activeBtnId = 'btnTabSkills';

  const activeBtn = document.getElementById(activeBtnId);
  if (activeBtn) {
    activeBtn.style.color = 'var(--color-primary)';
    activeBtn.style.borderBottomColor = 'var(--color-primary)';
    activeBtn.style.fontWeight = '700';
  }
}

function openNominateModal(trainingId = null) {
  if (trainingId) {
    document.getElementById('nominate_training_id').value = trainingId;
  }
  document.getElementById('modalNominate').style.display = 'flex';
}

function openAttendanceModal(p, title) {
  document.getElementById('att_participant_id').value = p.id;
  document.getElementById('att_course_title').textContent = title;
  document.getElementById('att_participant_name').textContent = p.first_name + ' ' + p.last_name + ' (' + p.employee_code + ')';
  document.getElementById('att_status').value = p.nomination_status || 'attended';
  document.getElementById('att_percent').value = p.attendance_percent || 100;
  document.getElementById('modalAttendance').style.display = 'flex';
}

function openCompleteModal(p, title) {
  document.getElementById('comp_participant_id').value = p.id;
  document.getElementById('comp_course_title').textContent = title;
  document.getElementById('comp_participant_name').textContent = p.first_name + ' ' + p.last_name + ' (' + p.employee_code + ')';
  document.getElementById('comp_status').value = p.completion_status || 'completed';
  document.getElementById('comp_score').value = p.score_rating || 90;
  document.getElementById('comp_feedback').value = p.feedback || '';
  document.getElementById('modalComplete').style.display = 'flex';
}
</script>
