<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageEmployee.php');

    if (empty($_GET['id'])) {
        header('Location: employee.php');
        exit;
    }

    $enc_employee_id = sanitize_input($_GET['id'], 'textarea');
    $employee_id = encrypt_decrypt($enc_employee_id, 'decrypt');
    $arrEmployee = getEmployeeById($employee_id);

    if (empty($arrEmployee)) {
        header('Location: employee.php?msg=ERREMPEMPTY');
        exit;
    }

    $employee_name = $arrEmployee['employee_name'];
    $address = $arrEmployee['address'];
    $phone = $arrEmployee['phone'];
    $mail_id = $arrEmployee['mail_id'];
    $position = $arrEmployee['position'];
    $hire_date = $arrEmployee['hire_date'];
    $gender = $arrEmployee['gender'];
    $age = $arrEmployee['age'];
    $dob = $arrEmployee['dob'];
    $user_name = $arrEmployee['user_name'];
    $initials = strtoupper(substr(preg_replace('/\s+/', '', $employee_name), 0, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Profile | SS-Cars</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/employee-management.css?v=font-size-20261018">
  <style>
    .ss-employee-profile-heading { min-height: 78px; display: flex; align-items: center; gap: 14px; padding: 12px 16px; border-bottom: 1px solid #173653; }
    .ss-employee-profile-avatar { width: 48px; height: 48px; flex-basis: 48px; font-size: 19px; }
    .ss-employee-profile-title { min-width: 0; }
    .ss-employee-profile-title h2 { margin: 0; color: #e4eefb; font-size: 21px; font-weight: 600; }
    .ss-employee-profile-title span { display: inline-block; margin-top: 5px; padding: 3px 9px; border: 1px solid #087bb5; border-radius: 12px; background: #062e4e; color: #97ddff; font-size: 13px; }
    .ss-employee-profile-actions { margin-left: auto; display: flex; align-items: center; gap: 9px; }
    @media (max-width: 480px) { .ss-employee-profile-heading { flex-wrap: wrap; } .ss-employee-profile-actions { width: 100%; margin-left: 62px; } }
  </style>
</head>
<body class="hold-transition ss-dash-page ss-employee-page">
<div class="ss-dash-layout">
  <aside class="ss-dash-sidebar">
    <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
    <nav class="ss-dash-nav" aria-label="Main navigation">
      <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
      <details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a class="is-current" href="employee.php">Employee</a><a href="customer.php">Customer</a></details>
      <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details>
      <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
      <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </nav>
    <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
  </aside>

  <main class="ss-dash-main">
    <header class="ss-dash-topbar">
      <button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
      <label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label>
      <div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div>
    </header>

    <section class="ss-dash-content ss-employee-content">
      <section class="ss-employee-hero"><div class="ss-employee-hero-copy"><span>INVENTORY MANAGEMENT</span><h1><i class="fas fa-users"></i> Employee Management</h1><p>Review contact, role, and team details for this employee.</p></div></section>
      <section class="ss-panel ss-employee-panel">
        <header class="ss-employee-profile-heading">
          <span class="ss-employee-avatar ss-employee-profile-avatar"><?php echo htmlspecialchars($initials, ENT_QUOTES, 'UTF-8'); ?></span>
          <div class="ss-employee-profile-title"><h2><?php echo htmlspecialchars($employee_name, ENT_QUOTES, 'UTF-8'); ?></h2><span><?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?></span></div>
          <div class="ss-employee-profile-actions"><a class="ss-employee-action" href="edit_employee.php?id=<?php echo rawurlencode($enc_employee_id); ?>" title="Edit employee"><i class="fas fa-pen"></i></a><a class="ss-employee-back" href="employee.php"><i class="fas fa-arrow-left"></i> Employee List</a></div>
        </header>
        <div class="ss-employee-detail-grid">
          <div class="ss-employee-detail"><span>Email</span><strong><?php echo htmlspecialchars($mail_id, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-employee-detail"><span>Phone</span><strong><?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-employee-detail"><span>User Name</span><strong><?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-employee-detail"><span>Hire Date</span><strong><?php echo htmlspecialchars($hire_date, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-employee-detail"><span>Date of Birth</span><strong><?php echo htmlspecialchars($dob, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-employee-detail"><span>Age / Gender</span><strong><?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?> / <?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-employee-detail is-wide"><span>Address</span><strong><?php echo htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?></strong></div>
        </div>
      </section>
      <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
    </section>
  </main>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
    $('#ssFullscreen').on('click', function () {
      if (!document.fullscreenElement && document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
      else if (document.exitFullscreen) { document.exitFullscreen(); }
    });
  });
</script>
</body>
</html>
