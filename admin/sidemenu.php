<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="dashboard.php" class="brand-link">
    <!--<img src="images/logo.png" alt="G=Maaran" class="brand-image" >-->
    <span class="brand-text font-weight-light">SS-Cars</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">superadmin</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item menu-open">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Masters -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Masters<i class="fas fa-angle-left right"></i></p>  
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="category.php" class="nav-link subnav">
                <p>Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="models.php" class="nav-link subnav">
                <p>Models</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cars.php" class="nav-link subnav">
                <p>Cars</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="employee.php" class="nav-link subnav">
                <p>Employee</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="customer.php" class="nav-link subnav">
                <p>Customer</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Transaction -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Transaction<i class="fas fa-angle-left right"></i></p>  
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="enquiry.php" class="nav-link subnav">
                <p>Enquiry</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="sales.php" class="nav-link subnav">
                <p>Sales</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="service.php" class="nav-link subnav">
                <p>Service</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Reports -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>Report<i class="fas fa-angle-left right"></i></p>  
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="revenue_report.php" class="nav-link subnav">
                <p>Revenue Report</p>
              </a>
            </li> 
            </li>
          </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
