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
$module_code = 'ADM-M-LO-E';
require_once('common/check_page_privilege.php');
$companydtl=getAllcompanies();
require_once('data/daManageLocation.php');
$arrAllCountries=loadCountries();

// Initialize the $arrData array
$arrData = array();

// Check if location ID is provided
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // I get ID in encrypted format.
    $enc_location_id = $_GET['id'];
    $location_id = encrypt_decrypt($enc_location_id, 'decrypt');
    // Fetch location details from the database
    $locationDetails = getLocationDetailsById($location_id);
    // Check if location details are found
    if($locationDetails) {
        // Assign location details to $arrData array
        $arrData['countryCode'] = $locationDetails['country_code'];
        $arrData['locationName'] = $locationDetails['location_name'];
        $arrData['address1'] = $locationDetails['address1'];
        $arrData['address2'] = $locationDetails['address2'];
        $arrData['city'] = $locationDetails['city'];
        $arrData['state'] = $locationDetails['state'];
        $arrData['zipcode'] = $locationDetails['zipcode'];
        $arrData['locationType'] = $locationDetails['location_type'];
        $arrData['contactPerson'] = $locationDetails['contact_person'];
        $arrData['contactEmail'] = $locationDetails['contact_email'];
        $arrData['contactNumber'] = $locationDetails['contact_number'];
        $arrData['currency'] = $locationDetails['currency'];
        $arrData['status'] = $locationDetails['status'];
        $arrData['notes'] = $locationDetails['notes'];
    } else {
        // Location not found, redirect to some error page or handle as needed
        header("Location: error.php");
        exit();
    }
} else {
    // Location ID not provided, redirect to some error page or handle as needed
    header("Location: error.php");
    exit();
}

if(!empty($_POST))
{
    // Server-side validation
    // Populate $arrData with form values
    $enc_location_id = $_POST['location_id'];
    $location_id = encrypt_decrypt($enc_location_id, 'decrypt');
    
    $arrData['address1'] = sanitize_input($_POST['address1'],'string');
    $arrData['address2'] = sanitize_input($_POST['address2'],'string');
    $arrData['city'] = sanitize_input($_POST['city'],'string');
    $arrData['state'] = sanitize_input($_POST['state'],'string');
    $arrData['zipcode'] = sanitize_input($_POST['zipcode'],'string');
    $arrData['location_type'] = sanitize_input($_POST['locationType'],'string');
    $arrData['contact_person'] = sanitize_input($_POST['contactPerson'],'string');
    $arrData['contact_email'] = sanitize_input($_POST['contactEmail'],'string');
    $arrData['contact_number'] = sanitize_input($_POST['contactNumber'],'string');
    $arrData['currency'] = sanitize_input($_POST['currency'],'string');
    $arrData['notes'] = sanitize_input($_POST['notes'],'string');
    $arrData['location_status'] = sanitize_input($_POST['status'],'string');
    $arrData['category_created_by'] = $_SESSION['SESS_USERLOGIN_ID'];

    // Validate Mandatory fields
    // Update location details
    $result = updateLocation($arrData, $location_id);
    if($result == 1) {
        $msg = 'SUC06';
        header("Location: location_management.php?msg=".$msg);
        exit();
    } else {
        $msg = 'ERR01';
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
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
                    <h1>Edit Location</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="location_management.php">Location List</a></li>
                        <li class="breadcrumb-item active">Edit Location</li>
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
                                    <li class="nav-item"><a class="nav-link active" href="editLocation" data-toggle="tab">Edit Location</a></li>
                                    <li class="nav-item"><a class="nav-link" href="location_management.php" ><i class="fa fa-fw fa-arrow-circle-left"></i>Back to Location List</a></li>
                                </ul>

                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane active" id="editLocation">
                                        <form id="editLocationForm" method="post" action="#">
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="countryCode">Select Country</label>
                                                    <select  class="form-control" readonly>
                                                        <option value="">Select Country</option>
                                                        <?php foreach ($arrAllCountries as $countries) { ?>
                                                            <option value="<?php echo $countries['countrycode']; ?>" <?php if ($countries['countrycode'] == $locationDetails['country_code']) echo "selected"; ?>>
                                                                <?php echo $countries['countryname']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="locationName">Location Name</label>
                                                    <input type="text" class="form-control" id="locationName" name="locationName" readonly placeholder="Enter location Name" value="<?php echo $locationDetails['location_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="address1">Address 1</label>
                                                    <textarea class="form-control" id="address1" name="address1" rows="3" required placeholder="Enter Address 1"><?php echo $locationDetails['address1']; ?></textarea>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="address2">Address 2</label>
                                                    <textarea class="form-control" id="address2" name="address2" rows="3" placeholder="Enter Address 2"><?php echo $locationDetails['address2']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="city">City</label>
                                                    <input type="text" class="form-control" id="city" name="city" required placeholder="Enter City" value="<?php echo $locationDetails['city']; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="state">State</label>
                                                    <input type="text" class="form-control" id="state" name="state" required placeholder="Enter State" value="<?php echo $locationDetails['state']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="zipcode">Zipcode</label>
                                                    <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Enter Zipcode" value="<?php echo $locationDetails['zipcode']; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="locationType">Location Type</label>
                                                    <select id="locationType" name="locationType" class="form-control" required>
                                                        <option value="">Select Location Type</option>
                                                        <option value="main" <?php if ($locationDetails['location_type'] == 'main') echo "selected"; ?>>Main Office</option>
                                                        <option value="vendor" <?php if ($locationDetails['location_type'] == 'vendor') echo "selected"; ?>>Vendor</option>
                                                        <option value="branch" <?php if ($locationDetails['location_type'] == 'branch') echo "selected"; ?>>Branch</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="contactPerson">Contact Person</label>
                                                    <input type="text" class="form-control" id="contactPerson" name="contactPerson" required placeholder="Enter Contact Person" value="<?php echo $locationDetails['contact_person']; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="contactEmail">Contact Email</label>
                                                    <input type="email" class="form-control" id="contactEmail" name="contactEmail" required placeholder="Enter Contact Email" value="<?php echo $locationDetails['contact_email']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="contactNumber">Contact Number</label>
                                                    <input type="text" class="form-control" id="contactNumber" name="contactNumber" required placeholder="Enter Contact Number" value="<?php echo $locationDetails['contact_number']; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="currency">Currency</label>
                                                    <select id="currency" name="currency" class="form-control" required>
                                                        <option value="">Select Currency</option>
                                                        <option value="INR" <?php if ($locationDetails['currency'] == 'INR') echo "selected"; ?>>INR</option>
                                                        <option value="USD" <?php if ($locationDetails['currency'] == 'USD') echo "selected"; ?>>USD</option>
                                                        <option value="AUD" <?php if ($locationDetails['currency'] == 'AUD') echo "selected"; ?>>AUD</option>
                                                        <option value="CAD" <?php if ($locationDetails['currency'] == 'CAD') echo "selected"; ?>>CAD</option>
                                                        <option value="SGD" <?php if ($locationDetails['currency'] == 'SGD') echo "selected"; ?>>SGD</option>
                                                        <option value="Euro" <?php if ($locationDetails['currency'] == 'Euro') echo "selected"; ?>>Euro</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 form-group">
                                                    <label>Status</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusActive" value="Active" <?php if ($locationDetails['status'] == 'Active') echo "checked"; ?>>
                                                        <label class="form-check-label" for="statusActive">Active</label>&nbsp; &nbsp;&nbsp; &nbsp;
                                                        <input class="form-check-input" type="radio" name="status" id="statusInactive" value="Inactive" <?php if ($locationDetails['status'] == 'Inactive') echo "checked"; ?>>
                                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="notes">Notes</label>
                                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Notes"><?php echo $locationDetails['notes']; ?></textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="location_id" value="<?php echo encrypt_decrypt($location_id, 'encrypt'); ?>">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>

                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <?php include_once("footer.php");?>
  <?php include_once("themes.php");?>
</div><!-- ./wrapper -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- jQuery Validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<script>
$(document).ready(function () {
    $('#editLocationForm').validate({
        rules: {
            // Add validation rules for other fields here
        },
        messages: {
            // Add custom messages for other fields here
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
</body>
</html>
