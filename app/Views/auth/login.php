<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enterprise HRMS & Payroll | Sign In</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/hrms.css') ?>">
  <meta name="color-scheme" content="light dark">
  <script>
    (function() {
      try {
        const savedTheme = localStorage.getItem('hrms-theme');
        const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const theme = savedTheme ? savedTheme : (systemPrefersDark ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
      } catch (e) {}
    })();
  </script>
  <style>
    body {
      background: radial-gradient(circle at 50% 10%, #4A3E3B 0%, #38302E 50%, #201B1A 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      color: #F7F3EE;
    }
    .login-container {
      width: 100%;
      max-width: 460px;
    }
    .login-brand {
      text-align: center;
      margin-bottom: 28px;
    }
    .brand-logo-large {
      width: 56px;
      height: 56px;
      background: linear-gradient(135deg, #8C7AA9 0%, #6E5C8C 100%);
      border-radius: 16px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      font-weight: 800;
      color: #fff;
      box-shadow: 0 10px 25px -5px rgba(140, 122, 169, 0.5);
      margin-bottom: 14px;
      border: 1px solid rgba(216, 188, 171, 0.3);
    }
    .login-brand h1 {
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: #ffffff;
    }
    .login-brand p {
      font-size: 13.5px;
      color: #D8BCAB;
      margin-top: 4px;
    }
    .login-card {
      background: rgba(46, 38, 37, 0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(216, 188, 171, 0.2);
      border-radius: 20px;
      padding: 32px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
    }
    .login-card .form-label {
      color: #D8BCAB;
    }
    .login-card .form-control {
      background: rgba(33, 27, 26, 0.8);
      border-color: rgba(216, 188, 171, 0.25);
      color: #fff;
    }
    .login-card .form-control:focus {
      border-color: #8C7AA9;
      background: rgba(33, 27, 26, 1);
      box-shadow: 0 0 0 3px rgba(140, 122, 169, 0.25);
    }
    .demo-tier-box {
      margin-top: 24px;
      padding-top: 20px;
      border-top: 1px solid rgba(216, 188, 171, 0.15);
    }
    .demo-tier-box h4 {
      font-size: 11.5px;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #D8BCAB;
      margin-bottom: 12px;
      font-weight: 700;
      text-align: center;
    }
    .demo-role-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }
    .demo-btn {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 9px 12px;
      background: rgba(56, 48, 46, 0.6);
      border: 1px solid rgba(216, 188, 171, 0.18);
      border-radius: 8px;
      color: #F7F3EE;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    .demo-btn:hover {
      background: rgba(140, 122, 169, 0.25);
      border-color: #8C7AA9;
      color: #fff;
      transform: translateY(-1px);
    }
    .demo-btn span {
      font-size: 10px;
      font-weight: 400;
      color: #D8BCAB;
    }
    .security-notice {
      margin-top: 20px;
      text-align: center;
      font-size: 11.5px;
      color: #B8A597;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }
    #btnSignIn {
      background: linear-gradient(135deg, #8C7AA9 0%, #6E5C8C 100%);
      border: none;
      box-shadow: 0 4px 14px rgba(140, 122, 169, 0.4);
    }
    #btnSignIn:hover {
      background: linear-gradient(135deg, #786695 0%, #5E4C7A 100%);
    }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-brand">
    <div class="brand-logo-large" style="background: transparent; box-shadow: none; border: none; width: 68px; height: 68px;">
      <img src="<?= base_url('assets/images/infosof-logo.png') ?>" alt="Infosof Logo" style="width: 68px; height: 68px; border-radius: 50%; object-fit: cover; border: 3px solid var(--color-beige); box-shadow: 0 4px 16px rgba(0,0,0,0.3);">
    </div>
    <h1>Infosof HRMS &amp; Payroll</h1>
    <p>Enterprise Workforce &amp; Human Capital Suite</p>
  </div>

  <div class="login-card">
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.15); border-color: rgba(239, 68, 68, 0.3); color: #fca5a5;">
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.15); border-color: rgba(16, 185, 129, 0.3); color: #6ee7b7;">
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="POST" id="loginForm">
      <?= csrf_field() ?>
      <div class="form-group">
        <label class="form-label" for="identifier">Username or Corporate Email</label>
        <input type="text" name="identifier" id="identifier" class="form-control" placeholder="e.g. demo.superadmin or demo.superadmin@infosof.com" required value="<?= old('identifier') ?>">
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter secure password" required>
      </div>

      <button type="submit" id="btnSignIn" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 14px; margin-top: 8px;">
        Sign In to Enterprise Workspace
      </button>
    </form>

    <!-- 1-Click Interactive Demo Role Switcher -->
    <div class="demo-tier-box">
      <h4>Instant Demo Access</h4>
      <div class="demo-role-grid">
        <a href="<?= site_url('auth/demo/super_admin') ?>" id="demoSuperAdmin" class="demo-btn" style="border-color: rgba(192, 132, 252, 0.4); background: rgba(140, 122, 169, 0.18);">
           Super Admin
          <span>Root Authority  </span>
        </a>
        <a href="<?= site_url('auth/demo/hr_admin') ?>" id="demoHrAdmin" class="demo-btn" style="border-color: rgba(56, 189, 248, 0.3);">
           HR Admin
          <span>HR Suite  </span>
        </a>
        <a href="<?= site_url('auth/demo/hr_executive') ?>" id="demoHrExec" class="demo-btn" style="border-color: rgba(52, 211, 153, 0.3);">
              HR Executive
          <span>HR Operations  </span>
        </a>
        <a href="<?= site_url('auth/demo/payroll_manager') ?>" id="demoPayroll" class="demo-btn" style="border-color: rgba(251, 191, 36, 0.3);">
           Payroll Manager
          <span>Payroll &amp; Salary Engine </span>
        </a>
        <a href="<?= site_url('auth/demo/accountant') ?>" id="demoAccountant" class="demo-btn" style="border-color: rgba(244, 114, 182, 0.3);">
           Accountant
          <span>Finance &amp; Audit  </span>
        </a>
        <a href="<?= site_url('auth/demo/manager') ?>" id="demoManager" class="demo-btn" style="border-color: rgba(251, 146, 60, 0.3);">
             Manager
          <span>MSS &amp; Dept Approvals </span>
        </a>
      </div>
      <div style="margin-top: 8px;">
        <a href="<?= site_url('auth/demo/employee') ?>" id="demoEmployee" class="demo-btn" style="width: 100%; text-align: center; align-items: center; border-color: rgba(216, 188, 171, 0.3);">
           Employee (ESS)
          <span>Individual Self-Service &bull; Clock-in &bull; Leaves &bull; Payslips</span>
        </a>
      </div>
    </div>

    <div class="security-notice">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      <span>Bcrypt Protected &bull; CSRF Active &bull; Default password: <strong>Admin@123</strong></span>
    </div>
  </div>
</div>

</body>
</html>
