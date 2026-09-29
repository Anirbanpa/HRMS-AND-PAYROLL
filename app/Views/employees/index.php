<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
      Employee Master Directory
    </h2>
    <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
      Showing <?= esc($totalCount) ?> registered personnel records across all active departments and global branches.
    </p>
  </div>
  <?php if (($currentRoleSlug ?? '') !== 'employee' && (in_array('employee.create', $userPermissions ?? []) || in_array($currentRoleSlug ?? '', ['super_admin', 'hr_admin', 'hr_executive']))): ?>
    <div>
      <a href="<?= site_url('employees/create') ?>" id="btnAddNewEmployee" class="btn btn-primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        Onboard New Employee
      </a>
    </div>
  <?php endif; ?>
</div>

<!-- FILTERS CONTAINER -->
<div class="card" style="margin-bottom: 20px;">
  <div class="card-body" style="padding: 16px 20px;">
    <form action="<?= site_url('employees') ?>" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 14px; align-items: flex-end;">
      <div class="form-group" style="margin-bottom: 0;">
        <label class="form-label" style="font-size: 12px;">Search Personnel</label>
        <input type="text" name="search" id="inputSearch" class="form-control" placeholder="Search by name, employee code, or email..." value="<?= esc($filters['search'] ?? '') ?>">
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label class="form-label" style="font-size: 12px;">Department</label>
        <select name="department_id" id="selectDepartment" class="form-control">
          <option value="">All Departments</option>
          <?php foreach ($departments as $dept): ?>
            <option value="<?= esc($dept['id']) ?>" <?= (($filters['department_id'] ?? '') == $dept['id']) ? 'selected' : '' ?>>
              <?= esc($dept['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label class="form-label" style="font-size: 12px;">Branch</label>
        <select name="branch_id" id="selectBranch" class="form-control">
          <option value="">All Branches</option>
          <?php foreach ($branches as $br): ?>
            <option value="<?= esc($br['id']) ?>" <?= (($filters['branch_id'] ?? '') == $br['id']) ? 'selected' : '' ?>>
              <?= esc($br['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-bottom: 0;">
        <label class="form-label" style="font-size: 12px;">Status</label>
        <select name="employment_status" id="selectStatus" class="form-control">
          <option value="">All Statuses</option>
          <option value="active" <?= (($filters['employment_status'] ?? '') == 'active') ? 'selected' : '' ?>>Active</option>
          <option value="on_leave" <?= (($filters['employment_status'] ?? '') == 'on_leave') ? 'selected' : '' ?>>On Leave</option>
          <option value="probation" <?= (($filters['employment_status'] ?? '') == 'probation') ? 'selected' : '' ?>>Probation</option>
          <option value="resigned" <?= (($filters['employment_status'] ?? '') == 'resigned') ? 'selected' : '' ?>>Resigned</option>
        </select>
      </div>

      <div style="display: flex; gap: 8px;">
        <button type="submit" id="btnFilterSubmit" class="btn btn-primary" style="height: 38px;">Filter</button>
        <a href="<?= site_url('employees') ?>" id="btnFilterReset" class="btn btn-outline" style="height: 38px;">Reset</a>
      </div>
    </form>
  </div>
</div>

<!-- EMPLOYEE DIRECTORY TABLE -->
<div class="card">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Employee ID</th>
          <th>Employee Details</th>
          <th>Designation</th>
          <th>Department</th>
          <th>Branch</th>
          <th>Reporting Manager</th>
          <th>Joining Date</th>
          <th>Status</th>
          <th style="text-align: right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($employees)): ?>
          <tr>
            <td colspan="9" style="text-align: center; padding: 40px; color: #64748b;">
              No employee records found matching your specified filters.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($employees as $emp): ?>
            <tr>
              <td>
                <span class="badge badge-primary"><?= esc($emp['employee_code']) ?></span>
              </td>
              <td>
                <div style="display: flex; align-items: center; gap: 12px;">
                  <?php if (!empty($emp['profile_photo']) && file_exists(FCPATH . $emp['profile_photo'])): ?>
                    <img src="<?= base_url(esc($emp['profile_photo'])) ?>" alt="<?= esc($emp['first_name']) ?>" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--border-color); flex-shrink: 0;">
                  <?php else: ?>
                    <div class="avatar-sm" style="background: #4f46e5; flex-shrink: 0;">
                      <?= esc(substr($emp['first_name'], 0, 1) . substr($emp['last_name'], 0, 1)) ?>
                    </div>
                  <?php endif; ?>
                  <div>
                    <div style="font-weight: 700; color: #0f172a;"><?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?></div>
                    <div style="font-size: 12px; color: #64748b;"><?= esc($emp['email']) ?></div>
                    <div style="font-size: 11px; color: #94a3b8;"><?= esc($emp['phone']) ?></div>
                  </div>
                </div>
              </td>
              <td>
                <div style="font-weight: 600;"><?= esc($emp['designation_name'] ?? 'Not Assigned') ?></div>
                <div style="font-size: 11px; color: #64748b;"><?= esc($emp['grade_code'] ?? '') ?></div>
              </td>
              <td><?= esc($emp['department_name'] ?? 'Unassigned') ?></td>
              <td><?= esc($emp['branch_name'] ?? 'HQ') ?></td>
              <td>
                <?php if ($emp['manager_first_name']): ?>
                  <span style="font-size: 12.5px;"><?= esc($emp['manager_first_name'] . ' ' . $emp['manager_last_name']) ?></span>
                <?php else: ?>
                  <span style="color: #94a3b8; font-size: 12px;">Direct Executive</span>
                <?php endif; ?>
              </td>
              <td><?= esc($emp['joining_date']) ?></td>
              <td>
                <?php if ($emp['employment_status'] === 'active'): ?>
                  <span class="badge badge-success">Active</span>
                <?php else: ?>
                  <span class="badge badge-warning"><?= esc(ucfirst($emp['employment_status'])) ?></span>
                <?php endif; ?>
              </td>
              <td style="text-align: right; white-space: nowrap;">
                <div style="display: inline-flex; gap: 6px; align-items: center;">
                  <a href="<?= site_url('employees/view/' . $emp['id']) ?>" id="btnView360_<?= $emp['id'] ?>" class="btn btn-outline btn-sm">
                    360° Profile
                  </a>
                  <?php if (($currentRoleSlug ?? '') === 'super_admin' || in_array('employee.delete', $userPermissions ?? [])): ?>
                    <button type="button" class="btn btn-danger btn-sm" style="padding: 4px 8px;" onclick="openDeleteDialog(<?= $emp['id'] ?>, '<?= esc(addslashes($emp['first_name'] . ' ' . $emp['last_name'])) ?>', '<?= esc(addslashes($emp['employee_code'])) ?>')" title="Delete Employee">
                      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- GLOBAL EMPLOYEE DELETE CONFIRMATION MODAL -->
<?php if (($currentRoleSlug ?? '') === 'super_admin' || in_array('employee.delete', $userPermissions ?? [])): ?>
<div id="modalDeleteEmpIndex" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
  <div style="background: var(--bg-card, #ffffff); border: 1px solid var(--border-color, #e2e8f0); border-radius: 16px; width: 100%; max-width: 480px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4); overflow: hidden; animation: popIn 0.2s ease-out;">
    <div style="padding: 24px; border-bottom: 1px solid var(--border-color, #e2e8f0); display: flex; align-items: center; gap: 14px;">
      <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(239, 68, 68, 0.12); color: #dc2626; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      </div>
      <div>
        <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: var(--text-main, #0f172a);">Delete Employee Profile</h3>
        <p style="margin: 2px 0 0; font-size: 13px; color: #64748b;">Permanent record removal &amp; archiving</p>
      </div>
    </div>
    <div style="padding: 24px; font-size: 14px; line-height: 1.6; color: var(--text-main, #334155);">
      <p style="margin: 0 0 12px;">
        Are you sure you want to delete employee <strong id="deleteEmpName"></strong> (<code id="deleteEmpCode"></code>)?
      </p>
      <div style="background: rgba(239, 68, 68, 0.08); border-left: 4px solid #ef4444; padding: 12px 14px; border-radius: 6px; font-size: 12.5px; color: #b91c1c;">
        <strong>Warning:</strong> This will archive the master profile, terminate employment status, deactivate user access, and remove the record from active directories.
      </div>
    </div>
    <div style="padding: 16px 24px; background: var(--bg-card-subtle, #f8fafc); border-top: 1px solid var(--border-color, #e2e8f0); display: flex; justify-content: flex-end; gap: 10px;">
      <button type="button" class="btn btn-outline" onclick="document.getElementById('modalDeleteEmpIndex').style.display='none'">
        Cancel
      </button>
      <form id="formDeleteEmpIndex" action="" method="POST" style="margin: 0;">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 6px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          Confirm Delete
        </button>
      </form>
    </div>
  </div>
</div>

<script>
function openDeleteDialog(empId, empName, empCode) {
  document.getElementById('deleteEmpName').innerText = empName;
  document.getElementById('deleteEmpCode').innerText = empCode;
  document.getElementById('formDeleteEmpIndex').action = "<?= site_url('employees/delete') ?>/" + empId;
  document.getElementById('modalDeleteEmpIndex').style.display = 'flex';
}
</script>
<?php endif; ?>

