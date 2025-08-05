
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>AdminLTE 4 | Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    <meta name="title" content="AdminLTE 4 | Login Page" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
    <meta
      name="keywords"
      content="bootstrap 5, admin dashboard, charts, tables, WCAG compliant" />
    <meta name="supported-color-schemes" content="light dark" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" media="print" onload="this.media='all'" />

    <!-- Plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/adminlte.css" />

  </head>
  <body class="login-page bg-body-secondary">

    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
      </div>

      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
<?php if (isset($_GET['unauthorized'])): ?>
    <div style="background: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;">
        <strong>Unauthorized Access:</strong> Please login to continue.
        <br><br>
        <a href="index.php" class="btn btn-primary">Login</a>
    </div>
<?php endif; ?>

<form action="login.php" method="POST">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="username" placeholder="Username" value="Enter User Name" required />

              <div class="input-group-text"><span class="bi bi-person-fill"></span></div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="password" placeholder="Password" required />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>

            <div class="row mb-3">
              <div class="col-8">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="rememberMe" />
                  <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
              </div>
            </div>
          </form>

          <div class="social-auth-links text-center mb-3">
            <p>- OR -</p>
            <a href="#" class="btn btn-primary mb-2">
              <i class="bi bi-facebook me-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-danger">
              <i class="bi bi-google me-2"></i> Sign in using Google
            </a>
          </div>

          <p class="mb-1"><a href="forgot-password.html">I forgot my password</a></p>
          <p class="mb-0"><a href="register.html" class="text-center">Register a new membership</a></p>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="js/adminlte.js"></script>

    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
  </body>
</html>
