 <!-- Right side column. Contains the navbar and content of the page -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <section class="content-header">
         <h1>
             Mobil
             <small></small>
         </h1>
         <ol class="breadcrumb">
             <li class="active"><a href="#">Mobil</a></li>
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
                         <table id="table-mobil" class="table table-bordered text-center display">
                             <thead>
                                 <tr>
                                     <th width="50">No</th>
                                     <th>Plat</th>
                                     <th>Warna</th>
                                     <th>Jenis Mobil</th>
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
 <div id="modal_form_mobil" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <form action="<?= site_url('mobil/save/') ?>" id="form_mobil" method="POST">
             <!-- Modal content-->
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Form Mobil</h4>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                         <input type="hidden" name="id" id="id" />
                         <label for="plat">Nomor Plat</label>
                         <input type="text" class="form-control" name="plat" id="plat" />
                     </div>
                     <div class="form-group">
                         <label for="warna">Warna</label>
                         <select class="form-control" name="warna" id="warna" required>
                             <option value="">Pilih</option>
                             <option>Putih</option>
                             <option>Hitam</option>
                             <option>Silver</option>
                         </select>
                     </div>
                     <div class="form-group">
                         <label for="jenis_mobil">Jenis Mobil</label>
                         <select class="js-example-basic-single js-states form-control" style="width: 100%" name="jenis_mobil" id="jenis_mobil" required>
                             <option value="">Pilih</option>
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

 <div id="modal_delete_mobil" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <form action="<?= site_url('mobil/delete/') ?>" id="form_mobil" method="POST">
             <!-- Modal content-->
             <div class="modal-content">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                     <h4 class="modal-title">Hapus Mobil</h4>
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
             dt = $('#table-mobil').DataTable({
                 stateSave: true,
                 ordering: false,
                 processing: true,
                 serverSide: true,
                 ajax: {
                     url: '<?= site_url('mobil/jx_get_data') ?>',
                     type: 'POST'
                 }
             })
         })

         $('#jenis_mobil').select2({
             ajax: {
                 url: function(params) {
                     return '<?= base_url('mobil/ajax_jenis_mobil_list') ?>/' + (params.term ?? '')
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
         $('#form_mobil')[0].reset()

         $('#modal_form_mobil').modal('show')
     }

     function show_edit(params) {
         let data = JSON.parse(atob(params));
         $('#id').val(data.id_mobil);
         $('#plat').val(data.plat);
         $('#warna').val(data.warna);
         $('#jenis_mobil').val(data.id_jenis);

         // Set the value, creating a new option if necessary
         if ($('#jenis_mobil').find("option[value='" + data.id_jenis + "']").length) {
             $('#jenis_mobil').val(data.id_jenis).trigger('change');
         } else {
             // Create a DOM Option and pre-select by default
             var newOption = new Option(data.jenis, data.id_jenis, true, true);
             // Append it to the select
             $('#jenis_mobil').append(newOption).trigger('change');
         }

         $('#modal_form_mobil').modal('show')
     }

     function show_delete(id) {
         $('#del_id').val(id)

         $('#modal_delete_mobil').modal('show')
     }
 </script>