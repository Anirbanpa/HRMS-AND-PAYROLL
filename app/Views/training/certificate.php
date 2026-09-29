<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($pageTitle) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      background: #0f172a;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      font-family: 'Plus Jakarta Sans', sans-serif;
      padding: 30px 15px;
      color: #1e293b;
    }
    .toolbar {
      width: 1000px;
      max-width: 95vw;
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .btn-action {
      background: #2563eb;
      color: #fff;
      border: none;
      padding: 10px 22px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
      transition: all 0.2s;
    }
    .btn-action:hover {
      background: #1d4ed8;
      transform: translateY(-1px);
    }
    .btn-back {
      background: rgba(255, 255, 255, 0.1);
      color: #f8fafc;
      text-decoration: none;
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 500;
      transition: all 0.2s;
    }
    .btn-back:hover {
      background: rgba(255, 255, 255, 0.18);
    }
    .certificate-card {
      width: 1000px;
      max-width: 95vw;
      background: #ffffff;
      padding: 48px 56px;
      position: relative;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      border-radius: 8px;
      overflow: hidden;
    }
    /* Luxurious Certificate Border */
    .outer-border {
      border: 3px double #d97706;
      padding: 14px;
      border-radius: 4px;
      position: relative;
    }
    .inner-border {
      border: 1.5px solid #1e293b;
      padding: 40px 48px;
      text-align: center;
      position: relative;
      background: radial-gradient(circle at center, #ffffff 65%, #f8fafc 100%);
    }
    /* Corner ornaments */
    .corner {
      position: absolute;
      width: 44px;
      height: 44px;
      border-color: #b45309;
    }
    .corner-tl { top: -2px; left: -2px; border-top: 3px solid; border-left: 3px solid; }
    .corner-tr { top: -2px; right: -2px; border-top: 3px solid; border-right: 3px solid; }
    .corner-bl { bottom: -2px; left: -2px; border-bottom: 3px solid; border-left: 3px solid; }
    .corner-br { bottom: -2px; right: -2px; border-bottom: 3px solid; border-right: 3px solid; }

    .company-title {
      font-family: 'Cinzel', serif;
      font-size: 18px;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: #64748b;
      font-weight: 700;
      margin-bottom: 4px;
    }
    .cert-heading {
      font-family: 'Cinzel', serif;
      font-size: 34px;
      font-weight: 800;
      letter-spacing: 2px;
      color: #0f172a;
      text-transform: uppercase;
      margin-bottom: 6px;
    }
    .cert-subtext {
      font-size: 13.5px;
      color: #94a3b8;
      text-transform: uppercase;
      letter-spacing: 3px;
      font-weight: 600;
      margin-bottom: 24px;
    }
    .cert-presented {
      font-family: 'Playfair Display', serif;
      font-style: italic;
      font-size: 18px;
      color: #475569;
      margin-bottom: 8px;
    }
    .recipient-name {
      font-family: 'Cinzel', serif;
      font-size: 32px;
      font-weight: 800;
      color: #1e3a8a;
      letter-spacing: 1px;
      border-bottom: 2px solid #e2e8f0;
      display: inline-block;
      padding: 0 40px 8px;
      margin-bottom: 8px;
    }
    .recipient-meta {
      font-size: 13px;
      color: #64748b;
      font-weight: 600;
      margin-bottom: 20px;
    }
    .cert-body {
      max-width: 740px;
      margin: 0 auto 28px;
      font-size: 15px;
      line-height: 1.6;
      color: #334155;
    }
    .course-highlight {
      font-weight: 700;
      color: #0f172a;
      font-size: 17px;
    }
    .badges-row {
      display: flex;
      justify-content: center;
      gap: 36px;
      margin-bottom: 36px;
    }
    .badge-pill {
      background: #f1f5f9;
      border: 1px solid #cbd5e1;
      padding: 6px 16px;
      border-radius: 9999px;
      font-size: 12.5px;
      color: #334155;
      font-weight: 600;
    }
    .signature-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      align-items: flex-end;
      margin-top: 10px;
      padding-top: 20px;
    }
    .sig-block {
      text-align: center;
    }
    .sig-line {
      width: 180px;
      height: 1px;
      background: #64748b;
      margin: 0 auto 8px;
    }
    .sig-name {
      font-weight: 700;
      font-size: 13.5px;
      color: #0f172a;
    }
    .sig-role {
      font-size: 11.5px;
      color: #64748b;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .gold-seal {
      width: 80px;
      height: 80px;
      background: radial-gradient(circle, #fde047 0%, #d97706 70%, #92400e 100%);
      border-radius: 50%;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(217, 119, 6, 0.4);
      border: 3px dashed #fff;
    }
    .cert-id-tag {
      position: absolute;
      bottom: 8px;
      right: 14px;
      font-size: 10.5px;
      color: #94a3b8;
      font-family: monospace;
    }

    @media print {
      body {
        background: #fff;
        padding: 0;
      }
      .toolbar {
        display: none;
      }
      .certificate-card {
        box-shadow: none;
        max-width: 100%;
        width: 100%;
        padding: 20px;
      }
      @page {
        size: landscape;
        margin: 10mm;
      }
    }
  </style>
</head>
<body>

  <div class="toolbar">
    <a href="<?= site_url('training') ?>" class="btn-back">
      &larr; Back to Training Hub
    </a>
    <button type="button" class="btn-action" onclick="window.print()">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
      Print Official Certificate
    </button>
  </div>

  <div class="certificate-card">
    <div class="outer-border">
      <div class="corner corner-tl"></div>
      <div class="corner corner-tr"></div>
      <div class="corner corner-bl"></div>
      <div class="corner corner-br"></div>

      <div class="inner-border">
        <div class="company-title">Enterprise HRMS &bull; Corporate Academy</div>
        <h1 class="cert-heading">Certificate of Completion</h1>
        <div class="cert-subtext">Credential of Professional Achievement</div>

        <div class="cert-presented">This certificate is proudly awarded to</div>
        <div class="recipient-name">
          <?= esc($cert['first_name'] . ' ' . $cert['last_name']) ?>
        </div>
        <div class="recipient-meta">
          Employee ID: <strong><?= esc($cert['employee_code']) ?></strong> &bull; <?= esc($cert['designation_name'] ?? 'Associate') ?> (<?= esc($cert['department_name'] ?? 'Corporate') ?>)
        </div>

        <p class="cert-body">
          for successfully fulfilling all curriculum requirements, rigorous assessments, and demonstrating active participation in the corporate training program
          <br><br>
          <span class="course-highlight">&ldquo;<?= esc($cert['course_title']) ?>&rdquo;</span>
          <br>
          <span style="font-size: 13px; color: #64748b;">(Course ID: <?= esc($cert['course_code']) ?> &bull; <?= esc($cert['category']) ?>)</span>
        </p>

        <div class="badges-row">
          <div class="badge-pill">Duration: <?= esc($cert['total_hours']) ?> Hours</div>
          <div class="badge-pill">Assessment Score: <?= esc($cert['score_rating'] ?? 95) ?>%</div>
          <div class="badge-pill">Verified: <?= date('F j, Y', strtotime($cert['completed_date'] ?? date('Y-m-d'))) ?></div>
        </div>

        <div class="signature-grid">
          <div class="sig-block">
            <div class="sig-line"></div>
            <div class="sig-name"><?= esc($cert['trainer_name'] ?? 'Program Lead') ?></div>
            <div class="sig-role">Lead Instructor / Trainer</div>
          </div>

          <div class="sig-block">
            <div class="gold-seal">
              <span style="font-size: 10px; font-weight: 900; letter-spacing: 0.5px;">OFFICIAL</span>
              <span style="font-size: 16px; font-weight: 900;">&#10003;</span>
              <span style="font-size: 9px; font-weight: 700;">VERIFIED</span>
            </div>
          </div>

          <div class="sig-block">
            <div class="sig-line"></div>
            <div class="sig-name">Director of Human Resources</div>
            <div class="sig-role">Head of People &amp; Culture</div>
          </div>
        </div>

        <div class="cert-id-tag">
          Certificate Hash: CERT-<?= strtoupper(substr(md5($cert['id'] . $cert['employee_id'] . $cert['course_code']), 0, 12)) ?>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
