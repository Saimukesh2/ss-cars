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
    $arrCars = getAllActiveCars();
    $arrEmployee = getAllActiveEmployeeById();
    $arrCustomer = getAllActiveCustomerById();
    if(!isset($_GET['id']) || !is_string($_GET['id']) || trim($_GET['id']) === '')
    {
        header('Location: sales.php?msg=ERR');
        exit;
    }
    $enc_sale_id = sanitize_input($_GET['id'], 'textarea');
    $sale_id = encrypt_decrypt($enc_sale_id, 'decrypt');
    $arrSales = $sale_id ? getSalesById($sale_id) : array();
    if(empty($arrSales))
    {
        header('Location: sales.php?msg=ERR');
        exit;
    }
    $sale_id = $arrSales['sale_id'];
    $car_id = $arrSales['car_id'];
    $car_name = $arrSales['car_name'];
    $category_id = $arrSales['category_id'];
    $category_name = $arrSales['category_name'];
    $model_id = $arrSales['model_id'];
    $model_name = $arrSales['model_name'];
    $year = $arrSales['year'];
    $customer_id = $arrSales['customer_id'];
    $customer_name = $arrSales['customer_name'];
    $employee_id = $arrSales['employee_id'];
    $employee_name = $arrSales['employee_name'];
    $sale_date = $arrSales['sale_date'];
    $sale_price = $arrSales['sale_price'];
    $payment_method = $arrSales['payment_method'];
  
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/main.css">
  <link rel="stylesheet" href="dist/css/dashboard.css">
  <link rel="stylesheet" href="dist/css/sales-management.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <style>
    /* Custom error message style */
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 14px; /* Set the font size to 10px */
    }
    </style>
</head>
<body class="hold-transition ss-dash-page ss-sales-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group" open><summary class="ss-nav-link"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a href="employee.php">Employee</a><a href="customer.php">Customer</a></details>
            <details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a class="is-current" href="sales.php">Sales</a><a href="service.php">Service</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
            <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </nav>
        <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
    </aside>
    <main class="ss-dash-main">
        <header class="ss-dash-topbar"><button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button><label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label><div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div></header>
        <section class="ss-dash-content ss-sales-content">
            <section class="ss-sales-hero"><div class="ss-sales-hero-copy"><span>SALES MANAGEMENT</span><h1><i class="fas fa-pen"></i> Edit Sale</h1><p>Update vehicle sale details and payment information.</p></div></section>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sale</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="sales.php">Sales List</a></li>
                        <li class="breadcrumb-item active">Edit Sale</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header p-2">
                                <?php if($msg != '') {
                                        if(substr($msg,0,3)=='SUC'){
                                ?>
                                <div class="alert alert-success  alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-info"></i><?php echo getMessage($msg); ?>
                                </div>
                                <?php } else { ?>
                                <div class="alert alert-warning  alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-info"></i><?php echo getMessage($msg); ?>
                                </div>
                                <?php } 
                                }
                                ?>
                                <ul id="sale_tab" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#listSale" data-toggle="tab" >Edit Sale</a></li>
                                    <li class="nav-item"><a class="nav-link" href="sales.php"><i class="fa fa-fw fa-arrow-circle-left"></i>Back to Sale List</a></li>     
                                    </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane active" id="addSale">
                                        <form id="addForm" method="post" action="edit_sales_validate.php" class="ss-sales-form">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="categoryName">Select Category Name</label>
                                                    <select class="form-control" id="categoryName" name="categoryName" required>
                                                        <option value="">Select Category Name</option>
                                                        <?php
                                                        foreach($arrProductCat as $key => $value)
                                                        {
                                                            if($category_id == $value['category_id']) $category_match = 'selected';
                                                            else $category_match = '';
                                                        ?>
                                                            <option value='<?php echo $value['category_id']?>'<?php echo $category_match;?>>
                                                                <?php echo $value['category_name'];?>
                                                            </option>
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
                                                            if($model_id == $value['model_id']) $model_match = 'selected';
                                                            else $model_match = '';
                                                        ?>
                                                            <option value='<?php echo $value['model_id']?>'<?php echo $model_match;?>>
                                                                <?php echo $value['model_name'];?>
                                                            </option>
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
                                                            if($car_id == $value['car_id']) $car_match = 'selected';
                                                            else $car_match = '';
                                                        ?>
                                                            <option value='<?php echo $value['car_id']?>'<?php echo $car_match;?>>
                                                                <?php echo $value['car_name'];?>
                                                            </option>
                                                    <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="Year">Year</label>
                                                    <input type="text" class="form-control" id="year" name="year" required placeholder="Enter Year" value="<?php echo $year;?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="employeename">Employee Name</label>
                                                    <select class="form-control" id="employeeName" name="employeeName"disabled required>
                                                        <option value="">Select Employee Name</option>
                                                        <?php
                                                        foreach($arrEmployee as $key => $value)
                                                        {
                                                            if($employee_id == $value['employee_id']) $employee_match = 'selected';
                                                            else $employee_match = '';
                                                        ?>
                                                            <option value='<?php echo $value['employee_id']?>'<?php echo $employee_match;?>>
                                                                <?php echo $value['employee_name'];?>
                                                            </option>
                                                    <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>                                               
                                                <div class="col-sm-6 form-group">
                                                    <label for="customerName">Customer Name</label>
                                                    <select class="form-control" id="customerName" name="customerName" disabled required>
                                                        <option value="">Select Customer Name</option>
                                                        <?php
                                                        foreach($arrCustomer as $key => $value)
                                                        {
                                                            if($customer_id == $value['customer_id']) $customer_match = 'selected';
                                                            else $customer_match = '';
                                                        ?>
                                                            <option value='<?php echo $value['customer_id']?>'<?php echo $customer_match;?>>
                                                                <?php echo $value['customer_name'];?>
                                                            </option>
                                                    <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>          
                                                <div class="col-sm-6 form-group">
                                                    <label for="saledate">Sale Date</label>
                                                    <input type="date" class="form-control" id="saledate" name="saledate" value="<?php echo $sale_date;?>" required>
                                                </div>
                                                
                                                <div class="col-sm-6 form-group">
                                                    <label for="saleprice">Sale Price</label>
                                                    <input type="text" class="form-control" id="saleprice" name="saleprice" required placeholder="Enter Sale Price" value="<?php echo $sale_price;?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                        <label for="paymentmethod">Payment Method</label>
                                                        <input type="text" class="form-control" id="paymentmethod" name="paymentmethod" required placeholder="Enter Payment Method" value="<?php echo $payment_method;?>">
                                                </div> 
                                                <input type="hidden" name="hdnSalesID" value="<?php echo $enc_sale_id?>">                                
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                           
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end of tab content -->
                            </div><!-- /.card-body -->
                            <!-- /.card-header -->
                        </div>                                
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
  <!-- /.content-wrapper -->
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
