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

  if (!empty($_GET)) {
      $enc_enquiry_id = sanitize_input($_GET['id'], 'textarea');
      $enquiry_id = encrypt_decrypt($enc_enquiry_id, 'decrypt');
      $arrEnquiry = getEnquiryById($enquiry_id);

      if (!empty($arrEnquiry)) {
          $category_id = $arrEnquiry['category_id'];
          $model_id = $arrEnquiry['model_id'];
          $car_id = $arrEnquiry['car_id'];
          $employee_name = $arrEnquiry['employee_name'];
          $customer_name = $arrEnquiry['enquirer_name'];
          $phone = $arrEnquiry['phone'];
          $testdrive_willing = $arrEnquiry['testdrive_willing'];
          $testdrive_date = $arrEnquiry['testdrive_date'];
          $feedback = $arrEnquiry['feedback'];
      } else {
          header('Location: enquiry.php?msg=ERRENQEMPTY');
          exit;
      }
  } else {
      header('Location: enquiry.php');
      exit;
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
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/main.css">
  <link rel="stylesheet" href="dist/css/dashboard.css">
  <link rel="stylesheet" href="dist/css/enquiry-management.css">
  <style>
    .ss-enquiry-subheading { min-height: 62px; display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 0 14px; border-bottom: 1px solid #173653; }
    .ss-enquiry-subheading h2 { margin: 0; color: #dce9f8; font-size: 15px; font-weight: 600; }
    .ss-enquiry-subheading h2 i { margin-right: 8px; color: #53bdff; }
    .ss-enquiry-back { color: #52baff; font-size: 11px; }
    .ss-enquiry-back:hover { color: white; }
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
                <div class="alert alert-dismissible ss-dash-alert <?php echo substr($msg, 0, 3) == 'SUC' ? 'alert-success' : 'alert-warning'; ?>"><?php echo getMessage($msg); ?></div>
            <?php } ?>

            <section class="ss-enquiry-hero">
                <div class="ss-enquiry-hero-copy">
                    <span>ENQUIRY MANAGEMENT</span>
                    <h1><i class="fas fa-edit"></i> Edit Enquiry</h1>
                    <p>Update the enquiry details and keep the customer follow-up record current.</p>
                </div>
            </section>

            <section class="ss-panel ss-enquiry-panel">
                <header class="ss-enquiry-subheading">
                    <h2><i class="fas fa-clipboard-list"></i> Enquiry Details</h2>
                    <a class="ss-enquiry-back" href="enquiry.php"><i class="fas fa-arrow-left"></i> Back to Enquiry List</a>
                </header>

                <form id="editEnquiryForm" method="post" action="edit_enquiry_validate.php" class="ss-enquiry-form" style="padding: 20px 18px 8px;">
                    <div>
                        <label for="categoryName">Category Name</label>
                        <select id="categoryName" name="categoryName" required>
                            <option value="">Select category</option>
                            <?php foreach ($arrProductCat as $value) { $selected = ($category_id == $value['category_id']) ? 'selected' : ''; ?>
                                <option value='<?php echo $value['category_id']; ?>' <?php echo $selected; ?>><?php echo htmlspecialchars($value['category_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="modelName">Model Name</label>
                        <select id="modelName" name="modelName" required>
                            <option value="">Select model</option>
                            <?php foreach ($arrModels as $value) { $selected = ($model_id == $value['model_id']) ? 'selected' : ''; ?>
                                <option value='<?php echo $value['model_id']; ?>' <?php echo $selected; ?>><?php echo htmlspecialchars($value['model_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="span-two">
                        <label for="carName">Car Name</label>
                        <select id="carName" name="carName" required>
                            <option value="">Select car</option>
                            <?php foreach ($arrCars as $value) { $selected = ($car_id == $value['car_id']) ? 'selected' : ''; ?>
                                <option value='<?php echo $value['car_id']; ?>' <?php echo $selected; ?>><?php echo htmlspecialchars($value['car_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div>
                        <label for="employeeName">Employee Name</label>
                        <input type="text" id="employeeName" name="employeeName" value="<?php echo htmlspecialchars($employee_name, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                    </div>

                    <div>
                        <label for="customerName">Customer Name</label>
                        <input type="text" id="customerName" name="customerName" required value="<?php echo htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div>
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" required value="<?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div>
                        <label>Testdrive Willing</label>
                        <div class="ss-enquiry-radio">
                            <label><input type="radio" name="testdrivewilling" value="Yes" <?php echo ($testdrive_willing == 'Yes') ? 'checked' : ''; ?>> Yes</label>
                            <label><input type="radio" name="testdrivewilling" value="No" <?php echo ($testdrive_willing == 'No') ? 'checked' : ''; ?>> No</label>
                        </div>
                    </div>

                    <div>
                        <label for="testdrivedate">Testdrive Date</label>
                        <input type="date" id="testdrivedate" name="testdrivedate" value="<?php echo htmlspecialchars($testdrive_date, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="span-two">
                        <label for="feedback">Feedback</label>
                        <textarea id="feedback" name="feedback" rows="4"><?php echo htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>

                    <input type="hidden" name="hdnEnquiryID" value="<?php echo htmlspecialchars($enc_enquiry_id, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="ss-enquiry-form-actions">
                        <button type="submit" class="ss-enquiry-add"><i class="fas fa-save"></i> Update Enquiry</button>
                        <a href="enquiry.php" class="ss-enquiry-cancel">Cancel</a>
                    </div>
                </form>
            </section>

            <footer class="ss-dash-footer"><span>Copyright &copy; 2022 SS-CARS. All rights reserved.</span><span>Luxury&nbsp;&nbsp; | &nbsp;&nbsp;Performance&nbsp;&nbsp; | &nbsp;&nbsp;Trust</span></footer>
        </section>
    </main>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $('.ss-sidebar-toggle').on('click', function () { $('.ss-dash-layout').toggleClass('sidebar-collapsed'); });
    $('#ssFullscreen').on('click', function () {
      if (!document.fullscreenElement && document.documentElement.requestFullscreen) { document.documentElement.requestFullscreen(); }
      else if (document.exitFullscreen) { document.exitFullscreen(); }
    });

    $('input[name="testdrivewilling"]').on('change', function () {
      const isYes = $(this).val() === 'Yes';
      $('#testdrivedate').prop('disabled', !isYes);
      if (!isYes) $('#testdrivedate').val('');
    });
    $('#testdrivedate').prop('disabled', $('input[name="testdrivewilling"]:checked').val() !== 'Yes');
  });
</script>
</body>
</html>

