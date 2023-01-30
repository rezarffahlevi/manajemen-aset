<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Rekanan
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#">Rekanan</a></li>
    </ol>
    <div style="margin-top:20px;">
      <button type="button" class="btn btn-primary" onclick="show_add()">Tambah Data</a></button>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="table-rekanan" class="table table-bordered text-center display">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Nama Perusahaan</th>
                  <th>PIC</th>
                  <th>Email</th>
                  <th>No HP</th>
                  <th width="150">Action</th>
                </tr>
              </thead>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<!-- Modal -->
<div id="modal-form-rekanan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('rekanan/save/') ?>" id="form-rekanan" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Rekanan</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="id" id="id" />
            <label for="nama_perusahaan">Nama Perusahaan</label>
            <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" />
          </div>
          <div class="form-group">
            <label for="pic">PIC</label>
            <input type="text" class="form-control" name="pic" id="pic" />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" />
          </div>
          <div class="form-group">
            <label for="telp">No HP</label>
            <input type="text" class="form-control" name="telp" id="telp" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </form>
  </div>
</div>

<div id="modal-delete-rekanan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('rekanan/delete/') ?>" id="form-rekanan" method="POST">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Rekanan</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="del_id" />
          Anda yakin ingin menghapus data tersebut?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
    let dt = ''
    $(function() {
      dt = $('#table-rekanan').DataTable({
        stateSave: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= site_url('rekanan/jx_get_data') ?>',
          type: 'POST'
        }
      })
    })

    <?php
    $msg = $this->session->flashdata("msg");
    if($msg) { ?>
      Swal.fire(
        "<?= ucfirst($msg[0]) ?>",
        "<?= $msg[1] ?>",
        "<?= $msg[0] ?>"
      )
    <?php  }  ?>
  })

  function show_add() {
    $('#id').val('')
    $('#form-rekanan')[0].reset()

    $('#modal-form-rekanan').modal('show')
  }

  function show_edit(params) {
    let data = JSON.parse(atob(params));
    $('#id').val(data.id);
    $('#nama_perusahaan').val(data.nama_perusahaan);
    $('#pic').val(data.pic);
    $('#email').val(data.email);
    $('#telp').val(data.telp);

    $('#modal-form-rekanan').modal('show')
  }

  function show_delete(id) {
    $('#del_id').val(id)

    $('#modal-delete-rekanan').modal('show')
  }
</script>