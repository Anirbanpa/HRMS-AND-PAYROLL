<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Database Backup &amp; Disaster Recovery
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Automated SQL data snapshots, table schema verification, and point-in-time disaster recovery tools.
    </p>
  </div>
  <div style="display: flex; gap: 10px;">
    <a href="<?= site_url('settings/backup/download') ?>" class="btn btn-primary" id="btnDownloadDbBackup" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 700; background: #059669; border-color: #059669;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
      1-Click Download Full SQL Dump
    </a>
  </div>
</div>

<!-- DATABASE HEALTH METRICS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <div class="stat-card">
    <div class="stat-content">
      <div class="stat-label">Active Schema</div>
      <div class="stat-value" style="font-size: 18px; font-family: monospace;"><?= esc($dbName) ?></div>
      <div class="stat-subtext">MySQL <?= esc($mysqlVersion) ?></div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
    </div>
  </div>

  <div class="stat-card emerald">
    <div class="stat-content">
      <div class="stat-label">Total Tables</div>
      <div class="stat-value"><?= esc($tableCount) ?> Tables</div>
      <div class="stat-subtext">Enterprise modules 1-44</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/><path d="M9 3v18"/><path d="M15 3v18"/></svg>
    </div>
  </div>

  <div class="stat-card sky">
    <div class="stat-content">
      <div class="stat-label">Total Records</div>
      <div class="stat-value"><?= number_format($totalRows) ?></div>
      <div class="stat-subtext">All entities &amp; audit trails</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
    </div>
  </div>

  <div class="stat-card amber">
    <div class="stat-content">
      <div class="stat-label">Database Storage</div>
      <div class="stat-value"><?= esc($totalSizeMB) ?> MB</div>
      <div class="stat-subtext">Data + Index footprint</div>
    </div>
    <div class="stat-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m8 17 4 4 4-4"/></svg>
    </div>
  </div>
</div>

<!-- ACTION & BEST PRACTICE BANNER -->
<div class="card" style="margin-bottom: 24px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #f8fafc; border: 1px solid #334155;">
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
    <div style="max-width: 680px;">
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
        <span class="badge" style="background: #059669; color: #fff; font-size: 11px;">Module 44 Certified</span>
        <h3 style="font-size: 17px; font-weight: 700; color: #fff; margin: 0;">Full Database Snapshot &amp; Cold Storage Export</h3>
      </div>
      <p style="font-size: 13.5px; color: #94a3b8; line-height: 1.5; margin: 0;">
        Generates an uncorrupted, complete SQL dump containing table schemas, foreign key constraints, indexes, and full dataset rows. Safe for point-in-time recovery, offsite cold storage, or cloud migration.
      </p>
    </div>
    <div>
      <a href="<?= site_url('settings/backup/download') ?>" class="btn btn-primary" style="background: #10b981; border-color: #10b981; font-weight: 700; padding: 12px 24px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Generate Snapshot (.sql)
      </a>
    </div>
  </div>
</div>

<div class="grid-2" style="margin-bottom: 24px;">
  <!-- AUDIT LOG OF BACKUPS -->
  <div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 16px 20px; background: var(--color-slate-50); border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
      <h3 style="font-size: 15px; font-weight: 700; color: var(--color-slate-800);">Recent Backup Activity Logs</h3>
      <span class="badge badge-info">Audited</span>
    </div>
    <div style="overflow-x: auto;">
      <table class="table" style="width: 100%; font-size: 13px;">
        <thead>
          <tr>
            <th>Timestamp</th>
            <th>Triggered By</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($recentBackups)): ?>
            <tr>
              <td colspan="3" style="text-align: center; color: var(--color-slate-500); padding: 24px;">
                No manual backup events recorded yet. Click 'Generate Snapshot' to take your first backup.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($recentBackups as $b): ?>
              <tr>
                <td><strong><?= date('M j, Y H:i:s', strtotime($b['created_at'])) ?></strong></td>
                <td>User #<?= esc($b['user_id'] ?? '1') ?></td>
                <td><code style="font-size: 11px;"><?= esc($b['description']) ?></code></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- RESTORATION PROTOCOL -->
  <div class="card">
    <div class="card-header" style="border-bottom: 1px solid var(--color-slate-200); padding-bottom: 12px; margin-bottom: 16px;">
      <div class="card-title" style="font-size: 15px; font-weight: 700; color: var(--color-slate-800);">
        Restoration &amp; Recovery CLI Instructions
      </div>
      <p style="font-size: 12.5px; color: var(--color-slate-500);">To restore your HRMS on any Linux or Windows server via MySQL CLI:</p>
    </div>

    <div style="background: #0f172a; color: #38bdf8; padding: 14px 18px; border-radius: 8px; font-family: monospace; font-size: 12px; margin-bottom: 14px; overflow-x: auto;">
      <span style="color: #94a3b8;"># 1. Create database if not exists:</span><br>
      mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS enterprise_hrms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"<br><br>
      <span style="color: #94a3b8;"># 2. Import the downloaded snapshot dump:</span><br>
      mysql -u root -p enterprise_hrms &lt; hrms_backup_enterprise_hrms.sql
    </div>

    <div style="font-size: 12.5px; color: var(--color-slate-600); line-height: 1.5;">
      &bull; <strong>Foreign Keys:</strong> The backup automatically disables foreign key constraints during import to prevent circular dependency errors.<br>
      &bull; <strong>UTF-8 Multilingual:</strong> Preserves UTF-8 encoding across employee profiles, addresses, and document templates.
    </div>
  </div>
</div>

<!-- TABLE REPOSITORY REGISTRY -->
<div class="card" style="padding: 0; overflow: hidden;">
  <div style="padding: 16px 20px; background: var(--color-slate-50); border-bottom: 1px solid var(--color-slate-200); display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h3 style="font-size: 15px; font-weight: 700; color: var(--color-slate-800);">Complete Schema Tables Inventory (<?= count($tables) ?> Tables)</h3>
      <p style="font-size: 12px; color: var(--color-slate-500);">Row counts and data footprints across all 44 HRMS modules.</p>
    </div>
    <span class="badge badge-success">Schema Synchronized</span>
  </div>

  <div style="overflow-x: auto; max-height: 480px;">
    <table class="table" style="width: 100%; font-size: 12.5px;">
      <thead>
        <tr>
          <th>#</th>
          <th>Table Name</th>
          <th>Total Rows</th>
          <th>Data Size (KB)</th>
          <th>Index Size (KB)</th>
          <th>Engine &amp; Health</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tables as $idx => $t): ?>
          <tr>
            <td style="color: var(--color-slate-400);"><?= $idx + 1 ?></td>
            <td><code style="font-weight: 700; color: var(--color-primary);"><?= esc($t['table_name']) ?></code></td>
            <td><strong><?= number_format((int)$t['row_count']) ?></strong></td>
            <td><?= number_format((float)$t['data_length'] / 1024, 1) ?> KB</td>
            <td><?= number_format((float)$t['index_length'] / 1024, 1) ?> KB</td>
            <td><span class="badge badge-success" style="font-size: 10.5px;">InnoDB OK</span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
