<div style="margin-bottom: 24px;">
  <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
    Enterprise &amp; Organizational Setup
  </h2>
  <p style="font-size: 13.5px; color: #64748b; margin-top: 2px;">
    Multi-branch infrastructure, pay bands, designations, financial years, and access tier topologies.
  </p>
</div>

<!-- COMPANY PROFILE SUMMARY -->
<div class="card" style="margin-bottom: 24px;">
  <div class="card-header"><div class="card-title">Registered Enterprise Entity (Module 3, 41)</div></div>
  <div class="card-body">
    <div class="grid-3" style="margin-bottom: 0;">
      <div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600;">LEGAL ENTITY</div>
        <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 2px;"><?= esc($company['name']) ?></div>
        <div style="font-size: 12px; color: #64748b;">Code: <strong><?= esc($company['code']) ?></strong> &bull; Tax ID: <?= esc($company['tax_id']) ?></div>
      </div>
      <div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600;">ACCOUNTING &amp; DISBURSEMENT</div>
        <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-top: 2px;">Currency: <?= esc($company['currency']) ?> &bull; Timezone: <?= esc($company['timezone']) ?></div>
        <div style="font-size: 12px; color: #64748b;">Fiscal Year Cycle: Starts Month <?= esc($company['fiscal_year_start_month']) ?> (January)</div>
      </div>
      <div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600;">GLOBAL HEADQUARTERS</div>
        <div style="font-size: 13.5px; color: #0f172a; margin-top: 2px;"><?= esc($company['address']) ?></div>
        <div style="font-size: 12px; color: #64748b;"><?= esc($company['email']) ?> &bull; <?= esc($company['phone']) ?></div>
      </div>
    </div>
  </div>
</div>

<!-- 2-COLUMN: BRANCHES & DESIGNATIONS -->
<div class="grid-2">
  <!-- Branches -->
  <div class="card">
    <div class="card-header"><div class="card-title">Operating Regional Branches</div></div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Branch Code</th>
            <th>Branch Name</th>
            <th>Location</th>
            <th>Workforce</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($branches as $br): ?>
            <tr>
              <td><span class="badge badge-primary"><?= esc($br['branch_code']) ?></span></td>
              <td>
                <div style="font-weight: 700;"><?= esc($br['name']) ?></div>
                <?php if ($br['is_head_office']): ?>
                  <span class="badge badge-success" style="font-size: 10px;">Global HQ</span>
                <?php endif; ?>
              </td>
              <td><?= esc($br['city']) ?>, <?= esc($br['country']) ?></td>
              <td><strong><?= esc($br['employee_count']) ?></strong> personnel</td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pay Bands & Grades -->
  <div class="card">
    <div class="card-header"><div class="card-title">Compensation Bands &amp; Pay Grades (Module 3)</div></div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Band Code</th>
            <th>Grade Title</th>
            <th style="text-align: right;">Min Base</th>
            <th style="text-align: right;">Max Base</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($payGrades as $pg): ?>
            <tr>
              <td><span class="badge badge-secondary"><?= esc($pg['grade_code']) ?></span></td>
              <td><strong><?= esc($pg['grade_name']) ?></strong></td>
              <td style="text-align: right;">₹<?= number_format($pg['min_salary']) ?></td>
              <td style="text-align: right; color: var(--primary); font-weight: 700;">₹<?= number_format($pg['max_salary']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- 7 ACCESS TIERS TOPOLOGY -->
<div class="card">
  <div class="card-header"><div class="card-title">7 Predefined Role-Based Access Control (RBAC) Tiers (Module 1)</div></div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Tier Level</th>
          <th>Role Identifier</th>
          <th>Role Title</th>
          <th>Description &amp; Operational Scope</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($roles as $r): ?>
          <tr>
            <td><span class="badge badge-primary">Tier <?= esc($r['id']) ?></span></td>
            <td><code><?= esc($r['slug']) ?></code></td>
            <td><strong><?= esc($r['name']) ?></strong></td>
            <td><?= esc($r['description']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
