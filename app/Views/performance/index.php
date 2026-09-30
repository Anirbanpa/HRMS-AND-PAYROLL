<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 14px;">
  <div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
      <h2 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em; margin: 0;">
        Performance Management, OKRs &amp; Appraisals
      </h2>
      <?php if (!empty($selectedCycle)): ?>
        <span class="badge badge-success" style="font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.04em;">
          <?= esc($selectedCycle['status'] ?? 'Active') ?>
        </span>
      <?php endif; ?>
    </div>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 3px; margin-bottom: 0;">
      Define measurable deliverables, track quarterly OKRs, and complete annual appraisal reviews.
    </p>
  </div>

  <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
    <!-- Cycle Switcher Pill Dropdown -->
    <form method="GET" action="<?= site_url('performance') ?>" style="display: flex; align-items: center; gap: 6px; background: var(--bg-card); padding: 5px 10px; border: 1px solid var(--border-color); border-radius: 8px;">
      <span style="font-size: 12px; font-weight: 600; color: var(--color-slate-500); display: flex; align-items: center; gap: 4px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        Cycle:
      </span>
      <select name="cycle_id" style="font-size: 13px; font-weight: 600; border: none; background: transparent; color: var(--color-slate-800); outline: none; cursor: pointer; padding-right: 4px;" onchange="this.form.submit()">
        <?php foreach ($cycles as $c): ?>
          <option value="<?= (int)$c['id'] ?>" <?= ($c['id'] == $selectedCycleId) ? 'selected' : '' ?>>
            <?= esc($c['title']) ?><?= !empty($c['status']) ? ' (' . ucfirst($c['status']) . ')' : '' ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <?php if ($isHR): ?>
      <button type="button" class="btn btn-outline" style="font-size: 13px; padding: 7px 12px;" onclick="document.getElementById('modalAddCycle').style.display='flex'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
        New Cycle
      </button>
    <?php endif; ?>

    <button type="button" class="btn btn-primary" style="font-size: 13px; padding: 7px 14px;" onclick="document.getElementById('modalAddGoal').style.display='flex'">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Goal / KPI
    </button>
  </div>
</div>

<!-- 4 MINIMAL KPI METRIC TILES -->
<div class="grid-4" style="gap: 16px; margin-bottom: 22px;">
  <!-- Metric 1: Active Goals & Weightage -->
  <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-primary); box-shadow: var(--shadow-sm);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
      <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Active Goals</span>
      <span class="badge <?= $totalWeightage >= 100 ? 'badge-success' : ($totalWeightage > 0 ? 'badge-primary' : 'badge-secondary') ?>" style="font-size: 11px;">
        <?= (float)$totalWeightage ?>% Weight
      </span>
    </div>
    <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 6px;">
      <h3 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); margin: 0;"><?= count($myGoals) ?></h3>
      <span style="font-size: 13px; color: var(--color-slate-500);">deliverables</span>
    </div>
    <div style="width: 100%; height: 5px; background: var(--color-slate-100); border-radius: 99px; overflow: hidden;">
      <div style="width: <?= min(100, $totalWeightage) ?>%; height: 100%; background: <?= $totalWeightage >= 100 ? 'var(--color-emerald-500)' : 'var(--color-primary)' ?>; border-radius: 99px; transition: width 0.3s ease;"></div>
    </div>
  </div>

  <!-- Metric 2: Self-Assessment Status -->
  <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #0284c7; box-shadow: var(--shadow-sm);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
      <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Self Review</span>
      <span class="badge <?= !empty($myAppraisal['overall_self_score']) ? 'badge-success' : 'badge-warning' ?>" style="font-size: 11px;">
        <?= !empty($myAppraisal['overall_self_score']) ? 'Submitted' : 'Pending' ?>
      </span>
    </div>
    <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
      <h3 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); margin: 0;">
        <?= !empty($myAppraisal['overall_self_score']) ? esc($myAppraisal['overall_self_score']) : '—' ?>
      </h3>
      <?php if (!empty($myAppraisal['overall_self_score'])): ?>
        <span style="font-size: 13px; color: var(--color-slate-500);">/ 5.0</span>
      <?php else: ?>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">Awaiting rating</span>
      <?php endif; ?>
    </div>
    <div style="font-size: 11.5px; color: var(--color-slate-500);">
      <?= !empty($selectedCycle['self_review_deadline']) ? 'Due: ' . date('M j, Y', strtotime($selectedCycle['self_review_deadline'])) : 'Open' ?>
    </div>
  </div>

  <!-- Metric 3: Manager Rating -->
  <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid var(--color-emerald-500); box-shadow: var(--shadow-sm);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
      <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Manager Rating</span>
      <span class="badge <?= !empty($myAppraisal['overall_manager_score']) ? 'badge-success' : 'badge-secondary' ?>" style="font-size: 11px;">
        <?= !empty($myAppraisal['overall_manager_score']) ? 'Evaluated' : 'Awaiting Review' ?>
      </span>
    </div>
    <div style="display: flex; align-items: baseline; gap: 6px; margin-bottom: 4px;">
      <h3 style="font-size: 24px; font-weight: 800; color: var(--color-emerald-600); margin: 0;">
        <?= !empty($myAppraisal['overall_manager_score']) ? esc($myAppraisal['overall_manager_score']) : '—' ?>
      </h3>
      <?php if (!empty($myAppraisal['overall_manager_score'])): ?>
        <span style="font-size: 13px; color: var(--color-slate-500);">/ 5.0</span>
      <?php else: ?>
        <span style="font-size: 12.5px; color: var(--color-slate-500);">Pending feedback</span>
      <?php endif; ?>
    </div>
    <div style="font-size: 11.5px; color: var(--color-slate-500);">
      <?= !empty($selectedCycle['manager_review_deadline']) ? 'Due: ' . date('M j, Y', strtotime($selectedCycle['manager_review_deadline'])) : 'Open' ?>
    </div>
  </div>

  <!-- Metric 4: Final Appraisal Band -->
  <div class="card" style="padding: 16px 18px; border-radius: 10px; border-left: 4px solid #8b5cf6; box-shadow: var(--shadow-sm);">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
      <span style="font-size: 12px; font-weight: 700; color: var(--color-slate-500); text-transform: uppercase; letter-spacing: 0.03em;">Appraisal Band</span>
      <?php if (!empty($myAppraisal['recommended_increment_percent'])): ?>
        <span class="badge badge-success" style="font-size: 11px;">+<?= esc($myAppraisal['recommended_increment_percent']) ?>% Merit</span>
      <?php endif; ?>
    </div>
    <div style="margin-bottom: 4px;">
      <strong style="font-size: 14.5px; font-weight: 700; color: var(--color-slate-900); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
        <?= esc($myAppraisal['final_rating_band'] ?? 'Under Review') ?>
      </strong>
    </div>
    <div style="font-size: 11.5px; color: var(--color-slate-500);">
      <?= !empty($myAppraisal['promotion_recommended']) ? '⭐ Promotion Recommended' : 'Cycle Evaluation' ?>
    </div>
  </div>
</div>

<!-- TABS NAVIGATION -->
<div class="tabs-container" style="margin-bottom: 24px;">
  <div class="tabs-nav" style="border-bottom: 1px solid var(--border-color); margin-bottom: 20px; display: flex; gap: 8px;">
    <button type="button" class="tab-btn active" data-target="#tabMyPerformance">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/><circle cx="12" cy="12" r="2"/></svg>
      My Goals &amp; Self-Assessment
    </button>
    <?php if ($isHR || $isManager): ?>
      <button type="button" class="tab-btn" data-target="#tabTeamAppraisals">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Team Reviews (<?= count($teamAppraisals) ?>)
        <?php if ($teamPendingCount > 0): ?>
          <span style="margin-left: 6px; background: #fef3c7; color: #92400e; font-size: 11px; padding: 2px 7px; border-radius: 99px; font-weight: 700;">
            <?= $teamPendingCount ?> pending
          </span>
        <?php endif; ?>
      </button>
    <?php endif; ?>
    <button type="button" class="tab-btn" data-target="#tabCycles">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px;"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
      Appraisal Cycles (<?= count($cycles) ?>)
    </button>
  </div>

  <!-- TAB 1: MY GOALS & SELF-ASSESSMENT -->
  <div class="tab-pane active" id="tabMyPerformance">
    <div style="display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start;">
      <!-- LEFT CARD: Appraisal Roadmap & Scorecard -->
      <div class="card" style="padding: 20px; border-radius: 10px; border-top: 4px solid var(--color-primary); box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
          <h3 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Appraisal Roadmap</h3>
          <span class="badge <?= !empty($myAppraisal['status']) && $myAppraisal['status'] === 'completed' ? 'badge-success' : 'badge-info' ?>" style="font-size: 11px;">
            <?= !empty($myAppraisal['status']) ? ucfirst(str_replace('_', ' ', $myAppraisal['status'])) : 'In Progress' ?>
          </span>
        </div>

        <!-- Visual Step Progression -->
        <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px;">
          <!-- Step 1 -->
          <div style="display: flex; gap: 12px; align-items: flex-start;">
            <div style="width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; background: <?= !empty($myGoals) ? 'var(--color-emerald-500); color: white;' : 'var(--color-slate-200); color: var(--color-slate-600);' ?>">
              <?= !empty($myGoals) ? '✓' : '1' ?>
            </div>
            <div>
              <div style="font-size: 13px; font-weight: 600; color: var(--color-slate-800);">1. Define OKRs / Goals</div>
              <div style="font-size: 11.5px; color: var(--color-slate-500);">
                <?= !empty($myGoals) ? count($myGoals) . ' goals added (' . (float)$totalWeightage . '% weight)' : 'Add deliverables for this cycle' ?>
              </div>
            </div>
          </div>

          <!-- Step 2 -->
          <div style="display: flex; gap: 12px; align-items: flex-start;">
            <div style="width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; background: <?= !empty($myAppraisal['overall_self_score']) ? 'var(--color-emerald-500); color: white;' : 'var(--color-slate-200); color: var(--color-slate-600);' ?>">
              <?= !empty($myAppraisal['overall_self_score']) ? '✓' : '2' ?>
            </div>
            <div>
              <div style="font-size: 13px; font-weight: 600; color: var(--color-slate-800);">2. Submit Self-Assessment</div>
              <div style="font-size: 11.5px; color: var(--color-slate-500);">
                <?= !empty($myAppraisal['overall_self_score']) ? 'Self score: ' . esc($myAppraisal['overall_self_score']) . ' / 5.0' : 'Rate your milestones & achievements' ?>
              </div>
            </div>
          </div>

          <!-- Step 3 -->
          <div style="display: flex; gap: 12px; align-items: flex-start;">
            <div style="width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; background: <?= !empty($myAppraisal['overall_manager_score']) ? 'var(--color-emerald-500); color: white;' : 'var(--color-slate-200); color: var(--color-slate-600);' ?>">
              <?= !empty($myAppraisal['overall_manager_score']) ? '✓' : '3' ?>
            </div>
            <div>
              <div style="font-size: 13px; font-weight: 600; color: var(--color-slate-800);">3. Managerial Review</div>
              <div style="font-size: 11.5px; color: var(--color-slate-500);">
                <?= !empty($myAppraisal['overall_manager_score']) ? 'Manager score: ' . esc($myAppraisal['overall_manager_score']) . ' / 5.0' : 'Supervisor review pending' ?>
              </div>
            </div>
          </div>

          <!-- Step 4 -->
          <div style="display: flex; gap: 12px; align-items: flex-start;">
            <div style="width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; background: <?= !empty($myAppraisal['final_rating_band']) ? 'var(--color-emerald-500); color: white;' : 'var(--color-slate-200); color: var(--color-slate-600);' ?>">
              <?= !empty($myAppraisal['final_rating_band']) ? '✓' : '4' ?>
            </div>
            <div>
              <div style="font-size: 13px; font-weight: 600; color: var(--color-slate-800);">4. Appraisal Outcome</div>
              <div style="font-size: 11.5px; color: var(--color-slate-500);">
                <?= !empty($myAppraisal['final_rating_band']) ? esc($myAppraisal['final_rating_band']) : 'Merit increment & final band' ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Scores Breakdown If Available -->
        <?php if ($myAppraisal): ?>
          <div style="display: flex; flex-direction: column; gap: 8px; padding-top: 14px; border-top: 1px dashed var(--border-color); margin-bottom: 16px;">
            <div style="display: flex; justify-content: space-between; font-size: 12.5px;">
              <span style="color: var(--color-slate-500);">Self Score:</span>
              <strong style="color: var(--color-primary);"><?= esc($myAppraisal['overall_self_score'] ?? '0.0') ?> / 5.0</strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 12.5px;">
              <span style="color: var(--color-slate-500);">Manager Score:</span>
              <strong style="color: var(--color-emerald-600);"><?= esc($myAppraisal['overall_manager_score'] ?? 'Pending') ?></strong>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 12.5px;">
              <span style="color: var(--color-slate-500);">Final Band:</span>
              <span class="badge badge-success" style="font-size: 11px;"><?= esc($myAppraisal['final_rating_band'] ?? 'Under Review') ?></span>
            </div>
            <?php if (!empty($myAppraisal['recommended_increment_percent'])): ?>
              <div style="display: flex; justify-content: space-between; font-size: 12.5px; background: rgba(16, 185, 129, 0.08); padding: 6px 10px; border-radius: 6px;">
                <span style="color: var(--color-emerald-700); font-weight: 600;">Recommended Increment:</span>
                <strong style="color: var(--color-emerald-700);">+<?= esc($myAppraisal['recommended_increment_percent']) ?>%</strong>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <!-- Action Trigger: Always Accessible -->
        <div style="display: flex; flex-direction: column; gap: 8px;">
          <?php if (!empty($myGoals)): ?>
            <button type="button" class="btn btn-primary" style="width: 100%; justify-content: center; font-size: 13px;" onclick="document.getElementById('modalSelfAssessment').style.display='flex'">
              ⚡ <?= $myAppraisal ? 'Update Self-Assessment' : 'Submit Self-Assessment' ?>
            </button>
          <?php else: ?>
            <button type="button" class="btn btn-primary" style="width: 100%; justify-content: center; font-size: 13px;" onclick="document.getElementById('modalAddGoal').style.display='flex'">
              + Add Goal / KPI to Begin
            </button>
            <p style="font-size: 11.5px; color: var(--color-slate-500); text-align: center; margin: 0;">
              Add at least one goal to submit self-assessment.
            </p>
          <?php endif; ?>
        </div>
      </div>

      <!-- RIGHT CARD: Active Objectives & Key Results (OKRs) -->
      <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
          <div>
            <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--color-slate-900);">
              Objectives &amp; Key Results (OKRs)
            </h3>
            <p style="font-size: 12.5px; color: var(--color-slate-500); margin: 2px 0 0 0;">
              Deliverables and KPI weightages for <?= esc($selectedCycle['title'] ?? 'current cycle') ?>
            </p>
          </div>
          <div style="display: flex; align-items: center; gap: 8px;">
            <span class="badge <?= $totalWeightage >= 100 ? 'badge-success' : 'badge-primary' ?>" style="font-size: 11.5px; padding: 5px 10px;">
              Weightage: <?= (float)$totalWeightage ?>% / 100%
            </span>
            <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('modalAddGoal').style.display='flex'" style="font-size: 12.5px;">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Add Goal
            </button>
          </div>
        </div>

        <?php if (empty($myGoals)): ?>
          <!-- Clean & Friendly Empty State -->
          <div style="text-align: center; padding: 48px 20px; background: var(--bg-main, #f8fafc); border-radius: 8px; border: 1px dashed var(--border-color);">
            <div style="width: 52px; height: 52px; border-radius: 50%; background: rgba(99, 102, 241, 0.1); color: var(--color-primary); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px;">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
            </div>
            <h4 style="font-size: 16px; font-weight: 700; color: var(--color-slate-800); margin: 0 0 4px 0;">No goals set for this cycle yet</h4>
            <p style="font-size: 13px; color: var(--color-slate-500); max-width: 440px; margin: 0 auto 18px auto; line-height: 1.5;">
              Define your quarterly OKRs and milestone targets. Your overall appraisal will be evaluated based on the weightage of these deliverables.
            </p>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('modalAddGoal').style.display='flex'">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              Add Your First Goal
            </button>
          </div>
        <?php else: ?>
          <!-- Clean Goals Table -->
          <div class="table-responsive">
            <table class="table" style="margin-bottom: 0;">
              <thead>
                <tr>
                  <th style="width: 38%;">Goal / Deliverable</th>
                  <th style="width: 12%;">Weight</th>
                  <th style="width: 20%;">Target Metric</th>
                  <th style="width: 12%;">Self Rating</th>
                  <th style="width: 12%;">Manager Rating</th>
                  <th style="width: 6%; text-align: right;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($myGoals as $g): ?>
                  <tr>
                    <td>
                      <div style="font-weight: 700; color: var(--color-slate-900); font-size: 13.5px; margin-bottom: 2px;">
                        <?= esc($g['title']) ?>
                      </div>
                      <?php if (!empty($g['description'])): ?>
                        <div style="font-size: 12px; color: var(--color-slate-500); line-height: 1.4;">
                          <?= esc($g['description']) ?>
                        </div>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="badge badge-primary" style="font-size: 11.5px; font-weight: 700;">
                        <?= esc($g['weightage_percent']) ?>%
                      </span>
                    </td>
                    <td>
                      <div style="font-size: 12.5px; color: var(--color-slate-700); background: var(--bg-main); padding: 4px 8px; border-radius: 4px; display: inline-block;">
                        <?= esc($g['target_metric'] ?? 'Deliverable milestone') ?>
                      </div>
                    </td>
                    <td>
                      <?php if (!empty($g['self_rating'])): ?>
                        <span class="badge badge-info" style="font-size: 11.5px;">
                          <?= esc($g['self_rating']) ?> / 5.0
                        </span>
                      <?php else: ?>
                        <span style="color: var(--color-slate-400); font-size: 12px;">Not rated</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if (!empty($g['manager_rating'])): ?>
                        <span class="badge badge-success" style="font-size: 11.5px;">
                          <?= esc($g['manager_rating']) ?> / 5.0
                        </span>
                      <?php else: ?>
                        <span style="color: var(--color-slate-400); font-size: 12px;">Pending</span>
                      <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                      <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
                      <a href="<?= site_url('performance/goal/delete/' . $g['id']) ?>" 
                         class="btn btn-outline btn-sm" 
                         style="color: var(--color-rose-600, #e11d48); padding: 4px 7px; border-color: var(--color-slate-200);"
                         title="Delete Goal" 
                         onclick="return confirm('Are you sure you want to remove this goal?');">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                      </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php if ($isHR || $isManager): ?>
  <!-- TAB 2: TEAM REVIEW & RATINGS HUB -->
  <div class="tab-pane" id="tabTeamAppraisals">
    <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div>
          <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--color-slate-900);">
            Team Performance Evaluations
          </h3>
          <p style="font-size: 12.5px; color: var(--color-slate-500); margin: 2px 0 0 0;">
            Supervisory review queue for direct reports and department team members.
          </p>
        </div>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
          <!-- Live Search Input -->
          <div style="position: relative; width: 260px;">
            <input type="text" id="teamSearchInput" class="form-control" placeholder="Search employee..." onkeyup="filterTeamRoster()" style="padding-left: 32px; font-size: 12.5px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-slate-400);"><circle cx="11" cy="11" r="8"/><line x1="21" x2="21" y1="21" y2="16.65"/></svg>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table" id="teamRosterTable" style="margin-bottom: 0;">
          <thead>
            <tr>
              <th style="width: 28%;">Employee</th>
              <th style="width: 22%;">Department &bull; Role</th>
              <th style="width: 12%;">Self Score</th>
              <th style="width: 12%;">Manager Score</th>
              <th style="width: 14%;">Rating Band</th>
              <th style="width: 12%; text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($teamAppraisals)): ?>
              <tr>
                <td colspan="6" style="text-align: center; color: var(--color-slate-500); padding: 36px;">
                  No direct reports or employees in your supervisory evaluation queue.
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($teamAppraisals as $t): ?>
                <tr class="team-row">
                  <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                      <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--bg-main, #e0e7ff); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; flex-shrink: 0;">
                        <?= strtoupper(substr($t['first_name'], 0, 1) . substr($t['last_name'], 0, 1)) ?>
                      </div>
                      <div>
                        <strong class="emp-name" style="font-size: 13.5px; color: var(--color-slate-900);">
                          <?= esc($t['first_name'] . ' ' . $t['last_name']) ?>
                        </strong>
                        <div style="font-size: 11.5px; color: var(--color-slate-500);">
                          <code><?= esc($t['employee_code']) ?></code>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div style="font-size: 13px; font-weight: 600; color: var(--color-slate-800);">
                      <?= esc($t['department_name'] ?? 'General') ?>
                    </div>
                    <div style="font-size: 11.5px; color: var(--color-slate-500);">
                      <?= esc($t['designation_name'] ?? 'Staff') ?>
                    </div>
                  </td>
                  <td>
                    <?php if (!empty($t['overall_self_score'])): ?>
                      <span class="badge badge-info" style="font-size: 11.5px;">
                        <?= esc($t['overall_self_score']) ?> / 5.0
                      </span>
                    <?php else: ?>
                      <span style="color: var(--color-slate-400); font-size: 12px;">Pending</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($t['overall_manager_score'])): ?>
                      <strong style="color: var(--color-emerald-600); font-size: 13.5px;">
                        <?= esc($t['overall_manager_score']) ?> / 5.0
                      </strong>
                    <?php else: ?>
                      <span style="color: var(--color-slate-400); font-size: 12px;">Not rated</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($t['final_rating_band'])): ?>
                      <span class="badge badge-success" style="font-size: 11.5px;">
                        <?= esc($t['final_rating_band']) ?>
                      </span>
                      <?php if (!empty($t['recommended_increment_percent'])): ?>
                        <div style="font-size: 11px; color: var(--color-emerald-700); font-weight: 600; margin-top: 2px;">
                          +<?= esc($t['recommended_increment_percent']) ?>% Increment
                        </div>
                      <?php endif; ?>
                    <?php else: ?>
                      <span class="badge badge-secondary" style="font-size: 11px;">Under Review</span>
                    <?php endif; ?>
                  </td>
                  <td style="text-align: right;">
                    <button type="button" class="btn btn-outline btn-sm" style="font-size: 12px; padding: 5px 10px;" onclick="openManagerReviewModal(<?= (int)$t['employee_id'] ?>, '<?= esc($t['first_name'] . ' ' . $t['last_name']) ?>', '<?= esc($t['overall_manager_score'] ?? '4.0') ?>', '<?= esc($t['final_rating_band'] ?? 'Meets Expectations (Grade C)') ?>', '<?= (int)($t['promotion_recommended'] ?? 0) ?>', '<?= esc($t['recommended_increment_percent'] ?? '8.0') ?>')">
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
    <div class="card" style="padding: 20px; border-radius: 10px; box-shadow: var(--shadow-sm);">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div>
          <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--color-slate-900);">
            Appraisal Cycles &amp; Deadlines
          </h3>
          <p style="font-size: 12.5px; color: var(--color-slate-500); margin: 2px 0 0 0;">
            Corporate performance review windows, self-assessment deadlines, and manager reviews.
          </p>
        </div>
        <?php if ($isHR): ?>
          <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('modalAddCycle').style.display='flex'">
            + New Cycle
          </button>
        <?php endif; ?>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px;">
        <?php foreach ($cycles as $c): ?>
          <div style="padding: 18px; background: var(--bg-main, #f8fafc); border-radius: 8px; border: 1px solid var(--border-color); display: flex; flex-direction: column; justify-content: space-between;">
            <div>
              <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <h4 style="font-size: 15px; font-weight: 700; margin: 0; color: var(--color-slate-900);">
                  <?= esc($c['title']) ?>
                </h4>
                <span class="badge <?= ($c['status'] ?? 'active') === 'active' ? 'badge-success' : 'badge-secondary' ?>" style="font-size: 10.5px; text-transform: uppercase;">
                  <?= esc($c['status'] ?: 'Active') ?>
                </span>
              </div>
              
              <div style="font-size: 12.5px; color: var(--color-slate-500); margin-bottom: 10px;">
                Period: <strong><?= date('M j, Y', strtotime($c['start_date'])) ?> &ndash; <?= date('M j, Y', strtotime($c['end_date'])) ?></strong>
              </div>

              <div style="font-size: 12px; color: var(--color-slate-600); margin-bottom: 4px; display: flex; justify-content: space-between;">
                <span>Self-Review Due:</span>
                <strong><?= date('M j, Y', strtotime($c['self_review_deadline'])) ?></strong>
              </div>
              <div style="font-size: 12px; color: var(--color-slate-600); margin-bottom: 14px; display: flex; justify-content: space-between;">
                <span>Manager Review Due:</span>
                <strong><?= date('M j, Y', strtotime($c['manager_review_deadline'])) ?></strong>
              </div>
            </div>

            <?php if ($c['id'] == $selectedCycleId): ?>
              <div style="text-align: center; padding: 7px; background: rgba(99, 102, 241, 0.1); border-radius: 6px; color: var(--color-primary); font-size: 12px; font-weight: 700;">
                ✓ Current Active Cycle
              </div>
            <?php else: ?>
              <a href="<?= site_url('performance?cycle_id=' . $c['id']) ?>" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; font-size: 12.5px;">
                Switch to this Cycle
              </a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- MODAL 1: ADD GOAL / KPI -->
<div id="modalAddGoal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(2px); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 520px; max-width: 92vw; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
      <h3 style="font-size: 17px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Add Goal / KPI Objective</h3>
      <button type="button" onclick="document.getElementById('modalAddGoal').style.display='none'" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);">&times;</button>
    </div>

    <form action="<?= site_url('performance/goal') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Performance Cycle *</label>
        <select name="cycle_id" class="form-control" required style="font-size: 13px;">
          <?php foreach ($cycles as $c): ?>
            <option value="<?= (int)$c['id'] ?>" <?= ($c['id'] == $selectedCycleId) ? 'selected' : '' ?>>
              <?= esc($c['title']) ?><?= !empty($c['status']) ? ' (' . ucfirst($c['status']) . ')' : '' ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Goal Title / Deliverable *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Redesign onboarding UX to reduce drop-off by 30%" required style="font-size: 13px;">
      </div>

      <div class="grid-2" style="gap: 12px; margin-bottom: 8px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Weightage (%) *</label>
          <input type="number" step="1" min="1" max="100" id="goalWeightInput" name="weightage_percent" class="form-control" value="25" required style="font-size: 13px;">
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Target Metric / Benchmark *</label>
          <input type="text" name="target_metric" class="form-control" placeholder="e.g. 99.9% uptime / Q3 Launch" required style="font-size: 13px;">
        </div>
      </div>

      <!-- Quick Preset Weightage Pills -->
      <div style="display: flex; gap: 6px; align-items: center; margin-bottom: 14px;">
        <span style="font-size: 11.5px; color: var(--color-slate-500);">Quick Presets:</span>
        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="document.getElementById('goalWeightInput').value=10">10%</button>
        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="document.getElementById('goalWeightInput').value=20">20%</button>
        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="document.getElementById('goalWeightInput').value=25">25%</button>
        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="document.getElementById('goalWeightInput').value=50">50%</button>
        <button type="button" class="btn btn-outline btn-sm" style="padding: 2px 7px; font-size: 11px;" onclick="document.getElementById('goalWeightInput').value=100">100%</button>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Scope / Description (Optional)</label>
        <textarea name="description" class="form-control" rows="2" placeholder="Specific deliverables, key milestones, or target dates..." style="font-size: 13px;"></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 10px; border-top: 1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddGoal').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Goal</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL 2: SUBMIT / EDIT SELF-ASSESSMENT -->
<div id="modalSelfAssessment" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(2px); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 620px; max-width: 92vw; max-height: 90vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
      <div>
        <h3 style="font-size: 17px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Self-Assessment Review</h3>
        <p style="font-size: 12.5px; color: var(--color-slate-500); margin: 2px 0 0 0;">
          Rate your milestone deliverables on a 1.0 to 5.0 scale (1 = Unsatisfactory, 3 = Meets Expectations, 5 = Outstanding).
        </p>
      </div>
      <button type="button" onclick="document.getElementById('modalSelfAssessment').style.display='none'" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);">&times;</button>
    </div>

    <form action="<?= site_url('performance/self-review') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="cycle_id" value="<?= esc($selectedCycleId) ?>">

      <?php if (!empty($myGoals)): ?>
        <div style="margin-bottom: 16px;">
          <label style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--color-slate-500); letter-spacing: 0.03em; display: block; margin-bottom: 8px;">
            Rate Individual Goals
          </label>
          <div style="display: flex; flex-direction: column; gap: 10px;">
            <?php foreach ($myGoals as $g): ?>
              <div style="padding: 12px; background: var(--bg-main, #f8fafc); border: 1px solid var(--border-color); border-radius: 8px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                  <strong style="font-size: 13.5px; color: var(--color-slate-900);"><?= esc($g['title']) ?></strong>
                  <span class="badge badge-primary" style="font-size: 11px;"><?= esc($g['weightage_percent']) ?>% Weight</span>
                </div>
                <div class="grid-2" style="gap: 10px;">
                  <div>
                    <label class="form-label" style="font-size: 11.5px; font-weight: 600; margin-bottom: 3px;">Score (1.0 &ndash; 5.0) *</label>
                    <input type="number" step="0.1" min="1.0" max="5.0" name="goal_ratings[<?= $g['id'] ?>]" class="form-control" value="<?= esc($g['self_rating'] ?? '4.0') ?>" required style="font-size: 13px;">
                  </div>
                  <div>
                    <label class="form-label" style="font-size: 11.5px; font-weight: 600; margin-bottom: 3px;">Self Comments / Proof</label>
                    <input type="text" name="goal_comments[<?= $g['id'] ?>]" class="form-control" value="<?= esc($g['self_comments'] ?? '') ?>" placeholder="Milestones completed..." style="font-size: 13px;">
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Overall Self-Assessment Score (1.0 to 5.0) *</label>
        <input type="number" step="0.1" min="1.0" max="5.0" name="overall_self_score" class="form-control" value="<?= esc($myAppraisal['overall_self_score'] ?? '4.2') ?>" required style="font-size: 13.5px; font-weight: 600;">
      </div>

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Key Strengths &amp; Highlights</label>
        <textarea name="key_strengths" class="form-control" rows="2" placeholder="Major accomplishments, leadership, high-impact contributions..." style="font-size: 13px;"><?= esc($myAppraisal['key_strengths'] ?? '') ?></textarea>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Growth Goals &amp; Development Needs</label>
        <textarea name="development_areas" class="form-control" rows="2" placeholder="Skills you wish to learn, certifications, or areas for improvement..." style="font-size: 13px;"><?= esc($myAppraisal['development_areas'] ?? '') ?></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 10px; border-top: 1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalSelfAssessment').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Self-Evaluation</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL 3: MANAGER REVIEW & APPRAISAL -->
<div id="modalManagerReview" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(2px); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 600px; max-width: 92vw; max-height: 90vh; overflow-y: auto; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
      <div>
        <h3 style="font-size: 17px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Manager Performance Evaluation</h3>
        <p style="font-size: 12.5px; color: var(--color-slate-500); margin: 2px 0 0 0;">
          Reviewing direct report: <strong id="mgrReviewEmpName" style="color: var(--color-primary);"></strong>
        </p>
      </div>
      <button type="button" onclick="document.getElementById('modalManagerReview').style.display='none'" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);">&times;</button>
    </div>

    <form action="<?= site_url('performance/manager-review') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="cycle_id" value="<?= esc($selectedCycleId) ?>">
      <input type="hidden" name="employee_id" id="mgrReviewEmpId" value="">

      <div class="grid-2" style="gap: 12px; margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Manager Rating (1.0 - 5.0) *</label>
          <input type="number" step="0.1" min="1.0" max="5.0" name="overall_manager_score" id="mgrReviewScore" class="form-control" value="4.0" required style="font-size: 13.5px; font-weight: 600;">
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Final Rating Band *</label>
          <select name="final_rating_band" id="mgrReviewBand" class="form-control" style="font-size: 13px;">
            <option value="Outstanding (Grade A)">Outstanding (Grade A)</option>
            <option value="Exceeds Expectations (Grade B)">Exceeds Expectations (Grade B)</option>
            <option value="Meets Expectations (Grade C)" selected>Meets Expectations (Grade C)</option>
            <option value="Needs Improvement (Grade D)">Needs Improvement (Grade D)</option>
            <option value="Unsatisfactory (Grade E)">Unsatisfactory (Grade E)</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="gap: 12px; margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Promotion Recommended?</label>
          <select name="promotion_recommended" id="mgrReviewPromo" class="form-control" style="font-size: 13px;">
            <option value="0">No - Retain in Current Role</option>
            <option value="1">Yes - Recommend for Promotion</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Recommended Increment (%)</label>
          <input type="number" step="0.5" min="0" max="100" name="recommended_increment_percent" id="mgrReviewInc" class="form-control" value="8.0" style="font-size: 13px;">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Key Strengths &amp; Commendations</label>
        <textarea name="key_strengths" class="form-control" rows="2" placeholder="Consistent reliability, technical excellence, team mentoring..." style="font-size: 13px;"></textarea>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Development Areas / Action Plan</label>
        <textarea name="development_areas" class="form-control" rows="2" placeholder="Initiative in cross-functional work, architectural planning..." style="font-size: 13px;"></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 10px; border-top: 1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalManagerReview').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Finalize Appraisal</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL 4: CREATE APPRAISAL CYCLE (HR ADMIN) -->
<div id="modalAddCycle" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(2px); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 520px; max-width: 92vw; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
      <h3 style="font-size: 17px; font-weight: 700; margin: 0; color: var(--color-slate-900);">Create Appraisal Cycle</h3>
      <button type="button" onclick="document.getElementById('modalAddCycle').style.display='none'" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);">&times;</button>
    </div>

    <form action="<?= site_url('performance/cycle') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Cycle Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. H2 Performance & Merit Cycle <?= date('Y') ?>" required style="font-size: 13px;">
      </div>

      <div class="grid-2" style="gap: 12px; margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Cycle Type</label>
          <select name="cycle_type" class="form-control" style="font-size: 13px;">
            <option value="annual">Annual Review</option>
            <option value="h1_h2" selected>Bi-Annual (H1/H2)</option>
            <option value="quarterly">Quarterly OKRs</option>
            <option value="probation">Probation Appraisal</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Cycle Status</label>
          <select name="status" class="form-control" style="font-size: 13px;">
            <option value="active" selected>Active</option>
            <option value="upcoming">Upcoming</option>
            <option value="closed">Closed</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="gap: 12px; margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Start Date *</label>
          <input type="date" name="start_date" class="form-control" value="<?= date('Y-04-01') ?>" required style="font-size: 13px;">
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">End Date *</label>
          <input type="date" name="end_date" class="form-control" value="<?= date((date('Y') + 1) . '-03-31') ?>" required style="font-size: 13px;">
        </div>
      </div>

      <div class="grid-2" style="gap: 12px; margin-bottom: 14px;">
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Self-Review Due Date</label>
          <input type="date" name="self_review_deadline" class="form-control" value="<?= date((date('Y') + 1) . '-03-15') ?>" style="font-size: 13px;">
        </div>
        <div class="form-group">
          <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Manager Review Due Date</label>
          <input type="date" name="manager_review_deadline" class="form-control" value="<?= date((date('Y') + 1) . '-03-25') ?>" style="font-size: 13px;">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label" style="font-size: 12.5px; font-weight: 600;">Description (Optional)</label>
        <textarea name="description" class="form-control" rows="2" placeholder="Brief note on objectives for this evaluation period..." style="font-size: 13px;"></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 10px; border-top: 1px solid var(--border-color);">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddCycle').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Create Cycle</button>
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
  document.getElementById('mgrReviewInc').value = inc || '8.0';
  document.getElementById('modalManagerReview').style.display = 'flex';
}

function filterTeamRoster() {
  const query = (document.getElementById('teamSearchInput').value || '').toLowerCase().trim();
  const rows = document.querySelectorAll('#teamRosterTable tbody tr.team-row');
  rows.forEach(r => {
    const text = r.innerText.toLowerCase();
    r.style.display = text.includes(query) ? '' : 'none';
  });
}
</script>
