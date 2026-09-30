<div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
  <a href="<?= site_url('employees/view/' . $employee['id']) ?>" class="btn btn-outline btn-sm">&larr; Back to Employee 360° Profile</a>
  <span class="badge badge-primary" style="font-size: 13px;"><?= esc($employee['employee_code']) ?></span>
</div>

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Edit Employee Master Profile</div>
      <p style="font-size: 13px; color: #64748b; margin-top: 2px;">
        Update employee lifecycle parameters, organizational placement, and corporate contact information.
      </p>
    </div>
  </div>

  <div class="card-body">
    <form action="<?= site_url('employees/update/' . $employee['id']) ?>" method="POST" enctype="multipart/form-data" id="formEditEmployee">
      <?= csrf_field() ?>

      <!-- 1. IDENTIFICATION & BASIC DETAILS (WITH PHOTO UPLOAD) -->
      <h3 style="font-size: 15px; font-weight: 700; color: var(--primary); margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 6px; display: flex; align-items: center; justify-content: space-between;">
        <span style="display: flex; align-items: center; gap: 8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
          1. Personal Identity &amp; Contact Details
        </span>
        <span style="font-size: 12px; color: #64748b; font-weight: 400;">Personal identity &amp; official records</span>
      </h3>

      <!-- Profile Photo Upload Card -->
      <?php $hasExistingPhoto = !empty($employee['profile_photo']) && file_exists(FCPATH . $employee['profile_photo']); ?>
      <div style="display: flex; gap: 24px; align-items: center; margin-bottom: 24px; padding: 18px 20px; background: var(--bg-card-subtle, #f8fafc); border: 1.5px dashed var(--border-color, #cbd5e1); border-radius: 12px; flex-wrap: wrap;">
        <!-- Avatar Preview Box -->
        <div style="position: relative; width: 90px; height: 90px; flex-shrink: 0;">
          <div id="photoPreviewContainer" style="width: 90px; height: 90px; border-radius: 20px; background: #e2e8f0; border: 2px solid var(--border-color); display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
            <?php if ($hasExistingPhoto): ?>
              <img id="photoPreviewImg" src="<?= base_url(esc($employee['profile_photo'])) ?>" alt="Profile Preview" style="width: 100%; height: 100%; object-fit: cover;">
              <div id="photoPlaceholder" style="display: none; text-align: center; color: #94a3b8;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                  <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                  <circle cx="12" cy="13" r="4"/>
                </svg>
                <div style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; margin-top: 2px;">Photo</div>
              </div>
            <?php else: ?>
              <img id="photoPreviewImg" src="" alt="Profile Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
              <div id="photoPlaceholder" style="text-align: center; color: #94a3b8;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                  <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                  <circle cx="12" cy="13" r="4"/>
                </svg>
                <div style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; margin-top: 2px;">Photo</div>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Upload Details & Trigger -->
        <div style="flex-grow: 1; min-width: 260px;">
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
            <label class="form-label" style="font-weight: 700; font-size: 13.5px; margin: 0; color: var(--text-main, #0f172a);">
              Employee Profile Photograph
            </label>
            <span class="badge badge-primary" style="font-size: 10px;">ID Badge &amp; Avatar</span>
          </div>
          <p style="font-size: 12px; color: #64748b; margin: 0 0 10px 0; line-height: 1.4;">
            Upload or replace the employee's headshot for ID badge and directory. Formats: PNG, JPG, WebP (Max 5MB).
          </p>
          <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <input type="hidden" name="remove_photo" id="remove_photo" value="0">
            <label for="profile_photo" class="btn btn-outline btn-sm" style="cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
              </svg>
              <span id="photoBtnLabel"><?= $hasExistingPhoto ? 'Change Photograph' : 'Choose Photograph' ?></span>
            </label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="previewProfilePhoto(this)">
            <button type="button" id="btnRemovePhoto" class="btn btn-sm" style="<?= $hasExistingPhoto ? 'display: inline-flex;' : 'display: none;' ?> background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-weight: 600;" onclick="handlePhotoRemoval()">
              ✕ Remove Photo
            </button>
            <span id="photoFilename" style="font-size: 12px; color: #64748b; font-style: italic;">
              <?= $hasExistingPhoto ? 'Current photo active on file' : 'No photo uploaded' ?>
            </span>
          </div>
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="employee_code">System Employee Code</label>
          <input type="text" id="employee_code" class="form-control" value="<?= esc($employee['employee_code']) ?>" disabled style="background: #f1f5f9; cursor: not-allowed;">
        </div>

        <div class="form-group">
          <label class="form-label" for="first_name">First Name <span style="color: #ef4444;">*</span></label>
          <input type="text" name="first_name" id="first_name" class="form-control" required value="<?= esc($employee['first_name']) ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="last_name">Last Name <span style="color: #ef4444;">*</span></label>
          <input type="text" name="last_name" id="last_name" class="form-control" required value="<?= esc($employee['last_name']) ?>">
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="email">Primary Corporate Email <span style="color: #ef4444;">*</span></label>
          <input type="email" name="email" id="email" class="form-control" required value="<?= esc($employee['email']) ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">Contact Telephone <span style="color: #ef4444;">*</span></label>
          <input type="text" name="phone" id="phone" class="form-control" required value="<?= esc($employee['phone']) ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="gender">Gender</label>
          <select name="gender" id="gender" class="form-control">
            <option value="male" <?= ($employee['gender'] === 'male') ? 'selected' : '' ?>>Male</option>
            <option value="female" <?= ($employee['gender'] === 'female') ? 'selected' : '' ?>>Female</option>
            <option value="non_binary" <?= ($employee['gender'] === 'non_binary') ? 'selected' : '' ?>>Non-Binary</option>
            <option value="other" <?= ($employee['gender'] === 'other') ? 'selected' : '' ?>>Other</option>
          </select>
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="marital_status">Marital Status</label>
          <select name="marital_status" id="marital_status" class="form-control">
            <option value="single" <?= ($employee['marital_status'] === 'single') ? 'selected' : '' ?>>Single</option>
            <option value="married" <?= ($employee['marital_status'] === 'married') ? 'selected' : '' ?>>Married</option>
            <option value="divorced" <?= ($employee['marital_status'] === 'divorced') ? 'selected' : '' ?>>Divorced</option>
            <option value="widowed" <?= ($employee['marital_status'] === 'widowed') ? 'selected' : '' ?>>Widowed</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="blood_group">Blood Group</label>
          <input type="text" name="blood_group" id="blood_group" class="form-control" placeholder="e.g. O+, A+" value="<?= esc($employee['blood_group'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="date_of_birth">Date of Birth</label>
          <div class="calendar-picker-wrapper">
            <div class="calendar-input-group">
              <span class="calendar-icon-prefix" title="Calendar">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                  <line x1="16" x2="16" y1="2" y2="6"/>
                  <line x1="8" x2="8" y1="2" y2="6"/>
                  <line x1="3" x2="21" y1="10" y2="10"/>
                  <path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/>
                  <path d="M8 18h.01"/><path d="M12 18h.01"/>
                </svg>
              </span>
              <input type="text" name="date_of_birth" id="date_of_birth" 
                     class="form-control datepicker-input" 
                     value="<?= esc($employee['date_of_birth'] ?? '') ?>" 
                     placeholder="Select date of birth..." 
                     autocomplete="off">
              <button type="button" class="calendar-trigger-btn" id="btnOpenDobCalendar" title="Click to choose date from calendar">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                  <line x1="16" x2="16" y1="2" y2="6"/>
                  <line x1="8" x2="8" y1="2" y2="6"/>
                  <line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
                <span>Calendar</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- 2. RESIDENTIAL & PERMANENT ADDRESS DETAILS (WITH COUNTRY) -->
      <h3 style="font-size: 15px; font-weight: 700; color: var(--primary); margin: 28px 0 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 6px; display: flex; align-items: center; justify-content: space-between;">
        <span style="display: flex; align-items: center; gap: 8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
          </svg>
          2. Residential &amp; Permanent Address
        </span>
        <span style="font-size: 12px; color: #64748b; font-weight: 400;">Tax residency &amp; physical location</span>
      </h3>

      <div class="grid-2">
        <div class="form-group">
          <label class="form-label" for="present_address">Present / Current Residential Address</label>
          <textarea name="present_address" id="present_address" class="form-control" rows="2" placeholder="Street / House No., Apartment, Suite, Locality..."><?= esc($employee['present_address'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <label class="form-label" for="permanent_address" style="margin-bottom: 0;">Permanent Address</label>
            <label style="font-size: 11.5px; color: var(--primary); font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px; user-select: none;">
              <input type="checkbox" id="chkSameAddress" onchange="copyAddress()" style="cursor: pointer;">
              Same as Present Address
            </label>
          </div>
          <textarea name="permanent_address" id="permanent_address" class="form-control" rows="2" placeholder="Permanent home / domicile address..."><?= esc($employee['permanent_address'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="grid-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div class="form-group">
          <label class="form-label" for="city">City</label>
          <input type="text" name="city" id="city" class="form-control" placeholder="e.g. San Francisco / Kolkata" value="<?= esc($employee['city'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="state">State / Province</label>
          <input type="text" name="state" id="state" class="form-control" placeholder="e.g. California / West Bengal" value="<?= esc($employee['state'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="postal_code">Postal / ZIP Code</label>
          <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="e.g. 94105 / 700001" value="<?= esc($employee['postal_code'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="country">Country *</label>
          <?php $currentCountry = $employee['country'] ?? 'United States'; ?>
          <select name="country" id="country" class="form-control" required>
            <?php
            $countryList = [
              'United States', 'India', 'United Kingdom', 'Canada', 'Australia', 'Germany',
              'United Arab Emirates', 'Singapore', 'France', 'Netherlands', 'Ireland',
              'Switzerland', 'Japan', 'New Zealand', 'South Africa', 'Saudi Arabia',
              'Brazil', 'Mexico', 'Spain', 'Italy', 'Malaysia', 'Philippines', 'Other'
            ];
            foreach ($countryList as $c):
            ?>
              <option value="<?= esc($c) ?>" <?= (strcasecmp($currentCountry, $c) === 0) ? 'selected' : '' ?>><?= esc($c) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- 3. ORGANIZATIONAL PLACEMENT & STATUS -->
      <h3 style="font-size: 15px; font-weight: 700; color: var(--primary); margin: 28px 0 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 6px;">
        3. Corporate Hierarchy &amp; Employment Status
      </h3>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="branch_id">Operating Branch <span style="color: #ef4444;">*</span></label>
          <select name="branch_id" id="branch_id" class="form-control" required>
            <?php foreach ($branches as $br): ?>
              <option value="<?= esc($br['id']) ?>" <?= ($employee['branch_id'] == $br['id']) ? 'selected' : '' ?>>
                <?= esc($br['name']) ?> (<?= esc($br['city']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="department_id">Department <span style="color: #ef4444;">*</span></label>
          <select name="department_id" id="department_id" class="form-control" required>
            <?php foreach ($departments as $d): ?>
              <option value="<?= esc($d['id']) ?>" <?= ($employee['department_id'] == $d['id']) ? 'selected' : '' ?>>
                <?= esc($d['name']) ?> (<?= esc($d['code']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="designation_id">Job Designation <span style="color: #ef4444;">*</span></label>
          <select name="designation_id" id="designation_id" class="form-control" required>
            <?php foreach ($designations as $ds): ?>
              <option value="<?= esc($ds['id']) ?>" <?= ($employee['designation_id'] == $ds['id']) ? 'selected' : '' ?>>
                <?= esc($ds['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="pay_grade_id">Salary Band / Pay Grade</label>
          <select name="pay_grade_id" id="pay_grade_id" class="form-control">
            <?php foreach ($payGrades as $pg): ?>
              <option value="<?= esc($pg['id']) ?>" 
                      data-min="<?= (float)$pg['min_salary'] ?>"
                      data-max="<?= (float)$pg['max_salary'] ?>"
                      data-name="<?= esc($pg['grade_name']) ?>"
                      <?= ($employee['pay_grade_id'] == $pg['id']) ? 'selected' : '' ?>>
                <?= esc($pg['grade_name']) ?> (₹<?= number_format($pg['min_salary']) ?> - ₹<?= number_format($pg['max_salary']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="employment_type">Employment Classification</label>
          <select name="employment_type" id="employment_type" class="form-control">
            <option value="full_time" <?= ($employee['employment_type'] === 'full_time') ? 'selected' : '' ?>>Full-Time Permanent</option>
            <option value="part_time" <?= ($employee['employment_type'] === 'part_time') ? 'selected' : '' ?>>Part-Time</option>
            <option value="contract" <?= ($employee['employment_type'] === 'contract') ? 'selected' : '' ?>>Contractor</option>
            <option value="probation" <?= ($employee['employment_type'] === 'probation') ? 'selected' : '' ?>>Probationary</option>
            <option value="intern" <?= ($employee['employment_type'] === 'intern') ? 'selected' : '' ?>>Intern</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="employment_status">Employment Status <span style="color: #ef4444;">*</span></label>
          <select name="employment_status" id="employment_status" class="form-control" style="font-weight: 600;">
            <option value="active" <?= ($employee['employment_status'] === 'active') ? 'selected' : '' ?>>Active</option>
            <option value="on_leave" <?= ($employee['employment_status'] === 'on_leave') ? 'selected' : '' ?>>On Leave</option>
            <option value="probation" <?= ($employee['employment_status'] === 'probation') ? 'selected' : '' ?>>Probation</option>
            <option value="notice_period" <?= ($employee['employment_status'] === 'notice_period') ? 'selected' : '' ?>>Notice Period</option>
            <option value="terminated" <?= ($employee['employment_status'] === 'terminated') ? 'selected' : '' ?>>Terminated</option>
            <option value="resigned" <?= ($employee['employment_status'] === 'resigned') ? 'selected' : '' ?>>Resigned</option>
            <option value="retired" <?= ($employee['employment_status'] === 'retired') ? 'selected' : '' ?>>Retired</option>
          </select>
        </div>
      </div>

      <!-- Conditional Probation Duration Setup Panel -->
      <?php $isProbation = ($employee['employment_status'] === 'probation' || $employee['employment_type'] === 'probation'); ?>
      <div id="probationSetupWrapperEdit" style="<?= $isProbation ? '' : 'display: none;' ?> background: #fffbeb; border: 1.5px solid #fef3c7; border-radius: 10px; padding: 16px; margin: 12px 0 18px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
          <div style="font-weight: 700; font-size: 13.5px; color: #92400e; display: flex; align-items: center; gap: 8px;">
            <span>⏱️</span> Probation &amp; Confirmation Period Settings
          </div>
          <span class="badge badge-warning" style="font-size: 11px;">Confirmation Tracking Active</span>
        </div>
        <div class="grid-2">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="probation_duration_months_edit" style="color: #92400e;">Preset Duration</label>
            <select name="probation_duration_months" id="probation_duration_months_edit" class="form-control" onchange="calcEditProbationDate(this.value)">
              <option value="1">1 Month</option>
              <option value="2">2 Months</option>
              <option value="3" selected>3 Months (Standard)</option>
              <option value="6">6 Months (Executive/Tech)</option>
            </select>
          </div>
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="probation_end_date_edit" style="color: #92400e;">Probation End / Evaluation Date</label>
            <input type="date" name="probation_end_date" id="probation_end_date_edit" class="form-control" value="<?= esc($employee['probation_end_date'] ?? date('Y-m-d', strtotime('+3 months', strtotime($employee['joining_date'] ?: date('Y-m-d'))))) ?>">
          </div>
        </div>
      </div>

      <div class="grid-2">
        <div class="form-group">
          <label class="form-label" for="reporting_to">Reporting Manager / Supervisor</label>
          <select name="reporting_to" id="reporting_to" class="form-control">
            <option value="">Direct Executive / C-Suite Board</option>
            <?php foreach ($managers as $m): ?>
              <option value="<?= esc($m['id']) ?>" <?= ($employee['reporting_to'] == $m['id']) ? 'selected' : '' ?>>
                <?= esc($m['first_name'] . ' ' . $m['last_name']) ?> (<?= esc($m['employee_code']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <!-- 3. BASIC COMPENSATION (NORMAL & MINIMAL) -->
      <div style="margin: 20px 0 24px; background: var(--bg-card-subtle, #f8fafc); border: 1.5px solid var(--border-color, #e2e8f0); border-radius: 10px; padding: 18px;">
        <div style="margin-bottom: 14px;">
          <div style="font-weight: 700; font-size: 14px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 6px; background: rgba(16, 185, 129, 0.12); color: #059669; font-weight: 800; font-size: 14px;">
              ₹
            </span>
            <span>Salary &amp; Compensation</span>
          </div>
          <p style="font-size: 12px; color: #64748b; margin: 3px 0 0 34px;">
            Specify base monthly salary or CTC. Detailed statutory breakdowns &amp; allowances can be managed in <strong>Monthly Payroll</strong>.
          </p>
        </div>

        <div class="grid-3" style="margin-bottom: 0;">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="basic_salary" style="font-weight: 600; font-size: 13px; color: #0f172a;">
              Monthly Basic Salary <span style="color: #ef4444;">*</span>
            </label>
            <div style="position: relative;">
              <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 700; color: #64748b; font-size: 14px;">₹</span>
              <input type="number" name="basic_salary" id="basic_salary" class="form-control" 
                     placeholder="e.g. 35000" min="0" step="any" 
                     value="<?= !empty($salaryStructure['basic_salary']) ? (float)$salaryStructure['basic_salary'] : 35000 ?>"
                     style="padding-left: 28px; font-weight: 700; font-size: 14.5px;"
                     oninput="onMinimalBasicInput(this.value)" required>
            </div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Base monthly wage component</div>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="annual_ctc" style="font-weight: 600; font-size: 13px; color: #0f172a;">
              Annual CTC (Cost to Company)
            </label>
            <div style="position: relative;">
              <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 700; color: #64748b; font-size: 14px;">₹</span>
              <input type="number" name="annual_ctc" id="annual_ctc" class="form-control" 
                     placeholder="e.g. 600000" min="0" step="any" 
                     value="<?= !empty($salaryStructure['gross_salary']) ? (float)$salaryStructure['gross_salary'] * 12 : (!empty($salaryStructure['basic_salary']) ? (float)$salaryStructure['basic_salary'] * 12 : 600000) ?>"
                     style="padding-left: 28px; font-weight: 600; font-size: 14.5px;"
                     oninput="onMinimalCtcInput(this.value)">
            </div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Approximate package per annum</div>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #64748b;">Estimated Net In-Hand</label>
            <div id="minimal_net_preview" style="font-size: 18px; font-weight: 800; color: #4338ca; padding-top: 4px;">
              <?= !empty($salaryStructure['net_salary']) ? '₹' . number_format($salaryStructure['net_salary'], 2) . ' / mo' : '₹47,530.00 / mo' ?>
            </div>
            <div style="font-size: 11.5px; color: #059669; font-weight: 600; margin-top: 4px;" id="minimal_gross_preview">
              Gross Monthly: <?= !empty($salaryStructure['gross_salary']) ? '₹' . number_format($salaryStructure['gross_salary'], 2) : '₹55,350.00' ?>
            </div>
          </div>
        </div>

        <!-- Hidden inputs for backend store -->
        <input type="hidden" name="salary_mode" id="salary_mode" value="auto">
        <input type="hidden" name="hra" id="hra" value="<?= !empty($salaryStructure['hra']) ? (float)$salaryStructure['hra'] : 14000 ?>">
        <input type="hidden" name="conveyance_allowance" id="conveyance_allowance" value="<?= !empty($salaryStructure['conveyance_allowance']) ? (float)$salaryStructure['conveyance_allowance'] : 1600 ?>">
        <input type="hidden" name="special_allowance" id="special_allowance" value="<?= !empty($salaryStructure['special_allowance']) ? (float)$salaryStructure['special_allowance'] : 3500 ?>">
        <input type="hidden" name="medical_allowance" id="medical_allowance" value="<?= !empty($salaryStructure['medical_allowance']) ? (float)$salaryStructure['medical_allowance'] : 1250 ?>">
        <input type="hidden" name="other_allowances" id="other_allowances" value="<?= !empty($salaryStructure['other_allowances']) ? (float)$salaryStructure['other_allowances'] : 0 ?>">
        <input type="hidden" name="pf_deduction" id="pf_deduction" value="<?= !empty($salaryStructure['pf_deduction']) ? (float)$salaryStructure['pf_deduction'] : 4200 ?>">
        <input type="hidden" name="tax_deduction" id="tax_deduction" value="<?= !empty($salaryStructure['tax_deduction']) ? (float)$salaryStructure['tax_deduction'] : 200 ?>">
        <input type="hidden" name="insurance_deduction" id="insurance_deduction" value="<?= !empty($salaryStructure['insurance_deduction']) ? (float)$salaryStructure['insurance_deduction'] : 120 ?>">
      </div>

      <!-- 4. SYSTEM ACCESS, ROLE & PORTAL CREDENTIALS -->
      <?php $activeRoleId = (int)($user['role_id'] ?? 7); ?>
      <div style="display: flex; justify-content: space-between; align-items: flex-end; margin: 32px 0 16px; border-bottom: 2px solid var(--border-color); padding-bottom: 8px;">
        <div>
          <h3 style="font-size: 16px; font-weight: 700; color: var(--primary); margin: 0; display: flex; align-items: center; gap: 8px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
              <rect width="8" height="6" x="14" y="11" rx="1"/>
              <path d="M18 11v-2a2 2 0 0 0-4 0v2"/>
            </svg>
            4. System Access, Security Role &amp; Login Credentials
          </h3>
          <p style="font-size: 13px; color: #64748b; margin: 4px 0 0;">
            Define whether this employee will be a <strong>Manager</strong>, <strong>Employee (ESS)</strong>, <strong>HR Admin</strong>, <strong>Payroll Manager</strong>, etc., and configure their portal credentials.
          </p>
        </div>
        <span class="badge" style="background: var(--primary-light); color: var(--primary); font-weight: 700; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
          RBAC Security
        </span>
      </div>

      <!-- System Role Dropdown Selector -->
      <style>
        .portal-auth-card {
          background: var(--bg-card-subtle, #f8fafc);
          border: 1px solid var(--border-color);
          border-radius: 10px;
          padding: 18px;
          margin-top: 16px;
        }
        .btn-pw-action {
          background: var(--bg-card, #ffffff);
          border: 1px solid var(--border-color);
          border-radius: 6px;
          font-size: 11px;
          font-weight: 600;
          padding: 5px 10px;
          color: var(--text-main, #334155);
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          gap: 4px;
          transition: all 0.15s ease;
        }
        .btn-pw-action:hover {
          border-color: var(--primary);
          color: var(--primary);
          background: var(--primary-light);
        }
      </style>

      <div class="form-group" style="margin-bottom: 20px; max-width: 580px;">
        <label class="form-label" for="role_id" style="font-weight: 700; font-size: 13.5px;">
          System Access Role <span style="color: #ef4444;">*</span>
        </label>
        <select name="role_id" id="role_id" class="form-control" required onchange="updateRoleHelpDesc(this)">
          <?php foreach ($roles as $r): 
            $lvl = $r['hierarchy_level'] ?? $r['id'];
          ?>
            <option value="<?= esc($r['id']) ?>" 
                    data-slug="<?= esc($r['slug']) ?>"
                    data-desc="<?= esc($r['description']) ?>"
                    <?= ($activeRoleId == $r['id']) ? 'selected' : '' ?>>
              Tier <?= $lvl ?>: <?= esc($r['name']) ?> &mdash; <?= esc($r['description']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <div style="font-size: 12px; color: #64748b; margin-top: 6px;" id="roleHelpDesc">
          <?php
            $currentRoleDesc = 'Standard Individual Employee Self-Service. Can clock in/out, view payslips, and apply for leaves.';
            foreach ($roles as $r) {
              if ($activeRoleId == $r['id']) {
                $currentRoleDesc = $r['description'];
                break;
              }
            }
            echo esc($currentRoleDesc);
          ?>
        </div>
      </div>

      <!-- PORTAL LOGIN CREDENTIALS & SET/RESET PASSWORD CARD -->
      <div class="portal-auth-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 28px; height: 28px; border-radius: 6px; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              🔑
            </div>
            <div>
              <span style="font-size: 14px; font-weight: 700; color: var(--text-main, #0f172a);">Portal User Login &amp; Password Management</span>
              <span style="font-size: 12px; color: #64748b; margin-left: 6px;">Manage authentication credentials</span>
            </div>
          </div>
          <span style="font-size: 11px; background: rgba(16, 185, 129, 0.15); color: #047857; font-weight: 700; padding: 2px 8px; border-radius: 10px;">
            <?= $user ? 'Account Active' : 'Account will be created' ?>
          </span>
        </div>

        <div class="grid-2">
          <!-- 1. Username Field -->
          <div class="form-group" style="margin-bottom: 10px;">
            <label class="form-label" for="portal_username" style="display: flex; justify-content: space-between;">
              <span>Portal Login Username</span>
              <span style="font-size: 11px; color: #64748b;">(Unique portal login identifier)</span>
            </label>
            <div style="position: relative;">
              <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 600; color: #94a3b8; font-size: 14px;">@</span>
              <input type="text" 
                     name="username" 
                     id="portal_username" 
                     class="form-control" 
                     style="padding-left: 32px;" 
                     value="<?= esc($user['username'] ?? strtolower($employee['first_name'] . '.' . $employee['last_name'])) ?>" 
                     placeholder="e.g. alex.wright" 
                     autocomplete="off">
            </div>
          </div>

          <!-- 2. Set/Reset Password Field -->
          <div class="form-group" style="margin-bottom: 10px;">
            <label class="form-label" for="portal_password" style="display: flex; justify-content: space-between;">
              <span style="font-weight: 700;">Set / Reset Portal Password</span>
              <span style="font-size: 11px; color: var(--primary); font-weight: 600;">Leave blank to keep current</span>
            </label>
            
            <div style="display: flex; gap: 8px;">
              <div style="position: relative; flex-grow: 1;">
                <input type="password" 
                       name="password" 
                       id="portal_password" 
                       class="form-control" 
                       placeholder="Enter new password (or leave blank to keep unchanged)" 
                       autocomplete="new-password">
                <button type="button" 
                        id="btnTogglePwVisibility" 
                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 14px; color: #64748b; padding: 4px;"
                        title="Show / Hide Password">
                  👁️
                </button>
              </div>
            </div>

            <!-- Quick Action Buttons for Password -->
            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px;">
              <button type="button" class="btn-pw-action" id="btnUseDefaultPw" title="Set to standard Admin@123">
                ⚡ Set Default (Admin@123)
              </button>
              <button type="button" class="btn-pw-action" id="btnGenStrongPw" title="Click to generate randomized strong password">
                🎲 Generate Strong Password
              </button>
              <button type="button" class="btn-pw-action" id="btnClearPw" title="Clear to keep existing password">
                ✕ Clear (Keep Current)
              </button>
            </div>
          </div>
        </div>

        <div style="margin-top: 10px; padding: 8px 12px; background: rgba(140, 122, 169, 0.08); border-radius: 6px; font-size: 12px; color: var(--text-main, #334155); display: flex; align-items: center; gap: 8px;">
          <span style="font-size: 14px;">💡</span>
          <span><strong>Note:</strong> Leave the password field empty to keep the employee's existing password unchanged. If you enter a new password, it will be securely hashed and updated immediately upon saving.</span>
        </div>
      </div>

      <!-- 4. ADDRESS & EMERGENCY CONTACT -->
      <h3 style="font-size: 15px; font-weight: 700; color: var(--primary); margin: 24px 0 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 6px;">
        4. Address &amp; Emergency Contact Details
      </h3>

      <div class="grid-3">
        <div class="form-group" style="grid-column: span 2;">
          <label class="form-label" for="present_address">Present Address</label>
          <input type="text" name="present_address" id="present_address" class="form-control" value="<?= esc($employee['present_address'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="city">City</label>
          <input type="text" name="city" id="city" class="form-control" value="<?= esc($employee['city'] ?? '') ?>">
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="state">State / Province</label>
          <input type="text" name="state" id="state" class="form-control" value="<?= esc($employee['state'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="postal_code">Postal Code / Zip</label>
          <input type="text" name="postal_code" id="postal_code" class="form-control" value="<?= esc($employee['postal_code'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="emergency_contact_phone">Emergency Contact Phone</label>
          <input type="text" name="emergency_contact_phone" id="emergency_contact_phone" class="form-control" value="<?= esc($employee['emergency_contact_phone'] ?? '') ?>">
        </div>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px;">
        <div>
          <?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('modalDeleteEmployeeEdit').style.display='flex'" style="display: inline-flex; align-items: center; gap: 6px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
              Delete Employee
            </button>
          <?php endif; ?>
        </div>
        <div style="display: flex; gap: 12px;">
          <a href="<?= site_url('employees/view/' . $employee['id']) ?>" class="btn btn-outline">Cancel</a>
          <button type="submit" class="btn btn-primary" id="btnSaveEmployee">
            Save Employee Changes
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<?php if (($currentRoleSlug ?? '') === 'super_admin'): ?>
<div id="modalDeleteEmployeeEdit" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
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
        Are you sure you want to delete employee <strong><?= esc($employee['first_name'] . ' ' . $employee['last_name']) ?></strong> (<code><?= esc($employee['employee_code']) ?></code>)?
      </p>
      <div style="background: rgba(239, 68, 68, 0.08); border-left: 4px solid #ef4444; padding: 12px 14px; border-radius: 6px; font-size: 12.5px; color: #b91c1c;">
        <strong>Warning:</strong> This will archive the master profile, terminate employment status, deactivate user access, and remove the record from active directories.
      </div>
    </div>
    <div style="padding: 16px 24px; background: var(--bg-card-subtle, #f8fafc); border-top: 1px solid var(--border-color, #e2e8f0); display: flex; justify-content: flex-end; gap: 10px;">
      <button type="button" class="btn btn-outline" onclick="document.getElementById('modalDeleteEmployeeEdit').style.display='none'">
        Cancel
      </button>
      <form action="<?= site_url('employees/delete/' . $employee['id']) ?>" method="POST" style="margin: 0;">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 6px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          Confirm Delete
        </button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>


<script>
// System Role Description helper
function updateRoleHelpDesc(select) {
  if (select && select.selectedIndex >= 0) {
    const opt = select.options[select.selectedIndex];
    const roleDesc = opt.getAttribute('data-desc') || opt.text;
    const descHelp = document.getElementById('roleHelpDesc');
    if (descHelp) descHelp.textContent = roleDesc;
  }
}

// Password Controls
const pwInput = document.getElementById('portal_password');
const btnTogglePw = document.getElementById('btnTogglePwVisibility');
const btnUseDefault = document.getElementById('btnUseDefaultPw');
const btnGenStrong = document.getElementById('btnGenStrongPw');
const btnClear = document.getElementById('btnClearPw');

if (btnTogglePw && pwInput) {
  btnTogglePw.addEventListener('click', function() {
    if (pwInput.type === 'password') {
      pwInput.type = 'text';
      btnTogglePw.textContent = '🙈';
      btnTogglePw.title = 'Hide password';
    } else {
      pwInput.type = 'password';
      btnTogglePw.textContent = '👁️';
      btnTogglePw.title = 'Show password';
    }
  });
}

if (btnUseDefault && pwInput) {
  btnUseDefault.addEventListener('click', function() {
    pwInput.value = 'Admin@123';
    pwInput.type = 'text';
    if (btnTogglePw) btnTogglePw.textContent = '🙈';
    pwInput.focus();
  });
}

if (btnGenStrong && pwInput) {
  btnGenStrong.addEventListener('click', function() {
    const words = ['Kolkata', 'Bengal', 'Quantum', 'Nexus', 'Apex', 'Infosof', 'Horizon'];
    const chosenWord = words[Math.floor(Math.random() * words.length)];
    const symbol = ['#', '@', '$', '!', '*'][Math.floor(Math.random() * 5)];
    const num = Math.floor(Math.random() * 899 + 100);
    const generated = `${chosenWord}${symbol}${num}`;
    
    pwInput.value = generated;
    pwInput.type = 'text';
    if (btnTogglePw) btnTogglePw.textContent = '🙈';
    pwInput.focus();
  });
}

if (btnClear && pwInput) {
  btnClear.addEventListener('click', function() {
    pwInput.value = '';
    pwInput.type = 'password';
    if (btnTogglePw) btnTogglePw.textContent = '👁️';
  });
}

// Profile Photo Preview & Removal for Edit
const originalPhotoSrc = <?= json_encode($hasExistingPhoto ? base_url(esc($employee['profile_photo'])) : '') ?>;
const hadExistingPhoto = <?= $hasExistingPhoto ? 'true' : 'false' ?>;

function previewProfilePhoto(input) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('photoPreviewImg');
      const placeholder = document.getElementById('photoPlaceholder');
      const filenameLbl = document.getElementById('photoFilename');
      const btnRemove = document.getElementById('btnRemovePhoto');
      const removeInput = document.getElementById('remove_photo');
      const btnLabel = document.getElementById('photoBtnLabel');

      if (removeInput) removeInput.value = '0';
      if (img) {
        img.src = e.target.result;
        img.style.display = 'block';
      }
      if (placeholder) placeholder.style.display = 'none';
      if (btnRemove) {
        btnRemove.style.display = 'inline-flex';
        btnRemove.innerHTML = '✕ Cancel New Photo';
        btnRemove.style.background = '#fee2e2';
        btnRemove.style.color = '#b91c1c';
      }
      if (btnLabel) {
        btnLabel.textContent = 'Change Selection';
      }
      if (filenameLbl) {
        const sizeKb = Math.round(file.size / 1024);
        filenameLbl.textContent = `${file.name} (${sizeKb} KB) - Ready to upload on save`;
        filenameLbl.style.color = 'var(--primary)';
        filenameLbl.style.fontWeight = '600';
      }
    };
    reader.readAsDataURL(file);
  }
}

function handlePhotoRemoval() {
  const fileInput = document.getElementById('profile_photo');
  const img = document.getElementById('photoPreviewImg');
  const placeholder = document.getElementById('photoPlaceholder');
  const filenameLbl = document.getElementById('photoFilename');
  const btnRemove = document.getElementById('btnRemovePhoto');
  const removeInput = document.getElementById('remove_photo');
  const btnLabel = document.getElementById('photoBtnLabel');

  // Case 1: User just picked a new file and wants to cancel / undo picking it
  if (fileInput && fileInput.files && fileInput.files.length > 0) {
    fileInput.value = '';
    if (hadExistingPhoto) {
      if (img) {
        img.src = originalPhotoSrc;
        img.style.display = 'block';
      }
      if (placeholder) placeholder.style.display = 'none';
      if (btnRemove) {
        btnRemove.style.display = 'inline-flex';
        btnRemove.innerHTML = '✕ Remove Photo';
        btnRemove.style.background = '#fee2e2';
        btnRemove.style.color = '#b91c1c';
      }
      if (btnLabel) btnLabel.textContent = 'Change Photograph';
      if (filenameLbl) {
        filenameLbl.textContent = 'Current photo active on file';
        filenameLbl.style.color = '#64748b';
        filenameLbl.style.fontWeight = 'normal';
      }
      if (removeInput) removeInput.value = '0';
    } else {
      if (img) {
        img.src = '';
        img.style.display = 'none';
      }
      if (placeholder) placeholder.style.display = 'block';
      if (btnRemove) btnRemove.style.display = 'none';
      if (btnLabel) btnLabel.textContent = 'Choose Photograph';
      if (filenameLbl) {
        filenameLbl.textContent = 'No photo uploaded';
        filenameLbl.style.color = '#64748b';
        filenameLbl.style.fontWeight = 'normal';
      }
      if (removeInput) removeInput.value = '0';
    }
    return;
  }

  // Case 2: Existing photo on file - toggle removal or undo removal
  if (removeInput && removeInput.value === '1') {
    // Undo removal
    removeInput.value = '0';
    if (img) {
      img.src = originalPhotoSrc;
      img.style.display = 'block';
    }
    if (placeholder) placeholder.style.display = 'none';
    if (btnRemove) {
      btnRemove.innerHTML = '✕ Remove Photo';
      btnRemove.style.background = '#fee2e2';
      btnRemove.style.color = '#b91c1c';
    }
    if (btnLabel) btnLabel.textContent = 'Change Photograph';
    if (filenameLbl) {
      filenameLbl.textContent = 'Current photo active on file';
      filenameLbl.style.color = '#64748b';
      filenameLbl.style.fontWeight = 'normal';
    }
  } else {
    // Mark for removal
    if (removeInput) removeInput.value = '1';
    if (img) {
      img.src = '';
      img.style.display = 'none';
    }
    if (placeholder) placeholder.style.display = 'block';
    if (btnRemove) {
      btnRemove.innerHTML = '↺ Undo Remove';
      btnRemove.style.background = '#e2e8f0';
      btnRemove.style.color = '#334155';
    }
    if (btnLabel) btnLabel.textContent = 'Choose Photograph';
    if (filenameLbl) {
      filenameLbl.textContent = 'Photo marked for deletion (will be removed on save)';
      filenameLbl.style.color = '#dc2626';
      filenameLbl.style.fontWeight = '600';
    }
  }
}

// Copy Present Address to Permanent Address in Edit
function copyAddress() {
  const chk = document.getElementById('chkSameAddress');
  const present = document.getElementById('present_address');
  const perm = document.getElementById('permanent_address');
  if (chk && present && perm) {
    if (chk.checked) {
      perm.value = present.value;
      perm.setAttribute('readonly', 'readonly');
      perm.style.background = '#f8fafc';
    } else {
      perm.removeAttribute('readonly');
      perm.style.background = '#ffffff';
    }
  }
}

const presentAddrEdit = document.getElementById('present_address');
if (presentAddrEdit) {
  presentAddrEdit.addEventListener('input', function() {
    const chk = document.getElementById('chkSameAddress');
    const perm = document.getElementById('permanent_address');
    if (chk && chk.checked && perm) {
      perm.value = this.value;
    }
  });
}

// ==============================================================
// MINIMAL SALARY & CTC CALCULATION LOGIC
// ==============================================================
function onMinimalBasicInput(val) {
  const basic = parseFloat(val) || 0;
  const hra = Math.round(basic * 0.40);
  const conv = 1600;
  const spec = Math.round(basic * 0.10);
  const med = 1250;
  const pf = Math.round(basic * 0.12);
  const tax = 200;
  const ins = 120;
  const gross = basic + hra + conv + spec + med;
  const deductions = pf + tax + ins;
  const net = Math.max(0, gross - deductions);
  const ctc = gross * 12;

  const ctcInput = document.getElementById('annual_ctc');
  if (ctcInput && document.activeElement === document.getElementById('basic_salary')) {
    ctcInput.value = ctc;
  }
  updateMinimalPreviews(gross, net);
  syncHiddenSalaryInputs(hra, conv, spec, med, pf, tax, ins);
}

function onMinimalCtcInput(val) {
  const ctc = parseFloat(val) || 0;
  const monthlyGross = Math.round(ctc / 12);
  const basic = Math.round(monthlyGross * 0.50);
  const basicInput = document.getElementById('basic_salary');
  if (basicInput && document.activeElement === document.getElementById('annual_ctc')) {
    basicInput.value = basic;
  }
  const hra = Math.round(basic * 0.40);
  const conv = 1600;
  const spec = Math.max(0, monthlyGross - (basic + hra + conv + 1250));
  const med = 1250;
  const pf = Math.round(basic * 0.12);
  const tax = 200;
  const ins = 120;
  const gross = monthlyGross;
  const deductions = pf + tax + ins;
  const net = Math.max(0, gross - deductions);

  updateMinimalPreviews(gross, net);
  syncHiddenSalaryInputs(hra, conv, spec, med, pf, tax, ins);
}

function updateMinimalPreviews(gross, net) {
  const fmt = (n) => '₹' + Number(n).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  const netEl = document.getElementById('minimal_net_preview');
  const grossEl = document.getElementById('minimal_gross_preview');
  if (netEl) netEl.textContent = fmt(net) + ' / mo';
  if (grossEl) grossEl.textContent = 'Gross Monthly: ' + fmt(gross);
}

function syncHiddenSalaryInputs(hra, conv, spec, med, pf, tax, ins) {
  if (document.getElementById('hra')) document.getElementById('hra').value = hra;
  if (document.getElementById('conveyance_allowance')) document.getElementById('conveyance_allowance').value = conv;
  if (document.getElementById('special_allowance')) document.getElementById('special_allowance').value = spec;
  if (document.getElementById('medical_allowance')) document.getElementById('medical_allowance').value = med;
  if (document.getElementById('pf_deduction')) document.getElementById('pf_deduction').value = pf;
  if (document.getElementById('tax_deduction')) document.getElementById('tax_deduction').value = tax;
  if (document.getElementById('insurance_deduction')) document.getElementById('insurance_deduction').value = ins;
}

document.addEventListener('DOMContentLoaded', function() {
  const basicInput = document.getElementById('basic_salary');
  if (basicInput && basicInput.value) {
    onMinimalBasicInput(basicInput.value);
  }

  const statusEl = document.getElementById('employment_status');
  const typeEl = document.getElementById('employment_type');
  if (statusEl) statusEl.addEventListener('change', toggleEditProbation);
  if (typeEl) typeEl.addEventListener('change', toggleEditProbation);
});

function toggleEditProbation() {
  const status = document.getElementById('employment_status').value;
  const type = document.getElementById('employment_type').value;
  const panel = document.getElementById('probationSetupWrapperEdit');
  if (!panel) return;
  if (status === 'probation' || type === 'probation') {
    panel.style.display = 'block';
  } else {
    panel.style.display = 'none';
  }
}

function calcEditProbationDate(months) {
  const joiningDateStr = '<?= esc($employee['joining_date'] ?: date('Y-m-d')) ?>';
  const base = new Date(joiningDateStr);
  base.setMonth(base.getMonth() + parseInt(months));
  const yyyy = base.getFullYear();
  const mm = String(base.getMonth() + 1).padStart(2, '0');
  const dd = String(base.getDate()).padStart(2, '0');
  const endInput = document.getElementById('probation_end_date_edit');
  if (endInput) {
    endInput.value = `${yyyy}-${mm}-${dd}`;
  }
}
</script>
