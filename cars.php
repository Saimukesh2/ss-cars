<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  $msg = '';
  $arrProductCat = getAllActiveCategory();
  $arrModels = getAllActiveModels();
  $arrCars = getAllCars();
  /*foreach($arrModels as $key => $value)
{
    print_r($value);
    echo "End of Row<br>";
}
exit;*/

//print_r($arrCars);
//exit;
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
    </style>
</head>
<body class="hold-transition ss-dash-page ss-car-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a class="is-current" href="cars.php">Car</a><a href="employee.php">Employee</a><a href="customer.php">Customer</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
            <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </nav>
        <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
    </aside>
    <main class="ss-dash-main">
        <header class="ss-dash-topbar"><button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button><label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label><div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div></header>
        <section class="ss-dash-content ss-car-content">
            <?php if($msg != '') { ?><div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg,0,3) == 'SUC' ? 'alert-success' : 'alert-warning'; ?>"><button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo getMessage($msg); ?></div><?php } ?>
            <section class="ss-car-hero"><div class="ss-car-hero-copy"><span>INVENTORY MANAGEMENT</span><h1><i class="fas fa-car"></i> Cars</h1><p>Manage your car inventory, add new cars, update details<br>and keep track of all vehicles in your showroom.</p></div></section>
            <section class="ss-panel ss-car-panel">
                <header class="ss-panel-heading ss-car-panel-heading"><div class="ss-car-title-tools"><h2><i class="fas fa-car"></i> Cars List</h2><a class="ss-car-add" href="#addcars" data-toggle="tab"><i class="fas fa-plus"></i> Add Car</a></div><div class="ss-car-tools"><label class="ss-car-search"><i class="fas fa-search"></i><input id="carSearch" type="search" placeholder="Search cars..." aria-label="Search cars"></label><label class="ss-car-filter" title="Filter by category"><i class="fas fa-filter"></i><select id="carCategoryFilter" aria-label="Filter by category"><option value="">All categories</option><?php foreach($arrProductCat as $value) { ?><option value="<?php echo htmlspecialchars($value['category_name'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($value['category_name'], ENT_QUOTES, 'UTF-8'); ?></option><?php } ?></select></label></div></header>
                <div class="ss-car-tabs"><div class="tab-content">
                    <div class="tab-pane" id="addcars"><form id="addForm" method="post" action="cars_validate.php" class="ss-car-form">
                        <div><label for="categoryName">Category Name</label><select id="categoryName" name="categoryName" required><option value="">Select Category Name</option><?php foreach($arrProductCat as $value) { ?><option value="<?php echo $value['category_id']; ?>"><?php echo htmlspecialchars($value['category_name'], ENT_QUOTES, 'UTF-8'); ?></option><?php } ?></select></div>
                        <div><label for="modelName">Model Name</label><select id="modelName" name="modelName" required><option value="">Select Model Name</option><?php foreach($arrModels as $value) { ?><option value="<?php echo $value['model_id']; ?>"><?php echo htmlspecialchars($value['model_name'], ENT_QUOTES, 'UTF-8'); ?></option><?php } ?></select></div>
                        <div><label for="carName">Car Name</label><input type="text" id="carName" name="carName" required placeholder="Enter car name"></div><div><label for="year">Year</label><input type="text" id="year" name="year" required placeholder="Enter year"></div>
                        <div class="span-two"><label>Available Colors</label><div class="ss-car-colors"><?php foreach(array('Red','Blue','White','Black','Teal','Silver','Gold','Yellow','Grey','Orange','Green','Brown') as $color) { ?><label><input type="checkbox" name="colorAvailable[]" value="<?php echo $color; ?>"> <?php echo $color; ?></label><?php } ?></div></div>
                        <div class="span-two"><label for="features">Features</label><textarea id="features" name="features" rows="3" placeholder="Enter features"></textarea></div>
                        <div><label for="mieleage">Mileage</label><input type="text" id="mieleage" name="mieleage" required placeholder="Enter mileage"></div><div><label for="price">Price</label><input type="text" id="price" name="price" required placeholder="Enter price"></div>
                        <div class="span-two"><label>Status</label><div class="ss-car-radio"><label><input type="radio" name="status" value="Active" checked> Active</label><label><input type="radio" name="status" value="Inactive"> Inactive</label></div></div>
                        <div class="ss-car-form-actions"><button type="submit" class="ss-car-add"><i class="fas fa-save"></i> Save Car</button><a href="#listcars" data-toggle="tab" class="ss-car-cancel">Cancel</a></div>
                    </form></div>
                    <div class="tab-pane active" id="listcars"><div class="ss-car-table-wrap"><table id="tbllistcars" class="ss-car-table"><thead><tr><th>S.No</th><th>Category Name</th><th>Model Name</th><th>Car Name</th><th>Year</th><th>Price</th><th>Mileage</th><th>Status</th><th>Edit</th><th>Delete</th><th>View</th></tr></thead><tbody>
                        <?php foreach($arrCars as $key => $value) { $status = $value['status']; $category_name = $value['category_name']; $model_name = $value['model_name']; $car_name = $value['car_name']; $year = $value['year']; $price = $value['price']; $mieleage = $value['mieleage']; $enc_car_id = encrypt_decrypt($value['car_id']); $car_category_class = 'cat-' . strtolower(str_replace(' ', '-', $category_name)); $car_image = array('images/dashboard-car-front.jpg', 'images/dashboard-car-city.jpg', 'images/dashboard-car-rear.jpg')[$key % 3]; ?>
                        <tr><td><?php echo $key + 1; ?></td><td><span class="ss-car-category <?php echo htmlspecialchars($car_category_class, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?></span></td><td class="ss-car-model"><?php echo htmlspecialchars($model_name, ENT_QUOTES, 'UTF-8'); ?></td><td><div class="ss-car-name"><img class="ss-car-thumb" src="<?php echo $car_image; ?>" alt="<?php echo htmlspecialchars($car_name, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($car_name, ENT_QUOTES, 'UTF-8'); ?></div></td><td><?php echo htmlspecialchars($year, ENT_QUOTES, 'UTF-8'); ?></td><td>&#8377; <?php echo number_format((float)$price, 2, '.', ''); ?></td><td><?php echo htmlspecialchars($mieleage, ENT_QUOTES, 'UTF-8'); ?></td><td><span class="ss-car-status <?php echo strtolower($status) == 'active' ? '' : 'is-inactive'; ?>"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></span></td><td class="ss-car-row-action"><a class="ss-car-action" href="edit_cars.php?id=<?php echo $enc_car_id; ?>" title="Edit"><i class="fas fa-pen"></i></a></td><td class="ss-car-row-action"><a class="ss-car-action is-delete" href="javascript:void(0)" onclick="deleteCar('<?php echo $enc_car_id; ?>','<?php echo htmlspecialchars($car_name, ENT_QUOTES, 'UTF-8'); ?>')" title="Delete"><i class="fas fa-trash"></i></a><span id="<?php echo $enc_car_id; ?>" style="display:none"><img src="images/spinner.gif" alt=""></span></td><td class="ss-car-row-action"><a class="ss-car-action is-view" href="view_cars.php?id=<?php echo $enc_car_id; ?>" title="View"><i class="fas fa-eye"></i></a></td></tr>
                        <?php } ?>
                    </tbody></table></div><div class="ss-car-footer"><span id="carEntrySummary"></span><span class="ss-car-pagination" id="carPagination"></span></div></div>
                </div></div>
            </section>
            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
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
                    <h1>Cars</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="cars.php">Cars List</a></li>
                        <li class="breadcrumb-item active">Add New Car</li>
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
                                    <li class="nav-item"><a class="nav-link active" href="#listcars" data-toggle="tab">Cars List</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#addcars" data-toggle="tab">Add Cars</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane" id="addcars">
                                        <form id="addForm" method="post" action="cars_validate.php">
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
                                                <div class="col-sm-6 form-group">
                                                    <label for="carName">Car Name</label>
                                                    <input type="text" class="form-control" id="carName" name="carName" required placeholder="Enter Car Name" value="<?php echo isset($arrData['car_name']) ? $arrData['car_name'] : ''; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="year">Year</label>
                                                    <input type="text" class="form-control" id="year" name="year" required placeholder="Enter Year" value="<?php echo isset($arrData['year']) ? $arrData['year'] : ''; ?>">
                                                </div>
                                                <div class="col-sm-12 from-group">
                                                    <label for="colorAvailable">Color Available</label>
                                                    <div class="row">
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableRed" name="colorAvailable[]" value="Red">
                                                                <label class="form-check-label" for="colorAvailableRed">Red</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableBlue" name="colorAvailable[]" value="Blue">
                                                                <label class="form-check-label" for="colorAvailableBlue">Blue</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">   
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableWhite" name="colorAvailable[]" value="White">
                                                                <label class="form-check-label" for="colorAvailableWhite">White</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableBlack" name="colorAvailable[]" value="Black">
                                                                <label class="form-check-label" for="colorAvailableBlack">Black</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableTeal" name="colorAvailable[]" value="Teal">
                                                                <label class="form-check-label" for="colorAvailableTeal">Teal</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableSilver" name="colorAvailable[]" value="Silver">
                                                                <label class="form-check-label" for="colorAvailableSilver">Silver</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableGold" name="colorAvailable[]" value="Gold">
                                                                <label class="form-check-label" for="colorAvailableGold">Gold</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableYellow" name="colorAvailable[]" value="Yellow">
                                                                <label class="form-check-label" for="colorAvailableYellow">Yellow</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableGrey" name="colorAvailable[]" value="Grey">
                                                                <label class="form-check-label" for="colorAvailableGrey">Grey</label>
                                                            </div>
                                                    
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableOrange" name="colorAvailable[]" value="Orange">
                                                                <label class="form-check-label" for="colorAvailableOrange">Orange</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableGreen" name="colorAvailable[]" value="Green">
                                                                <label class="form-check-label" for="colorAvailableGreen">Green</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" id="colorAvailableBrown" name="colorAvailable[]" value="Brown">
                                                                <label class="form-check-label" for="colorAvailableBrown">Brown</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">    
                                                        <div class="col-sm-12 form-group">
                                                            <label for="features">Features</label>
                                                            <textarea class="form-control" id="features" name="features" rows="4" placeholder="Enter features"></textarea>
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label for="mieleage">Mieleage</label>
                                                            <input type="text" class="form-control" id="mieleage" name="mieleage" required placeholder="Enter mieleage">
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label for="price">Price</label>
                                                            <input type="text" class="form-control" id="price" name="price" required placeholder="Enter price" value="">
                                                        </div>
                                                    </div>    
                                                    <div class="col-sm-12 form-group">
                                                        <label>Status</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="statusActive" value="Active" checked>
                                                            <label class="form-check-label" for="statusActive">Active</label>
                                                        </div> 
                                                        <div class="col-sm-12 form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="statusInactive" value="Inactive">
                                                            <label class="form-check-label" for="statusInactive">Inactive</label>
                                                        </div> 
                                                    </div>                                                         
                                                </div>                                        
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                                                                
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Second Tab -->

                                    <div class="tab-pane active" id="listcars">
                                        <table id="tbllistcars" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                <th>S.NO</th>
                                                <th>Category Name</th>
                                                <th>Model Name</th>
                                                <th>Car Name</th>
                                                <th>Year</th>
                                                <th>Price</th>
                                                <th>Mieleage</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                                <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrCars as $key => $value)
                                                    {
                                                        $status = $value['status'];
                                                        $sno = $key+1;
                                                        $category_name = $value['category_name'];
                                                        $model_name = $value['model_name'];
                                                        $car_name = $value['car_name'];
                                                        $year = $value['year'];
                                                        $price = $value['price'];
                                                        $mieleage = $value['mieleage'];
                                                        $enc_car_id = encrypt_decrypt($value['car_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $key+1;?></td>
                                                        <td><?php echo $category_name;?></td>
                                                        <td><?php echo $model_name;?></td>
                                                        <td><?php echo $car_name;?></td>
                                                        <td><?php echo $year;?></td>
                                                        <td><?php echo $price;?></td>
                                                        <td><?php echo $mieleage;?></td>
                                                        <td><?php echo $status;?></td>
                                                        <td><a href="edit_cars.php?id=<?php echo $enc_car_id;?>" class="btn-outline-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a></td>
                                                        <td>
                                                            <a href="javascript:void(0)" onclick="deleteCar('<?php echo  $enc_car_id;?>','<?php echo $car_name;?>')" class="btn-outline-secondary btn-sm" title="Delete"><i class="fas fa-trash"></i></a>
                                                            <span id='<?php echo $enc_car_id;?>' style='display: none;padding-left:1px;'>
                                                                <img src='images/spinner.gif'>
                                                            </span>
                                                        </td>
                                                        <td><a href="view_cars.php?id=<?php echo $enc_car_id;?>" class="btn-outline-light btn-sm" title="View"><i class="fa fa-eye"></i></a></td>
                                                <?php        
                                                    }
                                                ?>
                                            </tbody>
                                        </table>   
                                                


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
<script src="js/sweetalert.min.js"></script>
<script>
    $(function () {
        $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
        $('#ssFullscreen').on('click', function () {
            if (!document.fullscreenElement && document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
            else if (document.exitFullscreen) { document.exitFullscreen(); }
        });
        const carRows = $('#tbllistcars tbody tr').toArray();
        let currentCarPage = 1;
        const carPageSize = 10;
        function renderCarPage() {
            const query = $('#carSearch').val().toLowerCase();
            const category = $('#carCategoryFilter').val().toLowerCase();
            const filteredRows = carRows.filter(function (row) {
                const rowCategory = $(row).children('td').eq(1).text().trim().toLowerCase();
                return $(row).text().toLowerCase().indexOf(query) !== -1 && (!category || rowCategory === category);
            });
            const pageCount = Math.max(1, Math.ceil(filteredRows.length / carPageSize));
            currentCarPage = Math.min(currentCarPage, pageCount);
            carRows.forEach(function (row) { row.style.display = 'none'; });
            filteredRows.slice((currentCarPage - 1) * carPageSize, currentCarPage * carPageSize).forEach(function (row) { row.style.display = ''; });
            const firstEntry = filteredRows.length ? (currentCarPage - 1) * carPageSize + 1 : 0;
            const lastEntry = Math.min(currentCarPage * carPageSize, filteredRows.length);
            $('#carEntrySummary').text('Showing ' + firstEntry + ' to ' + lastEntry + ' of ' + filteredRows.length + ' entries');
            let pageButtons = '<button type="button" data-page="' + Math.max(1, currentCarPage - 1) + '" aria-label="Previous page"><i class="fas fa-chevron-left"></i></button>';
            for (let page = 1; page <= pageCount; page++) { pageButtons += '<button type="button" data-page="' + page + '" class="' + (page === currentCarPage ? 'is-current' : '') + '">' + page + '</button>'; }
            pageButtons += '<button type="button" data-page="' + Math.min(pageCount, currentCarPage + 1) + '" aria-label="Next page"><i class="fas fa-chevron-right"></i></button>';
            $('#carPagination').html(pageButtons);
        }
        $('#carSearch').on('input', function () { currentCarPage = 1; renderCarPage(); });
        $('#carCategoryFilter').on('change', function () { currentCarPage = 1; renderCarPage(); });
        $('#carPagination').on('click', 'button', function () { currentCarPage = Number($(this).data('page')); renderCarPage(); });
        renderCarPage();
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

        function deleteCar(enc_carID, carName) {
            console.log(carName);
            swal({
                title: "Confirmation",
                text: "Are You Sure You Want to Delete This Car '" + carName + "'?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {  
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "partial/delete_cars.php",
                        data: {enc_carID : enc_carID},
                        dataType: 'json',
                        beforeSend:function(){

                        },
                        success:function(ajaxResponse){
                            if(ajaxResponse.msg == 'Success'){
                                swal({
                                    title: "Success :)",
                                    text: ajaxResponse.msg_detail,
                                    icon: "success",
                                }).then(function() {
                                    location.reload();
                                });
                            }
                            else{
                                swal({
                                    title: "Error :|",
                                    text: ajaxResponse.msg_detail,
                                    icon: "error",
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: "Error!",
                                text: "An unexpected error occured. Please Try again Later",
                                icon: "error",
                            });
                        },
                        complete:function(res){

                        }
                    })
                }
            })
        }
</script>

</body>
</html>

