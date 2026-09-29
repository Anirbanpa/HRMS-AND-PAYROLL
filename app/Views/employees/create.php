<div style="margin-bottom: 20px;">
  <a href="<?= site_url('employees') ?>" class="btn btn-outline btn-sm">&larr; Back to Directory</a>
</div>

<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Employee Onboarding Wizard</div>
      <p style="font-size: 13px; color: #64748b; margin-top: 2px;">
        Register a new employee master record, establish organization placement, and provision portal credentials.
      </p>
    </div>
  </div>

  <div class="card-body">
    <form action="<?= site_url('employees/store') ?>" method="POST" enctype="multipart/form-data" id="formCreateEmployee">
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
      <div style="display: flex; gap: 24px; align-items: center; margin-bottom: 24px; padding: 18px 20px; background: var(--bg-card-subtle, #f8fafc); border: 1.5px dashed var(--border-color, #cbd5e1); border-radius: 12px; flex-wrap: wrap;">
        <!-- Avatar Preview Box -->
        <div style="position: relative; width: 90px; height: 90px; flex-shrink: 0;">
          <div id="photoPreviewContainer" style="width: 90px; height: 90px; border-radius: 20px; background: #e2e8f0; border: 2px solid var(--border-color); display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
            <img id="photoPreviewImg" src="" alt="Profile Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
            <div id="photoPlaceholder" style="text-align: center; color: #94a3b8;">
              <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                <circle cx="12" cy="13" r="4"/>
              </svg>
              <div style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; margin-top: 2px; letter-spacing: 0.5px;">Photo</div>
            </div>
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
            Upload a clear face photo for employee ID badge, corporate directory, and self-service portal profile. Formats: PNG, JPG, WebP (Max 5MB).
          </p>
          <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <label for="profile_photo" class="btn btn-outline btn-sm" style="cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
              </svg>
              Choose Photograph
            </label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="previewProfilePhoto(this)">
            <button type="button" id="btnRemovePhoto" class="btn btn-sm" style="display: none; background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; font-weight: 600;" onclick="clearProfilePhoto()">
              ✕ Remove
            </button>
            <span id="photoFilename" style="font-size: 12px; color: #64748b; font-style: italic;">No file selected</span>
          </div>
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="employee_code">System Employee Code *</label>
          <input type="text" name="employee_code" id="employee_code" class="form-control" value="<?= esc($nextCode) ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="first_name">First Name *</label>
          <input type="text" name="first_name" id="first_name" class="form-control" placeholder="e.g. Alexander" required value="<?= old('first_name') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="last_name">Last Name *</label>
          <input type="text" name="last_name" id="last_name" class="form-control" placeholder="e.g. Wright" required value="<?= old('last_name') ?>">
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="email">Primary Corporate Email *</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="alex.wright@infosof.com" required value="<?= old('email') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="official_email">Official / Alias Email</label>
          <input type="email" name="official_email" id="official_email" class="form-control" placeholder="e.g. awright@infosof.com" value="<?= old('official_email') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">Contact Telephone *</label>
          <input type="text" name="phone" id="phone" class="form-control" placeholder="+1 (415) 555-0182" required value="<?= old('phone') ?>">
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="gender">Gender</label>
          <select name="gender" id="gender" class="form-control">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="non_binary">Non-Binary</option>
            <option value="other">Other</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="marital_status">Marital Status</label>
          <select name="marital_status" id="marital_status" class="form-control">
            <option value="single">Single</option>
            <option value="married">Married</option>
            <option value="divorced">Divorced</option>
            <option value="widowed">Widowed</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="blood_group">Blood Group</label>
          <input type="text" name="blood_group" id="blood_group" class="form-control" placeholder="e.g. O+, A+, B+" value="<?= old('blood_group') ?>">
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
          <textarea name="present_address" id="present_address" class="form-control" rows="2" placeholder="Street / House No., Apartment, Suite, Locality..."><?= old('present_address') ?></textarea>
        </div>

        <div class="form-group">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
            <label class="form-label" for="permanent_address" style="margin-bottom: 0;">Permanent Address</label>
            <label style="font-size: 11.5px; color: var(--primary); font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px; user-select: none;">
              <input type="checkbox" id="chkSameAddress" onchange="copyAddress()" style="cursor: pointer;">
              Same as Present Address
            </label>
          </div>
          <textarea name="permanent_address" id="permanent_address" class="form-control" rows="2" placeholder="Permanent home / domicile address..."><?= old('permanent_address') ?></textarea>
        </div>
      </div>

      <div class="grid-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div class="form-group">
          <label class="form-label" for="city">City</label>
          <input type="text" name="city" id="city" class="form-control" placeholder="e.g. San Francisco / Kolkata" value="<?= old('city') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="state">State / Province</label>
          <input type="text" name="state" id="state" class="form-control" placeholder="e.g. California / West Bengal" value="<?= old('state') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="postal_code">Postal / ZIP Code</label>
          <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="e.g. 94105 / 700001" value="<?= old('postal_code') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="country">Country *</label>
          <select name="country" id="country" class="form-control" required>
            <option value="United States" selected>United States</option>
            <option value="India">India</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="Canada">Canada</option>
            <option value="Australia">Australia</option>
            <option value="Germany">Germany</option>
            <option value="United Arab Emirates">United Arab Emirates</option>
            <option value="Singapore">Singapore</option>
            <option value="France">France</option>
            <option value="Netherlands">Netherlands</option>
            <option value="Ireland">Ireland</option>
            <option value="Switzerland">Switzerland</option>
            <option value="Japan">Japan</option>
            <option value="New Zealand">New Zealand</option>
            <option value="South Africa">South Africa</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Brazil">Brazil</option>
            <option value="Mexico">Mexico</option>
            <option value="Spain">Spain</option>
            <option value="Italy">Italy</option>
            <option value="Malaysia">Malaysia</option>
            <option value="Philippines">Philippines</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>

      <!-- 3. CORPORATE HIERARCHY & ORGANIZATIONAL PLACEMENT -->
      <h3 style="font-size: 15px; font-weight: 700; color: var(--primary); margin: 28px 0 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 6px;">
        3. Corporate Hierarchy &amp; Organizational Placement
      </h3>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="branch_id">Operating Branch *</label>
          <select name="branch_id" id="branch_id" class="form-control" required>
            <?php foreach ($branches as $br): ?>
              <option value="<?= esc($br['id']) ?>"><?= esc($br['name']) ?> (<?= esc($br['city']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="department_id">Department *</label>
          <select name="department_id" id="department_id" class="form-control" required>
            <?php foreach ($departments as $dept): ?>
              <option value="<?= esc($dept['id']) ?>"><?= esc($dept['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="designation_id">Designation *</label>
          <select name="designation_id" id="designation_id" class="form-control" required>
            <?php foreach ($designations as $desig): ?>
              <option value="<?= esc($desig['id']) ?>"><?= esc($desig['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="pay_grade_id">Pay Band / Grade</label>
          <select name="pay_grade_id" id="pay_grade_id" class="form-control" onchange="onPayGradeChange(this)">
            <?php foreach ($payGrades as $pg): ?>
              <option value="<?= esc($pg['id']) ?>"
                      data-min="<?= (float)$pg['min_salary'] ?>"
                      data-max="<?= (float)$pg['max_salary'] ?>"
                      data-name="<?= esc($pg['grade_name']) ?>">
                <?= esc($pg['grade_name']) ?> (₹<?= number_format($pg['min_salary']) ?> - ₹<?= number_format($pg['max_salary']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="reporting_to">Reporting Line Manager</label>
          <select name="reporting_to" id="reporting_to" class="form-control">
            <option value="">Executive / Direct to C-Suite</option>
            <?php foreach ($managers as $mgr): ?>
              <option value="<?= esc($mgr['id']) ?>"><?= esc($mgr['first_name'] . ' ' . $mgr['last_name']) ?> (<?= esc($mgr['employee_code']) ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="employment_type">Employment Classification <span style="color: #ef4444;">*</span></label>
          <select name="employment_type" id="employment_type" class="form-control" onchange="toggleProbationFields(this.value)" required>
            <option value="full_time" selected>Full-Time Permanent</option>
            <option value="part_time">Part-Time</option>
            <option value="contract">Contractor</option>
            <option value="probation">Probationary</option>
            <option value="intern">Intern</option>
          </select>
        </div>
      </div>

      <div class="grid-2" style="margin-top: 4px;">
        <div class="form-group">
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
            <label class="form-label" for="joining_date" style="margin-bottom: 0;">
              Date of Joining <span style="color: #ef4444;">*</span>
            </label>
            <span style="font-size: 11px; font-weight: 600; color: var(--primary); display: flex; align-items: center; gap: 4px;">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
              Choose any date
            </span>
          </div>

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
              <input type="text" name="joining_date" id="joining_date" 
                     class="form-control datepicker-input" 
                     value="<?= date('Y-m-d') ?>" 
                     placeholder="Select joining date..." 
                     required 
                     autocomplete="off"
                     onchange="updateProbationEndDatePreview()">
              <button type="button" class="calendar-trigger-btn" id="btnOpenJoinCalendar" title="Click to choose date from calendar">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                  <line x1="16" x2="16" y1="2" y2="6"/>
                  <line x1="8" x2="8" y1="2" y2="6"/>
                  <line x1="3" x2="21" y1="10" y2="10"/>
                </svg>
                <span>Calendar</span>
              </button>
            </div>

            <!-- Quick Date Options -->
            <div class="date-quick-chips">
              <span class="date-chip-label">Quick:</span>
              <button type="button" class="date-chip active" data-target="joining_date" data-preset="today">Today</button>
              <button type="button" class="date-chip" data-target="joining_date" data-preset="yesterday">Yesterday</button>
              <button type="button" class="date-chip" data-target="joining_date" data-preset="month_start">1st of Month</button>
              <button type="button" class="date-chip" data-target="joining_date" data-preset="tomorrow">Tomorrow</button>
              <button type="button" class="date-chip" data-target="joining_date" data-preset="next_week">+7 Days</button>
              <button type="button" class="date-chip" data-target="joining_date" data-preset="next_month">+30 Days</button>
            </div>
          </div>
        </div>

        <!-- Conditional Probation Duration Setup Panel -->
        <div class="form-group" id="probationSetupWrapper" style="display: none;">
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
            <label class="form-label" for="probation_duration_months" style="margin-bottom: 0;">
              Probation Period Duration
            </label>
            <span class="badge badge-warning" style="font-size: 10px;">Auto Evaluation</span>
          </div>
          <select name="probation_duration_months" id="probation_duration_months" class="form-control" onchange="updateProbationEndDatePreview()">
            <option value="1">1 Month</option>
            <option value="2">2 Months</option>
            <option value="3" selected>3 Months (90 Days Standard)</option>
            <option value="6">6 Months (Executive/Tech)</option>
            <option value="12">12 Months (1 Year)</option>
          </select>
          <div style="font-size: 11.5px; color: #64748b; margin-top: 6px;">
            Target Review Date: <strong id="probationEndDatePreview" style="color: #0f172a;">--</strong> &bull; Auto-synced to Confirmation Dashboard.
          </div>
        </div>
      </div>

      <!-- COMPENSATION & MANUAL SALARY INPUT CARD -->
      <div style="margin: 20px 0 28px; background: var(--bg-card-subtle, #f8fafc); border: 1.5px solid var(--border-color, #e2e8f0); border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
          <div>
            <div style="font-weight: 700; font-size: 14px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
              <span style="display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; background: rgba(16, 185, 129, 0.12); color: #059669;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
              </span>
              <span>Manual Salary &amp; Compensation Setup</span>
            </div>
            <p style="font-size: 12px; color: #64748b; margin: 4px 0 0 36px;">
              Specify base monthly compensation or manually fine-tune allowances and statutory withholdings.
            </p>
          </div>
          
          <!-- Mode switcher -->
          <div style="display: inline-flex; background: #e2e8f0; padding: 3px; border-radius: 8px; font-size: 12px; font-weight: 600;">
            <button type="button" id="btnModeAuto" onclick="setSalaryMode('auto')" style="padding: 5px 12px; border: none; border-radius: 6px; background: #ffffff; color: var(--primary, #4f46e5); cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1); font-weight: 600;">
              Auto Statutory (40% HRA + 12% PF)
            </button>
            <button type="button" id="btnModeCustom" onclick="setSalaryMode('custom')" style="padding: 5px 12px; border: none; border-radius: 6px; background: transparent; color: #64748b; cursor: pointer; font-weight: 600;">
              Manual Breakdown
            </button>
          </div>
          <input type="hidden" name="salary_mode" id="salary_mode" value="auto">
        </div>

        <!-- Base Salary Input Row -->
        <div class="grid-3" style="margin-bottom: 16px;">
          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="basic_salary" style="font-weight: 700; font-size: 13px; color: #0f172a;">
              Monthly Basic Salary <span style="color: #ef4444;">*</span>
            </label>
            <div style="position: relative;">
              <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 700; color: #64748b; font-size: 15px;">₹</span>
              <input type="number" name="basic_salary" id="basic_salary" class="form-control" 
                     placeholder="e.g. 35000" min="0" max="1000000" step="500" value="35000"
                     style="padding-left: 28px; font-size: 15px; font-weight: 700; color: #0f172a;"
                     oninput="calculateSalaryBreakdown()" required>
            </div>
            <div id="salaryBandFeedback" style="font-size: 11.5px; color: #059669; margin-top: 5px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
              <span>✓ Aligned with selected pay band</span>
            </div>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #64748b;">Quick Band Presets</label>
            <div style="display: flex; gap: 6px; align-items: center; margin-top: 4px; flex-wrap: wrap;">
              <button type="button" class="btn btn-outline btn-sm" onclick="applyPresetSalary('min')" style="font-size: 11px; padding: 4px 8px;">Band Min</button>
              <button type="button" class="btn btn-outline btn-sm" onclick="applyPresetSalary('mid')" style="font-size: 11px; padding: 4px 8px;">Band Mid</button>
              <button type="button" class="btn btn-outline btn-sm" onclick="applyPresetSalary('max')" style="font-size: 11px; padding: 4px 8px;">Band Max</button>
            </div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 6px;">
              Selected Band: <strong id="lblActiveBandName" style="color: #0f172a;">Executive Band 1</strong>
            </div>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #64748b;">Annual CTC Equivalent</label>
            <div id="preview_annual_ctc" style="font-size: 20px; font-weight: 800; color: #0f172a; margin-top: 4px;">
              ₹0.00 / annum
            </div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Based on 12-month gross compensation</div>
          </div>
        </div>

        <!-- Custom Breakdown Fields (Hidden in Auto mode) -->
        <div id="customSalaryBreakdown" style="display: none; padding: 16px; background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 16px;">
          <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #059669; margin-bottom: 10px; letter-spacing: 0.5px;">
            Manual Earnings &amp; Allowances:
          </div>
          <div class="grid-4" style="margin-bottom: 14px;">
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="hra" style="font-size: 12px;">House Rent Allowance (HRA)</label>
              <input type="number" name="hra" id="hra" class="form-control form-control-sm" min="0" step="100" value="14000" oninput="calculateCustomSalary()">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="conveyance_allowance" style="font-size: 12px;">Conveyance</label>
              <input type="number" name="conveyance_allowance" id="conveyance_allowance" class="form-control form-control-sm" min="0" step="50" value="1600" oninput="calculateCustomSalary()">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="special_allowance" style="font-size: 12px;">Special Allowance</label>
              <input type="number" name="special_allowance" id="special_allowance" class="form-control form-control-sm" min="0" step="100" value="3500" oninput="calculateCustomSalary()">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="medical_allowance" style="font-size: 12px;">Medical Allowance</label>
              <input type="number" name="medical_allowance" id="medical_allowance" class="form-control form-control-sm" min="0" step="50" value="1250" oninput="calculateCustomSalary()">
            </div>
          </div>

          <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #b91c1c; margin-bottom: 10px; letter-spacing: 0.5px;">
            Manual Deductions &amp; Withholdings:
          </div>
          <div class="grid-3" style="margin-bottom: 0;">
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="pf_deduction" style="font-size: 12px;">Provident Fund (12%)</label>
              <input type="number" name="pf_deduction" id="pf_deduction" class="form-control form-control-sm" min="0" step="50" value="4200" oninput="calculateCustomSalary()">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="tax_deduction" style="font-size: 12px;">Income Tax TDS (10%)</label>
              <input type="number" name="tax_deduction" id="tax_deduction" class="form-control form-control-sm" min="0" step="50" value="3500" oninput="calculateCustomSalary()">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
              <label class="form-label" for="insurance_deduction" style="font-size: 12px;">Medical Insurance</label>
              <input type="number" name="insurance_deduction" id="insurance_deduction" class="form-control form-control-sm" min="0" step="10" value="120" oninput="calculateCustomSalary()">
            </div>
          </div>
        </div>

        <!-- Live Calculation Summary Card -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; padding: 14px 18px; background: #ffffff; border: 1px solid var(--border-color); border-radius: 8px;">
          <div>
            <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b;">Basic Pay</div>
            <div id="disp_basic" style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 2px;">₹35,000.00</div>
          </div>
          <div>
            <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #059669;">Gross Monthly Outlay</div>
            <div id="disp_gross" style="font-size: 16px; font-weight: 700; color: #047857; margin-top: 2px;">₹55,350.00</div>
          </div>
          <div>
            <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #dc2626;">Total Deductions</div>
            <div id="disp_deductions" style="font-size: 16px; font-weight: 700; color: #b91c1c; margin-top: 2px;">-₹7,820.00</div>
          </div>
          <div>
            <div style="font-size: 11px; text-transform: uppercase; font-weight: 800; color: #4338ca;">Estimated Net In-Hand</div>
            <div id="disp_net" style="font-size: 18px; font-weight: 800; color: #4338ca; margin-top: 2px;">₹47,530.00</div>
          </div>
        </div>
      </div>

      <!-- 4. SYSTEM ACCESS, ROLE & PORTAL CREDENTIALS -->
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
            Define whether this employee will be a <strong>Manager</strong>, <strong>Employee (ESS)</strong>, <strong>HR Admin</strong>, <strong>Payroll Manager</strong>, etc., and configure their portal password.
          </p>
        </div>
        <span class="badge" style="background: var(--primary-light); color: var(--primary); font-weight: 700; padding: 4px 10px; border-radius: 20px; font-size: 11px;">
          RBAC Security
        </span>
      </div>

      <!-- Role Selector Header & Quick Cards -->
      <div class="form-group" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
          <label class="form-label" style="font-weight: 700; font-size: 14px; margin: 0; display: flex; align-items: center; gap: 6px;">
            <span>System Role &amp; Access Tier <span style="color: #ef4444;">*</span></span>
            <span style="font-size: 12px; font-weight: 400; color: #64748b;">(Click a card to set role)</span>
          </label>
          <span style="font-size: 12px; color: var(--primary); font-weight: 600;">Selected: <span id="lblSelectedRoleName">Employee (ESS)</span></span>
        </div>

        <style>
          .role-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
          }
          .role-card {
            border: 2px solid var(--border-color);
            background: var(--bg-card, #ffffff);
            border-radius: 10px;
            padding: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
          }
          .role-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(140, 122, 169, 0.15);
          }
          .role-card.active {
            border-color: var(--primary);
            background: rgba(140, 122, 169, 0.08);
            box-shadow: 0 0 0 1px var(--primary);
          }
          .role-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
          }
          .role-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
          }
          .role-pill-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
          }
          .role-card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main, #1e293b);
            margin-bottom: 4px;
          }
          .role-card-desc {
            font-size: 11px;
            color: #64748b;
            line-height: 1.4;
            flex-grow: 1;
            margin-bottom: 10px;
          }
          .role-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            font-weight: 600;
            color: #64748b;
            padding-top: 8px;
            border-top: 1px dashed var(--border-color);
          }
          .role-card.active .role-card-footer {
            color: var(--primary);
          }
          .role-radio-circle {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            display: inline-block;
            position: relative;
          }
          .role-card.active .role-radio-circle {
            border-color: var(--primary);
            background: var(--primary);
          }
          .role-card.active .role-radio-circle::after {
            content: '';
            position: absolute;
            width: 6px;
            height: 6px;
            background: #ffffff;
            border-radius: 50%;
            top: 3px;
            left: 3px;
          }
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

        
        

        <div class="role-cards-grid">
          <!-- 1. Super Admin (Tier 1) -->
          <div class="role-card" data-role-id="1" data-role-slug="super_admin" id="roleCard_1" onclick="selectRole(1)">
            <div class="role-card-top">
              <div class="role-icon-box" style="background: rgba(168, 85, 247, 0.15); color: #7e22ce;">👑</div>
              <span class="role-pill-badge" style="background: rgba(168, 85, 247, 0.15); color: #6b21a8;">Tier 1 &bull; Global Root</span>
            </div>
            <div class="role-card-title">Super Administrator</div>
            <div class="role-card-desc">Global unrestricted system authority across all modules, role permissions, audit trails &amp; tenant settings.</div>
            <div class="role-card-footer">
              <span class="role-action-lbl">Click to Select</span>
              <span class="role-radio-circle"></span>
            </div>
          </div>

          <!-- 2. HR Admin (Tier 2) -->
          <div class="role-card" data-role-id="2" data-role-slug="hr_admin" id="roleCard_2" onclick="selectRole(2)">
            <div class="role-card-top">
              <div class="role-icon-box" style="background: rgba(56, 189, 248, 0.15); color: #0284c7;">🛡️</div>
              <span class="role-pill-badge" style="background: rgba(56, 189, 248, 0.15); color: #0369a1;">Tier 2 &bull; HR Master</span>
            </div>
            <div class="role-card-title">HR Administrator</div>
            <div class="role-card-desc">Full Human Resources authority: onboarding, employee master data, departments, shifts, attendance &amp; policies.</div>
            <div class="role-card-footer">
              <span class="role-action-lbl">Click to Select</span>
              <span class="role-radio-circle"></span>
            </div>
          </div>

          <!-- 3. HR Executive (Tier 3) -->
          <div class="role-card" data-role-id="3" data-role-slug="hr_executive" id="roleCard_3" onclick="selectRole(3)">
            <div class="role-card-top">
              <div class="role-icon-box" style="background: rgba(16, 185, 129, 0.15); color: #059669;">📋</div>
              <span class="role-pill-badge" style="background: rgba(16, 185, 129, 0.15); color: #047857;">Tier 3 &bull; Operations</span>
            </div>
            <div class="role-card-title">HR Executive</div>
            <div class="role-card-desc">Day-to-day HR operations: employee onboarding records, attendance management &amp; compliance documents.</div>
            <div class="role-card-footer">
              <span class="role-action-lbl">Click to Select</span>
              <span class="role-radio-circle"></span>
            </div>
          </div>

          <!-- 4. Payroll Manager (Tier 4) -->
          <div class="role-card" data-role-id="4" data-role-slug="payroll_manager" id="roleCard_4" onclick="selectRole(4)">
            <div class="role-card-top">
              <div class="role-icon-box" style="background: rgba(245, 158, 11, 0.15); color: #d97706;">💰</div>
              <span class="role-pill-badge" style="background: rgba(245, 158, 11, 0.15); color: #b45309;">Tier 4 &bull; Payroll</span>
            </div>
            <div class="role-card-title">Payroll Manager</div>
            <div class="role-card-desc">Compensation &amp; Payroll runs. Calculates monthly payroll, salary structures, tax declarations &amp; payslips.</div>
            <div class="role-card-footer">
              <span class="role-action-lbl">Click to Select</span>
              <span class="role-radio-circle"></span>
            </div>
          </div>

          <!-- 5. Accountant (Tier 5) -->
          <div class="role-card" data-role-id="5" data-role-slug="accountant" id="roleCard_5" onclick="selectRole(5)">
            <div class="role-card-top">
              <div class="role-icon-box" style="background: rgba(244, 114, 182, 0.15); color: #db2777;">📊</div>
              <span class="role-pill-badge" style="background: rgba(244, 114, 182, 0.15); color: #be185d;">Tier 5 &bull; Finance</span>
            </div>
            <div class="role-card-title">Accountant</div>
            <div class="role-card-desc">Finance auditor &amp; accounts. Reimbursement approvals, advance loans, statutory compliance &amp; bank ledger exports.</div>
            <div class="role-card-footer">
              <span class="role-action-lbl">Click to Select</span>
              <span class="role-radio-circle"></span>
            </div>
          </div>

          <!-- 6. Manager / Dept Head (Tier 6) -->
          <div class="role-card" data-role-id="6" data-role-slug="manager" id="roleCard_6" onclick="selectRole(6)">
            <div class="role-card-top">
              <div class="role-icon-box" style="background: rgba(251, 146, 60, 0.15); color: #ea580c;">👔</div>
              <span class="role-pill-badge" style="background: rgba(251, 146, 60, 0.15); color: #c2410c;">Tier 6 &bull; Approvals</span>
            </div>
            <div class="role-card-title">Manager / Dept Head</div>
            <div class="role-card-desc">Manager Self-Service (MSS). Approves team leave requests, overtime claims &amp; direct reports' attendance.</div>
            <div class="role-card-footer">
              <span class="role-action-lbl">Click to Select</span>
              <span class="role-radio-circle"></span>
            </div>
          </div>

          <!-- 7. Employee (ESS) (Tier 7) -->
          <div class="role-card active" data-role-id="7" data-role-slug="employee" id="roleCard_7" onclick="selectRole(7)">
            <div class="role-card-top">
              <div class="role-icon-box" style="background: rgba(140, 122, 169, 0.15); color: var(--primary);">👤</div>
              <span class="role-pill-badge" style="background: rgba(140, 122, 169, 0.15); color: var(--primary);">Tier 7 &bull; ESS Regular</span>
            </div>
            <div class="role-card-title">Employee (ESS)</div>
            <div class="role-card-desc">Individual Employee Self-Service. Clock-in/out, leave applications, expense claims &amp; view personal payslips.</div>
            <div class="role-card-footer">
              <span class="role-action-lbl">Default Role ✓</span>
              <span class="role-radio-circle"></span>
            </div>
          </div>
        </div>

        <!-- Dropdown & Contract Type Grid -->
        <div class="grid-2">
          <div class="form-group">
            <label class="form-label" for="role_id">All Roles Dropdown Selector *</label>
            <select name="role_id" id="role_id" class="form-control" required onchange="syncRoleFromDropdown(this.value)">
              <?php foreach ($roles as $r): 
                $lvl = $r['hierarchy_level'] ?? $r['id'];
              ?>
                <option value="<?= esc($r['id']) ?>" 
                        data-slug="<?= esc($r['slug']) ?>"
                        data-desc="<?= esc($r['description']) ?>"
                        <?= ($r['slug'] === 'employee') ? 'selected' : '' ?>>
                  Tier <?= $lvl ?>: <?= esc($r['name']) ?> &mdash; <?= esc($r['description']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div style="font-size: 12px; color: #64748b; margin-top: 4px;" id="roleHelpDesc">
              Standard Individual Employee Self-Service. Can clock in/out, view payslips, and apply for leaves.
            </div>
          </div>
        </div>
      </div>

      <!-- PORTAL LOGIN CREDENTIALS & SET PASSWORD CARD -->
      <div class="portal-auth-card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
          <div style="display: flex; align-items: center; gap: 8px;">
            <div style="width: 28px; height: 28px; border-radius: 6px; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              🔑
            </div>
            <div>
              <span style="font-size: 14px; font-weight: 700; color: var(--text-main, #0f172a);">Portal Login Credentials &amp; Password</span>
              <span style="font-size: 12px; color: #64748b; margin-left: 6px;">Provision access for the employee portal</span>
            </div>
          </div>
          <span style="font-size: 11px; background: rgba(16, 185, 129, 0.15); color: #047857; font-weight: 700; padding: 2px 8px; border-radius: 10px;">
            Auto-Activated
          </span>
        </div>

        <div class="grid-2">
          <!-- 1. Username Field -->
          <div class="form-group" style="margin-bottom: 10px;">
            <label class="form-label" for="portal_username" style="display: flex; justify-content: space-between;">
              <span>Portal Login Username</span>
              <span style="font-size: 11px; color: #64748b;">(Auto-generated / editable)</span>
            </label>
            <div style="position: relative;">
              <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 600; color: #94a3b8; font-size: 14px;">@</span>
              <input type="text" name="username" id="portal_username" class="form-control" style="padding-left: 32px;" placeholder="e.g. alex.wright" autocomplete="off">
            </div>
            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">
              Employee will use this username (or their email) to log into the portal.
            </div>
          </div>

          <!-- 2. Set Password Field -->
          <div class="form-group" style="margin-bottom: 10px;">
            <label class="form-label" for="portal_password" style="display: flex; justify-content: space-between;">
              <span style="font-weight: 700;">Set Login Password</span>
              <span style="font-size: 11px; color: var(--primary); font-weight: 600;">Optional &bull; Defaults to Admin@123</span>
            </label>
            
            <div style="display: flex; gap: 8px;">
              <div style="position: relative; flex-grow: 1;">
                <input type="password" 
                       name="password" 
                       id="portal_password" 
                       class="form-control" 
                       placeholder="Enter password or leave blank for default (Admin@123)" 
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
              <button type="button" class="btn-pw-action" id="btnUseDefaultPw" title="Click to fill initial default password">
                ⚡ Set Default (Admin@123)
              </button>
              <button type="button" class="btn-pw-action" id="btnGenStrongPw" title="Click to generate randomized strong password">
                🎲 Generate Strong Password
              </button>
              <button type="button" class="btn-pw-action" id="btnClearPw" title="Leave blank to use default">
                ✕ Clear
              </button>
            </div>
          </div>
        </div>

        <!-- Helpful info banner -->
        <div style="margin-top: 10px; padding: 8px 12px; background: rgba(140, 122, 169, 0.08); border-radius: 6px; font-size: 12px; color: var(--text-main, #334155); display: flex; align-items: center; gap: 8px;">
          <span style="font-size: 14px;">💡</span>
          <span><strong>Quick Tip:</strong> If left empty, the portal password will automatically be set to <code>Admin@123</code>. The employee can change it upon logging into their portal.</span>
        </div>
      <!-- 5. BANKING & DIRECT DEPOSIT -->
      <h3 style="font-size: 15px; font-weight: 700; color: var(--primary); margin: 28px 0 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 6px;">
        5. Banking &amp; Disbursement Info
      </h3>

      <div class="grid-3">
        <div class="form-group">
          <label class="form-label" for="bank_name">Bank Name</label>
          <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="e.g. JPMorgan Chase Bank">
        </div>

        <div class="form-group">
          <label class="form-label" for="account_number">Bank Account Number</label>
          <input type="text" name="account_number" id="account_number" class="form-control" placeholder="e.g. 98273641829">
        </div>

        <div class="form-group">
          <label class="form-label" for="ifsc_swift_code">SWIFT / Routing / IFSC Code</label>
          <input type="text" name="ifsc_swift_code" id="ifsc_swift_code" class="form-control" placeholder="e.g. CHASUS33">
        </div>
      </div>

      <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 12px;">
        <a href="<?= site_url('employees') ?>" class="btn btn-outline">Cancel</a>
        <button type="submit" id="btnSubmitOnboarding" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">
          Complete Employee Onboarding
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Role Selection Card & Dropdown Sync
function selectRole(roleId) {
  const select = document.getElementById('role_id');
  if (select) {
    select.value = roleId;
    syncRoleFromDropdown(roleId);
  }
}

function syncRoleFromDropdown(roleId) {
  // Update card highlights
  document.querySelectorAll('.role-card').forEach(card => {
    card.classList.remove('active');
    const footerLbl = card.querySelector('.role-action-lbl');
    if (footerLbl) footerLbl.textContent = 'Click to Select';
  });

  const targetCard = document.getElementById('roleCard_' + roleId);
  if (targetCard) {
    targetCard.classList.add('active');
    const footerLbl = targetCard.querySelector('.role-action-lbl');
    if (footerLbl) footerLbl.textContent = 'Selected ✓';
  }

  // Update label and help text
  const select = document.getElementById('role_id');
  if (select && select.selectedIndex >= 0) {
    const opt = select.options[select.selectedIndex];
    const roleName = opt.text.split('—')[0].trim();
    const roleDesc = opt.getAttribute('data-desc') || opt.text;
    const lblRole = document.getElementById('lblSelectedRoleName');
    if (lblRole) lblRole.textContent = roleName;
    const descHelp = document.getElementById('roleHelpDesc');
    if (descHelp) descHelp.textContent = roleDesc;
  }
}

// Auto-suggest username from First Name + Last Name
let usernameManuallyEdited = false;
const fnInput = document.getElementById('first_name');
const lnInput = document.getElementById('last_name');
const unInput = document.getElementById('portal_username');

if (unInput) {
  unInput.addEventListener('input', function() {
    usernameManuallyEdited = this.value.trim().length > 0;
  });
}

function updateSuggestedUsername() {
  if (usernameManuallyEdited) return;
  const fn = (fnInput ? fnInput.value : '').trim().toLowerCase().replace(/[^a-z0-9]/g, '');
  const ln = (lnInput ? lnInput.value : '').trim().toLowerCase().replace(/[^a-z0-9]/g, '');
  if (unInput && (fn || ln)) {
    unInput.value = (fn && ln) ? `${fn}.${ln}` : (fn || ln);
  }
}

if (fnInput) fnInput.addEventListener('input', updateSuggestedUsername);
if (lnInput) lnInput.addEventListener('input', updateSuggestedUsername);

// Password Controls: Show/Hide, Set Default, Generate Strong, Clear
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
    const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#$%&*';
    let randomPw = '';
    // Generate an 11-char password with mixed characters
    randomPw += 'A' + Math.floor(Math.random() * 90 + 10);
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

// Profile Photo Preview & Clear Handlers
function previewProfilePhoto(input) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('photoPreviewImg');
      const placeholder = document.getElementById('photoPlaceholder');
      const btnRemove = document.getElementById('btnRemovePhoto');
      const filenameLbl = document.getElementById('photoFilename');

      if (img && placeholder) {
        img.src = e.target.result;
        img.style.display = 'block';
        placeholder.style.display = 'none';
      }
      if (btnRemove) btnRemove.style.display = 'inline-flex';
      if (filenameLbl) {
        const sizeKb = Math.round(file.size / 1024);
        filenameLbl.textContent = `${file.name} (${sizeKb} KB)`;
        filenameLbl.style.color = 'var(--primary)';
        filenameLbl.style.fontWeight = '600';
      }
    };
    reader.readAsDataURL(file);
  }
}

function clearProfilePhoto() {
  const input = document.getElementById('profile_photo');
  const img = document.getElementById('photoPreviewImg');
  const placeholder = document.getElementById('photoPlaceholder');
  const btnRemove = document.getElementById('btnRemovePhoto');
  const filenameLbl = document.getElementById('photoFilename');

  if (input) input.value = '';
  if (img) {
    img.src = '';
    img.style.display = 'none';
  }
  if (placeholder) placeholder.style.display = 'block';
  if (btnRemove) btnRemove.style.display = 'none';
  if (filenameLbl) {
    filenameLbl.textContent = 'No file selected';
    filenameLbl.style.color = '#64748b';
    filenameLbl.style.fontWeight = 'normal';
  }
}

// Copy Present Address to Permanent Address
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

const presentAddrInput = document.getElementById('present_address');
if (presentAddrInput) {
  presentAddrInput.addEventListener('input', function() {
    const chk = document.getElementById('chkSameAddress');
    const perm = document.getElementById('permanent_address');
    if (chk && chk.checked && perm) {
      perm.value = this.value;
    }
  });
}

// ==============================================================
// COMPENSATION & MANUAL SALARY LOGIC
// ==============================================================
function setSalaryMode(mode) {
  document.getElementById('salary_mode').value = mode;
  const btnAuto = document.getElementById('btnModeAuto');
  const btnCust = document.getElementById('btnModeCustom');
  const customSection = document.getElementById('customSalaryBreakdown');

  if (mode === 'auto') {
    btnAuto.style.background = '#ffffff';
    btnAuto.style.color = 'var(--primary, #4f46e5)';
    btnAuto.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
    btnCust.style.background = 'transparent';
    btnCust.style.color = '#64748b';
    btnCust.style.boxShadow = 'none';
    if (customSection) customSection.style.display = 'none';
    calculateSalaryBreakdown();
  } else {
    btnCust.style.background = '#ffffff';
    btnCust.style.color = 'var(--primary, #4f46e5)';
    btnCust.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
    btnAuto.style.background = 'transparent';
    btnAuto.style.color = '#64748b';
    btnAuto.style.boxShadow = 'none';
    if (customSection) customSection.style.display = 'block';
    calculateCustomSalary();
  }
}

function calculateSalaryBreakdown() {
  const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
  const mode = document.getElementById('salary_mode').value;

  if (mode === 'custom') {
    calculateCustomSalary();
    return;
  }

  // Auto Statutory Calculation (40% HRA, 12% PF, 10% TDS Tax, Conveyance: 1600, Medical: 1250, Ins: 120)
  const hra = Math.round(basic * 0.40);
  const conv = 1600;
  const spec = Math.round(basic * 0.10);
  const med = 1250;
  const pf = Math.round(basic * 0.12);
  const tax = Math.round(basic * 0.10);
  const ins = 120;

  // Sync custom input fields in case user toggles to custom later
  if (document.getElementById('hra')) document.getElementById('hra').value = hra;
  if (document.getElementById('conveyance_allowance')) document.getElementById('conveyance_allowance').value = conv;
  if (document.getElementById('special_allowance')) document.getElementById('special_allowance').value = spec;
  if (document.getElementById('medical_allowance')) document.getElementById('medical_allowance').value = med;
  if (document.getElementById('pf_deduction')) document.getElementById('pf_deduction').value = pf;
  if (document.getElementById('tax_deduction')) document.getElementById('tax_deduction').value = tax;
  if (document.getElementById('insurance_deduction')) document.getElementById('insurance_deduction').value = ins;

  const gross = basic + hra + conv + spec + med;
  const deductions = pf + tax + ins;
  const net = Math.max(0, gross - deductions);
  const ctc = gross * 12;

  updateSalaryDisplay(basic, gross, deductions, net, ctc);
  validateBandRange(basic);
}

function calculateCustomSalary() {
  const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
  const hra = parseFloat(document.getElementById('hra').value) || 0;
  const conv = parseFloat(document.getElementById('conveyance_allowance').value) || 0;
  const spec = parseFloat(document.getElementById('special_allowance').value) || 0;
  const med = parseFloat(document.getElementById('medical_allowance').value) || 0;
  const pf = parseFloat(document.getElementById('pf_deduction').value) || 0;
  const tax = parseFloat(document.getElementById('tax_deduction').value) || 0;
  const ins = parseFloat(document.getElementById('insurance_deduction').value) || 0;

  const gross = basic + hra + conv + spec + med;
  const deductions = pf + tax + ins;
  const net = Math.max(0, gross - deductions);
  const ctc = gross * 12;

  updateSalaryDisplay(basic, gross, deductions, net, ctc);
  validateBandRange(basic);
}

function updateSalaryDisplay(basic, gross, deductions, net, ctc) {
  const fmt = (num) => '₹' + Number(num).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  if (document.getElementById('disp_basic')) document.getElementById('disp_basic').innerText = fmt(basic);
  if (document.getElementById('disp_gross')) document.getElementById('disp_gross').innerText = fmt(gross);
  if (document.getElementById('disp_deductions')) document.getElementById('disp_deductions').innerText = '-' + fmt(deductions);
  if (document.getElementById('disp_net')) document.getElementById('disp_net').innerText = fmt(net);
  if (document.getElementById('preview_annual_ctc')) document.getElementById('preview_annual_ctc').innerText = fmt(ctc) + ' / annum';
}

function onPayGradeChange(select) {
  const opt = select.options[select.selectedIndex];
  if (!opt) return;

  const min = parseFloat(opt.getAttribute('data-min')) || 0;
  const max = parseFloat(opt.getAttribute('data-max')) || 0;
  const name = opt.getAttribute('data-name') || opt.text;

  const lbl = document.getElementById('lblActiveBandName');
  if (lbl) lbl.innerText = name;

  validateBandRange(parseFloat(document.getElementById('basic_salary').value) || 0);
}

function validateBandRange(amount) {
  const gradeSelect = document.getElementById('pay_grade_id');
  if (!gradeSelect) return;
  const opt = gradeSelect.options[gradeSelect.selectedIndex];
  if (!opt) return;

  const min = parseFloat(opt.getAttribute('data-min')) || 0;
  const max = parseFloat(opt.getAttribute('data-max')) || 0;
  const feedback = document.getElementById('salaryBandFeedback');
  if (!feedback) return;

  if (amount >= min && (max === 0 || amount <= max)) {
    feedback.innerHTML = '<span style="color: #059669;">✓ Within selected pay band (₹' + min.toLocaleString('en-IN') + ' - ₹' + max.toLocaleString('en-IN') + ')</span>';
  } else if (amount < min) {
    feedback.innerHTML = '<span style="color: #d97706;">ℹ Below pay band minimum (₹' + min.toLocaleString('en-IN') + ') - Custom override</span>';
  } else {
    feedback.innerHTML = '<span style="color: #d97706;">ℹ Above pay band maximum (₹' + max.toLocaleString('en-IN') + ') - Custom override</span>';
  }
}

function applyPresetSalary(type) {
  const gradeSelect = document.getElementById('pay_grade_id');
  if (!gradeSelect) return;
  const opt = gradeSelect.options[gradeSelect.selectedIndex];
  if (!opt) return;

  const min = parseFloat(opt.getAttribute('data-min')) || 0;
  const max = parseFloat(opt.getAttribute('data-max')) || 45000;
  let target = min;

  if (type === 'min') {
    target = min === 0 ? 15000 : min;
  } else if (type === 'mid') {
    target = Math.round((min + max) / 2);
  } else if (type === 'max') {
    target = max;
  }

  const basicInput = document.getElementById('basic_salary');
  if (basicInput) {
    basicInput.value = target;
    calculateSalaryBreakdown();
  }
}

function toggleProbationFields(val) {
  const wrapper = document.getElementById('probationSetupWrapper');
  if (!wrapper) return;
  if (val === 'probation') {
    wrapper.style.display = 'block';
    updateProbationEndDatePreview();
  } else {
    wrapper.style.display = 'none';
  }
}

function updateProbationEndDatePreview() {
  const joinInput = document.getElementById('joining_date');
  const durSelect = document.getElementById('probation_duration_months');
  const preview = document.getElementById('probationEndDatePreview');
  if (!joinInput || !durSelect || !preview) return;

  const joinVal = joinInput.value;
  const months = parseInt(durSelect.value, 10) || 3;
  if (!joinVal) {
    preview.textContent = '--';
    return;
  }

  const d = new Date(joinVal + 'T00:00:00');
  d.setMonth(d.getMonth() + months);
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  preview.textContent = d.toLocaleDateString(undefined, options);
}

// Initial calculation on page load
document.addEventListener('DOMContentLoaded', function() {
  const gradeSelect = document.getElementById('pay_grade_id');
  if (gradeSelect) onPayGradeChange(gradeSelect);
  calculateSalaryBreakdown();

  const empTypeSelect = document.getElementById('employment_type');
  if (empTypeSelect) toggleProbationFields(empTypeSelect.value);
});
</script>
