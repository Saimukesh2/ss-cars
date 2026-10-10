<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  require_once('data/daManageService.php');
  require_once('data/daManageEmployee.php');
  require_once('data/daManageCustomer.php');
    $msg = '';
  $arrProdCat = getAllActiveCategory();
  $arrModels = getAllActiveModels();
  $arrCars = getAllActiveCars();
  $arrEmployee = getAllActiveEmployeeById();
  $arrCustomer = getAllActiveCustomerById();
  $arrService = getAllService();
  if(isset($_GET['msg']))
  {
    $msg = $_GET['msg'];
  }
  //print_r($arrService);
 // exit;
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
                    <h1>Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="location_management.php">Service List</a></li>
                        <li class="breadcrumb-item active">Add Service</li>
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
                                <ul id="serv_tab" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#listServ" data-toggle="tab" >Service List </a></li>
                                    <li class="nav-item"><a class="nav-link" href="#addServ" data-toggle="tab">Add Service</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane" id="addServ">
                                        <form id="addForm" method="post" action="service_validate.php">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="categoryName">Select Category Name</label>
                                                    <select class="form-control" id="categoryName" name="categoryName" required>
                                                        <option value="">Select Category Name</option>
                                                        <?php
                                                        foreach($arrProdCat as $key => $value)
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
                                                    <label for="employeeName">Employee Name</label>
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
                                                    <label for="servicedate">Service Date</label>
                                                    <input type="date" class="form-control" id="servicedate" name="servicedate" required>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="servicecost">Service Cost</label>
                                                    <input type="text" class="form-control" id="servicecost" name="servicecost" required placeholder="Enter Service Cost" value="">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="servicetype">Service Type</label>
                                                    <input type="text" class="form-control" id="servicetype" name="servicetype" required placeholder="Enter Service Type" value="">
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                        <label for="feedback">Feedback</label>
                                                        <textarea class="form-control" id="feedback" name="feedback" rows="4" placeholder="Enter Feedback"></textarea>
                                                </div>                                 
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                           
                                            </div>
                                        </form>
                                    </div>
                                
                                    <!-- Second tab -->
                                    <div class="tab-pane active" id="listServ">
                                        <table id="tbllistServ" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                <th>S.NO.</th>
                                                <th>Category Name</th>
                                                <th>Model Name</th>
                                                <th>Car Name</th>
                                                <th>Year</th>
                                                <th>Employee Name</th>
                                                <th>Customer Name</th>
                                                <th>Service Date</th>
                                                <th>Service Cost</th>
                                                <th>Service Type</th>
                                                <th>Edit</th>
                                                <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                                    foreach($arrService as $key => $value)
                                                    {
                                                        $sno = $key+1;
                                                        $category_name = $value['category_name'];
                                                        $model_name = $value['model_name'];
                                                        $car_name = $value['car_name'];
                                                        $year = $value['year'];
                                                        $employee_name = $value['employee_name'];
                                                        $customer_name = $value['customer_name'];
                                                        $service_date = $value['service_date'];
                                                        $service_cost = $value['service_cost'];
                                                        $service_type = $value['service_type'];
                                                        $enc_service_id = encrypt_decrypt($value['service_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $key+1;?></td>
                                                        <td><?php echo $category_name;?></td>
                                                        <td><?php echo $model_name;?></td>
                                                        <td><?php echo $car_name;?></td>
                                                        <td><?php echo $year;?></td>
                                                        <td><?php echo $employee_name;?></td>
                                                        <td><?php echo $customer_name;?></td>
                                                        <td><?php echo $service_date;?></td>
                                                        <td><?php echo $service_cost;?></td>
                                                        <td><?php echo $service_type;?></td>
                                                        <td><a href="edit_service.php?id=<?php echo $enc_service_id;?>" class="btn-outline-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a></td>
                                                        <td><a href="view_service.php?id=<?php echo $enc_service_id;?>" class="btn-outline-success btn-sm" title="View"><i class="fa fa-eye"></i></a></td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>    
                                        </table>
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
        $("#tbllistServ").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": true
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
                servicedate: {
                    required: true
                },
                servicecost: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                servicetype: {
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
                servicedate: {
                    required: "Please select a service date"
                },
                servicecost: {
                    required: "Please enter a service cost",
                    minlength: "Your service cost must be at least 3 characters long"
                },
                servicetype: {
                    required: "Please enter a service type",
                    minlength: "Your service type must be at least 3 characters long"
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
        $('#serv_tab a[href="#' + value + '"]').tab('show');; 
        }
    });
</script>



</body>
</html>

