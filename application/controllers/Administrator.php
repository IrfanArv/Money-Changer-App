<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class Administrator extends CI_Controller {

    public function __construct(){
		parent::__construct();
		
        if($this->session->userdata('id') <= 0 )
        {
            redirect('auth');
		}

		if(!$this->session->userdata('id'))
		{
			header('location:http://localhost/valas');
		}
		
	}
	
	public function logout()
	{
		$this->load->helper('cookie');
		delete_cookie('id');
		$this->session->sess_destroy();
		header('location:http://localhost/valas');
	}

    public function index()
    {
		
		echo "test";
	}

// START TELLER FUNCTION


	// CARI HARGA
		public function cari_harga()
		{
			if (isset($_SERVER['REQUEST_URI'])){ 
			$data = $this->MatauangM->cari_rate($_GET['keyword']); 
			echo json_encode( $data);
			}
		}
	// CARI HARGA

	// RATE LIST
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
	// END RATE LIST

	// TABLE TRANSAKSI BELI
		public function cart_beli(){
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
	// TABLE TRANSAKSI BELI

	// ADD TO CART BELI
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
	// ADD TO CART BELI 

	// CETAK STRUK ON CLICK PROSES TRANSAKSI DI TELLER VIEW
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
	// CETAK STRUK ON CLICK PROSES TRANSAKSI DI TELLER VIEW

	// DELETE ITEM CART BELI
		public function deleteitembeli($rowid){
			$this->cart->update([
					'rowid'=>$rowid,
					'qty'=>0,]);
			echo json_encode(["status" => TRUE]);
		}

	// DELETE ITEM CART BELI

	// RIWAYAT TRANSAKSI
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
	// RIWAYAT TRANSAKSI

	// DETAIL RIWAYAT
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
	// DETAIL RIWAYAT

// END TELLER FUNCTION

// BACKOFFICE FUNCTION START
	// DETAIL RIWAYAT
	public function detailriwayatbackoffice($id)
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
			<button type="button" class="btn btn-soft-warning btn-round waves-effect waves-light" data-dismiss="modal"><i class="mdi mdi-transcribe-close"></i>  Tutup</button>
		</div>
			';
		echo $output;
		
		
	}
	// DETAIL RIWAYAT
	public function waiting_list()
	{
		$waitingtrans = $this->BackofficeM->get_datatables();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($waitingtrans as $list) {
			
			$row = array();
			$no++;
			$row[] = '#'.$list->no_invoice.'';
			$row[] = $list->teller;
			$row[] = 'Rp. ' . number_format( $list->total, 0 , '' , '.' ) . ',-';
            $row[] = date('d M Y - H:i:s', strtotime($list->tanggal_transaksi)).' WIB';
            $row[] = '<span class="btn btn-sm btn-round btn-warning"><i class="mdi mdi-refresh mr-2"></i> ' .$list->status.'</span>';
            

			
			$row[] = '<a class="btn btn-sm btn-round btn-outline-secondary waves-effect" href="javascript:void(0)" title="Update" onclick="validasiTransaksiBeli('."'".$list->no_invoice."'".')"><i class="mdi mdi-check-all"></i> Validasi Transaksi</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->BackofficeM->count_all(),
						"recordsFiltered" => $this->BackofficeM->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function validasibeli($id)
	{
		$datatransaksi = $this->BackofficeM->get_by_id($id);
		$data = array();
		foreach ($datatransaksi as $dt) {
			$row = array();
			$row[] = $dt->nama_matauang;
			$row[] = $dt->jumlah;
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
										<td colspan="2"><font color="#000000">Rp. '.number_format($dt->total,0,',','.').'</font></td>
									</tr>
						
			</tbody>
		</table>
		<br>
		<div style="text-align:center;color: #000000;font-size: 14px;">Thank You</div>
		<div style="text-align:center;color: #000000;font-size: 14px;">For Rate Update Please Visit<br>www.bafageh.com</div>
		
		<div class="modal-footer">
			<button  class="btn btn-success btn-round waves-effect waves-light" onclick="accpembelian('."'".$dt->no_invoice."'".')"><i class="mdi mdi-file-check"></i>  Terima</button>
			<button  class="btn btn-danger btn-round waves-effect waves-light" onclick="tolakpembelian('."'".$dt->no_invoice."'".')"><i class="mdi mdi-cancel"></i>  Tolak</button>
			
		</div>
			';
		echo $output;
		
		
	}

	public function accbeli($id){ 
		$approved = $this->session->userdata('username');
		$this->db->query("UPDATE pembelian SET status='Selesai' ,approved_by='$approved' WHERE no_invoice='$id'");
		$this->db->query("UPDATE detail_pembelian SET status='Selesai' WHERE invoice_no='$id'");
		echo json_encode(array("status" => TRUE));
	}

	public function tolakbeli($id){ 
		$approved = $this->session->userdata('username');
		$this->db->query("UPDATE pembelian SET status='Di Tolak' ,approved_by='$approved' WHERE no_invoice='$id'");
		$this->db->query("UPDATE detail_pembelian SET invoice_no= '$id' WHERE invoice_no='$id'");
		echo json_encode(array("status" => TRUE));
	}

	public function hitung_sukses_beli(){ 
		$teller = $this->session->userdata('username');
		$status = "Selesai";
		$query = $this->db->query("SELECT * FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
	}

	public function hitung_sukses_beli_teller(){ 
		$teller = $this->session->userdata('username');
		$status = "Selesai";
		$query = $this->db->query("SELECT * FROM pembelian WHERE teller ='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
	}

	public function hitung_gagal_beli(){ 
		$teller = $this->session->userdata('username');
		$status = "Di Tolak";
		$query = $this->db->query("SELECT * FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
	}

	public function hitung_gagal_beli_teller(){ 
		$teller = $this->session->userdata('username');
		$status = "Di Tolak";
		$query = $this->db->query("SELECT * FROM pembelian WHERE teller='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
	}

	public function jumlah_sukses_beli(){ 
		$query = $this->BackofficeM->get_total_beli();
		echo json_encode($query);
	}

	public function jumlah_sukses_beli_teller(){ 
		$query = $this->BackofficeM->get_total_beli_teller();
		echo json_encode($query);
	}

	public function jumlah_tolak_beli(){ 
		$query = $this->BackofficeM->get_total_beli_gagal();
		echo json_encode($query);
	}

	public function jumlah_tolak_beli_teller(){ 
		$query = $this->BackofficeM->get_total_beli_gagal_teller();
		echo json_encode($query);
	}

	public function detail_sukses_beli()
	{
		$status	= "Selesai";
		$user = $this->session->userdata('username');
		$datasuksesbeli = $this->BackofficeM->get_detail_beli_sukses($user,$status);
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
								<th>Teller</th>
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
								<td ><font color="#000000">'.$dsb->teller.'</font></td>
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

	public function detail_tolak_beli()
	{
		$status	= "Di Tolak";
		$user = $this->session->userdata('username');
		$datasuksesbeli = $this->BackofficeM->get_detail_beli_sukses($user,$status);
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
								<th>Teller</th>
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
								<td ><font color="#000000">'.$dsb->teller.'</font></td>
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
// BACKOFFICE FUNCTION END

// START ADMINISTRATOR FUNCTION

	// START FUNCTION USER

		public function user()
		{
			$data['title']=$title = 'Daftar Pengguna Aplikasi Money Changer';
			$this->layout->display('AdminView/UserV', $data); 
		}

		public function user_list()
		{
			$list = $this->UserM->get_datatables();
			$data = [];
			$no = $_POST['start'];
			$n=0;
			foreach ($list as $user) {
				$n++;
				$row = [];
				$row[] = $user->id;
				$row[] = $user->nama;
				$row[] = $user->email;
				if($user->level == 3){
					$row[] = "<span class='btn btn-primary btn-round waves-effect waves-light'>Teller</span>";
				}elseif ($user->level == 2){
					$row[] = "<span class='btn btn-blue btn-round waves-effect waves-light'>Backoffice</span>";
				}elseif ($user->level == 1){
					$row[] = "<span class='btn btn-dark btn-round waves-effect waves-light'>Administrator</span>";
				}

				if($user->aktif == 1){
					$row[] = "<span class='btn btn-success btn-round waves-effect waves-light'><i class='mdi mdi-shield-check'></i> Akun Telah Aktif</span>";
				}else {
					$row[] = '<button class="btn btn-warning btn-square btn-outline-dashed waves-effect waves-light" roler="button" onClick="accuser('."'".$user->id."'".')"><i class="mdi mdi-av-timer"></i> Menunggu Aktivasi</button>';
				}

				$data[] = $row;
			}
			$output = [
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->UserM->count_all(),
				"recordsFiltered" => $this->UserM->count_filtered(),
				"data" => $data,
			];
			echo json_encode($output);
		}

		public function edit_user($id)
		{
			$data = $this->UserM->get_member($id);
			echo json_encode($data);
		}

		public function update_user($id)
		{
			$data = array(
				'aktif' => '1'
				);
			$this->db->where('id', $id);
			$this->db->update('user',$data);
			echo json_encode(array("status" => TRUE));

		}

	// END FUNCTION USER

	// START FUNCTION MATAUANG 
		public function rate_list()
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
				// $row[] = date('d M Y - H:i:s', strtotime($rate->updated));
				// $row[] = $rate->ket;
				

				
				$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Update" onclick="edit_rate('."'".$rate->id_matauang."'".')"><i class="dripicons-pencil"></i></a>
					<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="rate_delete('."'".$rate->id_matauang."'".')"><i class="dripicons-trash"></i></a>';
			
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

		public function stock_list()
		{
			$list = $this->StockM->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $sl) {
				$no++;
				$row = array();
				$row[] = $no;
				$row[] = $sl->mata_uang;
				$row[] = 'Rp. ' . number_format( $sl->harga_modal, 0 , '' , '.' ) . ',-';
				$row[] = number_format($sl->jumlah_stock);
				$data[] = $row;
			}

			$output = array(
							"draw" => $_POST['draw'],
							"recordsTotal" => $this->StockM->count_all(),
							"recordsFiltered" => $this->StockM->count_filtered(),
							"data" => $data,
					);
			echo json_encode($output);
		}

		public function add_rate()
		{

			$data = array(
					'nama' => $this->input->post('nama'),
					'harga_jual' => $this->input->post('harga_jual'),
					'harga_beli' => $this->input->post('harga_beli'),
					'ket' => $this->input->post('ket')
				);
			$insert = $this->MatauangM->save($data);
			echo json_encode(array("status" => TRUE));
		}

		public function edit_rate($id)
		{
			$data = $this->MatauangM->get_by_id($id);
			echo json_encode($data);
		}

		public function getrate()
		{
			$data = $this->MatauangM->getall();
			echo json_encode($data);
		}

		public function update_rate()
		{
			$data = array(
				'nama' => $this->input->post('nama'),
				'harga_jual' => $this->input->post('harga_jual'),
				'harga_beli' => $this->input->post('harga_beli'),
				'ket' => $this->input->post('ket')
				);
			$this->MatauangM->update(array('id_matauang' => $this->input->post('id_matauang')), $data);
			echo json_encode(array("status" => TRUE));
		}

		public function delete_rate($id)
		{
			$this->MatauangM->delete_by_id($id);
			echo json_encode(array("status" => TRUE));
		}
	// END FUNCTION MATAUANG

	// START SORTING FUNCTION TRANSAKSI BELI

		public function transcation_today()
		{
			$data['title']=$title = 'Transaksi Pembelian Hari ini';
			$this->layout->display('AdminView/PembelianV', $data); 
		}

		public function pembelian_list()
		{
			$list = $this->BackofficeM->get_datatables2();
			$data = [];
			$no = $_POST['start'];
			
			foreach ($list as $pmb) {
				
				$row = [];
				$row[] = $pmb->no_invoice;
				$row[] = $pmb->teller;
				$row[] = 'Rp. ' . number_format( $pmb->total, 0 , '' , '.' ) . ',-';
				$row[] = date('d M Y - H:i:s', strtotime($pmb->tanggal_transaksi));
				$row[] = $pmb->approved_by;
				if($pmb->status == "Menunggu"){
					$row[] = "<span class='btn btn-warning btn-round waves-effect waves-light'>Menunggu</span>";
				}elseif ($pmb->status == "Selesai"){
					$row[] = "<span class='btn btn-success btn-round waves-effect waves-light'>Selesai</span>";
				}elseif ($pmb->status == "Di Tolak"){
					$row[] = "<span class='btn btn-danger btn-round waves-effect waves-light'>Di Tolak</span>";
				}
				

				if($pmb->status == "Selesai"){
					$row[] = '<button class="btn btn-danger btn-round waves-effect waves-light" roler="button" onClick="batalkantransaksi('."'".$pmb->no_invoice."'".')"><i class="mdi mdi-close"></i> Batalkan Transaksi</button>';
				}elseif($pmb->status == "Di Tolak") {
					$row[] = '<button class="btn btn-success btn-round waves-effect waves-light" roler="button" onClick="sahkantransaksi('."'".$pmb->no_invoice."'".')"><i class="mdi mdi-shield-check-outline"></i> Sahkan Transaksi</button>';
				}elseif($pmb->status == "Menunggu"){
					$row[] = '<button class="btn btn-primary btn-round waves-effect waves-light" roler="button" onClick="terimatransaksi('."'".$pmb->no_invoice."'".')"><i class="mdi mdi-shield-check-outline"></i> Terima Transaksi</button>';
				}
				

				$data[] = $row;
			}
			$output = [
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->BackofficeM->count_all2(),
				"recordsFiltered" => $this->BackofficeM->count_filtered2(),
				"data" => $data,
			];
			echo json_encode($output);
		}

		public function batalin_transaksi($id)
		{
			$nama= $this->session->userdata('username');
			$data = array(
				'status' => 'Di Tolak',
				'approved_by' => $nama
				);
			$this->db->where('no_invoice', $id);
			$this->db->update('pembelian',$data);
			$this->db->query("UPDATE detail_pembelian SET status='Di Tolak' WHERE invoice_no='$id'");
			echo json_encode(array("status" => TRUE));

		}

		public function sahkantransaksi($id)
		{
			$nama= $this->session->userdata('username');
			$data = array(
				'status' => 'Selesai',
				'approved_by' => $nama
				);
			$this->db->where('no_invoice', $id);
			$this->db->update('pembelian',$data);
			$this->db->query("UPDATE detail_pembelian SET status='Selesai' WHERE invoice_no='$id'");
			echo json_encode(array("status" => TRUE));

		}

		public function terimatransaksi($id)
		{
			$nama= $this->session->userdata('username');
			$data = array(
				'status' => 'Selesai',
				'approved_by' => $nama
				);
			$this->db->where('no_invoice', $id);
			$this->db->update('pembelian',$data);
			$this->db->query("UPDATE detail_pembelian SET status='Selesai' WHERE invoice_no='$id'");
			echo json_encode(array("status" => TRUE));

		}

	// START SORTING FUNCTION TRANSAKSI BELI

	// RECAP PEMBELIAN
		public function recap_validasi()
		{
			$data['title']=$title = 'Recap Validasi Pembelian Backoffice';
			$this->layout->display('AdminView/RecapValidasiV', $data); 

		}
		public function recap_teller()
		{
			$data['title']=$title = 'Recap Transaksi Pembelian Teller';
			$this->layout->display('AdminView/RecapTellerV', $data); 

		}

		public function list_recap_teller()
		{
			$list = $this->BackofficeM->recap_teller_sukses();
			$data = array();
			$no = $_POST['start'];

			foreach ($list as $rct) {
				$no++;
				$row = array();
				$row[] = $rct->teller;
				$row[] = $rct->jumlah_transaksi. ' Transaksi Selesai';
				$row[] = 'Rp. ' . number_format( $rct->total, 0 , '' , '.' ) . ',-';
				$row[] = '<button class="btn btn-success btn-round waves-effect waves-light" roler="button" onClick="detail_recap_teller('."'".$rct->teller."'".')"><i class="mdi mdi-format-list-bulleted-type"></i> Detail</button>';
				$data[] = $row;
			}
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->BackofficeM->count_recap_teller(),
				"recordsFiltered" => $this->BackofficeM->count_filtered_teller_recap(),
				"data" => $data,
			);
		echo json_encode($output);
		}

		public function list_recap_teller_gagal()
		{
			$list = $this->BackofficeM->recap_teller_gagal();
			$data = array();
			$no = $_POST['start'];

			foreach ($list as $rct) {
				$no++;
				$row = array();
				$row[] = $rct->teller;
				$row[] = $rct->jumlah_transaksi. ' Transaksi Gagal';
				$row[] = 'Rp. ' . number_format( $rct->total, 0 , '' , '.' ) . ',-';
				$row[] = '<button class="btn btn-success btn-round waves-effect waves-light" roler="button" onClick="detail_recap_teller('."'".$rct->teller."'".')"><i class="mdi mdi-format-list-bulleted-type"></i> Detail</button>';
				$data[] = $row;
			}
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->BackofficeM->count_recap_teller_gagal(),
				"recordsFiltered" => $this->BackofficeM->count_filtered_teller_recap_gagal(),
				"data" => $data,
			);
		echo json_encode($output);
		}
	// RECAP PEMBELIAN

	// RECAP TRANSAKSI TELLER
	 function DateRecapTellerSuccess(){
		$start_date = $_POST['start_date']; 
		$end_date = $_POST['end_date'];
		$list = $this->BackofficeM->RecapTellerDate($start_date,$end_date);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $rct) {
			$no++;
			$row = array();
			$row[] = $rct->teller;
			$row[] = $rct->jumlah_transaksi;
			$row[] = 'Rp. ' . number_format( $rct->total, 0 , '' , '.' ) . ',-';
			$row[] = '<button class="btn btn-success btn-round waves-effect waves-light" roler="button" onClick="detail_recap_teller('."'".$rct->teller."'".')"><i class="mdi mdi-format-list-bulleted-type"></i> Detail</button>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		echo json_encode($output);
	}

	function DateRecapTellerGagal(){
		$start_date = $_POST['start_date']; 
		$end_date = $_POST['end_date'];
		$list = $this->BackofficeM->RecapTellerDateGagal($start_date,$end_date);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $rct) {
			$no++;
			$row = array();
			$row[] = $rct->teller;
			$row[] = $rct->jumlah_transaksi;
			$row[] = 'Rp. ' . number_format( $rct->total, 0 , '' , '.' ) . ',-';
			$row[] = '<button class="btn btn-success btn-round waves-effect waves-light" roler="button" onClick="detail_recap_teller('."'".$rct->teller."'".')"><i class="mdi mdi-format-list-bulleted-type"></i> Detail</button>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		echo json_encode($output);
	}

	// RECAP TRANSAKSI TELLER

	// DROP BARANG
	public function barang()
		{
			$data['title']=$title = 'Drop Barang (Rupiah)';
			$this->layout->display('AdminView/DropV', $data); 
		}

	public function list_barang()
		{
			$list = $this->BackofficeM->barang();
			$data = array();
			$no = $_POST['start'];

			foreach ($list as $rct) {
				$no++;
				$row = array();
				$row[] = $rct->nama;
				$row[] = 'Rp. ' . number_format( $rct->total_barang, 0 , '' , '.' ) . ',-';
				$row[] = date('d M Y - H:i:s', strtotime($rct->tanggal));
				$row[] = '<button class="btn btn-success btn-round waves-effect waves-light" roler="button" onClick="detail_recap_teller('."'".$rct->user_id."'".')"><i class="mdi mdi-format-list-bulleted-type"></i> Detail</button>';
				$data[] = $row;
			}
			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->BackofficeM->count_recap_teller(),
				"recordsFiltered" => $this->BackofficeM->count_filtered_teller_recap(),
				"data" => $data,
			);
		echo json_encode($output);
		}	
	// DROP BARANG

// END ADMINISTRATOR FUNCTION

    
}
