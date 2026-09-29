<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Recruitment &amp; Applicant Pipeline</h2>
    <p style="color: #64748b; font-size: 14px; margin: 0;">Manage job requisitions, track candidates across stages, and 1-click onboard hires into the employee master.</p>
  </div>
  <div style="display: flex; gap: 12px;">
    <button class="btn btn-outline" onclick="document.getElementById('modalAddJob').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Post Job Opening
    </button>
    <button class="btn btn-primary" onclick="document.getElementById('modalAddCandidate').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
      Add Candidate
    </button>
  </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid" style="margin-bottom: 28px;">
  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Active Openings</span>
      <div class="kpi-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($totalOpenings) ?></div>
    <div class="kpi-subtitle">Across <?= count($departments) ?> departments</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Total Applicants</span>
      <div class="kpi-icon" style="background: rgba(14,165,233,0.1); color: #0ea5e9;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($totalCandidates) ?></div>
    <div class="kpi-subtitle">Active talent pool</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">In Evaluation</span>
      <div class="kpi-icon" style="background: rgba(245,158,11,0.1); color: #d97706;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($interviews) ?></div>
    <div class="kpi-subtitle">Interview rounds active</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Offered / Hired</span>
      <div class="kpi-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($offeredOrHired) ?></div>
    <div class="kpi-subtitle">Successful conversions</div>
  </div>
</div>

<!-- TABS: Pipeline Kanban vs Job Openings List -->
<div class="card" style="margin-bottom: 24px;">
  <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
    <div class="tabs-nav" style="margin-bottom: 0;">
      <button class="tab-btn active" onclick="switchRecTab('kanban', this)">Candidate Pipeline Board</button>
      <button class="tab-btn" onclick="switchRecTab('jobs', this)">Job Requisitions (<?= count($jobs) ?>)</button>
    </div>
  </div>

  <!-- TAB 1: KANBAN PIPELINE -->
  <div id="tab-kanban" class="tab-pane active" style="padding: 20px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; align-items: start;">
      <?php
      $stagesMeta = [
        'applied'   => ['title' => 'Applied', 'color' => '#64748b', 'bg' => '#f1f5f9'],
        'screening' => ['title' => 'Screening', 'color' => '#0284c7', 'bg' => '#e0f2fe'],
        'interview' => ['title' => 'Interview', 'color' => '#d97706', 'bg' => '#fef3c7'],
        'offered'   => ['title' => 'Offered', 'color' => '#7c3aed', 'bg' => '#f3e8ff'],
        'hired'     => ['title' => 'Hired / Converted', 'color' => '#16a34a', 'bg' => '#dcfce7'],
        'rejected'  => ['title' => 'Rejected', 'color' => '#dc2626', 'bg' => '#fee2e2'],
      ];
      ?>

      <?php foreach ($stagesMeta as $sKey => $sInfo): ?>
        <div style="background: <?= $sInfo['bg'] ?>; border-radius: 10px; padding: 14px; border: 1px solid rgba(0,0,0,0.05); min-height: 480px;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <div style="font-weight: 700; color: <?= $sInfo['color'] ?>; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
              <?= $sInfo['title'] ?>
            </div>
            <span style="background: #fff; color: <?= $sInfo['color'] ?>; font-weight: 700; font-size: 11px; padding: 2px 8px; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.06);">
              <?= count($pipeline[$sKey]) ?>
            </span>
          </div>

          <div style="display: flex; flex-direction: column; gap: 12px;">
            <?php if (empty($pipeline[$sKey])): ?>
              <div style="text-align: center; color: #94a3b8; font-size: 12px; padding: 20px 0;">No candidates in this stage</div>
            <?php else: ?>
              <?php foreach ($pipeline[$sKey] as $cand): ?>
                <div style="background: #ffffff; border-radius: 8px; padding: 14px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #e2e8f0;">
                  <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                    <div style="font-weight: 700; font-size: 14px; color: #0f172a;"><?= esc($cand['full_name']) ?></div>
                    <span style="font-size: 10px; font-weight: 600; color: #64748b; background: #f8fafc; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                      <?= esc($cand['candidate_code']) ?>
                    </span>
                  </div>

                  <div style="font-size: 12px; color: #2563eb; font-weight: 600; margin-bottom: 6px;">
                    <?= esc($cand['job_title'] ?? 'Job Posting') ?>
                  </div>

                  <div style="font-size: 12px; color: #64748b; margin-bottom: 8px; display: flex; flex-direction: column; gap: 2px;">
                    <span>📧 <?= esc($cand['email']) ?></span>
                    <span>📞 <?= esc($cand['phone'] ?? 'N/A') ?> &bull; 💼 <?= esc($cand['experience_years']) ?> yrs exp</span>
                    <?php if (!empty($cand['expected_ctc'])): ?>
                      <span>💰 Expected: ₹<?= number_format((float)$cand['expected_ctc'], 0) ?></span>
                    <?php endif; ?>
                  </div>

                  <?php if (!empty($cand['scorecard_rating'])): ?>
                    <div style="margin-bottom: 8px; font-size: 11px; color: #d97706; font-weight: 700;">
                      Scorecard: <?= str_repeat('★', (int)$cand['scorecard_rating']) . str_repeat('☆', 5 - (int)$cand['scorecard_rating']) ?>
                    </div>
                  <?php endif; ?>

                  <?php if (!empty($cand['interviewer_feedback'])): ?>
                    <div style="font-size: 11px; background: #f8fafc; padding: 6px 8px; border-radius: 4px; color: #475569; margin-bottom: 10px; font-style: italic;">
                      "<?= esc($cand['interviewer_feedback']) ?>"
                    </div>
                  <?php endif; ?>

                  <!-- ACTION BUTTONS -->
                  <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-top: 10px; pt-2; border-top: 1px solid #f1f5f9;">
                    <!-- Update Stage Trigger -->
                    <button class="btn btn-outline btn-sm" style="font-size: 11px; padding: 4px 8px;" onclick="openUpdateStageModal(<?= htmlspecialchars(json_encode($cand)) ?>)">
                      Update Stage
                    </button>

                    <!-- 1-Click Convert to Employee Button -->
                    <?php if (in_array($cand['stage'], ['offered', 'hired']) && empty($cand['hired_as_employee_id'])): ?>
                      <form action="<?= site_url('recruitment/convert/' . $cand['id']) ?>" method="POST" onsubmit="return confirm('Hire this candidate and automatically provision an Employee Master Profile, User Login, and Leave Balances?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary btn-sm" style="font-size: 11px; padding: 4px 8px; background: #16a34a; border-color: #16a34a;">
                          ✨ Hire as Employee
                        </button>
                      </form>
                    <?php elseif (!empty($cand['hired_as_employee_id'])): ?>
                      <a href="<?= site_url('employees/view/' . $cand['hired_as_employee_id']) ?>" class="btn btn-sm" style="font-size: 11px; padding: 4px 8px; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; text-decoration: none;">
                        ✓ View Emp #<?= esc($cand['converted_emp_code']) ?>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- TAB 2: JOB OPENINGS LIST -->
  <div id="tab-jobs" class="tab-pane" style="display: none; padding: 20px;">
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Job Code</th>
            <th>Role Title</th>
            <th>Department</th>
            <th>Type</th>
            <th>Vacancies</th>
            <th>Exp. Required</th>
            <th>Salary Range</th>
            <th>Applicants</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($jobs as $j): ?>
            <tr>
              <td><strong><?= esc($j['job_code']) ?></strong></td>
              <td>
                <div style="font-weight: 700; color: #0f172a;"><?= esc($j['title']) ?></div>
                <div style="font-size: 12px; color: #64748b;"><?= esc($j['location']) ?></div>
              </td>
              <td><?= esc($j['department_name'] ?? 'General') ?></td>
              <td><span class="badge" style="background: #f1f5f9; color: #475569;"><?= esc(ucwords(str_replace('_', ' ', $j['job_type']))) ?></span></td>
              <td><?= esc($j['vacancies']) ?></td>
              <td><?= esc($j['experience_required']) ?></td>
              <td>₹<?= number_format((float)$j['min_salary'], 0) ?> - ₹<?= number_format((float)$j['max_salary'], 0) ?></td>
              <td>
                <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700;">
                  <?= esc($j['total_applicants']) ?> applicants
                </span>
                <?php if ($j['hired_count'] > 0): ?>
                  <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 700;">
                    <?= esc($j['hired_count']) ?> hired
                  </span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($j['status'] === 'open'): ?>
                  <span class="badge badge-success">Open</span>
                <?php elseif ($j['status'] === 'closed'): ?>
                  <span class="badge badge-danger">Closed</span>
                <?php else: ?>
                  <span class="badge badge-warning">On Hold</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL: ADD JOB REQUISITION -->
<div id="modalAddJob" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 600px;">
    <div class="modal-header">
      <h3 class="modal-title">Post New Job Requisition</h3>
      <button class="modal-close" onclick="document.getElementById('modalAddJob').style.display='none'">&times;</button>
    </div>
    <form action="<?= site_url('recruitment/jobs/store') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div class="form-group">
          <label class="form-label">Job Title *</label>
          <input type="text" name="title" class="form-control" required placeholder="e.g. Senior Backend Engineer">
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Department *</label>
            <select name="department_id" class="form-control" required>
              <option value="">Select Department</option>
              <?php foreach ($departments as $d): ?>
                <option value="<?= $d['id'] ?>"><?= esc($d['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Employment Type</label>
            <select name="job_type" class="form-control">
              <option value="full_time">Full-time</option>
              <option value="part_time">Part-time</option>
              <option value="contract">Contract</option>
              <option value="remote">Remote</option>
            </select>
          </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Vacancies</label>
            <input type="number" name="vacancies" class="form-control" value="1" min="1">
          </div>
          <div class="form-group">
            <label class="form-label">Experience Required</label>
            <input type="text" name="experience_required" class="form-control" placeholder="e.g. 3-5 years">
          </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Min Annual Salary (₹)</label>
            <input type="number" step="1000" name="min_salary" class="form-control" placeholder="60000">
          </div>
          <div class="form-group">
            <label class="form-label">Max Annual Salary (₹)</label>
            <input type="number" step="1000" name="max_salary" class="form-control" placeholder="90000">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Job Description &amp; Scope</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Key responsibilities and qualifications..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalAddJob').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Create Requisition</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: ADD CANDIDATE APPLICATION -->
<div id="modalAddCandidate" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 600px;">
    <div class="modal-header">
      <h3 class="modal-title">Add Candidate to Pipeline</h3>
      <button class="modal-close" onclick="document.getElementById('modalAddCandidate').style.display='none'">&times;</button>
    </div>
    <form action="<?= site_url('recruitment/candidates/store') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div class="form-group">
          <label class="form-label">Target Job Opening *</label>
          <select name="job_opening_id" class="form-control" required>
            <option value="">Select Job Opening</option>
            <?php foreach ($jobs as $j): ?>
              <option value="<?= $j['id'] ?>"><?= esc($j['title']) ?> (<?= esc($j['job_code']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Candidate Full Name *</label>
          <input type="text" name="full_name" class="form-control" required placeholder="e.g. Sarah Jenkins">
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Email Address *</label>
            <input type="email" name="email" class="form-control" required placeholder="sarah@example.com">
          </div>
          <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="+1-555-0123">
          </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Experience (Years)</label>
            <input type="number" step="0.5" name="experience_years" class="form-control" placeholder="4.5">
          </div>
          <div class="form-group">
            <label class="form-label">Current Company</label>
            <input type="text" name="current_company" class="form-control" placeholder="Acme Inc">
          </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Current CTC (₹)</label>
            <input type="number" name="current_ctc" class="form-control" placeholder="75000">
          </div>
          <div class="form-group">
            <label class="form-label">Expected CTC (₹)</label>
            <input type="number" name="expected_ctc" class="form-control" placeholder="95000">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Initial Stage</label>
          <select name="stage" class="form-control">
            <option value="applied">Applied</option>
            <option value="screening">Screening</option>
            <option value="interview">Interview</option>
            <option value="offered">Offered</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalAddCandidate').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Candidate</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: UPDATE CANDIDATE STAGE -->
<div id="modalUpdateStage" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h3 class="modal-title">Evaluate &amp; Move Stage</h3>
      <button class="modal-close" onclick="document.getElementById('modalUpdateStage').style.display='none'">&times;</button>
    </div>
    <form id="formUpdateStage" action="" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div id="updateCandSummary" style="background: #f8fafc; padding: 10px; border-radius: 6px; font-weight: 600; color: #1e293b;"></div>

        <div class="form-group">
          <label class="form-label">Pipeline Stage *</label>
          <select name="stage" id="updateStageSelect" class="form-control" required>
            <option value="applied">Applied</option>
            <option value="screening">Screening</option>
            <option value="interview">Interview</option>
            <option value="offered">Offered</option>
            <option value="hired">Hired</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Scorecard Rating (1 to 5 Stars)</label>
          <select name="scorecard_rating" id="updateRatingSelect" class="form-control">
            <option value="0">Not Rated</option>
            <option value="1">1 Star - Unsatisfactory</option>
            <option value="2">2 Stars - Marginal</option>
            <option value="3">3 Stars - Competent</option>
            <option value="4">4 Stars - Very Good</option>
            <option value="5">5 Stars - Outstanding</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Interviewer Notes &amp; Feedback</label>
          <textarea name="interviewer_feedback" id="updateFeedbackText" class="form-control" rows="3" placeholder="Technical evaluation, behavioral score, recommendations..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalUpdateStage').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Assessment</button>
      </div>
    </form>
  </div>
</div>

<script>
function switchRecTab(tabId, btn) {
  document.getElementById('tab-kanban').style.display = (tabId === 'kanban') ? 'block' : 'none';
  document.getElementById('tab-jobs').style.display = (tabId === 'jobs') ? 'block' : 'none';
  
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function openUpdateStageModal(cand) {
  document.getElementById('formUpdateStage').action = '<?= site_url("recruitment/candidates/stage/") ?>' + cand.id;
  document.getElementById('updateCandSummary').innerHTML = 'Evaluating: <strong>' + cand.full_name + '</strong> (' + cand.candidate_code + ')';
  document.getElementById('updateStageSelect').value = cand.stage;
  document.getElementById('updateRatingSelect').value = cand.scorecard_rating || 0;
  document.getElementById('updateFeedbackText').value = cand.interviewer_feedback || '';
  document.getElementById('modalUpdateStage').style.display = 'flex';
}
</script>
