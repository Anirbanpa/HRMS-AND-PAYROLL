<div style="margin-bottom: 24px;">
  <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
    Enterprise Audit Trail &amp; Security Logs
  </h2>
  <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
    Immutable, tamper-resistant system events recording authentication, data mutations, role changes, and administrative actions.
  </p>
</div>

<div class="card">
  <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div class="card-title">Security Event Log (<?= count($logs) ?> Events Recorded)</div>
    <span class="badge badge-success">Audit Stream Active</span>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Log ID</th>
          <th>Timestamp</th>
          <th>Action Type</th>
          <th>Subsystem Module</th>
          <th>Actor Username</th>
          <th>Event Description</th>
          <th>Origin IP</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($logs)): ?>
          <tr>
            <td colspan="7" style="text-align: center; padding: 30px; color: #64748b;">
              No audit logs registered yet.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($logs as $log): ?>
            <tr>
              <td><code>#<?= esc($log['id']) ?></code></td>
              <td style="white-space: nowrap; font-size: 12.5px; color: #64748b;">
                <?= esc(date('Y-m-d H:i:s', strtotime($log['created_at']))) ?>
              </td>
              <td>
                <span class="badge badge-primary"><?= esc($log['action']) ?></span>
              </td>
              <td>
                <span class="badge badge-secondary"><?= esc($log['module']) ?></span>
              </td>
              <td>
                <div style="font-weight: 600; color: #0f172a;">
                  <?= esc($log['username'] ?? 'System') ?>
                </div>
                <?php if ($log['first_name']): ?>
                  <div style="font-size: 11px; color: #64748b;"><?= esc($log['first_name'] . ' ' . $log['last_name']) ?></div>
                <?php endif; ?>
              </td>
              <td style="max-width: 320px;">
                <div style="font-size: 13px; line-height: 1.4; color: #334155;">
                  <?= esc($log['description']) ?>
                </div>
              </td>
              <td>
                <code style="font-size: 12px; color: #475569;"><?= esc($log['ip_address'] ?? '127.0.0.1') ?></code>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
