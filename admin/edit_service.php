<?php
session_start();
require_once('common/config.php');
require_once('common/dbconn.php');
require_once('common/common_functions.php');
require_once('data/daManageService.php');

function editServiceEscape($value)
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

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Service | SS-Cars</title>
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
            <?php if ($msg !== '') { ?><div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg, 0, 3) === 'SUC' ? 'alert-success' : 'alert-warning'; ?>"><button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo editServiceEscape(getMessage($msg)); ?></div><?php } ?>
            <section class="ss-service-hero ss-service-detail-hero">
                <div class="ss-service-hero-copy"><span>SERVICE MANAGEMENT</span><h1><i class="fas fa-pen"></i> Edit Service</h1><p>Update service details and keep the customer<br>record accurate and up to date.</p></div>
                <div class="ss-service-hero-note"><strong>QUALITY SERVICE<br>YOU CAN TRUST</strong><span>SERVICE RECORD<br>• SECURELY MANAGED</span></div>
            </section>
            <section class="ss-panel ss-service-detail-panel">
                <header class="ss-service-form-heading"><h2><i class="fas fa-clipboard-list"></i> Service Details</h2><a href="service.php"><i class="fas fa-arrow-left"></i> Back to service list</a></header>
                <form id="editServiceForm" method="post" action="edit_service_validate.php" class="ss-service-form">
                    <div><label for="categoryDisplay">Category Name</label><input id="categoryDisplay" type="text" value="<?php echo editServiceEscape($service['category_name']); ?>" readonly><input type="hidden" name="categoryName" value="<?php echo editServiceEscape($service['category_id']); ?>"></div>
                    <div><label for="modelDisplay">Model Name</label><input id="modelDisplay" type="text" value="<?php echo editServiceEscape($service['model_name']); ?>" readonly><input type="hidden" name="modelName" value="<?php echo editServiceEscape($service['model_id']); ?>"></div>
                    <div><label for="carDisplay">Car Name</label><input id="carDisplay" type="text" value="<?php echo editServiceEscape($service['car_name']); ?>" readonly><input type="hidden" name="carName" value="<?php echo editServiceEscape($service['car_id']); ?>"></div>
                    <div><label for="yearDisplay">Year</label><input id="yearDisplay" type="text" value="<?php echo editServiceEscape($service['year']); ?>" readonly><input type="hidden" name="year" value="<?php echo editServiceEscape($service['year']); ?>"></div>
                    <div><label for="employeeDisplay">Employee Name</label><input id="employeeDisplay" type="text" value="<?php echo editServiceEscape($service['employee_name']); ?>" readonly><input type="hidden" name="employeeName" value="<?php echo editServiceEscape($service['employee_id']); ?>"></div>
                    <div><label for="customerDisplay">Customer Name</label><input id="customerDisplay" type="text" value="<?php echo editServiceEscape($service['customer_name']); ?>" readonly><input type="hidden" name="customerName" value="<?php echo editServiceEscape($service['customer_id']); ?>"></div>
                    <div><label for="servicedate">Service Date</label><input type="date" id="servicedate" name="servicedate" value="<?php echo editServiceEscape($service['service_date']); ?>" required></div>
                    <div><label for="servicecost">Service Cost</label><input type="text" id="servicecost" name="servicecost" value="<?php echo editServiceEscape($service['service_cost']); ?>" placeholder="Enter service cost" required></div>
                    <div><label for="servicetype">Service Type</label><input type="text" id="servicetype" name="servicetype" value="<?php echo editServiceEscape($service['service_type']); ?>" placeholder="Enter service type" required></div>
                    <div class="ss-service-form-wide"><label for="feedback">Feedback</label><textarea id="feedback" name="feedback" rows="3" placeholder="Add service feedback"><?php echo editServiceEscape($service['feedback']); ?></textarea></div>
                    <input type="hidden" name="hdnServiceID" value="<?php echo editServiceEscape($encServiceId); ?>">
                    <div class="ss-service-form-actions"><button type="submit" class="ss-service-add"><i class="fas fa-save"></i> Save Changes</button><a href="view_service.php?id=<?php echo rawurlencode($encServiceId); ?>" class="ss-service-cancel-link">View service</a><a href="service.php" class="ss-service-cancel-link">Cancel</a></div>
                </form>
            </section>
            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script>
    $(function () {
        $.validator.addMethod('noBlank', function (value, element) {
            return this.optional(element) || $.trim(value).length > 0;
        }, 'This field cannot be blank or filled with only spaces.');
        $('#editServiceForm').validate({
            rules: {
                servicedate: { required: true },
                servicecost: { required: true, noBlank: true },
                servicetype: { required: true, minlength: 3, noBlank: true }
            },
            errorElement: 'span',
            errorClass: 'error',
            errorPlacement: function (error, element) { error.insertAfter(element); },
            highlight: function (element) { $(element).addClass('is-invalid'); },
            unhighlight: function (element) { $(element).removeClass('is-invalid'); }
        });
        $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
        $('#ssFullscreen').on('click', function () {
            if (document.fullscreenElement) { document.exitFullscreen(); }
            else if (document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
        });
    });
</script>
</body>
</html>
