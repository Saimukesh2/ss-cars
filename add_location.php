<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageMenus.php');
  require_once('data/daManageSession.php');
  require_once('data/daManageCompany.php');
  require_once('common/check_session_privileges.php');
  $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
  $module_code = 'ADM-M-LO-A';
  require_once('common/check_page_privilege.php');
  $companydtl=getAllcompanies();
  require_once('data/daManageLocation.php');
  $arrAllCountries=loadCountries();
  
  $arrData = array();
  $arrData['country_code'] = isset($_POST['countryCode']) ? sanitize_input($_POST['countryCode'],'string') : null;
  $arrData['location_name'] = isset($_POST['locationName']) ? sanitize_input($_POST['locationName'],'string') : null;
  $arrData['address1'] = isset($_POST['address1']) ? sanitize_input($_POST['address1'], 'string') : null;
  $arrData['address2'] = isset($_POST['address2']) ? sanitize_input($_POST['address2'], 'string') : null;
  $arrData['city'] = isset($_POST['city']) ? sanitize_input($_POST['city'], 'string') : null;
  $arrData['state'] = isset($_POST['state']) ? sanitize_input($_POST['state'], 'string') : null;
  $arrData['zipcode'] = isset($_POST['zipcode']) ? sanitize_input($_POST['zipcode'], 'string') : null;
  $arrData['location_type'] = isset($_POST['locationType']) ? sanitize_input($_POST['locationType'], 'string') : null;
  $arrData['contact_person'] = isset($_POST['contactPerson']) ? sanitize_input($_POST['contactPerson'], 'string') : null;
  $arrData['contact_email'] = isset($_POST['contactEmail']) ? sanitize_input($_POST['contactEmail'], 'string') : null;
  $arrData['contact_number'] = isset($_POST['contactNumber']) ? sanitize_input($_POST['contactNumber'], 'string') : null;
  $arrData['currency'] = isset($_POST['currency']) ? sanitize_input($_POST['currency'], 'string') : null;
  $arrData['location_status'] = isset($_POST['status']) ? sanitize_input($_POST['status'], 'string') : null;
  $arrData['notes'] = isset($_POST['notes']) ? sanitize_input($_POST['notes'], 'string') : null;


  if(!empty($_POST))
  {
    // Server-side validation

     // Validate Mandatory fields
    if(empty($_POST['location_name'])) {
        $msg = "ERR03";
    }

    // Validate Product Category Name
    if(empty($_POST['country_code'])) {
        $msg = "ERR03";
    }
    $count = checkLocationNameExists($arrData);
    if($count > 0)
    {
        $msg = "ERRLOCATIONDUPLICATE";
    }
    else
    {
        $result = insertLocation($arrData);
        if($result == 1)
        {
            $msg = 'SUC05';
            header("Location:location_management.php?msg=".$msg);
            exit;
        }
        else
        {
            $msg = 'ERR01';
        }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $companydtl['company_name'];?></title>
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
                                    <li class="nav-item"><a class="nav-link" href="location_management.php" >Location List</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="addLocation" data-toggle="tab">Add New Location</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane active" id="addLocation">
                                    <form id="addLocationForm" method="post" action="#">
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label for="countryCode">Select Country</label>
                                                <select id="countryCode" name="countryCode" class="form-control" required>
                                                    <option value="">Select Country</option>
                                                    <?php  
                                                        $arrAllCountries=loadCountries();
                                                        foreach($arrAllCountries as $countries) {
                                                            $selected = ($countries['countrycode'] == $arrData['country_code']) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $countries['countrycode']; ?>" <?php echo $selected; ?>>
                                                            <?php echo $countries['countryname']; ?>
                                                        </option>
                                                    <?php } ?> 
                                                </select>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="locationName">Location Name</label>
                                                <input type="text" class="form-control" id="locationName" name="locationName" required placeholder="Enter location Name" value="<?php echo isset($arrData['location_name']) ? $arrData['location_name'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label for="address1">Address 1</label>
                                                <textarea class="form-control" id="address1" name="address1" rows="3" required placeholder="Enter Address 1"><?php echo isset($arrData['address1']) ? $arrData['address1'] : ''; ?></textarea>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="address2">Address 2</label>
                                                <textarea class="form-control" id="address2" name="address2" rows="3" placeholder="Enter Address 2"><?php echo isset($arrData['address2']) ? $arrData['address2'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label for="city">City</label>
                                                <input type="text" class="form-control" id="city" name="city" required placeholder="Enter City" value="<?php echo isset($arrData['city']) ? $arrData['city'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="state">State</label>
                                                <input type="text" class="form-control" id="state" name="state" required placeholder="Enter State" value="<?php echo isset($arrData['state']) ? $arrData['state'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label for="zipcode">Zipcode</label>
                                                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Enter Zipcode" value="<?php echo isset($arrData['zipcode']) ? $arrData['zipcode'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="locationType">Location Type</label>
                                                <select id="locationType" name="locationType" class="form-control" required>
                                                    <option value="">Select Location Type</option>
                                                    <option value="main" <?php echo ($arrData['location_type'] == 'main') ? 'selected' : ''; ?>>Main Office</option>
                                                    <option value="vendor" <?php echo ($arrData['location_type'] == 'vendor') ? 'selected' : ''; ?>>Vendor</option>
                                                    <option value="branch" <?php echo ($arrData['location_type'] == 'branch') ? 'selected' : ''; ?>>Branch</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label for="contactPerson">Contact Person</label>
                                                <input type="text" class="form-control" id="contactPerson" name="contactPerson" required placeholder="Enter Contact Person" value="<?php echo isset($arrData['contact_person']) ? $arrData['contact_person'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="contactEmail">Contact Email</label>
                                                <input type="email" class="form-control" id="contactEmail" name="contactEmail" required placeholder="Enter Contact Email" value="<?php echo isset($arrData['contact_email']) ? $arrData['contact_email'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label for="contactNumber">Contact Number</label>
                                                <input type="text" class="form-control" id="contactNumber" name="contactNumber" required placeholder="Enter Contact Number" value="<?php echo isset($arrData['contact_number']) ? $arrData['contact_number'] : ''; ?>">
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label for="currency">Currency</label>
                                                <select id="currency" name="currency" class="form-control" required>
                                                    <option value="">Select Currency</option>
                                                    <option value="INR" <?php echo ($arrData['currency'] == 'INR') ? 'selected' : ''; ?>>INR</option>
                                                    <option value="USD" <?php echo ($arrData['currency'] == 'USD') ? 'selected' : ''; ?>>USD</option>
                                                    <option value="AUD" <?php echo ($arrData['currency'] == 'AUD') ? 'selected' : ''; ?>>AUD</option>
                                                    <option value="CAD" <?php echo ($arrData['currency'] == 'CAD') ? 'selected' : ''; ?>>CAD</option>
                                                    <option value="SGD" <?php echo ($arrData['currency'] == 'SGD') ? 'selected' : ''; ?>>SGD</option>
                                                    <option value="Euro" <?php echo ($arrData['currency'] == 'Euro') ? 'selected' : ''; ?>>Euro</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 form-group">
                                                <label>Status</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="statusActive" value="Active" <?php echo ($arrData['location_status'] == 'Active') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="statusActive">Active</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" id="statusInactive" value="Inactive" <?php echo ($arrData['location_status'] == 'Inactive') ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="statusInactive">Inactive</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 form-group">
                                                <label for="notes">Notes</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Notes"><?php echo isset($arrData['notes']) ? $arrData['notes'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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

