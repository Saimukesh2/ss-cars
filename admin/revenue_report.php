<?php
session_start();
require_once('common/config.php');
require_once('common/dbconn.php');
require_once('common/common_functions.php');
require_once('data/daManageEmployee.php');
require_once('data/daManageRevenue.php');

function revenueReportEscape($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function revenueReportMoney($amount)
{
    $formattedAmount = number_format((float)$amount, 2, '.', '');
    list($wholeAmount, $decimalAmount) = explode('.', $formattedAmount);
    if (strlen($wholeAmount) > 3) {
        $lastThreeDigits = substr($wholeAmount, -3);
        $remainingDigits = substr($wholeAmount, 0, -3);
        $wholeAmount = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remainingDigits) . ',' . $lastThreeDigits;
    }
    return $wholeAmount . '.' . $decimalAmount;
}

$arrEmployee = getAllActiveEmployeeById();
$arrRevenue = array();
$employeeId = '';
$hasSearched = false;
$reportError = '';
$totalRevenue = 0;
$totalTax = 0;
$totalProfit = 0;
$selectedEmployeeName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = isset($_POST['employeeName']) ? trim($_POST['employeeName']) : '';
    $employeeFound = false;

    foreach ($arrEmployee as $employee) {
        if ((string)$employee['employee_id'] === $employeeId) {
            $selectedEmployeeName = $employee['employee_name'];
            $employeeFound = true;
            break;
        }
    }

    if ($employeeId === '' || !$employeeFound) {
        $reportError = 'Please select a valid employee to view the revenue report.';
    } else {
        $hasSearched = true;
        $arrRevenue = getRevenue(array(
            'employee_name' => $employeeId
        ));
        foreach ($arrRevenue as $revenue) {
            $totalRevenue += (float)$revenue['total_amount_with_tax'];
            $totalTax += (float)$revenue['tax_amount'];
            $totalProfit += (float)$revenue['profit'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Revenue Report | SS-Cars</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/revenue-report.css?v=font-size-20261018">
</head>
<body class="hold-transition ss-dash-page ss-revenue-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a href="employee.php">Employee</a><a href="customer.php">Customer</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details>
            <details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a class="is-current" href="revenue_report.php">Revenue Report</a></details>
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
        <section class="ss-dash-content ss-revenue-content">
            <section class="ss-revenue-hero">
                <div class="ss-revenue-hero-copy"><span>FINANCIAL REPORTS</span><h1><i class="fas fa-chart-line"></i> Revenue Report</h1><p>Track your total revenue, sales, taxes and<br>profit details in real time.</p></div>
                <div class="ss-revenue-hero-note"><strong>MORE SALES<br>MORE REVENUE<br>BIGGER DREAMS</strong></div>
            </section>

            <section class="ss-panel ss-revenue-filter-panel">
                <header class="ss-revenue-filter-heading"><span class="ss-revenue-filter-icon"><i class="fas fa-user-tie"></i></span><div><h2>Revenue Report</h2><p>Select an employee to view their revenue report</p></div></header>
                <?php if ($reportError !== '') { ?><div class="ss-revenue-error" role="alert"><i class="fas fa-exclamation-circle"></i> <?php echo revenueReportEscape($reportError); ?></div><?php } ?>
                <form method="post" action="revenue_report.php" id="revenueReportForm" class="ss-revenue-filter-form" autocomplete="off">
                    <div class="ss-revenue-field ss-revenue-employee-field">
                        <label for="employeeName">Employee Name <b>*</b></label>
                        <span class="ss-revenue-select-wrap">
                            <i class="far fa-user"></i>
                            <select id="employeeName" name="employeeName" required>
                                <option value=""<?php echo $employeeId === '' ? ' selected' : ''; ?> disabled>Select Employee</option>
                                <?php foreach ($arrEmployee as $employee) { ?>
                                    <option value="<?php echo revenueReportEscape($employee['employee_id']); ?>"<?php echo (string)$employee['employee_id'] === $employeeId ? ' selected' : ''; ?>><?php echo revenueReportEscape($employee['employee_name']); ?></option>
                                <?php } ?>
                            </select>
                        </span>
                    </div>
                    <button type="submit" class="ss-revenue-search-button"><i class="fas fa-search"></i> Search</button>
                </form>
            </section>

            <?php if ($hasSearched) { ?>
            <section class="ss-revenue-report-stage">
                <section class="ss-revenue-stat-grid" aria-label="Revenue summary">
                    <article class="ss-revenue-stat-card stat-teal"><span class="ss-revenue-stat-icon"><i class="fas fa-coins"></i></span><div><span>Total Revenue</span><strong>₹ <?php echo revenueReportMoney($totalRevenue); ?></strong><small>All recorded revenue</small></div><i class="fas fa-chart-line ss-revenue-stat-watermark"></i></article>
                    <article class="ss-revenue-stat-card stat-blue"><span class="ss-revenue-stat-icon"><i class="fas fa-handshake"></i></span><div><span>Total Sales</span><strong><?php echo count($arrRevenue); ?></strong><small>Recorded sales</small></div><i class="fas fa-chart-line ss-revenue-stat-watermark"></i></article>
                    <article class="ss-revenue-stat-card stat-purple"><span class="ss-revenue-stat-icon"><i class="fas fa-receipt"></i></span><div><span>Total Tax Amount</span><strong>₹ <?php echo revenueReportMoney($totalTax); ?></strong><small>Tax collected</small></div><i class="fas fa-chart-line ss-revenue-stat-watermark"></i></article>
                    <article class="ss-revenue-stat-card stat-gold"><span class="ss-revenue-stat-icon"><i class="fas fa-chart-bar"></i></span><div><span>Total Profit</span><strong>₹ <?php echo revenueReportMoney($totalProfit); ?></strong><small>Reported profit</small></div><i class="fas fa-chart-line ss-revenue-stat-watermark"></i></article>
                </section>
                <section class="ss-panel ss-revenue-table-panel">
                    <header class="ss-revenue-table-heading">
                        <h2><i class="fas fa-file-invoice-dollar"></i> Revenue Report <small><?php echo revenueReportEscape($selectedEmployeeName); ?></small></h2>
                        <?php if (!empty($arrRevenue)) { ?>
                        <div class="ss-revenue-table-tools">
                            <button type="button" class="ss-revenue-tool-button" id="revenueCsv"><i class="fas fa-download"></i> CSV</button>
                            <button type="button" class="ss-revenue-tool-button" id="revenuePrint"><i class="fas fa-print"></i> Print</button>
                            <label class="ss-revenue-table-search"><i class="fas fa-search"></i><input id="revenueSearch" type="search" placeholder="Search..." aria-label="Search report"></label>
                        </div>
                        <?php } ?>
                    </header>
                    <div class="ss-revenue-table-wrap">
                        <table id="tblRevenueReport" class="ss-revenue-table">
                            <thead><tr><th>S.No</th><th>Category Name</th><th>Model Name</th><th>Car Name</th><th>Year</th><th>Employee Name</th><th>Customer Name</th><th>Sale Date</th><th>Sale Price</th><th>Quantity</th><th>Total Sale</th><th>Discount</th><th>Net Sale</th><th>Tax Amount</th><th>Total With Tax</th><th>Payment Method</th><th>Profit</th></tr></thead>
                            <tbody>
                            <?php if (empty($arrRevenue)) { ?>
                                <tr class="ss-revenue-empty-row"><td colspan="17"><i class="fas fa-info-circle"></i> No revenue records found for <?php echo revenueReportEscape($selectedEmployeeName); ?>.</td></tr>
                            <?php } else { ?>
                            <?php foreach ($arrRevenue as $key => $revenue) { ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><span class="ss-revenue-category"><?php echo revenueReportEscape($revenue['category_name']); ?></span></td>
                                    <td><?php echo revenueReportEscape($revenue['model_name']); ?></td>
                                    <td><?php echo revenueReportEscape($revenue['car_name']); ?></td>
                                    <td><?php echo revenueReportEscape($revenue['year']); ?></td>
                                    <td><?php echo revenueReportEscape($revenue['employee_name']); ?></td>
                                    <td><?php echo revenueReportEscape($revenue['customer_name']); ?></td>
                                    <td><?php echo revenueReportEscape($revenue['sale_date']); ?></td>
                                    <td>₹ <?php echo revenueReportMoney($revenue['price']); ?></td>
                                    <td><?php echo revenueReportEscape($revenue['quantity_sold']); ?></td>
                                    <td>₹ <?php echo revenueReportMoney($revenue['total_sale']); ?></td>
                                    <td>₹ <?php echo revenueReportMoney($revenue['discount']); ?></td>
                                    <td>₹ <?php echo revenueReportMoney($revenue['net_sale']); ?></td>
                                    <td>₹ <?php echo revenueReportMoney($revenue['tax_amount']); ?></td>
                                    <td>₹ <?php echo revenueReportMoney($revenue['total_amount_with_tax']); ?></td>
                                    <td><?php echo revenueReportEscape($revenue['payment_method']); ?></td>
                                    <td>₹ <?php echo revenueReportMoney($revenue['profit']); ?></td>
                                </tr>
                            <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </section>
            <?php } ?>
            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script>
    $(function () {
        <?php if ($hasSearched && !empty($arrRevenue)) { ?>
        var revenueTable = $('#tblRevenueReport').DataTable({
            autoWidth: false,
            lengthChange: false,
            pageLength: 10,
            order: [[7, 'desc']],
            dom: 't<"ss-revenue-table-footer"ip>',
            language: {
                emptyTable: 'No revenue records found for this employee.',
                info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                infoEmpty: 'Showing 0 to 0 of 0 entries',
                infoFiltered: '(filtered from _MAX_ total entries)',
                paginate: { previous: '<i class="fas fa-chevron-left"></i>', next: '<i class="fas fa-chevron-right"></i>' }
            },
            buttons: [
                { extend: 'csvHtml5', title: 'Revenue Report', filename: 'ss-cars-revenue-report', exportOptions: { columns: ':visible' } },
                { extend: 'print', title: 'Revenue Report', exportOptions: { columns: ':visible' } }
            ]
        });
        $('#revenueSearch').on('input', function () { revenueTable.search(this.value).draw(); });
        $('#revenueCsv').on('click', function () { revenueTable.button('.buttons-csv').trigger(); });
        $('#revenuePrint').on('click', function () { revenueTable.button('.buttons-print').trigger(); });
        <?php } ?>

        $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
        $('#ssFullscreen').on('click', function () {
            if (document.fullscreenElement) { document.exitFullscreen(); }
            else if (document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
        });
    });
</script>
</body>
</html>
