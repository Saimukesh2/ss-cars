<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
  $arrProductCat = getAllCategory();
  //print_r($arrProductCat);
  /* $a = "Hi";
  $b = "Sai";
  echo $a .' '. $b;
  exit;*/
        
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
  <style>
    /* Custom error message style */
    
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 14px; /* Set the font size to 10px */
    }
    .ss-category-content { padding-top: 0; }
    .ss-category-content { padding-right: 24px; padding-left: 24px; }
    .ss-category-content .ss-category-hero { margin-right: -24px; margin-left: -24px; }
    .ss-category-content ~ * { box-sizing: border-box; }
    .ss-dash-sidebar { width: 228px; }
    .ss-dash-main { margin-left: 228px; }
    .ss-dash-brand { height: 68px; }
    .ss-dash-topbar { height: 48px; }
    .ss-category-hero { height: 128px; position: relative; display: flex; align-items: center; overflow: hidden; margin: 0 -16px 16px; border-bottom: 1px solid #173b61; background: #071a2d url('images/dashboard-hero.png') right 42% / 57% auto no-repeat; }
    .ss-category-hero:before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(3, 13, 25, .98) 0%, rgba(3, 13, 25, .91) 35%, rgba(3, 13, 25, .25) 80%); }
    .ss-category-hero-copy { position: relative; z-index: 1; margin-left: 35px; }
    .ss-category-hero-copy > span { color: #08a8ff; font-size: 9px; font-weight: 600; letter-spacing: 3px; }
    .ss-category-hero-copy h1 { margin: 7px 0 4px; color: #f0f5fb; font-size: 24px; font-weight: 700; line-height: 1.1; }
    .ss-category-hero-copy h1 i { margin-right: 8px; color: #bdd8ef; font-size: 19px; }
    .ss-category-hero-copy p { margin: 0; color: #b8cde2; font-size: 12px; line-height: 1.25; }
    .ss-category-panel { margin-bottom: 12px; }
    .ss-category-heading { min-height: 56px; padding: 0 12px; border-bottom: 1px solid #173653; }
    .ss-category-heading h2 { font-size: 18px; }
    .ss-category-heading h2 i { width: 30px; height: 30px; display: inline-grid; place-items: center; margin-right: 7px; border-radius: 9px; background: #0b3560; color: #53bdff; font-size: 14px; }
    .ss-category-tools { display: flex; align-items: center; gap: 12px; }
    .ss-category-search { width: 202px; height: 34px; display: flex; align-items: center; gap: 9px; padding: 0 11px; border: 1px solid #15395c; border-radius: 9px; background: #07182b; color: #4cbaff; }
    .ss-category-search input { width: 100%; border: 0; outline: 0; background: transparent; color: #dceafd; font-size: 11px; }
    .ss-category-search input::placeholder { color: #7890ab; }
    .ss-add-category { display: inline-flex; align-items: center; gap: 8px; min-height: 34px; padding: 0 15px; border: 0; border-radius: 8px; background: linear-gradient(180deg, #118eff, #0574e5); color: #fff; font-size: 12px; font-weight: 600; white-space: nowrap; }
    .ss-add-category:hover { color: #fff; background: #1b9aff; }
    .ss-category-tabs { padding: 0 10px 10px; }
    .ss-category-table-wrap { overflow-x: auto; }
    .ss-category-table { width: 100%; min-width: 760px; border-collapse: separate; border-spacing: 0; color: #c8d8eb; font-size: 11px; table-layout: fixed; }
    .ss-category-table th { height: 38px; padding: 0 10px; border-bottom: 1px solid #184163; background: #0a2038; color: #a9c0db; font-size: 11px; font-weight: 600; text-align: left; }
    .ss-category-table th:first-child { width: 48px; border-radius: 8px 0 0 8px; }
    .ss-category-table th:nth-child(2) { width: 24%; }
    .ss-category-table th:nth-child(3) { width: 42%; }
    .ss-category-table th:nth-child(4) { width: 12%; }
    .ss-category-table th:nth-child(5), .ss-category-table th:nth-child(6) { width: 52px; }
    .ss-category-table td { height: 80px; padding: 8px 10px; border-bottom: 1px solid rgba(52, 93, 131, .32); vertical-align: middle; line-height: 1.25; }
    .ss-category-table tbody tr:hover td { background: rgba(10, 57, 94, .25); }
    .ss-category-name { display: flex; align-items: center; gap: 12px; }
    .ss-category-name img { width: 110px; height: 50px; flex: 0 0 110px; object-fit: cover; border: 1px solid #214e78; border-radius: 9px; }
    .ss-category-name strong { color: #cbdced; font-size: 12px; font-weight: 600; }
    .ss-status { display: inline-block; min-width: 55px; padding: 6px 10px; border-radius: 14px; color: #00dfc2; background: #063c48; font-size: 10px; font-weight: 600; text-align: center; }
    .ss-status.is-inactive { color: #f2b66f; background: #483019; }
    .ss-row-action { width: 29px; height: 29px; display: inline-grid; place-items: center; border-radius: 50%; font-size: 12px; }
    .ss-edit-action { color: #078cff; background: #0a3159; }
    .ss-delete-action { color: #ff3e55; background: #331b33; }
    .ss-row-action:hover { color: #fff; filter: brightness(1.25); }
    .ss-spinner { display: none; }
    .ss-category-footer { display: flex; align-items: center; justify-content: space-between; min-height: 39px; color: #8da4be; font-size: 10px; }
    .ss-pagination { display: flex; gap: 4px; }
    .ss-pagination button { width: 31px; height: 30px; border: 1px solid #173a5e; border-radius: 8px; background: #071b31; color: #8eabc8; }
    .ss-pagination button.is-current { border-color: #0b8cff; background: #087df0; color: #fff; }
    .ss-category-form { display: grid; gap: 16px; padding: 20px 8px; color: #bdd0e6; }
    .ss-category-form > div { display: grid; gap: 6px; }
    .ss-category-form label { color: #aac0d8; font-size: 12px !important; }
    .ss-category-form input[type=text], .ss-category-form textarea { width: 100%; padding: 10px 12px; border: 1px solid #1a4267; border-radius: 7px; outline: 0; background: #07182b; color: #e3effc; }
    .ss-radio { display: inline-flex !important; align-items: center; gap: 6px; margin-right: 14px; }
    .ss-category-form .ss-add-category { width: max-content; }
    .ss-category-tabs .tab-pane:not(.active) { display: none; }
    .ss-nav-group > a.is-current { color: #4cbaff; }
    @media (max-width: 1180px) { .ss-dash-sidebar { width: 188px; } .ss-dash-main { margin-left: 188px; } }
    @media (max-width: 760px) { .ss-category-content { padding-right: 11px; padding-left: 11px; } .ss-category-hero { margin-right: -11px !important; margin-left: -11px !important; background-size: cover, 90% auto; } .ss-category-hero-copy { margin-left: 24px; } .ss-category-heading { align-items: flex-start; flex-direction: column; gap: 10px; padding: 12px; } .ss-category-tools { width: 100%; } .ss-category-search { flex: 1; } }
    @media (max-width: 420px) { .ss-category-hero { height: 150px; } .ss-category-hero-copy { margin-left: 17px; } .ss-category-hero-copy h1 { font-size: 21px; } .ss-category-tools { gap: 7px; } .ss-add-category { padding: 0 10px; } }
    </style>
</head>
<body class="hold-transition ss-dash-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group" open>
                <summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a class="is-current" href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Cars</a><a href="employee.php">Employees</a><a href="customer.php">Customers</a>
            </details>
            <details class="ss-nav-group">
                <summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="enquiry.php">Enquiries</a><a href="sales.php">Sales</a><a href="service.php">Service</a>
            </details>
            <details class="ss-nav-group">
                <summary class="ss-nav-link"><i class="fas fa-folder-open"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="revenue_report.php">Revenue Report</a>
            </details>
            <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </nav>
        <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
    </aside>

    <main class="ss-dash-main">
        <header class="ss-dash-topbar">
            <button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
            <label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label>
            <div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div>
        </header>

        <section class="ss-dash-content ss-category-content">
            <?php if($msg != '') { ?><div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg,0,3) == 'SUC' ? 'alert-success' : 'alert-warning'; ?>"><button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo getMessage($msg); ?></div><?php } ?>
            <section class="ss-category-hero"><div class="ss-category-hero-copy"><span>INVENTORY MANAGEMENT</span><h1><i class="fas fa-layer-group"></i> Category Management</h1><p>Manage your vehicle categories, keep your inventory organized<br>and running smoothly.</p></div></section>

            <section class="ss-panel ss-category-panel">
                <header class="ss-panel-heading ss-category-heading"><h2><i class="fas fa-car"></i> Category List</h2><div class="ss-category-tools"><label class="ss-category-search"><i class="fas fa-search"></i><input id="categorySearch" type="search" placeholder="Search category..." aria-label="Search category"></label><a class="ss-add-category" href="#addPage" data-toggle="tab"><i class="fas fa-plus"></i> Add Category</a></div></header>
                <div class="ss-category-tabs"><div class="tab-content">
                    <div class="tab-pane" id="addPage"><form id="addForm" method="post" action="category_validate.php" class="ss-category-form"><div><label for="categoryName">Category Name</label><input type="text" id="categoryName" name="categoryName" required placeholder="Enter Category Name"></div><div><label for="description">Category Description</label><textarea id="description" name="description" rows="3" placeholder="Enter description"></textarea></div><div><label>Status</label><label class="ss-radio"><input type="radio" name="status" value="Active"> Active</label><label class="ss-radio"><input type="radio" name="status" checked value="Inactive"> Inactive</label></div><button type="submit" class="ss-add-category">Save Category</button></form></div>
                    <div class="tab-pane active" id="listCat"><div class="ss-category-table-wrap"><table id="tbllistCat" class="ss-category-table"><thead><tr><th>S.No</th><th>Category Name</th><th>Category Description</th><th>Category Status</th><th>Edit</th><th>Delete</th></tr></thead><tbody>
                        <?php foreach($arrProductCat as $key => $value) { $category_status = $value['category_status']; $category_name = $value['category_name']; $category_desc = $value['category_desc']; $enc_category_id = encrypt_decrypt($value['category_id']); $category_image = array('images/dashboard-car-front.jpg', 'images/dashboard-car-city.jpg', 'images/dashboard-car-rear.jpg')[$key % 3]; ?>
                        <tr><td><?php echo $key + 1; ?></td><td><div class="ss-category-name"><img src="<?php echo $category_image; ?>" alt="<?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?>"><strong><?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?></strong></div></td><td><?php echo htmlspecialchars($category_desc, ENT_QUOTES, 'UTF-8'); ?></td><td><span class="ss-status <?php echo strtolower($category_status) == 'active' ? 'is-active' : 'is-inactive'; ?>"><?php echo htmlspecialchars($category_status, ENT_QUOTES, 'UTF-8'); ?></span></td><td><a href="edit_category.php?id=<?php echo $enc_category_id; ?>" class="ss-row-action ss-edit-action" title="Edit"><i class="fas fa-pen"></i></a></td><td><a href="javascript:void(0)" onclick="deleteCat('<?php echo $enc_category_id; ?>','<?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?>')" class="ss-row-action ss-delete-action" title="Delete"><i class="fas fa-trash"></i></a><span id="<?php echo $enc_category_id; ?>" class="ss-spinner"><img src="images/spinner.gif" alt=""></span></td></tr>
                        <?php } ?>
                    </tbody></table></div><div class="ss-category-footer"><span>Showing 1 to <?php echo count($arrProductCat); ?> of <?php echo count($arrProductCat); ?> entries</span><span class="ss-pagination"><button type="button" aria-label="Previous page"><i class="fas fa-chevron-left"></i></button><button type="button" class="is-current">1</button><button type="button" aria-label="Next page"><i class="fas fa-chevron-right"></i></button></span></div></div>
                </div></div>
            </section>
            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>
<?php if (false) { ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="category.php">Category List</a></li>
                        <li class="breadcrumb-item active">Add New Category</li>
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
                        <!-- Display Response messages here --->
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
                                <ul id="category_tab" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#listCat" data-toggle="tab" >Category List </a></li>
                                    <li class="nav-item"><a class="nav-link" href="#addPage" data-toggle="tab">Add Category</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane" id="addPage">
                                        <form id="addForm" method="post" action="category_validate.php">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="categoryName">Category Name</label>
                                                    <input type="text" class="form-control" id="categoryName" name="categoryName" required placeholder="Enter Category Name">
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="categoryDesc">Category Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Desc"></textarea>
                                                </div>
                                            <div class="col-sm-12 form-group">
                                                    <label>Status</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusActive" value="Active">
                                                        <label class="form-check-label" for="statusActive">Active</label>
                                                    </div>
                                                    <div class="col-sm-12 form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusInactive" checked value="Inactive">
                                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                                    </div>
                                                </div>                                       
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                           
                                            </div>
                                        </form>
                                    </div>
                                
                                    <!-- Second tab -->
                                    <div class="tab-pane active" id="listCat">
                                        <table id="tbllistCat" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                <th>S.NO.</th>
                                                <th>Category Name</th>
                                                <th>Category Description</th>
                                                <th>Category Status </th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                                    foreach($arrProductCat as $key => $value)
                                                    {
                                                        $category_status = $value['category_status'];
                                                        $sno = $key+1;
                                                        $category_name = $value['category_name'];
                                                        $category_desc = $value['category_desc'];
                                                        $enc_category_id = encrypt_decrypt($value['category_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $key+1;?></td>
                                                        <td><?php echo $category_name;?></td>
                                                        <td><?php echo $category_desc;?></td>
                                                        <td><?php echo $category_status;?></td>
                                                        <td><a href="edit_category.php?id=<?php echo $enc_category_id;?>" class="btn-outline-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a></td>
                                                        <td>
                                                            <a href="javascript:void(0)" onclick="deleteCat('<?php echo  $enc_category_id;?>','<?php echo $category_name;?>')" class="btn-outline-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
                                                            <span id='<?php echo $enc_category_id;?>' style='display: none;padding-left:1px;'>
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
        $('#categorySearch').on('input', function () {
            const query = $(this).val().toLowerCase();
            $('#tbllistCat tbody tr').each(function () { $(this).toggle($(this).text().toLowerCase().indexOf(query) !== -1); });
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
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
            },
            messages: {
                categoryName: {
                    required: "Please enter a category name",
                    minlength: "Your category name must be at least 3 characters long"
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
        if(value != null) { $('a[href="#' + value + '"]').tab('show'); }
    });

    function deleteCat(enc_categoryID,categoryName) {
        console.log(categoryName);
        swal({
            title: "Confirmation",
            text: "Are You Sure You Want To Delete This Category '"+ categoryName +"'?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if(willDelete){
                $.ajax({
                    type: "POST",
                    url: "partial/delete_category.php",
                    data: {enc_categoryID : enc_categoryID},
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
                            title: 'Error!',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                        });
                    },
                    complete:function(res){
                        
                    }
                });
                
            }
        })
    }

</script>

</body>
</html>

