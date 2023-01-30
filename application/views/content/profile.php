<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#">Profile</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <?= $this->session->flashdata("msg") ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive">
            <table class="table table-striped">
              <tr>
                <td>Email</td>
                <td>:</td>
                <td><?= $profile->email ?></td>
              </tr>
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $this->session->userdata('name') ?></td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?= $profile->jabatan ?></td>
              </tr>
              <?php
              if ($profile->jabatan == 'Kapool') : ?>
                <tr>
                  <td>TTD</td>
                  <td>:</td>
                  <td>
                    <img src="<?= base_url('ttd/' . $profile->ttd) ?>" width="100">
                    <br /><br />
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal_ttd_user"><i class="fa fa-sheqel"></i> Ubah TTD</button>
                  </td>
                </tr>
              <?php endif ?>
              <tr>
                <td>Password</td>
                <td>:</td>
                <td><button class="btn btn-primary" data-toggle="modal" data-target="#modal_password_user"><i class="fa fa-key"></i> Ubah Password</button></td>
              </tr>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="modal_ttd_user" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('user/save/') ?>" method="POST" enctype="multipart/form-data">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ubah TTD</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" id="div_ttd">
            <label for="ttd">TTD</label>
            <input type="file" name="ttd" id="ttd" accept="image/*">

            <input type="hidden" name="id" value="<?= $profile->id_user ?>" />
            <input type="hidden" name="nama" value="<?= $profile->nama ?>" />
            <input type="hidden" name="tipe" value="<?= $profile->tipe ?>" />
            <input type="hidden" name="jabatan" value="<?= $profile->jabatan ?>" />
            <input type="hidden" name="email" value="<?= $profile->email ?>" />
            <input type="hidden" name="old_ttd" value="<?= $profile->ttd ?>" />
            <input type="hidden" name="redirect" value="user/profile">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Ubah</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="modal_password_user" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('user/save/') ?>" method="POST">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ubah Password</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" id="div_ttd">
            <label for="password">New Password</label>
            <input type="password" class="form-control" name="password" id="password">

            <input type="hidden" name="id" value="<?= $profile->id_user ?>" />
            <input type="hidden" name="nama" value="<?= $profile->nama ?>" />
            <input type="hidden" name="tipe" value="<?= $profile->tipe ?>" />
            <input type="hidden" name="jabatan" value="<?= $profile->jabatan ?>" />
            <input type="hidden" name="email" value="<?= $profile->email ?>" />
            <input type="hidden" name="redirect" value="user/profile">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Ubah</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>