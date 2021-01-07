 
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Transaksi</li>
                        <li class="breadcrumb-item">Penjualan</li>
                        <li class="breadcrumb-item">Data Penjualan</li>
                        <li class="breadcrumb-item active">Rincian Penjualan Valas</li>
                    </ol> 
                </div>
                
                <h4 class="page-title">Rincian Penjualan Valas</h4>
            </div>
        </div>
    </div>
<?php echo $this->uri->segment(4); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3">
                    <button class="btn btn-success waves-effect waves-light" onclick="reload_table()"><i class="ti-reload"></i> Refresh</button>    
                        <table id="table" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>#ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama</th>
                                    <th>Bank/Perusahaan</th>
                                    <th>Total Transaksi</th>
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



    

<script type="text/javascript"> 
    var table;
    function reload_table()
    {
        table.ajax.reload(null,false); 
    }

    
        $(document).ready(function() 
        {
            table = $('#table').DataTable({ 
                "processing": true, 
                "serverSide": true, 
                "order": [], 
                "ajax": {
                    
                    "url": "<?php echo site_url('valas/adminvalas/detail_penjualan_list')?>",
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
    
        
    

</script>



