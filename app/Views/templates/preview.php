<div class="no-print" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
  <div>
    <a href="<?= site_url('templates') ?>" class="btn btn-outline btn-sm">
      &larr; Back to Templates Hub
    </a>
  </div>
  <div style="display: flex; gap: 10px;">
    <button onclick="window.print()" class="btn btn-primary">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
      Print / Save as PDF
    </button>
  </div>
</div>

<!-- FORMAL DOCUMENT LETTERHEAD & BODY -->
<div class="card print-area" style="max-width: 820px; margin: 0 auto; padding: 48px; background: #ffffff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; border-radius: 8px; min-height: 900px; display: flex; flex-direction: column; justify-content: space-between;">
  <div>
    <!-- Corporate Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0f172a; padding-bottom: 20px; margin-bottom: 30px;">
      <div style="display: flex; align-items: center; gap: 16px;">
        <img src="<?= base_url('assets/images/infosof-logo.png') ?>" alt="Infosof Logo" style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid #D8BCAB; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div>
          <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">INFOSOF TECHNOLOGIES</h1>
          <p style="color: #64748b; font-size: 13px; margin: 0; line-height: 1.4;">
            People Operations &bull; Global Talent Center<br>
            Plot Y-12, Sector V, Salt Lake, Kolkata, West Bengal 700091 &bull; info@infosof.com
          </p>
        </div>
      </div>
      <div style="text-align: right;">
        <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-size: 11px; padding: 4px 8px; text-transform: uppercase;">
          Official HR Document
        </span>
        <div style="font-size: 12px; color: #64748b; margin-top: 6px;">
          Date: <strong><?= date('F d, Y') ?></strong>
        </div>
      </div>
    </div>

    <!-- Rendered Letter Body -->
    <div style="font-size: 14px; line-height: 1.8; color: #1e293b; margin-bottom: 40px;">
      <?= $renderedBody ?>
    </div>
  </div>

  <!-- Corporate Stamp & Sign-off Footer -->
  <div style="border-top: 1px solid #e2e8f0; padding-top: 24px; display: flex; justify-content: space-between; align-items: flex-end;">
    <div style="font-size: 11px; color: #94a3b8; max-width: 400px; line-height: 1.4;">
      This document has been electronically generated and validated via Infosof Technologies HRMS Cryptographic Registry.<br>
      Verification Hash: <code><?= strtoupper(substr(md5($employee['employee_code'] . date('Ymd')), 0, 16)) ?></code>
    </div>
    <div style="text-align: right;">
      <div style="width: 140px; border-bottom: 1px solid #0f172a; margin-bottom: 6px; margin-left: auto;"></div>
      <div style="font-size: 13px; font-weight: 700; color: #0f172a;">Authorized Signatory</div>
      <div style="font-size: 12px; color: #64748b;">Infosof Technologies</div>
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
