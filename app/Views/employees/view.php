<div style="margin-bottom: 20px;">
  <a href="<?= site_url('employees') ?>" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
    &larr; Back to Employee Directory
  </a>
</div>

<!-- PROFILE HERO HEADER -->
<div class="card" style="background: linear-gradient(to right, #ffffff, #f8fafc); border-top: 4px solid var(--primary);">
  <div class="card-body" style="padding: 28px;">
    <div style="display: flex; gap: 24px; align-items: center; flex-wrap: wrap;">
      <?php if (!empty($employee['profile_photo']) && file_exists(FCPATH . $employee['profile_photo'])): ?>
        <img src="<?= base_url(esc($employee['profile_photo'])) ?>" alt="Profile Photo" style="width: 80px; height: 80px; border-radius: 20px; object-fit: cover; box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4); border: 2px solid #fff;">
      <?php else: ?>
        <div style="width: 80px; height: 80px; border-radius: 20px; background: var(--primary-gradient); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800; color: #fff; box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);">
          <?= esc(substr($employee['first_name'], 0, 1) . substr($employee['last_name'], 0, 1)) ?>
        </div>
      <?php endif; ?>

      <div style="flex: 1; min-width: 260px;">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
          <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.01em;">
            <?= esc($employee['first_name'] . ' ' . ($employee['middle_name'] ? $employee['middle_name'] . ' ' : '') . $employee['last_name']) ?>
          </h2>
          <span class="badge badge-primary" style="font-size: 12px;"><?= esc($employee['employee_code']) ?></span>
          <span class="badge badge-success"><?= esc(ucfirst($employee['employment_status'])) ?></span>
        </div>

        <p style="font-size: 14.5px; font-weight: 600; color: var(--primary); margin-bottom: 8px;">
          <?= esc($employee['designation_name'] ?? 'Personnel') ?> &bull; <?= esc($employee['department_name'] ?? 'General') ?>
        </p>

        <div style="display: flex; gap: 20px; flex-wrap: wrap; font-size: 13px; color: #64748b;">
          <div><strong>Email:</strong> <?= esc($employee['email']) ?></div>
          <div><strong>Phone:</strong> <?= esc($employee['phone']) ?></div>
          <div><strong>Country:</strong> <?= esc($employee['country'] ?? 'United States') ?></div>
          <div><strong>Branch:</strong> <?= esc($employee['branch_name'] ?? 'HQ') ?> (<?= esc($employee['branch_city'] ?? 'USA') ?>)</div>
          <div><strong>Joined:</strong> <?= esc(date('F j, Y', strtotime($employee['joining_date']))) ?></div>
        </div>
      </div>

      <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
        <?php if (($currentRoleSlug ?? '') !== 'employee' && (in_array('employee.edit', $userPermissions ?? []) || in_array($currentRoleSlug ?? '', ['super_admin', 'hr_admin', 'hr_executive']))): ?>
          <a href="<?= site_url('employees/edit/' . $employee['id']) ?>" id="btnEditProfile" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
            Edit Profile
          </a>
        <?php endif; ?>

        <?php if (($currentRoleSlug ?? '') === 'super_admin' || in_array('employee.delete', $userPermissions ?? [])): ?>
          <button type="button" id="btnDeleteEmployee" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 6px;" onclick="document.getElementById('modalDeleteEmployee').style.display='flex'">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
            Delete Employee
          </button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- 360° PROFILE TABS CONTAINER -->
<div class="tabs-container">
  <div class="tabs-nav">
    <button type="button" class="tab-btn active" data-target="#tabPersonal">Personal &amp; Demographics</button>
    <button type="button" class="tab-btn" data-target="#tabJob">Organization &amp; Job Placement</button>
    <button type="button" class="tab-btn" data-target="#tabBank">Banking &amp; Disbursement</button>
    <button type="button" class="tab-btn" data-target="#tabSalary">Compensation &amp; Salary Structure</button>
    <button type="button" class="tab-btn" data-target="#tabLeave">Leave Balances (2026)</button>
    <button type="button" class="tab-btn" data-target="#tabAttendance">Recent Attendance</button>
    <button type="button" class="tab-btn" data-target="#tabDocs">Document Vault &amp; Proofs</button>
  </div>

  <!-- TAB 1: PERSONAL & DEMOGRAPHICS -->
  <div class="tab-pane active" id="tabPersonal">
    <div class="grid-2">
      <div class="card">
        <div class="card-header"><div class="card-title">Demographics &amp; Identity</div></div>
        <div class="card-body">
          <table class="table" style="font-size: 13.5px;">
            <tr><th style="width: 40%;">Gender</th><td><?= esc(ucfirst($employee['gender'])) ?></td></tr>
            <tr><th>Date of Birth</th><td><?= esc($employee['date_of_birth'] ?? 'Not specified') ?></td></tr>
            <tr><th>Marital Status</th><td><?= esc(ucfirst($employee['marital_status'])) ?></td></tr>
            <tr><th>Blood Group</th><td><?= esc($employee['blood_group'] ?? 'Not provided') ?></td></tr>
            <tr><th>National ID / SSN</th><td><?= esc($employee['national_id_ssn'] ?? 'Encrypted on File') ?></td></tr>
            <tr><th>Tax ID (TIN)</th><td><?= esc($employee['tax_identification_number'] ?? 'Encrypted on File') ?></td></tr>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><div class="card-title">Address &amp; Emergency Contact</div></div>
        <div class="card-body">
          <table class="table" style="font-size: 13.5px;">
            <tr><th style="width: 40%;">Present Address</th><td><?= esc(!empty($employee['present_address']) ? $employee['present_address'] : 'Not provided') ?></td></tr>
            <tr><th>Permanent Address</th><td><?= esc(!empty($employee['permanent_address']) ? $employee['permanent_address'] : ($employee['present_address'] ?? 'Not provided')) ?></td></tr>
            <tr><th>City, State, Zip</th><td><?= esc($employee['city'] ?? '') ?>, <?= esc($employee['state'] ?? '') ?> <?= esc($employee['postal_code'] ?? '') ?></td></tr>
            <tr><th>Country</th><td><span class="badge badge-primary"><?= esc($employee['country'] ?? 'United States') ?></span></td></tr>
            <tr><th>Emergency Contact Name</th><td><?= esc($employee['emergency_contact_name'] ?? 'Not provided') ?></td></tr>
            <tr><th>Relationship</th><td><?= esc($employee['emergency_contact_relation'] ?? 'Not provided') ?></td></tr>
            <tr><th>Emergency Phone</th><td><?= esc($employee['emergency_contact_phone'] ?? 'Not provided') ?></td></tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB 2: ORGANIZATION & JOB PLACEMENT -->
  <div class="tab-pane" id="tabJob">
    <div class="card">
      <div class="card-header"><div class="card-title">Corporate Hierarchy &amp; Reporting Structure</div></div>
      <div class="card-body">
        <div class="grid-2">
          <table class="table">
            <tr><th style="width: 40%;">Department</th><td><strong><?= esc($employee['department_name'] ?? 'General') ?></strong></td></tr>
            <tr><th>Designation</th><td><strong><?= esc($employee['designation_name'] ?? 'Staff') ?></strong></td></tr>
            <tr><th>Branch / Location</th><td><?= esc($employee['branch_name'] ?? 'HQ') ?> (<?= esc($employee['branch_city']) ?>, <?= esc($employee['branch_country']) ?>)</td></tr>
            <tr><th>Pay Band / Grade</th><td><?= esc($employee['grade_name'] ?? 'Standard Band') ?></td></tr>
          </table>

          <table class="table">
            <tr><th style="width: 40%;">Reporting Manager</th><td>
              <?php if ($employee['manager_first_name']): ?>
                <strong><?= esc($employee['manager_first_name'] . ' ' . $employee['manager_last_name']) ?></strong>
                <div style="font-size: 12px; color: #64748b;"><?= esc($employee['manager_email']) ?></div>
              <?php else: ?>
                <span style="color: #64748b;">Direct Executive / Board</span>
              <?php endif; ?>
            </td></tr>
            <tr><th>Employment Type</th><td><?= esc(ucwords(str_replace('_', ' ', $employee['employment_type']))) ?></td></tr>
            <tr><th>Joining Date</th><td><?= esc(date('F j, Y', strtotime($employee['joining_date']))) ?></td></tr>
            <tr><th>Portal User Account</th><td><code><?= esc($employee['username'] ?? 'None') ?></code> (Role: <?= esc($employee['role_name'] ?? 'Employee') ?>)</td></tr>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- TAB 3: BANKING & DISBURSEMENT -->
  <div class="tab-pane" id="tabBank">
    <div class="card">
      <div class="card-header"><div class="card-title">Primary Banking &amp; Direct Deposit Details</div></div>
      <div class="card-body">
        <?php if (!empty($employee['bank_details'])): ?>
          <table class="table">
            <thead>
              <tr>
                <th>Bank Name</th>
                <th>Account Holder</th>
                <th>Account Number</th>
                <th>SWIFT / IFSC / Routing</th>
                <th>Branch Name</th>
                <th>Disbursement Mode</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($employee['bank_details'] as $bk): ?>
                <tr>
                  <td><strong><?= esc($bk['bank_name']) ?></strong></td>
                  <td><?= esc($bk['account_name']) ?></td>
                  <td><code><?= esc($bk['account_number']) ?></code></td>
                  <td><?= esc($bk['ifsc_swift_code'] ?? 'N/A') ?></td>
                  <td><?= esc($bk['branch_name'] ?? 'Main') ?></td>
                  <td><span class="badge badge-primary"><?= esc(ucwords(str_replace('_', ' ', $bk['payment_method']))) ?></span></td>
                  <td><span class="badge badge-success">Primary Active</span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p style="color: #64748b; padding: 20px; text-align: center;">No banking details registered yet.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- TAB 4: COMPENSATION & SALARY STRUCTURE -->
  <div class="tab-pane" id="tabSalary">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Monthly Salary Structure &amp; Statutory Breakdown</div>
      </div>
      <div class="card-body">
        <?php if (!empty($employee['salary_structure'])): 
          $ss = $employee['salary_structure'];
        ?>
          <div class="grid-2">
            <!-- Earnings -->
            <div>
              <h4 style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 12px; border-bottom: 2px solid #10b981; padding-bottom: 6px;">
                Monthly Earnings &amp; Allowances
              </h4>
              <table class="table">
                <tr><td>Basic Salary</td><td style="text-align: right; font-weight: 600;">₹<?= number_format($ss['basic_salary'], 2) ?></td></tr>
                <tr><td>House Rent Allowance (HRA)</td><td style="text-align: right;">₹<?= number_format($ss['hra'], 2) ?></td></tr>
                <tr><td>Conveyance Allowance</td><td style="text-align: right;">₹<?= number_format($ss['conveyance_allowance'], 2) ?></td></tr>
                <tr><td>Special Allowance</td><td style="text-align: right;">₹<?= number_format($ss['special_allowance'], 2) ?></td></tr>
                <tr><td>Medical Allowance</td><td style="text-align: right;">₹<?= number_format($ss['medical_allowance'], 2) ?></td></tr>
                <tr style="background: #ecfdf5; font-weight: 700; font-size: 15px;">
                  <td>GROSS MONTHLY SALARY</td>
                  <td style="text-align: right; color: #047857;">₹<?= number_format($ss['gross_salary'], 2) ?></td>
                </tr>
              </table>
            </div>

            <!-- Deductions -->
            <div>
              <h4 style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 12px; border-bottom: 2px solid #ef4444; padding-bottom: 6px;">
                Monthly Statutory &amp; Pre-tax Deductions
              </h4>
              <table class="table">
                <tr><td>Provident Fund (PF / Social Security)</td><td style="text-align: right; color: #b91c1c;">₹<?= number_format($ss['pf_deduction'], 2) ?></td></tr>
                <tr><td>Income Tax Withholding (TDS)</td><td style="text-align: right; color: #b91c1c;">₹<?= number_format($ss['tax_deduction'], 2) ?></td></tr>
                <tr><td>Medical Insurance Plan</td><td style="text-align: right; color: #b91c1c;">₹<?= number_format($ss['insurance_deduction'], 2) ?></td></tr>
                <tr style="background: #fef2f2; font-weight: 700; font-size: 14px;">
                  <td>TOTAL DEDUCTIONS</td>
                  <td style="text-align: right; color: #b91c1c;">₹<?= number_format($ss['total_deductions'], 2) ?></td>
                </tr>
                <tr style="background: #eef2ff; font-weight: 800; font-size: 16px;">
                  <td>NET DISBURSEMENT PAY</td>
                  <td style="text-align: right; color: #4338ca;">₹<?= number_format($ss['net_salary'], 2) ?></td>
                </tr>
              </table>
            </div>
          </div>
        <?php else: ?>
          <p style="color: #64748b; padding: 20px; text-align: center;">No salary structure defined yet for this employee.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- TAB 5: LEAVE BALANCES -->
  <div class="tab-pane" id="tabLeave">
    <div class="card">
      <div class="card-header"><div class="card-title">Leave Entitlements &amp; Remaining Balances (Year 2026)</div></div>
      <div class="card-body">
        <?php if (!empty($employee['leave_balances'])): ?>
          <table class="table">
            <thead>
              <tr>
                <th>Leave Category</th>
                <th>Type Code</th>
                <th>Paid Status</th>
                <th>Allocated Days</th>
                <th>Utilized Days</th>
                <th>Pending Approvals</th>
                <th>Available Balance</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($employee['leave_balances'] as $lb): ?>
                <tr>
                  <td><strong><?= esc($lb['leave_type_name']) ?></strong></td>
                  <td><span class="badge badge-secondary"><?= esc($lb['leave_type_code']) ?></span></td>
                  <td>
                    <?php if ($lb['is_paid']): ?>
                      <span class="badge badge-success">Paid</span>
                    <?php else: ?>
                      <span class="badge badge-warning">Unpaid</span>
                    <?php endif; ?>
                  </td>
                  <td><?= esc($lb['allocated_days']) ?> days</td>
                  <td><?= esc($lb['used_days']) ?> days</td>
                  <td><?= esc($lb['pending_days']) ?> days</td>
                  <td>
                    <strong style="color: var(--primary); font-size: 15px;"><?= esc($lb['remaining_days']) ?> days</strong>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p style="color: #64748b; padding: 20px; text-align: center;">No leave balances initialized.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- TAB 6: ATTENDANCE -->
  <div class="tab-pane" id="tabAttendance">
    <div class="card">
      <div class="card-header"><div class="card-title">Recent Daily Attendance Logs</div></div>
      <div class="card-body">
        <?php if (!empty($employee['recent_attendance'])): ?>
          <table class="table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Clock In</th>
                <th>Clock Out</th>
                <th>Total Hours</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($employee['recent_attendance'] as $att): ?>
                <tr>
                  <td><?= esc($att['date']) ?></td>
                  <td><?= esc($att['clock_in'] ? date('H:i:s', strtotime($att['clock_in'])) : '-') ?></td>
                  <td><?= esc($att['clock_out'] ? date('H:i:s', strtotime($att['clock_out'])) : '-') ?></td>
                  <td><?= esc($att['total_hours']) ?> hrs</td>
                  <td><span class="badge badge-success"><?= esc($att['status']) ?></span></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div style="padding: 30px; text-align: center; color: #64748b;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: 8px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <p>No recent attendance logs recorded yet for this period.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- TAB 7: DOCUMENTS & VAULT -->
  <div class="tab-pane" id="tabDocs">
    <div class="grid-2-1">
      <!-- Document List Table -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">Employee Document Repository (Module 6)</div>
          <span style="font-size: 12px; color: #64748b;"><?= count($employee['documents'] ?? []) ?> files vaulted</span>
        </div>
        <div class="card-body" style="padding: 0;">
          <table class="table" style="margin-bottom: 0;">
            <thead>
              <tr>
                <th>Document Title</th>
                <th>Type</th>
                <th>Expiry Date</th>
                <th>Verification</th>
                <th>Uploaded</th>
                <th style="text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($employee['documents'])): ?>
                <tr>
                  <td colspan="6" style="text-align: center; color: #94a3b8; padding: 30px;">
                    No identity or educational documents vaulted yet. Use the upload panel on the right to add records.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($employee['documents'] as $doc): ?>
                  <tr>
                    <td>
                      <div style="font-weight: 600; color: #0f172a;"><?= esc($doc['document_title']) ?></div>
                      <code style="font-size: 11px; color: #64748b;"><?= esc($doc['file_path']) ?></code>
                    </td>
                    <td>
                      <span class="badge badge-primary"><?= esc(ucwords(str_replace('_', ' ', $doc['document_type']))) ?></span>
                    </td>
                    <td>
                      <?php if ($doc['expiry_date']): ?>
                        <span style="font-size: 12px; color: <?= (strtotime($doc['expiry_date']) < time()) ? '#ef4444' : '#10b981' ?>; font-weight: 600;">
                          <?= esc($doc['expiry_date']) ?>
                        </span>
                      <?php else: ?>
                        <span style="color: #94a3b8; font-size: 12px;">Non-expiring</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($doc['is_verified']): ?>
                        <span class="badge badge-success">Verified</span>
                      <?php else: ?>
                        <span class="badge badge-warning">Pending</span>
                      <?php endif; ?>
                    </td>
                    <td style="font-size: 12px; color: #64748b;">
                      <?= esc(date('M j, Y', strtotime($doc['uploaded_at']))) ?>
                    </td>
                    <td style="text-align: right; white-space: nowrap;">
                      <?php if (!empty($doc['file_path']) && file_exists(FCPATH . $doc['file_path'])): ?>
                        <a href="<?= base_url(esc($doc['file_path'])) ?>" target="_blank" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 4px; margin-right: 6px;">
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                          View / Download
                        </a>
                      <?php endif; ?>
                      <a href="<?= site_url('employees/document/delete/' . $doc['id']) ?>" class="btn btn-outline btn-sm" style="color: #ef4444;" onclick="return confirm('Permanently remove this document from vault?');">
                        Delete
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Upload Form Panel -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">Catalog New Document</div>
        </div>
        <div class="card-body">
          <form action="<?= site_url('employees/document/upload') ?>" method="POST" enctype="multipart/form-data" id="formUploadDocument">
            <?= csrf_field() ?>
            <input type="hidden" name="employee_id" value="<?= esc($employee['id']) ?>">

            <div class="form-group">
              <label class="form-label" for="document_title">Document Title <span style="color: #ef4444;">*</span></label>
              <input type="text" name="document_title" id="document_title" class="form-control" placeholder="e.g. Passport Photo ID Page" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="document_type">Document Category <span style="color: #ef4444;">*</span></label>
              <select name="document_type" id="document_type" class="form-control" required>
                <option value="national_id">National ID / Social Security</option>
                <option value="passport">Passport</option>
                <option value="degree">Degree / Diploma Certificate</option>
                <option value="contract">Employment Agreement</option>
                <option value="resume">Resume / CV</option>
                <option value="tax_form">W-4 / Tax Exemption Form</option>
                <option value="certificate">Professional Certification</option>
                <option value="other">Other Supporting Proof</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="document_file">Document File (PDF, DOC, DOCX, JPG, PNG) <span style="color: #ef4444;">*</span></label>
              <input type="file" name="document_file" id="document_file" class="form-control" style="font-size: 12px;" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="expiry_date">Expiry Date (if applicable)</label>
              <input type="date" name="expiry_date" id="expiry_date" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px;" id="btnSubmitDoc">
              Vault Document
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<?php if (($currentRoleSlug ?? '') === 'super_admin' || in_array('employee.delete', $userPermissions ?? [])): ?>
<div id="modalDeleteEmployee" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
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
        <strong>Warning:</strong> This will archive the master profile, terminate employment status, deactivate associated user portal login, and remove the record from active directories.
      </div>
    </div>
    <div style="padding: 16px 24px; background: var(--bg-card-subtle, #f8fafc); border-top: 1px solid var(--border-color, #e2e8f0); display: flex; justify-content: flex-end; gap: 10px;">
      <button type="button" class="btn btn-outline" onclick="document.getElementById('modalDeleteEmployee').style.display='none'">
        Cancel
      </button>
      <form action="<?= site_url('employees/delete/' . $employee['id']) ?>" method="POST" style="margin: 0;">
        <?= csrf_field() ?>
        <button type="submit" id="btnConfirmDeleteEmp" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 6px;">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          Confirm Delete
        </button>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

