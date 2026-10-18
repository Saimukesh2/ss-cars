
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- TO DO List -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <i class="ion ion-clipboard mr-1"></i>
          ALERT
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <ul class="todo-list" data-widget="todo-list">
          <li>
            <!-- drag handle -->
            <span class="handle">
              <i class="fas fa-ellipsis-v"></i>
              <i class="fas fa-ellipsis-v"></i>
            </span>
            <!-- checkbox -->
            <div class="icheck-primary d-inline ml-2">
              <input type="checkbox" value="" name="todo1" id="todoCheck1">
              <label for="todoCheck1"></label>
            </div>
            <!-- todo text -->
            <span class="text">Pending Invoices</span>
            <!-- Emphasis label -->
            <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
            <!-- General tools such as edit or delete-->
            <div class="tools">
              <i class="fas fa-edit"></i>
              <i class="fas fa-trash-o"></i>
            </div>
          </li>
        </ul>
        <!-- /.card-body -->
      </div>
    </div>
    <!-- /.card -->

    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->

    <!-- Small boxes (Stat box) -->
    <div class="row">

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3></h3>

            <p><strong>Invoice</strong><br> Due Invoices : </p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="new_invoice.php?tab_id=listInvoice" class="small-box-footer ">Manage <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3></h3>

            <p><p><strong>Products<br></strong><br></p></p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="products_master.php?tab_id=listProduct&tab=product" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3></h3>

            <p><strong>Vendors<br></strong><br></p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="vendor_master.php?tab_id=listvendor" class="small-box-footer">Manage <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->
