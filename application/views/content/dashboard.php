<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beranda
      <small>Selamat Bekerja!</small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <?= $this->session->flashdata("msg") ?>
      </div>
    </div>
    <div class="callout callout-info">
      <h4>Selamat datang <b>
          <?= $this->session->userdata('nama') ?>
        </b>.</h4>
      <p></p>
    </div>
    <!-- Default box -->
    <!-- <div class="box">
       <div class="box-header with-border">
         <h3 class="box-title">Title</h3>
         <div class="box-tools pull-right">
           <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
           <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
         </div>
       </div>
       <div class="box-body">
         Start creating your amazing application!
       </div>

       <div class="box-footer">
         Footer
       </div>
     </div> -->
    <!-- /.box -->
    <div class="box box-primary">
      <div class="box-header">
        <i class="fa fa-bar-chart-o"></i>
        <h3 class="box-title">Monitor Material Multemedia</h3>
      </div>
      <div class="box-body">
        <?php
        foreach ($less_stock as $key => $value): ?>
          <div class="row">
            <div class="col-md-12">
              <div class="callout callout-danger">
                <h4>Stok material <b>
                    <?= $value->material ?>
                  </b> number <b><?= $value->number ?></b> tersisa <b><?= $value->jumlah ?></b>
                </h4>
                <p></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->