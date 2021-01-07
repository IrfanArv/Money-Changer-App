
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Rupiah</li>
                        <li class="breadcrumb-item active">Drop Rupiah</li>
                    </ol> 
                </div>
                
                <h4 class="page-title">Drop Rupiah</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    
                    <p class="text-muted mb-3">
                    <button class="btn btn-primary waves-effect waves-light" onclick="drop_barang()"><i class="mdi mdi-briefcase-download-outline"></i> Drop Rupiah</button>
                    <button class="btn btn-danger waves-effect waves-light" id="btnTarik" onclick="tarikBarang()"><i class="mdi mdi-briefcase-upload-outline"></i> Tarik Rupiah</button>
                    <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>
                        <table id="table" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Total Rupiah</th>
                                    <th>Terakhir Update</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="font-54 font-weight-normal mt-0 mb-4" id="total_drop"></h1>
                    <h5 class="mb-0 font-weight-normal">Total rupiah saat ini </h5>
                </div><!--end card-body-->
            </div>
        </div>
    </div>

    <div class="modal fade" id="drop_barang" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color:#ffffff!important">
                
                <div class="modal-header" style="background-color:#ffffff!important">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form">
                        <div id="isibarang">
                                
                        </div>
                    </form>
                </div>
                    
                <div class="modal-footer" style="background-color:#ffffff!important">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="tarikBarang" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color:#ffffff!important">
                
                <div class="modal-header" style="background-color:#ffffff!important">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body form">
                    <form action="#" id="formtarik">
                    <h5 class="mt-0"> Barang Terakhir dilaci</h5>
                        <div id="barang">
                                
                        </div>
                    </form>
                </div>
                    
                <div class="modal-footer" style="background-color:#ffffff!important">
                    <button type="button" id="btnTarik" onclick="tarik()" class="btn btn-primary">Tarik Semua</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    

<script type="text/javascript"> 

    var table;

    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('valas/adminvalas/list_barang')?>",
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

    function reload_table()
    {
        table.ajax.reload(null,false); 
        $( "#total_drop" ).load( "<?php echo site_url('valas/adminvalas/jumlah_barang')?>" );
    }


    function drop_barang()
    {
        $.ajax({
            url:"<?php echo site_url('valas/adminvalas/drop_barang/');?>",
            
            method:"POST", 
            success:function(data){
                $('#form')[0].reset(); 
                $('.form-group').removeClass('has-error'); 
                $('.help-block').empty(); 
                $('#drop_barang').modal('show'); 
                $('.modal-title').text('Drop Barang (Rupiah) Hari ini');
                $('#isibarang').html(data); 
                $('[name="jumlah"]').val(data.jumlah);
                }
            });
    }


    function tarikBarang()
    {
        $.ajax({
            url:"<?php echo site_url('valas/adminvalas/drop_barang/');?>",
            
            method:"POST", 
            success:function(data){
                $('#form')[0].reset(); 
                $('.form-group').removeClass('has-error'); 
                $('.help-block').empty(); 
                $('#tarikBarang').modal('show'); 
                $('.modal-title').text('Tarik dan kosongkan semua barang dari masing-masing laci ?');
                $('#barang').html(data); 
                }
            });
    }

    function save()
    {
        $('#btnSave').text('Drop Barang Sedang Berlangsung...'); 
        $('#btnSave').attr('disabled',true); 
        var url;

        
        url = "<?php echo site_url('valas/adminvalas/update_barang')?>";
        swal("Berhasil", "Semua Barang Berhasil di Drop ke Masing2 Laci", "success"); 

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
                    $('#drop_barang').modal('hide');
                    reload_table();
                    $( "#total_drop" ).load( "<?php echo site_url('valas/adminvalas/jumlah_barang')?>" );

                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Gan');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 

            }
        });
    }

    function tarik()
    {
        
        $('#btnTarik').attr('disabled',true); 
        var url;

        
        url = "<?php echo site_url('valas/adminvalas/tarik_barang')?>";
        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#formtarik').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#tarikBarang').modal('hide');
                    reload_table();
                    $( "#total_drop" ).load( "<?php echo site_url('valas/adminvalas/jumlah_barang')?>" );
                    swal("Berhasil", "Semua Barang Berhasil di Tarik", "success"); 
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                
                $('#btnTarik').attr('disabled',false); //set button enable 


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Gan');
                $('#btnTarik').attr('disabled',false); //set button enable 
                $('#tarikBarang').modal('hide');
                    reload_table();

            }
        });
    }

    $(document).ready(function() {
        
        $.ajax({    
            type: "GET",
            "url": "<?php echo site_url('valas/adminvalas/jumlah_barang')?>",
            dataType: "html",   
            success: function(response){                    
                $("#total_drop").html(response);   
            }
        });
    });
 


</script>



