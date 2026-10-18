<?php  
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageEmployee.php');
  $arrEmployee = getAllEmployee();
    $msg = '';
    //print_r($arrEmployee);
    //exit;
    //echo $_SESSION['__SESS_EMPLOYEE_ID'];
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
    <link rel="stylesheet" href="dist/css/employee-management.css?v=font-size-20261018">
  <style>
    /* Custom error message style */
    .error {
        color: red; /* Set the color to red */
        font-weight: 10; /* Set the font weight to thin */
        font-size: 18px;
    }
    </style>
</head>
<body class="hold-transition ss-dash-page ss-employee-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar"><a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a><nav class="ss-dash-nav" aria-label="Main navigation"><a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a><details class="ss-nav-group" open><summary class="ss-nav-link is-active"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="category.php">Category</a><a href="models.php">Models</a><a href="cars.php">Car</a><a class="is-current" href="employee.php">Employee</a><a href="customer.php">Customer</a></details><details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="enquiry.php">Enquiry</a><a href="sales.php">Sales</a><a href="service.php">Service</a></details><details class="ss-nav-group"><summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary><a href="revenue_report.php">Revenue Report</a></details><a class="ss-nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></nav><div class="ss-sidebar-motto">Drive<br>Your Dreams,<br><span>Not Just Cars.</span><i></i></div></aside>
    <main class="ss-dash-main"><header class="ss-dash-topbar"><button class="ss-icon-button ss-sidebar-toggle" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button><label class="ss-search"><i class="fas fa-search"></i><input type="search" placeholder="Search anything..." aria-label="Search anything"></label><div class="ss-topbar-actions"><button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button><button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button><div class="ss-profile"><img src="dist/img/user2-160x160.jpg" alt=""><span><b>Superadmin</b><small>Admin</small></span><i class="fas fa-chevron-down"></i></div></div></header>
        <section class="ss-dash-content ss-employee-content">
            <?php if($msg != '') { ?><div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg,0,3) == 'SUC' ? 'alert-success' : 'alert-warning'; ?>"><button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button><?php echo getMessage($msg); ?></div><?php } ?>
            <section class="ss-employee-hero"><div class="ss-employee-hero-copy"><span>INVENTORY MANAGEMENT</span><h1><i class="fas fa-users"></i> Employee Management</h1><p>Manage your team members, add new employees,<br>and keep your workforce organized efficiently.</p></div></section>
            <section class="ss-panel ss-employee-panel">
                <header class="ss-panel-heading ss-employee-panel-heading"><div class="ss-employee-title-tools"><h2><i class="fas fa-user"></i> Employee List</h2><a class="ss-employee-add" href="#addEmp" data-toggle="tab"><i class="fas fa-plus"></i> Add Employee</a></div><div class="ss-employee-tools"><label class="ss-employee-search"><i class="fas fa-search"></i><input id="employeeSearch" type="search" placeholder="Search employee..." aria-label="Search employee"></label><label class="ss-employee-filter" title="Filter by position"><i class="fas fa-filter"></i><select id="employeePositionFilter" aria-label="Filter by position"><option value="">All positions</option><?php $employeePositions = array_unique(array_column($arrEmployee, 'position')); foreach($employeePositions as $employeePosition) { ?><option value="<?php echo htmlspecialchars($employeePosition, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($employeePosition, ENT_QUOTES, 'UTF-8'); ?></option><?php } ?></select></label></div></header>
                <div class="ss-employee-tabs"><div class="tab-content">
                    <div class="tab-pane" id="addEmp"><form id="addEmployeeForm" method="post" action="employee_validate.php" class="ss-employee-form">
                        <div><label for="employeeName">Employee Name</label><input type="text" id="employeeName" name="employeeName" required placeholder="Enter employee name"></div><div><label for="position">Position</label><input type="text" id="position" name="position" required placeholder="Enter position"></div>
                        <div><label for="mailid">Mail ID</label><input type="email" id="mailid" name="mailid" required placeholder="Enter email address"></div><div><label for="phone">Phone</label><input type="text" id="phone" name="phone" required placeholder="Enter phone number"></div>
                        <div><label for="hiredate">Hire Date</label><input type="date" id="hiredate" name="hiredate" required></div><div><label for="dateofbirth">Date of Birth</label><input type="date" id="dateofbirth" name="dateofbirth" required></div>
                        <div><label for="age">Age</label><input type="text" id="age" name="age" required placeholder="Enter age"></div><div><label>Gender</label><div class="ss-employee-radio"><label><input type="radio" name="gender" value="Male" checked> Male</label><label><input type="radio" name="gender" value="Female"> Female</label></div></div>
                        <div><label for="username">User Name</label><input type="text" id="username" name="username" required placeholder="Enter username"></div><div><label for="password">Password</label><input type="password" id="password" name="password" required placeholder="Enter password"></div>
                        <div class="span-two"><label for="address">Address</label><textarea id="address" name="address" rows="3" placeholder="Enter address"></textarea></div>
                        <div class="ss-employee-form-actions"><button type="submit" class="ss-employee-add"><i class="fas fa-save"></i> Save Employee</button><a href="#listEmp" data-toggle="tab" class="ss-employee-cancel">Cancel</a></div>
                    </form></div>
                    <div class="tab-pane active" id="listEmp"><div class="ss-employee-table-wrap"><table id="tbllistEmp" class="ss-employee-table"><thead><tr><th>S.No</th><th>Employee Name</th><th>Mail ID</th><th>Position</th><th>Hire Date</th><th>User Name</th><th>Password</th><th>Record</th><th>Edit</th><th>Delete</th><th>View</th></tr></thead><tbody>
                        <?php foreach($arrEmployee as $key => $value) { $employee_name = $value['employee_name']; $mail_id = $value['mail_id']; $position = $value['position']; $hire_date = $value['hire_date']; $user_name = $value['user_name']; $enc_employee_id = encrypt_decrypt($value['employee_id']); $initials = strtoupper(substr(preg_replace('/\s+/', '', $employee_name), 0, 2)); $positionClass = 'position-' . strtolower(str_replace(' ', '-', $position)); $avatarClass = array('','avatar-purple','avatar-teal','avatar-orange')[$key % 4]; ?>
                        <tr><td><?php echo $key + 1; ?></td><td><div class="ss-employee-person"><span class="ss-employee-avatar <?php echo $avatarClass; ?>"><?php echo htmlspecialchars($initials, ENT_QUOTES, 'UTF-8'); ?></span><strong><?php echo htmlspecialchars($employee_name, ENT_QUOTES, 'UTF-8'); ?></strong></div></td><td><?php echo htmlspecialchars($mail_id, ENT_QUOTES, 'UTF-8'); ?></td><td><span class="ss-employee-position <?php echo htmlspecialchars($positionClass, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?></span></td><td class="ss-employee-date"><i class="far fa-calendar-alt"></i><?php echo htmlspecialchars($hire_date, ENT_QUOTES, 'UTF-8'); ?></td><td class="ss-employee-username"><?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?></td><td><span class="ss-employee-password" aria-label="Password hidden">&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</span></td><td><span class="ss-employee-status">Listed</span></td><td class="ss-employee-row-action"><a class="ss-employee-action" href="edit_employee.php?id=<?php echo $enc_employee_id; ?>" title="Edit"><i class="fas fa-pen"></i></a></td><td class="ss-employee-row-action"><a class="ss-employee-action is-delete" href="javascript:void(0)" onclick="deleteEmployee('<?php echo $enc_employee_id; ?>','<?php echo htmlspecialchars($employee_name, ENT_QUOTES, 'UTF-8'); ?>')" title="Delete"><i class="fas fa-trash"></i></a><span id="<?php echo $enc_employee_id; ?>" style="display:none"><img src="images/spinner.gif" alt=""></span></td><td class="ss-employee-row-action"><a class="ss-employee-action is-view" href="view_employee.php?id=<?php echo $enc_employee_id; ?>" title="View"><i class="fas fa-eye"></i></a></td></tr>
                        <?php } ?>
                    </tbody></table></div><div class="ss-employee-footer"><span id="employeeEntrySummary"></span><span class="ss-employee-pagination" id="employeePagination"></span></div></div>
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
                    <h1>Employee</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="employee.php">Employee List</a></li>
                        <li class="breadcrumb-item active">Add Employee</li>
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
                                <ul id="emp_tab" class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#listEmp" data-toggle="tab" >Employee List </a></li>
                                    <li class="nav-item"><a class="nav-link" href="#addEmp" data-toggle="tab">Add Employee</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">   
                                    <div class="tab-pane" id="addEmp">
                                        <form id="addForm" method="post" action="employee_validate.php">
                                            <div class="row">
                                                <div class="col-sm-12 form-group">
                                                    <label for="employeeName">Employee Name</label>
                                                    <input type="text" class="form-control" id="employeeName" name="employeeName" required placeholder="Enter Employee Name" value="<?php echo isset($arrData['employee_name']) ? $arrData['employee_name'] : ''; ?>">
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
                                                <div class="col-sm-6 form -group">
                                                    <label for="position">Position</label>
                                                    <input type="text" class="form-control" id="position" name="position" required placeholder="Enter Position" value="<?php echo isset($aaData['position']) ? $arrData['position'] : '';?>">
                                                </div>
                                                <div class="col-sm-6 form-group">
                                                    <label for="hiredate">Hire Date</label>
                                                    <input type="date" class="form-control" id="hiredate" name="hiredate" required>
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
                                                        <label for="username">User Name</label>
                                                        <input type="text" class="form-control" id="username" name="username" required placeholder="Enter User Name" value="<?php echo isset($aarData['user_name']) ? $arrData['user_name'] : '';?>">
                                                    </div>
                                                    <div class="col-sm-6 form-group">
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password" required placeholder="Enter Password" value="<?php echo isset($arrData['password']) ? $arrData['password'] : '';?>">
                                                    </div>
                                                                                      
                                                    <button type="submit"  class="btn btn-primary" >Submit</button>                                           
                                            </div>
                                        </form>
                                    </div>
                                
                                    <!-- Second tab -->
                                    <div class="tab-pane active" id="listEmp">
                                        <table id="tbllistEmp" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                <th>S.NO.</th>
                                                <th>Employee Name</th>
                                                <th>Mail ID</th>
                                                <th>Position</th>
                                                <th>Hire Date</th>
                                                <th>User Name</th>
                                                <th>Password</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                                <th>View</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrEmployee as $key => $value)
                                                    {
                                                        $sno = $key + 1;
                                                        $employee_name = $value['employee_name'];
                                                        $mail_id = $value['mail_id'];
                                                        $position = $value['position'];
                                                        $hire_date = $value['hire_date'];
                                                        $user_name = $value['user_name'];
                                                        $password = $value['password'];
                                                        $enc_employee_id = encrypt_decrypt($value['employee_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $key+1;?></td>
                                                        <td><?php echo $employee_name;?></td>
                                                        <td><?php echo $mail_id;?></td>
                                                        <td><?php echo $position;?></td>
                                                        <td><?php echo $hire_date;?></td>
                                                        <td><?php echo $user_name;?></td>
                                                        <td><?php echo $password;?></td>
                                                        <td><a href="edit_employee.php?id=<?php echo $enc_employee_id;?>" class="btn-outline-light btn-sm" title="Edit"><i class="far fa-edit"></i></a></td>
                                                        <td>
                                                            <a href="javascript:void(0)" onclick="deleteEmployee('<?php echo  $enc_employee_id;?>','<?php echo $user_name;?>')" class="btn-outline-dark btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
                                                            <span id='<?php echo $enc_employee_id;?>' style='display: none;padding-left:1px;'>
                                                                <img src='images/spinner.gif'>
                                                            </span>
                                                        </td>
                                                        <td><a href="view_employee.php?id=<?php echo $enc_employee_id;?>" class="btn-outline-light btn-sm" title="View"><i class="fas fa-eye"></i></a></td>      
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
        const employeeRows = $('#tbllistEmp tbody tr').toArray();
        let currentEmployeePage = 1;
        const employeePageSize = 10;
        function renderEmployeePage() {
            const query = $('#employeeSearch').val().toLowerCase();
            const position = $('#employeePositionFilter').val().toLowerCase();
            const filteredRows = employeeRows.filter(function (row) {
                const rowPosition = $(row).children('td').eq(3).text().trim().toLowerCase();
                return $(row).text().toLowerCase().indexOf(query) !== -1 && (!position || rowPosition === position);
            });
            const pageCount = Math.max(1, Math.ceil(filteredRows.length / employeePageSize));
            currentEmployeePage = Math.min(currentEmployeePage, pageCount);
            employeeRows.forEach(function (row) { row.style.display = 'none'; });
            filteredRows.slice((currentEmployeePage - 1) * employeePageSize, currentEmployeePage * employeePageSize).forEach(function (row) { row.style.display = ''; });
            const firstEntry = filteredRows.length ? (currentEmployeePage - 1) * employeePageSize + 1 : 0;
            const lastEntry = Math.min(currentEmployeePage * employeePageSize, filteredRows.length);
            $('#employeeEntrySummary').text('Showing ' + firstEntry + ' to ' + lastEntry + ' of ' + filteredRows.length + ' entries');
            let pageButtons = '<button type="button" data-page="' + Math.max(1, currentEmployeePage - 1) + '">Previous</button>';
            for (let page = 1; page <= pageCount; page++) { pageButtons += '<button type="button" data-page="' + page + '" class="' + (page === currentEmployeePage ? 'is-current' : '') + '">' + page + '</button>'; }
            pageButtons += '<button type="button" data-page="' + Math.min(pageCount, currentEmployeePage + 1) + '">Next</button>';
            $('#employeePagination').html(pageButtons);
        }
        $('#employeeSearch').on('input', function () { currentEmployeePage = 1; renderEmployeePage(); });
        $('#employeePositionFilter').on('change', function () { currentEmployeePage = 1; renderEmployeePage(); });
        $('#employeePagination').on('click', 'button', function () { currentEmployeePage = Number($(this).data('page')); renderEmployeePage(); });
        renderEmployeePage();
        // Add a custom method to check for blank spaces
        $.validator.addMethod("noBlank", function(value, element) {
            return this.optional(element) || $.trim(value).length > 0;
        }, "This field cannot be blank or filled with only spaces.");
        //Lets validate  this form for mandatory fields and input types
        // Initialize form validation on the addLocationForm form
        $("#addEmployeeForm").validate({
            // Specify validation rules
            rules: {
                employeeName: {
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
                position: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                hiredate: {
                    required: true
                },
                age: {
                    required: true,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                dateofbirth: {
                    required: true
                },
                username: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
                password: {
                    required: true,
                    minlength: 3,
                    noBlank: true // do not allow pure blank values created using spacebar
                },
            },
            messages: {
                employeeName: {
                    required: "Please enter  employee name",
                    minlength: "Your employee name must be at least 3 characters long"
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
                position: {
                    required: "Please enter position",
                    minlength: "Your position must be at least 3 characters long"
                },
                hiredate: {
                    required: "Please select a date of birth"
                },
                age: {
                    required: "Please enter age"
                },
                dateofbirth: {
                    required: "Please select a date of birth"
                },
                username: {
                    required: "Please enter username",
                    minlength: "Your username must be at least 3 characters long"
                },
                password: {
                    required: "Please enter password",
                    minlength: "Your password must be at least 3 characters long"
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
        $('a[href="#' + value + '"]').tab('show');
        }
    });
    function deleteEmployee(enc_employeeID,employeeName){
        console.log(employeeName);
        swal({
            title: "Confirmation",
            text: "Are You Sure You Want To Delete This Employee '" +employeeName+ "'?",
            icon: "warning",
            buttons: true,
            dangerMode: "true",
        })
        .then((willDelete) => {  
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: "partial/delete_employee.php",
                        data: {enc_employeeID : enc_employeeID},
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

