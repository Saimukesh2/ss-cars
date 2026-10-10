<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  require_once('data/daManageService.php');
  require_once('data/daManageEmployee.php');
  require_once('data/daManageRevenue.php');
    
    $msg = '';
    $arrProdCat = getAllActiveCategory();
    $arrModels = getAllActiveModels();
    $arrCars = getAllActiveCars();
    $arrEmployee = getAllActiveEmployeeById();

    if(!empty($_POST))
    {

        $arrData['employee_name'] = sanitize_input($_POST['employeeName'],'textarea');

        $employeeName = $arrData['employee_name'];
        // Removed debugging print and exit statements
        $arrgetRevenue = getRevenue($arrData);
        /*print_r($_POST);
        exit;*/

    } else {

        $employeeName = '';
    }
    $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
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
    .error {
        color: red;
        font-weight: 10;
        font-size: 14px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php 
    include_once("header.php");
    include_once("sidemenu.php");
?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Revenue Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header p-2">
                                <?php if($msg != '') { 
                                    if(substr($msg, 0, 3) == 'SUC') { ?>
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fas fa-info"></i><?php echo getMessage($msg); ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="icon fas fa-info"></i><?php echo getMessage($msg); ?>
                                    </div>
                                <?php } } ?>
                                
                                <ul id="revenue_report" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="addPage" data-toggle="tab">Revenue Report</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane active" id="addPage">
                                        <form method="post" action="" name="revenuereport" id="revenuereport" novalidate>
                                            <div class="form-group row">
                                                <div class="col-sm-6 form-group">
                                                    <label for="employeeName">Employee Name</label>
                                                    <select class="form-control" id="employeeName" name="employeeName" required>
                                                        <option value="">Select Employee</option>
                                                        <?php
                                                            foreach($arrEmployee as $key => $value) {
                                                        ?>
                                                            <option value='<?php echo $value['employee_id']?>'<?php if($employeeName==$value['employee_id']) { ?> selected <?php } ?>>
                                                                <?php echo $value['employee_name'];?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">Select Employee Name!</div>
                                                </div> 
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-5 col-sm-10">
                                                    <input type="hidden" name="action" value="Search">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                            <div id="excel" class="col-md-2 form-group" style='display: none;padding-left:1px;'>
                                                <button type="button" id="downloadButton" name="downloadButton" class="btn btn-success">Download Excel</button>
                                            </div> 
                                            <div class="col-sm-3">
                                                <div id='loader' style='display: none;padding-left:1px;'>
                                                    <img src='images/ajax-loader.gif'>
                                                </div>
                                            </div>
                                        </form>

                                        <?php if(!empty($_POST)) { ?>
                                            <table id='tblRevenueReport' class="table table-bordered table-striped">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>S.NO</th>
                                                        <th>Category Name</th>
                                                        <th>Car Name</th>
                                                        <th>Employee Name</th>
                                                        <th>Customer Name</th>
                                                        <th>Quantity Sold</th>
                                                        <th>Price</th>
                                                        <th>Total Sale</th>
                                                        <th>Discount</th>
                                                        <th>Net Sale</th>
                                                        <th>Tax Amount</th>
                                                        <th>Total Amount With Tax</th>
                                                        <th>Payment Method</th>
                                                        <th>Profit</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody-light">
                                                    <?php
                                                        $sno = 1;
                                                        foreach($arrgetRevenue as $key => $value)
                                                        {
                                                            $categoryName = $value['category_name'];
                                                            $carName = $value['car_name'];
                                                            $employeeName = $value['employee_name'];
                                                            $customerName = $value['customer_name'];
                                                            $quantitySold = $value['quantity_sold'];
                                                            $price = $value['price'];
                                                            $totalSale = $value['total_sale'];
                                                            $discount = $value['discount'];
                                                            $netSale = $value['net_sale'];
                                                            $taxAmount = $value['tax_amount'];
                                                            $totalAmountWithTax = $value['total_amount_with_tax'];
                                                            $paymentMethod = $value['payment_method'];
                                                            $profit = $value['profit'];
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $sno++;?></td>
                                                            <td><?php echo $value['category_name'];?></td>
                                                            <td><?php echo $value['car_name'];?></td>
                                                            <td><?php echo $value['employee_name'];?></td>
                                                            <td><?php echo $value['customer_name'];?></td>
                                                            <td><?php echo $value['quantity_sold'];?></td>
                                                            <td><?php echo $value['price'];?></td>
                                                            <td><?php echo $value['total_sale'];?></td>
                                                            <td><?php echo $value['discount'];?></td>
                                                            <td><?php echo $value['net_sale'];?></td>
                                                            <td><?php echo $value['tax_amount'];?></td>
                                                            <td><?php echo $value['total_amount_with_tax'];?></td>
                                                            <td><?php echo $value['payment_method'];?></td>
                                                            <td><?php echo $value['profit'];?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <br><br><?php $total=0;?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>

    <!-- Footer -->
    <?php include_once("footer.php"); ?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!--<script src="dist/js/demo.js"></script>-->
<script src="js/sweetalert.min.js"></script>
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- Page specific script -->
<script>
    $(function () {
        $("#tblRevenueReport").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": [ "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#tblRevenueReport_wrapper .col-md-6:eq(0)');
    });

    // Show loader when searching
    $('#revenuereport').on('submit', function(e) {
        $('#loader').show();
    });

    // Download Excel functionality
    $('#downloadButton').on('click', function() {
        var table = $("#tblRevenueReport").DataTable();
        table.button('.buttons-excel').trigger();
    });
</script>
</body>
</html>

