
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Relasi Valas</li>
                    </ol> 
                </div>
                
                <h4 class="page-title">Data Relasi Valas</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3">
                    <button class="btn btn-primary waves-effect waves-light" onclick="addrelasi()">Tambah Data</button>
                    <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>    
                        <table id="table" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Nama Perusahaan</th>
                                    <th>No Telpon</th>
                                    <th>Alamat</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_relasi" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form">
                    <input type="hidden" value="" name="id_relasi"/>  
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input name="nama" type="text" class="form-control" placeholder="Nama" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Perusahaan</label>
                                <div class="col-sm-8">
                                    <input name="nama_perusahaan" type="text" class="form-control" placeholder="Nama Perusahaan" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">No Telpon</label>
                                <div class="col-sm-8">
                                    <input name="no_tel" type="number" class="form-control" placeholder="No Telpon" required>
                                </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea name="alamat" cols="10" class="form-control" rows="10"></textarea>
                                </div>
                        </div>
                        
                    </form>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    

<script type="text/javascript"> 
    var table;
    var save_method; 


    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

    $(document).ready(function() 
    {
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('valas/adminvalas/relasi_list')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                "targets": [ -1 ], 
                "orderable": false, 
            },
            ],
        });
    });

    function addrelasi()
    {
        save_method = 'add';
        $('#form')[0].reset(); 
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
        $('#modal_relasi').modal('show'); 
        $('.modal-title').text('Tambah Data Relasi'); 
    }

    function save()
    {
        $('#btnSave').text('Menyimpan Data...'); 
        $('#btnSave').attr('disabled',true); 
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('valas/adminvalas/add_relasi')?>";
            swal("Berhasil", "Data Relasi berhasil ditambahkan", "success");
        } else {
            url = "<?php echo site_url('valas/adminvalas/update_relasi')?>";
            swal("Berhasil", "Data Relasi berhasil diperbaharui", "success"); 
        }

        // ajax adding data to database 
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_relasi').modal('hide');
                    reload_table();

                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Gan');
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 

            }
        });
    }

    function edit_relasi(id_relasi)
    {
        save_method = 'update';
        $('#form')[0].reset();
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 

        
        $.ajax({
            url : "<?php echo site_url('valas/adminvalas/edit_relasi/')?>/" + id_relasi,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="id_relasi"]').val(data.id_relasi);
                $('[name="nama"]').val(data.nama);
                $('[name="nama_perusahaan"]').val(data.nama_perusahaan);
                $('[name="no_tel"]').val(data.telpon);
                $('[name="alamat"]').val(data.alamat);
                $('#modal_relasi').modal('show');
                $('.modal-title').text('Update Data Relasi'); 

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function relasi_delete(id_relasi)
    {

        swal({
            title: "Hapus Data",
            text: "Hapus data relasi ini ?",
            type: "warning",
            showCancelButton: true,
            cancelButtonClass: "btn-success",
            cancelButtonText: "Batal",
            confirmButtonText: "Hapus",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo site_url('valas/adminvalas/delete_relasi')?>/"+id_relasi,
                    type: "POST",
                    dataType: "JSON",
                    success:function(result){
                        if(result.status == true){
                            reload_table();
                            swal("Berhasil", "Data relasi berhasil dihapus.", "success");
                        }else{
                            swal("Dibatalkan", "Data relasi dibatalkan untuk dihapus :)", "error");
                        }
                    },
                    error: function(err){
                        swal("Dibatalkan", "Data relasi dibatalkan untuk dihapus :)", "error");
                    }
                });
            } else {
                swal("Dibatalkan", "Data relasi dibatalkan untuk dihapus :)", "error");
            }
        });
    }

</script>



