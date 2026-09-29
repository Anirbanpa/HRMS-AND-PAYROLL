<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
      Role-Based Access Control (RBAC) Matrix
    </h2>
    <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
      Manage the 7 predefined enterprise access tiers and granular module-level capabilities.
    </p>
  </div>
  <div>
    <span class="badge badge-success" style="padding: 6px 12px; font-size: 12px;">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 4px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
      RBAC Enforcement Active
    </span>
  </div>
</div>

<?php 
  $tierMeta = [
    'super_admin'     => ['icon' => '👑', 'title' => 'Super Admin', 'level' => 'Tier 1', 'desc' => 'Global Root', 'color' => '#818cf8', 'bg' => 'rgba(99, 102, 241, 0.2)'],
    'hr_admin'        => ['icon' => '🛡️', 'title' => 'HR Admin', 'level' => 'Tier 2', 'desc' => 'HR Master', 'color' => '#38bdf8', 'bg' => 'rgba(56, 189, 248, 0.2)'],
    'hr_executive'    => ['icon' => '📋', 'title' => 'HR Executive', 'level' => 'Tier 3', 'desc' => 'HR Operations', 'color' => '#34d399', 'bg' => 'rgba(52, 211, 153, 0.2)'],
    'payroll_manager' => ['icon' => '💰', 'title' => 'Payroll Manager', 'level' => 'Tier 4', 'desc' => 'Payroll Engine', 'color' => '#fbbf24', 'bg' => 'rgba(251, 191, 36, 0.2)'],
    'accountant'      => ['icon' => '📊', 'title' => 'Accountant', 'level' => 'Tier 5', 'desc' => 'Audit & Finance', 'color' => '#f472b6', 'bg' => 'rgba(244, 114, 182, 0.2)'],
    'manager'         => ['icon' => '👔', 'title' => 'Manager', 'level' => 'Tier 6', 'desc' => 'Approvals & Team', 'color' => '#fb923c', 'bg' => 'rgba(251, 146, 60, 0.2)'],
    'employee'        => ['icon' => '👤', 'title' => 'Employee', 'level' => 'Tier 7', 'desc' => 'Individual ESS', 'color' => '#a78bfa', 'bg' => 'rgba(167, 139, 250, 0.2)'],
  ];
?>

<!-- 7 ROLE SUMMARY CARDS -->
<div class="grid-4" style="margin-bottom: 24px;">
  <?php foreach ($roles as $idx => $r): 
    $meta = $tierMeta[$r['slug']] ?? ['icon' => '🔐', 'color' => '#64748b', 'level' => 'Tier ' . ($idx + 1)];
  ?>
    <div class="card" style="padding: 16px; margin-bottom: 0; border-top: 3px solid <?= $meta['color'] ?>; cursor: pointer;" onclick="switchRoleTab('<?= $r['id'] ?>')">
      <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
          <div style="display: flex; align-items: center; gap: 6px;">
            <span style="font-size: 16px;"><?= $meta['icon'] ?></span>
            <div style="font-size: 14px; font-weight: 700; color: #0f172a;"><?= esc($r['name']) ?></div>
          </div>
          <div style="display: flex; gap: 4px; margin-top: 4px;">
            <span style="font-size: 10px; font-weight: 700; color: <?= $meta['color'] ?>; background: #f1f5f9; padding: 1px 6px; border-radius: 4px;"><?= $meta['level'] ?></span>
            <code style="font-size: 10px; color: #64748b; background: #f8fafc; padding: 1px 5px; border-radius: 4px;"><?= esc($r['slug']) ?></code>
          </div>
        </div>
        <?php if ($r['is_system']): ?>
          <span class="badge badge-primary" style="font-size: 10px;">System</span>
        <?php endif; ?>
      </div>
      <p style="font-size: 11.5px; color: #64748b; margin: 8px 0 10px; min-height: 32px; line-height: 1.4;">
        <?= esc($r['description'] ?? 'Standard enterprise operational access.') ?>
      </p>
      <div style="display: flex; justify-content: space-between; font-size: 11px; border-top: 1px solid #f1f5f9; padding-top: 8px; color: #475569;">
        <span><strong><?= esc($r['user_count']) ?></strong> users</span>
        <span><strong><?= esc($r['permission_count']) ?></strong> perms</span>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- ROLE PERMISSION ASSIGNMENT TABS -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Granular Permissions Assignment Matrix</div>
    <span style="font-size: 12px; color: #64748b;">Select a role below to configure its capability permissions</span>
  </div>
  <div class="card-body">
    <div class="tabs-container">
      <div class="tabs-header">
        <?php foreach ($roles as $idx => $r): ?>
          <button type="button" class="tab-btn <?= ($idx === 0) ? 'active' : '' ?>" data-target="role-tab-<?= $r['id'] ?>">
            <?= esc($r['name']) ?>
          </button>
        <?php endforeach; ?>
      </div>

      <?php foreach ($roles as $idx => $r): 
        $assignedPerms = $rolePermMap[$r['id']] ?? [];
      ?>
        <div id="role-tab-<?= $r['id'] ?>" class="tab-content <?= ($idx === 0) ? 'active' : '' ?>">
          <form action="<?= site_url('roles/update/' . $r['id']) ?>" method="POST">
            <?= csrf_field() ?>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; background: #f8fafc; padding: 12px 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
              <div>
                <strong style="color: #0f172a; font-size: 14px;"><?= esc($r['name']) ?></strong>
                <span style="color: #64748b; font-size: 13px; margin-left: 8px;">(<?= count($assignedPerms) ?> permissions currently assigned)</span>
                <?php if ($r['slug'] === 'super_admin'): ?>
                  <div style="font-size: 11.5px; color: #4f46e5; margin-top: 2px;">
                    &bull; Super Admin permanently holds all system capabilities for platform governance.
                  </div>
                <?php endif; ?>
              </div>
              <div>
                <?php if ($r['slug'] !== 'super_admin'): ?>
                  <button type="submit" class="btn btn-primary btn-sm">
                    Save Permission Changes
                  </button>
                <?php else: ?>
                  <span class="badge badge-success">Permanent Root Authority</span>
                <?php endif; ?>
              </div>
            </div>

            <!-- Grouped Permissions Checkbox Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
              <?php foreach ($groupedPermissions as $moduleName => $perms): ?>
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                  <div style="font-size: 13px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 12px; display: flex; justify-content: space-between;">
                    <span><?= esc(ucwords(str_replace('_', ' ', $moduleName))) ?></span>
                    <span style="font-size: 11px; color: #94a3b8;"><?= count($perms) ?> capabilities</span>
                  </div>

                  <div style="display: flex; flex-direction: column; gap: 10px;">
                    <?php foreach ($perms as $p): 
                      $checked = in_array((int)$p['id'], $assignedPerms, true) || ($r['slug'] === 'super_admin');
                    ?>
                      <label style="display: flex; align-items: flex-start; gap: 8px; font-size: 12.5px; cursor: pointer; color: #334155;">
                        <input type="checkbox" name="permissions[]" value="<?= $p['id'] ?>" 
                          <?= $checked ? 'checked' : '' ?>
                          <?= ($r['slug'] === 'super_admin') ? 'disabled' : '' ?>
                          style="margin-top: 3px; accent-color: #4f46e5;">
                        <div>
                          <div style="font-weight: 600; color: #0f172a;"><?= esc($p['name']) ?></div>
                          <code style="font-size: 10.5px; color: #64748b;"><?= esc($p['slug']) ?></code>
                          <?php if (!empty($p['description'])): ?>
                            <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;"><?= esc($p['description']) ?></div>
                          <?php endif; ?>
                        </div>
                      </label>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <?php if ($r['slug'] !== 'super_admin'): ?>
              <div style="margin-top: 24px; text-align: right;">
                <button type="submit" class="btn btn-primary">
                  Save Changes for <?= esc($r['name']) ?>
                </button>
              </div>
            <?php endif; ?>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
function switchRoleTab(roleId) {
  const targetBtn = document.querySelector(`.tab-btn[data-target="role-tab-${roleId}"]`);
  if (targetBtn) {
    targetBtn.click();
    const matrixCard = document.querySelector('.card:has(.tabs-container)');
    if (matrixCard) {
      matrixCard.scrollIntoView({ behavior: 'smooth' });
    }
  }
}
</script>
