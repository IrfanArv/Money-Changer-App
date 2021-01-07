
</script>
<?php if($this->session->userdata('level')=='1'){ ;?>
<!-- MODAL LACI -->
<div class="modal fade" id="modal_laci" role="dialog" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content" >
            
            <div class="modal-header" >
                <h5 class="modal-title mt-0"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="isilaciuser">
                
            </div>
                
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- MODAL LACI -->
<!-- MODAL JUAL -->
<div class="modal-beli">
    <div class="modal fade bd-example-modal-xl" id="modal_transaksijual" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body form">
                    
                    <div class="row">
                        <div class="col-5">

                            <div class="card">
                                <div class="card-body">
                                        <h4 class="mt-0 header-title">Input Transaksi</h4>
                                        <div class="general-label">
                                            <form class="form-horizontal" id="form_jual" role="form">
                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label >Cari Mata Uang </label> 
                                                                <select name="id" id="pencarianjual" class="form-control" required>
                                                                </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label >Harga Modal </label> 
                                                                <div id="loading">
                                                                    <center> <img src="<?php echo base_url().'assets/200.gif'?>" width="50"> <small>Proses...</small></center>
                                                                </div>
                                                                <select name="harga_modal" id="harga_modal" class="form-control" required>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label >Harga Jual </label> 
                                                                <input class="form-control" type="number" readonly="readonly" name="jual" id="jual" placeholder="Harga Jual">
                                                        </div>
                                                    </div>

                                                </div>
                                                <hr>
                                                <div class="row">

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label >Jumlah </label> 
                                                                <input class="form-control reset" type="number" readonly="readonly" onkeyup="subTotaljual(this.value)" id="jumlahjual" min="0" name="jumlahjual" placeholder="Jumlah">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label >Sub Total </label> 
                                                                <input class="form-control reset" type="text" name="sub_total_jual" id="sub_total_jual"  readonly="" placeholder="0" value="">
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

                        <div class="col-7">
                    
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">Data Transaksi</h4>
                                    <!-- <input type="text" name="no_invoice" id="no_invoice" value=""> -->
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tableTransaksiJual">
                                        <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Harga Modal</th>
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

                                <form action="#" id="form_relasi">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Penjualan Untuk</label>
                                        <div class="col-sm-8">
                                            <select name="relasi" id="getdatarelasi" class="form-control" required>
                                            </select>
                                        </div>
                                    </div>
                                </form>

                                <button type="button" class="btn btn-primary waves-effect waves-light" id="selesai" disabled="disabled" ><i class="ti-reload" ></i> Proses Transaksi</button>
                            </div>

                        </div>

                    </div>


                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<!-- MODAL JUAL -->

<script type="text/javascript">

    $('#selesai').click(function()
    {
        {
        
        swal({
            title: "Cek Transaksi Kamu",
            text: "Yakin data yang kamu input sudah benar ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            cancelButtonClass: "btn-warning",
            cancelButtonText: "Cek Lagi",
            confirmButtonText: "Proses Transaksi",
            closeOnConfirm: false,
            closeOnCancel: false
        }, 

        function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url : "<?php echo site_url('valas/AdminValas/addpenjualan')?>",
                type: "POST",
                data: $('#form_relasi').serialize(),
                dataType:"JSON",
                success: function(data)
                {
                    if (data.redirect)
                    {
                        $('#modal_transaksijual').modal('hide');
                        reload_table();
                        $('.res').val('');
                        swal("Selesai", "Transaksi penjualan berhasil.", "success");
                        window.open(data.redirect, '_blank');
                    }
                    else
                    {
                        swal("Gagal", "Gagal melakukan transaksi", "error");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                alert('Error Gan');
                
                }
            });
        } else {
            swal("Dicek lagi", "Cek kembali inputan data transaksi", "warning");
        }
        });
    
        }
    });
 
    function laci_user() 
    { 
        $.ajax({ 
            url:"<?php echo site_url('valas/adminvalas/laci_user/');?>",
            method:"POST",
            success:function(data){
                $('#modal_laci').modal('show'); 
                $('.modal-title').text('Laci User Hari ini'); 
                $('#isilaciuser').html(data);
                }
            });
    }

    function create_jual()
    {
        transaksi_beli_method = 'add';
        $('#form_jual')[0].reset(); 
        $('.form-group').removeClass('has-error'); 
        $('.help-block').empty(); 
        $('#modal_transaksijual').modal('show'); 
        $('.modal-title').text('Penjualan Valas'); 
        $("#selesai").hide();

    }

    function addjual()
    {
        var id = $('#pencarianjual').val();
        var jumlahjual = $('#jumlahjual').val();
        var harga_modal = $('#harga_modal').val();
        $.ajax({
            url : "<?php echo site_url('valas/AdminValas/add_transaksijual');?>",
            type: "POST",
            data: $('#form_jual').serialize(),
            dataType: "JSON", 
            success: function(data){
                reload_table();
                $('#tambah').attr("disabled","disabled");
                $('#jumlahjual').attr("readonly","readonly");
                $('#pencarianjual').focus();
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
        var sub_total_jual = $('#sub_total_jual').val().replace(".", "").replace(".", "");
        $('#total').val(convertToRupiah((Number(total)+Number(sub_total_jual))));
        
    }

    $('#pencarianjual').ready(function(){
        
        $.ajax({
            url:"<?php echo site_url('valas/AdminValas/cari_mata_uang/');?>",
            
            method:"POST",
            success:function(data){
                $('#pencarianjual').html(data);
                }
            });
    });

    $('#getdatarelasi').ready(function(){
        
        $.ajax({
            url:"<?php echo site_url('valas/AdminValas/getRelasi/');?>",
            
            method:"POST",
            success:function(data){
                $('#getdatarelasi').html(data);
                
                }
            });
    });

    $(document).ready(function(){
        $("#harga_modal").change(function(){
            $('#jual').focus();
        });
    });

    $(document).ready(function(){
        $("#getdatarelasi").change(function(){
            $('#selesai').removeAttr("disabled");
            $("#selesai").show(); 

        });
    });

    

    $(document).ready(function(){
        $("#jual").change(function(){
            $('#jumlahjual').removeAttr("readonly");
                $('#jumlahjual').focus();
        });
    });

    $(document).ready(function(){ 
            $("#loading").hide();
            $("#pencarianjual").change(function(){ 
            $("#harga_modal").hide(); 
            $("#loading").show(); 
            
            $.ajax({
                type: "POST", 
                url: "<?php echo site_url('valas/adminvalas/listStock/');?>", 
                data: {mata_uang : $("#pencarianjual").val()}, 
                dataType: "json",
                beforeSend: function(e) {
                if(e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                },
                success: function(response){  
                $("#loading").hide(); 
                $("#harga_modal").html(response.list_Stock).show();
                $('#jual').removeAttr("readonly");
                // $('#jumlahjual').removeAttr("readonly");
                },
                error: function (xhr, ajaxOptions, thrownError) { 
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); 
                }
            });
            });
    }); 

    function subTotaljual(jumlahjual)
    {
        var jual = $('#jual').val().replace(".", "").replace(".", "");
        $('#sub_total_jual').val(convertToRupiah(jual*jumlahjual));
        $('#tambah').removeAttr("disabled"); 
        // $('#selesai').removeAttr("disabled");
    }

    function convertToRupiah(angka)
    {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++)
        if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return rupiah.split('',rupiah.length-1).reverse().join('');
    }

    $(document).ready(function(){
        tabletransaksiju = $('#tableTransaksiJual').DataTable({
            paging: false,
            "info": false,
            "searching": false,
            
            "ajax": {
                "url": "<?php echo site_url('valas/AdminValas/cart_jual');?>",
                "type": "POST"
                },
            "columnDefs": [
            {
                "targets": [ 1 ],
                "orderable": false,
            },
            ],
            });
        
        $('#mata_uang').focus();
        
    });

    function deleteitembeli(id,sub_total)
    {
        $.ajax({
            url : "<?= site_url('valas/AdminValas/deleteitembeli')?>/"+id,
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

    // jQuery(document).ready(function($){
    // working = false;
    // var do_sync = function(){
    //     if ( working ) { return; }
    //     working = true;
    //     jQuery.post(
    //         "<?php echo $this->config->item("sync_url"); ?>", 
    //         {},
    //         function(ret){
    //             working = false;
    //         }
    //     );
    // }
    // window.setInterval(do_sync, 10000);
    // });
    
</script>
<?php };?> 
<footer class="footer text-center text-sm-left">
    <div class="boxed-footer">&copy; <?php echo date("Y"); ?> Bafageh Tour and Travel | Aplikasi Money Changer
    <span class="text-muted d-none d-sm-inline-block float-right">Page rendered in <strong>{elapsed_time}</strong> seconds. | Made with <i class="mdi mdi-heart text-danger"></i> by <a href="http://irfanarv.gomaya.id/" target="_blank">Irfan Arifin</a></span></div>
</footer>