<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Storage Location
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#">Storage Location</a></li>
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
            <table id="table-penyimpanan" class="table table-bordered text-center display">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Lokasi</th>
                  <th>Keterangan</th>
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
<div id="modal-form-penyimpanan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('penyimpanan/save/') ?>" id="form-penyimpanan" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Storage Location</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="id" id="id" />
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" id="lokasi" />
          </div>
          <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" ></textarea>
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

<div id="modal-delete-penyimpanan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('penyimpanan/delete/') ?>" id="form-penyimpanan" method="POST">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Storage Location</h4>
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
      dt = $('#table-penyimpanan').DataTable({
        stateSave: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= site_url('penyimpanan/jx_get_data') ?>',
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
    $('#form-penyimpanan')[0].reset()

    $('#modal-form-penyimpanan').modal('show')
  }

  function show_edit(params) {
    let data = JSON.parse(atob(params));
    $('#id').val(data.id);
    $('#lokasi').val(data.lokasi);
    $('#keterangan').val(data.keterangan);

    $('#modal-form-penyimpanan').modal('show')
  }

  function show_delete(id) {
    $('#del_id').val(id)

    $('#modal-delete-penyimpanan').modal('show')
  }
</script>