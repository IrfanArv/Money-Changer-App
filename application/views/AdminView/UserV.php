
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Pengguna Aplikasi Money Changer</li>
                    </ol> 
                </div>
                
                <h4 class="page-title">Daftar Pengguna Aplikasi Money Changer</h4>
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
                                <thead>
                                    <tr>
                                        <th width="30px">ID Pengguna</th>
                                        <th>Nama</th>
                                        <th>Email Login</th>
                                        <th>Role</th>
                                        <th>Status</th>
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
    var save_method;

    $(document).ready(function() {
        table = $('#table').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('Administrator/user_list')?>",
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
    

    function accuser(id)
    {
        swal({
            title: "Akifkan Akun",
            text: "Aktifkan akun pengguna ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-primary",
            cancelButtonText: "Batal",
            confirmButtonText: "Aktifkan",
            closeOnConfirm: false,
            closeOnCancel: false
        },

        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url : "<?php echo site_url('Administrator/update_user')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success:function(result){
                        if(result.status == true){
                            reload_table();
                            swal("Berhasil", "Akun berhasil diaktivasi.", "success");
                        }else{
                            swal("Dibatalkan", "Akun batal diaktivasi :)", "error");
                        }
                    },
                    error: function(err){
                        swal("Gagal", "Akun gagal diaktivasi :)", "error");
                    }
                });
            } else {
                swal("Gagal", "Akun gagal diaktivasi :)", "error");
            }
        });

    
    }


</script>



