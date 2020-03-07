<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="float-right">
                <!-- <ol class="breadcrumb"> 
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol> -->
                <!--end breadcrumb-->
            </div>
            <!--end /div-->
            <h4 class="page-title">Backoffice</h4>
        </div>
        <!--end page-title-box-->
    </div>
    <!--end col-->
</div>
<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Antrian Transaksi Beli</h4>
                <p class="text-muted mb-3">
                <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>
                    <table id="tablewaiting" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Teller</th>
                                <th>Jumlah</th>
                                <th>Waktu Transaksi</th>
                                <th>Status</th>
                                <th>Opsi</th>
                                
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
<!-- MODAL DETAIL SELESAI-->

<!-- MODAL LACI -->
<div class="modal fade" id="modal_laci" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title mt-0"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="isilaci">
                
            </div>
                
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- MODAL LACI -->

<!-- MODAL ACC -->
    <div class="modal fade" id="modalValidasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:74mm;">
                <div class="modal-content">
                
                    <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                
                    <div class="modal-body" id="isiModal">
                    </div>
                </div>
            </div>
    </div>
<!-- MODAL ACC -->

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
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })

    var table;
    var save_method;
    // TABLE WAITING LIST 
        $(document).ready(function() {
            
            table = $('#tablewaiting').DataTable({ 

                "processing": true, 
                "serverSide": true, 
                "order": [], 

                "ajax": {
                    "url": "<?php echo site_url('Administrator/waiting_list')?>",
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
    // TABLE WAITING LIST 

    // RELOAD
        function reload_table()
        {
            table.ajax.reload(null,false); 
        }
    // RELOAD

    // MODALVALIDASI
        function validasiTransaksiBeli(no_invoice)
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/validasibeli/')?>/"+ no_invoice,
                method:"POST",
                success:function(data){
                    $('#modalValidasi').modal('show');
                    $('#isiModal').html(data);
                    $('.modal-title').text('Validasi Transaksi Pembelian'); 
                    }
                });
        }
    // MODALVALIDASI

    // HITUNG PEMBELIAN SELESAI BY USERBACKOFFICE
        $(document).ready(function() {
            $.ajax({    
                type: "GET",
                "url": "<?php echo site_url('Administrator/hitung_sukses_beli')?>",
                dataType: "html",   
                success: function(response){                    
                    $("#transaksi_beli_valid").html(response);   
                }
            });
        });
    // HITUNG PEMBELIAN SELESAI BY USERBACKOFFICE

    // HITUNG PEMBELIAN DI TOLAK BY USER BACKOFFICE
        $(document).ready(function() {
            $.ajax({    
                type: "GET",
                "url": "<?php echo site_url('Administrator/hitung_gagal_beli')?>",
                dataType: "html",   
                success: function(response){                    
                    $("#transaksi_beli_gagal").html(response);   
                }
            });
        });
    // HITUNG PEMBELIAN DI TOLAK BY USER BACKOFFICE    

    // ACC BELI
        function accpembelian(no_invoice)
        {
            

                swal({
                title: "Validasi Transaksi",
                text: "Terima transaksi pembelian ini?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                cancelButtonText: "Batal",
                confirmButtonText: "Validasi",
                closeOnConfirm: false,
                closeOnCancel: false
                },

                function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url : "<?php echo site_url('Administrator/accbeli/')?>/"+ no_invoice,
                        type: "post",
                        dataType:"json",
                        success:function(result){
                            if(result.status == true){
                                $('#modalValidasi').modal('hide');
                                reload_table();
                                $('.res').val('');
                                $( "#transaksi_beli_valid" ).load( "<?php echo site_url('Administrator/hitung_sukses_beli')?>" );
                                $( "#total_acc_beli" ).load( "<?php echo site_url('Administrator/jumlah_sukses_beli')?>" );
                                $( "#isiModalbelisukses" ).load( "<?php echo site_url('Administrator/detail_sukses_beli')?>" );
                                swal("Berhasil", "Transaksi telah divalidasi.", "success");
                            }else{
                                swal("Dibatalkan", "Gagal Validasi Transaksi :)", "error");
                            }
                        },
                        error: function(err){
                            alert('Gagal Validasi')
                        }
                    });
                } else {
                    swal("Dibatalkan", "Gagal Validasi Transaksi :)", "error");
                }
                });
            
        }
    // ACC BELI

    // TOLAK BELI

        function tolakpembelian(no_invoice) 
        {
            swal({
                title: "Tolak Transaksi",
                text: "Yakin mau tolak transaksi pembelian ini ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonText: "Batal",
                confirmButtonText: "Tolak",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url : "<?php echo site_url('Administrator/tolakbeli/')?>/"+ no_invoice,
                        type: "post",
                        dataType:"json",
                        success:function(result){
                            if(result.status == true){
                                $('#modalValidasi').modal('hide');
                                reload_table();
                                $('.res').val('');
                                $( "#isiModalbelisukses" ).load( "<?php echo site_url('Administrator/detail_tolak_beli')?>" );
                                $( "#total_tolak_beli" ).load( "<?php echo site_url('Administrator/jumlah_tolak_beli')?>" );
                                $( "#transaksi_beli_gagal" ).load( "<?php echo site_url('Administrator/hitung_gagal_beli')?>" );
                                swal("Berhasil", "Transaksi telah ditolak.", "success");
                            }else{
                                swal("Dibatalkan", "Gagal Menolak Transaksi :)", "error");
                            }
                        },
                        error: function(err){
                            alert('Gagal Validasi')
                        }
                    });
                } else {
                    swal("Dibatalkan", "Gagal Menolak Transaksi :)", "error");
                }
            });
        }
    // TOLAK BELI
        
    //TOTAL HARGA JUMLAH BELI 
        $(document).ready(function() {
        
                $.ajax({    
                    type: "GET",
                    "url": "<?php echo site_url('Administrator/jumlah_sukses_beli')?>",
                    dataType: "html",   
                    success: function(response){                    
                        $("#total_acc_beli").html(response);   
                    }
                });
        });
    //TOTAL HARGA JUMLAH BELI

    // TOTAL HARGA JUMLAH DITOLAK
        $(document).ready(function() {
            $.ajax({    
                type: "GET",
                "url": "<?php echo site_url('Administrator/jumlah_tolak_beli')?>",
                dataType: "html",   
                success: function(response){                    
                    $("#total_tolak_beli").html(response);   
                }
            });
        });
    // TOTAL HARGA JUMLAH DITOLAK

    // LIST DETAIL RECAP PEMBELIAN SELESAI
        function detail_recap_beli_success()
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/detail_sukses_beli/');?>",
                method:"POST",
                success:function(data){
                    $('#modal_recap_beli_success').modal('show'); 
                    $('.modal-title').text('Detail Recap Transaksi Pembelian "Selesai"'); 
                    $('#isiModalbelisukses').html(data);
                    }
                });
        }
    // LIST DETAIL RECAP PEMBELIAN SELESAI

    // LIST DETAIL RECAP PEMBELIAN DI TOLAK
        function detail_recap_beli_gagal()
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/detail_tolak_beli/');?>",
                method:"POST",
                success:function(data){
                    $('#modal_recap_beli_success').modal('show'); 
                    $('.modal-title').text('Detail Recap Transaksi Pembelian "Di Tolak"'); 
                    $('#isiModalbelisukses').html(data);
                    }
                });
        }
    // LIST DETAIL RECAP PEMBELIAN DI TOLAK

    // MODAL DETAIL RIWAYAT TRANSAKSI
    function detailriwayat(no_invoice)
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/detailriwayatbackoffice/')?>/"+ no_invoice,
                method:"POST",
                success:function(data){
                    $('#modalRiwayat').modal('show');
                    $('#isiModalRiwayat').html(data);
                    $('.modal-title').text('Detail Transaksi'); 
                    }
                });
        }
    // MODAL DETAIL RIWAYAT TRANSAKSI
    function bukalaci() 
        {
            $.ajax({
                url:"<?php echo site_url('Administrator/riwayatransaksiteller/');?>",
                method:"POST",
                success:function(data){
                    $('#modal_laci').modal('show'); 
                    $('.modal-title').text('Laci Kamu'); 
                    $('#isilaci').html(data);
                    }
                });
        }  
</script>