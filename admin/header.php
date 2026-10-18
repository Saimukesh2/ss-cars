 <!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
  <img
    class="animation__shake"
    src="dist/img/AdminLTELogo.png"
    alt="AdminLTELogo"
    height="60"
    width="60"
  />
</div>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"
        ><i class="fas fa-bars"></i
      ></a>
    </li>
          <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php?menu_id=1" class="nav-link "  style ="color: white; background-color:lightblue;"  >
          Inventory Management        </a>
      </li>
          <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php?menu_id=2" class="nav-link "  >
          User Management        </a>
      </li>
          <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php?menu_id=4" class="nav-link "  >
          Admin        </a>
      </li>
      </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input
              class="form-control form-control-navbar"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
              <button  class="btn btn-navbar"  type="button"  data-widget="navbar-search"><i class="fas fa-times"></i></button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge" id="notificationsCount">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div id="notificationsContainer">
              <!-- Notifications will be appended here -->
          </div>
          <a href="view_notifications.php" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!--  <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>-->
    <li class="nav-item">
      <a class="nav-link" data-widget="logout" href="logout.php" role="button">
        <i class="fas fa-th-large"></i> logout
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->