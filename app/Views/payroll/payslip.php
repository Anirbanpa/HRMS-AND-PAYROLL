<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payslip: <?= esc($payslip['employee_code']) ?> - <?= date('F Y', mktime(0,0,0, $payslip['month'], 10)) ?> | Infosof Technologies</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: #f1f5f9;
      color: #0f172a;
      padding: 30px 16px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .payslip-sheet {
      width: 100%;
      max-width: 820px;
      background: #ffffff;
      border: 1px solid #cbd5e1;
      border-radius: 12px;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
      padding: 40px;
    }
    .header-table {
      width: 100%;
      margin-bottom: 24px;
      border-bottom: 2px solid #0f172a;
      padding-bottom: 16px;
    }
    .brand-title {
      font-size: 22px;
      font-weight: 800;
      color: #1e1b4b;
      letter-spacing: -0.02em;
    }
    .brand-meta {
      font-size: 11.5px;
      color: #64748b;
      line-height: 1.5;
      margin-top: 4px;
    }
    .payslip-badge {
      text-align: right;
    }
    .payslip-badge h3 {
      font-size: 16px;
      font-weight: 800;
      color: #4f46e5;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    .payslip-badge .number {
      font-size: 13px;
      font-weight: 700;
      color: #0f172a;
      margin-top: 2px;
    }
    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 24px;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 16px;
      font-size: 12.5px;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      padding: 3px 0;
    }
    .info-row .label {
      color: #64748b;
    }
    .info-row .val {
      font-weight: 600;
      color: #0f172a;
    }
    .breakdown-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
      font-size: 13px;
    }
    .breakdown-table th {
      background: #0f172a;
      color: #ffffff;
      text-transform: uppercase;
      font-size: 11px;
      letter-spacing: 0.05em;
      padding: 10px 14px;
      font-weight: 700;
    }
    .breakdown-table td {
      padding: 9px 14px;
      border-bottom: 1px solid #e2e8f0;
    }
    .amount-col {
      text-align: right;
      font-weight: 600;
    }
    .total-row {
      font-weight: 800;
      background: #f8fafc;
      font-size: 13.5px;
    }
    .net-banner {
      background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
      color: #ffffff;
      border-radius: 8px;
      padding: 18px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .net-banner .title {
      font-size: 14px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #c7d2fe;
    }
    .net-banner .figure {
      font-size: 26px;
      font-weight: 800;
      color: #ffffff;
    }
    .signature-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      margin-top: 40px;
      padding-top: 20px;
      border-top: 1px dashed #cbd5e1;
      font-size: 12px;
      color: #64748b;
    }
    .sig-line {
      border-top: 1px solid #0f172a;
      margin-top: 40px;
      padding-top: 6px;
      font-weight: 600;
      color: #0f172a;
      text-align: center;
    }
    .notice {
      margin-top: 24px;
      font-size: 11px;
      color: #94a3b8;
      text-align: center;
    }
    .print-actions {
      margin-bottom: 20px;
      display: flex;
      gap: 12px;
    }
    .btn-print {
      background: #4f46e5;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      font-size: 13px;
    }
    @media print {
      body {
        background: #fff;
        padding: 0;
      }
      .payslip-sheet {
        border: none;
        box-shadow: none;
        padding: 0;
        max-width: 100%;
      }
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>
<body>

<div class="print-actions no-print">
  <button type="button" class="btn-print" onclick="window.print();">
    Print / Save as PDF
  </button>
  <button type="button" class="btn-print" style="background: #64748b;" onclick="window.close();">
    Close Window
  </button>
</div>

<div class="payslip-sheet">
  <!-- COMPANY HEADER -->
  <table class="header-table">
    <tr>
      <td style="vertical-align: top; width: 62px; padding-right: 14px;">
        <img src="<?= base_url('assets/images/infosof-logo.png') ?>" alt="Infosof Logo" style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid #D8BCAB; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
      </td>
      <td style="vertical-align: top;">
        <div class="brand-title"><?= esc($payslip['company']['name'] ?? 'Infosof Technologies Corp.') ?></div>
        <div class="brand-meta">
          Corporate HQ: <?= esc($payslip['branch_name'] ?? 'Kolkata Headquarters') ?> &bull; <?= esc($payslip['branch_city'] ?? 'Kolkata') ?>, India<br>
          Tax ID: <?= esc($payslip['company']['tax_id'] ?? 'EIN-12-9847291') ?> &bull; Currency: INR (₹) &bull; Official Portal
        </div>
      </td>
      <td class="payslip-badge" style="vertical-align: top;">
        <h3>Confidential Payslip</h3>
        <div class="number"><?= esc($payslip['payslip_number']) ?></div>
        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
          Pay Period: <strong><?= date('F Y', mktime(0,0,0, $payslip['month'], 10)) ?></strong>
        </div>
      </td>
    </tr>
  </table>

  <!-- EMPLOYEE & BANK INFO -->
  <div class="info-grid">
    <div>
      <div class="info-row">
        <span class="label">Employee Name:</span>
        <span class="val"><?= esc($payslip['first_name'] . ' ' . $payslip['last_name']) ?></span>
      </div>
      <div class="info-row">
        <span class="label">Employee Code:</span>
        <span class="val" style="color: #4f46e5;"><?= esc($payslip['employee_code']) ?></span>
      </div>
      <div class="info-row">
        <span class="label">Department:</span>
        <span class="val"><?= esc($payslip['department_name'] ?? 'General Operations') ?></span>
      </div>
      <div class="info-row">
        <span class="label">Designation:</span>
        <span class="val"><?= esc($payslip['designation_name'] ?? 'Staff') ?></span>
      </div>
    </div>
    <div>
      <div class="info-row">
        <span class="label">Bank Name:</span>
        <span class="val"><?= esc($payslip['bank']['bank_name'] ?? 'JPMorgan Chase') ?></span>
      </div>
      <div class="info-row">
        <span class="label">Account Number:</span>
        <span class="val"><code><?= esc($payslip['bank']['account_number'] ?? '**** 4921') ?></code></span>
      </div>
      <div class="info-row">
        <span class="label">Disbursement Mode:</span>
        <span class="val">Direct Electronic Deposit (ACH)</span>
      </div>
      <div class="info-row">
        <span class="label">Disbursement Date:</span>
        <span class="val"><?= esc($payslip['payment_date'] ? date('M j, Y', strtotime($payslip['payment_date'])) : date('M j, Y')) ?></span>
      </div>
    </div>
  </div>

  <!-- 2-COLUMN EARNINGS AND DEDUCTIONS -->
  <table class="breakdown-table">
    <thead>
      <tr>
        <th style="width: 35%;">Earnings &amp; Allowances</th>
        <th style="width: 15%; text-align: right;">Amount (₹)</th>
        <th style="width: 35%;">Statutory Deductions</th>
        <th style="width: 15%; text-align: right;">Amount (₹)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Basic Salary</td>
        <td class="amount-col"><?= number_format($payslip['basic_salary'], 2) ?></td>
        <td>Provident Fund (PF / Social Security 12%)</td>
        <td class="amount-col" style="color: #b91c1c;"><?= number_format($payslip['pf_deduction'], 2) ?></td>
      </tr>
      <tr>
        <td>House Rent Allowance (HRA)</td>
        <td class="amount-col"><?= number_format($payslip['hra'], 2) ?></td>
        <td>Income Tax Withholding (TDS)</td>
        <td class="amount-col" style="color: #b91c1c;"><?= number_format($payslip['tax_deduction'], 2) ?></td>
      </tr>
      <tr>
        <td>Conveyance Allowance</td>
        <td class="amount-col"><?= number_format($payslip['conveyance'], 2) ?></td>
        <td>Medical &amp; Health Insurance</td>
        <td class="amount-col" style="color: #b91c1c;"><?= number_format($payslip['insurance_deduction'], 2) ?></td>
      </tr>
      <tr>
        <td>Special Allowance</td>
        <td class="amount-col"><?= number_format($payslip['special_allowance'], 2) ?></td>
        <td>Loan EMI / Advance Adjustment</td>
        <td class="amount-col" style="color: #b91c1c;"><?= number_format($payslip['loan_emi_deduction'], 2) ?></td>
      </tr>
      <tr>
        <td>Medical Allowance</td>
        <td class="amount-col"><?= number_format($payslip['medical_allowance'], 2) ?></td>
        <td>Unpaid Cut / Absence Proration</td>
        <td class="amount-col" style="color: #b91c1c;"><?= number_format($payslip['unpaid_cut'], 2) ?></td>
      </tr>
      <tr class="total-row">
        <td>GROSS EARNINGS</td>
        <td class="amount-col" style="color: #047857;">₹<?= number_format($payslip['gross_salary'], 2) ?></td>
        <td>TOTAL STATUTORY DEDUCTIONS</td>
        <td class="amount-col" style="color: #b91c1c;">₹<?= number_format($payslip['total_deductions'], 2) ?></td>
      </tr>
    </tbody>
  </table>

  <!-- NET PAY BANNER -->
  <div class="net-banner">
    <div>
      <div class="title">Net Take-Home Salary Disbursement</div>
      <div style="font-size: 11.5px; color: #a5b4fc; margin-top: 2px;">
        Payment Status: <strong>PAID &bull; DIRECT ACCOUNT TRANSFER</strong>
      </div>
    </div>
    <div class="figure">
      ₹<?= number_format($payslip['net_salary'], 2) ?>
    </div>
  </div>

  <!-- SIGNATURE BLOCKS -->
  <div class="signature-grid">
    <div>
      <div class="sig-line">Employer Authorized Signatory</div>
      <p style="text-align: center; margin-top: 4px;">Director of People &amp; Payroll Operations</p>
    </div>
    <div>
      <div class="sig-line">Employee Signature / Acknowledgment</div>
      <p style="text-align: center; margin-top: 4px;">Digitally Acknowledged in ESS Portal</p>
    </div>
  </div>

  <div class="notice">
    This statement is an official computer-generated document under Section 21 of the Infosof HRMS Suite. All statutory deductions are reconciled and submitted to regulatory authorities.
  </div>
</div>

</body>
</html>
