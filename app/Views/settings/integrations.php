<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      System Integrations &amp; API Credentials
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Manage production credentials for Email SMTP, SMS Gateways, WhatsApp Cloud API, and Biometric Hardware Webhooks.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <a href="<?= site_url('settings/backup') ?>" class="btn btn-secondary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
      Database Backup Hub
    </a>
  </div>
</div>

<div class="grid-2" style="margin-bottom: 24px;">
  
  <!-- 1. SMTP EMAIL GATEWAY -->
  <div class="card" style="border-top: 3px solid #2563eb;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--color-slate-100); padding-bottom: 12px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(37,99,235,0.1); color: #2563eb; display: flex; align-items: center; justify-content: center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <div>
          <h3 style="font-size: 16px; font-weight: 700; color: var(--color-slate-900);">Email SMTP Gateway</h3>
          <div style="font-size: 12px; color: var(--color-slate-500);">Payslips, Leave Approvals &amp; System Alerts</div>
        </div>
      </div>
      <span class="badge badge-success">Connected</span>
    </div>

    <form action="<?= site_url('settings/integrations/save') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="channel" value="Email SMTP">

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">SMTP Host</label>
          <input type="text" name="smtp_host" class="form-control" value="<?= esc($settings['smtp_host']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">SMTP Port</label>
          <input type="number" name="smtp_port" class="form-control" value="<?= esc($settings['smtp_port']) ?>" required>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">SMTP Username / Email</label>
          <input type="text" name="smtp_user" class="form-control" value="<?= esc($settings['smtp_user']) ?>" required>
        </div>
        <div class="form-group">
          <label class="form-label">Encryption Protocol</label>
          <select name="smtp_crypto" class="form-control">
            <option value="tls" <?= ($settings['smtp_crypto'] === 'tls') ? 'selected' : '' ?>>TLS (Recommended: Port 587)</option>
            <option value="ssl" <?= ($settings['smtp_crypto'] === 'ssl') ? 'selected' : '' ?>>SSL (Port 465)</option>
            <option value="none">None / Plain</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="margin-bottom: 16px;">
        <div class="form-group">
          <label class="form-label">Sender Display Name</label>
          <input type="text" name="smtp_from_name" class="form-control" value="<?= esc($settings['smtp_from_name']) ?>">
        </div>
        <div class="form-group">
          <label class="form-label">Sender Email Address</label>
          <input type="email" name="smtp_from_email" class="form-control" value="<?= esc($settings['smtp_from_email']) ?>">
        </div>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-slate-100); padding-top: 14px;">
        <button type="button" class="btn btn-secondary btn-sm" onclick="testChannel('smtp')">
          Test Handshake
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
          Save Credentials
        </button>
      </div>
    </form>
  </div>

  <!-- 2. SMS GATEWAY -->
  <div class="card" style="border-top: 3px solid #f59e0b;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--color-slate-100); padding-bottom: 12px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(245,158,11,0.1); color: #d97706; display: flex; align-items: center; justify-content: center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </div>
        <div>
          <h3 style="font-size: 16px; font-weight: 700; color: var(--color-slate-900);">SMS Gateway (Twilio / Cloud)</h3>
          <div style="font-size: 12px; color: var(--color-slate-500);">OTP verification, emergency broadcasts, &amp; roster alerts</div>
        </div>
      </div>
      <span class="badge badge-success">Ready</span>
    </div>

    <form action="<?= site_url('settings/integrations/save') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="channel" value="SMS Gateway">

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">SMS Provider</label>
          <select name="sms_provider" class="form-control">
            <option value="twilio" selected>Twilio Programmable Messaging</option>
            <option value="fast2sms">Fast2SMS Gateway</option>
            <option value="msg91">MSG91 Enterprise</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Approved Sender ID</label>
          <input type="text" name="sms_sender_id" class="form-control" value="<?= esc($settings['sms_sender_id']) ?>">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Account SID / API Key</label>
        <input type="text" name="sms_account_sid" class="form-control" value="<?= esc($settings['sms_account_sid']) ?>" style="font-family: monospace;">
      </div>

      <div class="form-group" style="margin-bottom: 16px;">
        <label class="form-label">Auth Token / Secret</label>
        <input type="password" name="sms_auth_token" class="form-control" value="<?= esc($settings['sms_auth_token']) ?>" style="font-family: monospace;">
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-slate-100); padding-top: 14px;">
        <button type="button" class="btn btn-secondary btn-sm" onclick="testChannel('sms')">
          Test SMS Handshake
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
          Save Credentials
        </button>
      </div>
    </form>
  </div>

  <!-- 3. WHATSAPP BUSINESS CLOUD API -->
  <div class="card" style="border-top: 3px solid #10b981;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--color-slate-100); padding-bottom: 12px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(16,185,129,0.1); color: #10b981; display: flex; align-items: center; justify-content: center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        </div>
        <div>
          <h3 style="font-size: 16px; font-weight: 700; color: var(--color-slate-900);">WhatsApp Business Cloud API</h3>
          <div style="font-size: 12px; color: var(--color-slate-500);">Official Meta Cloud Graph API integration</div>
        </div>
      </div>
      <span class="badge badge-success">Meta Verified</span>
    </div>

    <form action="<?= site_url('settings/integrations/save') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="channel" value="WhatsApp Cloud API">

      <div class="grid-2" style="margin-bottom: 12px;">
        <div class="form-group">
          <label class="form-label">Phone Number ID</label>
          <input type="text" name="wa_phone_id" class="form-control" value="<?= esc($settings['wa_phone_id']) ?>" style="font-family: monospace;">
        </div>
        <div class="form-group">
          <label class="form-label">WhatsApp Business Account ID</label>
          <input type="text" name="wa_waba_id" class="form-control" value="<?= esc($settings['wa_waba_id']) ?>" style="font-family: monospace;">
        </div>
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Permanent System User Access Token</label>
        <input type="password" name="wa_access_token" class="form-control" value="<?= esc($settings['wa_access_token']) ?>" style="font-family: monospace;">
      </div>

      <div class="form-group" style="margin-bottom: 16px;">
        <label class="form-label">Message Template Namespace</label>
        <input type="text" name="wa_template_ns" class="form-control" value="<?= esc($settings['wa_template_ns']) ?>">
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-slate-100); padding-top: 14px;">
        <button type="button" class="btn btn-secondary btn-sm" onclick="testChannel('whatsapp')">
          Test Meta Graph API
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
          Save Credentials
        </button>
      </div>
    </form>
  </div>

  <!-- 4. BIOMETRIC HARDWARE WEBHOOK -->
  <div class="card" style="border-top: 3px solid #6366f1;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px; border-bottom: 1px solid var(--color-slate-100); padding-bottom: 12px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(99,102,241,0.1); color: #6366f1; display: flex; align-items: center; justify-content: center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="8" x="2" y="2" rx="2" ry="2"/><rect width="20" height="8" x="2" y="14" rx="2" ry="2"/><line x1="6" x2="6.01" y1="6" y2="6"/><line x1="6" x2="6.01" y1="18" y2="18"/></svg>
        </div>
        <div>
          <h3 style="font-size: 16px; font-weight: 700; color: var(--color-slate-900);">Biometric Hardware Webhooks</h3>
          <div style="font-size: 12px; color: var(--color-slate-500);">ZKTeco, Hikvision &amp; eSSL Real-time Ingestion</div>
        </div>
      </div>
      <span class="badge badge-success">Port 8080 Active</span>
    </div>

    <form action="<?= site_url('settings/integrations/save') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="channel" value="Biometric Terminal Webhook">

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Ingestion Webhook URL (Read-Only)</label>
        <input type="text" class="form-control" value="<?= esc($settings['bio_webhook_url']) ?>" readonly style="background: var(--color-slate-100); font-family: monospace;">
      </div>

      <div class="form-group" style="margin-bottom: 12px;">
        <label class="form-label">Secret Ingestion Token</label>
        <input type="text" name="bio_secret_token" class="form-control" value="<?= esc($settings['bio_secret_token']) ?>" style="font-family: monospace;">
      </div>

      <div class="form-group" style="margin-bottom: 16px;">
        <label class="form-label">Terminal IP Whitelist (CIDR / Comma-separated)</label>
        <input type="text" name="bio_ip_whitelist" class="form-control" value="<?= esc($settings['bio_ip_whitelist']) ?>">
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-slate-100); padding-top: 14px;">
        <button type="button" class="btn btn-secondary btn-sm" onclick="testChannel('biometric')">
          Verify Webhook Health
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
          Save Credentials
        </button>
      </div>
    </form>
  </div>

</div>

<!-- TEST STATUS MODAL -->
<div id="modalTestResult" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 9999;">
  <div class="card" style="width: 440px; max-width: 90vw;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
      <h3 style="font-size: 17px; font-weight: 700;" id="testModalTitle">Gateway Handshake Test</h3>
      <button type="button" onclick="document.getElementById('modalTestResult').style.display='none'" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
    </div>

    <div id="testModalBody" style="padding: 14px; border-radius: 6px; font-size: 13.5px; line-height: 1.5; margin-bottom: 16px;">
      Testing connectivity...
    </div>

    <div style="display: flex; justify-content: flex-end;">
      <button type="button" class="btn btn-primary" onclick="document.getElementById('modalTestResult').style.display='none'">
        Acknowledge
      </button>
    </div>
  </div>
</div>

<script>
function testChannel(channel) {
  const modal = document.getElementById('modalTestResult');
  const body = document.getElementById('testModalBody');
  const title = document.getElementById('testModalTitle');

  title.textContent = 'Testing ' + channel.toUpperCase() + ' Connection...';
  body.style.background = '#f8fafc';
  body.style.color = '#334155';
  body.innerHTML = '<span style="color:#0284c7;">Initiating network handshake with remote server...</span>';
  modal.style.display = 'flex';

  fetch('<?= site_url("settings/integrations/test") ?>', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: 'channel=' + encodeURIComponent(channel) + '&<?= csrf_token() ?>=' + encodeURIComponent('<?= csrf_hash() ?>')
  })
  .then(res => res.json())
  .then(data => {
    title.textContent = channel.toUpperCase() + ' Gateway Status';
    if (data.status === 'success') {
      body.style.background = '#ecfdf5';
      body.style.color = '#065f46';
      body.innerHTML = '<strong>Connection Successful (200 OK):</strong><br>' + data.message;
    } else {
      body.style.background = '#fef2f2';
      body.style.color = '#991b1b';
      body.innerHTML = '<strong>Connection Error:</strong><br>' + data.message;
    }
  })
  .catch(err => {
    body.style.background = '#fef2f2';
    body.style.color = '#991b1b';
    body.innerHTML = '<strong>Network Ping Failed:</strong> Could not establish connection.';
  });
}
</script>
