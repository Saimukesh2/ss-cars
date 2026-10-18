<?php
    session_start();
    require_once('common/config.php');
    require_once('common/dbconn.php');
    require_once('common/common_functions.php');
    require_once('data/daManageCustomer.php');

    if (empty($_GET['id'])) {
        header('Location: customer.php');
        exit;
    }

    $enc_customer_id = sanitize_input($_GET['id'], 'textarea');
    $customer_id = encrypt_decrypt($enc_customer_id, 'decrypt');
    $customer = getCustomerById($customer_id);
    if (empty($customer)) {
        header('Location: customer.php?msg=ERRCUSTEMPTY');
        exit;
    }

    $customer_name = $customer['customer_name'];
    $address = $customer['address'];
    $phone = $customer['phone'];
    $mail_id = $customer['mail_id'];
    $gender = $customer['gender'];
    $age = $customer['age'];
    $dob = $customer['dob'];
    $city = $customer['city'];
    $state = $customer['state'];
    $initials = strtoupper(substr(preg_replace('/\s+/', '', $customer_name), 0, 2));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Customer Profile | SS-Cars</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/customer-management.css?v=font-size-20261018">
  <style>
    .ss-customer-profile-avatar { width: 48px; height: 48px; flex-basis: 48px; font-size: 19px; }
    @media (max-width: 480px) { .ss-customer-profile-heading { flex-wrap: wrap; } .ss-customer-profile-actions { width: 100%; margin-left: 62px; } }
  </style>
</head>
<body class="hold-transition ss-dash-page ss-customer-page">
<div class="ss-dash-layout">
  <aside class="ss-dash-sidebar">
    <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
    <nav class="ss-dash-nav" aria-label="Main navigation">
      <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
      <details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a href="employee.php">Employee</a><a class="is-current" href="customer.php">Customer</a></details>
      <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details>
      <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
      <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </nav>
    <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
  </aside>
  <main class="ss-dash-main">
    <header class="ss-dash-topbar"><button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button><label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label><div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div></header>
    <section class="ss-dash-content ss-customer-content">
      <section class="ss-customer-hero"><div class="ss-customer-hero-copy"><span>CUSTOMER MANAGEMENT</span><h1><i class="fas fa-users"></i> Customer Profile</h1><p>Review contact and location details for this customer.</p></div></section>
      <section class="ss-panel ss-customer-panel">
        <header class="ss-customer-profile-heading"><span class="ss-customer-avatar ss-customer-profile-avatar"><?php echo htmlspecialchars($initials, ENT_QUOTES, 'UTF-8'); ?></span><div class="ss-customer-profile-title"><h2><?php echo htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'); ?></h2><span><?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($state, ENT_QUOTES, 'UTF-8'); ?></span></div><div class="ss-customer-profile-actions"><a class="ss-customer-action" href="edit_customer.php?id=<?php echo rawurlencode($enc_customer_id); ?>" title="Edit customer"><i class="fas fa-pen"></i></a><a class="ss-customer-back" href="customer.php"><i class="fas fa-arrow-left"></i> Customer List</a></div></header>
        <div class="ss-customer-detail-grid">
          <div class="ss-customer-detail"><span>Email</span><strong><?php echo htmlspecialchars($mail_id, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-customer-detail"><span>Phone</span><strong><?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-customer-detail"><span>Gender</span><strong><?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-customer-detail"><span>Age</span><strong><?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-customer-detail"><span>Date of Birth</span><strong><?php echo htmlspecialchars($dob, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-customer-detail"><span>City</span><strong><?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?></strong></div>
          <div class="ss-customer-detail"><span>State</span><strong><?php echo htmlspecialchars($state, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-customer-detail is-wide"><span>Address</span><strong><?php echo htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?></strong></div>
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
