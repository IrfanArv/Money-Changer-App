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
                <h4 class="page-title">Teller Money Changer</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>

    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Harga Valas</h4>
                    <p class="text-muted mb-3">
                    <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>
                            <table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Mata Uang</th>
                                        <th>Harga Jual</th>
                                        <th>Harga Beli</th>
                                        <th>Last Update</th>
                                        <th>Keterangan</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                </div>
            </div>
        </div>

        <div class="col-3">
            <div class="card">
                <h5 class="card-header bg-primary text-white mt-0">Recap Transaksi <?php echo $this->session->userdata('username');?> Hari ini </h5>

                <div class="card card-eco">
                    <div class="card-body">
                        <h4 class="title-text mt-0">Pembelian "Selesai" 
                        <button type="button" class="btn btn-outline-warning btn-round" data-toggle="tooltip" data-placement="top" title="Detail Transaksi" onclick="detail_recap_beli_success()"><i class="mdi mdi-format-list-checks"></i></button></h4>
                        <div class="d-flex justify-content-between">
                            <h3 class="font-weight-bold" id="transaksi_beli_valid"><h5 class="font-weight-bold" style="padding-right: 150px;padding-top: 6px;color:#50649c!important">Transaksi</h5></h3><i class="mdi mdi-shield-check-outline card-eco-icon text-success align-self-center"></i>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 text-truncate">Total:<h5 class="mb-0 text-truncate jumlah" id="total_acc_beli"></h5></h5>
                        </div>
                    </div>
                </div>

                <div class="card card-eco">
                    <div class="card-body">
                        <h4 class="title-text mt-0">Pembelian "Di Tolak"
                        <button type="button" class="btn btn-outline-warning btn-round" data-toggle="tooltip" data-placement="top" title="Detail Transaksi" onclick="detail_recap_beli_gagal()"><i class="mdi mdi-format-list-checks"></i></button></h4>
                        <div class="d-flex justify-content-between">
                        <h3 class="font-weight-bold" id="transaksi_beli_gagal"><h5 class="font-weight-bold" style="padding-right: 150px;padding-top: 6px;color:#50649c!important">Transaksi</h5></h3><i class="mdi mdi-shield-off-outline card-eco-icon text-danger align-self-center"></i>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 text-truncate">Total:<h5 class="mb-0 text-truncate jumlah" id="total_tolak_beli"></h5></h5>
                        </div>
                    </div>
                </div>

            </div>
            
                
            
        </div> 

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
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> × </button>
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
                                                                        <input class="form-control reset" id="pencarian"  name="id" type="text" placeholder="Ketik Mata Uang" >
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
                                                                    <label >Harga Beli </label> 
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
                                                                    <button type="button" class="btn btn-primary waves-effect waves-light" id="tambah" disabled="disabled" onclick="addbeli()"><i class="ti-angle-double-right"></i> Kirim Data</button>
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
                                                    <th>Harga Beli</th>
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
                        <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                        </div> -->
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>
    <!-- MODAL BELI -->
    <!-- MODAL STRUK -->

        <div class="modal fade" id="modalNota" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:74mm;">
                <div class="modal-content"style="background-color:#ffffff!important">
                    
                    <div class="modal-header" style="background-color:#ffffff!important">
                    <button type="button" class="close" id="tutupnotaprintx"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                
                    <div class="modal-body" id="isiModal" >
                    
                    </div>
                
                    <div class="modal-footer" style="background-color:#ffffff!important">
                    <button  class="btn btn-success" id="tombolprint" onclick="print_nota()"><span class="fa fa-print"></span>  Cetak</button>
                    <button type="button" class="btn btn-danger" id="tutupnotaprint"><span class="fa fa-close"></span>  Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- MODAL STRUK --> 
<!-- TRANSAKSI BELI -->

<!-- MODAL DETAIL SELESAI-->
<div class="modal fade" id="modal_recap_beli_success" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color:#ffffff!important">
            
            <div class="modal-header" style="background-color:#ffffff!important">
                <h5 class="modal-title mt-0"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="isiModalbelisukses">
                
            </div>
                
            <div class="modal-footer" style="background-color:#ffffff!important">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- MODAL DETAIL SELESAI -->
<!-- MODAL RIWAYAT TRANSAKSI -->
        <div class="modal fade" id="modalRiwayat" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:74mm;">
                <div class="modal-content">
                
                    <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                
                    <div class="modal-body" id="isiModalRiwayat">
                    </div>
                </div>
            </div>
    </div>
<!-- MODAL RIWAYAT TRANSAKSI -->

<script type="text/javascript"> 

    var save_method; 
    var transaksi_beli_method; 
    var table;
    var tabletransaksiju;

    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('Administrator/rate_listteller')?>",
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
        $('#modal_transaksibeli').on('shown.bs.modal', function() {
            $('#pencarian').trigger('focus');
        });
    });

    function create_beli()
    {
        transaksi_beli_method = 'add';
        $('#form_jual')[0].reset(); 
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
        $('#modal_transaksibeli').modal('show'); 
        $('.modal-title').text('Transaksi Pembelian '); 
    } 

    // SC SHOW MODAL TRANSAKSI
    shortcut.add("alt+s", function() {
        transaksi_beli_method = 'add';
        $('#form_jual')[0].reset(); 
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
        $('#modal_transaksibeli').modal('show'); 
        $('#modal_transaksibeli').modal('hide'); 
        $('.modal-title').text('Transaksi Pembelian'); 
    }); 

    // SC SEND DATA TO CART TABLE (TOMBOL KIRIM)
    shortcut.add("alt+k", function() {

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
        $('#pencarian').focus();
        $('#selesai').removeAttr("disabled");
        
    }); 

    // SC PROSES TRANSAKSI
    shortcut.add("alt+p", function() {

        $.ajax({
            url:"<?php echo site_url('Administrator/add_invoice/');?>",
            
            method:"POST", 
            success:function(data){
                $('#modalNota').modal('show');
                
                $('#isiModal').html(data);
                }
            });

    }); 

    // SC PRINT
    shortcut.add("alt+t", function() {
        window.print();
        $("#tombolprint").hide()
        reload_table();
        $('.res').val('');
        $('#pencarian').focus();
        $( "#transaksi_beli_valid" ).load( "<?php echo site_url('Administrator/hitung_sukses_beli_teller')?>" );
        $( "#total_acc_beli" ).load( "<?php echo site_url('Administrator/jumlah_sukses_beli_teller')?>" );
        $( "#isiModalbelisukses" ).load( "<?php echo site_url('Administrator/detail_sukses_beli_teller')?>" );
        $( "#transaksi_beli_gagal" ).load( "<?php echo site_url('Administrator/hitung_gagal_beli_teller')?>" );
        $( "#total_tolak_beli" ).load( "<?php echo site_url('Administrator/jumlah_tolak_beli_teller')?>" );
    }); 

    function reload_table()
    {
        table.ajax.reload(null,false); 
        tabletransaksiju.ajax.reload(null,false); 
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
        // $('#selesai').removeAttr("disabled");
    });

    function subTotal(jumlah)
    {
        var harga = $('#harga').val().replace(".", "").replace(".", "");
        $('#sub_total').val(convertToRupiah(harga*jumlah));
        $('#tambah').removeAttr("disabled"); 
        
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
        $('#selesai').removeAttr("disabled");
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
            url:"<?php echo site_url('Administrator/add_invoice/');?>",
            
            method:"POST", 
            success:function(data){
                $('#modalNota').modal('show');
                $('#isiModal').html(data);
                }
            });
    });

    $('#tutupnotaprint').click(function(){

        $('#modalNota').modal('hide');
        reload_table();
        $('.res').val('');
        $('#pencarian').focus();
       $("#tombolprint").show() 
       
    });

    $('#tutupnotaprintx').click(function(){

    $('#modalNota').modal('hide');
    reload_table();
    $('.res').val('');
    $('#pencarian').focus();
    $("#tombolprint").show() 

    });


    function print_nota(){
        window.print();
        $("#tombolprint").hide()
        reload_table();
        $('.res').val('');
        $('#pencarian').focus();
        $( "#transaksi_beli_valid" ).load( "<?php echo site_url('Administrator/hitung_sukses_beli_teller')?>" );
        $( "#total_acc_beli" ).load( "<?php echo site_url('Administrator/jumlah_sukses_beli_teller')?>" );
        $( "#isiModalbelisukses" ).load( "<?php echo site_url('Administrator/detail_sukses_beli_teller')?>" );
        $( "#transaksi_beli_gagal" ).load( "<?php echo site_url('Administrator/hitung_gagal_beli_teller')?>" );
        $( "#total_tolak_beli" ).load( "<?php echo site_url('Administrator/jumlah_tolak_beli_teller')?>" );
        
    }

    function printlagi(){
        $('#modal_recap_beli_success').modal('hide'); 
        window.print();
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

    function riwayattransaksi() 
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/riwayatransaksiteller/');?>",
                method:"POST",
                success:function(data){
                    $('#modal_recap_beli_success').modal('show'); 
                    $('.modal-title').text('Riwayat Transaksi Terakhir'); 
                    $('#isiModalbelisukses').html(data);
                    }
                });
        }   
        
        function detail_recap_beli_success() 
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/detail_sukses_beli_teller/');?>",
                method:"POST",
                success:function(data){ 
                    $('#modal_recap_beli_success').modal('show'); 
                    $('.modal-title').text('Detail Recap Transaksi Pembelian "Selesai"'); 
                    $('#isiModalbelisukses').html(data);
                    }
                });
        }  
   
     // LIST DETAIL RECAP PEMBELIAN DI TOLAK
    function detail_recap_beli_gagal()
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/detail_tolak_beli_teller/');?>",
                method:"POST",
                success:function(data){
                    $('#modal_recap_beli_success').modal('show'); 
                    $('.modal-title').text('Detail Recap Transaksi Pembelian "Di Tolak"'); 
                    $('#isiModalbelisukses').html(data);
                    }
                });
        }
    // LIST DETAIL RECAP PEMBELIAN DI TOLAK

    // HITUNG PEMBELIAN SELESAI BY USERBACKOFFICE
    $(document).ready(function() {
            $.ajax({    
                type: "GET",
                "url": "<?php echo site_url('Administrator/hitung_sukses_beli_teller')?>",
                dataType: "html",   
                success: function(response){                    
                    $("#transaksi_beli_valid").html(response);   
                }
            });
        });
    // HITUNG PEMBELIAN SELESAI BY USERBACKOFFICE

    //TOTAL HARGA JUMLAH BELI 
    $(document).ready(function() {
        
        $.ajax({    
            type: "GET",
            "url": "<?php echo site_url('Administrator/jumlah_sukses_beli_teller')?>",
            dataType: "html",   
            success: function(response){                    
                $("#total_acc_beli").html(response);   
            }
        });
    });
    //TOTAL HARGA JUMLAH BELI

      // HITUNG PEMBELIAN DI TOLAK BY USER BACKOFFICE
      $(document).ready(function() {
            $.ajax({    
                type: "GET",
                "url": "<?php echo site_url('Administrator/hitung_gagal_beli_teller')?>",
                dataType: "html",   
                success: function(response){                    
                    $("#transaksi_beli_gagal").html(response);   
                }
            });
        });
    // HITUNG PEMBELIAN DI TOLAK BY USER BACKOFFICE

    // TOTAL HARGA JUMLAH DITOLAK
    $(document).ready(function() {
            $.ajax({    
                type: "GET",
                "url": "<?php echo site_url('Administrator/jumlah_tolak_beli_teller')?>",
                dataType: "html",   
                success: function(response){                    
                    $("#total_tolak_beli").html(response);   
                }
            });
    });

    // MODAL DETAIL RIWAYAT TRANSAKSI
    function detailriwayat(no_invoice)
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/detailriwayat/')?>/"+ no_invoice,
                method:"POST",
                success:function(data){
                    $('#modalRiwayat').modal('show');
                    $('#isiModalRiwayat').html(data);
                    $('.modal-title').text('Detail Transaksi'); 
                    }
                });
        }
    // MODAL DETAIL RIWAYAT TRANSAKSI


        
    
</script>



