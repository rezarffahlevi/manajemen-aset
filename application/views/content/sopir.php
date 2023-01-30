<style>
    .form-check-label {
        margin-right: 15px;
    }

    .form-check-label span {
        margin-left: 8px;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sopir
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a href="#">Sopir</a></li>
        </ol>
        <div style="margin-top:20px;">
            <button type="button" class="btn btn-primary" onclick="show_add()"><i class="fa fa-plus"></i> &nbsp; Tambah Data</a></button>
        </div>
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
                        <table id="table-sopir" class="table table-bordered text-center display">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Mobil</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
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
<div id="modal_form_sopir" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?= site_url('sopir/save/') ?>" id="form_sopir" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Sopir</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" />
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" />
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No. Telp</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="08xxxxxx" />
                    </div>
                    <div class="form-group">
                        <label for="mobil">Mobil</label>
                        <select class="js-example-basic-single js-states form-control" style="width: 100%" name="mobil" id="mobil" required>
                            <option value="">Pilih</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" style="width: 100%" name="status" id="status" required>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="cuti">Cuti</option>
                        </select>
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

<div id="modal_delete_sopir" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="<?= site_url('sopir/delete/') ?>" id="form_sopir" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Hapus Sopir</h4>
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
            dt = $('#table-sopir').DataTable({
                stateSave: true,
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?= site_url('sopir/jx_get_data') ?>',
                    type: 'POST'
                }
            })
        })

        $('#mobil').select2({
            ajax: {
                url: function(params) {
                    return '<?= base_url('sopir/ajax_mobil_list') ?>/' + (params.term ?? '')
                },
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function(data) {
                    // Transforms the top-level key of the response object from 'items' to 'results'
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
        $('#form_sopir')[0].reset()

        $('#modal_form_sopir').modal('show')
    }

    function show_edit(params) {
        let data = JSON.parse(atob(params));
        $('#id').val(data.id_sopir);
        $('#nama').val(data.nama);
        $('#no_telp').val(data.no_telp);
        $('#status').val(data.status);

        // Set the value, creating a new option if necessary
        if ($('#mobil').find("option[value='" + data.id_mobil + "']").length) {
            $('#mobil').val(data.id_mobil).trigger('change');
        } else {
            // Create a DOM Option and pre-select by default
            var newOption = new Option(data.plat, data.id_mobil, true, true);
            // Append it to the select
            $('#mobil').append(newOption).trigger('change');
        }

        $('#modal_form_sopir').modal('show')
    }

    function show_delete(id) {
        $('#del_id').val(id)

        $('#modal_delete_sopir').modal('show')
    }
</script>