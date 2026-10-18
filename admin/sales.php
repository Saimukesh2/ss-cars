<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  require_once('data/daManageSales.php');
  require_once('data/daManageEmployee.php');
  require_once('data/daManageCustomer.php');
    $msg = '';
    $arrProductCat = getAllActiveCategory();
    $arrModels = getAllActiveModels();
    $arrSales = getAllSales();
    $arrCars = getAllActiveCars();
    $arrEmployee = getAllActiveEmployeeById();
    $arrCustomer = getAllActiveCustomerById();
    if(isset($_GET['msg']))
    {
        $msg = $_GET['msg'];
    }
    $arrPaymentMethods = array();
    foreach($arrSales as $sale)
    {
        if(!empty($sale['payment_method']))
        {
            $arrPaymentMethods[$sale['payment_method']] = $sale['payment_method'];
        }
    }
    //print_r($arrSales);
    //exit;
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SS-Cars</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
 <!-- DataTables -->
 <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
 <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
 <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/sales-management.css?v=font-size-20261018">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <style>
    /* Custom error message style */
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 18px;
    }
    </style>
</head>
<body class="hold-transition ss-dash-page ss-sales-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group" open>
                <summary class="ss-nav-link"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a href="employee.php">Employee</a><a href="customer.php">Customer</a>
            </details>
            <details class="ss-nav-group" open>
                <summary class="ss-nav-link is-active"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="enquiry.php">Enquiry</a><a class="is-current" href="sales.php">Sales</a><a href="service.php">Service</a>
            </details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
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
        <section class="ss-dash-content ss-sales-content">
                                <?php if($msg != '') {
                                        if(substr($msg,0,3)=='SUC'){
                                ?>
                                <div class="alert alert-dismissible ss-dash-alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo getMessage($msg); ?>
                                </div>
                                <?php } else { ?>
                                <div class="alert alert-dismissible ss-dash-alert alert-warning">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo getMessage($msg); ?>
                                </div>
                                <?php } 
                                }
                                ?>
            <section class="ss-sales-hero">
                <div class="ss-sales-hero-copy"><span>SALES MANAGEMENT</span><h1><i class="fas fa-handshake"></i> Sales Management</h1><p>Manage vehicle sales, customer details, and payment records in one place.</p></div>
            </section>
            <section class="ss-panel ss-sales-panel">
                <header class="ss-panel-heading ss-sales-panel-heading">
                    <div class="ss-sales-title-tools">
                        <h2><i class="fas fa-file-invoice-dollar"></i> Sales List</h2>
                        <label class="ss-sales-search"><i class="fas fa-search"></i><input id="salesSearch" type="search" placeholder="Search sales..." aria-label="Search sales"></label>
                        <button type="button" class="ss-sales-filter" aria-label="Filter by payment method"><i class="fas fa-filter"></i><select id="salesPaymentFilter" aria-label="Filter by payment method"><option value="">All payments</option><?php foreach($arrPaymentMethods as $method) { ?><option value="<?php echo htmlspecialchars($method, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($method, ENT_QUOTES, 'UTF-8'); ?></option><?php } ?></select></button>
                    </div>
                    <a class="ss-sales-add" href="#addSale" data-toggle="tab"><i class="fas fa-plus"></i> Add Sale</a>
                </header>
                <div class="ss-sales-tabs">
                    <ul id="sale_tab" class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#listSale" data-toggle="tab"><i class="fas fa-list"></i> Sales List</a></li>
                        <li class="nav-item"><a class="nav-link" href="#addSale" data-toggle="tab"><i class="fas fa-plus-circle"></i> Add Sale</a></li>
                    </ul>
                    <div class="tab-content">
                                    <div class="tab-pane" id="addSale">
                                        <form id="addForm" method="post" action="sales_validate.php" class="ss-sales-form">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="categoryName">Select Category Name</label>
                                                    <select class="form-control" id="categoryName" name="categoryName" required>
                                                        <option value="">Select Category Name</option>
                                                        <?php
                                                        foreach($arrProductCat as $key => $value)
                                                        {
                                                        ?>
                                                            <option value='<?php echo $value['category_id']?>'><?php echo $value['category_name'];?></option>
                                                    <?php 
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="modelName">Select Model Name</label>
                                                    <select class="form-control" id="modelName" name="modelName" required>
                                                        <option value="">Select Model Name</option>
                                                        <?php
                                                        foreach($arrModels as $key => $value)
                                                        {
                                                        ?>
                                                            <option value='<?php echo $value['model_id']?>'><?php echo $value['model_name'];?></option>
                                                    <?php 
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="carName">Select Car Name</label>
                                                    <select class="form-control" id="carName" name="carName" required>
                                                        <option value="">Select Car Name</option>
                                                        <?php
                                                        foreach($arrCars as $key => $value)
                                                        {
                                                        ?>
                                                            <option value='<?php echo $value['car_id']?>'><?php echo $value['car_name'];?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="Year">Year</label>
                                                    <input type="text" class="form-control" id="year" name="year" required placeholder="Enter Year" value="">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="employeename">Employee Name</label>
                                                    <select class="form-control" id="employeeName" name="employeeName" required>
                                                        <option value="">Select Employee Name</option>
                                                        <?php
                                                        foreach($arrEmployee as $key => $value)
                                                        {
                                                        ?>
                                                            <option value='<?php echo $value['employee_id']?>'><?php echo $value['employee_name'];?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>                                               
                                                <div class="col-sm-6 form-group">
                                                    <label for="customerName">Customer Name</label>
                                                    <select class="form-control" id="customerName" name="customerName" required>
                                                        <option value="">Select Customer Name</option>
                                                        <?php
                                                        foreach($arrCustomer as $key => $value)
                                                        {
                                                        ?>
                                                            <option value='<?php echo $value['customer_id']?>'><?php echo $value['customer_name'];?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>          
                                                <div class="col-sm-6 form-group">
                                                    <label for="saledate">Sale Date</label>
                                                    <input type="date" class="form-control" id="saledate" name="saledate" required>
                                                </div>
                                                
                                                <div class="col-sm-6 form-group">
                                                    <label for="saleprice">Sale Price</label>
                                                    <input type="text" class="form-control" id="saleprice" name="saleprice" required placeholder="Enter Sale Price" value="">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                        <label for="paymentmethod">Payment Method</label>
                                                        <input type="text" class="form-control" id="paymentmethod" name="paymentmethod" required placeholder="Enter Payment Method" value="">
                                                </div>                                 
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                           
                                            </div>
                                        </form>
                                    </div>
                                
                                    <!-- Second tab -->
                                    <div class="tab-pane active" id="listSale">
                                        <div class="ss-sales-table-wrap">
                                        <table id="tbllistSale" class="ss-sales-table">
                                            <thead>
                                                <tr>
                                                <th>S.NO.</th>
                                                <th>Category Name</th>
                                                <th>Model Name</th>
                                                <th>Car Name</th>
                                                <th>Year</th>
                                                <th>Employee Name</th>
                                                <th>Customer Name</th>
                                                <th>Sale Date</th>
                                                <th>Sale Price</th>
                                                <th>Payment Method</th>
                                                <th>Edit</th>
                                                <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrSales as $key => $value)
                                                    {
                                                        $sno = $key+1;
                                                        $category_name = $value['category_name'];
                                                        $model_name = $value['model_name'];
                                                        $car_name = $value['car_name'];
                                                        $year = $value['year'];
                                                        $employee_name = $value['employee_name'];
                                                        $customer_name = $value['customer_name'];
                                                        $sale_date = $value['sale_date'];
                                                        $price = $value['price'];
                                                        $payment_method = isset($value['payment_method']) ? $value['payment_method'] : '';
                                                        $enc_sale_id = encrypt_decrypt($value['sale_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $key+1;?></td>
                                                        <td><?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($model_name, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($car_name, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($employee_name, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($sale_date, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($price, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td><?php echo htmlspecialchars($payment_method, ENT_QUOTES, 'UTF-8');?></td>
                                                        <td class="ss-sales-row-action"><a href="edit_sales.php?id=<?php echo rawurlencode($enc_sale_id);?>" class="ss-sales-action" title="Edit" aria-label="Edit sale"><i class="fas fa-pen"></i></a></td>
                                                        <td class="ss-sales-row-action"><a href="view_sales.php?id=<?php echo rawurlencode($enc_sale_id);?>" class="ss-sales-action is-view" title="View" aria-label="View sale"><i class="fas fa-eye"></i></a></td>
                                                    </tr>
                                                <?php      
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="ss-sales-footer"><span id="salesEntrySummary"></span><span class="ss-sales-pagination" id="salesPagination"></span></div>
                                    </div>
                                </div>
                </div>
            </section>
            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<script src="js/sweetalert.min.js"></script>


<script>
    $(function () {
        $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
        $('#ssFullscreen').on('click', function () {
            if (!document.fullscreenElement && document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
            else if (document.exitFullscreen) { document.exitFullscreen(); }
        });

        const salesRows = $('#tbllistSale tbody tr').toArray();
        let currentSalesPage = 1;
        const salesPageSize = 10;

        function renderSalesPage() {
            const query = $('#salesSearch').val().toLowerCase();
            const paymentMethod = $('#salesPaymentFilter').val().toLowerCase();
            const filteredRows = salesRows.filter(function (row) {
                const rowText = $(row).text().toLowerCase();
                const rowPaymentMethod = $(row).children('td').eq(9).text().trim().toLowerCase();
                return rowText.indexOf(query) !== -1 && (!paymentMethod || rowPaymentMethod === paymentMethod);
            });
            const pageCount = Math.max(1, Math.ceil(filteredRows.length / salesPageSize));
            currentSalesPage = Math.min(currentSalesPage, pageCount);
            salesRows.forEach(function (row) { row.style.display = 'none'; });
            filteredRows.slice((currentSalesPage - 1) * salesPageSize, currentSalesPage * salesPageSize).forEach(function (row) { row.style.display = ''; });

            const firstEntry = filteredRows.length ? (currentSalesPage - 1) * salesPageSize + 1 : 0;
            const lastEntry = Math.min(currentSalesPage * salesPageSize, filteredRows.length);
            $('#salesEntrySummary').text('Showing ' + firstEntry + ' to ' + lastEntry + ' of ' + filteredRows.length + ' entries');

            let pageButtons = '<button type="button" data-page="' + Math.max(1, currentSalesPage - 1) + '" aria-label="Previous page"><i class="fas fa-chevron-left"></i></button>';
            for (let page = 1; page <= pageCount; page++) {
                pageButtons += '<button type="button" data-page="' + page + '" class="' + (page === currentSalesPage ? 'is-current' : '') + '">' + page + '</button>';
            }
            pageButtons += '<button type="button" data-page="' + Math.min(pageCount, currentSalesPage + 1) + '" aria-label="Next page"><i class="fas fa-chevron-right"></i></button>';
            $('#salesPagination').html(pageButtons);
        }

        $('#salesSearch').on('input', function () { currentSalesPage = 1; renderSalesPage(); });
        $('#salesPaymentFilter').on('change', function () { currentSalesPage = 1; renderSalesPage(); });
        $('#salesPagination').on('click', 'button', function () { currentSalesPage = Number($(this).data('page')); renderSalesPage(); });
        renderSalesPage();

        $('.ss-sales-add').on('click', function () { $('#sale_tab a[href="#addSale"]').tab('show'); });
        // Add a custom method to check for blank spaces
        $.validator.addMethod("noBlank", function(value, element) {
            return this.optional(element) || $.trim(value).length > 0;
        }, "This field cannot be blank or filled with only spaces.");
        //Lets validate  this form for mandatory fields and input types
        // Initialize form validation on the addLocationForm form
        $("#addForm").validate({
            // Specify validation rules
            rules: {
                categoryName: {
                    required: true,
                   },
                modelName: {
                    required: true,
                    },
                carName: {
                    required: true,
                },
                year: {
                    required: true,
                    noBlank: true // do not allow pure blank values created using spacebar
                },

                employeeName: {
                    required: true,
                },
                customerName: {
                    required: true,
                },
                saledate: {
                    required: true
                },
                saleprice: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                paymentmethod: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
            },
            messages: {
                categoryName: {
                    required: "Please enter a category name",
                    },
                modelName: {
                    required: "Please enter a model name",
                    },
                carName: {
                    required: "Please enter a car name",
                },
                year: {
                    required: "Please enter a year"
                },
                employeeName: {
                    required: "Please enter a employee name",
                },
                customerName: {
                    required: "Please enter a customer name",
                },
                saledate: {
                    required: "Please select a sale date"
                },
                saleprice: {
                    required: "Please enter a sale price",
                    minlength: "Your sale price must be at least 3 characters long"
                },
                paymentmethod: {
                    required: "Please enter a payment method",
                    minlength: "Your payment method must be at least 3 characters long"
                },
            },
            // Apply custom error message style
            errorElement: 'span',
            errorPlacement: function(error, element) {
                // Display the error message below the input field
                error.insertAfter(element);
            },
            // Highlight and unhighlight inputs with error
            highlight: function(element, errorClass) {
                $(element).addClass("is-invalid"); // Add Bootstrap class for invalid input
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass("is-invalid"); // Remove Bootstrap class for valid input
            }
        });
        //The below function is to display the relevant tab based on tab_id
        // Below function is to get the query string value
        const params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
        });
        let value = params.tab_id;// Make sur ethe query 
        //Focus on the tab that is passed as query string
        if(value != null) {
        $('#sale_tab a[href="#' + value + '"]').tab('show');; 
        }
    });
</script>

</body>
</html>
