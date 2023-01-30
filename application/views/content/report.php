<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="#">Laporan</a></li>
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
                    <div class="box-header">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="from" id="from" class="form-control" />
                                </div>
                                <div class="col-md-2">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="to" id="to" class="form-control" />
                                </div>
                                <div class="col-md-2">
                                    <label>Laporan</label>
                                    <select name="group_by" id="group_by" class="form-control">
                                        <!-- <option value="">Pilih</option> -->
                                        <option value="all">All</option>
                                        <option value="pegawai">Pegawai</option>
                                        <option value="sopir">Sopir</option>
                                        <option value="mobil">Mobil</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <a id="print_report" class="btn btn-default pull-right" style="margin-top: 25px;"><i class="fa fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="table-data" class="table table-bordered text-center display">
                            <thead>
                                <th width="50">No </th>
                                <th>Nama Peminjam</th>
                                <th>Lokasi Kantor</th>
                                <th>Email Pegawai</th>
                                <th>Nama Sopir</th>
                                <th>No Telp</th>
                                <th>Jenis Mobil</th>
                                <th>Perusahaan</th>
                                <th>Plat Nomor</th>
                                <th>Jumlah Keberangkatan</th>
                                <th>Tujuan</th>
                                <th width="100">Tanggal</th>
                                <th>Jam</th>
                                <th>Dokumen Pendukung</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        let dt = '';
        let from = $('#from');
        let to = $('#to');
        let group_by = $('#group_by');

        let now = new Date();
        let defaultFrom = now.setDate(now.getDate() - 7);

        let formdata = {
            from: new Date(defaultFrom).toJSON().slice(0, 10),
            to: new Date().toJSON().slice(0, 10),
            group_by: 'all',
        };

        from.val(formdata.from);
        to.val(formdata.to);
        group_by.val(formdata.group_by);

        setTh();

        dt = $('#table-data').DataTable({
            stateSave: true,
            ordering: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url('report/jx_get_data') ?>',
                type: 'POST',
                data: function(d) {
                    d['from'] = formdata.from;
                    d['to'] = formdata.to;
                    d['group_by'] = formdata.group_by;
                },
            }
        })

        from.on('change', (e) => {
            e.preventDefault()
            let val = e.currentTarget.value;
            if (isEmpty(formdata.to) || val <= formdata.to) {
                formdata.from = val;
                dt.draw();
            } else if (val >= formdata.to) {
                from.val(formdata.from);
                alert('Tanggal dari tidak boleh lebih besar dari tanggal sampai');
            }
        });

        to.on('change', (e) => {
            e.preventDefault()
            let val = e.currentTarget.value;
            if (isEmpty(formdata.from) || val >= formdata.from) {
                formdata.to = val;
                dt.draw();
            } else if (val <= formdata.from) {
                to.val(formdata.to);
                alert('Tanggal dari tidak boleh lebih besar dari tanggal sampai');
            }
        });

        group_by.on('change', (e) => {
            e.preventDefault()
            dt.destroy();
            let val = e.currentTarget.value;
            formdata.group_by = val;
            setTh(val);
            dt = $('#table-data').DataTable({
                stateSave: true,
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= site_url('report/jx_get_data') ?>',
                    type: 'POST',
                    data: function(d) {
                        d['from'] = formdata.from;
                        d['to'] = formdata.to;
                        d['group_by'] = formdata.group_by;
                    },
                }
            })
        });


        $('#print_report').on('click', () => {
            window.open("<?= base_url('report/print/') ?>" + formdata.from + '/' + formdata.to + '/' + formdata.group_by);
        });

        function setTh(val = 'all') {
            let field = ['Nama Peminjam', 'Lokasi Kantor', 'Email Pegawai', 'Nama Sopir', 'No Telp', 'Jenis Mobil', 'Perusahaan', 'Plat Nomor', 'Jumlah Keberangkatan', 'Tujuan', 'Tanggal', 'Jam', 'Dokumen Pendukung'];
            switch (val) {
                case 'pegawai':
                    field = ['Nama Pegawai', 'Lokasi Kantor', 'Divisi', 'Jumlah Keberangkatan', 'Tanggal', 'Jam'];
                    break;
                case 'sopir':
                    field = ['Nama Sopir', 'No Telp', 'Tujuan', 'Jumlah Keberangkatan', 'Tanggal', 'Jam'];
                    break;
                case 'mobil':
                    field = ['No Plat', 'Perusahaan', 'Jenis Mobil', 'Jumlah Keberangkatan', 'Tanggal', 'Jam'];
                    break;
                default:
                    field = ['Nama Peminjam', 'Lokasi Kantor', 'Email Pegawai', 'Nama Sopir', 'No Telp', 'Jenis Mobil', 'Perusahaan', 'Plat Nomor', 'Jumlah Keberangkatan', 'Tujuan', 'Tanggal', 'Jam', 'Dokumen Pendukung'];
                    break;
            }
            let th = `<th width="50">No </th>`;
            field.forEach(dt => {
                if(dt == 'Tanggal')
                th += `<th width="100">${dt}</th>`;
                else
                th += `<th>${dt}</th>`;
            });
            $('#table-data thead').remove();
            $('#table-data tbody').remove();
            $('#table-data').append(`<thead><tr>` + th + `</tr></thead>`);
        }
    });

    function isEmpty(val) {
        return val == '' || val == null;
    }

    function show_add() {
        $('#id').val('')
        $('#form_rent')[0].reset()
        $('#ptl').val(null).trigger('change');
        $('#kapool').val(null).trigger('change');
        $('#pegawai').val(null).trigger('change');

        $('#modal_form').modal('show')
    }
</script>