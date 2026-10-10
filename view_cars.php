<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  $msg = '';
  //$arrProductCat = getAllActiveCategory();
  //$arrModels = getAllActiveModels();
  //$arrCars = getAllCars();
  if(!empty($_GET))
  {
        $enc_car_id = sanitize_input($_GET['id'],'textarea');
        $car_id = encrypt_decrypt($enc_car_id,'decrypt');
        $arrCar = getCarById($car_id);
        if(!empty($arrCar))
        {
            $car_id = $arrCar['car_id'];
            $car_name = $arrCar['car_name'];
            $model_id = $arrCar['model_name'];
            $model_name = $arrCar['model_name'];
            $category_name = $arrCar['category_name'];
            $year = $arrCar['year'];
            $color_available = $arrCar['color_available'];
            //check color "Red" is present in the $color_available comma separated string
            $arrColor = explode(',', $color_available);
           
            $price = $arrCar['price'];
            $features = $arrCar['features'];
            $mieleage = $arrCar['mieleage'];
            $status = $arrCar['status'];
            //print_r($arrCar);
            //exit;
            if($status == 'InActive')
            {
                $active_checkbox = '';
                $inactive_checkbox = 'checked';
            }
            else
            {
                $active_checkbox = 'checked';
                $inactive_checkbox = '';
            }
        }
        else{
            header("Location: cars.php?msg=ERRCAREMPTY");
        }
  }
  else{
    header("Location: cars.php");
  }
  
  
  function checkColorExists($arrColor,$checkColor)
  {
    $arrColor = array_map('trim', $arrColor);
    if(in_array($checkColor, $arrColor))
    {
        return true;
    }
    else{
        return false;
    }
}
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
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="dist/css/dashboard.css">
    <link rel="stylesheet" href="dist/css/cars-management.css">
  <style>
    /* Custom error message style */
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 14px; /* Set the font size to 10px */
    }
    .form-check-input,.form-control {
            cursor: not-allowed;
        }
        
    
    </style>
</head>
<body class="hold-transition ss-dash-page ss-car-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar"><a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a><nav class="ss-dash-nav" aria-label="Main navigation"><a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a><details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a class="is-current" href="cars.php">Car</a><a href="employee.php">Employee</a><a href="customer.php">Customer</a></details><details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details><details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details><a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></nav><div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div></aside>
    <main class="ss-dash-main"><header class="ss-dash-topbar"><button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button><label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label><div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div></header>
        <section class="ss-dash-content ss-car-content"><section class="ss-car-hero"><div class="ss-car-hero-copy"><span>INVENTORY MANAGEMENT</span><h1><i class="fas fa-car"></i> Vehicle Details</h1><p>Review specifications and availability for this vehicle.</p></div></section>
            <section class="ss-panel ss-car-view-panel"><header class="ss-car-subheading"><h2><i class="fas fa-clipboard-list"></i> <?php echo htmlspecialchars($car_name, ENT_QUOTES, 'UTF-8'); ?></h2><a class="ss-car-back" href="cars.php"><i class="fas fa-arrow-left"></i> Back to Cars List</a></header>
                <div class="ss-car-detail-grid">
                    <div class="ss-car-detail"><span>Category</span><strong><?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-car-detail"><span>Model</span><strong><?php echo htmlspecialchars($model_name, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-car-detail"><span>Car Name</span><strong><?php echo htmlspecialchars($car_name, ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="ss-car-detail"><span>Year</span><strong><?php echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-car-detail"><span>Price</span><strong>&#8377; <?php echo number_format((float)$price, 2, '.', ''); ?></strong></div><div class="ss-car-detail"><span>Mileage</span><strong><?php echo htmlspecialchars($mieleage, ENT_QUOTES, 'UTF-8'); ?></strong></div>
                    <div class="ss-car-detail"><span>Available Colors</span><strong><?php echo htmlspecialchars($color_available, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-car-detail"><span>Status</span><strong><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></strong></div><div class="ss-car-detail is-wide"><span>Features</span><strong><?php echo htmlspecialchars($features ?: 'No features listed', ENT_QUOTES, 'UTF-8'); ?></strong></div>
                </div>
            </section><footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>
<?php if (false) { ?>
<div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Cars</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="cars.php">Cars List</a></li>
                        <li class="breadcrumb-item active">View Cars</li>
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
                                <ul id="car_tab" class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#" data-toggle="tab">View Cars</a></li>
                                <li class="nav-item"><a class="nav-link" href="cars.php"><i class="fa fa-fw fa-arrow-circle-left"></i>Back to Cars List</a>                                    
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane active" id="addcars">
                                        <form id="addForm" method="post" action="#">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="categoryName">Category Name</label>
                                                    <input type="text" class="form-control" id="categoryName" readonly name="categoryName" required placeholder="Enter category Name" value="<?php echo $category_name; ?>">
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="modelName">Model Name</label>
                                                    <input type="text" class="form-control" id="modelName" readonly name="modelName" required placeholder="Enter Model Name" value="<?php echo $model_name; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="carName">Car Name</label>
                                                    <input type="text" class="form-control" id="carName" readonly name="carName" required placeholder="Enter Car Name" value="<?php echo $car_name; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="year">Year</label>
                                                    <input type="text" class="form-control" id="year" name="year" readonly required placeholder="Enter Year" value="<?php echo $year; ?>">
                                                </div>
                                                <div class="col-sm-12 from-group">
                                                    <label for="colorAvailable">Color Available</label>
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableRed"  name="colorAvailable[]" 
                                                                        value="Red"  <?php if(checkColorExists($arrColor,'Red')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableRed">Red</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableBlue" name="colorAvailable[]" 
                                                                            value="Blue" <?php if(checkColorExists($arrColor,'Red')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableBlue">Blue</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">   
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableWhite" name="colorAvailable[]" 
                                                                    value="White" <?php if(checkColorExists($arrColor,'White')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableWhite">White</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableBlack" name="colorAvailable[]"
                                                                    value="Black"  <?php if(checkColorExists($arrColor,'Black')) echo 'checked'; ?>>                        
                                                                <label class="form-check-label" for="colorAvailableBlack">Black</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableTeal" name="colorAvailable[]"
                                                                    value="Teal" <?php if(checkColorExists($arrColor,'Teal')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableTeal">Teal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableSilver" name="colorAvailable[]"
                                                                    value="Silver" <?php if(checkColorExists($arrColor,'Silver')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableSilver">Silver</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableGold" name="colorAvailable[]"
                                                                    value="Gold" <?php if(checkColorExists($arrColor,'Gold')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableGold">Gold</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableYellow" name="colorAvailable[]"
                                                                    value="Yellow" <?php if(checkColorExists($arrColor,'Yellow')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableYellow">Yellow</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableGrey" name="colorAvailable[]"
                                                                    value="Grey" <?php if(checkColorExists($arrColor,'Grey')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableGrey">Grey</label>
                                                            </div>
                                                    
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableOrange" name="colorAvailable[]"
                                                                    value="Orange" <?php if(checkColorExists($arrColor,'Orange')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableOrange">Orange</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableGreen" name="colorAvailable[]"
                                                                    value="Green" <?php if(checkColorExists($arrColor,'Green')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableGreen">Green</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableBrown" name="colorAvailable[]"
                                                                    value="Brown" <?php if(checkColorExists($arrColor,'Brown')) echo 'checked'; ?>>
                                                                <label class="form-check-label" for="colorAvailableBrown">Brown</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">    
                                                        <div class="col-sm-12 form-group">
                                                            <label for="features">Features</label>
                                                            <textarea class="form-control" id="features" name="features" readonly rows="4" placeholder="Enter features"><?php echo $features;?></textarea>
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label for="mieleage">Mieleage</label>
                                                            <input type="text" class="form-control" id="mieleage" name="mieleage" readonly required placeholder="Enter mieleage" value="<?php echo $mieleage;?>">
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label for="price">Price</label>
                                                            <input type="text" class="form-control" id="price" name="price" readonly required placeholder="Enter price" value="<?php echo $price;?>">
                                                        </div>
                                                    </div>    
                                                    <div class="col-sm-12 form-group">
                                                        <label>Status</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" readonly id="statusActive" value="Active" <?php if($status == 'Active') echo 'checked'; ?>>
                                                            <label class="form-check-label" for="statusActive">Active</label>
                                                        </div> 
                                                        <div class="col-sm-12 form-check">
                                                            <input class="form-check-input" type="radio" name="status" readonly id="statusInactive" value="In-Active" <?php if($status == 'In-Active') echo 'checked';?>>
                                                            <label class="form-check-label" for="statusInactive">In-Active</label>
                                                        </div> 
                                                    </div>                                                         
                                                </div>                                                                          
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
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
  <?php include_once("footer.php");?>
  <?php include_once("themes.php");?>
</div>
<!-- ./wrapper -->
<?php } ?>
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
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                year: {
                    required: true,
                    noBlank: true // do not allow pure blank values
                },
                mieleage: {
                    required: true,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                price: {
                    required: true,
                    noBlank: true // do not allow pure blank values created using spacebar
                }
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
                    minlength: "Your car name must be at least 3 characters long"
                },
                year: {
                    required: "Please enter a year"
                },
                mieleage: {
                    required: "Please enter a mieleage"
                },
                price: {
                    required: "Please enter a price"
                }
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
        $('#car_tab a[href="#' + value + '"]').tab('show');; 
        }
    });
</script>

</body>
</html>

