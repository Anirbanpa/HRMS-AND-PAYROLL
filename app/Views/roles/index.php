<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; flex-wrap: wrap; gap: 14px;">
  <div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
      <h2 style="font-size: 22px; font-weight: 800; color: var(--color-slate-900); letter-spacing: -0.02em; margin: 0;">
        Role-Based Access Control (RBAC) Matrix
      </h2>
      <span class="badge badge-success" style="padding: 4px 10px; font-size: 11.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
        RBAC Enforcement Active
      </span>
    </div>
    <p style="font-size: 13.5px; color: var(--color-slate-500); margin-top: 3px; margin-bottom: 0;">
      Manage the 7 predefined enterprise access tiers and granular module-level capabilities.
    </p>
  </div>

  <!-- View Mode Switcher Pills -->
  <div style="display: flex; background: var(--bg-card); padding: 4px; border: 1px solid var(--border-color); border-radius: 8px; gap: 4px;">
    <button type="button" id="btnViewEditor" class="btn btn-primary btn-sm" onclick="switchRbacView('editor')" style="font-size: 12.5px; padding: 6px 12px;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
      Role Capability Editor
    </button>
    <button type="button" id="btnViewMatrix" class="btn btn-outline btn-sm" onclick="switchRbacView('matrix')" style="font-size: 12.5px; padding: 6px 12px; border: none;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/><path d="M9 3v18"/><path d="M15 3v18"/></svg>
      Full Matrix Overview
    </button>
  </div>
</div>

<?php 
  $tierMeta = [
    'super_admin'     => ['icon' => '👑', 'title' => 'Super Admin', 'level' => 'Tier 1', 'desc' => 'Global Root', 'color' => '#6366f1', 'bg' => 'rgba(99, 102, 241, 0.12)'],
    'hr_admin'        => ['icon' => '🛡️', 'title' => 'HR Admin', 'level' => 'Tier 2', 'desc' => 'HR Master', 'color' => '#0284c7', 'bg' => 'rgba(2, 132, 199, 0.12)'],
    'hr_executive'    => ['icon' => '📋', 'title' => 'HR Executive', 'level' => 'Tier 3', 'desc' => 'HR Operations', 'color' => '#10b981', 'bg' => 'rgba(16, 185, 129, 0.12)'],
    'payroll_manager' => ['icon' => '💰', 'title' => 'Payroll Manager', 'level' => 'Tier 4', 'desc' => 'Payroll Engine', 'color' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.12)'],
    'accountant'      => ['icon' => '📊', 'title' => 'Accountant', 'level' => 'Tier 5', 'desc' => 'Audit & Finance', 'color' => '#ec4899', 'bg' => 'rgba(236, 72, 153, 0.12)'],
    'manager'         => ['icon' => '👔', 'title' => 'Manager', 'level' => 'Tier 6', 'desc' => 'Approvals & Team', 'color' => '#f97316', 'bg' => 'rgba(249, 115, 22, 0.12)'],
    'employee'        => ['icon' => '👤', 'title' => 'Employee', 'level' => 'Tier 7', 'desc' => 'Individual ESS', 'color' => '#8b5cf6', 'bg' => 'rgba(139, 92, 246, 0.12)'],
  ];
?>

<!-- ============================================================== -->
<!-- VIEW 1: GRANULAR PERMISSIONS ASSIGNMENT (ROLE CAPABILITY EDITOR) -->
<!-- ============================================================== -->
<div id="rbacEditorView" class="card" style="padding: 22px; border-radius: 12px; box-shadow: var(--shadow-sm);">
  <!-- Role Tabs Navigation -->
  <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
    <div style="display: flex; gap: 6px; flex-wrap: wrap;" id="roleTabsBar">
      <?php foreach ($roles as $idx => $r): 
        $meta = $tierMeta[$r['slug']] ?? ['icon' => '🔐'];
      ?>
        <button type="button" 
                class="role-tab-btn <?= ($idx === 0) ? 'active' : '' ?>" 
                id="roleTabBtn-<?= $r['id'] ?>"
                onclick="switchRole('<?= $r['id'] ?>')"
                style="padding: 7px 14px; font-size: 13px; font-weight: 600; border-radius: 6px; border: 1px solid var(--border-color); background: var(--bg-card); color: var(--color-slate-600); cursor: pointer; transition: all 0.2s ease;">
          <span style="margin-right: 4px;"><?= $meta['icon'] ?></span>
          <?= esc($r['name']) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <!-- Live Search Capabilities Filter -->
    <div style="position: relative; width: 280px;">
      <input type="text" id="permSearchInput" class="form-control" placeholder="Search capabilities..." onkeyup="filterPermissions()" style="padding-left: 32px; font-size: 12.5px;">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--color-slate-400);"><circle cx="11" cy="11" r="8"/><line x1="21" x2="21" y1="21" y2="16.65"/></svg>
    </div>
  </div>

  <!-- Role Permission Panels -->
  <?php foreach ($roles as $idx => $r): 
    $assignedPerms = $rolePermMap[$r['id']] ?? [];
    $isSuperAdmin = ($r['slug'] === 'super_admin');
    $meta = $tierMeta[$r['slug']] ?? ['icon' => '🔐', 'color' => '#64748b'];
  ?>
    <div id="rolePanel-<?= $r['id'] ?>" class="role-panel" style="display: <?= ($idx === 0) ? 'block' : 'none' ?>;">
      <form action="<?= site_url('roles/update/' . $r['id']) ?>" method="POST" id="formRole-<?= $r['id'] ?>">
        <?= csrf_field() ?>

        <!-- Active Role Header Banner -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; background: var(--bg-main, #f8fafc); padding: 14px 18px; border-radius: 10px; border: 1px solid var(--border-color); flex-wrap: wrap; gap: 12px;">
          <div>
            <div style="display: flex; align-items: center; gap: 8px;">
              <span style="font-size: 18px;"><?= $meta['icon'] ?></span>
              <strong style="color: var(--color-slate-900); font-size: 15px;"><?= esc($r['name']) ?></strong>
              <span style="font-size: 12px; color: var(--color-slate-500);">
                (<span id="rolePermCounter-<?= $r['id'] ?>"><?= count($assignedPerms) ?></span> / 18 capabilities assigned)
              </span>
            </div>
            <?php if ($isSuperAdmin): ?>
              <div style="font-size: 12px; color: var(--color-primary); margin-top: 3px; font-weight: 500;">
                &bull; Super Admin permanently holds all system capabilities for root platform governance.
              </div>
            <?php else: ?>
              <div style="font-size: 12px; color: var(--color-slate-500); margin-top: 3px;">
                Configure the specific modules and actions permitted for users in this tier.
              </div>
            <?php endif; ?>
          </div>

          <div style="display: flex; gap: 8px; align-items: center;">
            <?php if (!$isSuperAdmin): ?>
              <button type="button" class="btn btn-outline btn-sm" onclick="selectAllRolePerms('<?= $r['id'] ?>', true)" style="font-size: 12px; padding: 5px 10px;">
                ✓ Select All
              </button>
              <button type="button" class="btn btn-outline btn-sm" onclick="selectAllRolePerms('<?= $r['id'] ?>', false)" style="font-size: 12px; padding: 5px 10px;">
                ✗ Clear All
              </button>
              <button type="submit" class="btn btn-primary btn-sm" style="font-size: 12px; padding: 6px 14px;">
                Save Changes
              </button>
            <?php else: ?>
              <span class="badge badge-success" style="font-size: 12px; padding: 5px 12px;">Permanent Root Authority</span>
            <?php endif; ?>
          </div>
        </div>

        <!-- Grouped Permissions Cards Grid -->
        <div class="perm-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 18px;">
          <?php foreach ($groupedPermissions as $moduleName => $perms): ?>
            <div class="perm-module-card" data-module="<?= esc($moduleName) ?>" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; padding: 16px; box-shadow: var(--shadow-sm);">
              
              <!-- Module Card Header -->
              <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding-bottom: 10px; margin-bottom: 12px;">
                <div style="display: flex; align-items: center; gap: 6px;">
                  <span style="font-size: 12px; font-weight: 800; color: var(--color-slate-900); text-transform: uppercase; letter-spacing: 0.05em;">
                    <?= esc(ucwords(str_replace('_', ' ', $moduleName))) ?>
                  </span>
                  <span class="badge badge-secondary" style="font-size: 10px; padding: 1px 6px;">
                    <?= count($perms) ?>
                  </span>
                </div>

                <?php if (!$isSuperAdmin): ?>
                  <button type="button" 
                          onclick="toggleModulePerms('<?= $r['id'] ?>', '<?= esc($moduleName) ?>')" 
                          class="btn-text-action" 
                          style="background: none; border: none; font-size: 11px; font-weight: 600; color: var(--color-primary); cursor: pointer; padding: 2px 4px;">
                    Toggle
                  </button>
                <?php endif; ?>
              </div>

              <!-- Module Capabilities List -->
              <div style="display: flex; flex-direction: column; gap: 10px;">
                <?php foreach ($perms as $p): 
                  $isDeletePerm = (strpos($p['slug'], '.delete') !== false);
                  $checked = $isSuperAdmin ? true : (!$isDeletePerm && in_array((int)$p['id'], $assignedPerms, true));
                  $isDisabled = $isSuperAdmin || $isDeletePerm;
                ?>
                  <label class="perm-item" 
                         data-search="<?= strtolower(esc($p['name'] . ' ' . $p['slug'] . ' ' . ($p['description'] ?? '') . ' ' . $moduleName)) ?>"
                         style="display: flex; align-items: flex-start; gap: 9px; font-size: 12.5px; cursor: <?= $isDisabled ? 'default' : 'pointer' ?>; color: var(--color-slate-700); padding: 6px 8px; border-radius: 6px; transition: background 0.15s ease; <?= $isDeletePerm && !$isSuperAdmin ? 'opacity: 0.75; background: rgba(239, 68, 68, 0.03);' : '' ?>">
                    
                    <input type="checkbox" 
                           name="permissions[]" 
                           value="<?= $p['id'] ?>" 
                           class="perm-checkbox role-<?= $r['id'] ?>-module-<?= esc($moduleName) ?>"
                           data-role-id="<?= $r['id'] ?>"
                           <?= $checked ? 'checked' : '' ?>
                           <?= $isDisabled ? 'disabled' : '' ?>
                           onchange="updateRolePermCount('<?= $r['id'] ?>')"
                           style="margin-top: 3px; width: 15px; height: 15px; accent-color: var(--color-primary); cursor: <?= $isDisabled ? 'default' : 'pointer' ?>;">
                    
                    <div style="flex: 1;">
                      <div style="font-weight: 600; color: var(--color-slate-900); line-height: 1.3; display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                        <span><?= esc($p['name']) ?></span>
                        <?php if ($isDeletePerm): ?>
                          <span class="badge badge-danger" style="font-size: 10px; padding: 2px 6px; background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.25);">Super Admin Exclusive</span>
                        <?php endif; ?>
                      </div>
                      <code style="font-size: 10.5px; color: var(--color-slate-500); background: var(--bg-main); padding: 1px 4px; border-radius: 3px; display: inline-block; margin-top: 2px;">
                        <?= esc($p['slug']) ?>
                      </code>
                      <?php if (!empty($p['description'])): ?>
                        <div style="font-size: 11px; color: var(--color-slate-400); margin-top: 2px; line-height: 1.35;">
                          <?= esc($p['description']) ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if (!$isSuperAdmin): ?>
          <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 12px; align-items: center;">
            <span style="font-size: 12.5px; color: var(--color-slate-500);">
              Modifications apply immediately to all users assigned to <strong><?= esc($r['name']) ?></strong>.
            </span>
            <button type="submit" class="btn btn-primary" style="padding: 8px 20px; font-size: 13px;">
              Save Permissions for <?= esc($r['name']) ?>
            </button>
          </div>
        <?php endif; ?>
      </form>
    </div>
  <?php endforeach; ?>
</div>

<!-- ============================================================== -->
<!-- VIEW 2: FULL ENTERPRISE RBAC MATRIX (CROSS-ROLE SIDE-BY-SIDE) -->
<!-- ============================================================== -->
<div id="rbacMatrixView" class="card" style="display: none; padding: 22px; border-radius: 12px; box-shadow: var(--shadow-sm);">
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
    <div>
      <h3 style="font-size: 16px; font-weight: 700; margin: 0; color: var(--color-slate-900);">
        Enterprise Access Control Comparison Grid
      </h3>
      <p style="font-size: 12.5px; color: var(--color-slate-500); margin: 2px 0 0 0;">
        Side-by-side compliance overview across all 7 role tiers and 18 system capabilities.
      </p>
    </div>
    <div style="display: flex; gap: 10px; align-items: center;">
      <span class="badge badge-success" style="font-size: 11.5px;">✓ Granted</span>
      <span class="badge badge-secondary" style="font-size: 11.5px;">— Restricted</span>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table" style="margin-bottom: 0; font-size: 12.5px;">
      <thead>
        <tr>
          <th style="width: 28%; min-width: 220px;">Module &bull; Capability</th>
          <?php foreach ($roles as $r): 
            $meta = $tierMeta[$r['slug']] ?? ['icon' => '🔐'];
          ?>
            <th style="text-align: center; min-width: 105px;">
              <span style="font-size: 14px;"><?= $meta['icon'] ?></span>
              <div style="font-size: 11.5px; font-weight: 700; margin-top: 2px;"><?= esc($r['name']) ?></div>
            </th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($groupedPermissions as $moduleName => $perms): ?>
          <tr style="background: var(--bg-main, #f8fafc);">
            <td colspan="<?= count($roles) + 1 ?>" style="font-weight: 800; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-slate-600); padding: 8px 12px;">
              📁 <?= esc(ucwords(str_replace('_', ' ', $moduleName))) ?> (<?= count($perms) ?> capabilities)
            </td>
          </tr>
          <?php foreach ($perms as $p): ?>
            <tr>
              <td>
                <div style="font-weight: 600; color: var(--color-slate-900);"><?= esc($p['name']) ?></div>
                <code style="font-size: 10.5px; color: var(--color-slate-500);"><?= esc($p['slug']) ?></code>
              </td>
              <?php foreach ($roles as $r): 
                $assignedPerms = $rolePermMap[$r['id']] ?? [];
                $isSuperAdmin = ($r['slug'] === 'super_admin');
                $isDeletePerm = (strpos($p['slug'], '.delete') !== false);
                $isGranted = $isSuperAdmin || (!$isDeletePerm && in_array((int)$p['id'], $assignedPerms, true));
              ?>
                <td style="text-align: center; vertical-align: middle;">
                  <?php if ($isGranted): ?>
                    <span class="badge badge-success" style="font-size: 11px; padding: 2px 7px;">✓ Granted</span>
                  <?php elseif ($isDeletePerm): ?>
                    <span style="color: #ef4444; font-size: 10.5px; font-weight: 600;">🔒 Super Admin</span>
                  <?php else: ?>
                    <span style="color: var(--color-slate-300); font-weight: 700; font-size: 13px;">—</span>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr style="background: var(--bg-main, #f8fafc); font-weight: 700;">
          <td style="color: var(--color-slate-800);">Total Granted Capabilities:</td>
          <?php foreach ($roles as $r): 
            $assignedPerms = $rolePermMap[$r['id']] ?? [];
            $isSuperAdmin = ($r['slug'] === 'super_admin');
            $count = $isSuperAdmin ? 18 : count($assignedPerms);
          ?>
            <td style="text-align: center; color: var(--color-primary); font-size: 13px;">
              <strong><?= $count ?> / 18</strong>
            </td>
          <?php endforeach; ?>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<style>
.role-tab-btn.active {
  background: var(--color-primary) !important;
  color: #ffffff !important;
  border-color: var(--color-primary) !important;
}
.perm-item:hover {
  background: var(--bg-main, #f8fafc);
}
</style>

<script>
let currentActiveRoleId = '<?= $roles[0]['id'] ?? 1 ?>';

function switchRole(roleId) {
  currentActiveRoleId = roleId;

  // 1. Update role tab buttons
  document.querySelectorAll('.role-tab-btn').forEach(b => b.classList.remove('active'));
  const activeTabBtn = document.getElementById(`roleTabBtn-${roleId}`);
  if (activeTabBtn) activeTabBtn.classList.add('active');

  // 2. Switch role panel
  document.querySelectorAll('.role-panel').forEach(p => p.style.display = 'none');
  const targetPanel = document.getElementById(`rolePanel-${roleId}`);
  if (targetPanel) {
    targetPanel.style.display = 'block';
  }

  // Clear search filter when switching roles
  const searchInput = document.getElementById('permSearchInput');
  if (searchInput && searchInput.value) {
    searchInput.value = '';
    filterPermissions();
  }
}

function selectAllRolePerms(roleId, state) {
  const panel = document.getElementById(`rolePanel-${roleId}`);
  if (!panel) return;
  const checkboxes = panel.querySelectorAll('input.perm-checkbox:not(:disabled)');
  checkboxes.forEach(cb => cb.checked = state);
  updateRolePermCount(roleId);
}

function toggleModulePerms(roleId, moduleName) {
  const panel = document.getElementById(`rolePanel-${roleId}`);
  if (!panel) return;
  const checkboxes = panel.querySelectorAll(`input.role-${roleId}-module-${moduleName}:not(:disabled)`);
  if (!checkboxes.length) return;
  const allChecked = Array.from(checkboxes).every(cb => cb.checked);
  checkboxes.forEach(cb => cb.checked = !allChecked);
  updateRolePermCount(roleId);
}

function updateRolePermCount(roleId) {
  const panel = document.getElementById(`rolePanel-${roleId}`);
  if (!panel) return;
  const checked = panel.querySelectorAll('input.perm-checkbox:checked').length;
  
  const counter = document.getElementById(`rolePermCounter-${roleId}`);
  if (counter) counter.innerText = checked;
}

function filterPermissions() {
  const query = (document.getElementById('permSearchInput').value || '').toLowerCase().trim();
  const currentPanel = document.getElementById(`rolePanel-${currentActiveRoleId}`);
  if (!currentPanel) return;

  const moduleCards = currentPanel.querySelectorAll('.perm-module-card');
  moduleCards.forEach(card => {
    let hasVisibleItem = false;
    const items = card.querySelectorAll('.perm-item');
    items.forEach(item => {
      const searchData = item.getAttribute('data-search') || '';
      const match = !query || searchData.includes(query);
      item.style.display = match ? 'flex' : 'none';
      if (match) hasVisibleItem = true;
    });
    card.style.display = hasVisibleItem ? 'block' : 'none';
  });
}

function switchRbacView(mode) {
  const editorView = document.getElementById('rbacEditorView');
  const matrixView = document.getElementById('rbacMatrixView');
  const btnEditor = document.getElementById('btnViewEditor');
  const btnMatrix = document.getElementById('btnViewMatrix');

  if (mode === 'matrix') {
    editorView.style.display = 'none';
    matrixView.style.display = 'block';
    btnMatrix.className = 'btn btn-primary btn-sm';
    btnMatrix.style.border = 'none';
    btnEditor.className = 'btn btn-outline btn-sm';
    btnEditor.style.border = 'none';
  } else {
    matrixView.style.display = 'none';
    editorView.style.display = 'block';
    btnEditor.className = 'btn btn-primary btn-sm';
    btnEditor.style.border = 'none';
    btnMatrix.className = 'btn btn-outline btn-sm';
    btnMatrix.style.border = 'none';
  }
}
</script>
