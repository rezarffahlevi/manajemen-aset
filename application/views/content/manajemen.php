<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Material Multimedia
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#">Material Multimedia</a></li>
    </ol>
    <?php if ($this->session->userdata('level') == 'Admin'): ?>
      <div class="row">
        <div class="col-md-12" style="margin-top:20px;">
          <button type="button" class="btn btn-primary" onclick="show_spr()">SPR</button>
          <button type="button" class="btn btn-success" onclick="show_update_stock()">UPDATE STOCK</button>
          <button type="button" class="btn btn-warning" onclick="show_reservasi()">RESERVASI</button>
          <button type="button" class="btn btn-danger" onclick="show_rma()">RMA</button>
        </div>
      </div>
    <?php endif; ?>
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
                  <th>Jumlah</th>
                  <!-- <th>Other</th> -->
                  <!-- <th width="50">Status</th> -->
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
<div id="modal-form-spr" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('manajemen/save_spr/') ?>" id="form-spr" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">SPR Material Multimedia</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <input type="hidden" name="id" id="spr_id" />
                <label for="judul">Judul SPR</label>
                <input type="text" class="form-control" name="judul" placeholder="Judul SPR" id="spr_judul" required />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="no_spr">No. SPR</label>
                <input type="text" class="form-control" name="no_spr" placeholder="No. SPR" id="spr_no_spr" required />
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="rab">Nilai RAB</label>
                <input type="number" min="0" class="form-control" name="rab" placeholder="xxx.xxx.xxx.xxx" id="spr_rab"
                  required />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="realissasi">Realisasi</label>
                <input type="number" min="0" class="form-control" name="realisasi" placeholder="xxx.xxx.xxx.xxx"
                  id="spr_realisasi" required />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="spr_jenis_anggaran">Jenis Anggaran</label>
                <select class="js-example-basic-single js-states form-control" style="width: 100%" name="jenis_anggaran"
                  id="spr_jenis_anggaran" required>
                  <option value="">Pilih</option>
                  <option value="Capex">Capex</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="tgl">Tanggal SPR</label>
                <input type="date" class="form-control" name="tgl" id="spr_tgl" required />
                <!-- <input type="datetime-local" class="form-control" name="created_date" id="created_date" required /> -->
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="spr_rekanan">Rekanan</label>
                <select class="js-example-basic-single js-states form-control" style="width: 100%" name="rekanan"
                  id="spr_rekanan" required>
                  <option value="">Pilih</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="spr_nomor_io">Nomor IO/PRK</label>
                <input type="text" class="form-control" name="nomor_io" placeholder="Nomor IO/PRK" id="spr_nomor_io"
                  required />
              </div>
            </div>
          </div>
          <div class="row" style="margin-top:16px">
            <div class="col-md-12" align="center">
              <h4 class="modal-title">List Material</h4>
            </div>
          </div>
          <div align="center" style="margin:16px">
            <button type="button" class="btn btn-info" onclick="addMaterialInput()">+</button>
            <button type="button" class="btn btn-info" onclick="removeMaterialInput()">-</button>
          </div>
          <div style="margin-top:16px" id="material-input">
            <input type="hidden" id="count_material" name="count_material" value="1" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="modal-delete-rent" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('rent/delete/') ?>" id="form-spr_delete" method="POST">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Hapus Data</h4>
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

<!-- Modal Update Stock -->
<div id="modal-form-update-stock" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('manajemen/update_stock/') ?>" id="form-update-stock" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Stock Material Multimedia</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" name="id" id="id_update_stoc" />
                <!-- <label for="no_spr">No. SPR</label>
                <select type="text" class="js-example-basic-single js-states form-control" name="no_spr" placeholder=""
                  id="no_spr" required>
                  <option>Pilih</option>
                </select> -->
              </div>
              <div class="form-group">
                <label for="material_number">Material Number</label>
                <select type="text" class="js-example-basic-single js-states form-control material" style="width: 100%"
                  name="material_number" placeholder="" id="update_material_number" required>
                  <option>Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="storage_loc">Storage Loc</label>
                <br />
                <select type="text" class="js-example-basic-single js-states form-control penyimpanan"
                  style="width: 100%" name="storage_loc" placeholder="" id="stock_storage_loc" required>
                  <option>Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="update_stock">Update Stock</label>
                <input type="number" min="0" class="form-control" name="update_stock" placeholder="" id="update_stock"
                  required />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Reservasi -->
<div id="modal-form-reservasi" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('manajemen/save_reservasi/') ?>" id="form-reservasi" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Reservasi Material</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" name="id" id="id" />
                <label for="material_number">Material Number</label>
                <select class="js-example-basic-single js-states form-control material" style="width: 100%"
                  name="material_number" placeholder="" id="reserv_material_number" required>
                  <option>Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="tgl">Tanggal Reservasi</label>
                <input type="date" class="form-control" name="tgl" id="reserv_tgl" required />
                <!-- <input type="datetime-local" class="form-control" name="created_date" id="created_date" required /> -->
              </div>
              <div class="form-group">
                <label for="storage_loc">Storage Loc</label>
                <select class="js-example-basic-single js-states form-control penyimpanan" style="width: 100%"
                  name="storage_loc" placeholder="" id="reserv_storage_loc" required>
                  <option>Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="pic">PIC</label>
                <input type="text" class="form-control" name="pic" placeholder="" id="pic" required />
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" min="0" class="form-control" name="jumlah" placeholder="" id="reserv_jumlah"
                  required />
              </div>
              <div class="form-group">
                <label for="lokasi">Lokasi Tujuan Reservasi</label>
                <input type="text" class="form-control" name="lokasi" placeholder="" id="lokasi" required />
              </div>
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
              </div>
            </div>
          </div>
          <input type="hidden" id="temp_jumlah" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal RMA -->
<div id="modal-form-rma" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('manajemen/save_rma/') ?>" id="form-rma" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">RMA</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <input type="hidden" name="id" id="id" />
                <label for="lokasi">Lokasi Barang</label>
                <input type="text" class="form-control" name="lokasi" placeholder="" id="lokasi" required />
              </div>
              <div class="form-group">
                <label for="material_number">Material Number</label>
                <select type="text" class="js-example-basic-single js-states form-control material" style="width: 100%"
                  name="material_number" placeholder="" id="rma_material_number" required>
                  <option>Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="tgl">Tanggal RMA</label>
                <input type="date" class="form-control" name="tgl" id="rma_tgl" required />
                <!-- <input type="datetime-local" class="form-control" name="created_date" id="created_date" required /> -->
              </div>
              <div class="form-group">
                <label for="storage_loc">Storage Loc</label>
                <select class="js-example-basic-single js-states form-control penyimpanan" style="width: 100%"
                  name="storage_loc" placeholder="" id="rma_storage_loc" required>
                  <option>Pilih</option>
                </select>
              </div>
              <div class="form-group">
                <label for="pic">PIC</label>
                <input type="text" class="form-control" name="pic" placeholder="" id="pic" required />
              </div>
              <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" min="0" class="form-control" name="jumlah" placeholder="" id="jumlah" required />
              </div>
              <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
  let materialInputCount = 0;
  $(function () {

    let dt = ''
    $(function () {
      dt = $('#table-manajemen').DataTable({
        stateSave: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= site_url('manajemen/jx_get_data') ?>',
          type: 'POST'
        }
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
    });

    $('.material').select2({
      ajax: {
        url: function (params) {
          return '<?= base_url('material/ajax_search') ?>/' + (params.term ?? '')
        },
        processResults: function (data) {
          data = JSON.parse(data);
          return {
            results: data.results
          };
        }
      }
    });

    $('#reserv_material_number').on("select2:selecting", function (e) {
      // what you would like to happen
      let jumlah = e.params?.args?.data?.jumlah;
      console.log(jumlah);
      $('#temp_jumlah').val(jumlah);
      $('#reserv_jumlah').val('')
    });

    $('#spr_rekanan').select2({
      ajax: {
        url: function (params) {
          return '<?= base_url('rekanan/ajax_search') ?>/' + (params.term ?? '')
        },
        processResults: function (data) {
          data = JSON.parse(data);
          return {
            results: data.results
          };
        }
      }
    });

    $('#reserv_jumlah').on('change', function (e) {
      if (parseInt($('#reserv_jumlah').val()) > parseInt($('#temp_jumlah').val())) {
        Swal.fire(
          "Peringatan",
          "Jumlah tidak boleh lebih dari stok, stok tersisa " + $('#temp_jumlah').val(),
          "warning"
        )
        e.target.value = '';
      }
    })

    addMaterialInput();
  })

  function addMaterialInput() {
    materialInputCount++;
    $('#material-input').append(
      renderMaterialInput(materialInputCount)
    );
    $('#count_material').val(materialInputCount);

    $('.penyimpanan').select2({
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
  }

  function removeMaterialInput() {
    if (materialInputCount < 2) {
      return Swal.fire(
        "Gagal",
        "Minimal input 1 material",
        "error"
      )
    }
    $(`#wrapper-input-${materialInputCount}`).remove();
    materialInputCount--;
    $('#count_material').val(materialInputCount);
  }

  function renderMaterialInput(params) {
    return `
          <div id="wrapper-input-${params}">
          <div class="row">
            <div class="col-md-2">
              <label for="mat_number_${params}">Material Number</label>
              <input type="text" class="form-control" name="mat_number_${params}" id="mat_number_${params}" required />
            </div>
            <div class="col-md-3">
              <label for="mat_name_${params}">Material Name</label>
              <input type="text" class="form-control" name="mat_name_${params}" id="mat_name_${params}" required />
            </div>
            <div class="col-md-2">
              <label for="mat_brand_${params}">Brand</label>
              <input type="text" class="form-control" name="mat_brand_${params}" id="mat_brand_${params}" required/>
            </div>
            <div class="col-md-2">
              <label for="mat_vendor_${params}">Vendor</label>
              <input type="text" class="form-control" name="mat_vendor_${params}" id="mat_vendor_${params}" required/>
            </div>
            <div class="col-md-2">
              <label for="mat_penyimpanan_id_${params}">Storage Location</label>
              <select class="js-example-basic-single js-states form-control penyimpanan" style="width: 100%" name="mat_penyimpanan_id_${params}"
                id="mat_penyimpanan_id_${params}" required>
                <option value="">Pilih</option>
              </select>
            </div>
            <div class="col-md-1">
              <label for="mat_jumlah_${params}">Jumlah</label>
              <input type="number" min="0" class="form-control" name="mat_jumlah_${params}" id="mat_jumlah_${params}" required />
            </div>
          </div>
          <hr/>
          </div>`;
  }

  function show_detail(params) {
    $.ajax({
      method: "GET",
      url: '<?= base_url('rent/detail/') ?>' + params,
      data: null
    })
      .done(function (res) {
        let data = JSON.parse(res);
        console.log(data)
        const terbilang = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima'];
        $('#detail_no_so').text(data.no_so);
        $('.detail_no_so').text(data.no_so);
        $('#detail_nama_pegawai').text(data.nama_pegawai);
        $('.detail_nama_pegawai').text(data.nama_pegawai);
        $('#detail_jabatan_pegawai').text(data.jabatan_pegawai);
        $('#detail_jumlah_penumpang').text(`${data.jumlah_penumpang} (${terbilang[data.jumlah_penumpang]}) Orang`);
        $('#detail_keperluan').text(data.keperluan);
        $('#detail_tanggal').text(data.tanggal);
        $('#detail_nama_kapool').text(data.nama_kapool);
        $('#detail_nama_ptl').text(data.nama_ptl);

        $('#detail_ttd_kapool').text(data.nama_kapool);
        $('#detail_ttd_ptl').text(data.nama_ptl);
        $('#detail_ttd_pegawai').text(data.nama_pegawai);

        $('#detail_nama_sopir').text(data.nama_sopir);
        $('.detail_nama_sopir').text(data.nama_sopir);
        $('#detail_plat').text(data.plat);
        $('#detail_nama_pelanggan').text(data.nama_pelanggan);
        $('#detail_alamat_pelanggan').text(data.alamat_pelanggan);
        $('#tgl_berangkat').text(new Date(data.tgl_berangkat).toISOString().slice(0, 10))
        $('#tgl_kembali').text(data.status_peminjaman == 'done' ? new Date(data.tgl_kembali).toISOString().slice(0, 10) : '...........');

        $('#modal_detail').modal('show');
      });

  }

  $('#created_date').on('change', e => {
    console.log(e.currentTarget.value)
  })

  function show_spr() {
    $('#id').val('')
    $('#form-spr')[0].reset()
    $('#spr_rekanan').val(null).trigger('change');

    // var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
    // var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
    // $('#created_date').val(localISOTime.substring(0, (localISOTime.indexOf("T") | 0) + 6 | 0));
    $('#modal-form-spr').modal('show')
  }

  function show_edit(params) {
    let data = JSON.parse(atob(params));
    $('#id').val(data.id_rent);
    $('#nama').val(data.nama);
    $('#tipe').val(data.tipe);
    $('#jabatan').val(data.jabatan);
    $('#email').val(data.email);

    $('#modal-form-spr').modal('show')
  }

  function edit_status(params) {
    let data = JSON.parse(atob(params));
    console.log('data', data);
    // let ubah_status = $('#ubah_status');
    // let sopir = $('#sopir');
    // $('#ubah_id').val(data.id_peminjaman);
    // ubah_status.empty();
    // ubah_status.append('<option value="run">Run</option>');
    // ubah_status.append('<option value="done">Done</option>');

    // if (data.status_peminjaman == 'queue') {
    //   ubah_status.val('run');
    //   $('#form-group-sopir').show();
    //   sopir.attr('required', true);
    // } else {
    //   ubah_status.val('done');
    //   sopir.attr('required', false);
    //   sopir.val(data.id_sopir);
    //   $('#form-group-sopir').hide();
    // }
    // $('#modal_status_rent').modal('show')
  }

  function show_delete(id) {
    $('#del_id').val(id)

    $('#modal-delete-rent').modal('show')
  }

  function show_update_stock() {
    $('#form-update-stock')[0].reset()

    var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
    var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
    $('#created_date').val(localISOTime.substring(0, (localISOTime.indexOf("T") | 0) + 6 | 0));
    $('#modal-form-update-stock').modal('show')
  }

  function show_reservasi() {
    $('#form-reservasi')[0].reset()

    var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
    var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
    $('#created_date').val(localISOTime.substring(0, (localISOTime.indexOf("T") | 0) + 6 | 0));
    $('#modal-form-reservasi').modal('show')
  }

  function show_rma() {
    $('#form-rma')[0].reset()

    var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
    var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
    $('#created_date').val(localISOTime.substring(0, (localISOTime.indexOf("T") | 0) + 6 | 0));
    $('#modal-form-rma').modal('show')
  }
</script>