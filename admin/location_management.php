<?php  
  session_start();
  
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageMenus.php');
  require_once('data/daManageSession.php');
  require_once('data/daManageCompany.php');
  require_once('data/daManageLocation.php');
  require_once('common/check_session_privileges.php');
  $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
  $module_code = 'ADM-M-LO-L';
  require_once('common/check_page_privilege.php');
  $companydtl=getAllcompanies();
  $arrLocation = getAllLocation();
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
                    <h1>Location Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Location Management</li>
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
                                <li class="nav-item"><a class="nav-link active" href="#listLocation" data-toggle="tab">Location List</a></li>
                                <li class="nav-item"><a class="nav-link" href="add_location.php">Add Location</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">   
                            <!-- /.tab-pane for Prod Cat List -->
                            <div class="tab-pane active" id="listLocation">
                                <table id="tblLocation" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                        <th>S.NO.</th>
                                        <th>Location Name</th>
                                        <th>Country </th>
                                        <th>Type </th>
                                        <th>City</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Change Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        foreach($arrLocation as $key => $value)
                                        {
                                            $status = $value['status'];
                                            $sno = $key+1;
                                            $location_name = $value['location_name'];
                                            $country_name = $value['country_code'];
                                            $enc_location_gid = encrypt_decrypt($value['location_gid']);
                                        
                                   ?>
                                        <tr>
                                            <td><?php echo $key+1;?></td>
                                            <td><?php echo $value['location_name'];?></td>
                                            <td><?php echo $value['countryname'];?></td>
                                            <td><?php echo $value['location_type'];?></td>
                                            <td><?php echo $value['city'];?></td>
                                            <td><?php echo $status;?></td>
                                            <td><a href="edit_location.php?id=<?php echo $enc_location_gid;?>"  class="btn-outline-warning btn-sm"  title="Edit"><i class="fa fa-edit"></i></a></td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="deleteLocation('<?php echo $enc_location_gid;?>','<?php echo $status;?>')" class="btn-outline-danger btn-sm" title="Delete"><i class="fa fa-ban"></i></a>
                                                <span id='<?php echo $enc_location_gid;?>' style='display: none;padding-left:1px;'>
                                                    <img src='images/spinner.gif'>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->
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
<script src="js/sweetalert.min.js"></script>

<script>
    $(function () {
        $("#tblLocation").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false
        });
    });
    function deleteLocation(locationId,status) {
        var loaderID = '#'+locationId;
        if(status == 'Active')
        {
            var new_status = 'Inactive'; 
            var changed_status = 'deactivated';
        }
        else {
            var new_status = 'Active';
            var changed_status = 'activated';
        } 
        swal({
            title: "Confirmation",
            text: " Are you sure you want to change the status of this location to "+new_status+" ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: 'POST',
                    url: 'partials/delete_location.php', // Change the URL to the actual delete script
                    data: { locationId: locationId, status : new_status },
                    dataType: 'json',
                    beforeSend:function(){
                        $(loaderID).show();
                    },
                    success: function(response) {
                        // Handle success response
                        if(response.msg == 'Success')
                        {
                            swal("Success", "Location "+changed_status+" successfully.", "success");
                            window.location.reload();
                        }
                        else{
                            swal("Error", response.msg_detail, "error");
                        }
                        // Refresh DataTable
                        //$('#productCategoryTable').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        swal({
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                        });
                    },
                    complete:function(res){
                        $(loaderID).hide();
                    }
                });
            } 
        });
        
    }
</script>
</body>
</html>

