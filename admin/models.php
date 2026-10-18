<?php
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  $msg = isset($_GET['msg']) ? $_GET['msg'] : '';
  $arrProductCat = getAllActiveCategory();
  $arrModels = getAllModels();
  //
  //9print_r($count);
  //exit;


/*foreach($arrProductCat as $key => $value)
{
    print_r($value);
    echo "End of Row<br>";
}

exit;*/
//print_r($arrProductCat); check the array has all the values
//exit;

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
    .ss-model-content { padding: 0 24px; }
    .ss-dash-sidebar { width: 228px; }
    .ss-dash-main { margin-left: 228px; }
    .ss-dash-brand { height: 68px; }
    .ss-dash-topbar { height: 48px; }
    .ss-model-hero { height: 128px; position: relative; display: flex; align-items: center; overflow: hidden; margin: 0 -24px 16px; border-bottom: 1px solid #173b61; background: #071a2d url('images/dashboard-hero.png') right 42% / 57% auto no-repeat; }
    .ss-model-hero:before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(3, 13, 25, .98), rgba(3, 13, 25, .91) 35%, rgba(3, 13, 25, .25) 80%); }
    .ss-model-hero-copy { position: relative; z-index: 1; margin-left: 35px; }
    .ss-model-hero-copy > span { color: #08a8ff; font-size: 13px; font-weight: 600; letter-spacing: 3px; }
    .ss-model-hero-copy h1 { margin: 7px 0 4px; color: #f0f5fb; font-size: 28px; font-weight: 700; line-height: 1.1; }
    .ss-model-hero-copy h1 i { margin-right: 8px; color: #bdd8ef; font-size: 23px; }
    .ss-model-hero-copy p { margin: 0; color: #b8cde2; font-size: 16px; line-height: 1.25; }
    .ss-model-panel { margin-bottom: 12px; }
    .ss-model-heading { min-height: 56px; padding: 0 12px; border-bottom: 1px solid #173653; }
    .ss-model-heading h2 { font-size: 22px; }
    .ss-model-heading h2 i { width: 30px; height: 30px; display: inline-grid; place-items: center; margin-right: 7px; border-radius: 9px; background: #0b3560; color: #53bdff; font-size: 18px; }
    .ss-model-tools { display: flex; align-items: center; gap: 12px; }
    .ss-model-search { width: 245px; height: 34px; display: flex; align-items: center; gap: 9px; padding: 0 11px; border: 1px solid #15395c; border-radius: 9px; background: #07182b; color: #4cbaff; }
    .ss-model-search input { width: 100%; border: 0; outline: 0; background: transparent; color: #dceafd; font-size: 15px; }
    .ss-model-search input::placeholder { color: #7890ab; }
    .ss-add-model { display: inline-flex; align-items: center; gap: 8px; min-height: 34px; padding: 0 15px; border: 0; border-radius: 8px; background: linear-gradient(180deg, #118eff, #0574e5); color: #fff; font-size: 16px; font-weight: 600; white-space: nowrap; }
    .ss-add-model:hover { color: #fff; background: #1b9aff; }
    .ss-model-tabs { padding: 0 10px 10px; }
    .ss-model-table-wrap { overflow-x: auto; }
    .ss-model-table { width: 100%; min-width: 940px; border-collapse: separate; border-spacing: 0; color: #c8d8eb; font-size: 14px; table-layout: fixed; }
    .ss-model-table th { height: 36px; padding: 0 10px; border-bottom: 1px solid #184163; background: #0a2038; color: #a9c0db; font-size: 14px; font-weight: 600; text-align: left; text-transform: uppercase; }
    .ss-model-table th:first-child { width: 48px; border-radius: 8px 0 0 8px; }
    .ss-model-table th:nth-child(2) { width: 20%; }
    .ss-model-table th:nth-child(3) { width: 17%; }
    .ss-model-table th:nth-child(4) { width: 27%; }
    .ss-model-table th:nth-child(5) { width: 13%; }
    .ss-model-table th:nth-child(6), .ss-model-table th:nth-child(7), .ss-model-table th:nth-child(8) { width: 46px; }
    .ss-model-table td { height: 41px; padding: 5px 10px; border-bottom: 1px solid rgba(52, 93, 131, .32); vertical-align: middle; line-height: 1.15; }
    .ss-model-table tbody tr:hover td { background: rgba(10, 57, 94, .25); }
    .ss-model-category { display: inline-block; padding: 5px 9px; border-radius: 12px; background: #07517a; color: #9bdcff; font-size: 13px; white-space: nowrap; }
    .ss-model-category:nth-child(2n) { background: #3d216f; color: #d6b4ff; }
    .ss-model-category.category-hatchback { background: #714018; color: #ffd08c; }
    .ss-model-category.category-pickup { background: #7c1829; color: #ff9cab; }
    .ss-model-name { display: flex; align-items: center; gap: 10px; }
    .ss-model-name img { width: 75px; height: 31px; flex: 0 0 75px; object-fit: cover; border-radius: 6px; border: 1px solid #214e78; }
    .ss-model-name strong { display: block; color: #d6e5f5; font-size: 15px; font-weight: 600; }
    .ss-model-name small { display: block; margin-top: 2px; color: #849bb5; font-size: 13px; }
    .ss-model-status { display: inline-flex; align-items: center; gap: 5px; padding: 5px 9px; border-radius: 13px; background: #063c35; color: #00dfb7; font-size: 13px; font-weight: 600; }
    .ss-model-status:before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    .ss-model-status.is-inactive { background: #483019; color: #f2b66f; }
    .ss-model-action { width: 27px; height: 27px; display: inline-grid; place-items: center; border: 1px solid #087dd2; border-radius: 6px; background: #092c50; color: #1a9bff; font-size: 14px; }
    .ss-model-delete { border-color: #76233c; background: #3a142b; color: #ff3d5b; }
    .ss-model-action:hover { color: #fff; filter: brightness(1.25); }
    .ss-model-view { border-color: #167b8b; background: #073746; color: #4dd7e8; }
    .ss-model-footer { display: flex; align-items: center; justify-content: space-between; min-height: 39px; color: #8da4be; font-size: 14px; }
    .ss-model-pagination { display: flex; gap: 4px; }
    .ss-model-pagination button { width: 28px; height: 28px; border: 1px solid #173a5e; border-radius: 6px; background: #071b31; color: #8eabc8; font-size: 14px; }
    .ss-model-pagination button.is-current { border-color: #0b8cff; background: #087df0; color: #fff; }
    .ss-model-form { max-width: 760px; display: grid; gap: 16px; padding: 20px 8px; color: #bdd0e6; }
    .ss-model-form > div { display: grid; gap: 6px; }
    .ss-model-form label { color: #aac0d8; font-size: 16px !important; }
    .ss-model-form select, .ss-model-form input[type=text], .ss-model-form textarea { width: 100%; padding: 10px 12px; border: 1px solid #1a4267; border-radius: 7px; outline: 0; background: #07182b; color: #e3effc; }
    .ss-model-upload { gap: 8px !important; }
    .ss-model-upload > label:first-child { margin-bottom: 1px; }
    .ss-model-file { position: relative; min-height: 76px; display: flex !important; align-items: center; gap: 13px; padding: 12px 14px; border: 1px dashed #24527b; border-radius: 9px; background: linear-gradient(110deg, rgba(9, 36, 62, .92), rgba(7, 24, 43, .96)); cursor: pointer; transition: border-color .18s ease, background .18s ease, box-shadow .18s ease; }
    .ss-model-file:hover, .ss-model-file:focus-within { border-color: #168df0; background: linear-gradient(110deg, rgba(10, 49, 83, .96), rgba(7, 27, 48, .98)); box-shadow: 0 0 0 3px rgba(11, 140, 255, .1); }
    .ss-model-file-input { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
    .ss-model-file-icon { width: 42px; height: 42px; flex: 0 0 42px; display: grid; place-items: center; overflow: hidden; border: 1px solid #1c4b75; border-radius: 8px; background: #0b2d4e; color: #53bdff; font-size: 21px; }
    .ss-model-file-icon img { width: 100%; height: 100%; object-fit: cover; }
    .ss-model-file-copy { min-width: 0; display: grid; gap: 4px; }
    .ss-model-file-copy strong { overflow: hidden; color: #dceafd; font-size: 16px; font-weight: 600; text-overflow: ellipsis; white-space: nowrap; }
    .ss-model-file-copy small { color: #829bb6; font-size: 14px; font-weight: 400; }
    .ss-model-file-button { min-height: 30px; display: inline-flex; align-items: center; gap: 7px; margin-left: auto; padding: 0 11px; border: 1px solid #1e5b8d; border-radius: 7px; background: #0b3155; color: #77c8ff; font-size: 14px; font-weight: 600; white-space: nowrap; }
    .ss-model-file:hover .ss-model-file-button, .ss-model-file:focus-within .ss-model-file-button { border-color: #168df0; background: #0d4170; color: #fff; }
    .ss-model-form .ss-model-actions { display: flex; grid-auto-flow: column; grid-auto-columns: max-content; justify-content: start; align-items: center; gap: 10px; }
    .ss-model-back { min-height: 34px; display: inline-flex; align-items: center; gap: 7px; padding: 0 13px; border: 1px solid #1a4267; border-radius: 8px; background: #0a2038; color: #a9c7e4; font-size: 15px; font-weight: 600; transition: border-color .18s ease, background .18s ease, color .18s ease; }
    .ss-model-back:hover, .ss-model-back:focus { border-color: #168df0; background: #0b3155; color: #fff; }
    .ss-model-radio { display: inline-flex !important; align-items: center; gap: 6px; margin-right: 14px; }
    .ss-model-form .ss-add-model { width: max-content; }
    .ss-model-tabs .tab-pane:not(.active) { display: none; }
    .ss-nav-group > a.is-current { color: #4cbaff; }
    @media (max-width: 1180px) { .ss-dash-sidebar { width: 188px; } .ss-dash-main { margin-left: 188px; } }
    @media (max-width: 760px) { .ss-model-content { padding: 0 11px; } .ss-model-hero { margin-right: -11px; margin-left: -11px; background-size: cover, 90% auto; } .ss-model-hero-copy { margin-left: 24px; } .ss-model-heading { align-items: flex-start; flex-direction: column; gap: 10px; padding: 12px; } .ss-model-tools { width: 100%; } .ss-model-search { flex: 1; } }
    @media (max-width: 420px) { .ss-model-hero { height: 150px; } .ss-model-hero-copy { margin-left: 17px; } .ss-model-hero-copy h1 { font-size: 25px; } }
    </style>
</head>
<body class="hold-transition ss-dash-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a class="is-current" href="models.php">Models</a><a href="cars.php">Cars</a><a href="employee.php">Employees</a><a href="customer.php">Customers</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiries</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details>
            <details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-folder-open"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details>
            <a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
        </nav>
        <div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div>
    </aside>

    <main class="ss-dash-main">
        <header class="ss-dash-topbar"><button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button><label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label><div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div></header>

        <section class="ss-dash-content ss-model-content">
            <?php if($msg != '') { ?><div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg,0,3) == 'SUC' ? 'alert-success' : 'alert-warning'; ?>"><button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo getMessage($msg); ?></div><?php } ?>
            <section class="ss-model-hero"><div class="ss-model-hero-copy"><span>INVENTORY MANAGEMENT</span><h1><i class="fas fa-car"></i> Models</h1><p>Manage your car models, keep your inventory organized<br>and running smoothly.</p></div></section>
            <section class="ss-panel ss-model-panel">
                <header class="ss-panel-heading ss-model-heading"><h2><i class="fas fa-car"></i> Models</h2><div class="ss-model-tools"><label class="ss-model-search"><i class="fas fa-search"></i><input id="modelSearch" type="search" placeholder="Search models..." aria-label="Search models"></label><a class="ss-add-model" href="#addmodel"><i class="fas fa-plus"></i> Add Model</a></div></header>
                <div class="ss-model-tabs"><div class="tab-content">
                    <div class="tab-pane" id="addmodel"><form id="addForm" method="post" action="models_validate.php" enctype="multipart/form-data" class="ss-model-form"><div><label for="category_id">Select Category Name</label><select id="category_id" name="category_id" required><option value="">Select Category Name</option><?php foreach($arrProductCat as $value) { ?><option value="<?php echo $value['category_id']; ?>"><?php echo htmlspecialchars($value['category_name'], ENT_QUOTES, 'UTF-8'); ?></option><?php } ?></select></div><div><label for="modelName">Model Name</label><input type="text" id="modelName" name="modelName" required placeholder="Enter Model Name"></div><div><label for="description">Model Description</label><textarea id="description" name="description" rows="4" placeholder="Enter description"></textarea></div><div class="ss-model-upload"><label for="modelImage">Model Image</label><label class="ss-model-file" for="modelImage"><input class="ss-model-file-input" type="file" id="modelImage" name="modelImage" accept=".jpg,.jpeg,.png,image/jpeg,image/png" aria-describedby="modelImageHint"><span class="ss-model-file-icon"><i class="far fa-image" aria-hidden="true"></i><img id="modelImagePreview" alt="" hidden></span><span class="ss-model-file-copy"><strong id="modelImageName">Choose an image for this model</strong><small id="modelImageHint">JPG, JPEG, or PNG · Maximum 5 MB</small></span><span class="ss-model-file-button"><i class="fas fa-folder-open" aria-hidden="true"></i> Browse</span></label></div><div><label>Status</label><label class="ss-model-radio"><input type="radio" name="status" checked value="Active"> Active</label><label class="ss-model-radio"><input type="radio" name="status" value="Inactive"> Inactive</label></div><div class="ss-model-actions"><a class="ss-model-back" href="#listmodel"><i class="fas fa-arrow-left" aria-hidden="true"></i> Back to Models List</a><button type="submit" class="ss-add-model">Save Model</button></div></form></div>
                    <div class="tab-pane active" id="listmodel"><div class="ss-model-table-wrap"><table id="tbllistmodel" class="ss-model-table"><thead><tr><th>S.No</th><th>Category Name</th><th>Model Name</th><th>Model Description</th><th>Model Status</th><th>Edit</th><th>Delete</th></tr></thead><tbody>
                        <?php foreach($arrModels as $key => $value) { $model_status = $value['model_status']; $category_name = $value['category_name']; $model_name = $value['model_name']; $model_description = $value['model_desc']; $enc_model_id = encrypt_decrypt($value['model_id']); $category_class = 'category-' . strtolower(str_replace(' ', '-', $category_name)); $model_image = !empty($value['model_image']) ? $value['model_image'] : array('images/dashboard-car-front.jpg', 'images/dashboard-car-city.jpg', 'images/dashboard-car-rear.jpg')[$key % 3]; ?>
                        <tr><td><?php echo $key + 1; ?></td><td><span class="ss-model-category <?php echo htmlspecialchars($category_class, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?></span></td><td><div class="ss-model-name"><img src="<?php echo htmlspecialchars($model_image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($model_name, ENT_QUOTES, 'UTF-8'); ?>"><span><strong><?php echo htmlspecialchars($model_name, ENT_QUOTES, 'UTF-8'); ?></strong><small><?php echo htmlspecialchars($category_name, ENT_QUOTES, 'UTF-8'); ?></small></span></div></td><td><?php echo htmlspecialchars($model_description ?: '-', ENT_QUOTES, 'UTF-8'); ?></td><td><span class="ss-model-status <?php echo strtolower($model_status) == 'active' ? '' : 'is-inactive'; ?>"><?php echo htmlspecialchars($model_status, ENT_QUOTES, 'UTF-8'); ?></span></td><td><a href="edit_models.php?id=<?php echo rawurlencode($enc_model_id); ?>" class="ss-model-action" title="Edit"><i class="fas fa-pen"></i></a></td><td><a href="javascript:void(0)" onclick="deleteModel('<?php echo htmlspecialchars($enc_model_id, ENT_QUOTES, 'UTF-8'); ?>','<?php echo htmlspecialchars($model_name, ENT_QUOTES, 'UTF-8'); ?>')" class="ss-model-action ss-model-delete" title="Delete"><i class="fas fa-trash"></i></a><span id="<?php echo htmlspecialchars($enc_model_id, ENT_QUOTES, 'UTF-8'); ?>" style="display:none"><img src="images/spinner.gif" alt=""></span></td></tr>
                        <?php } ?>
                    </tbody></table></div><div class="ss-model-footer"><span id="modelEntrySummary"></span><span class="ss-model-pagination" id="modelPagination"></span></div></div>
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
                    <h1>Models</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="models.php">Models List</a></li>
                        <li class="breadcrumb-item active">Add New Model</li>
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
                                <ul id="models_tab" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#listmodel" data-toggle="tab" >Model List </a></li>
                                    <li class="nav-item"><a class="nav-link" href="#addmodel" data-toggle="tab">Add Model</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane" id="addmodel">
                                        <form id="addForm" method="post" action="models_validate.php">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="category_id">Select Category Name</label>
                                                    <select class="form-control" id="category_id"  name="category_id" required>
                                                        <option value="">Select  Category Name</option>
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
                                                    <label for="modelName">Model Name</label>
                                                    <input type="text" class="form-control" id="modelName" name="modelName" required placeholder="Enter Model Name" value="<?php echo isset($arrData['model_name']) ? $arrData['model_name'] : ''; ?>">
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="modelDesc">Model Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter Desc"><?php echo isset($arrData['description']) ? $arrData['description'] : ''; ?></textarea>
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label>Status</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusActive"  checked value="Active">
                                                        <label class="form-check-label" for="statusActive">Active</label>
                                                    </div>
                                                    <div class="col-sm-12 form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusInactive" value="Inactive">
                                                        <label class="form-check-label" for="statusInactive">Inactive</label>
                                                    </div>
                                                </div>                                       
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                           
                                            </div>
                                        </form>
                                    </div>
                                
                                    <!-- Second tab -->
                                    <div class="tab-pane active" id="listmodel">
                                        <table id="tbllistmodel" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                <th>S.NO.</th>
                                                <th>Category Name</th>
                                                <th>Model Name</th>
                                                <th>Model Description</th>
                                                <th>Model Status </th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrModels as $key => $value)
                                                    {
                                                        //echo $value['model_name'];
                                                        $model_status = $value['model_status'];
                                                        $sno = $key+1;
                                                        $category_name = $value['category_name'];
                                                        $model_name = $value['model_name'];
                                                        $model_description = $value['model_desc'];
                                                        $enc_model_id = encrypt_decrypt($value['model_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $key+1; ?></td>
                                                        <td><?php echo $category_name; ?></td>
                                                        <td><?php echo $model_name; ?></td>
                                                        <td><?php echo $model_description; ?></td>
                                                        <td><?php echo $model_status; ?></td>
                                                        <td><a href="edit_models.php?id=<?php echo $enc_model_id;?>" class="btn-outline-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a></td>
                                                        <td>
                                                            <a href="javascript:void(0)" onclick="deleteModel('<?php echo  $enc_model_id;?>','<?php echo $model_name;?>')" class="btn-outline-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></a>
                                                            <span id='<?php echo $enc_model_id;?>' style='display: none;padding-left:1px;'>
                                                                <img src='images/spinner.gif'>
                                                            </span>
                                                        </td>
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
        const modelRows = $('#tbllistmodel tbody tr').toArray();
        let currentModelPage = 1;
        const modelPageSize = 10;
        function renderModelPage() {
            const query = $('#modelSearch').val().toLowerCase();
            const filteredRows = modelRows.filter(function (row) {
                return $(row).text().toLowerCase().indexOf(query) !== -1;
            });
            const pageCount = Math.max(1, Math.ceil(filteredRows.length / modelPageSize));
            currentModelPage = Math.min(currentModelPage, pageCount);
            modelRows.forEach(function (row) { row.style.display = 'none'; });
            filteredRows.slice((currentModelPage - 1) * modelPageSize, currentModelPage * modelPageSize).forEach(function (row) { row.style.display = ''; });

            const firstEntry = filteredRows.length ? (currentModelPage - 1) * modelPageSize + 1 : 0;
            const lastEntry = Math.min(currentModelPage * modelPageSize, filteredRows.length);
            $('#modelEntrySummary').text('Showing ' + firstEntry + ' to ' + lastEntry + ' of ' + filteredRows.length + ' entries');

            let pageButtons = '<button type="button" data-page="' + Math.max(1, currentModelPage - 1) + '" aria-label="Previous page" ' + (currentModelPage === 1 ? 'disabled' : '') + '><i class="fas fa-chevron-left"></i></button>';
            for (let page = 1; page <= pageCount; page++) {
                pageButtons += '<button type="button" data-page="' + page + '" class="' + (page === currentModelPage ? 'is-current' : '') + '">' + page + '</button>';
            }
            pageButtons += '<button type="button" data-page="' + Math.min(pageCount, currentModelPage + 1) + '" aria-label="Next page" ' + (currentModelPage === pageCount ? 'disabled' : '') + '><i class="fas fa-chevron-right"></i></button>';
            $('#modelPagination').html(pageButtons);
        }
        $('#modelSearch').on('input', function () { currentModelPage = 1; renderModelPage(); });
        $('#modelPagination').on('click', 'button:not(:disabled)', function () { currentModelPage = Number($(this).data('page')); renderModelPage(); });
        renderModelPage();

        function showModelTab(tabId) {
            if (tabId === 'listMod' || tabId === 'listModel') {
                tabId = 'listmodel';
            } else if (tabId === 'addPage') {
                tabId = 'addmodel';
            }
            if (tabId !== 'addmodel' && tabId !== 'listmodel') {
                return;
            }

            $('.ss-model-tabs .tab-pane').removeClass('active show');
            $('#' + tabId).addClass('active');
            $('.ss-model-panel a[href="#addmodel"], .ss-model-panel a[href="#listmodel"]').removeClass('active');
            $('.ss-model-panel a[href="#' + tabId + '"]').addClass('active');
        }

        $('.ss-model-panel').on('click', 'a[href="#addmodel"], a[href="#listmodel"]', function (event) {
            event.preventDefault();
            showModelTab(this.hash.substring(1));
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
                modelName: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
            },
            messages: {
                modelName: {
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

        let modelImagePreviewUrl = null;
        $('#modelImage').on('change', function() {
            const file = this.files && this.files[0];
            const preview = document.getElementById('modelImagePreview');
            const previewIcon = preview.previousElementSibling;

            if (modelImagePreviewUrl) {
                URL.revokeObjectURL(modelImagePreviewUrl);
                modelImagePreviewUrl = null;
            }

            if (!file) {
                $('#modelImageName').text('Choose an image for this model');
                $('#modelImageHint').text('JPG, JPEG, or PNG · Maximum 5 MB');
                preview.hidden = true;
                previewIcon.hidden = false;
                return;
            }

            $('#modelImageName').text(file.name);
            $('#modelImageHint').text((file.size / (1024 * 1024)).toFixed(2) + ' MB · Ready to upload');
            if (file.type === 'image/jpeg' || file.type === 'image/png') {
                modelImagePreviewUrl = URL.createObjectURL(file);
                preview.src = modelImagePreviewUrl;
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
        if(value != null) { showModelTab(value); }
    });

        function deleteModel(enc_modelID,modelName) {
            console.log(modelName);
            swal({
                title: "Confirmation",
                text: "Are You Sure You Want To Delete This Model '"+ modelName +"'?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if(willDelete){
                    $.ajax({
                        type: "POST",
                        url: "partial/delete_models.php",
                        data: {enc_modelID : enc_modelID},
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
