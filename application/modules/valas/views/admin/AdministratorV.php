<!-- MATAUANG -->
    
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <!-- <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol> -->
                </div>
                <!--end /div-->
                <h4 class="page-title">Administrator Money Changer</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3">
                    <button class="btn btn-primary waves-effect waves-light" onclick="add_currency()">Tambah Mata Uang</button>
                    <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>
                        
                        <div class="row">
                            <div class="col-6">
                            <h4 class="mt-0 header-title">Harga Valas</h4>  
                                <table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0;">
                                    <thead>
                                        <tr>
                                            <th width="20">Mata Uang</th>
                                            <th width="20">Harga Jual</th>
                                            <th width="20">Harga Beli</th>
                                            <!-- <th width="20">Last Update</th>
                                            <th width="20">Keterangan</th> -->
                                            <th width="20">Opsi</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <h4 class="mt-0 header-title">Stock Global</h4>  
                                <table id="tablestock" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="20">No</th>
                                            <th>Mata Uang</th>
                                            <th>Harga Modal</th>
                                            <th>Stock</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3">Statistik Stock Valas</p>
                        <div id="stockstat"></div>
                </div>
            </div>
        </div> -->

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3">Statistik Pembelian Valas</p>
                        <div id="pembelian"></div>
                </div>
            </div>
        </div>
    </div>
    
</div>
 
    <div class="modal fade" id="modal_currency" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form">
                        <input type="hidden" value="" name="id_matauang"/> 
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Mata Uang</label>
                                <div class="col-sm-8">
                                    <input name="nama" type="text" class="form-control" placeholder="Mata Uang" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Harga Jual</label>
                                <div class="col-sm-8">
                                    <input name="harga_jual" type="number" class="form-control" placeholder="Harga Jual" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Harga Beli</label>
                                <div class="col-sm-8">
                                    <input name="harga_beli" type="number" class="form-control"  placeholder="Harga Beli" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-8">
                                    <input name="ket" type="text" class="form-control" placeholder="Contoh: SAR Kecil (Maksimal 200 Karakter)">
                                </div>
                        </div>
                        
                    </form>
                </div>
                    
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<!-- MATAUANG -->

<!-- TRANSAKSI BELI -->
    
    <!-- MODAL STRUK -->

        <div class="modal fade" id="modalNota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                
                    <div class="modal-body" id="isiModal">
                    
                    </div>
                
                    <div class="modal-footer">
                    <button  class="btn btn-success" onclick="print_nota()"><span class="fa fa-print"></span>  Cetak</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span>  Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- MODAL STRUK -->
<!-- TRANSAKSI BELI -->

<script type="text/javascript"> 

    var save_method; 
    var transaksi_beli_method; 
    var table;
    var tabletransaksiju;
    var tablestock;
    
// CHART JUAL
    $(document).ready(function(){
        $.ajax({
            url: "<?php echo site_url('valas/adminvalas/chartjual')?>",
            dataType: 'JSON',
            type: 'POST',
            data: {get_values: true},
            success: function(response) {
                Morris.Area({
                    parseTime:false,
                    element: 'pembelian',
                    data: response,
                    xkey: 'bulan',
                    ykeys: ['minggu','sum(total)'],
                    labels: ['Minggu ke','Pembelian Valas ']
                });
            }
        });
    });
// CHART JUAL

// MATAUANG
    $(document).ready(function() {

        table = $('#table').DataTable({ 

            "processing": true, 
            "serverSide": true, 
            "order": [], 

            "ajax": {
                "url": "<?php echo site_url('valas/adminvalas/rate_list')?>",
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

    $(document).ready(function() {

        tablestock = $('#tablestock').DataTable({ 

            "processing": true, 
            "serverSide": true, 
            "order": [], 

            "ajax": {
                "url": "<?php echo site_url('valas/adminvalas/stock_list')?>",
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

    function add_currency()
    {
        save_method = 'add';
        $('#form')[0].reset(); 
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
        $('#modal_currency').modal('show'); 
        $('.modal-title').text('Tambah Mata Uang Baru'); 
    }

    function edit_rate(id_matauang)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('valas/adminvalas/edit_rate/')?>/" + id_matauang,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[name="id_matauang"]').val(data.id_matauang);
                $('[name="nama"]').val(data.nama);
                $('[name="harga_jual"]').val(data.harga_jual);
                $('[name="harga_beli"]').val(data.harga_beli);
                $('[name="ket"]').val(data.ket);
                $('#modal_currency').modal('show');
                $('.modal-title').text('Update Mata Uang'); 

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
        tabletransaksiju.ajax.reload(null,false); //reload datatable ajax 
        tablestock.ajax.reload(null,false);
    }

    function save()
    {
        $('#btnSave').text('Menyimpan Data...'); 
        $('#btnSave').attr('disabled',true); 
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('valas/adminvalas/add_rate')?>";
            swal("Berhasil", "Mata uang baru berhasil ditambahkan", "success");
        } else {
            url = "<?php echo site_url('valas/adminvalas/update_rate')?>";
            swal("Berhasil", "Data mata uang berhasil diperbaharui", "success"); 
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
                    $('#modal_currency').modal('hide');
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

    function rate_delete(id_matauang)
    {

        swal({
            title: "Hapus Mata Uang",
            text: "Hapus data mata uang ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            cancelButtonText: "Batal",
            confirmButtonText: "Hapus",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo site_url('valas/adminvalas/delete_rate')?>/"+id_matauang,
                    type: "POST",
                    dataType: "JSON",
                    success:function(result){
                        if(result.status == true){
                            reload_table();
                            swal("Berhasil", "Mata uang berhasil dihapus.", "success");
                        }else{
                            swal("Dibatalkan", "Mata uang dibatalkan untuk dihapus :)", "error");
                        }
                    },
                    error: function(err){
                        swal("Dibatalkan", "Mata uang dibatalkan untuk dihapus :)", "error");
                    }
                });
            } else {
                swal("Dibatalkan", "Mata uang dibatalkan untuk dihapus :)", "error");
            }
        });
    }
// MATAUANG

// TRANSAKSI JUAL

    

    

    
    


    

    

    

    

    


    

    function selesai()
    {
        $.ajax({
            url:"<?php echo site_url('Administrator/cetak_nota/');?>",
            method:"POST",
            success:function(data){
                $('#modalNota').modal('show');
                $('#isiModal').html(data);
                }
            });
    }

    function print_nota(){
        window.print();
        cetak_struk();
    }
    
    function cetak_struk()
    {
        $.ajax({
            url : "<?php echo site_url('Administrator/proses/');?>",
            type: "post",
            dataType:"json",
            success:function(result){
                if(result.status == true){
                    $('#modalNota').modal('hide');
                    reload_table();
                    $('.res').val('');
        $('#pencarian').focus();
                }else{
        alert('gagal melakukan transaksi')
        }
            },
            error: function(err){
                alert('error transaksi')
            }
        });
    }
    
        
// TRANSAKSI JUAL
</script>




