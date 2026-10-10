<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');

  unset($_SESSION['sidesubparentmenu']);
  unset($_SESSION['sidechildmenu']);

  // Retrieve message from query string or session
  $msg = isset($_GET['msg']) ? $_GET['msg'] : (isset($_SESSION['msg']) ? $_SESSION['msg'] : '');
  
  // Clear the session variable after retrieving it
  if(isset($_SESSION['msg'])) {
      unset($_SESSION['msg']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <!-- Include stylesheets -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/main.css">
  <link rel="stylesheet" href="dist/css/dashboard.css">
</head>
<body class="hold-transition ss-dash-page">
<div class="ss-dash-layout">
  <aside class="ss-dash-sidebar">
    <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
    <nav class="ss-dash-nav" aria-label="Main navigation">
      <a class="ss-nav-link is-active" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
      <details class="ss-nav-group">
        <summary class="ss-nav-link"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
        <a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Cars</a><a href="employee.php">Employees</a><a href="customer.php">Customers</a>
      </details>
      <details class="ss-nav-group">
        <summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
        <a href="enquiry.php">Enquiries</a><a href="sales.php">Sales</a><a href="service.php">Service</a>
      </details>
      <details class="ss-nav-group">
        <summary class="ss-nav-link"><i class="fas fa-folder-open"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
        <a href="revenue_report.php">Revenue Report</a>
      </details>
      <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </nav>
    <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
  </aside>

  <main class="ss-dash-main">
    <header class="ss-dash-topbar">
      <button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
      <label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label>
      <div class="ss-topbar-actions">
        <button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button>
        <button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button>
        <div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div>
      </div>
    </header>

    <section class="ss-dash-content">
      <?php if ($msg != ''): ?>
        <div class="alert alert-dismissible ss-dash-alert alert-<?php echo substr($msg, 0, 3) == 'SUC' ? 'success' : (substr($msg, 0, 3) == 'ERR' ? 'danger' : 'info'); ?>">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
          <?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?>
        </div>
      <?php endif; ?>

      <section class="ss-welcome-hero">
        <div class="ss-welcome-copy"><span>WELCOME BACK,</span><h1>Superadmin <i class="fas fa-crown"></i></h1><p>Manage cars, customers and transactions<br>all in one place.</p><i class="ss-gold-rule"></i></div>
      </section>

      <section class="ss-stat-grid" aria-label="Business overview">
        <article class="ss-stat-card stat-blue"><div class="ss-stat-icon"><i class="fas fa-car"></i></div><div><span>Total Cars</span><strong>3,272</strong><small><b>↑ 12%</b><br>vs last month</small></div><i class="fas fa-car-side ss-stat-watermark"></i></article>
        <article class="ss-stat-card stat-cyan"><div class="ss-stat-icon"><i class="fas fa-user"></i></div><div><span>New Customers</span><strong>461</strong><small><b>↑ 25%</b><br>vs last month</small></div><i class="fas fa-users ss-stat-watermark"></i></article>
        <article class="ss-stat-card stat-green"><div class="ss-stat-icon"><i class="fas fa-clipboard-list"></i></div><div><span>Total Enquiries</span><strong>1,598</strong><small><b>↑ 18%</b><br>vs last month</small></div><i class="far fa-clipboard ss-stat-watermark"></i></article>
        <article class="ss-stat-card stat-gold"><div class="ss-stat-icon"><i class="fas fa-chart-line"></i></div><div><span>Total Sales</span><strong>349</strong><small><b>↑ 14%</b><br>vs last month</small></div><i class="fas fa-chart-bar ss-stat-watermark"></i></article>
      </section>

      <section class="ss-dashboard-grid ss-dashboard-grid-primary">
        <article class="ss-panel ss-sales-panel">
          <header class="ss-panel-heading"><h2>Monthly Sales Overview</h2><button class="ss-period-button">This Month <i class="fas fa-chevron-down"></i></button></header>
          <div class="ss-sales-body"><div class="ss-sales-chart"><canvas id="salesChart" aria-label="Monthly sales chart"></canvas></div><div class="ss-chart-legend"><div><i class="fas fa-chart-line"></i><span>Total Sales<strong>349</strong></span><b>↑ 14%</b></div><div><i class="fas fa-clipboard-list"></i><span>Total Enquiries<strong>1,598</strong></span><b>↑ 18%</b></div><div><i class="fas fa-user-friends"></i><span>Total Customers<strong>461</strong></span><b>↑ 12%</b></div></div></div>
        </article>
        <article class="ss-panel ss-activity-panel">
          <header class="ss-panel-heading"><h2><i class="fas fa-history"></i> Recent Activities</h2><a href="enquiry.php">View All <i class="fas fa-arrow-right"></i></a></header>
          <div class="ss-activity-list">
            <div><i class="fas fa-car"></i><span>New Enquiry - BMW M4<small>2 hours ago</small></span></div>
            <div><i class="fas fa-check"></i><span>Sale Completed - Tata Sierra<small>4 hours ago</small></span></div>
            <div><i class="fas fa-user-plus"></i><span>New Customer Registered<small>5 hours ago</small></span></div>
            <div><i class="fas fa-wrench"></i><span>Service Request - Range Rover<small>6 hours ago</small></span></div>
          </div>
        </article>
        <article class="ss-panel ss-quick-panel">
          <header class="ss-panel-heading"><h2><i class="fas fa-bolt"></i> Quick Actions</h2></header>
          <div class="ss-quick-links"><a href="cars.php"><i class="fas fa-car"></i><span>Add New Car</span><i class="fas fa-chevron-right"></i></a><a href="customer.php"><i class="fas fa-user"></i><span>Add Customer</span><i class="fas fa-chevron-right"></i></a><a href="enquiry.php"><i class="fas fa-clipboard-list"></i><span>Add Enquiry</span><i class="fas fa-chevron-right"></i></a><a href="revenue_report.php"><i class="fas fa-chart-bar"></i><span>View Reports</span><i class="fas fa-chevron-right"></i></a></div>
        </article>
      </section>

      <section class="ss-dashboard-grid ss-dashboard-grid-secondary">
        <article class="ss-panel ss-models-panel">
          <header class="ss-panel-heading"><h2>Top Selling Models</h2></header>
          <div class="ss-model-grid">
            <a href="models.php" class="ss-model-card"><img src="images/dashboard-car-front.jpg" alt="BMW M4"><span>BMW M4<small>78 sales</small></span></a>
            <a href="models.php" class="ss-model-card"><img src="images/dashboard-car-city.jpg" alt="Tata Sierra"><span>Tata Sierra<small>64 sales</small></span></a>
            <a href="models.php" class="ss-model-card"><img src="images/dashboard-car-rear.jpg" alt="Range Rover"><span>Range Rover<small>52 sales</small></span></a>
            <a href="models.php" class="ss-model-card"><img src="images/dashboard-car-front.jpg" alt="Audi Q7"><span>Audi Q7<small>41 sales</small></span></a>
            <a href="models.php" class="ss-model-card"><img src="images/dashboard-car-city.jpg" alt="Mercedes GLE"><span>Mercedes GLE<small>38 sales</small></span></a>
          </div>
        </article>
        <article class="ss-panel ss-revenue-panel">
          <header class="ss-panel-heading"><h2><i class="fas fa-coins"></i> Revenue Overview</h2></header>
          <div class="ss-revenue-total"><strong>₹ 8,40,00,000</strong><span><b>↑ 18%</b><small>vs last month</small></span></div>
          <div class="ss-revenue-chart"><canvas id="revenueChart" aria-label="Monthly revenue chart"></canvas></div>
        </article>
        <article class="ss-panel ss-enquiries-panel">
          <header class="ss-panel-heading"><h2>Top Enquiries</h2><a href="enquiry.php">View All <i class="fas fa-arrow-right"></i></a></header>
          <div class="ss-enquiry-list">
            <a href="enquiry.php"><img src="images/dashboard-car-front.jpg" alt=""><span>BMW M4<small>245 enquiries</small></span><i class="fas fa-chevron-right"></i></a>
            <a href="enquiry.php"><img src="images/dashboard-car-city.jpg" alt=""><span>Tata Sierra<small>198 enquiries</small></span><i class="fas fa-chevron-right"></i></a>
            <a href="enquiry.php"><img src="images/dashboard-car-rear.jpg" alt=""><span>Range Rover<small>142 enquiries</small></span><i class="fas fa-chevron-right"></i></a>
            <a href="enquiry.php"><img src="images/dashboard-car-city.jpg" alt=""><span>Mercedes GLE<small>121 enquiries</small></span><i class="fas fa-chevron-right"></i></a>
          </div>
        </article>
      </section>
      <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
    </section>
  </main>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/chart.js/Chart.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
    $('#ssFullscreen').on('click', function () {
      if (!document.fullscreenElement) { document.documentElement.requestFullscreen(); }
      else if (document.exitFullscreen) { document.exitFullscreen(); }
    });
    var chartText = '#8b9eb7';
    var chartGrid = 'rgba(77, 113, 152, .16)';
    new Chart(document.getElementById('salesChart'), {
      type: 'line',
      data: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], datasets: [{ data: [14, 31, 38, 35, 48, 41, 53, 63, 58, 71, 82, 89], borderColor: '#08a9ff', backgroundColor: 'rgba(0, 142, 255, .16)', pointBackgroundColor: '#00d4ff', pointRadius: 2, borderWidth: 2, fill: true, tension: .38 }] },
      options: { maintainAspectRatio: false, legend: { display: false }, tooltips: { enabled: true }, scales: { yAxes: [{ ticks: { beginAtZero: true, max: 100, stepSize: 20, fontColor: chartText }, gridLines: { color: chartGrid } }], xAxes: [{ ticks: { fontColor: chartText }, gridLines: { color: chartGrid } }] } }
    });
    new Chart(document.getElementById('revenueChart'), {
      type: 'bar',
      data: { labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], datasets: [{ data: [24, 35, 31, 45, 53, 48, 62, 47, 60, 72, 82, 78], backgroundColor: ['#078cff', '#078cff', '#078cff', '#078cff', '#078cff', '#078cff', '#078cff', '#078cff', '#078cff', '#078cff', '#078cff', '#078cff'], borderRadius: 4, maxBarThickness: 12 }] },
      options: { maintainAspectRatio: false, legend: { display: false }, tooltips: { enabled: true }, scales: { yAxes: [{ ticks: { beginAtZero: true, max: 100, stepSize: 20, fontColor: chartText }, gridLines: { display: false } }], xAxes: [{ ticks: { fontColor: chartText }, gridLines: { display: false } }] } }
    });
  });
</script>
</body>
</html>
