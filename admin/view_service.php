<?php
session_start();
require_once('common/config.php');
require_once('common/dbconn.php');
require_once('common/common_functions.php');
require_once('data/daManageService.php');

function viewServiceEscape($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$encServiceId = isset($_GET['id']) ? sanitize_input($_GET['id'], 'textarea') : '';
$serviceId = $encServiceId !== '' ? encrypt_decrypt($encServiceId, 'decrypt') : false;
$service = ($serviceId !== false && ctype_digit((string)$serviceId)) ? getServiceById($serviceId) : false;
if (empty($service)) {
    header('Location: service.php?msg=ERRSERVEMPTY');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Service | SS-Cars</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/service-management.css?v=font-size-20261018">
</head>
<body class="hold-transition ss-dash-page ss-service-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a href="employee.php">Employee</a><a href="customer.php">Customer</a></details>
            <details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a class="is-current" href="service.php">Service</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
            <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </nav>
        <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
    </aside>
    <main class="ss-dash-main">
        <header class="ss-dash-topbar">
            <button class="ss-icon-button ss-sidebar-toggle" type="button" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
            <label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label>
            <div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" type="button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" type="button" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div>
        </header>
        <section class="ss-dash-content ss-service-content">
            <section class="ss-service-hero ss-service-detail-hero">
                <div class="ss-service-hero-copy"><span>SERVICE MANAGEMENT</span><h1><i class="fas fa-clipboard-check"></i> Service Details</h1><p>Review vehicle service information, costs<br>and customer feedback.</p></div>
                <div class="ss-service-hero-note"><strong>QUALITY SERVICE<br>YOU CAN TRUST</strong><span>SERVICE RECORD<br>• SECURELY MANAGED</span></div>
            </section>
            <section class="ss-panel ss-service-detail-panel">
                <header class="ss-service-form-heading"><h2><i class="fas fa-tools"></i> Service Record</h2><a href="service.php"><i class="fas fa-arrow-left"></i> Back to service list</a></header>
                <div class="ss-service-form ss-service-readonly">
                    <div><label>Category Name</label><div class="ss-service-readonly-value"><?php echo viewServiceEscape($service['category_name']); ?></div></div>
                    <div><label>Model Name</label><div class="ss-service-readonly-value"><?php echo viewServiceEscape($service['model_name']); ?></div></div>
                    <div><label>Car Name</label><div class="ss-service-readonly-value"><?php echo viewServiceEscape($service['car_name']); ?></div></div>
                    <div><label>Year</label><div class="ss-service-readonly-value"><?php echo viewServiceEscape($service['year']); ?></div></div>
                    <div><label>Employee Name</label><div class="ss-service-readonly-value"><?php echo viewServiceEscape($service['employee_name']); ?></div></div>
                    <div><label>Customer Name</label><div class="ss-service-readonly-value"><?php echo viewServiceEscape($service['customer_name']); ?></div></div>
                    <div><label>Service Date</label><div class="ss-service-readonly-value"><?php echo viewServiceEscape($service['service_date']); ?></div></div>
                    <div><label>Service Cost</label><div class="ss-service-readonly-value ss-service-view-cost">₹ <?php echo viewServiceEscape($service['service_cost']); ?></div></div>
                    <div><label>Service Type</label><div class="ss-service-readonly-value"><span class="ss-service-type ss-service-type-0"><?php echo viewServiceEscape($service['service_type']); ?></span></div></div>
                    <div class="ss-service-form-wide"><label>Feedback</label><div class="ss-service-readonly-value ss-service-view-feedback"><?php echo nl2br(viewServiceEscape(isset($service['feedback']) && $service['feedback'] !== '' ? $service['feedback'] : 'No feedback provided.')); ?></div></div>
                    <div class="ss-service-form-actions"><a class="ss-service-add" href="edit_service.php?id=<?php echo rawurlencode($encServiceId); ?>"><i class="fas fa-pen"></i> Edit Service</a><a href="service.php" class="ss-service-cancel-link">Back to service list</a></div>
                </div>
            </section>
            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script>
    $(function () {
        $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
        $('#ssFullscreen').on('click', function () {
            if (document.fullscreenElement) { document.exitFullscreen(); }
            else if (document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
        });
    });
</script>
</body>
</html>
