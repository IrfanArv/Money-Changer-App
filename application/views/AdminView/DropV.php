
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Drop Barang (RP)</li>
                    </ol> 
                </div>
                
                <h4 class="page-title">Drop Barang (RP)</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    
                    <p class="text-muted mb-3">
                    <button class="btn btn-primary waves-effect waves-light" onclick="reload_table()"><i class="mdi mdi-briefcase-download-outline"></i> Drop Rupiah</button>
                    <button class="btn btn-danger waves-effect waves-light" onclick="reload_table()"><i class="mdi mdi-briefcase-upload-outline"></i> Tarik Rupiah</button>
                        <table id="table" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Total Barang (RP)</th>
                                    <th>Tanggal Drop</th>
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
                <div class="card-body">
                    <span class="float-right text-muted font-weight-normal">Normal / 400</span>
                    <h1 class="font-54 font-weight-normal mt-0 mb-4">Aa</h1>
                    <h5 class="mb-0 font-weight-normal">Metrica</h5>
                </div><!--end card-body-->
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
    var save_method;

    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('Administrator/list_barang')?>",
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

    
    $('#search').click(function(){

        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(start_date != '' && end_date != ''){
            $('#table').DataTable().destroy();
            fetch_data(start_date,end_date);
        }else{
            swal("Tanggal dibutuhkan", "Kedua Tanggal Diperlukan dan Pilih yang akan ditampilkan!", "error");
        }

    });


</script>



