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

      <!-- 1. IDENTIFICATION & BASIC DETAILS -->
      <h3 style="font-size: 15px; font-weight: 700; color: var(--primary); margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 6px; display: flex; align-items: center; justify-content: space-between;">
        <span style="display: flex; align-items: center; gap: 8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
          1. Personal Identity &amp; Contact Details
        </span>
        <span style="font-size: 12px; color: #64748b; font-weight: 400;">Personal identity &amp; official records</span>
      </h3>

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

      <div class="grid-2">
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
            Specify initial basic salary or CTC. Detailed statutory breakdowns &amp; allowances can be managed in <strong>Monthly Payroll</strong>.
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
                     placeholder="e.g. 35000" min="0" step="any" value="35000"
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
                     placeholder="e.g. 600000" min="0" step="any" value="600000"
                     style="padding-left: 28px; font-weight: 600; font-size: 14.5px;"
                     oninput="onMinimalCtcInput(this.value)">
            </div>
            <div style="font-size: 11.5px; color: #64748b; margin-top: 4px;">Approximate package per annum</div>
          </div>

          <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" style="font-weight: 600; font-size: 13px; color: #64748b;">Estimated Net In-Hand</label>
            <div id="minimal_net_preview" style="font-size: 18px; font-weight: 800; color: #4338ca; padding-top: 4px;">
              ₹47,530.00 / mo
            </div>
            <div style="font-size: 11.5px; color: #059669; font-weight: 600; margin-top: 4px;" id="minimal_gross_preview">
              Gross Monthly: ₹55,350.00
            </div>
          </div>
        </div>

        <!-- Hidden inputs for backend store -->
        <input type="hidden" name="salary_mode" id="salary_mode" value="auto">
        <input type="hidden" name="hra" id="hra" value="14000">
        <input type="hidden" name="conveyance_allowance" id="conveyance_allowance" value="1600">
        <input type="hidden" name="special_allowance" id="special_allowance" value="3500">
        <input type="hidden" name="medical_allowance" id="medical_allowance" value="1250">
        <input type="hidden" name="other_allowances" id="other_allowances" value="0">
        <input type="hidden" name="pf_deduction" id="pf_deduction" value="4200">
        <input type="hidden" name="tax_deduction" id="tax_deduction" value="200">
        <input type="hidden" name="insurance_deduction" id="insurance_deduction" value="120">
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
                    <?= ($r['slug'] === 'employee') ? 'selected' : '' ?>>
              Tier <?= $lvl ?>: <?= esc($r['name']) ?> &mdash; <?= esc($r['description']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <div style="font-size: 12px; color: #64748b; margin-top: 6px;" id="roleHelpDesc">
          Standard Individual Employee Self-Service. Can clock in/out, view payslips, and apply for leaves.
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
// Role Selection Dropdown Helper
function updateRoleHelpDesc(select) {
  if (select && select.selectedIndex >= 0) {
    const opt = select.options[select.selectedIndex];
    const roleDesc = opt.getAttribute('data-desc') || opt.text;
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
// MINIMAL SALARY & CTC ONBOARDING LOGIC
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
  const basicInput = document.getElementById('basic_salary');
  if (basicInput) {
    onMinimalBasicInput(basicInput.value);
  }

  const empTypeSelect = document.getElementById('employment_type');
  if (empTypeSelect) toggleProbationFields(empTypeSelect.value);
});
</script>
