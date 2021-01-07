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
                <h4 class="page-title">Hello, <?php echo $this->session->userdata('username') ?></h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
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

    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3">
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

    <!-- <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <p class="text-muted mb-3">Statistik Harga Valas</p>
                        <div id="valasstat"></div>
                </div>
            </div>
        </div>

        <div class="col-6">
            
        </div>
    </div> -->
    
</div>
<!-- MATAUANG -->

<script type="text/javascript"> 

    var table;
    var tablestock;
    var real_time;
    
    function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
            tablestock.ajax.reload(null,false);
        }
    // CHART JUAL
    $(document).ready(function(){
        $.ajax({
            url: "<?php echo site_url('Administrator/chartjual')?>",
            dataType: 'JSON',
            type: 'POST',
            data: {get_values: true},
            success: function(response) {
                
               real_timepass =  Morris.Area({
                    parseTime:false,
                    element: 'pembelian',
                    data: response,
                    xkey: 'bulan',
                    ykeys: ['minggu','sum(total)'],
                    labels: ['Minggu ke','Pembelian Valas '],
                    resize: true,
                });
                // setInterval(function() { updateLiveTempGraph(real_time); }, 1000);
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



       

</script>



