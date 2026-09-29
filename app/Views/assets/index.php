<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Hardware &amp; Digital Asset Management</h2>
    <p style="color: #64748b; font-size: 14px; margin: 0;">Track corporate workstations, peripherals, licenses, serial numbers, employee allocations, and returns.</p>
  </div>
  <div style="display: flex; gap: 12px;">
    <button class="btn btn-outline" onclick="document.getElementById('modalRegisterAsset').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Register New Asset
    </button>
    <button class="btn btn-primary" onclick="document.getElementById('modalAllocateAsset').style.display='flex'">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
      Allocate Asset
    </button>
  </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid" style="margin-bottom: 28px;">
  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Total Inventory</span>
      <div class="kpi-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($totalAssets) ?> Units</div>
    <div class="kpi-subtitle">Valuation: ₹<?= number_format((float)$totalValuation, 2) ?></div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Allocated Assets</span>
      <div class="kpi-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($allocatedCount) ?> Units</div>
    <div class="kpi-subtitle">Active with employees</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Available in Pool</span>
      <div class="kpi-icon" style="background: rgba(14,165,233,0.1); color: #0ea5e9;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($availableCount) ?> Units</div>
    <div class="kpi-subtitle">Ready for immediate issuance</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Maintenance / Repair</span>
      <div class="kpi-icon" style="background: rgba(239,68,68,0.1); color: #ef4444;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($maintenanceCount) ?> Units</div>
    <div class="kpi-subtitle">In repair or decommissioned</div>
  </div>
</div>

<!-- TABS: Inventory Directory vs Allocation History -->
<div class="card" style="margin-bottom: 24px;">
  <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
    <div class="tabs-nav" style="margin-bottom: 0;">
      <button class="tab-btn active" onclick="switchAssetTab('inventory', this)">Asset Inventory Directory</button>
      <button class="tab-btn" onclick="switchAssetTab('history', this)">Allocation Audit Log (<?= count($allocations) ?>)</button>
    </div>

    <!-- Filter Form -->
    <form action="<?= site_url('asset-management') ?>" method="GET" style="display: flex; gap: 8px;">
      <select name="category" class="form-control" style="font-size: 12px; padding: 6px 12px;" onchange="this.form.submit()">
        <option value="">All Categories</option>
        <option value="laptop" <?= ($categoryFilter === 'laptop') ? 'selected' : '' ?>>Laptops</option>
        <option value="desktop" <?= ($categoryFilter === 'desktop') ? 'selected' : '' ?>>Desktops</option>
        <option value="monitor" <?= ($categoryFilter === 'monitor') ? 'selected' : '' ?>>Monitors</option>
        <option value="access_card" <?= ($categoryFilter === 'access_card') ? 'selected' : '' ?>>Access Keys</option>
        <option value="furniture" <?= ($categoryFilter === 'furniture') ? 'selected' : '' ?>>Furniture</option>
      </select>
      <select name="status" class="form-control" style="font-size: 12px; padding: 6px 12px;" onchange="this.form.submit()">
        <option value="">All Statuses</option>
        <option value="available" <?= ($statusFilter === 'available') ? 'selected' : '' ?>>Available</option>
        <option value="allocated" <?= ($statusFilter === 'allocated') ? 'selected' : '' ?>>Allocated</option>
        <option value="maintenance" <?= ($statusFilter === 'maintenance') ? 'selected' : '' ?>>Maintenance</option>
      </select>
    </form>
  </div>

  <!-- TAB 1: INVENTORY DIRECTORY -->
  <div id="tab-inventory" class="tab-pane active" style="padding: 20px;">
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Asset Code</th>
            <th>Item Details</th>
            <th>Category</th>
            <th>Serial Number</th>
            <th>Current Assignee</th>
            <th>Valuation</th>
            <th>Warranty</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($assets)): ?>
            <tr><td colspan="9" style="text-align: center; color: #94a3b8; padding: 30px;">No assets found matching filters.</td></tr>
          <?php else: ?>
            <?php foreach ($assets as $a): ?>
              <tr>
                <td><strong><?= esc($a['asset_code']) ?></strong></td>
                <td>
                  <div style="font-weight: 700; color: #0f172a;"><?= esc($a['name']) ?></div>
                  <div style="font-size: 12px; color: #64748b;"><?= esc($a['brand']) ?> <?= esc($a['model']) ?></div>
                </td>
                <td>
                  <span class="badge" style="background: #f1f5f9; color: #475569; text-transform: uppercase; font-size: 10px;">
                    <?= esc($a['category']) ?>
                  </span>
                </td>
                <td><code style="background: #f8fafc; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;"><?= esc($a['serial_number']) ?></code></td>
                <td>
                  <?php if (!empty($a['current_employee_id'])): ?>
                    <a href="<?= site_url('employees/view/' . $a['current_employee_id']) ?>" style="text-decoration: none; display: flex; align-items: center; gap: 6px;">
                      <div class="avatar-sm" style="width: 24px; height: 24px; font-size: 10px;">
                        <?= esc(substr($a['first_name'], 0, 1) . substr($a['last_name'], 0, 1)) ?>
                      </div>
                      <span style="font-weight: 600; color: #2563eb; font-size: 13px;">
                        <?= esc($a['first_name'] . ' ' . $a['last_name']) ?>
                      </span>
                    </a>
                  <?php else: ?>
                    <span style="color: #94a3b8; font-style: italic; font-size: 12px;">Unassigned (Pool)</span>
                  <?php endif; ?>
                </td>
                <td>₹<?= number_format((float)$a['purchase_cost'], 2) ?></td>
                <td><?= !empty($a['warranty_expiry']) ? date('M d, Y', strtotime($a['warranty_expiry'])) : 'N/A' ?></td>
                <td>
                  <?php if ($a['status'] === 'allocated'): ?>
                    <span class="badge badge-primary">Allocated</span>
                  <?php elseif ($a['status'] === 'available'): ?>
                    <span class="badge badge-success">Available</span>
                  <?php elseif ($a['status'] === 'maintenance'): ?>
                    <span class="badge badge-danger">Maintenance</span>
                  <?php else: ?>
                    <span class="badge badge-secondary"><?= esc(ucfirst($a['status'])) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($a['status'] === 'allocated'): ?>
                    <button class="btn btn-outline btn-sm" style="font-size: 11px; padding: 4px 8px; color: #dc2626;" onclick="openReturnModal(<?= htmlspecialchars(json_encode($a)) ?>)">
                      Return Asset
                    </button>
                  <?php elseif ($a['status'] === 'available'): ?>
                    <button class="btn btn-primary btn-sm" style="font-size: 11px; padding: 4px 8px;" onclick="openQuickAllocate(<?= $a['id'] ?>)">
                      Assign
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

  <!-- TAB 2: ALLOCATION AUDIT LOG -->
  <div id="tab-history" class="tab-pane" style="display: none; padding: 20px;">
    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>Date &amp; Time</th>
            <th>Asset Code &amp; Name</th>
            <th>Employee</th>
            <th>Condition at Handover</th>
            <th>Return Status</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($allocations as $al): ?>
            <tr>
              <td><?= date('M d, Y H:i', strtotime($al['allocated_at'])) ?></td>
              <td><strong><?= esc($al['asset_code']) ?></strong> - <?= esc($al['asset_name']) ?></td>
              <td>
                <span style="font-weight: 600; color: #0f172a;"><?= esc($al['first_name'] . ' ' . $al['last_name']) ?></span>
                <span style="font-size: 11px; color: #64748b;">(<?= esc($al['employee_code']) ?>)</span>
              </td>
              <td><?= esc($al['condition_on_allocation']) ?></td>
              <td>
                <?php if (!empty($al['returned_at'])): ?>
                  <span class="badge badge-success">Returned on <?= date('M d, Y', strtotime($al['returned_at'])) ?></span>
                  <div style="font-size: 11px; color: #64748b;">Condition: <?= esc($al['condition_on_return']) ?></div>
                <?php else: ?>
                  <span class="badge badge-warning">Currently In Use</span>
                <?php endif; ?>
              </td>
              <td><?= esc($al['notes'] ?? '—') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL: REGISTER NEW ASSET -->
<div id="modalRegisterAsset" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 600px;">
    <div class="modal-header">
      <h3 class="modal-title">Register Asset in Inventory</h3>
      <button class="modal-close" onclick="document.getElementById('modalRegisterAsset').style.display='none'">&times;</button>
    </div>
    <form action="<?= site_url('asset-management/store') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div class="form-group">
          <label class="form-label">Asset / Device Name *</label>
          <input type="text" name="name" class="form-control" required placeholder="e.g. MacBook Pro 16 M3 Max">
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Category *</label>
            <select name="category" class="form-control" required>
              <option value="laptop">Laptop / Workstation</option>
              <option value="desktop">Desktop PC</option>
              <option value="monitor">External Monitor</option>
              <option value="mobile">Mobile / Tablet</option>
              <option value="access_card">Security Key / Access Card</option>
              <option value="peripherals">Peripherals (Dock, Headset)</option>
              <option value="furniture">Ergonomic Furniture</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Serial Number / Hardware ID *</label>
            <input type="text" name="serial_number" class="form-control" required placeholder="e.g. SN-APL-998811">
          </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" placeholder="Apple / Lenovo / Dell">
          </div>
          <div class="form-group">
            <label class="form-label">Model</label>
            <input type="text" name="model" class="form-control" placeholder="X1 Carbon / XPS 15">
          </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
          <div class="form-group">
            <label class="form-label">Purchase Cost (₹)</label>
            <input type="number" step="0.01" name="purchase_cost" class="form-control" placeholder="2500.00">
          </div>
          <div class="form-group">
            <label class="form-label">Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" value="<?= date('Y-m-d') ?>">
          </div>
          <div class="form-group">
            <label class="form-label">Warranty Expiry</label>
            <input type="date" name="warranty_expiry" class="form-control">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Initial Condition</label>
          <select name="condition_status" class="form-control">
            <option value="brand_new">Brand New (Sealed)</option>
            <option value="good" selected>Good Condition</option>
            <option value="fair">Fair Condition</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalRegisterAsset').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Asset</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: ALLOCATE ASSET -->
<div id="modalAllocateAsset" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 550px;">
    <div class="modal-header">
      <h3 class="modal-title">Handover &amp; Allocate Asset</h3>
      <button class="modal-close" onclick="document.getElementById('modalAllocateAsset').style.display='none'">&times;</button>
    </div>
    <form action="<?= site_url('asset-management/allocate') ?>" method="POST">
      <?= csrf_field() ?>
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div class="form-group">
          <label class="form-label">Select Available Asset *</label>
          <select name="asset_id" id="allocAssetSelect" class="form-control" required>
            <option value="">-- Choose Hardware from Available Pool --</option>
            <?php foreach ($assets as $a): ?>
              <?php if ($a['status'] === 'available'): ?>
                <option value="<?= $a['id'] ?>"><?= esc($a['asset_code']) ?> - <?= esc($a['name']) ?> (SN: <?= esc($a['serial_number']) ?>)</option>
              <?php endif; ?>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Assign to Employee *</label>
          <select name="employee_id" class="form-control" required>
            <option value="">-- Choose Assignee Employee --</option>
            <?php foreach ($employees as $emp): ?>
              <option value="<?= $emp['id'] ?>"><?= esc($emp['employee_code']) ?> - <?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Handover Condition Statement</label>
          <input type="text" name="condition_on_allocation" class="form-control" value="Good working condition with power brick and cables">
        </div>

        <div class="form-group">
          <label class="form-label">Handover Notes / Ticket ID</label>
          <textarea name="notes" class="form-control" rows="2" placeholder="Onboarding issuance, IT request reference..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalAllocateAsset').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary">Confirm Handover</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: RETURN ASSET -->
<div id="modalReturnAsset" class="modal-overlay" style="display: none;">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h3 class="modal-title">Acknowledge Asset Return</h3>
      <button class="modal-close" onclick="document.getElementById('modalReturnAsset').style.display='none'">&times;</button>
    </div>
    <form action="<?= site_url('asset-management/return') ?>" method="POST">
      <?= csrf_field() ?>
      <input type="hidden" name="asset_id" id="returnAssetId">
      <div class="modal-body" style="display: flex; flex-direction: column; gap: 14px;">
        <div id="returnAssetInfo" style="background: #f8fafc; padding: 12px; border-radius: 6px; font-weight: 600; color: #1e293b;"></div>

        <div class="form-group">
          <label class="form-label">Return Condition Status *</label>
          <input type="text" name="condition_on_return" class="form-control" required value="Returned in full working order without damage">
        </div>

        <div class="form-group">
          <label class="form-label">Release Asset Status *</label>
          <select name="asset_status" class="form-control" required>
            <option value="available">Available (Release back to inventory pool)</option>
            <option value="maintenance">Maintenance (Requires repair or re-imaging)</option>
            <option value="retired">Decommissioned / Retired</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalReturnAsset').style.display='none'">Cancel</button>
        <button type="submit" class="btn btn-primary" style="background: #dc2626; border-color: #dc2626;">Confirm Return</button>
      </div>
    </form>
  </div>
</div>

<script>
function switchAssetTab(tabId, btn) {
  document.getElementById('tab-inventory').style.display = (tabId === 'inventory') ? 'block' : 'none';
  document.getElementById('tab-history').style.display = (tabId === 'history') ? 'block' : 'none';
  
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function openQuickAllocate(assetId) {
  document.getElementById('allocAssetSelect').value = assetId;
  document.getElementById('modalAllocateAsset').style.display = 'flex';
}

function openReturnModal(asset) {
  document.getElementById('returnAssetId').value = asset.id;
  document.getElementById('returnAssetInfo').innerHTML = 'Returning: <strong>' + asset.name + '</strong> (' + asset.asset_code + ')<br>Assignee: ' + (asset.first_name ? asset.first_name + ' ' + asset.last_name : 'Assigned Staff');
  document.getElementById('modalReturnAsset').style.display = 'flex';
}
</script>
