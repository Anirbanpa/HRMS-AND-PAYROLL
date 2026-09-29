<div class="page-header" style="margin-bottom: 24px;">
  <h2 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Reports &amp; Compliance Export Center</h2>
  <p style="color: #64748b; font-size: 14px; margin: 0;">Generate auditable CSV datasets, monthly attendance summaries, bank payout files, and statutory tax reports.</p>
</div>

<!-- KPI Cards -->
<div class="kpi-grid" style="margin-bottom: 28px;">
  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Active Workforce</span>
      <div class="kpi-icon" style="background: rgba(37,99,235,0.1); color: #2563eb;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= esc($totalEmployees) ?> Profiles</div>
    <div class="kpi-subtitle">Available for instant data export</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Payroll Runs Logged</span>
      <div class="kpi-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
      </div>
    </div>
    <div class="kpi-value"><?= count($payrollRuns) ?> Cycles</div>
    <div class="kpi-subtitle">Total Disbursed: ₹<?= number_format((float)$totalPayrollDisbursed, 2) ?></div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Data Sanitization</span>
      <div class="kpi-icon" style="background: rgba(14,165,233,0.1); color: #0ea5e9;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
      </div>
    </div>
    <div class="kpi-value">UTF-8 + BOM</div>
    <div class="kpi-subtitle">Formula injection protected</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-header">
      <span class="kpi-title">Format Standard</span>
      <div class="kpi-icon" style="background: rgba(245,158,11,0.1); color: #d97706;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
      </div>
    </div>
    <div class="kpi-value">Bank / Excel</div>
    <div class="kpi-subtitle">Compatible with all major banks</div>
  </div>
</div>

<!-- 4 REPORT GENERATION CARDS -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 24px; margin-bottom: 28px;">
  
  <!-- 1. EMPLOYEE DIRECTORY REPORT -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(37,99,235,0.1); color: #2563eb; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <div>
        <div class="card-title">Employee Master Directory</div>
        <div style="font-size: 12px; color: #64748b;">Complete employee roster with personal, department, and banking info</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1;">
      <form action="<?= site_url('reports/export/employees') ?>" method="GET">
        <div style="display: flex; flex-direction: column; gap: 14px;">
          <div class="form-group">
            <label class="form-label">Filter by Department</label>
            <select name="department_id" class="form-control">
              <option value="">All Departments</option>
              <?php foreach ($departments as $d): ?>
                <option value="<?= $d['id'] ?>"><?= esc($d['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Employment Status</label>
            <select name="status" class="form-control">
              <option value="">All Statuses (Active, Probation, Terminated)</option>
              <option value="active">Active Only</option>
              <option value="probation">Probation Only</option>
              <option value="terminated">Terminated / Exited Only</option>
            </select>
          </div>
          <div style="margin-top: 10px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
              Download Employee Directory (.csv)
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- 2. MONTHLY ATTENDANCE REGISTER -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(14,165,233,0.1); color: #0ea5e9; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <div class="card-title">Monthly Attendance Summary</div>
        <div style="font-size: 12px; color: #64748b;">Present days, late arrivals, leaves, and absence percentages</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1;">
      <form action="<?= site_url('reports/export/attendance') ?>" method="GET">
        <div style="display: flex; flex-direction: column; gap: 14px;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div class="form-group">
              <label class="form-label">Month</label>
              <select name="month" class="form-control">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                  <option value="<?= $m ?>" <?= ($m == (int)date('n')) ? 'selected' : '' ?>>
                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                  </option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Year</label>
              <select name="year" class="form-control">
                <option value="2026" selected>2026</option>
                <option value="2025">2025</option>
              </select>
            </div>
          </div>
          <div style="margin-top: 36px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #0284c7; border-color: #0284c7;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
              Download Attendance Summary (.csv)
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- 3. PAYROLL BANK DISBURSEMENT FILE -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(16,185,129,0.1); color: #10b981; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12"/><path d="M6 8h12"/><path d="m6 13 8.5 8"/><path d="M6 13h3"/><path d="M9 13c6.667 0 6.667-10 0-10"/></svg>
      </div>
      <div>
        <div class="card-title">Bank Payout File (ACH / NEFT)</div>
        <div style="font-size: 12px; color: #64748b;">Direct upload format for corporate online banking batch disbursements</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1;">
      <form action="<?= site_url('reports/export/payroll-bank') ?>" method="GET">
        <div style="display: flex; flex-direction: column; gap: 14px;">
          <div class="form-group">
            <label class="form-label">Select Processed Payroll Cycle *</label>
            <select name="payroll_run_id" class="form-control" required>
              <option value="">-- Choose Processed Payroll Run --</option>
              <?php foreach ($payrollRuns as $run): ?>
                <option value="<?= $run['id'] ?>">
                  Run #<?= $run['id'] ?> &bull; <?= date('F Y', mktime(0, 0, 0, (int)$run['month'], 1, (int)$run['year'])) ?> &bull; ₹<?= number_format((float)$run['total_net'], 2) ?> Net (<?= esc($run['total_employees']) ?> Staff)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
            Includes: Beneficiary Name, Account Number, Bank Name, IFSC / Routing Code, and Exact Net Salary.
          </div>
          <div style="margin-top: 10px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #16a34a; border-color: #16a34a;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
              Download Bank Batch File (.csv)
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- 4. STATUTORY PF & TAX RECONCILIATION -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(124,58,237,0.1); color: #7c3aed; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
      </div>
      <div>
        <div class="card-title">Statutory Tax &amp; PF Compliance</div>
        <div style="font-size: 12px; color: #64748b;">Employer &amp; Employee Provident Fund (12%) and Tax Withholdings</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1;">
      <form action="<?= site_url('reports/export/statutory') ?>" method="GET">
        <div style="display: flex; flex-direction: column; gap: 14px;">
          <div class="form-group">
            <label class="form-label">Select Payroll Cycle *</label>
            <select name="payroll_run_id" class="form-control" required>
              <option value="">-- Choose Processed Payroll Run --</option>
              <?php foreach ($payrollRuns as $run): ?>
                <option value="<?= $run['id'] ?>">
                  Run #<?= $run['id'] ?> &bull; <?= date('F Y', mktime(0, 0, 0, (int)$run['month'], 1, (int)$run['year'])) ?> &bull; Deductions: ₹<?= number_format((float)$run['total_deductions'], 2) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
            Audit reconciliation for monthly government remittances and payroll compliance filings.
          </div>
          <div style="margin-top: 10px;">
            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; background: #7c3aed; border-color: #7c3aed;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
              Download Statutory Tax Report (.csv)
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- 5. PERFORMANCE APPRAISAL MATRIX REPORT -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(245,158,11,0.1); color: #d97706; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <div>
        <div class="card-title">Performance Appraisal Matrix</div>
        <div style="font-size: 12px; color: #64748b;">Employee ratings, manager review bands, promotion flags, and increment %</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
      <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">
        Audited scorecard data across evaluation cycles including self-assessment scores, manager recommendations, and proposed salary hike percentages.
      </p>
      <a href="<?= site_url('reports/export/appraisals') ?>" class="btn btn-primary" style="width: 100%; justify-content: center; background: #d97706; border-color: #d97706; text-decoration: none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Download Appraisals Matrix (.csv)
      </a>
    </div>
  </div>

  <!-- 6. TRAINING & SKILLS DEVELOPMENT REPORT -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(5,150,105,0.1); color: #059669; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
      </div>
      <div>
        <div class="card-title">Training &amp; Skills Matrix</div>
        <div style="font-size: 12px; color: #64748b;">Course attendance, participant scores, credentials, and certified skills</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
      <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">
        Comprehensive log of corporate programs, trainer hours, employee attendance roll-call percentages, and competency badges awarded.
      </p>
      <a href="<?= site_url('reports/export/training') ?>" class="btn btn-primary" style="width: 100%; justify-content: center; background: #059669; border-color: #059669; text-decoration: none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Download Training &amp; Skills (.csv)
      </a>
    </div>
  </div>

  <!-- 7. RECRUITMENT ATS TALENT PIPELINE REPORT -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(99,102,241,0.1); color: #6366f1; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
      </div>
      <div>
        <div class="card-title">Recruitment ATS &amp; Talent Pipeline</div>
        <div style="font-size: 12px; color: #64748b;">Candidate stages, job requisitions, interviewer ratings, and hire rates</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
      <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">
        End-to-end recruitment funnel report with stage tracking from initial application screening to interview ratings and final onboarding.
      </p>
      <a href="<?= site_url('reports/export/recruitment') ?>" class="btn btn-primary" style="width: 100%; justify-content: center; background: #6366f1; border-color: #6366f1; text-decoration: none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Download ATS Pipeline (.csv)
      </a>
    </div>
  </div>

  <!-- 8. SEPARATION & EXIT CLEARANCE REPORT -->
  <div class="card" style="display: flex; flex-direction: column;">
    <div class="card-header" style="border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px;">
      <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(239,68,68,0.1); color: #ef4444; display: flex; align-items: center; justify-content: center;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
      </div>
      <div>
        <div class="card-title">Separation &amp; FnF Settlements</div>
        <div style="font-size: 12px; color: #64748b;">Attrition trends, department clearance status, gratuity, and final payouts</div>
      </div>
    </div>
    <div style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
      <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">
        Auditable exit register logging notice periods, last working days, reasons for departure, department clearances, and full &amp; final disbursements.
      </p>
      <a href="<?= site_url('reports/export/separation') ?>" class="btn btn-primary" style="width: 100%; justify-content: center; background: #dc2626; border-color: #dc2626; text-decoration: none;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Download Separation &amp; FnF (.csv)
      </a>
    </div>
  </div>

</div>
