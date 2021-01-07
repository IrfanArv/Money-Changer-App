<style>
    page {
    background: white;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }

    
    page[size="A4"] {  
    width: 21cm;
    height: 29.7cm; 
    }
    page[size="A4"][layout="landscape"] {
    width: 29.7cm;
    height: 21cm;  
    }
    page[size="A3"] {
    width: 29.7cm;
    height: 42cm;
    }
    page[size="A3"][layout="landscape"] {
    width: 42cm;
    height: 29.7cm;  
    }
    page[size="A5"] {
    width: 14.8cm;
    height: 21cm;
    }
    page[size="A5"][layout="landscape"] {
    width: 21cm;
    height: 14.8cm;  
    }
    @page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
    p{

    }
  }
  /* ... the rest of the rules ... */
}

</style>

<div class="container-fluid ">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().''?>">Dashboard</a></li>
                        <li class="breadcrumb-item">Transaksi</li>
                        <li class="breadcrumb-item">Penjualan</li>
                        <li class="breadcrumb-item">Data Penjualan</li>
                        <li class="breadcrumb-item active">Faktur Penjualan</li>
                    </ol>
                    
                </div>
                
                <h4 class="page-title">#Penjualan <?php echo $id_jual; ?> <a href="# " onclick="window.close();" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Kembali ke data penjualan"><i class="dripicons-backspace"></i></a></h4>
            </div>
            
        </div>
        
    </div>
</div><br>
<center><a href="javascript:window.print()" class="btn btn-info d-print-none"><i class="fa fa-print"></i> Cetak Faktur</a></center><br><br>
<page size="A4">
    <br><br>
    <div class="row" >
        <div class="col-lg-10 mx-auto">
            <div class="card" style="box-shadow:none!important;">
                <div class="card-body invoice-head">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?php echo base_url().'uploads/faktur.png'?>" class="logo-sm mr-2" height="90" style="margin-top: 20px;margin-left: -30px;margin-bottom: -100px;">
                        </div>
                        <div class="col-md-10">
                            <center>
                            <h3 style="color:#000000!important;">PT. BAFAGEH TOUR AND TRAVEL</h3>
                            <p style="color:#000000!important;"> Jalan Raya Puncak KM 83 Desa Tugu Selatan Kecamatan Cisarua Kabupaten Bogor 
                                </br>Jawa Barat - Indoneisa (16750)
                                </br>Telepon: 0251 - 8254 159 Website: www.bafageh.com
                            </p>
                            </center>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" style="color:#000000!important;">
                            <address class="font-13">
                                    <br><strong class="font-14">Kepada Yth:</strong>
                                    <br><?php echo $nama; ?>
                                    <br>Di
                                    <br><?php echo $nama_perusahaan; ?>
                                    <br><?php echo $alamat; ?>
                                    <br><?php echo $telpon; ?>
                                    <br> 
                                    <br><strong class="font-14">ID Transaksi&emsp;&emsp;&emsp;&emsp; : <?php echo $id_jual; ?></strong>
                                    <br><strong class="font-14">Tanggal Transaksi&ensp;&ensp;: <?php echo date("d M Y - H:i:s", strtotime($tanggal_transaksi)).' WIB'; ?></strong>
                            </address>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Uang</th>
                                            <th>Jumlah Valas</th>
                                            <th>Kurs</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0; $sum = 0; foreach($jual as $j){ $i++; $sum+= $j->subtotal;?>
                                        <tr>
                                        <th><?php echo $i; ?></th>
                                        <th><?php echo $j->mata_uang; ?></th>
                                        <th><?php echo number_format($j->jumlah_valas); ?> </th>
                                        <th><?php echo 'Rp. ' . number_format( $j->harga_jual, 0 , '' , '.' ) . ',-'; ?></th>
                                        <th><?php echo 'Rp. ' . number_format( $j->subtotal, 0 , '' , '.' ) . ',-'; ?></th>
                                        </tr>
                                        <?php }?>
                                        <tr>
                                            <th colspan="3"></th>
                                            <td class="font-14">
                                                <b>Total</b>
                                            </td>
                                            <td class="font-14">
                                                <b><?php echo 'Rp. ' . number_format( $sum, 0 , '' , '.' ) . ',-'; ?></b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><br>
                    <strong style="color:#000000!important;" class="font-14">Bogor, <?php echo date("d M Y", strtotime($tanggal_transaksi)); ?></strong><br><br>
                    <div class="row" style="color:#000000!important;">
                        <div class="col-lg-4">
                            <div class=" float-left">
                                <p>Mengetahui</p>
                                <br><br><br>
                                <p class="border-top"></p>
                            </div>
                        </div>
                       

                    </div>

                </div>

            </div>
        </div>
    </div>
</page>

