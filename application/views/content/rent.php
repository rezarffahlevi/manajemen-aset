<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Peminjaman Mobil
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><a href="#">Peminjama Mobil</a></li>
    </ol>
    <?php
    if ($tipe_user == 'Superadmin' || $tipe_user == 'User') : ?>
      <div style="margin-top:20px;">
        <button type="button" class="btn btn-primary" onclick="show_add()"><i class="fa fa-car"></i> &nbsp; Pinjam Mobil</a></button>
      </div>
    <?php endif; ?>
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
          <div class="box-header">
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="table-rent" class="table table-bordered text-center display">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>NO SO</th>
                  <th>Nama Pelanggan</th>
                  <th>PTL</th>
                  <th>Kapool</th>
                  <th>Sopir</th>
                  <th>Mobil</th>
                  <th>Tanggal Berangkat</th>
                  <th>Tanggal Kembali</th>
                  <th>Status</th>
                  <th width="250">Aksi</th>
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
<div id="modal_form_rent" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?= site_url('rent/save/') ?>" id="form_rent" method="POST">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Peminjaman Mobil</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="id" id="id" />
            <label for="no_so">No SO</label>
            <input type="text" class="form-control" name="no_so" placeholder="PA/AC/…/…" id="no_so" required />
          </div>
          <div class="form-group">
            <label for="created_date">Tanggal</label>
            <input type="datetime-local" class="form-control" name="created_date" id="created_date" required />
          </div>
          <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" required />
          </div>
          <div class="form-group">
            <label for="alamat_pelanggan">Alamat Pelanggan</label>
            <textarea class="form-control" name="alamat_pelanggan" id="alamat_pelanggan" placeholder="Alamat Pelanggan" required></textarea>
          </div>
          <div class="form-group">
            <label for="ptl">PTL</label>
            <select class="js-example-basic-single js-states form-control" style="width: 100%" name="ptl" id="ptl" required>
              <option value="">Pilih</option>
            </select>
          </div>
          <div class="form-group">
            <label for="kapool">Kapool</label>
            <select class="js-example-basic-single js-states form-control" style="width: 100%" name="kapool" id="kapool" required>
              <option value="">Pilih</option>
            </select>
          </div>
          <div class="form-group">
            <label for="pegawai">Pegawai</label>
            <select class="js-example-basic-single js-states form-control" style="width: 100%" name="pegawai" id="pegawai" required>
              <option value="">Pilih</option>
            </select>
          </div>
          <div class="form-group">
            <label for="keperluan">Keperluan</label>
            <textarea class="form-control" name="keperluan" id="keperluan" placeholder="Keperluan" required></textarea>
          </div>
          <div class="form-group">
            <label for="jumlah_penumpang">Jumlah Penumpang</label>
            <input type="text" class="form-control" name="jumlah_penumpang" id="jumlah_penumpang" placeholder="Jumlah Penumpang" required />
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


<div id="modal_status_rent" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('rent/update_status/') ?>" id="form_rent_status" method="POST">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pemberangkatan</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="ubah_id" />
          <div class="form-group" id="form-group-sopir">
            <label for="sopir">Sopir</label>
            <select class="js-example-basic-single js-states form-control" style="width: 100%" name="sopir" id="sopir" required>
              <option value="">Pilih</option>
            </select>
          </div>
          <div class="form-group">
            <label for="ubah_status">Status</label>
            <select class="form-control" name="status" id="ubah_status" required>
              <option value="">Pilih</option>
              <option value="queue">Queue</option>
              <option value="run">Run</option>
              <option value="done">Done</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Ubah</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="modal_delete_rent" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form action="<?= site_url('rent/delete/') ?>" id="form_rent_delete" method="POST">
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

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Peminjaman Mobil</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div style="text-align: center;">
              <img src="<?= base_url('assets/img/logo_icon.png') ?>" style="width: 80pt;" />
              <br /><br /><b>PT. INDONESIA COMNETS PLUS</b>
              <br />Jl. KH. Abdul Rochim No. 1, Kuningan Barat
              <br />Mampang - Jakarta Selatan 12710
              <br />Telp. 021-29532400 Email: humas@iconpln.cp.id www.iconpln.co.id
              <div style="width: 100%; height:1px; background-color: #000; margin:20px 0px;"></div>
              <h4 style="margin-bottom: 0; margin-top: 10px">
                S U R A T&nbsp;&nbsp;&nbsp;J A L A N
                <br />No. : <span id="detail_no_so"></span>
              </h4>
              PERMOHONAN KENDARAAN UNTUK KEPERLUAN
              <br />Umum - Aktivasi - Gangguan - Pemeliharaan - Penjualan - Marketing
            </div>

            <br />
            <div class="row">
              <div class="col-md-12">
                <table style="width: 100%;">
                  <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><span id="detail_nama_pegawai"></span></td>
                  </tr>
                  <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><span id="detail_jabatan_pegawai"></span></td>
                  </tr>
                  <tr>
                    <td>Jenis Kendaraan</td>
                    <td>:</td>
                    <td>Mobil</td>
                  </tr>
                  <tr>
                    <td>Jumlah Penumpang</td>
                    <td>:</td>
                    <td><span id="detail_jumlah_penumpang"></span></td>
                  </tr>
                  <tr>
                    <td>Tujuan/Keperluan</td>
                    <td>:</td>
                    <td> <span id="detail_keperluan"></span></td>
                  </tr>
                  <tr>
                    <td>No. SO/IO/AR</td>
                    <td>:</td>
                    <td><span class="detail_no_so"></span></td>
                  </tr>
                </table>
                <br>
                <table style="width: 100%; margin-top:10px;" align="center">
                  <tr align="center">
                    <td>
                      Menyetujui
                    </td>
                    <td>
                      Mengetahui
                    </td>
                    <td>
                      Jakarta, <span id="detail_tanggal"></span>
                    </td>
                  </tr>
                  <tr align="center">
                    <td><span id="detail_ttd_kapool" class="ttd">ttd</span></td>
                    <td><span id="detail_ttd_ptl" class="ttd">ttd</span></td>
                    <td><span id="detail_ttd_pegawai" class="ttd">ttd</span></td>
                  </tr>
                  <tr align="center">
                    <td>
                      (<span id="detail_nama_kapool"></span>)<br />
                      Kapool
                    </td>
                    <td>
                      (<span id="detail_nama_ptl"></span>)<br />
                      Supervisor
                    </td>
                    <td>
                      (<span class="detail_nama_pegawai"></span>)<br />
                      Pemohon
                    </td>
                  </tr>
                </table>

                <div style="width: 100%; height:1px; background-color: #000; margin:20px 0px;"></div>

                <div style="text-align: center;">
                  <h4 style="margin-bottom: 0; margin-top: 0">
                    PERINTAH PERJALANAN
                  </h4>
                  (Diisi oleh Bag. Kendaraan/Pool)
                </div>

                <br />

                <table style="width: 100%;">
                  <tr>
                    <td>Pengemudi</td>
                    <td>:</td>
                    <td colspan="7"><span id="detail_nama_sopir"></span></td>
                  </tr>
                  <tr>
                    <td>Tanggal Berangkat</td>
                    <td>:</td>
                    <td><span id="tgl_berangkat"></span></td>
                  <tr>
                    <td>Jenis Kendaraan</td>
                    <td>:</td>
                    <td>Mobil</td>
                  </tr>
                  <tr>
                    <td>No. Pol</td>
                    <td>:</td>
                    <td><span id="detail_plat"></span></td>
                  </tr>
                  <tr>
                    <td>Tanggal Kembali</td>
                    <td>:</td>
                    <td colspan="7"><span id="tgl_kembali"></span></td>
                  </tr>
                  <tr>
                    <td>Tujuan</td>
                    <td>:</td>
                    <td colspan="7"><span id="detail_nama_pelanggan"></span>, <span id="detail_alamat_pelanggan"></span></td>
                  </tr>
                  <tr align="center">
                    <td colspan="8"></td>
                    <td>
                      <div style="margin-top:20px;">
                        <p>Sopir</p>
                        <p class="detail_nama_sopir ttd">ttd</p>
                        (<span class="detail_nama_sopir"></span>)<br />
                        Sopir
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
    let dt = ''
    $(function() {
      dt = $('#table-rent').DataTable({
        stateSave: true,
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: '<?= site_url('rent/jx_get_data') ?>',
          type: 'POST'
        }
      })
    });


    $('#ptl').select2({
      ajax: {
        url: function(params) {
          return '<?= base_url('rent/ajax_search_user') ?>/PTL/' + (params.term ?? '')
        },
        processResults: function(data) {
          data = JSON.parse(data);
          return {
            results: data.results
          };
        }
      }
    });

    $('#kapool').select2({
      ajax: {
        url: function(params) {
          return '<?= base_url('rent/ajax_search_user') ?>/Kapool/' + (params.term ?? '')
        },
        processResults: function(data) {
          data = JSON.parse(data);
          return {
            results: data.results
          };
        }
      }
    });

    $('#pegawai').select2({
      ajax: {
        url: function(params) {
          return '<?= base_url('rent/ajax_search_user') ?>/Pegawai/' + (params.term ?? '')
        },
        processResults: function(data) {
          data = JSON.parse(data);
          return {
            results: data.results
          };
        }
      }
    });

    $('#sopir').select2({
      language: {
        noResults: function() {
          return "Sopir tidak tersedia";
        }
      },
      ajax: {
        url: function(params) {
          return '<?= base_url('rent/ajax_search_sopir') ?>/' + (params.term ?? '')
        },
        processResults: function(data) {
          data = JSON.parse(data);
          return {
            results: data.results
          };
        }
      }
    });
  })

  function show_detail(params) {
    $.ajax({
        method: "GET",
        url: '<?= base_url('rent/detail/') ?>' + params,
        data: null
      })
      .done(function(res) {
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

  function show_add() {
    $('#id').val('')
    $('#form_rent')[0].reset()
    $('#ptl').val(null).trigger('change');
    $('#kapool').val(null).trigger('change');
    $('#pegawai').val(null).trigger('change');

    var tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
    var localISOTime = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
    $('#created_date').val(localISOTime.substring(0, (localISOTime.indexOf("T") | 0) + 6 | 0));
    $('#modal_form_rent').modal('show')
  }

  function show_edit(params) {
    let data = JSON.parse(atob(params));
    $('#id').val(data.id_rent);
    $('#nama').val(data.nama);
    $('#tipe').val(data.tipe);
    $('#jabatan').val(data.jabatan);
    $('#email').val(data.email);

    $('#modal_form_rent').modal('show')
  }

  function edit_status(params) {
    let data = JSON.parse(atob(params));
    let ubah_status = $('#ubah_status');
    let sopir = $('#sopir');
    $('#ubah_id').val(data.id_peminjaman);
    ubah_status.empty();
    ubah_status.append('<option value="run">Run</option>');
    ubah_status.append('<option value="done">Done</option>');

    if (data.status_peminjaman == 'queue') {
      ubah_status.val('run');
      $('#form-group-sopir').show();
      sopir.attr('required', true);
    } else {
      ubah_status.val('done');
      sopir.attr('required', false);
      sopir.val(data.id_sopir);
      $('#form-group-sopir').hide();
    }
    $('#modal_status_rent').modal('show')
  }

  function show_delete(id) {
    $('#del_id').val(id)

    $('#modal_delete_rent').modal('show')
  }
</script>