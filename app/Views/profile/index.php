<div class="grid-2-1">
  <!-- Left Column: Identity & Account Summary -->
  <div style="display: flex; flex-direction: column; gap: 20px;">
    <div class="card">
      <div class="card-header">
        <div class="card-title">User Account Details</div>
        <span class="badge badge-success"><?= esc(ucfirst($user['status'])) ?></span>
      </div>
      <div class="card-body">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
          <div style="width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%); display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 800; color: #fff; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
            <?= esc(substr($currentUser['full_name'] ?? $user['username'], 0, 2)) ?>
          </div>
          <div>
            <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0;"><?= esc($currentUser['full_name'] ?? $user['username']) ?></h3>
            <span class="badge badge-primary" style="margin-top: 4px;"><?= esc($user['role_name']) ?></span>
          </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px; font-size: 13px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
          <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Username:</span>
            <strong style="color: #0f172a;"><?= esc($user['username']) ?></strong>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Email Address:</span>
            <strong style="color: #0f172a;"><?= esc($user['email']) ?></strong>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Two-Factor Auth:</span>
            <span style="color: <?= $user['two_factor_enabled'] ? '#10b981' : '#f59e0b' ?>; font-weight: 600;">
              <?= $user['two_factor_enabled'] ? 'Enabled' : 'Disabled (Optional)' ?>
            </span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Last Login:</span>
            <span style="color: #475569;"><?= esc($user['last_login_at'] ?? 'Current session') ?></span>
          </div>
          <div style="display: flex; justify-content: space-between;">
            <span style="color: #64748b;">Last Login IP:</span>
            <code style="color: #475569; font-size: 11px;"><?= esc($user['last_login_ip'] ?? '127.0.0.1') ?></code>
          </div>
        </div>
      </div>
    </div>

    <!-- Linked Employee Record -->
    <?php if ($employee): ?>
      <div class="card">
        <div class="card-header">
          <div class="card-title">Linked Corporate Profile</div>
          <a href="<?= site_url('employees/view/' . $employee['id']) ?>" class="btn btn-outline btn-sm">Full 360° Profile</a>
        </div>
        <div class="card-body">
          <div style="display: flex; flex-direction: column; gap: 10px; font-size: 13px;">
            <div style="display: flex; justify-content: space-between;">
              <span style="color: #64748b;">Employee Code:</span>
              <strong style="color: #4f46e5;"><?= esc($employee['employee_code']) ?></strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span style="color: #64748b;">Designation:</span>
              <strong style="color: #0f172a;"><?= esc($employee['designation_name'] ?? 'N/A') ?></strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span style="color: #64748b;">Department:</span>
              <strong style="color: #0f172a;"><?= esc($employee['department_name'] ?? 'N/A') ?></strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span style="color: #64748b;">Branch:</span>
              <strong style="color: #0f172a;"><?= esc($employee['branch_name'] ?? 'N/A') ?></strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span style="color: #64748b;">Joining Date:</span>
              <strong style="color: #0f172a;"><?= esc($employee['joining_date'] ?? 'N/A') ?></strong>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Right Column: Password Management & Activity -->
  <div style="display: flex; flex-direction: column; gap: 20px;">
    <!-- Password Change Form -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">Change Password &amp; Credentials</div>
        <span style="font-size: 12px; color: #64748b;">Bcrypt Hashed</span>
      </div>
      <div class="card-body">
        <form action="<?= site_url('profile/password') ?>" method="POST" id="formChangePassword">
          <?= csrf_field() ?>

          <div class="form-group">
            <label class="form-label" for="current_password">Current Password <span style="color: #ef4444;">*</span></label>
            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter your current password" required>
          </div>

          <div class="grid-2">
            <div class="form-group">
              <label class="form-label" for="new_password">New Password <span style="color: #ef4444;">*</span></label>
              <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Minimum 8 characters" required minlength="8">
            </div>

            <div class="form-group">
              <label class="form-label" for="confirm_password">Confirm New Password <span style="color: #ef4444;">*</span></label>
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Re-type new password" required minlength="8">
            </div>
          </div>

          <div style="display: flex; justify-content: flex-end; margin-top: 8px;">
            <button type="submit" class="btn btn-primary" id="btnUpdatePassword">
              Update Password
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Security Activity Logs for User -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">My Recent Activity &amp; Session Logs</div>
        <a href="<?= site_url('audit') ?>" class="btn btn-outline btn-sm">Full System Audit</a>
      </div>
      <div class="card-body" style="padding: 0;">
        <table class="table" style="margin-bottom: 0;">
          <thead>
            <tr>
              <th>Action</th>
              <th>Module</th>
              <th>Description</th>
              <th>IP Address</th>
              <th>Timestamp</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($recentLogs)): ?>
              <tr>
                <td colspan="5" style="text-align: center; color: #94a3b8; padding: 24px;">No recent security actions logged for this session.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($recentLogs as $log): ?>
                <tr>
                  <td><span class="badge badge-primary"><?= esc($log['action']) ?></span></td>
                  <td><code><?= esc($log['module']) ?></code></td>
                  <td style="font-size: 12.5px;"><?= esc($log['description']) ?></td>
                  <td><code style="font-size: 11px;"><?= esc($log['ip_address'] ?? '127.0.0.1') ?></code></td>
                  <td style="font-size: 11.5px; color: #64748b;"><?= esc($log['created_at']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
