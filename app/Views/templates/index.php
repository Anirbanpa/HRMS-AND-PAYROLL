<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">HR Document Templates &amp; Letter Builder</h2>
    <p style="color: #64748b; font-size: 14px; margin: 0;">Generate dynamic offer letters, experience certificates, and increment letters with automated token substitution.</p>
  </div>
  <div>
    <button class="btn btn-outline" onclick="document.getElementById('modalCreateTpl').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Create New Template
    </button>
  </div>
</div>

<!-- QUICK DOCUMENT GENERATOR CARD -->
<div class="card" style="margin-bottom: 28px; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 4px solid #2563eb;">
  <div class="card-header" style="border-bottom: 1px solid #e2e8f0;">
    <div style="display: flex; align-items: center; gap: 10px;">
      <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(37,99,235,0.1); color: #2563eb; display: flex; align-items: center; justify-content: center;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
      </div>
      <div>
        <div class="card-title">Instant Letter &amp; Certificate Generator</div>
        <div style="font-size: 12px; color: #64748b;">Select an employee and standard template to render a fully populated, print-ready document</div>
      </div>
    </div>
  </div>

  <div style="padding: 24px;">
    <form action="<?= site_url('templates/generate') ?>" method="POST" target="_blank" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 16px; align-items: flex-end;">
      <?= csrf_field() ?>
      <div class="form-group">
        <label class="form-label">1. Choose Template *</label>
        <select name="template_id" class="form-control" required>
          <option value="">-- Select Template --</option>
          <?php foreach ($templates as $t): ?>
            <option value="<?= $t['id'] ?>"><?= esc($t['name']) ?> (<?= esc($t['template_code']) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">2. Target Employee *</label>
        <select name="employee_id" class="form-control" required>
          <option value="">-- Select Target Employee --</option>
          <?php foreach ($employees as $emp): ?>
            <option value="<?= $emp['id'] ?>"><?= esc($emp['employee_code']) ?> - <?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <button type="submit" class="btn btn-primary" style="height: 42px; padding: 0 24px; font-weight: 700;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
          Generate &amp; Preview
        </button>
      </div>
    </form>
  </div>
</div>

<!-- TEMPLATES DIRECTORY TABLE -->
<div class="card">
  <div class="card-header" style="border-bottom: 1px solid #e2e8f0;">
    <div class="card-title">Configured Document Templates (<?= count($templates) ?>)</div>
  </div>

  <div style="padding: 20px;">
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Template Code</th>
            <th>Name &amp; Category</th>
            <th>Default Subject</th>
            <th>Supported Tokens</th>
            <th>Status</th>
            <th style="text-align: right; width: 170px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($templates as $tpl): ?>
            <tr>
              <td><code><?= esc($tpl['template_code']) ?></code></td>
              <td>
                <div style="font-weight: 700; color: var(--text-main);"><?= esc($tpl['name']) ?></div>
                <span class="badge" style="background: var(--bg-card-subtle); color: var(--text-muted); text-transform: uppercase; font-size: 10px; border: 1px solid var(--border-color);">
                  <?= esc(str_replace('_', ' ', $tpl['category'])) ?>
                </span>
              </td>
              <td style="color: var(--text-main); font-size: 13px;"><?= esc($tpl['subject']) ?></td>
              <td>
                <div style="font-size: 11px; color: var(--text-muted); max-width: 300px; line-height: 1.4;">
                  <?= esc($tpl['available_tokens']) ?>
                </div>
              </td>
              <td>
                <?php if (!empty($tpl['is_active']) || !isset($tpl['is_active'])): ?>
                  <span class="badge badge-success">Active</span>
                <?php else: ?>
                  <span class="badge badge-danger">Inactive</span>
                <?php endif; ?>
              </td>
              <td style="text-align: right; white-space: nowrap;">
                <div style="display: inline-flex; align-items: center; justify-content: flex-end; gap: 6px;">
                  <button type="button" 
                          class="btn btn-sm btn-outline" 
                          onclick='openEditTemplateModal(<?= json_encode($tpl, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'
                          style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; font-weight: 600;"
                          title="Edit Template">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                      <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Edit</span>
                  </button>

                  <a href="<?= site_url('templates/delete/' . $tpl['id']) ?>" 
                     class="btn btn-sm btn-danger" 
                     onclick="return confirm('Are you sure you want to delete template \'<?= esc($tpl['name'], 'js') ?>\' (<?= esc($tpl['template_code'], 'js') ?>)? This cannot be undone.');"
                     style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; font-weight: 600;"
                     title="Delete Template">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <polyline points="3 6 5 6 21 6"></polyline>
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                      <line x1="10" y1="11" x2="10" y2="17"></line>
                      <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    <span>Delete</span>
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL: CREATE TEMPLATE -->
<div id="modalCreateTpl" class="modal-overlay" style="display: none;" onclick="if(event.target === this) this.style.display='none'">
  <div class="modal-content" style="max-width: 680px;">
    <div class="modal-header">
      <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(140, 122, 169, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </div>
        <h3 class="modal-title">Create HR Document Template</h3>
      </div>
      <button type="button" class="modal-close" onclick="document.getElementById('modalCreateTpl').style.display='none'">&times;</button>
    </div>
    <form action="<?= site_url('templates/store') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Template Name *</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Relieving & Experience Certificate">
          </div>
          <div class="form-group">
            <label class="form-label">Category *</label>
            <select name="category" class="form-control" required>
              <option value="offer_letter">Offer Letter</option>
              <option value="appointment_letter">Appointment Letter</option>
              <option value="experience_certificate">Experience Certificate</option>
              <option value="relieving_letter">Relieving Letter</option>
              <option value="increment_letter">Increment Letter</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Email / Document Subject *</label>
          <input type="text" name="subject" class="form-control" required placeholder="Offer of Employment at {{COMPANY_NAME}}">
        </div>

        <div class="form-group">
          <label class="form-label">Template Body (HTML supported) *</label>
          <textarea name="body_content" class="form-control" rows="8" required placeholder="<p>Dear {{EMPLOYEE_NAME}},</p><p>We are pleased to inform you that your designation has been revised to {{DESIGNATION}}...</p>"></textarea>
        </div>

        <div style="background: rgba(140, 122, 169, 0.1); border: 1px solid var(--border-color); padding: 10px 14px; border-radius: 6px; font-size: 11.5px; color: var(--text-main);">
          <strong>Dynamic Token Tags:</strong> <code>{{EMPLOYEE_NAME}}</code>, <code>{{EMPLOYEE_CODE}}</code>, <code>{{DESIGNATION}}</code>, <code>{{DEPARTMENT}}</code>, <code>{{JOIN_DATE}}</code>, <code>{{GROSS_SALARY}}</code>, <code>{{COMPANY_NAME}}</code>, <code>{{TODAY_DATE}}</code>.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalCreateTpl').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary" style="font-weight: 700;">Save Template</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: EDIT TEMPLATE -->
<div id="modalEditTpl" class="modal-overlay" style="display: none;" onclick="if(event.target === this) closeEditTemplateModal()">
  <div class="modal-content" style="max-width: 680px;">
    <div class="modal-header">
      <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(140, 122, 169, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <h3 class="modal-title">Edit Document Template</h3>
      </div>
      <button type="button" class="modal-close" onclick="closeEditTemplateModal()">&times;</button>
    </div>
    <form id="formEditTemplate" action="" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label" for="edit_tpl_name">Template Name *</label>
            <input type="text" name="name" id="edit_tpl_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="edit_tpl_code">Template Code *</label>
            <input type="text" name="template_code" id="edit_tpl_code" class="form-control" required>
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label" for="edit_tpl_category">Document Category *</label>
            <select name="category" id="edit_tpl_category" class="form-control" required>
              <option value="offer_letter">Offer Letter</option>
              <option value="appointment_letter">Appointment Letter</option>
              <option value="experience_certificate">Experience Certificate</option>
              <option value="relieving_letter">Relieving Letter</option>
              <option value="increment_letter">Increment Letter</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label" for="edit_tpl_status">Status *</label>
            <select name="is_active" id="edit_tpl_status" class="form-control" required>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="edit_tpl_subject">Email / Document Subject *</label>
          <input type="text" name="subject" id="edit_tpl_subject" class="form-control" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="edit_tpl_body">Template Body (HTML Supported) *</label>
          <textarea name="body_content" id="edit_tpl_body" class="form-control" rows="10" required></textarea>
        </div>

        <div style="background: rgba(140, 122, 169, 0.1); border: 1px solid var(--border-color); padding: 10px 14px; border-radius: 6px; font-size: 11.5px; color: var(--text-main);">
          <strong>Dynamic Token Tags:</strong> <code>{{EMPLOYEE_NAME}}</code>, <code>{{EMPLOYEE_CODE}}</code>, <code>{{DESIGNATION}}</code>, <code>{{DEPARTMENT}}</code>, <code>{{JOIN_DATE}}</code>, <code>{{GROSS_SALARY}}</code>, <code>{{COMPANY_NAME}}</code>, <code>{{TODAY_DATE}}</code>.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="closeEditTemplateModal()">Cancel</button>
        <button type="submit" class="btn btn-primary" style="font-weight: 700;">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEditTemplateModal(tpl) {
  if (!tpl) return;
  const updateUrl = '<?= site_url('templates/update') ?>/' + tpl.id;
  document.getElementById('formEditTemplate').action = updateUrl;
  document.getElementById('edit_tpl_name').value = tpl.name || '';
  document.getElementById('edit_tpl_code').value = tpl.template_code || '';
  document.getElementById('edit_tpl_category').value = tpl.category || 'offer_letter';
  document.getElementById('edit_tpl_status').value = (tpl.is_active !== undefined && tpl.is_active !== null) ? tpl.is_active : 1;
  document.getElementById('edit_tpl_subject').value = tpl.subject || '';
  document.getElementById('edit_tpl_body').value = tpl.body_content || '';
  document.getElementById('modalEditTpl').style.display = 'flex';
}

function closeEditTemplateModal() {
  document.getElementById('modalEditTpl').style.display = 'none';
}
</script>
