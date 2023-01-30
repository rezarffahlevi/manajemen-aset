<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Material
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#">Material</a></li>
    </ol>
    <div style="margin-top:20px;">
      <button type="button" class="btn btn-primary purple" onclick="show_add()">Tambah Data</a></button>
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
            <table id="table-material" class="table table-bordered text-center display">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Material Number</th>
                  <th>Material Name</th>
                  <th>Brand</th>
                  <th>Vendor</th>
                  <th>Storage Loc</th>
                  <th>Jumlah</th>
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
<div id="modal-form-material" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('material/save/') ?>" id="form-material" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Material</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="id" id="id" />
            <label for="number">Material Number</label>
            <input type="text" class="form-control" name="number" id="number" />
          </div>
          <div class="form-group">
            <label for="material">Material Name</label>
            <input type="text" class="form-control" name="material" id="material" />
          </div>
          <div class="form-group">
            <label for="brand">Brand</label>
            <input type="text" class="form-control" name="brand" id="brand" />
          </div>
          <div class="form-group">
            <label for="vendor">Vendor</label>
            <input type="text" class="form-control" name="vendor" id="vendor" />
          </div>
          <div class="form-group">
            <label for="penyimpanan_id">Storage Location</label>
            <select class="js-example-basic-single js-states form-control" style="width: 100%" name="penyimpanan_id"
              id="penyimpanan_id">
              <option value="">Pilih</option>
            </select>
          </div>
          <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="text" class="form-control" name="jumlah" id="jumlah" />
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

<div id="modal-delete-material" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('material/delete/') ?>" id="form-material" method="POST">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Material</h4>
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
  $(function () {
    let dt = ''
    $(function () {
      dt = $('#table-material').DataTable({
        stateSave: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= site_url('material/jx_get_data') ?>',
          type: 'POST'
        }
      })
    })

    <?php
    $msg = $this->session->flashdata("msg");
    if ($msg) { ?>
      Swal.fire(
        "<?= ucfirst($msg[0]) ?>",
        "<?= $msg[1] ?>",
        "<?= $msg[0] ?>"
      )
    <?php } ?>

    $('#penyimpanan_id').select2({
      ajax: {
        url: function (params) {
          return '<?= base_url('penyimpanan/ajax_search') ?>/' + (params.term ?? '')
        },
        processResults: function (data) {
          data = JSON.parse(data);
          return {
            results: data.results
          };
        }
      }
    });
  })

  function show_add() {
    $('#id').val('')
    $('#form-material')[0].reset()
    $('#penyimpanan_id').val(null).trigger('change');

    $('#modal-form-material').modal('show')
  }

  function show_edit(params) {
    let data = JSON.parse(atob(params));
    $('#id').val(data.id);
    $('#number').val(data.number);
    $('#material').val(data.material);
    $('#brand').val(data.brand);
    $('#vendor').val(data.vendor);
    $('#jumlah').val(data.jumlah);
    var newOption = new Option(data.lokasi, data.penyimpanan_id, true, true);
    $('#penyimpanan_id').append(newOption).trigger('change');

    $('#modal-form-material').modal('show')
  }

  function show_delete(id) {
    $('#del_id').val(id)

    $('#modal-delete-material').modal('show')
  }
</script>