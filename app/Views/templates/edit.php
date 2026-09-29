<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <div style="margin-bottom: 8px;">
      <a href="<?= site_url('templates') ?>" class="btn btn-outline btn-sm">&larr; Back to Templates</a>
    </div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--text-main); margin: 0 0 4px 0;">Edit Document Template</h2>
    <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Modify template parameters, dynamic token substitutions, and document body.</p>
  </div>
</div>

<div class="card" style="max-width: 900px;">
  <div class="card-header" style="border-bottom: 1px solid var(--border-color);">
    <div style="display: flex; align-items: center; gap: 10px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(140, 122, 169, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      </div>
      <div>
        <div class="card-title"><?= esc($template['name']) ?></div>
        <div style="font-size: 12px; color: var(--text-muted);">Code: <code><?= esc($template['template_code']) ?></code></div>
      </div>
    </div>
  </div>

  <div style="padding: 24px;">
    <form action="<?= site_url('templates/update/' . $template['id']) ?>" method="POST">
      <?= csrf_field() ?>

      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
        <div class="form-group">
          <label class="form-label" for="tpl_name">Template Name *</label>
          <input type="text" name="name" id="tpl_name" class="form-control" value="<?= esc($template['name']) ?>" required placeholder="e.g. Standard Offer Letter">
        </div>

        <div class="form-group">
          <label class="form-label" for="tpl_code">Template Code *</label>
          <input type="text" name="template_code" id="tpl_code" class="form-control" value="<?= esc($template['template_code']) ?>" required placeholder="e.g. TPL_OFFER_LETTER">
        </div>
      </div>

      <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 18px;">
        <div class="form-group">
          <label class="form-label" for="tpl_category">Document Category *</label>
          <select name="category" id="tpl_category" class="form-control" required>
            <option value="offer_letter" <?= ($template['category'] === 'offer_letter') ? 'selected' : '' ?>>Offer Letter</option>
            <option value="appointment_letter" <?= ($template['category'] === 'appointment_letter') ? 'selected' : '' ?>>Appointment Letter</option>
            <option value="experience_certificate" <?= ($template['category'] === 'experience_certificate') ? 'selected' : '' ?>>Experience Certificate</option>
            <option value="relieving_letter" <?= ($template['category'] === 'relieving_letter') ? 'selected' : '' ?>>Relieving Letter</option>
            <option value="increment_letter" <?= ($template['category'] === 'increment_letter') ? 'selected' : '' ?>>Increment Letter</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="tpl_status">Template Status *</label>
          <select name="is_active" id="tpl_status" class="form-control" required>
            <option value="1" <?= (!empty($template['is_active'])) ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= (empty($template['is_active'])) ? 'selected' : '' ?>>Inactive</option>
          </select>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 18px;">
        <label class="form-label" for="tpl_subject">Email / Document Subject *</label>
        <input type="text" name="subject" id="tpl_subject" class="form-control" value="<?= esc($template['subject']) ?>" required placeholder="e.g. Offer of Employment at {{COMPANY_NAME}}">
      </div>

      <div class="form-group" style="margin-bottom: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
          <label class="form-label" for="tpl_body" style="margin-bottom: 0;">Template Body (HTML Supported) *</label>
          <span style="font-size: 12px; color: var(--text-muted);">Use token tags to auto-fill employee details</span>
        </div>
        <textarea name="body_content" id="tpl_body" class="form-control" rows="12" style="font-family: monospace; font-size: 13px; line-height: 1.6;" required><?= esc($template['body_content']) ?></textarea>
      </div>

      <!-- Token Chips Helper -->
      <div style="background: var(--bg-card-subtle); border: 1px solid var(--border-color); padding: 14px; border-radius: 8px; margin-bottom: 24px;">
        <div style="font-size: 12px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
          Available Dynamic Tokens (Click to insert into body):
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
          <?php 
            $tokensList = ['{{EMPLOYEE_NAME}}', '{{EMPLOYEE_CODE}}', '{{DESIGNATION}}', '{{DEPARTMENT}}', '{{JOIN_DATE}}', '{{GROSS_SALARY}}', '{{COMPANY_NAME}}', '{{TODAY_DATE}}'];
            foreach ($tokensList as $t): 
          ?>
            <button type="button" class="date-chip" onclick="insertToken('<?= $t ?>')">
              <?= $t ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); padding-top: 18px;">
        <a href="<?= site_url('templates/delete/' . $template['id']) ?>" 
           class="btn btn-danger" 
           onclick="return confirm('Are you sure you want to delete this template?');">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
          Delete Template
        </a>

        <div style="display: flex; gap: 10px;">
          <a href="<?= site_url('templates') ?>" class="btn btn-outline">Cancel</a>
          <button type="submit" class="btn btn-primary" style="font-weight: 700;">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function insertToken(token) {
  const textarea = document.getElementById('tpl_body');
  if (!textarea) return;
  const start = textarea.selectionStart;
  const end = textarea.selectionEnd;
  const text = textarea.value;
  textarea.value = text.substring(0, start) + token + text.substring(end);
  textarea.focus();
  textarea.selectionStart = textarea.selectionEnd = start + token.length;
}
</script>
