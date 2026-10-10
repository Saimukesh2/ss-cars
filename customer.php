<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCustomer.php');
  require_once('data/daManageEnquiry.php');
  $arrCustomer = getAllCustomer();  
    $msg = '';
 /* print_r($arrCustomer);
  exit;*/
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
    <link rel="stylesheet" href="dist/css/customer-management.css">
  <style>
    /* Custom error message style */
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 14px; /* Set the font size to 10px */
    }
    /* Style for autocomplete dropdown items */
    .ui-menu-item {
        padding: 8px 12px; /* Add padding */
        cursor: pointer; /* Change cursor to pointer */
        border: 1px solid #007bff; /* Set blue border */
        background-color: #f8f9fa; /* Set grey background */
        border-radius: 4px; /* Add border-radius for rounded corners */
        width:500px;
    }

    /* Style for selected autocomplete dropdown item */
    .ui-menu-item-wrapper.ui-state-active {
        background-color: #007bff; /* Set background color for selected item */
        color: #fff; /* Set text color for selected item */
    }
    </style>
</head>
<body class="hold-transition ss-dash-page ss-customer-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar"><a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a><nav class="ss-dash-nav" aria-label="Main navigation"><a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a><details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a href="employee.php">Employee</a><a class="is-current" href="customer.php">Customer</a></details><details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details><details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details><a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></nav><div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div></aside>
    <main class="ss-dash-main"><header class="ss-dash-topbar"><button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button><label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label><div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div></header>
        <section class="ss-dash-content ss-customer-content">
            <?php if($msg != '') { ?><div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg,0,3) == 'SUC' ? 'alert-success' : 'alert-warning'; ?>"><button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo getMessage($msg); ?></div><?php } ?>
            <section class="ss-customer-hero"><div class="ss-customer-hero-copy"><span>CUSTOMER MANAGEMENT</span><h1><i class="fas fa-users"></i> Customer List</h1><p>Manage your customers, keep their details<br>and track their purchase history efficiently.</p></div></section>
            <section class="ss-panel ss-customer-panel">
                <header class="ss-panel-heading ss-customer-panel-heading"><div class="ss-customer-title-tools"><h2><i class="fas fa-users"></i> Customer List</h2><a class="ss-customer-add" href="#addCust" data-toggle="tab"><i class="fas fa-plus"></i> Add Customer</a></div><div class="ss-customer-tools"><label class="ss-customer-search"><i class="fas fa-search"></i><input id="customerSearch" type="search" placeholder="Search customer..." aria-label="Search customer"></label><label class="ss-customer-filter" title="Filter by gender"><i class="fas fa-filter"></i><select id="customerGenderFilter" aria-label="Filter by gender"><option value="">All genders</option><option value="Male">Male</option><option value="Female">Female</option></select></label></div></header>
                <div class="ss-customer-tabs"><div class="tab-content">
                    <div class="tab-pane" id="addCust"><form id="addCustomerForm" method="post" action="customer_validate.php" class="ss-customer-form">
                        <div><label for="customerName">Customer Name</label><input type="text" id="customerName" name="customerName" required placeholder="Enter customer name"></div><div><label for="mailid">Mail ID</label><input type="email" id="mailid" name="mailid" required placeholder="Enter email address"></div>
                        <div><label for="phone">Phone</label><input type="text" id="phone" name="phone" required placeholder="Enter phone number"></div><div><label for="age">Age</label><input type="text" id="age" name="age" required placeholder="Enter age"></div>
                        <div><label for="dateofbirth">Date of Birth</label><input type="date" id="dateofbirth" name="dateofbirth" required></div><div><label>Gender</label><div class="ss-customer-radio"><label><input type="radio" name="gender" value="Male" checked> Male</label><label><input type="radio" name="gender" value="Female"> Female</label></div></div>
                        <div><label for="city">City / Village / Town</label><input type="text" id="city" name="city" required placeholder="Enter city"></div><div><label for="state">State</label><input type="text" id="state" name="state" required placeholder="Enter state"></div>
                        <div class="span-two"><label for="address">Address</label><textarea id="address" name="address" rows="3" placeholder="Enter address"></textarea></div>
                        <div class="ss-customer-form-actions"><button type="submit" class="ss-customer-add"><i class="fas fa-save"></i> Save Customer</button><a href="#listCust" data-toggle="tab" class="ss-customer-cancel">Cancel</a></div>
                    </form></div>
                    <div class="tab-pane active" id="listCust"><div class="ss-customer-table-wrap"><table id="tbllistCust" class="ss-customer-table"><thead><tr><th>S.No</th><th>Customer Name</th><th>Mail ID</th><th>Gender</th><th>City</th><th>State</th><th>Edit</th><th>Delete</th><th>View</th></tr></thead><tbody>
                        <?php foreach($arrCustomer as $key => $value) { $customer_name = $value['customer_name']; $mail_id = $value['mail_id']; $gender = $value['gender']; $city = $value['city']; $state = $value['state']; $enc_customer_id = encrypt_decrypt($value['customer_id']); $initials = strtoupper(substr(preg_replace('/\s+/', '', $customer_name), 0, 2)); $avatarClass = array('','avatar-purple','avatar-teal','avatar-orange')[$key % 4]; ?>
                        <tr><td><?php echo $key + 1; ?></td><td><div class="ss-customer-person"><span class="ss-customer-avatar <?php echo $avatarClass; ?>"><?php echo htmlspecialchars($initials, ENT_QUOTES, 'UTF-8'); ?></span><strong><?php echo htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'); ?></strong></div></td><td><?php echo htmlspecialchars($mail_id, ENT_QUOTES, 'UTF-8'); ?></td><td class="ss-customer-gender"><i class="fas <?php echo strtolower($gender) == 'female' ? 'fa-venus' : 'fa-mars'; ?>"></i><?php echo htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'); ?></td><td class="ss-customer-location"><i class="fas fa-map-marker-alt"></i><?php echo htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?></td><td class="ss-customer-location"><i class="fas fa-circle-notch"></i><?php echo htmlspecialchars($state, ENT_QUOTES, 'UTF-8'); ?></td><td class="ss-customer-row-action"><a class="ss-customer-action" href="edit_customer.php?id=<?php echo rawurlencode($enc_customer_id); ?>" title="Edit"><i class="fas fa-pen"></i></a></td><td class="ss-customer-row-action"><button type="button" class="ss-customer-action is-delete js-delete-customer" data-customer-id="<?php echo htmlspecialchars($enc_customer_id, ENT_QUOTES, 'UTF-8'); ?>" data-customer-name="<?php echo htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'); ?>" title="Delete"><i class="fas fa-trash-alt"></i></button></td><td class="ss-customer-row-action"><a class="ss-customer-action is-view" href="view_customer.php?id=<?php echo rawurlencode($enc_customer_id); ?>" title="View"><i class="fas fa-eye"></i></a></td></tr>
                        <?php } ?>
                    </tbody></table></div><div class="ss-customer-footer"><span id="customerEntrySummary"></span><span class="ss-customer-pagination" id="customerPagination"></span></div></div>
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
                    <h1>Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="customer.php">Customer List</a></li>
                        <li class="breadcrumb-item active">Customer List</li>
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
                                <ul id="cust_tab" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#listCust" data-toggle="tab" >Customer List </a></li>
                                    <li class="nav-item"><a class="nav-link" href="#addCust" data-toggle="tab">Add Customer</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane" id="addCust">
                                        <form id="addForm" method="post" action="customer_validate.php">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="customerName">Customer Name</label>
                                                    <input type="text" class="form-control" id="customerName" name="customerName" required placeholder="Enter Customer Name" value="<?php echo isset($arrData['customer_name']) ? $arrData['customer_name'] : ''; ?>">
                                                </div>
                                                <div class="col-sm-12 form-group">
                                                    <label for="address">Address</label>
                                                    <textarea class="form-control" id="address" name="address" rows="4" placeholder="Enter Address"><?php echo isset($arrData['address']) ? $arrData['address'] : ''; ?></textarea>
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" required placeholder="Enter Phone" value="<?php echo isset($arrData['phone']) ? $arrData['phone'] : ''; ?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="mailid">Mail ID</label>
                                                    <input type="text" class="form-control" id="mailid" name="mailid" required placeholder="Enter Mail Id" value="<?php echo isset($arrData['mailid']) ? $arrData['mailid'] : '';?>">
                                                </div>                                                
                                                <div class="col-sm-3 form-group">
                                                    <label for="age">Age</label>
                                                    <input type="text" class="form-control" id="age" name="age" required placeholder="Enter Age" value="<?php echo isset($arrData['age']) ? $arrData['age'] :'';?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label>Gender</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male" checked>
                                                        <label class="form-check-label" for="genderMale">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female">
                                                        <label class="form-check-label" for="genderFemale">Female</label>
                                                    </div>                       
                                                    <div class="col-sm-3 form-group">
                                                        <label for="dateofbirth">D.O.B</label>
                                                        <input type="date" class="form-control" id="dateofbirth" name="dateofbirth" required>
                                                    </div>
                                                </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="city">City/Village/Town</label>
                                                        <input type="text" class="form-control" id="city" name="city" required placeholder="Enter City" value="<?php echo isset($arrData['city']) ? $arrData['city'] : '';?>">
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="state">State</label>
                                                        <input type="text" class="form-control" id="state" name="state" required placeholder="Enter State" value="<?php echo isset($arrData['state']) ? $arrData['state'] : '';?>">
                                                    </div>
                                                                                      
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                           
                                            </div>
                                        </form>
                                    </div>
                                
                                    <!-- Second tab -->
                                    <div class="tab-pane active" id="listCust">
                                        <table id="tbllistCust" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                <th>S.NO.</th>
                                                <th>Customer Name</th>
                                                <th>Mail ID</th>
                                                <th>Gender</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Edit</th>
                                                <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($arrCustomer as $key => $value)
                                                    {
                                                        $sno = $key+1;
                                                        $customer_name = $value['customer_name'];
                                                        $mail_id = $value['mail_id'];
                                                        $gender = $value['gender'];
                                                        $city = $value['city'];
                                                        $state = $value['state'];
                                                        $enc_customer_id = encrypt_decrypt($value['customer_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $key+1;?></td>
                                                        <td><?php echo $customer_name;?></td>
                                                        <td><?php echo $mail_id;?></td>
                                                        <td><?php echo $gender;?></td>
                                                        <td><?php echo $city;?></td>
                                                        <td><?php echo $state;?></td>
                                                        <td><a href="edit_customer.php?id=<?php echo $enc_customer_id;?>" class="btn-outline-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a></td>
                                                        <td><a href="view_customer.php?id=<?php echo $enc_customer_id;?>" class="btn-outline-light btn-sm" title="View"><i class="fa fa-eye"></i></a></td>      
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
        const customerRows = $('#tbllistCust tbody tr').toArray();
        let currentCustomerPage = 1;
        const customerPageSize = 10;
        function renderCustomerPage() {
            const query = $('#customerSearch').val().toLowerCase();
            const gender = $('#customerGenderFilter').val().toLowerCase();
            const filteredRows = customerRows.filter(function (row) {
                const rowGender = $(row).children('td').eq(3).text().trim().toLowerCase();
                return $(row).text().toLowerCase().indexOf(query) !== -1 && (!gender || rowGender === gender);
            });
            const pageCount = Math.max(1, Math.ceil(filteredRows.length / customerPageSize));
            currentCustomerPage = Math.min(currentCustomerPage, pageCount);
            customerRows.forEach(function (row) { row.style.display = 'none'; });
            filteredRows.slice((currentCustomerPage - 1) * customerPageSize, currentCustomerPage * customerPageSize).forEach(function (row) { row.style.display = ''; });
            const firstEntry = filteredRows.length ? (currentCustomerPage - 1) * customerPageSize + 1 : 0;
            const lastEntry = Math.min(currentCustomerPage * customerPageSize, filteredRows.length);
            $('#customerEntrySummary').text('Showing ' + firstEntry + ' to ' + lastEntry + ' of ' + filteredRows.length + ' entries');
            let pageButtons = '<button type="button" data-page="' + Math.max(1, currentCustomerPage - 1) + '" aria-label="Previous page"><i class="fas fa-chevron-left"></i></button>';
            for (let page = 1; page <= pageCount; page++) { pageButtons += '<button type="button" data-page="' + page + '" class="' + (page === currentCustomerPage ? 'is-current' : '') + '">' + page + '</button>'; }
            pageButtons += '<button type="button" data-page="' + Math.min(pageCount, currentCustomerPage + 1) + '" aria-label="Next page"><i class="fas fa-chevron-right"></i></button>';
            $('#customerPagination').html(pageButtons);
        }
        $('#customerSearch').on('input', function () { currentCustomerPage = 1; renderCustomerPage(); });
        $('#customerGenderFilter').on('change', function () { currentCustomerPage = 1; renderCustomerPage(); });
        $('#customerPagination').on('click', 'button', function () { currentCustomerPage = Number($(this).data('page')); renderCustomerPage(); });
        renderCustomerPage();
        // Add a custom method to check for blank spaces
        $.validator.addMethod("noBlank", function(value, element) {
            return this.optional(element) || $.trim(value).length > 0;
        }, "This field cannot be blank or filled with only spaces.");
        //Lets validate  this form for mandatory fields and input types
        // Initialize form validation on the addLocationForm form
        $("#addCustomerForm").validate({
            // Specify validation rules
            rules: {
                customerName: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                address: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                phone: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                mailid: {
                    required: true,
                    email: true,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                age: {
                    required: true,
                    noBlank:  true // do not allow pure blank values created using spacebar
                },
                dateofbirth: {
                    required: true
                },
                city: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                state: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
            },
            messages: {
                customerName: {
                    required: "Please enter  customer name",
                    minlength: "Your customer name must be at least 3 characters long"
                },
                address: {
                    required: "Please enter  address",
                    minlength: "Your address must be at least 3 characters long"
                },
                phone: {
                    required: "Please enter  phone number",
                    minlength: "Your phone number must be at least 3 characters long"
                },
                mailid: {
                    required: "Please enter email id",
                    email: "Please enter a valid email address"
                },
                age: {
                    required: "Please enter age"
                },
                dateofbirth: {
                    required: "Please select a date of birth"
                },
                city: {
                    required: "Please enter city",
                    minlength: "Your city must be at least 3 characters long"
                },
                state: {
                    required: "Please enter state",
                    minlength: "Your state must be at least 3 characters long"
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
        $('a[href="#' + value + '"]').tab('show');
        }

        $("#customerName").autocomplete({
            source: 'partial/autocomplete_customers.php',
            minLength: 1,
            select: function(event, ui) {
                // Set the selected value in the input field
                $("#customerName").val(ui.item.value);
            }
        });
    });

    function deleteCustomer(enc_customerID, customerName) {
        swal({ title: 'Delete customer?', text: 'Delete ' + customerName + '? This cannot be undone.', icon: 'warning', buttons: true, dangerMode: true })
        .then(function (confirmed) {
            if (!confirmed) { return; }
            $.ajax({
                type: 'POST',
                url: 'partial/delete_customer.php',
                data: { enc_customerID: enc_customerID },
                dataType: 'json',
                success: function (response) {
                    swal({ title: response.msg === 'Success' ? 'Deleted' : 'Cannot delete', text: response.msg_detail, icon: response.msg === 'Success' ? 'success' : 'error' })
                    .then(function () { if (response.msg === 'Success') { location.reload(); } });
                },
                error: function () { swal({ title: 'Error', text: 'Could not delete this customer.', icon: 'error' }); }
            });
        });
    }

    $(document).on('click', '.js-delete-customer', function () {
        deleteCustomer($(this).data('customer-id'), $(this).data('customer-name'));
    });

</script>

</body>
</html>

