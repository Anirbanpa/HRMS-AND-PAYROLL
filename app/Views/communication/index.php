<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Communication &amp; Notification Broadcast Center
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Broadcast organizational announcements and configure multi-channel templates (Email, SMS, WhatsApp, In-App).
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <button type="button" class="btn btn-outline" onclick="document.getElementById('modalTestDispatch').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
      Test Dispatcher (Email/SMS/WhatsApp)
    </button>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalAddAnnouncement').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Broadcast Announcement
    </button>
  </div>
</div>

<div class="grid-3" style="margin-bottom: 24px;">
  <!-- ACTIVE ANNOUNCEMENTS -->
  <div class="card" style="grid-column: span 2;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 14px;">Active Enterprise Announcements</h3>

    <?php if (empty($announcements)): ?>
      <div style="text-align: center; color: var(--color-slate-500); padding: 24px;">
        No active announcements. Click 'Broadcast Announcement' to publish news.
      </div>
    <?php else: ?>
      <div style="display: flex; flex-direction: column; gap: 12px;">
        <?php foreach ($announcements as $ann): ?>
          <div style="padding: 14px; background: var(--color-slate-50); border-radius: 8px; border-left: 4px solid <?= ($ann['priority'] === 'urgent') ? 'var(--color-rose-500)' : 'var(--color-primary)' ?>;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
              <h4 style="font-size: 15px; font-weight: 700; margin: 0;"><?= esc($ann['title']) ?></h4>
              <span class="badge <?= ($ann['priority'] === 'urgent') ? 'badge-danger' : 'badge-info' ?>" style="font-size: 10.5px; text-transform: uppercase;">
                <?= esc($ann['priority']) ?>
              </span>
            </div>
            <p style="font-size: 13px; color: var(--color-slate-700); margin-bottom: 8px;">
              <?= nl2br(esc($ann['content'])) ?>
            </p>
            <div style="font-size: 11.5px; color: var(--color-slate-400);">
              Published on <?= date('M j, Y H:i', strtotime($ann['published_at'])) ?> by <?= esc($ann['publisher_name'] ?? 'HR Admin') ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- NOTIFICATION TEMPLATES -->
  <div class="card" style="grid-column: span 1;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px;">Automated Templates</h3>
    <div style="display: flex; flex-direction: column; gap: 10px;">
      <?php foreach ($templates as $tpl): ?>
        <div style="padding: 10px 12px; background: var(--color-slate-50); border-radius: 6px; border: 1px solid var(--color-slate-200);">
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <strong style="font-size: 13px;"><?= esc($tpl['title']) ?></strong>
            <span class="badge badge-secondary" style="font-size: 10px;"><?= esc($tpl['channel']) ?></span>
          </div>
          <div style="font-size: 11px; color: var(--color-slate-400); margin-top: 4px;">
            Key: <code><?= esc($tpl['template_key']) ?></code>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- MODAL: BROADCAST ANNOUNCEMENT -->
<div id="modalAddAnnouncement" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 500px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Broadcast Announcement</h3>
      <button type="button" onclick="document.getElementById('modalAddAnnouncement').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('communication/announcement') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Subject / Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Annual Company Town Hall Announcement" required>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Target Audience</label>
          <select name="target_audience" class="form-control">
            <option value="all">All Employees</option>
            <option value="department">Specific Department</option>
            <option value="branch">Specific Branch</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Priority</label>
          <select name="priority" class="form-control">
            <option value="normal">Normal</option>
            <option value="urgent">Urgent Alert</option>
            <option value="low">Low Priority</option>
          </select>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Message Content *</label>
        <textarea name="content" class="form-control" rows="4" placeholder="Write announcement details..." required></textarea>
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalAddAnnouncement').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Broadcast News</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: TEST MULTI-CHANNEL DISPATCH -->
<div id="modalTestDispatch" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 520px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <h3 style="font-size: 18px; font-weight: 700;">Test Multi-Channel Dispatcher</h3>
      <button type="button" onclick="document.getElementById('modalTestDispatch').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <form action="<?= site_url('communication/test-dispatch') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Notification Template *</label>
        <select name="template_key" class="form-control" required>
          <?php foreach ($templates as $tpl): ?>
            <option value="<?= esc($tpl['template_key']) ?>"><?= esc($tpl['title']) ?> (<?= esc($tpl['template_key']) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Recipient Employee *</label>
        <select name="employee_id" class="form-control" required>
          <?php foreach ($employees as $emp): ?>
            <option value="<?= (int)$emp['id'] ?>"><?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= esc($emp['employee_code']) ?> &bull; <?= esc($emp['official_email'] ?: $emp['email']) ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 14px;">
        <label class="form-label">Delivery Channels (Select one or more) *</label>
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 6px;">
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; padding: 8px 12px; background: var(--color-slate-50); border: 1px solid var(--color-slate-200); border-radius: 6px;">
            <input type="checkbox" name="channels[]" value="in_app" checked>
            <span>In-App Notification</span>
          </label>
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; padding: 8px 12px; background: var(--color-slate-50); border: 1px solid var(--color-slate-200); border-radius: 6px;">
            <input type="checkbox" name="channels[]" value="email" checked>
            <span>Email Alert</span>
          </label>
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; padding: 8px 12px; background: var(--color-slate-50); border: 1px solid var(--color-slate-200); border-radius: 6px;">
            <input type="checkbox" name="channels[]" value="sms">
            <span>SMS Message</span>
          </label>
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer; padding: 8px 12px; background: var(--color-slate-50); border: 1px solid var(--color-slate-200); border-radius: 6px;">
            <input type="checkbox" name="channels[]" value="whatsapp">
            <span>WhatsApp Notification</span>
          </label>
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-label">Event Details Parameter ({{DETAILS}})</label>
        <input type="text" name="details" class="form-control" placeholder="e.g. Approved leave for 2 days from Oct 12">
      </div>

      <div style="display: flex; justify-content: flex-end; gap: 10px;">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('modalTestDispatch').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Dispatch Notification</button>
      </div>
    </form>
  </div>
</div>

