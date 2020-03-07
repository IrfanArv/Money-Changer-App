
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Recap Validasi</li>
                    </ol> 
                </div>
                
                <h4 class="page-title">Recap Validasi</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <p class="text-muted mb-3">
                    <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>
                            <table id="table" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead align="center">
                                    <tr>
                                        
                                        <th>ID Transaksi</th>
                                        <th>Teller</th>
                                        <th>Total</th>
                                        <th>Waktu</th>
                                        <th>Validasi Oleh</th>
                                        <th>Status</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                </tbody>
                            </table>
                </div>
            </div>
        </div>
    </div>

    

<script type="text/javascript"> 

    var table;
    var save_method;

    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('Administrator/pembelian_list')?>",
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
    }
    

    function batalkantransaksi(id)
    {

        swal({
                title: "Batalkan Transaksi",
                text: "Yakin transaksi dibatalkan ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                cancelButtonText: "Tidak",
                confirmButtonText: "Batalkan",
                closeOnConfirm: false,
                closeOnCancel: false
            },

            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url : "<?php echo site_url('Administrator/batalin_transaksi')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success:function(result){
                            if(result.status == true){
                                reload_table();
                                swal("Berhasil", "Transaksi telah dibatalkan.", "success");
                            }else{
                                swal("Gagal", "Pembatalan Transaksi Gagal :)", "error");
                            }
                        },
                        error: function(err){
                            swal("Gagal", "Pembatalan Transaksi Gagal :)", "error");
                        }
                    });
                } else {
                    swal("Gagal", "Pembatalan Transaksi Gagal :)", "error");
                }
            });
    }

    function sahkantransaksi(id)
    {

        swal({
                title: "Sahkan Transaksi",
                text: "Validasi dan sahkan transaksi ini ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                cancelButtonText: "Tidak",
                confirmButtonText: "Sahkan",
                closeOnConfirm: false,
                closeOnCancel: false
            },

            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url : "<?php echo site_url('Administrator/sahkantransaksi')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success:function(result){
                            if(result.status == true){
                                reload_table();
                                swal("Berhasil", "Transaksi telah divalidasi dan disahkan.", "success");
                            }else{
                                swal("Gagal", "Transaksi gagal disahkan :)", "error");
                            }
                        },
                        error: function(err){
                            swal("Gagal", "Transaksi gagal disahkan :)", "error");
                        }
                    });
                } else {
                    swal("Gagal", "Transaksi gagal disahkan :)", "error");
                }
            });
    }

    function terimatransaksi(id)
    {
        swal({
            title: "Terima Transaksi",
            text: "Terima Transaksi Pembelian ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-primary",
            cancelButtonText: "Batal",
            confirmButtonText: "Terima",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo site_url('Administrator/terimatransaksi')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success:function(result){
                        if(result.status == true){
                            reload_table();
                            swal("Berhasil", "Transaksi telah diterima.", "success");
                        }else{
                            swal("Dibatalkan", "Gagal Validasi Transaksi :)", "error");
                        }
                    },
                    error: function(err){
                        swal("Dibatalkan", "Gagal Validasi Transaksi :)", "error");
                    }
                });
            } else {
                swal("Dibatalkan", "Gagal Validasi Transaksi :)", "error");
            }
        });
    }


</script>



