<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Persetujuan Reservasi
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#">Material Multimedia</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="table-manajemen" class="table table-bordered text-center display">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Material Number</th>
                  <th>Material Desc</th>
                  <th>Brand</th>
                  <th>Vendor PN</th>
                  <th>Storage Location</th>
                  <th>PIC</th>
                  <th>Jumlah</th>
                  <th>Tanggal</th>
                  <!-- <th>Other</th> -->
                  <th width="50">Status</th>
                </tr>
              </thead>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>
    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="modal-approval" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('reservasi/approval/') ?>" id="form-material" method="POST">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Persetujuan</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="reservasi_id" id="reservasi_id" />
          <input type="hidden" name="material_id" id="material_id" />
          <input type="hidden" name="jumlah" id="jumlah" />
          Apakah anda menyetujui Reservasi ini?
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button> -->
          <button type="submit" name="status" value="Ditolak" class="btn btn-danger">Tolak</button>
          <button type="submit" name="status" value="Disetujui" class="btn btn-success">Setujui</button>
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
      dt = $('#table-manajemen').DataTable({
        stateSave: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= site_url('reservasi/jx_get_data') ?>',
          type: 'POST',
        },
      }).on( 'draw.dt', function () {
			if('<?= $this->session->userdata('level') ?>' == 'SPV' )
				$('.approval').css({cursor:'pointer'});
		} );

      <?php
      $msg = $this->session->flashdata("msg");
      if ($msg) { ?>
        Swal.fire(
          "<?= ucfirst($msg[0]) ?>",
          "<?= $msg[1] ?>",
          "<?= $msg[0] ?>"
        )
      <?php } ?>
    });
  })


  function onAprovalClick2(id) {
    Swal.fire({
      title: 'Persetujuan',
      text: "Apakah anda menyetujui Reservasi ini?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Setujui',
      cancelButtonText: 'Tolak',
      reverseButtons: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    }).then((result) => {
      if (result.isConfirmed) {

      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {

      }
    })
  }

  function onAprovalClick(params) {
    if('<?= $this->session->userdata('level') ?>' == 'Admin' )
      return;
      
    let data = JSON.parse(atob(params));
    console.log('data', data);
    $('#reservasi_id').val(data?.id)
    $('#material_id').val(data?.material_id)
    $('#jumlah').val(data?.jumlah)

    $('#modal-approval').modal('show')
  }
</script>
