<style>
.active-pill {
  background: var(--primary) !important;
  color: #ffffff !important;
  box-shadow: 0 2px 6px var(--primary-glow);
}
.inactive-pill {
  background: transparent !important;
  color: var(--text-muted, #64748b) !important;
}
.inactive-pill:hover {
  color: var(--text-main, #0f172a) !important;
  background: rgba(0,0,0,0.05) !important;
}
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
  <div>
    <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
      Department &amp; Designation Management
    </h2>
    <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
      Define corporate organizational units, departmental heads, job designations, and pay grade alignments.
    </p>
  </div>
</div>

<!-- VIEW SWITCHER TABS -->
<div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
  <button type="button" class="btn <?= ($activeTab === 'departments') ? 'btn-primary' : 'btn-outline' ?>" 
          id="btnTabDepartments" onclick="switchMainTab('departments')"
          style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
    Corporate Departments (<?= count($departments) ?>)
  </button>
  <button type="button" class="btn <?= ($activeTab === 'designations') ? 'btn-primary' : 'btn-outline' ?>" 
          id="btnTabDesignations" onclick="switchMainTab('designations')"
          style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
    Job Designations (<?= count($designations) ?>)
  </button>
</div>

<div class="grid-2-1">
  <!-- LEFT COLUMN: TABLES -->
  <div>
    <!-- 1. DEPARTMENTS TABLE -->
    <div id="panelDepartments" class="card" style="<?= ($activeTab === 'designations') ? 'display: none;' : '' ?>">
      <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="card-title">Corporate Departments (<?= count($departments) ?> Active)</div>
        <button type="button" class="btn btn-sm btn-outline" onclick="switchRightForm('department')" style="display: inline-flex; align-items: center; gap: 4px; font-size: 12px;">
          + New Department
        </button>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Department Code</th>
              <th>Department Name</th>
              <th>Head of Department</th>
              <th>Operating Branch</th>
              <th>Staff Count</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($departments)): ?>
              <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 24px;">No departments found.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($departments as $dept): ?>
                <tr>
                  <td>
                    <span class="badge badge-primary"><?= esc($dept['code']) ?></span>
                  </td>
                  <td>
                    <div style="font-weight: 700; color: #0f172a;"><?= esc($dept['name']) ?></div>
                    <?php if ($dept['parent_dept_name']): ?>
                      <div style="font-size: 11px; color: #64748b;">Under: <?= esc($dept['parent_dept_name']) ?></div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($dept['head_first_name']): ?>
                      <div style="font-weight: 600;"><?= esc($dept['head_first_name'] . ' ' . $dept['head_last_name']) ?></div>
                      <div style="font-size: 11px; color: #64748b;"><?= esc($dept['head_code']) ?></div>
                    <?php else: ?>
                      <span style="color: #94a3b8; font-size: 12px;">Unassigned</span>
                    <?php endif; ?>
                  </td>
                  <td><?= esc($dept['branch_name'] ?? 'Kolkata Headquarters') ?></td>
                  <td>
                    <span class="badge badge-secondary" style="font-weight: 700;">
                      <?= esc($dept['employee_count']) ?> members
                    </span>
                  </td>
                  <td>
                    <?php if ($dept['status'] === 'active'): ?>
                      <span class="badge badge-success">Active</span>
                    <?php else: ?>
                      <span class="badge badge-warning">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td style="text-align: right; white-space: nowrap;">
                    <div style="display: inline-flex; gap: 6px; align-items: center;">
                      <button type="button" class="btn btn-outline btn-sm btn-edit-dept" 
                              data-dept="<?= htmlspecialchars(json_encode($dept), ENT_QUOTES, 'UTF-8') ?>"
                              onclick="openEditDeptModal(this)"
                              title="Edit Department" 
                              style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 12px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                      </button>
                      <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
                      <button type="button" class="btn btn-sm btn-delete-dept" 
                              onclick="openDeleteDeptModal(<?= (int)$dept['id'] ?>, '<?= esc($dept['name'], 'js') ?>', <?= (int)$dept['employee_count'] ?>)"
                              title="Delete Department" 
                              style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 12px; background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.25);">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        Delete
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

    <!-- 2. DESIGNATIONS TABLE -->
    <div id="panelDesignations" class="card" style="<?= ($activeTab !== 'designations') ? 'display: none;' : '' ?>">
      <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="card-title">Job Designations (<?= count($designations) ?> Active)</div>
        <button type="button" class="btn btn-sm btn-outline" onclick="switchRightForm('designation')" style="display: inline-flex; align-items: center; gap: 4px; font-size: 12px;">
          + New Designation
        </button>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Designation Code</th>
              <th>Designation Title</th>
              <th>Department</th>
              <th>Pay Grade / Band</th>
              <th>Staff Count</th>
              <th>Status</th>
              <th style="text-align: right;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($designations)): ?>
              <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 24px;">No designations found. Create one using the form on the right.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($designations as $desig): ?>
                <tr>
                  <td>
                    <span class="badge badge-primary"><?= esc($desig['code']) ?></span>
                  </td>
                  <td>
                    <div style="font-weight: 700; color: #0f172a;"><?= esc($desig['name']) ?></div>
                    <?php if (!empty($desig['description'])): ?>
                      <div style="font-size: 11px; color: #64748b;"><?= esc($desig['description']) ?></div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($desig['department_name'])): ?>
                      <span class="badge badge-secondary"><?= esc($desig['department_name']) ?></span>
                    <?php else: ?>
                      <span style="color: #94a3b8; font-size: 12px;">General / All</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($desig['grade_name'])): ?>
                      <div style="font-weight: 600; font-size: 12px;"><?= esc($desig['grade_name']) ?> (<?= esc($desig['grade_code']) ?>)</div>
                      <div style="font-size: 11px; color: #64748b;">₹<?= number_format($desig['min_salary']) ?> - ₹<?= number_format($desig['max_salary']) ?></div>
                    <?php else: ?>
                      <span style="color: #94a3b8; font-size: 12px;">Standard Band</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="badge badge-secondary" style="font-weight: 700;">
                      <?= (int)($desig['employee_count'] ?? 0) ?> members
                    </span>
                  </td>
                  <td>
                    <?php if ($desig['status'] === 'active'): ?>
                      <span class="badge badge-success">Active</span>
                    <?php else: ?>
                      <span class="badge badge-warning">Inactive</span>
                    <?php endif; ?>
                  </td>
                  <td style="text-align: right; white-space: nowrap;">
                    <div style="display: inline-flex; gap: 6px; align-items: center;">
                      <button type="button" class="btn btn-outline btn-sm btn-edit-desig" 
                              data-desig="<?= htmlspecialchars(json_encode($desig), ENT_QUOTES, 'UTF-8') ?>"
                              onclick="openEditDesigModal(this)"
                              title="Edit Designation" 
                              style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 12px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                      </button>
                      <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
                      <button type="button" class="btn btn-sm btn-delete-desig" 
                              onclick="openDeleteDesigModal(<?= (int)$desig['id'] ?>, '<?= esc($desig['name'], 'js') ?>', <?= (int)($desig['employee_count'] ?? 0) ?>)"
                              title="Delete Designation" 
                              style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 12px; background: rgba(239, 68, 68, 0.12); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.25);">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        Delete
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
  </div>

  <!-- RIGHT COLUMN: DUAL-PURPOSE CREATE CARD -->
  <div class="card" style="height: fit-content;">
    <div class="card-header" style="display: block; padding-bottom: 12px;">
      <div class="card-title" id="formHeaderTitle" style="margin-bottom: 10px;">
        <?= ($formTab === 'designation') ? 'Create New Designation' : 'Create New Department' ?>
      </div>

      <!-- Segmented Pill Switcher -->
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4px; background: rgba(0,0,0,0.06); padding: 4px; border-radius: 8px;">
        <button type="button" id="pillTabDept" onclick="switchRightForm('department')"
                class="<?= ($formTab !== 'designation') ? 'active-pill' : 'inactive-pill' ?>"
                style="border: none; padding: 7px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px; transition: all 0.2s;">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
          Department
        </button>
        <button type="button" id="pillTabDesig" onclick="switchRightForm('designation')"
                class="<?= ($formTab === 'designation') ? 'active-pill' : 'inactive-pill' ?>"
                style="border: none; padding: 7px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px; transition: all 0.2s;">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
          Designation
        </button>
      </div>
    </div>

    <div class="card-body">
      <!-- 1. CREATE DEPARTMENT FORM -->
      <form action="<?= site_url('departments/store') ?>" method="POST" id="formAddDept" style="<?= ($formTab === 'designation') ? 'display: none;' : '' ?>">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label" for="dept_name">Department Name *</label>
          <input type="text" name="name" id="dept_name" class="form-control" placeholder="e.g. Quality Assurance & Testing" required value="<?= old('name') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="dept_code">Department Code *</label>
          <input type="text" name="code" id="dept_code" class="form-control" placeholder="e.g. DEP-QA" required style="text-transform: uppercase;" value="<?= old('code') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="dept_branch_id">Operating Branch</label>
          <select name="branch_id" id="dept_branch_id" class="form-control">
            <?php foreach ($branches as $br): ?>
              <option value="<?= esc($br['id']) ?>"><?= esc($br['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="dept_head_id">Department Head</label>
          <select name="head_employee_id" id="dept_head_id" class="form-control">
            <option value="">Select Department Head (Optional)</option>
            <?php foreach ($employees as $emp): ?>
              <option value="<?= esc($emp['id']) ?>"><?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= esc($emp['employee_code']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <button type="submit" id="btnSaveDept" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
          Create Department
        </button>
      </form>

      <!-- 2. CREATE DESIGNATION FORM -->
      <form action="<?= site_url('designations/store') ?>" method="POST" id="formAddDesig" style="<?= ($formTab === 'designation') ? '' : 'display: none;' ?>">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label" for="desig_name">Designation Title *</label>
          <input type="text" name="name" id="desig_name" class="form-control" placeholder="e.g. Senior Software Architect" required value="<?= old('name') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="desig_code">Designation Code *</label>
          <input type="text" name="code" id="desig_code" class="form-control" placeholder="e.g. DES-ARCH-01" required style="text-transform: uppercase;" value="<?= old('code') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="desig_dept_id">Assigned Department</label>
          <select name="department_id" id="desig_dept_id" class="form-control">
            <option value="">Select Department (Optional)</option>
            <?php foreach ($departments as $dept): ?>
              <option value="<?= esc($dept['id']) ?>"><?= esc($dept['name']) ?> (<?= esc($dept['code']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="desig_grade_id">Compensation Pay Grade</label>
          <select name="grade_band_id" id="desig_grade_id" class="form-control">
            <option value="">Select Compensation Band (Optional)</option>
            <?php foreach ($payGrades as $pg): ?>
              <option value="<?= esc($pg['id']) ?>">
                <?= esc($pg['grade_code']) ?> &bull; <?= esc($pg['grade_name']) ?> (₹<?= number_format($pg['min_salary']) ?> - ₹<?= number_format($pg['max_salary']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="desig_description">Description / Responsibilities</label>
          <textarea name="description" id="desig_description" class="form-control" rows="2" placeholder="Primary role responsibilities and scope..."></textarea>
        </div>

        <div class="form-group">
          <label class="form-label" for="desig_status">Operational Status</label>
          <select name="status" id="desig_status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <button type="submit" id="btnSaveDesig" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
          Create Designation
        </button>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- 1. EDIT DEPARTMENT MODAL                                       -->
<!-- ============================================================== -->
<div id="modalEditDept" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
  <div class="card" style="width: 100%; max-width: 520px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; background: var(--bg-card, #ffffff);">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding: 16px 20px; background: var(--bg-card-subtle, #f8fafc);">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(140, 122, 169, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
          ✏️
        </div>
        <div>
          <div class="card-title" style="margin: 0; font-size: 16px; font-weight: 700;">Edit Department</div>
          <div style="font-size: 12px; color: #64748b;">Update organizational unit properties and leadership</div>
        </div>
      </div>
      <button type="button" onclick="closeEditDeptModal()" style="background: none; border: none; font-size: 22px; line-height: 1; color: #94a3b8; cursor: pointer; padding: 4px; border-radius: 6px;" title="Close Modal">&times;</button>
    </div>
    
    <div class="card-body" style="padding: 20px;">
      <form id="formEditDept" method="POST" action="">
        <?= csrf_field() ?>

        <div class="form-group" style="margin-bottom: 14px;">
          <label class="form-label" for="edit_dept_name">Department Name *</label>
          <input type="text" name="name" id="edit_dept_name" class="form-control" required placeholder="e.g. Quality Assurance">
        </div>

        <div class="form-group" style="margin-bottom: 14px;">
          <label class="form-label" for="edit_dept_code">Department Code *</label>
          <input type="text" name="code" id="edit_dept_code" class="form-control" required placeholder="e.g. DEP-QA" style="text-transform: uppercase;">
        </div>

        <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
          <div class="form-group">
            <label class="form-label" for="edit_branch_id">Operating Branch</label>
            <select name="branch_id" id="edit_branch_id" class="form-control">
              <?php foreach ($branches as $br): ?>
                <option value="<?= esc($br['id']) ?>"><?= esc($br['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="edit_status">Operational Status</label>
            <select name="status" id="edit_status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
          <label class="form-label" for="edit_head_id">Department Head</label>
          <select name="head_employee_id" id="edit_head_id" class="form-control">
            <option value="">Select Department Head (Optional)</option>
            <?php foreach ($employees as $emp): ?>
              <option value="<?= esc($emp['id']) ?>"><?= esc($emp['first_name'] . ' ' . $emp['last_name']) ?> (<?= esc($emp['employee_code']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px;">
          <button type="button" class="btn btn-outline" onclick="closeEditDeptModal()">Cancel</button>
          <button type="submit" id="btnUpdateDept" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- 2. DELETE DEPARTMENT MODAL                                     -->
<!-- ============================================================== -->
<?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
<div id="modalDeleteDept" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
  <div class="card" style="width: 100%; max-width: 480px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 14px; overflow: hidden; background: var(--bg-card, #ffffff);">
    <div class="card-header" style="background: rgba(239, 68, 68, 0.08); border-bottom: 1px solid rgba(239, 68, 68, 0.2); padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(239, 68, 68, 0.15); color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 16px;">
          ⚠️
        </div>
        <div class="card-title" style="margin: 0; font-size: 16px; color: #dc2626; font-weight: 700;">Delete Department</div>
      </div>
      <button type="button" onclick="closeDeleteDeptModal()" style="background: none; border: none; font-size: 22px; line-height: 1; color: #94a3b8; cursor: pointer; padding: 4px;" title="Close Modal">&times;</button>
    </div>
    
    <div class="card-body" style="padding: 20px;">
      <form id="formDeleteDept" method="POST" action="">
        <?= csrf_field() ?>
        
        <p style="font-size: 14px; color: var(--text-main, #1e293b); margin: 0 0 12px; line-height: 1.5;">
          Are you sure you want to permanently delete the department: <strong id="deleteDeptNameText" style="color: #dc2626;"></strong>?
        </p>

        <div id="deleteDeptStaffWarning" style="display: none; background: #fffbeb; border: 1px solid #fef3c7; color: #92400e; padding: 12px 14px; border-radius: 8px; font-size: 12.5px; margin-bottom: 16px; line-height: 1.4;">
          <div style="font-weight: 700; margin-bottom: 2px;">⚠️ Staff Assignment Notice</div>
          This department currently has <strong id="deleteDeptStaffCount"></strong> staff member(s). Deleting it will safely move them to <em>"Unassigned"</em> without removing their employee accounts.
        </div>

        <p style="font-size: 12px; color: #64748b; margin: 0 0 20px 0;">
          This action will be logged in the system audit trail and cannot be undone.
        </p>

        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px;">
          <button type="button" class="btn btn-outline" onclick="closeDeleteDeptModal()">Cancel</button>
          <button type="submit" id="btnConfirmDeleteDept" class="btn btn-danger" style="background: #dc2626; border-color: #dc2626; color: #ffffff; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            Yes, Delete Department
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- ============================================================== -->
<!-- 3. EDIT DESIGNATION MODAL                                      -->
<!-- ============================================================== -->
<div id="modalEditDesig" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
  <div class="card" style="width: 100%; max-width: 520px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; background: var(--bg-card, #ffffff);">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color); padding: 16px 20px; background: var(--bg-card-subtle, #f8fafc);">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(140, 122, 169, 0.15); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
          💼
        </div>
        <div>
          <div class="card-title" style="margin: 0; font-size: 16px; font-weight: 700;">Edit Designation</div>
          <div style="font-size: 12px; color: #64748b;">Update designation title, department link, and pay grade</div>
        </div>
      </div>
      <button type="button" onclick="closeEditDesigModal()" style="background: none; border: none; font-size: 22px; line-height: 1; color: #94a3b8; cursor: pointer; padding: 4px; border-radius: 6px;" title="Close Modal">&times;</button>
    </div>
    
    <div class="card-body" style="padding: 20px;">
      <form id="formEditDesig" method="POST" action="">
        <?= csrf_field() ?>

        <div class="form-group" style="margin-bottom: 14px;">
          <label class="form-label" for="edit_desig_name">Designation Title *</label>
          <input type="text" name="name" id="edit_desig_name" class="form-control" required placeholder="e.g. Senior Software Architect">
        </div>

        <div class="form-group" style="margin-bottom: 14px;">
          <label class="form-label" for="edit_desig_code">Designation Code *</label>
          <input type="text" name="code" id="edit_desig_code" class="form-control" required placeholder="e.g. DES-ARCH-01" style="text-transform: uppercase;">
        </div>

        <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
          <div class="form-group">
            <label class="form-label" for="edit_desig_dept_id">Department</label>
            <select name="department_id" id="edit_desig_dept_id" class="form-control">
              <option value="">General / All</option>
              <?php foreach ($departments as $dept): ?>
                <option value="<?= esc($dept['id']) ?>"><?= esc($dept['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="edit_desig_status">Operational Status</label>
            <select name="status" id="edit_desig_status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="form-group" style="margin-bottom: 14px;">
          <label class="form-label" for="edit_desig_grade_id">Compensation Pay Grade</label>
          <select name="grade_band_id" id="edit_desig_grade_id" class="form-control">
            <option value="">Select Compensation Band (Optional)</option>
            <?php foreach ($payGrades as $pg): ?>
              <option value="<?= esc($pg['id']) ?>">
                <?= esc($pg['grade_code']) ?> &bull; <?= esc($pg['grade_name']) ?> (₹<?= number_format($pg['min_salary']) ?> - ₹<?= number_format($pg['max_salary']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
          <label class="form-label" for="edit_desig_description">Description / Scope</label>
          <textarea name="description" id="edit_desig_description" class="form-control" rows="2" placeholder="Responsibilities and scope..."></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px;">
          <button type="button" class="btn btn-outline" onclick="closeEditDesigModal()">Cancel</button>
          <button type="submit" id="btnUpdateDesig" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ============================================================== -->
<!-- 4. DELETE DESIGNATION MODAL                                    -->
<!-- ============================================================== -->
<?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
<div id="modalDeleteDesig" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
  <div class="card" style="width: 100%; max-width: 480px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 14px; overflow: hidden; background: var(--bg-card, #ffffff);">
    <div class="card-header" style="background: rgba(239, 68, 68, 0.08); border-bottom: 1px solid rgba(239, 68, 68, 0.2); padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(239, 68, 68, 0.15); color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 16px;">
          ⚠️
        </div>
        <div class="card-title" style="margin: 0; font-size: 16px; color: #dc2626; font-weight: 700;">Delete Designation</div>
      </div>
      <button type="button" onclick="closeDeleteDesigModal()" style="background: none; border: none; font-size: 22px; line-height: 1; color: #94a3b8; cursor: pointer; padding: 4px;" title="Close Modal">&times;</button>
    </div>
    
    <div class="card-body" style="padding: 20px;">
      <form id="formDeleteDesig" method="POST" action="">
        <?= csrf_field() ?>
        
        <p style="font-size: 14px; color: var(--text-main, #1e293b); margin: 0 0 12px; line-height: 1.5;">
          Are you sure you want to permanently delete the designation: <strong id="deleteDesigNameText" style="color: #dc2626;"></strong>?
        </p>

        <div id="deleteDesigStaffWarning" style="display: none; background: #fffbeb; border: 1px solid #fef3c7; color: #92400e; padding: 12px 14px; border-radius: 8px; font-size: 12.5px; margin-bottom: 16px; line-height: 1.4;">
          <div style="font-weight: 700; margin-bottom: 2px;">⚠️ Staff Assignment Notice</div>
          This designation currently has <strong id="deleteDesigStaffCount"></strong> staff member(s). Deleting it will safely set them to <em>"Unassigned Designation"</em> without removing their employee accounts.
        </div>

        <p style="font-size: 12px; color: #64748b; margin: 0 0 20px 0;">
          This action will be logged in the system audit trail and cannot be undone.
        </p>

        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--border-color); padding-top: 16px;">
          <button type="button" class="btn btn-outline" onclick="closeDeleteDesigModal()">Cancel</button>
          <button type="submit" id="btnConfirmDeleteDesig" class="btn btn-danger" style="background: #dc2626; border-color: #dc2626; color: #ffffff; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            Yes, Delete Designation
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
// --- MAIN TABLE TABS ---
function switchMainTab(tab) {
  const panelDept = document.getElementById('panelDepartments');
  const panelDesig = document.getElementById('panelDesignations');
  const btnDept = document.getElementById('btnTabDepartments');
  const btnDesig = document.getElementById('btnTabDesignations');

  if (tab === 'departments') {
    panelDept.style.display = 'block';
    panelDesig.style.display = 'none';
    btnDept.className = 'btn btn-primary';
    btnDesig.className = 'btn btn-outline';
  } else {
    panelDept.style.display = 'none';
    panelDesig.style.display = 'block';
    btnDept.className = 'btn btn-outline';
    btnDesig.className = 'btn btn-primary';
  }

  // Update URL state without page reload
  const url = new URL(window.location);
  url.searchParams.set('tab', tab);
  window.history.replaceState({}, '', url);
}

// --- RIGHT FORM TABS ---
function switchRightForm(type) {
  const formDept = document.getElementById('formAddDept');
  const formDesig = document.getElementById('formAddDesig');
  const pillDept = document.getElementById('pillTabDept');
  const pillDesig = document.getElementById('pillTabDesig');
  const formTitle = document.getElementById('formHeaderTitle');

  if (type === 'department') {
    formDept.style.display = 'block';
    formDesig.style.display = 'none';
    pillDept.className = 'active-pill';
    pillDesig.className = 'inactive-pill';
    formTitle.textContent = 'Create New Department';
  } else {
    formDept.style.display = 'none';
    formDesig.style.display = 'block';
    pillDept.className = 'inactive-pill';
    pillDesig.className = 'active-pill';
    formTitle.textContent = 'Create New Designation';
  }
}

// --- DEPARTMENT MODALS ---
function openEditDeptModal(btn) {
  try {
    const dept = JSON.parse(btn.getAttribute('data-dept'));
    const modal = document.getElementById('modalEditDept');
    const form = document.getElementById('formEditDept');
    
    form.action = '<?= site_url('departments/update') ?>/' + dept.id;
    document.getElementById('edit_dept_name').value = dept.name || '';
    document.getElementById('edit_dept_code').value = dept.code || '';
    document.getElementById('edit_branch_id').value = dept.branch_id || '1';
    document.getElementById('edit_status').value = dept.status || 'active';
    document.getElementById('edit_head_id').value = dept.head_employee_id || '';
    
    modal.style.display = 'flex';
  } catch (err) {
    console.error('Error parsing department data:', err);
  }
}

function closeEditDeptModal() {
  const modal = document.getElementById('modalEditDept');
  if (modal) modal.style.display = 'none';
}

function openDeleteDeptModal(id, name, staffCount) {
  const modal = document.getElementById('modalDeleteDept');
  const form = document.getElementById('formDeleteDept');
  
  form.action = '<?= site_url('departments/delete') ?>/' + id;
  document.getElementById('deleteDeptNameText').textContent = name;
  
  const warn = document.getElementById('deleteDeptStaffWarning');
  if (staffCount > 0) {
    document.getElementById('deleteDeptStaffCount').textContent = staffCount;
    warn.style.display = 'block';
  } else {
    warn.style.display = 'none';
  }
  
  modal.style.display = 'flex';
}

function closeDeleteDeptModal() {
  const modal = document.getElementById('modalDeleteDept');
  if (modal) modal.style.display = 'none';
}

// --- DESIGNATION MODALS ---
function openEditDesigModal(btn) {
  try {
    const desig = JSON.parse(btn.getAttribute('data-desig'));
    const modal = document.getElementById('modalEditDesig');
    const form = document.getElementById('formEditDesig');
    
    form.action = '<?= site_url('designations/update') ?>/' + desig.id;
    document.getElementById('edit_desig_name').value = desig.name || '';
    document.getElementById('edit_desig_code').value = desig.code || '';
    document.getElementById('edit_desig_dept_id').value = desig.department_id || '';
    document.getElementById('edit_desig_grade_id').value = desig.grade_band_id || '';
    document.getElementById('edit_desig_description').value = desig.description || '';
    document.getElementById('edit_desig_status').value = desig.status || 'active';
    
    modal.style.display = 'flex';
  } catch (err) {
    console.error('Error parsing designation data:', err);
  }
}

function closeEditDesigModal() {
  const modal = document.getElementById('modalEditDesig');
  if (modal) modal.style.display = 'none';
}

function openDeleteDesigModal(id, name, staffCount) {
  const modal = document.getElementById('modalDeleteDesig');
  const form = document.getElementById('formDeleteDesig');
  
  form.action = '<?= site_url('designations/delete') ?>/' + id;
  document.getElementById('deleteDesigNameText').textContent = name;
  
  const warn = document.getElementById('deleteDesigStaffWarning');
  if (staffCount > 0) {
    document.getElementById('deleteDesigStaffCount').textContent = staffCount;
    warn.style.display = 'block';
  } else {
    warn.style.display = 'none';
  }
  
  modal.style.display = 'flex';
}

function closeDeleteDesigModal() {
  const modal = document.getElementById('modalDeleteDesig');
  if (modal) modal.style.display = 'none';
}

// Close on outside overlay click
window.addEventListener('click', function(e) {
  const mEditDept = document.getElementById('modalEditDept');
  const mDelDept  = document.getElementById('modalDeleteDept');
  const mEditDesig= document.getElementById('modalEditDesig');
  const mDelDesig = document.getElementById('modalDeleteDesig');
  if (e.target === mEditDept) closeEditDeptModal();
  if (e.target === mDelDept) closeDeleteDeptModal();
  if (e.target === mEditDesig) closeEditDesigModal();
  if (e.target === mDelDesig) closeDeleteDesigModal();
});

// Close on Escape key
window.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeEditDeptModal();
    closeDeleteDeptModal();
    closeEditDesigModal();
    closeDeleteDesigModal();
  }
});
</script>
