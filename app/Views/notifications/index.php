<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em;">
      Notification &amp; Activity Stream
    </h2>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 2px;">
      Personal in-app alerts, approval notices, payroll notifications, and broadcast circulars.
    </p>
  </div>
  <div>
    <form action="<?= site_url('notifications/read-all') ?>" method="POST" style="display: inline;">
      <?= csrf_field() ?>
      <button type="submit" class="btn btn-outline btn-sm">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        Mark All as Read
      </button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <?php if (empty($notifications)): ?>
      <div style="text-align: center; color: var(--color-slate-500); padding: 48px 24px;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 12px; color: var(--color-slate-400); display: block;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        <p style="font-size: 15px; font-weight: 600; color: var(--color-slate-700); margin-bottom: 4px;">No notifications</p>
        <p style="font-size: 13px; color: var(--color-slate-400);">You're all caught up with your enterprise updates and announcements.</p>
      </div>
    <?php else: ?>
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <?php foreach ($notifications as $n): ?>
          <div style="padding: 14px 18px; border-radius: 8px; border: 1px solid <?= empty($n['is_read']) ? 'var(--primary)' : 'var(--color-slate-200)' ?>; background: <?= empty($n['is_read']) ? 'rgba(79, 70, 229, 0.04)' : 'var(--color-slate-50)' ?>; display: flex; justify-content: space-between; align-items: flex-start; gap: 14px;">
            <div style="flex: 1;">
              <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span class="badge <?= empty($n['is_read']) ? 'badge-primary' : 'badge-secondary' ?>" style="font-size: 10.5px; text-transform: uppercase;">
                  <?= esc($n['channel'] ?? 'in_app') ?>
                </span>
                <strong style="font-size: 14.5px; color: var(--color-slate-900);"><?= esc($n['title']) ?></strong>
                <?php if (empty($n['is_read'])): ?>
                  <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: var(--primary);"></span>
                <?php endif; ?>
              </div>
              <p style="font-size: 13.5px; color: var(--color-slate-600); margin-bottom: 6px; line-height: 1.5;">
                <?= nl2br(esc($n['message'])) ?>
              </p>
              <div style="font-size: 11.5px; color: var(--color-slate-400);">
                <?= date('F j, Y \a\t g:i A', strtotime($n['created_at'])) ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
