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
    <!-- MODAL BELI -->
        <div class="modal-beli">
            <div class="modal fade bd-example-modal-xl" id="modal_transaksibeli" role="dialog">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body form">
                            
                            <div class="row">
                                <div class="col-6">

                                    <div class="card">
                                        <div class="card-body">
                                                <h4 class="mt-0 header-title">Input Transaksi</h4>
                                                <div class="general-label">
                                                    <form class="form-horizontal" id="form_jual" role="form">
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label >Cari Mata Uang </label> 
                                                                        <input class="form-control reset" id="pencarian"  name="id" type="text" placeholder="Ketik Mata Uang">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label >Mata Uang </label> 
                                                                        <input class="form-control reset" type="text" id="nama" name="nama" readonly="" placeholder="Mata Uang" >
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label >Harga Jual </label> 
                                                                        <input class="form-control reset" type="text" name="harga" id="harga"  readonly="" placeholder="0"value="">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <hr>
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label >Jumlah </label> 
                                                                        <input class="form-control reset" type="number" readonly="readonly" onkeyup="subTotal(this.value)" id="jumlah" min="0" name="jumlah" placeholder="Masukan Jumlah">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label >Sub Total </label> 
                                                                        <input class="form-control reset" type="text" name="sub_total" id="sub_total"  readonly="" placeholder="0" value="">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4 row align-self-center">
                                                                    <br>
                                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambah" disabled="disabled" onclick="addjual()"><i class="ti-angle-double-right"></i> Kirim Data</button>
                                                            </div>

                                                        </div>
                                                        
                                                    </form>
                                                    
                                                </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-6">
                            
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Data Transaksi</h4>
                                            <!-- <input type="text" name="no_invoice" id="no_invoice" value=""> -->
                                            <table id="tableTransaksiJual" class="table table-striped table-bordered nowrap" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Harga Jual</th>
                                                    <th>Jumlah</th>
                                                    <th>Sub Total</th>
                                                    <th>Opsi</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label">Total</label>
                                                    <div class="col-md-9">
                                                    <input class="form-control form-control-lg res" type="text" readonly="" name="total" id="total" value="<?= number_format( 
                                                        $this->cart->total(), 0 , '' , '.' ); ?>" >  
                                            </div>
                                        </div>
                                        </div>
                                        
                                        <button type="button" class="btn btn-primary waves-effect waves-light" id="selesai" disabled="disabled" ><i class="ti-reload" ></i> Proses Transaksi</button>
                                    </div>

                                </div>

                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
    <!-- MODAL BELI -->
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
    

// MATAUANG
    $(document).ready(function() {

        table = $('#table').DataTable({ 

            "processing": true, 
            "serverSide": true, 
            "order": [], 

            "ajax": {
                "url": "<?php echo site_url('Administrator/rate_list')?>",
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
                "url": "<?php echo site_url('Administrator/stock_list')?>",
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
            url : "<?php echo site_url('Administrator/edit_rate/')?>/" + id_matauang,
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
            url = "<?php echo site_url('Administrator/add_rate')?>";
            swal("Berhasil", "Mata uang baru berhasil ditambahkan", "success");
        } else {
            url = "<?php echo site_url('Administrator/update_rate')?>";
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
                    url : "<?php echo site_url('Administrator/delete_rate')?>/"+id_matauang,
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

// TRANSAKSI BELI

    function create_beli()
    {
        transaksi_beli_method = 'add';
        $('#form_jual')[0].reset(); 
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
        $('#modal_transaksibeli').modal('show'); 
        $('.modal-title').text('Transaksi Pembelian'); 

    }


    $(document).ready(function(){
        tabletransaksiju = $('#tableTransaksiJual').DataTable({
            paging: false,
            "info": false,
            "searching": false,
            
            "ajax": {
                "url": "<?php echo site_url('Administrator/cart_beli');?>",
                "type": "POST"
                },
            "columnDefs": [
            {
                "targets": [ 1 ],
                "orderable": false,
            },
            ],
            });
        
        $('#pencarian').focus();
        $('#selesai').removeAttr("disabled");
    });

    function subTotal(jumlah)
    {
        var harga = $('#harga').val().replace(".", "").replace(".", "");
        $('#sub_total').val(convertToRupiah(harga*jumlah));
        $('#tambah').removeAttr("disabled"); 
        $('#selesai').removeAttr("disabled");
    }

    function addbeli()
    {
        var id = $('#id').val();
        var jumlah = $('#jumlah').val();
        $.ajax({
            url : "<?php echo site_url('Administrator/add_transaksibeli');?>",
            type: "POST",
            data: $('#form_jual').serialize(),
            dataType: "JSON", 
            success: function(data){
                reload_table();
                $('#tambah').attr("disabled","disabled");
                $('#jumlah').attr("readonly","readonly");
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error adding data');
            }
        });
        showTotal();
        $('.reset').val('');
    }

    function showTotal()
    {
        var total = $('#total').val().replace(".", "").replace(".", "");
        var sub_total = $('#sub_total').val().replace(".", "").replace(".", "");
        $('#total').val(convertToRupiah((Number(total)+Number(sub_total))));
        
    }

    function convertToRupiah(angka)
    {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++)
        if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
    }

    $(function(){
        $("#pencarian").autocomplete({
            minLength: 1,
            source: function(request, response) { 

                jQuery.ajax({
                    url:      "<?php echo site_url('Administrator/cari_harga');?>",
                    data: {
                        keyword:request.term
                    },
                    dataType: "json",
                    success: function(data){
                        response(data);
                    }   
                })
            },


            select:  function(e, ui){
                var nama = ui.item.nama;
                var code = ui.item.id_matauang;
                $("#pencarian").val(code);
                $("#nama").val(nama);
                $("#harga").val(convertToRupiah(ui.item.harga_beli));
                $('#jumlah').removeAttr("readonly");
                $('#jumlah').focus();
                return false;
            }
        })
        .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li>" )
            .append( "<a>" + item.id_matauang + " " + item.nama + "</a>" )
            .appendTo( ul );
        };
    
    });

    $('#selesai').click(function(){
        
        $.ajax({
            url:"<?php echo site_url('Administrator/cetak_nota/');?>",
            
            method:"POST",
            success:function(data){
                $('#modalNota').modal('show');
                $('#isiModal').html(data);
                }
            });
    });

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
    
    function deleteitembeli(id,sub_total)
    {
        $.ajax({
            url : "<?= site_url('Administrator/deleteitembeli')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Gagal hapus');
            }
        });
        var ttl = $('#total').val().replace(".", "");
        $('#total').val(convertToRupiah(ttl-sub_total));
    }         
// TRANSAKSI BELI


</script>



