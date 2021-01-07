<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class Teller extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
        if($this->session->userdata('id') <= 0 )
        {
            redirect('setting/auth');
		}

		if(!$this->session->userdata('id'))
		{
			$this->header->get();
		}
	}
	
	public function logout()
	{
		$this->load->helper('cookie');
		delete_cookie('id'); 
		$this->session->sess_destroy();
		$this->header->get();
    }

    public function rate_listteller()
    {
        $list = $this->MatauangM->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rate) {
            $no++;
            $row = array();
            $row[] = $rate->nama;
            $row[] = 'Rp. ' . number_format( $rate->harga_jual, 0 , '' , '.' ) . ',-';
            $row[] = 'Rp. ' . number_format( $rate->harga_beli, 0 , '' , '.' ) . ',-';
            $row[] = date('d M Y - H:i:s', strtotime($rate->updated));
            $row[] = $rate->ket;
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->MatauangM->count_all(),
                        "recordsFiltered" => $this->MatauangM->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function add_transaksibeli()
    {
        $data = [
            'id' => $this->input->post('id'),
            'name' => $this->input->post('nama'),
            'price' => str_replace('.', '', $this->input->post('harga')),
            'qty' => $this->input->post('jumlah')
        ];
        $insert = $this->cart->insert($data);
        echo json_encode(["status" => TRUE]);
    }

    public function add_invoice() 
    {
        if($this->cart->contents() !==[]){
            $id_teller = $this->session->userdata('id');
            $invoice = $id_teller.'-'.$this->MatauangM->get_inv($id_teller);

            $output = '';
            $output = '
                <div class="invoice-head" style="margin-top:-15px;margin-bottom: 10px;">
                    <center>
                        <h4>Bafageh Money Changer</h4>
                        <p style="font-size: 14px;color: #000000;">Jalan Raya Puncak KM. 83
                        Ruko Bafageh Businees Center</p>
                    </center>
                    <div class="row">
                        <div class="col" style="font-size: 13px;color: #000000;">Order ID :</div>
                        <div class="col text-right" style="font-size: 13px;color: #000000;">'.$invoice.'</div>
                    </div>
                    <div class="row">
                        <div class="col" style="font-size: 13px;color: #000000;">Order Date :</div>
                        <div class="col text-right" style="font-size: 13px;color: #000000;">'.date('d/m/y - H:i').'</div>
                    </div>
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col" style="font-size: 13px;color: #000000;">Teller :</div>
                        <div class="col text-right" style="font-size: 13px;color: #000000;">'.$this->session->userdata('username').'</div>
                    </div>
                </div>
                
                <table style="font-size:12px;">
                    <thead>
                        <tr>
                            <th style="padding-right: 5px;"><font color="#000000">Currency</font></th>
                            <th style="padding-right: 5px;"><font color="#000000">Amount</font></th>
                            <th style="padding-right: 25px;"><font color="#000000">Price</font></th>
                            <th style="text-align:left;"><font color="#000000">Sub Total</font></th>
                        </tr>
                    </thead>
                    <tbody>';
                                    foreach($this->cart->contents() as $row){
                        $output .= 		'<tr>
                                            <td ><font color="#000000">'.$row["name"].'</font></td>
                                            <td ><font color="#000000">'.number_format($row["qty"]).'</font></td>
                                            <td ><font color="#000000">'.number_format($row["price"]) .'</font></td>
                                            <td style=";"><font color="#000000">'.number_format($row["subtotal"]) .'</font></td>
                                        </tr>';
                                        }
                        $output .= 		'<tr style="border-top: 4px double #000000; font-size:large; font-weight:bold">
                                            <td style="text-align:left" colspan="2" ><font color="#000000">Total :</font></td>
                                            
                                            <td colspan="2"><font color="#000000">Rp.'.number_format($this->cart->total(),0,',','.').'</font></td>
                                        </tr>
                                        
                    </tbody>
                </table>
                <br>
                            
                <div style="text-align:center;color: #000000;font-size: 14px;">Thank You</div>
                <div style="text-align:center;color: #000000;font-size: 14px;">For Rate Update Please Visit<br>www.bafageh.com</div>
            ';
        
            // ADD TO DATABASE
                $i = 0;
                $total		= $this->cart->total();
                foreach ($this->cart->contents() as $insert){
                    $no_invoice	= $invoice;
                    $teller		= $this->session->userdata('username');
                    $id 		= $insert['id'];
                    $q 			= $insert['qty'];
                    $sub_total	= $insert['subtotal'];
                    $rowid 		= $insert['rowid'];
                    $tgl 		= date('Y-m-d');
                    $datestring = '%H:%i';
                    $time 		= time();
                    $waktu 		= mdate($datestring, $time);
                    
                    $data = [
                        'invoice_no' => $invoice,
                        'matauang_id' => $insert['id'],
                        'nama_matauang' => $insert['name'],
                        'harga_beli' => $insert['price'],
                        'jumlah' => $insert['qty'],
                        'sub_total' => $insert['subtotal'],
                    ];
                    $masuk[] = $data;
                    $i++; 
 
                }
                $insert = $this->db->insert_batch('detail_pembelian', $masuk);
                $this->db->query("INSERT INTO pembelian (no_invoice,teller,total) VALUES ('$invoice','$teller','$total')");
                
                if($insert){
                    echo $output;
                    $this->cart->destroy();
                    
                }else{
                    echo json_encode(["status" => FALSE]);
                }
            // ADD TO DATABASE
        }else{
            echo('Transaksi Kosong');
        }

    }

    public function hitung_sukses_beli_teller()
    { 
		$teller = $this->session->userdata('username');
		$status = "Selesai";
		$query = $this->db->query("SELECT * FROM pembelian WHERE teller ='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
    }
    
    public function jumlah_sukses_beli_teller()
	{ 
		$query = $this->BackofficeM->get_total_beli_teller();
		echo json_encode($query);
    }
    
    public function detail_sukses_beli_teller()
	{
		$status	= "Selesai";
		$user = $this->session->userdata('username');
		$datasuksesbeli = $this->BackofficeM->get_detail_beli_sukses_teller($user,$status);
		$data = array();
		foreach ($datasuksesbeli as $dsb) {
			$row = array();
			$row[] = $dsb->no_invoice;
			$row[] = $dsb->teller;
			$row[] = 'Rp. ' . number_format( $dsb->total, 0 , '' , '.' ) . ',-';
			$row[] = date('d M Y - H:i:s', strtotime($dsb->tanggal_transaksi));
			$data[] = $row;
		}
		$output = '';
		$output = '
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped mb-0" id="tablesuksesbeli">
						<thead>
							<tr align="center">
								<th width="50">No</th>
								<th>ID Transaksi</th>
								<th>Validasi Oleh</th>
								<th>Total</th>
								<th>Waktu Transaksi</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody>';
						$i=1;
						foreach ($datasuksesbeli as $dsb) {
				$output .= '
							<tr align="center">
								<td width="50"><font color="#000000">'.$i.'</font></td>
								<td ><font color="#000000">'.$dsb->no_invoice.'</font></td>
								<td ><font color="#000000">'.$dsb->approved_by.'</font></td>
								<td ><font color="#000000">'.'Rp. ' . number_format( $dsb->total, 0 , '' , '.' ) . ',-'.'</font></td>
								<td><font color="#000000">'.date('d M Y - H:i:s', strtotime($dsb->tanggal_transaksi)).'</font></td>
								<td><a class="btn btn-sm btn-round btn-outline-secondary waves-effect" href="javascript:void(0)" title="Detail" onclick="detailriwayat('."'".$dsb->no_invoice."'".')"><i class="mdi mdi-format-list-checks"></i> Detail</a></td>
							</tr>';
							$i++;
							}
				$output .= '		
						</tbody>
					</table>
				</div>
			</div>
		</div>';
				
		echo $output;
    }
    
    public function hitung_gagal_beli_teller()
    { 
		$teller = $this->session->userdata('username');
		$status = "Di Tolak";
		$query = $this->db->query("SELECT * FROM pembelian WHERE teller='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
    }
    
    public function jumlah_tolak_beli_teller()
	{ 
		$query = $this->BackofficeM->get_total_beli_gagal_teller();
		echo json_encode($query);
    }
    
    public function cart_beli()
    {
        $data = [];
        $no = 1; 
        foreach ($this->cart->contents() as $items){
            $row = [];
            $row[] = $items["name"];
            $row[] = 'Rp. ' . number_format( $items['price'], 0 , '' , '.' ) . ',-';
            $row[] = $items["qty"];
            $row[] = 'Rp. ' . number_format( $items['subtotal'], 0 , '' , '.' ) . ',-';
            
            //add html for action
            $row[] = '<a 
                href="javascript:void()" style="color:rgb(255,128,128);
                text-decoration:none" onclick="deleteitembeli('
                    ."'".$items["rowid"]."'".','."'".$items['subtotal'].
                    "'".')"> <i class="fas fa-times"></i></a>';
            $data[] = $row;
            $no++;
        }
        $output = [
            "data" => $data,
        ];
        echo json_encode($output);
    }

    public function cari_harga()
    {
        if (isset($_SERVER['REQUEST_URI'])){ 
        $data = $this->MatauangM->cari_rate($_GET['keyword']); 
        echo json_encode($data);
        }
    }

    public function deleteitembeli($rowid)
    {
        $this->cart->update([
                'rowid'=>$rowid,
                'qty'=>0,]);
        echo json_encode(["status" => TRUE]);
    }

    public function riwayatransaksiteller()
    {
        $user = $this->session->userdata('username');
        $datasuksesbeli = $this->BackofficeM->get_riwayat_transaksi($user);
        $data = array();
        foreach ($datasuksesbeli as $dsb) {
            $row = array();
            $row[] = $dsb->no_invoice;
            $row[] = $dsb->teller;
            $row[] = 'Rp. ' . number_format( $dsb->total, 0 , '' , '.' ) . ',-';
            $row[] = date('d M Y - H:i:s', strtotime($dsb->tanggal_transaksi));
            $data[] = $row;
        }
        $output = '';
        $output = '
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>ID Transaksi</th>
                                <th>Total</th>
                                <th>Waktu Transaksi</th>
                                <th>Status</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>';
                        $i=1;
                        foreach ($datasuksesbeli as $dsb) {
                $output .= '
                            <tr>
                                <td width="50"><font color="#000000">'.$i.'</font></td>
                                <td ><font color="#000000">'.$dsb->no_invoice.'</font></td>
                                <td ><font color="#000000">'.'Rp. ' . number_format( $dsb->total, 0 , '' , '.' ) . ',-'.'</font></td>
                                <td><font color="#000000">'.date('d M Y - H:i:s', strtotime($dsb->tanggal_transaksi)).'</font></td>
                                <td ><font color="#000000">'.$dsb->status.'</font></td>
                                <td><a class="btn btn-sm btn-round btn-outline-secondary waves-effect" href="javascript:void(0)" title="Detail" onclick="detailriwayat('."'".$dsb->no_invoice."'".')"><i class="mdi mdi-format-list-checks"></i> Detail</a></td>
                            </tr>';
                            $i++;
                            }
                $output .= '		
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';
                
        echo $output;
    }

    public function detailriwayat($id)
    {
        $datatransaksi = $this->BackofficeM->get_by_id($id);
        $data = array();
        foreach ($datatransaksi as $dt) {
            $row = array();
            $row[] = $dt->nama_matauang;
            $row[] = 'Rp. ' . number_format( $dt->jumlah, 0 , '' , '.' ) . ',-';
            $row[] = 'Rp. ' . number_format( $dt->harga_beli, 0 , '' , '.' ) . ',-';
            $row[] = 'Rp. ' . number_format( $dt->sub_total, 0 , '' , '.' ) . ',-';
            $row[] = date('d M Y - H:i:s', strtotime($dt->tanggal_transaksi));
            $row[] = $dt->no_invoice;
            $row[] = $dt->teller;
            $row[] = 'Rp. ' . number_format( $dt->total, 0 , '' , '.' ) . ',-';
            $data[] = $row;
        }
        $output = '';
        $output = '
        <div class="invoice-head" style="margin-top:-15px;margin-bottom: 10px;">
                <center>
                    <h4>Bafageh Money Changer</h4>
                    <p style="font-size: 14px;color: #000000;">Jalan Raya Puncak KM. 83
                    Ruko Bafageh Businees Center</p>
                </center>
                <div class="row">
                    <div class="col" style="font-size: 13px;color: #000000;">Order ID :</div>
                    <div class="col text-right" style="font-size: 13px;color: #000000;">'.$dt->no_invoice.'</div>
                </div>
                <div class="row">
                    <div class="col" style="font-size: 13px;color: #000000;">Order Date :</div>
                    <div class="col text-right" style="font-size: 13px;color: #000000;">'.date('d/m/y - H:i', strtotime($dt->tanggal_transaksi)).'</div>
                </div>
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col" style="font-size: 13px;color: #000000;">Teller :</div>
                    <div class="col text-right" style="font-size: 13px;color: #000000;">'.$dt->teller.'</div>
                </div>
        </div>
        <table style="font-size:12px;">
            <thead>
                <tr>
                <th style="padding-right: 5px;"><font color="#000000">Currency</font></th>
                <th style="padding-right: 5px;"><font color="#000000">Amount</font></th>
                <th style="padding-right: 25px;"><font color="#000000">Price</font></th>
                <th style="text-align:left;"><font color="#000000">Sub Total</font></th>
                </tr>
            </thead>
            <tbody>';
                                    foreach ($datatransaksi as $dt) {
                    $output .= 		'<tr>
                                        <td ><font color="#000000">'.$dt->nama_matauang.'</font></td>
                                        <td ><font color="#000000">'.$dt->jumlah.'</font></td>
                                        <td ><font color="#000000">'.number_format($dt->harga_beli).'</font></td>
                                        <td><font color="#000000">'.number_format($dt->sub_total).'</font></td>
                                    </tr>';
                                    }
                    $output .= 		'<tr style="border-top: 4px double #000000; font-size:large; font-weight:bold">
                                        <td style="text-align:left" colspan="2" ><font color="#000000">Total :</font></td>
                                        
                                        <td colspan="2"><font color="#000000">Rp.'.number_format($dt->total,0,',','.').'</font></td>
                                    </tr>
                        
            </tbody>
        </table>
        <br>
        <div style="text-align:center;color: #000000;font-size: 14px;">Thank You</div>
        <div style="text-align:center;color: #000000;font-size: 14px;">For Rate Update Please Visit<br>www.bafageh.com</div>
        
        <div class="modal-footer">
            <button  class="btn btn-success btn-round waves-effect waves-light" onclick="printlagi('."'".$dt->no_invoice."'".')"><i class="mdi mdi-printer"></i>  Print Lagi</button>
            <button type="button" class="btn btn-soft-warning btn-round waves-effect waves-light" data-dismiss="modal"><i class="mdi mdi-transcribe-close"></i>  Tutup</button>
        </div>
            ';
        echo $output;
        
        
    }

    public function detail_tolak_beli_teller()
	{
		$status	= "Di Tolak";
		$user = $this->session->userdata('username');
		$datasuksesbeli = $this->BackofficeM->get_detail_beli_sukses_teller($user,$status);
		$data = array();
		foreach ($datasuksesbeli as $dsb) {
			$row = array();
			$row[] = $dsb->no_invoice;
			$row[] = $dsb->teller;
			$row[] = 'Rp. ' . number_format( $dsb->total, 0 , '' , '.' ) . ',-';
			$row[] = date('d M Y - H:i:s', strtotime($dsb->tanggal_transaksi));
			$data[] = $row;
		}
		$output = '';
		$output = '
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped mb-0">
						<thead>
							<tr align="center">
								<th width="50">No</th>
								<th>ID Transaksi</th>
								<th>Ditolak Oleh</th>
								<th>Total</th>
								<th>Waktu Transaksi</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody>';
						$i=1;
						foreach ($datasuksesbeli as $dsb) {
				$output .= '
							<tr align="center">
								<td width="50"><font color="#000000">'.$i.'</font></td>
								<td ><font color="#000000">'.$dsb->no_invoice.'</font></td>
								<td ><font color="#000000">'.$dsb->approved_by.'</font></td>
								<td ><font color="#000000">'.'Rp. ' . number_format( $dsb->total, 0 , '' , '.' ) . ',-'.'</font></td>
								<td><font color="#000000">'.date('d M Y - H:i:s', strtotime($dsb->tanggal_transaksi)).'</font></td>
								<td><a class="btn btn-sm btn-round btn-outline-secondary waves-effect" href="javascript:void(0)" title="Detail" onclick="detailriwayat('."'".$dsb->no_invoice."'".')"><i class="mdi mdi-format-list-checks"></i> Detail</a></td>
							</tr>';
							$i++;
							}
				$output .= '		
						</tbody>
					</table>
				</div>
			</div>
		</div>';
				
		echo $output;
	}

}