<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
    $msg = '';
    if(isset($_GET['msg']))
    {
        $msg = $_GET['msg'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Page Title</title>
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
  <style>
    /* Custom error message style */
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 14px; /* Set the font size to 10px */
    }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php 
    include_once("header.php");
    include_once("sidemenu.php");
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add New Location</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="location_management.php">Location List</a></li>
                        <li class="breadcrumb-item active">Add New Location</li>
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
                                <ul id="product_cat_tab" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link" href="page1.php" >List</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="addPage" data-toggle="tab">Add</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane active" id="addPage">
                                    <form id="addForm" method="post" action="#">
                                        <div class="row">
                                            <div class="col-sm-3 form-group">
                                                <label for="locationName">Location Name</label>
                                                <input type="text" class="form-control" id="locationName" name="locationName" required placeholder="Enter location Name" value="<?php echo isset($arrData['location_name']) ? $arrData['location_name'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="locationDesc">Location Desc</label>
                                                <input type="text" class="form-control" id="locationDesc" name="locationDesc" required placeholder="Enter location Desc" value="<?php echo isset($arrData['location_name']) ? $arrData['location_name'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="locationDesc">Location Desc</label>
                                                <input type="text" class="form-control" id="locationDesc" name="locationDesc" required placeholder="Enter location Desc" value="<?php echo isset($arrData['location_name']) ? $arrData['location_name'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-3 form-group">
                                                <label for="locationDesc">Location Desc</label>
                                                <input type="text" class="form-control" id="locationDesc" name="locationDesc" required placeholder="Enter location Desc" value="<?php echo isset($arrData['location_name']) ? $arrData['location_name'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">&nbsp;</div>
                                            <div class="col-sm-1 form-group">
                                                <button type="submit"  class="btn btn-primary" >Submit</button>
                                            </div>
                                            <div class="col-sm-5 form-group">&nbsp;</div>
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
        // Initialize form validation on the addLocationForm form
        $("#addLocationForm").validate({
            // Specify validation rules
            rules: {
                countryCode: {
                    required: true
                },
                locationName: {
                    required: true
                },
                address1: {
                    required: true
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                locationType: {
                    required: true
                },
                contactPerson: {
                    required: true
                },
                contactEmail: {
                    required: true,
                    email: true // Validate email format
                },
                contactNumber: {
                    required: true
                },
                currency: {
                    required: true
                }
            },
            // Specify validation error messages
            messages: {
                countryCode: {
                    required: "Please select a country"
                },
                locationName: {
                    required: "Please enter location name"
                },
                address1: {
                    required: "Please enter address 1"
                },
                city: {
                    required: "Please enter city"
                },
                state: {
                    required: "Please enter state"
                },
                locationType: {
                    required: "Please select a location type"
                },
                contactPerson: {
                    required: "Please enter contact person"
                },
                contactEmail: {
                    required: "Please enter contact email",
                    email: "Please enter a valid email address" // Email format validation message
                },
                contactNumber: {
                    required: "Please enter contact number"
                },
                currency: {
                    required: "Please select a currency"
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
    });

</script>

</body>
</html>

