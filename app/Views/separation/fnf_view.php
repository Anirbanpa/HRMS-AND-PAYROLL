<div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <a href="<?= site_url('separation') ?>" class="btn btn-outline btn-sm">
      &larr; Back to Separation Pipeline
    </a>
  </div>
  <div style="display: flex; gap: 10px;">
    <button onclick="window.print()" class="btn btn-primary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
      Print Official Statement
    </button>
  </div>
</div>

<!-- PRINTABLE FNF DOCUMENT -->
<div class="card print-area" style="max-width: 860px; margin: 0 auto; padding: 40px; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-radius: 8px;">
  <!-- Header -->
  <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0f172a; padding-bottom: 20px; margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 16px;">
      <img src="<?= base_url('assets/images/infosof-logo.png') ?>" alt="Infosof Logo" style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid #D8BCAB; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      <div>
        <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">INFOSOF TECHNOLOGIES INC.</h1>
        <p style="color: #64748b; font-size: 13px; margin: 0; line-height: 1.4;">
          Corporate Headquarters: Plot Y-12, Sector V, Salt Lake, Kolkata, West Bengal 700091<br>
          CIN: U72200WB2020PTC012345 &bull; payroll@infosof.com
        </p>
      </div>
    </div>
    <div style="text-align: right;">
      <div style="font-size: 18px; font-weight: 800; color: #7c3aed; text-transform: uppercase; letter-spacing: 0.5px;">
        F&amp;F SETTLEMENT
      </div>
      <div style="font-size: 13px; color: #64748b; margin-top: 4px;">
        Ref: <strong>FNF-<?= str_pad((string)$settlement['id'], 5, '0', STR_PAD_LEFT) ?></strong><br>
        Date: <strong><?= date('M d, Y', strtotime($settlement['settlement_date'])) ?></strong>
      </div>
    </div>
  </div>

  <!-- Employee Details Grid -->
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #f8fafc; padding: 18px; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 28px;">
    <div>
      <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 8px;">Employee Particulars</div>
      <table style="width: 100%; font-size: 13px; line-height: 1.8;">
        <tr><td style="color: #64748b; width: 40%;">Employee Name:</td><td><strong><?= esc($settlement['first_name'] . ' ' . $settlement['last_name']) ?></strong></td></tr>
        <tr><td style="color: #64748b;">Employee Code:</td><td><strong><?= esc($settlement['employee_code']) ?></strong></td></tr>
        <tr><td style="color: #64748b;">Designation:</td><td><?= esc($settlement['designation_title'] ?? 'Staff') ?></td></tr>
        <tr><td style="color: #64748b;">Department:</td><td><?= esc($settlement['department_name'] ?? 'General') ?></td></tr>
      </table>
    </div>
    <div>
      <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700; margin-bottom: 8px;">Separation &amp; Bank Details</div>
      <table style="width: 100%; font-size: 13px; line-height: 1.8;">
        <tr><td style="color: #64748b; width: 40%;">Joining Date:</td><td><?= !empty($settlement['joining_date']) ? date('M d, Y', strtotime($settlement['joining_date'])) : 'N/A' ?></td></tr>
        <tr><td style="color: #64748b;">Last Working Day:</td><td><strong><?= !empty($settlement['approved_last_working_day']) ? date('M d, Y', strtotime($settlement['approved_last_working_day'])) : 'N/A' ?></strong></td></tr>
        <tr><td style="color: #64748b;">Disbursement Bank:</td><td><?= esc($settlement['bank_name'] ?? 'Primary Account') ?></td></tr>
        <tr><td style="color: #64748b;">Account Number:</td><td><code><?= esc($settlement['account_number'] ?? 'On Record') ?></code></td></tr>
      </table>
    </div>
  </div>

  <!-- Breakdown Table -->
  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px;">
    <!-- EARNINGS / CREDITS -->
    <div style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
      <div style="background: #f0fdf4; padding: 10px 14px; font-weight: 700; font-size: 13px; color: #166534; border-bottom: 1px solid #bbf7d0;">
        A. SETTLEMENT EARNINGS &amp; CREDITS
      </div>
      <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
        <tbody>
          <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; color: #334155;">Unpaid Salary (<?= esc($settlement['unpaid_salary_days']) ?> Days)</td>
            <td style="padding: 10px 14px; text-align: right; font-weight: 600;">₹<?= number_format((float)$settlement['unpaid_salary_amount'], 2) ?></td>
          </tr>
          <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; color: #334155;">Leave Encashment (<?= esc($settlement['leave_encashment_days']) ?> Days)</td>
            <td style="padding: 10px 14px; text-align: right; font-weight: 600;">₹<?= number_format((float)$settlement['leave_encashment_amount'], 2) ?></td>
          </tr>
          <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; color: #334155;">Statutory Gratuity Benefit</td>
            <td style="padding: 10px 14px; text-align: right; font-weight: 600;">₹<?= number_format((float)$settlement['gratuity_amount'], 2) ?></td>
          </tr>
          <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; color: #334155;">Ex-Gratia / Discretionary Bonus</td>
            <td style="padding: 10px 14px; text-align: right; font-weight: 600;">₹<?= number_format((float)$settlement['bonus_amount'], 2) ?></td>
          </tr>
        </tbody>
        <tfoot>
          <tr style="background: #f8fafc; font-weight: 700; border-top: 1px solid #e2e8f0;">
            <td style="padding: 10px 14px; color: #0f172a;">Total Earnings (A)</td>
            <td style="padding: 10px 14px; text-align: right; color: #16a34a;">₹<?= number_format((float)$settlement['total_earnings'], 2) ?></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <!-- DEDUCTIONS / RECOVERIES -->
    <div style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
      <div style="background: #fef2f2; padding: 10px 14px; font-weight: 700; font-size: 13px; color: #991b1b; border-bottom: 1px solid #fecaca;">
        B. RECOVERIES &amp; STATUTORY DEDUCTIONS
      </div>
      <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
        <tbody>
          <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; color: #334155;">Notice Shortfall Recovery</td>
            <td style="padding: 10px 14px; text-align: right; font-weight: 600;">₹<?= number_format((float)$settlement['notice_shortfall_recovery'], 2) ?></td>
          </tr>
          <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; color: #334155;">Asset / IT Clearance Recovery</td>
            <td style="padding: 10px 14px; text-align: right; font-weight: 600;">₹<?= number_format((float)$settlement['asset_damage_deduction'], 2) ?></td>
          </tr>
          <tr style="border-bottom: 1px solid #f1f5f9;">
            <td style="padding: 10px 14px; color: #334155;">Statutory Withholding Tax</td>
            <td style="padding: 10px 14px; text-align: right; font-weight: 600;">₹<?= number_format((float)$settlement['statutory_tax_deduction'], 2) ?></td>
          </tr>
        </tbody>
        <tfoot>
          <tr style="background: #f8fafc; font-weight: 700; border-top: 1px solid #e2e8f0;">
            <td style="padding: 10px 14px; color: #0f172a;">Total Deductions (B)</td>
            <td style="padding: 10px 14px; text-align: right; color: #dc2626;">₹<?= number_format((float)$settlement['total_deductions'], 2) ?></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  <!-- NET PAYABLE BOX -->
  <div style="background: #0f172a; color: #ffffff; border-radius: 8px; padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 36px;">
    <div>
      <div style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8;">Net Final Payout (A - B)</div>
      <div style="font-size: 12px; opacity: 0.7; margin-top: 4px;">Payment Mode: <?= esc(ucwords(str_replace('_', ' ', $settlement['payment_mode']))) ?></div>
    </div>
    <div style="font-size: 32px; font-weight: 800; color: #4ade80;">
      ₹<?= number_format((float)$settlement['net_payable_amount'], 2) ?>
    </div>
  </div>

  <!-- Acknowledgement & Signatures -->
  <div style="font-size: 12px; color: #64748b; line-height: 1.6; margin-bottom: 36px; padding: 14px; background: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
    <strong>Employee Declaration:</strong> I hereby acknowledge receipt of this Full &amp; Final settlement statement and confirm that upon receipt of the above net amount, I will have no outstanding claims, financial or otherwise, against Infosof Technologies Inc.
  </div>

  <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 30px; margin-top: 40px; pt-4;">
    <div style="border-top: 1px solid #94a3b8; padding-top: 8px; text-align: center; font-size: 12px; color: #334155;">
      <strong>Prepared By</strong><br>
      Payroll Operations
    </div>
    <div style="border-top: 1px solid #94a3b8; padding-top: 8px; text-align: center; font-size: 12px; color: #334155;">
      <strong>Verified By</strong><br>
      Finance &amp; Accounts
    </div>
    <div style="border-top: 1px solid #94a3b8; padding-top: 8px; text-align: center; font-size: 12px; color: #334155;">
      <strong>Employee Acceptance</strong><br>
      Signature &amp; Date
    </div>
  </div>
</div>

<style>
@media print {
  body { background: #fff !important; }
  .app-sidebar, .app-topbar, .no-print { display: none !important; }
  .app-main { margin-left: 0 !important; }
  .page-content { padding: 0 !important; }
  .print-area { box-shadow: none !important; border: none !important; width: 100% !important; max-width: 100% !important; padding: 0 !important; }
}
</style>
