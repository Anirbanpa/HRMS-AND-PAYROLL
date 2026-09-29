<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Employee Warning &amp; Disciplinary Records
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Formal warnings, incident investigations, Performance Improvement Plans (PIPs), suspensions, and confidential records.
    </p>
  </div>
  <div style="display: flex; gap: 8px; align-items: center;">
    <div style="display: flex; gap: 6px;">
      <a href="<?= site_url('disciplinary') ?>" class="badge <?= empty($_GET['action_type']) ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">All Cases</a>
      <a href="<?= site_url('disciplinary?action_type=written_warning') ?>" class="badge <?= ($_GET['action_type'] ?? '') === 'written_warning' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">Written Warnings</a>
      <a href="<?= site_url('disciplinary?action_type=pip') ?>" class="badge <?= ($_GET['action_type'] ?? '') === 'pip' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">Active PIPs</a>
      <a href="<?= site_url('disciplinary?action_type=suspension') ?>" class="badge <?= ($_GET['action_type'] ?? '') === 'suspension' ? 'badge-primary' : 'badge-secondary' ?>" style="text-decoration: none; padding: 6px 12px; font-size: 12px;">Suspensions</a>
    </div>
    <?php if ($isHR || $isManager): ?>
      <button type="button" class="btn btn-primary" onclick="document.getElementById('modalIssueDisciplinary').style.display='flex'">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: -2px; margin-right: 4px;"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        Issue Notice
      </button>
    <?php endif; ?>
  </div>
</div>

<!-- TOP KPI METRIC CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Warnings Issued</div>
      <div class="stat-value" style="color: #f59e0b;"><?= $warningCount ?></div>
      <div class="stat-subtext">Verbal, written &amp; final reprimands</div>
    </div>
    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Performance Plans (PIP)</div>
      <div class="stat-value" style="color: #6366f1;"><?= $pipCount ?></div>
      <div class="stat-subtext">Structured performance reviews</div>
    </div>
    <div class="stat-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Active Suspensions</div>
      <div class="stat-value" style="color: #ef4444;"><?= $suspensionCount ?></div>
      <div class="stat-subtext">Pending inquiry suspensions</div>
    </div>
    <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Cases Resolved</div>
      <div class="stat-value" style="color: #10b981;"><?= $closedCount ?></div>
      <div class="stat-subtext">Successfully settled &amp; archived</div>
    </div>
    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
  </div>
</div>

<!-- DISCIPLINARY ACTIONS ROSTER -->
<div class="card">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <div class="card-title">Confidential Disciplinary Action Records (<?= count($cases) ?>)</div>
      <span style="font-size: 12.5px; color: var(--color-slate-500);">Documented infractions, management directives, and employee acknowledgments</span>
    </div>
  </div>
  <div class="card-body" style="padding: 0;">
    <div class="table-responsive">
      <table class="table" style="margin-bottom: 0;">
        <thead>
          <tr>
            <th>Case # &amp; Date</th>
            <th>Employee</th>
            <th>Type &amp; Severity</th>
            <th>Infraction &amp; Directives</th>
            <th>Evidence</th>
            <th>Status</th>
            <th style="text-align: right;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($cases)): ?>
            <tr>
              <td colspan="7" style="text-align: center; color: var(--color-slate-500); padding: 32px;">
                No disciplinary actions or warning incidents logged.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($cases as $c): ?>
              <tr>
                <td>
                  <strong style="color: var(--color-slate-800); font-family: monospace; font-size: 12.5px;"><?= esc($c['case_number']) ?></strong>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);">
                    Incident: <?= date('M d, Y', strtotime($c['incident_date'])) ?>
                  </div>
                </td>
                <td>
                  <strong><?= esc($c['first_name'] . ' ' . $c['last_name']) ?></strong>
                  <div style="font-size: 11.5px; color: var(--color-slate-500);"><?= esc($c['employee_code']) ?> &bull; <?= esc($c['designation_name'] ?? 'Associate') ?></div>
                </td>
                <td>
                  <div>
                    <?php
                      $typeLabels = [
                        'verbal_warning' => ['Verbal Warning', '#f59e0b', 'rgba(245, 158, 11, 0.1)'],
                        'written_warning' => ['Written Warning', '#f97316', 'rgba(249, 115, 22, 0.1)'],
                        'final_warning' => ['Final Warning', '#ef4444', 'rgba(239, 68, 68, 0.1)'],
                        'pip' => ['Performance Plan (PIP)', '#6366f1', 'rgba(99, 102, 241, 0.1)'],
                        'suspension' => ['Suspension', '#b91c1c', 'rgba(185, 28, 28, 0.1)'],
                        'termination' => ['Termination Rec.', '#7f1d1d', 'rgba(127, 29, 29, 0.1)']
                      ];
                      $tInfo = $typeLabels[$c['action_type']] ?? [ucwords(str_replace('_', ' ', $c['action_type'])), '#64748b', 'rgba(100, 116, 139, 0.1)'];
                    ?>
                    <span style="font-size: 11.5px; font-weight: 700; padding: 3px 8px; border-radius: 4px; color: <?= $tInfo[1] ?>; background: <?= $tInfo[2] ?>;">
                      <?= $tInfo[0] ?>
                    </span>
                  </div>
                  <div style="margin-top: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 700; color: var(--color-slate-500);">
                    Severity: <span style="color: <?= $c['severity_level'] === 'critical' ? '#ef4444' : ($c['severity_level'] === 'severe' ? '#f97316' : '#64748b') ?>"><?= esc($c['severity_level']) ?></span>
                  </div>
                </td>
                <td style="max-width: 280px;">
                  <strong style="color: var(--color-slate-900); font-size: 13px;"><?= esc($c['title']) ?></strong>
                  <div style="font-size: 12px; color: var(--color-slate-600); margin-top: 2px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    <?= esc($c['description']) ?>
                  </div>
                  <?php if (!empty($c['pip_start_date'])): ?>
                    <div style="font-size: 11px; color: #6366f1; margin-top: 4px;">
                      PIP Period: <?= date('M d', strtotime($c['pip_start_date'])) ?> &rarr; <?= date('M d, Y', strtotime($c['pip_end_date'])) ?>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($c['suspension_days'])): ?>
                    <div style="font-size: 11px; color: #ef4444; margin-top: 4px;">
                      Suspension: <?= (int)$c['suspension_days'] ?> Calendar Days
                    </div>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if (!empty($c['attachment_path'])): ?>
                    <a href="<?= base_url($c['attachment_path']) ?>" target="_blank" class="btn btn-secondary" style="padding: 4px 8px; font-size: 11px; display: inline-flex; align-items: center; gap: 4px;">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                      Evidence
                    </a>
                  <?php else: ?>
                    <span style="font-size: 12px; color: var(--color-slate-400);">None</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($c['status'] === 'issued'): ?>
                    <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.3);">Issued / Unacknowledged</span>
                  <?php elseif ($c['status'] === 'acknowledged'): ?>
                    <span class="badge" style="background: rgba(99, 102, 241, 0.15); color: #4f46e5; border: 1px solid rgba(99, 102, 241, 0.3);">Acknowledged</span>
                    <div style="font-size: 10.5px; color: var(--color-slate-500); margin-top: 2px;">
                      <?= date('M d, H:i', strtotime($c['employee_acknowledged_at'])) ?>
                    </div>
                  <?php elseif ($c['status'] === 'closed'): ?>
                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.3);">Resolved &amp; Closed</span>
                  <?php else: ?>
                    <span class="badge badge-secondary"><?= esc(ucwords($c['status'])) ?></span>
                  <?php endif; ?>
                </td>
                <td style="text-align: right; white-space: nowrap;">
                  <button type="button" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;" onclick="viewCaseDetails(<?= htmlspecialchars(json_encode($c), ENT_QUOTES, 'UTF-8') ?>)">
                    Details
                  </button>
                  
                  <?php if ($currentEmpId && (int)$c['employee_id'] === (int)$currentEmpId && $c['status'] === 'issued'): ?>
                    <button type="button" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background: #6366f1; border-color: #6366f1; margin-left: 4px;" onclick="openAcknowledgeModal(<?= $c['id'] ?>, '<?= esc($c['case_number']) ?>')">
                      Acknowledge
                    </button>
                  <?php endif; ?>

                  <?php if ($isHR && $c['status'] !== 'closed'): ?>
                    <button type="button" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; color: #059669; border-color: #10b981; margin-left: 4px;" onclick="openCloseModal(<?= $c['id'] ?>, '<?= esc($c['case_number']) ?>')">
                      Close Case
                    </button>
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

<!-- MODAL: ISSUE DISCIPLINARY NOTICE -->
<?php if ($isHR || $isManager): ?>
<div id="modalIssueDisciplinary" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1050; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
  <div style="background: #ffffff; border-radius: 12px; width: 100%; max-width: 640px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); margin: 20px; max-height: 90vh; display: flex; flex-direction: column;">
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
      <h3 style="font-size: 17px; font-weight: 700; color: var(--color-slate-900); margin: 0; display: flex; align-items: center; gap: 8px;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        Issue Disciplinary Record / Warning
      </h3>
      <button type="button" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);" onclick="document.getElementById('modalIssueDisciplinary').style.display='none'">&times;</button>
    </div>
    <div style="padding: 24px; overflow-y: auto;">
      <form action="<?= site_url('disciplinary/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div style="margin-bottom: 16px;">
          <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Target Employee *</label>
          <select name="employee_id" class="form-control" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;">
            <option value="">-- Choose Employee --</option>
            <?php foreach ($employees as $emp): ?>
              <option value="<?= $emp['id'] ?>">
                <?= esc($emp['employee_code']) ?> - <?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="grid-2" style="gap: 16px; margin-bottom: 16px;">
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Action / Warning Type *</label>
            <select name="action_type" id="discActionType" class="form-control" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;" onchange="toggleDisciplinaryFields()">
              <option value="verbal_warning">Verbal Warning</option>
              <option value="written_warning" selected>Written Warning</option>
              <option value="final_warning">Final Warning</option>
              <option value="pip">Performance Improvement Plan (PIP)</option>
              <option value="suspension">Suspension</option>
              <option value="termination">Termination Recommendation</option>
            </select>
          </div>
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Severity Level *</label>
            <select name="severity_level" class="form-control" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;">
              <option value="minor">Minor</option>
              <option value="moderate" selected>Moderate</option>
              <option value="severe">Severe</option>
              <option value="critical">Critical</option>
            </select>
          </div>
        </div>

        <div class="grid-2" style="gap: 16px; margin-bottom: 16px;">
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Incident Date *</label>
            <input type="date" name="incident_date" class="form-control" value="<?= date('Y-m-d') ?>" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;">
          </div>
          <div>
            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Incident Subject / Title *</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Unexcused Absence / Conduct Breach" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;">
          </div>
        </div>

        <!-- CONDITIONAL PIP DATES -->
        <div id="pipFields" style="display: none; background: #f8fafc; border: 1px dashed var(--color-slate-300); padding: 12px; border-radius: 8px; margin-bottom: 16px;">
          <div style="font-size: 12px; font-weight: 700; color: #6366f1; margin-bottom: 8px;">PIP Timeline Configuration</div>
          <div class="grid-2" style="gap: 12px;">
            <div>
              <label style="display: block; font-size: 12px; color: var(--color-slate-600); margin-bottom: 4px;">PIP Start Date</label>
              <input type="date" name="pip_start_date" class="form-control" value="<?= date('Y-m-d') ?>" style="width: 100%; padding: 6px 10px; font-size: 12px;">
            </div>
            <div>
              <label style="display: block; font-size: 12px; color: var(--color-slate-600); margin-bottom: 4px;">PIP Target End Date</label>
              <input type="date" name="pip_end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+30 days')) ?>" style="width: 100%; padding: 6px 10px; font-size: 12px;">
            </div>
          </div>
        </div>

        <!-- CONDITIONAL SUSPENSION DAYS -->
        <div id="suspensionFields" style="display: none; background: #fef2f2; border: 1px dashed #fca5a5; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
          <label style="display: block; font-size: 12px; font-weight: 700; color: #ef4444; margin-bottom: 4px;">Suspension Duration (Days)</label>
          <input type="number" name="suspension_days" min="1" max="90" placeholder="e.g. 7" class="form-control" style="width: 100%; padding: 6px 10px; font-size: 12px;">
        </div>

        <div style="margin-bottom: 16px;">
          <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Infraction &amp; Findings Description *</label>
          <textarea name="description" rows="3" class="form-control" placeholder="Provide factual context, witnesses, policy violation details..." required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;"></textarea>
        </div>

        <div style="margin-bottom: 16px;">
          <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Remedial Directive / Action Taken *</label>
          <textarea name="action_taken" rows="2" class="form-control" placeholder="Mandatory corrective behavior, performance expectations..." required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;"></textarea>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Evidence Attachment (PDF, Image, Document)</label>
          <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="width: 100%; padding: 6px 10px; border: 1px solid var(--color-slate-300); border-radius: 6px;">
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalIssueDisciplinary').style.display='none'">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background: #ef4444; border-color: #ef4444;">Issue &amp; Dispatch Notice</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- MODAL: VIEW CASE DETAILS -->
<div id="modalCaseDetails" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1050; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
  <div style="background: #ffffff; border-radius: 12px; width: 100%; max-width: 600px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); margin: 20px; max-height: 90vh; display: flex; flex-direction: column;">
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
      <h3 style="font-size: 17px; font-weight: 700; color: var(--color-slate-900); margin: 0;">
        Case Dossier: <span id="viewCaseNumber" style="font-family: monospace; color: #4f46e5;"></span>
      </h3>
      <button type="button" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);" onclick="document.getElementById('modalCaseDetails').style.display='none'">&times;</button>
    </div>
    <div style="padding: 24px; overflow-y: auto;" id="viewCaseBody">
      <!-- Dynamic populated -->
    </div>
    <div style="padding: 14px 24px; border-top: 1px solid var(--color-slate-200); text-align: right;">
      <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalCaseDetails').style.display='none'">Close</button>
    </div>
  </div>
</div>

<!-- MODAL: EMPLOYEE ACKNOWLEDGMENT -->
<div id="modalAcknowledge" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1050; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
  <div style="background: #ffffff; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); margin: 20px;">
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
      <h3 style="font-size: 17px; font-weight: 700; color: var(--color-slate-900); margin: 0;">
        Acknowledge Disciplinary Notice
      </h3>
      <button type="button" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);" onclick="document.getElementById('modalAcknowledge').style.display='none'">&times;</button>
    </div>
    <div style="padding: 24px;">
      <form id="formAcknowledge" method="POST" action="">
        <?= csrf_field() ?>
        <p style="font-size: 13.5px; color: var(--color-slate-600); line-height: 1.5; margin-bottom: 16px;">
          By acknowledging, you confirm receipt and understanding of Case <strong id="ackCaseNum"></strong>. You may provide a formal counter-statement or explanation below for the permanent record.
        </p>

        <div style="margin-bottom: 18px;">
          <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">Employee Statement / Explanation (Optional)</label>
          <textarea name="employee_explanation" rows="4" class="form-control" placeholder="Enter your response, clarification, or corrective commitment..." style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;"></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAcknowledge').style.display='none'">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background: #4f46e5; border-color: #4f46e5;">Digitally Sign &amp; Acknowledge</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL: CLOSE DISCIPLINARY CASE -->
<?php if ($isHR): ?>
<div id="modalCloseCase" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1050; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
  <div style="background: #ffffff; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); margin: 20px;">
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
      <h3 style="font-size: 17px; font-weight: 700; color: var(--color-slate-900); margin: 0;">
        Conclude &amp; Close Case
      </h3>
      <button type="button" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--color-slate-400);" onclick="document.getElementById('modalCloseCase').style.display='none'">&times;</button>
    </div>
    <div style="padding: 24px;">
      <form id="formCloseCase" method="POST" action="">
        <?= csrf_field() ?>
        <p style="font-size: 13.5px; color: var(--color-slate-600); margin-bottom: 16px;">
          Mark Case <strong id="closeCaseNum"></strong> as resolved and archived into the confidential HR repository.
        </p>

        <div style="margin-bottom: 18px;">
          <label style="display: block; font-size: 13px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 6px;">HR Resolution &amp; Closure Notes *</label>
          <textarea name="closure_notes" rows="3" class="form-control" placeholder="e.g. Employee completed 30-day PIP with satisfactory rating..." required style="width: 100%; padding: 8px 12px; border: 1px solid var(--color-slate-300); border-radius: 6px;"></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalCloseCase').style.display='none'">Cancel</button>
          <button type="submit" class="btn btn-primary" style="background: #059669; border-color: #059669;">Confirm Closure</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
function toggleDisciplinaryFields() {
  const val = document.getElementById('discActionType').value;
  const pipDiv = document.getElementById('pipFields');
  const suspDiv = document.getElementById('suspensionFields');

  if (pipDiv) pipDiv.style.display = (val === 'pip') ? 'block' : 'none';
  if (suspDiv) suspDiv.style.display = (val === 'suspension') ? 'block' : 'none';
}

function viewCaseDetails(c) {
  document.getElementById('viewCaseNumber').innerText = c.case_number;
  
  let html = `
    <div style="margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
      <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-slate-500); font-weight: 700;">Employee Information</div>
      <div style="font-size: 14px; font-weight: 700; color: var(--color-slate-900); margin-top: 2px;">${c.first_name} ${c.last_name} (${c.employee_code})</div>
      <div style="font-size: 12.5px; color: var(--color-slate-600);">${c.designation_name || 'Associate'} &bull; ${c.department_name || 'Department'}</div>
    </div>

    <div style="margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
      <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-slate-500); font-weight: 700;">Infraction Subject</div>
      <div style="font-size: 14px; font-weight: 700; color: #b91c1c; margin-top: 2px;">${c.title}</div>
      <div style="font-size: 13px; color: var(--color-slate-700); margin-top: 6px; white-space: pre-wrap; line-height: 1.5;">${c.description}</div>
    </div>

    <div style="margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
      <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-slate-500); font-weight: 700;">Action Taken / Directives</div>
      <div style="font-size: 13px; color: var(--color-slate-800); margin-top: 4px; line-height: 1.5;">${c.action_taken}</div>
    </div>
  `;

  if (c.attachment_path) {
    html += `
      <div style="margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-slate-500); font-weight: 700;">Attached Evidence</div>
        <div style="margin-top: 4px;">
          <a href="<?= base_url() ?>/${c.attachment_path}" target="_blank" class="btn btn-secondary" style="font-size: 12px; padding: 4px 10px;">Download / View Attached Document</a>
        </div>
      </div>
    `;
  }

  if (c.employee_acknowledged_at) {
    html += `
      <div style="margin-bottom: 16px; background: #f8fafc; border-left: 3px solid #6366f1; padding: 10px 14px; border-radius: 4px;">
        <div style="font-size: 11px; font-weight: 700; color: #4f46e5; text-transform: uppercase;">Employee Acknowledgment (${c.employee_acknowledged_at})</div>
        <div style="font-size: 12.5px; color: var(--color-slate-700); margin-top: 4px; font-style: italic;">
          ${c.employee_explanation ? '"' + c.employee_explanation + '"' : 'Acknowledged with no remarks.'}
        </div>
      </div>
    `;
  }

  if (c.closed_at) {
    html += `
      <div style="background: #f0fdf4; border-left: 3px solid #10b981; padding: 10px 14px; border-radius: 4px;">
        <div style="font-size: 11px; font-weight: 700; color: #059669; text-transform: uppercase;">HR Case Closure Notes (${c.closed_at})</div>
        <div style="font-size: 12.5px; color: var(--color-slate-700); margin-top: 4px;">
          ${c.closure_notes || 'Case concluded successfully.'}
        </div>
      </div>
    `;
  }

  document.getElementById('viewCaseBody').innerHTML = html;
  document.getElementById('modalCaseDetails').style.display = 'flex';
}

function openAcknowledgeModal(id, caseNum) {
  document.getElementById('ackCaseNum').innerText = caseNum;
  document.getElementById('formAcknowledge').action = '<?= site_url('disciplinary/acknowledge') ?>/' + id;
  document.getElementById('modalAcknowledge').style.display = 'flex';
}

function openCloseModal(id, caseNum) {
  document.getElementById('closeCaseNum').innerText = caseNum;
  document.getElementById('formCloseCase').action = '<?= site_url('disciplinary/close') ?>/' + id;
  document.getElementById('modalCloseCase').style.display = 'flex';
}
</script>
