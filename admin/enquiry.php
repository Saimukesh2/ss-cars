<?php
  session_start();
  require_once('common/config.php');
  require_once('common/dbconn.php');
  require_once('common/common_functions.php');
  require_once('data/daManageCar.php');
  require_once('data/daManageEnquiry.php');
  require_once('data/daManageEmployee.php');

  $msg = '';
  $arrProductCat = getAllActiveCategory();
  $arrModels = getAllActiveModels();
  $arrCars = getAllActiveCars();
  $arrEmployee = getAllActiveEmployeeById();
  $arrEnquiry = getAllEnquiry();

  if (isset($_GET['msg'])) {
      $msg = $_GET['msg'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SS-Cars</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/main.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/dashboard.css?v=font-size-20261018">
  <link rel="stylesheet" href="dist/css/enquiry-management.css?v=font-size-20261018">
  <style>
    .error { color: red; font-weight: 600; font-size: 16px; }
  </style>
</head>
<body class="hold-transition ss-dash-page ss-enquiry-page">
<div class="ss-dash-layout">
    <aside class="ss-dash-sidebar">
        <a href="dashboard.php" class="ss-dash-brand"><span class="ss-brand-emblem">SS</span><span>SS-<b>CARS</b></span></a>
        <nav class="ss-dash-nav" aria-label="Main navigation">
            <a class="ss-nav-link" href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
            <details class="ss-nav-group" open>
                <summary class="ss-nav-link"><i class="fas fa-th-large"></i><span>Masters</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a href="category.php">Category</a>
                <a href="models.php">Models</a>
                <a href="cars.php">Car</a>
                <a href="employee.php">Employee</a>
                <a href="customer.php">Customer</a>
            </details>
            <details class="ss-nav-group" open>
                <summary class="ss-nav-link is-active"><i class="fas fa-exchange-alt"></i><span>Transaction</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
                <a class="is-current" href="enquiry.php">Enquiry</a>
                <a href="sales.php">Sales</a>
                <a href="service.php">Service</a>
            </details>
            <details class="ss-nav-group">
                <summary class="ss-nav-link"><i class="fas fa-chart-bar"></i><span>Report</span><i class="fas fa-chevron-down ss-nav-chevron"></i></summary>
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
            <div class="ss-topbar-actions">
                <button class="ss-icon-button ss-notice-button" aria-label="Notifications"><i class="far fa-bell"></i><span></span></button>
                <button class="ss-icon-button" id="ssFullscreen" aria-label="Toggle fullscreen"><i class="fas fa-expand-alt"></i></button>
                <div class="ss-profile">
                    <img src="dist/img/user2-160x160.jpg" alt="">
                    <span><b>Superadmin</b><small>Admin</small></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </header>

        <section class="ss-dash-content ss-enquiry-content">
            <?php if ($msg != '') { ?>
                <div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg, 0, 3) == 'SUC' ? 'alert-success' : 'alert-warning'; ?>">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                    <?php echo getMessage($msg); ?>
                </div>
            <?php } ?>

            <section class="ss-enquiry-hero">
                <div class="ss-enquiry-hero-copy">
                    <span>ENQUIRY MANAGEMENT</span>
                    <h1><i class="fas fa-clipboard-list"></i> Enquiry List</h1>
                    <p>Track customer interest, test drives, and vehicle enquiries from one place.</p>
                </div>
            </section>

            <section class="ss-panel ss-enquiry-panel">
                <header class="ss-panel-heading ss-enquiry-panel-heading">
                    <div class="ss-enquiry-title-tools">
                        <h2><i class="fas fa-clipboard-list"></i> Enquiry List</h2>
                        <a class="ss-enquiry-add" href="#addEnq" data-toggle="tab"><i class="fas fa-plus"></i> Add Enquiry</a>
                    </div>
                    <div class="ss-enquiry-tools">
                        <label class="ss-enquiry-search"><i class="fas fa-search"></i><input id="enquirySearch" type="search" placeholder="Search enquiry..." aria-label="Search enquiry"></label>
                    </div>
                </header>

                <div class="ss-enquiry-tabs">
                    <div class="tab-content">
                        <div class="tab-pane" id="addEnq">
                            <form id="addEnquiryForm" method="post" action="enquiry_validate.php" class="ss-enquiry-form">
                                <div>
                                    <label for="carName">Car Name</label>
                                    <select id="carName" name="carName" required>
                                        <option value="">Select car</option>
                                        <?php foreach ($arrCars as $key => $value) { ?>
                                            <option value='<?php echo $value['car_id']; ?>'><?php echo htmlspecialchars($value['car_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div>
                                    <label for="employeeName">Employee Name</label>
                                    <select id="employeeName" name="employeeName" required>
                                        <option value="">Select employee</option>
                                        <?php foreach ($arrEmployee as $key => $value) { ?>
                                            <option value='<?php echo $value['employee_id']; ?>'><?php echo htmlspecialchars($value['employee_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div>
                                    <label for="customerName">Customer Name</label>
                                    <input type="text" id="customerName" name="customerName" required placeholder="Enter customer name">
                                </div>

                                <div>
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" required placeholder="Enter phone number">
                                </div>

                                <div>
                                    <label>Testdrive Willing</label>
                                    <div class="ss-enquiry-radio">
                                        <label><input type="radio" name="testdrivewilling" value="Yes" checked> Yes</label>
                                        <label><input type="radio" name="testdrivewilling" value="No"> No</label>
                                    </div>
                                </div>

                                <div>
                                    <label for="testdrivedate">Testdrive Date</label>
                                    <input type="date" id="testdrivedate" name="testdrivedate" required>
                                </div>

                                <div class="span-two">
                                    <label for="feedback">Feedback</label>
                                    <textarea id="feedback" name="feedback" rows="4" placeholder="Enter feedback"></textarea>
                                </div>

                                <div class="ss-enquiry-form-actions">
                                    <button type="submit" class="ss-enquiry-add"><i class="fas fa-save"></i> Save Enquiry</button>
                                    <a href="#listEnq" data-toggle="tab" class="ss-enquiry-cancel">Cancel</a>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane active" id="listEnq">
                            <div class="ss-enquiry-table-wrap">
                                <table id="tbllistEnq" class="ss-enquiry-table">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Car Name</th>
                                            <th>Employee Name</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Willing</th>
                                            <th>Testdrive Date</th>
                                            <th>Edit</th>
                                            <th>View</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($arrEnquiry as $key => $value) { $enc_enquiry_id = encrypt_decrypt($value['enquiry_id']); ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo htmlspecialchars($value['car_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($value['employee_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($value['enquirer_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><?php echo htmlspecialchars($value['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td><span class="ss-enquiry-status <?php echo strtolower($value['testdrive_willing']) == 'yes' ? 'is-yes' : 'is-no'; ?>"><?php echo htmlspecialchars($value['testdrive_willing'], ENT_QUOTES, 'UTF-8'); ?></span></td>
                                                <td><?php echo ($value['testdrive_date']); ?></td>
                                                <td class="ss-enquiry-row-action"><a class="ss-enquiry-action" href="edit_enquiry.php?id=<?php echo rawurlencode($enc_enquiry_id); ?>" title="Edit"><i class="fas fa-pen"></i></a></td>
                                                <td class="ss-enquiry-row-action"><a class="ss-enquiry-action is-view" href="view_enquiry.php?id=<?php echo rawurlencode($enc_enquiry_id); ?>" title="View"><i class="fas fa-eye"></i></a></td>
                                                <td class="ss-enquiry-row-action"><button type="button" class="ss-enquiry-action is-delete js-delete-enquiry" data-enquiry-id="<?php echo htmlspecialchars($enc_enquiry_id, ENT_QUOTES, 'UTF-8'); ?>" data-enquiry-name="<?php echo htmlspecialchars($value['enquirer_name'], ENT_QUOTES, 'UTF-8'); ?>" title="Delete"><i class="fas fa-trash-alt"></i></button></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="ss-enquiry-footer">
                                <span id="enquiryEntrySummary"></span>
                                <span class="ss-enquiry-pagination" id="enquiryPagination"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
    $(function () {
        $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
        $('#ssFullscreen').on('click', function () {
            if (!document.fullscreenElement && document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
            else if (document.exitFullscreen) { document.exitFullscreen(); }
        });

        const enquiryRows = $('#tbllistEnq tbody tr').toArray();
        let currentEnquiryPage = 1;
        const enquiryPageSize = 10;

        function renderEnquiryPage() {
            const query = $('#enquirySearch').val().toLowerCase();
            const filteredRows = enquiryRows.filter(function (row) {
                return $(row).text().toLowerCase().indexOf(query) !== -1;
            });

            const pageCount = Math.max(1, Math.ceil(filteredRows.length / enquiryPageSize));
            currentEnquiryPage = Math.min(currentEnquiryPage, pageCount);

            enquiryRows.forEach(function (row) { row.style.display = 'none'; });
            filteredRows.slice((currentEnquiryPage - 1) * enquiryPageSize, currentEnquiryPage * enquiryPageSize).forEach(function (row) { row.style.display = ''; });

            const firstEntry = filteredRows.length ? (currentEnquiryPage - 1) * enquiryPageSize + 1 : 0;
            const lastEntry = Math.min(currentEnquiryPage * enquiryPageSize, filteredRows.length);
            $('#enquiryEntrySummary').text('Showing ' + firstEntry + ' to ' + lastEntry + ' of ' + filteredRows.length + ' entries');

            let pageButtons = '<button type="button" data-page="' + Math.max(1, currentEnquiryPage - 1) + '" aria-label="Previous page"><i class="fas fa-chevron-left"></i></button>';
            for (let page = 1; page <= pageCount; page++) {
                pageButtons += '<button type="button" data-page="' + page + '" class="' + (page === currentEnquiryPage ? 'is-current' : '') + '">' + page + '</button>';
            }
            pageButtons += '<button type="button" data-page="' + Math.min(pageCount, currentEnquiryPage + 1) + '" aria-label="Next page"><i class="fas fa-chevron-right"></i></button>';
            $('#enquiryPagination').html(pageButtons);
        }

        $('#enquirySearch').on('input', function () { currentEnquiryPage = 1; renderEnquiryPage(); });
        $('#enquiryPagination').on('click', 'button', function () { currentEnquiryPage = Number($(this).data('page')); renderEnquiryPage(); });
        renderEnquiryPage();

        $.validator.addMethod('noBlank', function(value, element) {
            return this.optional(element) || $.trim(value).length > 0;
        }, 'This field cannot be blank or filled with only spaces.');

        $('#addEnquiryForm').validate({
            rules: {
                carName: { required: true },
                employeeName: { required: true },
                customerName: { required: true, minlength: 3, noBlank: true },
                phone: { required: true, minlength: 3, noBlank: true },
                testdrivedate: {
                    required: function () {
                        return $('input[name="testdrivewilling"]:checked').val() === 'Yes';
                    }
                },
                feedback: { noBlank: true }
            },
            messages: {
                carName: { required: 'Please select a car' },
                employeeName: { required: 'Please select an employee' },
                customerName: {
                    required: 'Please enter a customer name',
                    minlength: 'Customer name must be at least 3 characters long'
                },
                phone: {
                    required: 'Please enter a phone number',
                    minlength: 'Phone number must be at least 3 characters long'
                },
                testdrivedate: { required: 'Please select a test drive date when the customer is willing to test drive.' }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) { error.insertAfter(element); },
            highlight: function (element) { $(element).addClass('is-invalid'); },
            unhighlight: function (element) { $(element).removeClass('is-invalid'); }
        });

        const params = new Proxy(new URLSearchParams(window.location.search), {
            get: (searchParams, prop) => searchParams.get(prop),
        });
        const activeTab = params.tab_id;
        if (activeTab != null) {
            $('a[href="#' + activeTab + '"]').tab('show');
        }

        $('input[name="testdrivewilling"]').on('change', function () {
            const isYes = $(this).val() === 'Yes';
            $('#testdrivedate').prop('disabled', !isYes);
            if (!isYes) {
                $('#testdrivedate').val('');
            }
        });
        $('#testdrivedate').prop('disabled', $('input[name="testdrivewilling"]:checked').val() !== 'Yes');
    });

    function deleteEnquiry(enc_enquiryID, customerName) {
        swal({
            title: 'Delete enquiry?',
            text: 'Delete enquiry for ' + customerName + '? This cannot be undone.',
            icon: 'warning',
            buttons: true,
            dangerMode: true
        }).then(function (confirmed) {
            if (!confirmed) { return; }

            $.ajax({
                type: 'POST',
                url: 'partial/delete_enquiry.php',
                data: { enc_enquiryID: enc_enquiryID },
                dataType: 'json',
                success: function (response) {
                    swal({
                        title: response.msg === 'Success' ? 'Deleted' : 'Cannot delete',
                        text: response.msg_detail,
                        icon: response.msg === 'Success' ? 'success' : 'error'
                    }).then(function () {
                        if (response.msg === 'Success') { location.reload(); }
                    });
                },
                error: function () {
                    swal({ title: 'Error', text: 'Could not delete this enquiry.', icon: 'error' });
                }
            });
        });
    }

    $(document).on('click', '.js-delete-enquiry', function () {
        deleteEnquiry($(this).data('enquiry-id'), $(this).data('enquiry-name'));
    });
</script>
</body>
</html>


</body>
</html>

