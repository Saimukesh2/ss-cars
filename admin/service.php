<?php
session_start();
require_once('common/config.php');
require_once('common/dbconn.php');
require_once('common/common_functions.php');
require_once('data/daManageCar.php');
require_once('data/daManageService.php');
require_once('data/daManageEmployee.php');
require_once('data/daManageCustomer.php');

function serviceEscape($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function serviceFormatIndianCurrency($amount)
{
    $wholeAmount = number_format((float)$amount, 0, '.', '');
    if (strlen($wholeAmount) > 3) {
        $lastThreeDigits = substr($wholeAmount, -3);
        $remainingDigits = substr($wholeAmount, 0, -3);
        $wholeAmount = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remainingDigits) . ',' . $lastThreeDigits;
    }
    return $wholeAmount;
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$arrProdCat = getAllActiveCategory();
$arrModels = getAllActiveModels();
$arrCars = getAllActiveCars();
$arrEmployee = getAllActiveEmployeeById();
$arrCustomer = getAllActiveCustomerById();
$arrService = getAllService();

$serviceTypeOptions = array();
$servedCustomerOptions = array();
$totalServiceCost = 0;
foreach ($arrService as $service) {
    $serviceType = trim((string)$service['service_type']);
    if ($serviceType !== '') {
        $serviceTypeOptions[$serviceType] = $serviceType;
    }
    $customerId = (string)$service['customer_id'];
    if ($customerId !== '') {
        $servedCustomerOptions[$customerId] = $customerId;
    }
    $totalServiceCost += (float)preg_replace('/[^0-9.\-]/', '', (string)$service['service_cost']);
}
ksort($serviceTypeOptions, SORT_NATURAL | SORT_FLAG_CASE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Management | SS-Cars</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
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
            <details class="ss-nav-group">
                <summary class="ss-nav-link"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a href="employee.php">Employee</a><a href="customer.php">Customer</a>
            </details>
            <details class="ss-nav-group" open>
                <summary class="ss-nav-link is-active"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a class="is-current" href="service.php">Service</a>
            </details>
            <details class="ss-nav-group">
                <summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="revenue_report.php">Revenue Report</a>
            </details>
            <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </nav>
        <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
    </aside>
    <main class="ss-dash-main">
        <header class="ss-dash-topbar">
            <button class="ss-icon-button ss-sidebar-toggle" type="button" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
            <label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label>
            <div class="ss-topbar-actions">
                <button class="ss-icon-button ss-notice-button" type="button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button>
                <button class="ss-icon-button" id="ssFullscreen" type="button" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button>
                <div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div>
            </div>
        </header>
        <section class="ss-dash-content ss-service-content">
            <?php if ($msg !== '') { ?>
                <div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg, 0, 3) === 'SUC' ? 'alert-success' : 'alert-warning'; ?>">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo serviceEscape(getMessage($msg)); ?>
                </div>
            <?php } ?>

            <section class="ss-service-hero">
                <div class="ss-service-hero-copy">
                    <span>SERVICE MANAGEMENT</span>
                    <h1><i class="fas fa-tools"></i> Service List</h1>
                    <p>Manage your car services, track service details,<br>costs and maintain smooth operations.</p>
                </div>
                <div class="ss-service-hero-note"><strong>KEEP YOUR CAR<br>IN TOP CONDITION</strong><span>QUALITY SERVICE<br>• TRUSTED CARE</span></div>
            </section>

            <section class="ss-service-stat-grid" aria-label="Service overview">
                <article class="ss-service-stat-card stat-blue"><span class="ss-service-stat-icon"><i class="fas fa-cogs"></i></span><div><span>Total Services</span><strong><?php echo count($arrService); ?></strong><small>Service records</small></div><i class="fas fa-clipboard-list ss-service-stat-watermark"></i></article>
                <article class="ss-service-stat-card stat-cyan"><span class="ss-service-stat-icon"><i class="fas fa-wrench"></i></span><div><span>Service Types</span><strong><?php echo count($serviceTypeOptions); ?></strong><small>Types recorded</small></div><i class="fas fa-tools ss-service-stat-watermark"></i></article>
                <article class="ss-service-stat-card stat-green"><span class="ss-service-stat-icon"><i class="fas fa-users"></i></span><div><span>Customers Served</span><strong><?php echo count($servedCustomerOptions); ?></strong><small>Unique customers</small></div><i class="fas fa-user-check ss-service-stat-watermark"></i></article>
                <article class="ss-service-stat-card stat-gold"><span class="ss-service-stat-icon"><i class="fas fa-rupee-sign"></i></span><div><span>Total Service Cost</span><strong class="ss-service-total-cost">₹ <?php echo serviceFormatIndianCurrency($totalServiceCost); ?></strong><small>Across all service records</small></div><i class="fas fa-coins ss-service-stat-watermark"></i></article>
            </section>

            <section class="ss-panel ss-service-panel">
                <header class="ss-panel-heading ss-service-panel-heading">
                    <div class="ss-service-heading-title"><h2><i class="fas fa-tools"></i> Service List</h2></div>
                    <div class="ss-service-tools">
                        <label class="ss-service-search"><i class="fas fa-search"></i><input id="serviceSearch" type="search" placeholder="Search service..." aria-label="Search service"></label>
                        <button type="button" class="ss-service-filter" id="serviceFilterToggle" aria-label="Filter by service type" aria-expanded="false"><i class="fas fa-filter"></i></button>
                        <select class="ss-service-filter-select" id="serviceTypeFilter" aria-label="Filter by service type" hidden>
                            <option value="">All service types</option>
                            <?php foreach ($serviceTypeOptions as $serviceType) { ?><option value="<?php echo serviceEscape($serviceType); ?>"><?php echo serviceEscape($serviceType); ?></option><?php } ?>
                        </select>
                        <a class="ss-service-add" href="#addServ" data-toggle="tab"><i class="fas fa-plus"></i> Add Service</a>
                    </div>
                </header>
                <div class="ss-service-tabs">
                    <div class="tab-content">
                        <div class="tab-pane" id="addServ">
                            <div class="ss-service-form-heading"><h2><i class="fas fa-plus-circle"></i> Add Service</h2><a href="#listServ" data-toggle="tab"><i class="fas fa-arrow-left"></i> Back to service list</a></div>
                            <form id="addForm" method="post" action="service_validate.php" class="ss-service-form">
                                <div><label for="categoryName">Category Name</label><select id="categoryName" name="categoryName" required><option value="">Select category</option><?php foreach ($arrProdCat as $category) { ?><option value="<?php echo serviceEscape($category['category_id']); ?>"><?php echo serviceEscape($category['category_name']); ?></option><?php } ?></select></div>
                                <div><label for="modelName">Model Name</label><select id="modelName" name="modelName" required><option value="">Select model</option><?php foreach ($arrModels as $model) { ?><option value="<?php echo serviceEscape($model['model_id']); ?>"><?php echo serviceEscape($model['model_name']); ?></option><?php } ?></select></div>
                                <div><label for="carName">Car Name</label><select id="carName" name="carName" required><option value="">Select car</option><?php foreach ($arrCars as $car) { ?><option value="<?php echo serviceEscape($car['car_id']); ?>"><?php echo serviceEscape($car['car_name']); ?></option><?php } ?></select></div>
                                <div><label for="year">Year</label><input type="text" id="year" name="year" required placeholder="Enter year"></div>
                                <div><label for="employeeName">Employee Name</label><select id="employeeName" name="employeeName" required><option value="">Select employee</option><?php foreach ($arrEmployee as $employee) { ?><option value="<?php echo serviceEscape($employee['employee_id']); ?>"><?php echo serviceEscape($employee['employee_name']); ?></option><?php } ?></select></div>
                                <div><label for="customerName">Customer Name</label><select id="customerName" name="customerName" required><option value="">Select customer</option><?php foreach ($arrCustomer as $customer) { ?><option value="<?php echo serviceEscape($customer['customer_id']); ?>"><?php echo serviceEscape($customer['customer_name']); ?></option><?php } ?></select></div>
                                <div><label for="servicedate">Service Date</label><input type="date" id="servicedate" name="servicedate" required></div>
                                <div><label for="servicecost">Service Cost</label><input type="text" id="servicecost" name="servicecost" required placeholder="Enter service cost"></div>
                                <div><label for="servicetype">Service Type</label><input type="text" id="servicetype" name="servicetype" required placeholder="e.g. General service"></div>
                                <div class="ss-service-form-wide"><label for="feedback">Feedback</label><textarea id="feedback" name="feedback" rows="3" placeholder="Add service feedback (optional)"></textarea></div>
                                <div class="ss-service-form-actions"><button type="submit" class="ss-service-add"><i class="fas fa-save"></i> Save Service</button><a href="#listServ" data-toggle="tab">Cancel</a></div>
                            </form>
                        </div>
                        <div class="tab-pane active" id="listServ">
                            <div class="ss-service-table-wrap">
                                <table id="tbllistServ" class="ss-service-table">
                                    <thead><tr><th>S.No</th><th>Category Name</th><th>Model Name</th><th>Car Name</th><th>Year</th><th>Employee Name</th><th>Customer Name</th><th>Service Date</th><th>Service Cost</th><th>Service Type</th><th>Edit</th><th>View</th><th>Delete</th></tr></thead>
                                    <tbody>
                                    <?php foreach ($arrService as $key => $service) {
                                        $encServiceId = encrypt_decrypt($service['service_id']);
                                        $typeClass = 'ss-service-type-' . ($key % 5);
                                        ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><span class="ss-service-category"><?php echo serviceEscape($service['category_name']); ?></span></td>
                                            <td><?php echo serviceEscape($service['model_name']); ?></td>
                                            <td><?php echo serviceEscape($service['car_name']); ?></td>
                                            <td><?php echo serviceEscape($service['year']); ?></td>
                                            <td><?php echo serviceEscape($service['employee_name']); ?></td>
                                            <td><?php echo serviceEscape($service['customer_name']); ?></td>
                                            <td><?php echo serviceEscape($service['service_date']); ?></td>
                                            <td class="ss-service-cost">₹ <?php echo serviceEscape($service['service_cost']); ?></td>
                                            <td><span class="ss-service-type <?php echo $typeClass; ?>"><?php echo serviceEscape($service['service_type']); ?></span></td>
                                            <td class="ss-service-row-action"><a class="ss-service-action" href="edit_service.php?id=<?php echo rawurlencode($encServiceId); ?>" title="Edit service" aria-label="Edit service"><i class="fas fa-pen"></i></a></td>
                                            <td class="ss-service-row-action"><a class="ss-service-action is-view" href="view_service.php?id=<?php echo rawurlencode($encServiceId); ?>" title="View service" aria-label="View service"><i class="fas fa-eye"></i></a></td>
                                            <td class="ss-service-row-action"><button type="button" class="ss-service-action is-delete js-delete-service" data-service-id="<?php echo serviceEscape($encServiceId); ?>" data-service-name="<?php echo serviceEscape($service['car_name']); ?>" title="Delete service" aria-label="Delete service"><i class="fas fa-trash-alt"></i></button></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
    $(function () {
        var serviceTable = $('#tbllistServ').DataTable({
            autoWidth: false,
            lengthChange: false,
            pageLength: 10,
            order: [[7, 'desc']],
            dom: 't<"ss-service-table-footer"ip>',
            language: {
                emptyTable: 'No service records found.',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Showing 0 to 0 of 0 entries',
                infoFiltered: '(filtered from _MAX_ total entries)',
                paginate: { previous: 'Previous', next: 'Next' }
            },
            columnDefs: [{ orderable: false, targets: [10, 11, 12] }]
        });

        $('#serviceSearch').on('input', function () {
            serviceTable.search(this.value).draw();
        });
        $('#serviceFilterToggle').on('click', function () {
            var filter = $('#serviceTypeFilter');
            var expanded = !filter.prop('hidden');
            filter.prop('hidden', expanded);
            $(this).attr('aria-expanded', expanded ? 'false' : 'true');
            if (!expanded) { filter.trigger('focus'); }
        });
        $('#serviceTypeFilter').on('change', function () {
            var value = $.fn.dataTable.util.escapeRegex(this.value);
            serviceTable.column(9).search(value ? '^' + value + '$' : '', true, false).draw();
        });

        $.validator.addMethod('noBlank', function (value, element) {
            return this.optional(element) || $.trim(value).length > 0;
        }, 'This field cannot be blank or filled with only spaces.');
        $('#addForm').validate({
            rules: {
                year: { required: true, noBlank: true },
                servicecost: { required: true, minlength: 1, noBlank: true },
                servicetype: { required: true, minlength: 3, noBlank: true }
            },
            errorElement: 'span',
            errorClass: 'error',
            errorPlacement: function (error, element) { error.insertAfter(element); },
            highlight: function (element) { $(element).addClass('is-invalid'); },
            unhighlight: function (element) { $(element).removeClass('is-invalid'); }
        });

        var tabId = new URLSearchParams(window.location.search).get('tab_id');
        if (tabId === 'addServ' || tabId === 'listServ') {
            $('.ss-service-add[href="#' + tabId + '"]').tab('show');
        }
        $('.ss-sidebar-toggle').on('click', function () {
            $('.ss-dash-layout').toggleClass('sidebar-collapsed');
        });
        $('#ssFullscreen').on('click', function () {
            if (document.fullscreenElement) {
                document.exitFullscreen();
            } else if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            }
        });
    });

    function deleteService(serviceId, serviceName) {
        swal({
            title: 'Delete service?',
            text: 'Delete the service record for ' + serviceName + '? This cannot be undone.',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then(function (confirmed) {
            if (!confirmed) { return; }
            $.ajax({
                type: 'POST',
                url: 'partial/delete_service.php',
                data: { enc_serviceID: serviceId },
                dataType: 'json',
                success: function (response) {
                    swal({
                        title: response.msg === 'Success' ? 'Deleted' : 'Cannot delete',
                        text: response.msg_detail,
                        icon: response.msg === 'Success' ? 'success' : 'error'
                    }).then(function () {
                        if (response.msg === 'Success') { location.reload(); }
                    });
                },
                error: function () {
                    swal({ title: 'Error', text: 'Could not delete this service record.', icon: 'error' });
                }
            });
        });
    }

    $(document).on('click', '.js-delete-service', function () {
        deleteService($(this).data('service-id'), $(this).data('service-name'));
    });
</script>
</body>
</html>
