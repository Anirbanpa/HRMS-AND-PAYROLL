<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Performance Management, OKRs &amp; Appraisals
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Goal setting, weightage metrics, self-evaluations, supervisory reviews, and promotion increments.
    </p>
  </div>
  <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
    <!-- Cycle Switcher Dropdown -->
    <form method="GET" action="<?= site_url('performance') ?>" style="display: flex; align-items: center; gap: 6px;">
      <label style="font-size: 12.5px; font-weight: 600; color: var(--color-slate-600);">Cycle:</label>
      <select name="cycle_id" class="form-control" style="font-size: 12.5px; padding: 6px 12px; width: auto;" onchange="this.form.submit()">
        <?php foreach ($cycles as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= ($c['id'] == $selectedCycleId) ? 'selected' : '' ?>>
            <?= esc($c['title']) ?> (<?= ucfirst($c['status']) ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <?php if ($isHR): ?>
      <button type="button" class="btn btn-outline" onclick="document.getElementById('modalAddCycle').style.display='flex'">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        New Cycle
      </button>
    <?php endif; ?>

    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalAddGoal').style.display='flex'">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Goal / KPI
    </button>
  </div>
</div>

<!-- TABS: MY PERFORMANCE vs TEAM APPRAISALS -->
<div class="tabs-container" style="margin-bottom: 24px;">
  <div class="tabs-nav">
    <button type="button" class="tab-btn active" data-target="#tabMyPerformance">My Goals &amp; Self-Assessment</button>
    <?php if ($isHR || $isManager): ?>
      <button type="button" class="tab-btn" data-target="#tabTeamAppraisals">Team Review &amp; Ratings Hub (<?= count($teamAppraisals) ?>)</button>
    <?php endif; ?>
    <button type="button" class="tab-btn" data-target="#tabCycles">Appraisal Cycles &amp; Deadlines</button>
  </div>

  <!-- TAB 1: MY PERFORMANCE & SELF-ASSESSMENT -->
  <div class="tab-pane active" id="tabMyPerformance">
    <div class="grid-3" style="margin-bottom: 20px;">
      <!-- Appraisal Status Summary Card -->
      <div class="card" style="grid-column: span 1; border-top: 4px solid var(--color-primary);">
        <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 12px;">Appraisal Scorecard</h3>
        <?php if ($myAppraisal): ?>
          <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; justify-content: space-between; padding: 8px 12px; background: var(--color-slate-50); border-radius: 6px;">
              <span style="font-size: 13px; color: var(--color-slate-600);">Self Score:</span>
              <strong style="font-size: 14px; color: var(--color-primary);"><?= esc($myAppraisal['overall_self_score'] ?? '0.0') ?> / 5.0</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 8px 12px; background: var(--color-slate-50); border-radius: 6px;">
              <span style="font-size: 13px; color: var(--color-slate-600);">Manager Score:</span>
              <strong style="font-size: 14px; color: var(--color-emerald-600);"><?= esc($myAppraisal['overall_manager_score'] ?? 'Pending') ?> / 5.0</strong>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 8px 12px; background: var(--color-slate-50); border-radius: 6px;">
              <span style="font-size: 13px; color: var(--color-slate-600);">Final Rating Band:</span>
              <span class="badge badge-success"><?= esc($myAppraisal['final_rating_band'] ?? 'Under Review') ?></span>
            </div>
            <?php if (!empty($myAppraisal['recommended_increment_percent'])): ?>
              <div style="display: flex; justify-content: space-between; padding: 8px 12px; background: rgba(16, 185, 129, 0.08); border-radius: 6px;">
                <span style="font-size: 13px; color: var(--color-emerald-700);">Recommended Increment:</span>
                <strong style="font-size: 14px; color: var(--color-emerald-700);">+<?= esc($myAppraisal['recommended_increment_percent']) ?>%</strong>
              </div>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <p style="font-size: 13px; color: var(--color-slate-500); line-height: 1.5;">
            No appraisal form submitted yet for this cycle. Rate your goals and click "Submit Self-Assessment" below.
          </p>
        <?php endif; ?>

        <?php if (!empty($myGoals)): ?>
          <button type="button" class="btn btn-outline btn-sm" style="width: 100%; margin-top: 14px; justify-content: center;" onclick="document.getElementById('modalSelfAssessment').style.display='flex'">
            ⚡ Submit / Edit Self-Assessment
          </button>
        <?php endif; ?>
      </div>

      <!-- My Active Goals & Metrics Table -->
      <div class="card" style="grid-column: span 2;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
          <h3 style="font-size: 15px; font-weight: 700; margin: 0;">My Active Objectives &amp; Key Results (OKRs)</h3>
          <span class="badge badge-info" style="font-size: 11px;">
            Total Weightage: <?= array_sum(array_column($myGoals, 'weightage_percent')) ?>%
          </span>
        </div>

        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Goal / Objective</th>
                <th>Weight</th>
                <th>Target Metric</th>
                <th>Self Rating</th>
                <th>Manager Rating</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($myGoals)): ?>
                <tr>
                  <td colspan="6" style="text-align: center; color: var(--color-slate-500); padding: 32px 14px;">
                    No goals defined for this cycle. Click 'Add Goal / KPI' to set your quarterly/annual deliverables.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($myGoals as $g): ?>
                  <tr>
                    <td>
                      <strong style="color: var(--color-slate-900);"><?= esc($g['title']) ?></strong>
                      <?php if (!empty($g['description'])): ?>
                        <div style="font-size: 12px; color: var(--color-slate-500); margin-top: 2px;"><?= esc($g['description']) ?></div>
                      <?php endif; ?>
                    </td>
                    <td><span class="badge badge-primary"><?= esc($g['weightage_percent']) ?>%</span></td>
                    <td style="font-size: 13px;"><?= esc($g['target_metric'] ?? 'Deliverable Milestone') ?></td>
                    <td>
                      <?php if ($g['self_rating']): ?>
                        <span class="badge badge-info"><?= esc($g['self_rating']) ?> / 5.0</span>
                      <?php else: ?>
                        <span style="color: var(--color-slate-400); font-size: 12px;">Not rated</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($g['manager_rating']): ?>
                        <span class="badge badge-success"><?= esc($g['manager_rating']) ?> / 5.0</span>
                      <?php else: ?>
                        <span style="color: var(--color-slate-400); font-size: 12px;">Pending</span>
                      <?php endif; ?>
                    </td>
                    <td><span class="badge badge-secondary"><?= esc(ucfirst($g['status'])) ?></span></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php if ($isHR || $isManager): ?>
  <!-- TAB 2: TEAM REVIEW & RATINGS HUB -->
  <div class="tab-pane" id="tabTeamAppraisals">
    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div>
          <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Supervisory Review Roster</h3>
          <p style="font-size: 13px; color: var(--color-slate-500); margin-top: 2px;">Evaluate team member milestones, assign overall score bands, and recommend salary increments.</p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Employee Code</th>
              <th>Employee Name</th>
              <th>Department &bull; Designation</th>
              <th>Self Score</th>
              <th>Manager Score</th>
              <th>Rating Band</th>
              <th>Rec. Increment</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($teamAppraisals)): ?>
              <tr><td colspan="8" style="text-align: center; color: var(--color-slate-500); padding: 32px;">No employees in your supervisory queue.</td></tr>
            <?php else: ?>
              <?php foreach ($teamAppraisals as $t): ?>
                <tr>
                  <td><code><?= esc($t['employee_code']) ?></code></td>
                  <td><strong><?= esc($t['first_name'] . ' ' . $t['last_name']) ?></strong></td>
                  <td style="font-size: 12.5px;"><?= esc($t['department_name'] ?? 'General') ?> &bull; <?= esc($t['designation_name'] ?? 'Staff') ?></td>
                  <td><?= $t['overall_self_score'] ? esc($t['overall_self_score']) . ' / 5.0' : '<span style="color:var(--color-slate-400)">Pending</span>' ?></td>
                  <td><?= $t['overall_manager_score'] ? '<strong style="color:var(--color-emerald-600)">' . esc($t['overall_manager_score']) . ' / 5.0</strong>' : '<span style="color:var(--color-slate-400)">Pending</span>' ?></td>
                  <td>
                    <?php if (!empty($t['final_rating_band'])): ?>
                      <span class="badge badge-success"><?= esc($t['final_rating_band']) ?></span>
                    <?php else: ?>
                      <span class="badge badge-secondary">Under Review</span>
                    <?php endif; ?>
                  </td>
                  <td><?= !empty($t['recommended_increment_percent']) ? '+' . esc($t['recommended_increment_percent']) . '%' : '-' ?></td>
                  <td>
                    <button type="button" class="btn btn-outline btn-sm" onclick="openManagerReviewModal(<?= (int)$t['employee_id'] ?>, '<?= esc($t['first_name'] . ' ' . $t['last_name']) ?>', '<?= esc($t['overall_manager_score'] ?? '3.5') ?>', '<?= esc($t['final_rating_band'] ?? 'Meets Expectations') ?>', '<?= (int)($t['promotion_recommended'] ?? 0) ?>', '<?= esc($t['recommended_increment_percent'] ?? '5.0') ?>')">
                      Evaluate &amp; Rate
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- TAB 3: APPRAISAL CYCLES & DEADLINES -->
  <div class="tab-pane" id="tabCycles">
    <div class="card">
      <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 14px;">Enterprise Performance Cycles</h3>
      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 14px;">
        <?php foreach ($cycles as $c): ?>
          <div style="padding: 16px; background: var(--color-slate-50); border-radius: 8px; border: 1px solid var(--color-slate-200);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
              <h4 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);"><?= esc($c['title']) ?></h4>
              <span class="badge badge-success" style="font-size: 11px; text-transform: uppercase;"><?= esc($c['status']) ?></span>
            </div>
            <div style="font-size: 12px; color: var(--color-slate-500); margin-bottom: 6px;">
              Period: <?= date('M j, Y', strtotime($c['start_date'])) ?> &ndash; <?= date('M j, Y', strtotime($c['end_date'])) ?>
            </div>
            <div style="font-size: 12px; color: var(--color-slate-600); margin-bottom: 4px;">
              Self-Review Deadline: <strong><?= date('M j, Y', strtotime($c['self_review_deadline'])) ?></strong>
            </div>
            <div style="font-size: 12px; color: var(--color-slate-600); margin-bottom: 12px;">
              Manager Review Deadline: <strong><?= date('M j, Y', strtotime($c['manager_review_deadline'])) ?></strong>
            </div>
            <a href="<?= site_url('performance?cycle_id=' . $c['id']) ?>" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;">
              Switch to this Cycle
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: ADD GOAL -->
<div id="modalAddGoal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 500px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Add Goal / KPI Objective</h3>
      <button type="button" onclick="document.getElementById('modalAddGoal').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('performance/goal') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Performance Cycle *</label>
        <select name="cycle_id" class="form-control" required>
          <?php foreach ($cycles as $c): ?>
            <option value="<?= (int)$c['id'] ?>" <?= ($c['id'] == $selectedCycleId) ? 'selected' : '' ?>>
              <?= esc($c['title']) ?> (<?= ucfirst($c['status']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Goal Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Implement automated testing pipeline" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Weightage Percent (%) *</label>
          <input type="number" step="1" min="1" max="100" name="weightage_percent" class="form-control" value="25" required>
        </div>
        <div class="form-group">
          <label class="form-label">Target Metric *</label>
          <input type="text" name="target_metric" class="form-control" placeholder="e.g. 95% test coverage" required>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Description / Scope of Work</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Provide clarity on milestones and deliverable expectations..."></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddGoal').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Goal</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: ADD CYCLE (HR ADMIN) -->
<div id="modalAddCycle" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 500px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Create Performance Appraisal Cycle</h3>
      <button type="button" onclick="document.getElementById('modalAddCycle').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('performance/cycle') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Cycle Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Annual Appraisal Cycle 2026-2027" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Start Date *</label>
          <input type="date" name="start_date" class="form-control" value="<?= date('Y-01-01') ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">End Date *</label>
          <input type="date" name="end_date" class="form-control" value="<?= date('Y-12-31') ?>" required>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 20px;">
        <div class="form-group">
          <label class="form-label">Self-Review Deadline</label>
          <input type="date" name="self_review_deadline" class="form-control" value="<?= date('Y-11-30') ?>">
        </div>
        <div class="form-group">
          <label class="form-label">Manager Review Deadline</label>
          <input type="date" name="manager_review_deadline" class="form-control" value="<?= date('Y-12-15') ?>">
        </div>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddCycle').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Create Cycle</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: SELF-ASSESSMENT -->
<div id="modalSelfAssessment" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 600px; max-width: 90vw; max-height: 90vh; overflow-y: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Submit Self-Assessment</h3>
      <button type="button" onclick="document.getElementById('modalSelfAssessment').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('performance/self-review') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="cycle_id" value="<?= esc($selectedCycleId) ?>">

      <div style="font-size: 13px; color: var(--color-slate-600); margin-bottom: 16px;">
        Rate your performance milestones for this cycle on a 1.0 to 5.0 scale (1 = Unsatisfactory, 3 = Meets Expectations, 5 = Outstanding).
      </div>

      <?php foreach ($myGoals as $g): ?>
        <div style="padding: 12px; background: var(--color-slate-50); border: 1px solid var(--color-slate-200); border-radius: 6px; margin-bottom: 12px;">
          <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
            <strong style="font-size: 13.5px;"><?= esc($g['title']) ?></strong>
            <span class="badge badge-info"><?= esc($g['weightage_percent']) ?>% Weight</span>
          </div>
          <div class="grid-2" style="gap: 10px;">
            <div>
              <label class="form-label" style="font-size: 12px;">Self Score (1.0 - 5.0)</label>
              <input type="number" step="0.1" min="1.0" max="5.0" name="goal_ratings[<?= $g['id'] ?>]" class="form-control" value="<?= esc($g['self_rating'] ?? '4.0') ?>" required>
            </div>
            <div>
              <label class="form-label" style="font-size: 12px;">Self Comments</label>
              <input type="text" name="goal_comments[<?= $g['id'] ?>]" class="form-control" value="<?= esc($g['self_comments'] ?? '') ?>" placeholder="Milestone deliverables achieved...">
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="form-group" style="margin-top: 16px; margin-bottom: 20px;">
        <label class="form-label">Overall Self Score (1.0 to 5.0) *</label>
        <input type="number" step="0.1" min="1.0" max="5.0" name="overall_self_score" class="form-control" value="<?= esc($myAppraisal['overall_self_score'] ?? '4.2') ?>" required>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalSelfAssessment').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Self-Evaluation</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: MANAGER APPRAISAL REVIEW -->
<div id="modalManagerReview" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 580px; max-width: 90vw; max-height: 90vh; overflow-y: auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Manager Performance Evaluation</h3>
      <button type="button" onclick="document.getElementById('modalManagerReview').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('performance/manager-review') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="cycle_id" value="<?= esc($selectedCycleId) ?>">
      <input type="hidden" name="employee_id" id="mgrReviewEmpId" value="">

      <div style="margin-bottom: 14px; font-size: 13.5px; color: var(--color-slate-700);">
        Reviewing Employee: <strong id="mgrReviewEmpName" style="color: var(--color-primary);"></strong>
      </div>

      <div class="grid-2" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Overall Manager Score (1.0 - 5.0) *</label>
          <input type="number" step="0.1" min="1.0" max="5.0" name="overall_manager_score" id="mgrReviewScore" class="form-control" value="4.0" required>
        </div>
        <div class="form-group">
          <label class="form-label">Final Rating Band *</label>
          <select name="final_rating_band" id="mgrReviewBand" class="form-control">
            <option value="Outstanding (Grade A)">Outstanding (Grade A)</option>
            <option value="Exceeds Expectations (Grade B)">Exceeds Expectations (Grade B)</option>
            <option value="Meets Expectations (Grade C)" selected>Meets Expectations (Grade C)</option>
            <option value="Needs Improvement (Grade D)">Needs Improvement (Grade D)</option>
            <option value="Unsatisfactory (Grade E)">Unsatisfactory (Grade E)</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label">Promotion Recommended?</label>
          <select name="promotion_recommended" id="mgrReviewPromo" class="form-control">
            <option value="0">No - Maintain Current Role</option>
            <option value="1">Yes - Recommend for Promotion</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Recommended Salary Increment (%)</label>
          <input type="number" step="0.5" min="0" max="100" name="recommended_increment_percent" id="mgrReviewInc" class="form-control" value="8.0">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Key Strengths &amp; Commendations</label>
        <textarea name="key_strengths" class="form-control" rows="2" placeholder="Exceptional problem-solving, architectural consistency..."></textarea>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Development Areas / Growth Goals</label>
        <textarea name="development_areas" class="form-control" rows="2" placeholder="Communication across remote squads, delegation..."></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalManagerReview').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Finalize Appraisal</button>
      </div>
    </form>
  </div>
</div>

<script>
function openManagerReviewModal(empId, empName, score, band, promo, inc) {
  document.getElementById('mgrReviewEmpId').value = empId;
  document.getElementById('mgrReviewEmpName').innerText = empName;
  document.getElementById('mgrReviewScore').value = score || '4.0';
  document.getElementById('mgrReviewBand').value = band || 'Meets Expectations (Grade C)';
  document.getElementById('mgrReviewPromo').value = promo || '0';
  document.getElementById('mgrReviewInc').value = inc || '5.0';
  document.getElementById('modalManagerReview').style.display = 'flex';
}
</script>
