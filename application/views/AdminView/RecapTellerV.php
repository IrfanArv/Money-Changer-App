
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Recap Transaksi Teller</li>
                    </ol> 
                </div>
                
                <h4 class="page-title">Recap Transaksi Teller</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <p class="text-muted mb-3">
                    <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>
                    <h4 id="status" class="mt-0 header-title"></h4>
                    <h4 id="today" class="mt-0 header-title">Data Transaksi Hari ini</h4>
                        <div class="row">
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="start_date" id="start_date">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="dripicons-calendar"></i>
                                                    </span>
                                                </div>
                                        </div> 
                                    </div>

                                    <label for="example-text-input" class="col-sm-1 col-form-label text-right"><i class="dripicons-arrow-right" style="font-size: 20px;"></i></label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="end_date" id="end_date">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="dripicons-calendar"></i>
                                                    </span>
                                                </div>
                                        </div> 
                                    </div>
                                    <div class="col-sm-2"><button type="button" class="btn btn-primary waves-effect waves-light" name = "search" id="search" ><i class="ti-search"></i> Cari</button></div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                            <h4 class="mt-0 header-title">Recap Transaksi Selesai</h4>
                                <table id="table" class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Teller</th>
                                            <th>Transaksi</th>

                                            <th>Total Transaksi</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                            <h4 class="mt-0 header-title">Recap Transaksi Gagal</h4>
                                <table id="table_gagal" class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Teller</th>
                                            <th>Transaksi</th>
                                            <th>Total Transaksi</th>
                                            <th>Detail</th>
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

    <div class="modal fade" id="modal_recap_teller" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body form">
                    
                </div>
                    
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    

<script type="text/javascript"> 

    var table;
    var table_gagal;
    var save_method;

    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('Administrator/list_recap_teller')?>",
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
        table_gagal = $('#table_gagal').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('Administrator/list_recap_teller_gagal')?>",
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
        table_gagal.ajax.reload(null,false); 
    }

    function detail_recap_teller(teller)
    {
        $.ajax({
            url:"<?php echo site_url('Administrator/validasibeli/')?>/"+ teller,
            method:"POST",
            success:function(data){
                $('#modal_recap_teller').modal('show'); 
                $('.modal-title').text('Detail Recap'); 
                $('#isiModal').html(data);
                }
            });
    }

    

    $('#end_date').bootstrapMaterialDatePicker({ 
        weekStart : 0, time: false ,
        todayBtn: 'linked',
        // format: "YYYY-MM-DD HH:mm:ss",
        autoclose: true
    });
    $('#start_date').bootstrapMaterialDatePicker({ 
        weekStart : 0, time: false , 
        todayBtn: 'linked',
        // format: "YYYY-MM-DD HH:mm:ss",
        autoclose: true
    }).on('change', function(e, date)
    {
    $('#end_date').bootstrapMaterialDatePicker('setMinDate', date);
    });


    

    function fetch_data(start_date='', end_date=''){
     table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "info":     false,
        "paging":   false,
        "order":[],
        "ajax":{
            "url": "<?php echo site_url('Administrator/DateRecapTellerSuccess')?>",
            type: "POST",
            data:{
                start_date:start_date, end_date:end_date
            },
        },
        "columnDefs": [
            { 
                "targets": [ -1 ], 
                "orderable": false, 
            },
            ],
    });
    }

    function fetch_data_gagal(start_date='', end_date=''){
     table_gagal = $('#table_gagal').DataTable({
        "processing": true,
        "serverSide": true,
        "info":     false,
        "paging":   false,
        "order":[],
        "ajax":{
            "url": "<?php echo site_url('Administrator/DateRecapTellerGagal')?>",
            type: "POST",
            data:{
                start_date:start_date, end_date:end_date
            },
        },
        "columnDefs": [
            { 
                "targets": [ -1 ], 
                "orderable": false, 
            },
            ],
    });
    }

    

    $('#search').click(function(){

        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(start_date != '' && end_date != ''){
            $('#table').DataTable().destroy();
            $('#table_gagal').DataTable().destroy();
            fetch_data(start_date,end_date);
            fetch_data_gagal(start_date,end_date);
            $('#status').text("Menampilkan Data dari Tanggal");
            $('#today').hide();
        }else{
            swal("Tanggal dibutuhkan", "Kedua Tanggal Diperlukan dan pilih yang akan ditampilkan!", "error");
        }

    });


</script>



