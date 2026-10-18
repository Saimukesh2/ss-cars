<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  $msg = isset($_GET['msg']) ? sanitize_input($_GET['msg'], 'textarea') : '';
 // print_r($_GET);
  //exit;
  if(!empty($_GET))
        {     
            $enc_category_id = sanitize_input($_GET['id'],'textarea');
            $category_id = encrypt_decrypt($enc_category_id,'decrypt');
            $arrCategory = getCategoryById($category_id);
            if(!empty($arrCategory))
            {
                $category_id = $arrCategory['category_id'];
                $category_name = $arrCategory['category_name'];
                $category_desc = $arrCategory['category_desc'];
                $category_status = $arrCategory['category_status'];
                $category_image = isset($arrCategory['category_image']) ? $arrCategory['category_image'] : '';
                if($category_status == 'Active')
                {
                    $active_checkbox = 'checked';
                    $inactive_checkbox = '';
                }
                else
                {
                    $active_checkbox = '';
                    $inactive_checkbox = 'checked';
                }
            }
            else{
                header("Location: category.php?msg=ERRCATEMPTY");
            }
        }
        else
        {
            header("Location:category.php");
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
  <style>
    /* Custom error message style */
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 18px;
    }
    .ss-category-content { padding: 0 24px; }
    .ss-dash-sidebar { width: 228px; }
    .ss-dash-main { margin-left: 228px; }
    .ss-dash-brand { height: 68px; }
    .ss-dash-topbar { height: 48px; }
    .ss-category-hero { height: 128px; position: relative; display: flex; align-items: center; overflow: hidden; margin: 0 -24px 16px; border-bottom: 1px solid #173b61; background: #071a2d url('images/dashboard-hero.png') right 42% / 57% auto no-repeat; }
    .ss-category-hero:before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(3, 13, 25, .98), rgba(3, 13, 25, .91) 35%, rgba(3, 13, 25, .25) 80%); }
    .ss-category-hero-copy { position: relative; z-index: 1; margin-left: 35px; }
    .ss-category-hero-copy > span { color: #08a8ff; font-size: 13px; font-weight: 600; letter-spacing: 3px; }
    .ss-category-hero-copy h1 { margin: 7px 0 4px; color: #f0f5fb; font-size: 28px; font-weight: 700; line-height: 1.1; }
    .ss-category-hero-copy h1 i { margin-right: 8px; color: #bdd8ef; font-size: 23px; }
    .ss-category-hero-copy p { margin: 0; color: #b8cde2; font-size: 16px; line-height: 1.25; }
    .ss-edit-panel { min-height: 390px; }
    .ss-edit-heading { min-height: 56px; padding: 0 12px; border-bottom: 1px solid #173653; }
    .ss-edit-heading h2 { margin: 0; color: #d8e3f1; font-size: 22px; font-weight: 600; }
    .ss-edit-heading h2 i { width: 30px; height: 30px; display: inline-grid; place-items: center; margin-right: 7px; border-radius: 9px; background: #0b3560; color: #53bdff; font-size: 18px; }
    .ss-back-link { display: inline-flex; align-items: center; gap: 7px; color: #52baff; font-size: 16px; }
    .ss-back-link:hover { color: #fff; }
    .ss-edit-form { max-width: 760px; display: grid; gap: 18px; padding: 25px 20px 30px; }
    .ss-edit-form > div { display: grid; gap: 7px; }
    .ss-edit-form label { color: #aac0d8; font-size: 16px !important; font-weight: 600 !important; }
    .ss-edit-form input[type=text], .ss-edit-form textarea { width: 100%; padding: 11px 13px; border: 1px solid #1a4267; border-radius: 7px; outline: 0; background: #07182b; color: #e3effc; font-size: 17px; }
    .ss-edit-form input[disabled] { color: #7891ab; background: #0a1e32; cursor: not-allowed; }
    .ss-edit-form textarea { resize: vertical; }
    .ss-edit-form input:focus, .ss-edit-form textarea:focus { border-color: #0c8df4; box-shadow: 0 0 0 2px rgba(12, 141, 244, .12); }
    .ss-edit-upload { gap: 8px !important; }
    .ss-edit-upload > label:first-child { margin-bottom: 1px; }
    .ss-category-file { position: relative; min-height: 76px; display: flex !important; align-items: center; gap: 13px; padding: 12px 14px; border: 1px dashed #24527b; border-radius: 9px; background: linear-gradient(110deg, rgba(9, 36, 62, .92), rgba(7, 24, 43, .96)); cursor: pointer; transition: border-color .18s ease, background .18s ease, box-shadow .18s ease; }
    .ss-category-file:hover, .ss-category-file:focus-within { border-color: #168df0; background: linear-gradient(110deg, rgba(10, 49, 83, .96), rgba(7, 27, 48, .98)); box-shadow: 0 0 0 3px rgba(11, 140, 255, .1); }
    .ss-category-file-input { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
    .ss-category-file-icon { width: 52px; height: 42px; flex: 0 0 52px; display: grid; place-items: center; overflow: hidden; border: 1px solid #1c4b75; border-radius: 8px; background: #0b2d4e; color: #53bdff; font-size: 21px; }
    .ss-category-file-icon img { width: 100%; height: 100%; object-fit: cover; }
    .ss-category-file-copy { min-width: 0; display: grid; gap: 4px; }
    .ss-category-file-copy strong { overflow: hidden; color: #dceafd; font-size: 16px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
    .ss-category-file-copy small { color: #829bb6; font-size: 14px; font-weight: 400; }
    .ss-category-file-button { min-height: 30px; display: inline-flex; align-items: center; gap: 7px; margin-left: auto; padding: 0 11px; border: 1px solid #1e5b8d; border-radius: 7px; background: #0b3155; color: #77c8ff; font-size: 14px; font-weight: 600; white-space: nowrap; }
    .ss-category-file:hover .ss-category-file-button, .ss-category-file:focus-within .ss-category-file-button { border-color: #168df0; background: #0d4170; color: #fff; }
    .ss-edit-status { display: flex; gap: 18px; }
    .ss-edit-status label { display: inline-flex; align-items: center; gap: 7px; font-weight: 400 !important; }
    .ss-edit-submit { width: max-content; min-height: 36px; padding: 0 19px; border: 0; border-radius: 8px; background: linear-gradient(180deg, #118eff, #0574e5); color: #fff; font-size: 16px; font-weight: 600; }
    .ss-edit-submit:hover { background: #1b9aff; }
    @media (max-width: 1180px) { .ss-dash-sidebar { width: 188px; } .ss-dash-main { margin-left: 188px; } }
    @media (max-width: 760px) { .ss-category-content { padding: 0 11px; } .ss-category-hero { margin-right: -11px; margin-left: -11px; background-size: cover, 90% auto; } .ss-category-hero-copy { margin-left: 24px; } .ss-edit-heading { align-items: flex-start; flex-direction: column; gap: 8px; padding: 12px; } .ss-edit-form { padding: 20px 10px; } }
    @media (max-width: 420px) { .ss-category-hero { height: 150px; } .ss-category-hero-copy { margin-left: 17px; } .ss-category-hero-copy h1 { font-size: 25px; } }
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
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiries</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-folder-open"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
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
            <section class="ss-category-hero"><div class="ss-category-hero-copy"><span>INVENTORY MANAGEMENT</span><h1><i class="fas fa-layer-group"></i> Edit Category</h1><p>Update your vehicle category details and keep your inventory organized.</p></div></section>
            <section class="ss-panel ss-edit-panel">
                <header class="ss-panel-heading ss-edit-heading"><h2><i class="fas fa-pen"></i> Edit Category</h2><a class="ss-back-link" href="category.php"><i class="fas fa-arrow-left"></i> Back to Category List</a></header>
                <form id="editCategoryForm" method="post" action="edit_category_validate.php" enctype="multipart/form-data" class="ss-edit-form">
                    <div><label for="editCategoryName">Category Name</label><input type="text" id="editCategoryName" disabled name="categoryName" required value="<?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?>"></div>
                    <div><label for="description">Category Description</label><textarea id="description" name="description" rows="5" placeholder="Enter description"><?php echo htmlspecialchars($category_desc, ENT_QUOTES, 'UTF-8'); ?></textarea></div>
                    <div class="ss-edit-upload"><label for="categoryImage">Category Image</label><label class="ss-category-file" for="categoryImage"><input class="ss-category-file-input" type="file" id="categoryImage" name="categoryImage" accept=".jpg,.jpeg,.png,image/jpeg,image/png" aria-describedby="categoryImageHint"><span class="ss-category-file-icon"><i class="far fa-image" aria-hidden="true" <?php echo $category_image !== '' ? 'hidden' : ''; ?>></i><img id="categoryImagePreview" src="<?php echo htmlspecialchars($category_image, ENT_QUOTES, 'UTF-8'); ?>" alt="" <?php echo $category_image === '' ? 'hidden' : ''; ?>></span><span class="ss-category-file-copy"><strong id="categoryImageName"><?php echo $category_image !== '' ? 'Current category image' : 'Choose an image for this category'; ?></strong><small id="categoryImageHint"><?php echo $category_image !== '' ? 'Select a new JPG, JPEG, or PNG image to replace it · Maximum 5 MB' : 'JPG, JPEG, or PNG · Maximum 5 MB'; ?></small></span><span class="ss-category-file-button"><i class="fas fa-folder-open" aria-hidden="true"></i> Browse</span></label></div>
                    <div><label>Status</label><div class="ss-edit-status"><label><input type="radio" name="status" value="Active" <?php if($category_status == 'Active') echo 'checked'; ?>> Active</label><label><input type="radio" name="status" value="Inactive" <?php if($category_status == 'Inactive') echo 'checked'; ?>> Inactive</label></div></div>
                    <input type="hidden" name="hdnCategoryID" value="<?php echo htmlspecialchars($enc_category_id, ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="submit" class="ss-edit-submit"><i class="fas fa-save"></i> Save Changes</button>
                </form>
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
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="category.php">Category List</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
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
                                <li class="nav-item"><a class="nav-link active" href="#" data-toggle="tab">Edit Category</a></li>
                                <li class="nav-item"><a class="nav-link" href="category.php"><i class="fa fa-fw fa-arrow-circle-left"></i>Back to Category List</a></li>    
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane active" id="editPage">
                                        <form id="addForm" method="post" action="edit_category_validate.php">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="categoryName">Category Name</label>
                                                    <input type="text" class="form-control" id="categoryName" disabled name="categoryName" required placeholder="Enter Category Name" value="<?php echo $category_name; ?>">
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="locationDesc">Category Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Desc"><?php echo $category_desc;?></textarea>
                                                </div>
                                            <div class="col-sm-12 form-group">
                                                    <label>Status</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusActive" value="Active" <?php if($category_status == 'Active') echo 'checked';?>>
                                                        <label class="form-check-label" for="statusActive">Active</label>
                                                    </div>
                                                    <div class="col-sm-12 form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusInactive" value="Inactive" <?php if($category_status == 'Inactive') echo 'checked';?>>
                                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="hdnCategoryID" value="<?php echo $enc_category_id?>">                                       
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

        // Add a custom method to check for blank spaces
        $.validator.addMethod("noBlank", function(value, element) {
            return this.optional(element) || $.trim(value).length > 0;
        }, "This field cannot be blank or filled with only spaces.");
        //Lets validate  this form for mandatory fields and input types
        // Initialize form validation on the addLocationForm form
        $("#editCategoryForm").validate({
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

        let categoryImagePreviewUrl = null;
        $('#categoryImage').on('change', function() {
            const file = this.files && this.files[0];
            const preview = document.getElementById('categoryImagePreview');
            const previewIcon = preview.previousElementSibling;

            if (categoryImagePreviewUrl) {
                URL.revokeObjectURL(categoryImagePreviewUrl);
                categoryImagePreviewUrl = null;
            }

            if (!file) {
                preview.src = <?php echo json_encode($category_image); ?>;
                preview.hidden = <?php echo $category_image === '' ? 'true' : 'false'; ?>;
                previewIcon.hidden = !preview.hidden;
                $('#categoryImageName').text(<?php echo json_encode($category_image !== '' ? 'Current category image' : 'Choose an image for this category'); ?>);
                $('#categoryImageHint').text(<?php echo json_encode($category_image !== '' ? 'Select a new JPG, JPEG, or PNG image to replace it · Maximum 5 MB' : 'JPG, JPEG, or PNG · Maximum 5 MB'); ?>);
                return;
            }

            $('#categoryImageName').text(file.name);
            $('#categoryImageHint').text((file.size / (1024 * 1024)).toFixed(2) + ' MB · Ready to upload');
            if (file.type === 'image/jpeg' || file.type === 'image/png') {
                categoryImagePreviewUrl = URL.createObjectURL(file);
                preview.src = categoryImagePreviewUrl;
                preview.hidden = false;
                previewIcon.hidden = true;
            } else {
                preview.hidden = true;
                previewIcon.hidden = false;
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
        $('#category_tab a[href="#' + value + '"]').tab('show');
        }
    });

</script>

</body>
</html>
