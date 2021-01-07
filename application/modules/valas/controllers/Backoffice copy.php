<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class Backoffice extends CI_Controller {

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
    
    public function jumlah_barang_user()
	{ 
		$id= $this->session->userdata('id');
		$query = $this->UserM->get_total_barang_user($id);
		echo json_encode($query);
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
    
    public function hitung_sukses_beli()
    { 
		$teller = $this->session->userdata('username');
		$status = "Selesai";
		$query = $this->db->query("SELECT * FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
    }
    
    public function hitung_gagal_beli()
    { 
		$teller = $this->session->userdata('username');
		$status = "Di Tolak";
		$query = $this->db->query("SELECT * FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE()");
		echo json_encode($query->num_rows());
    }

    public function accbeli($id)
    {  
		$approved = $this->session->userdata('username');
		$this->db->query("UPDATE pembelian SET status='Selesai' ,approved_by='$approved' WHERE no_invoice='$id'");
		$this->db->query("UPDATE detail_pembelian SET status='Selesai' ,approved='$approved' WHERE invoice_no='$id'");
		echo json_encode(array("status" => TRUE));

    }
    
    public function jumlah_sukses_beli()
    { 
		$query = $this->BackofficeM->get_total_beli();
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
    
    public function tolakbeli($id)
    { 
		$approved = $this->session->userdata('username');
		$this->db->query("UPDATE pembelian SET status='Di Tolak' ,approved_by='$approved' WHERE no_invoice='$id'");
		// $this->db->query("UPDATE detail_pembelian SET invoice_no= '$id', status='Di Tolak' ,approved='$approved' WHERE invoice_no='$id'");
		echo json_encode(array("status" => TRUE));
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
    
    public function jumlah_tolak_beli()
    { 
		$query = $this->BackofficeM->get_total_beli_gagal();
		echo json_encode($query);
    }
    
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

    public function laci_kamu()
	{
		$user = $this->session->userdata('username');
		$id = $this->session->userdata('id');
		$sisa = $this->UserM->get_total_barang_user($id);
		$datastock = $this->BackofficeM->getstockuser($user);
		$stock = $this->BackofficeM->getallstock();
		$data = array();
		foreach ($stock as $sl) {
            $row = array();
            $row[] = $sl->mata_uang;
            $row[] = 'Rp. ' . number_format( $sl->harga_modal, 0 , '' , '.' ) . ',-';
            $row[] = number_format($sl->jumlah_stock);
            $data[] = $row;
        }
		foreach ($datastock as $dsb) {
			$row = array();
			$row[] = $dsb->nama_matauang;
			$row[] = number_format ($dsb->jumlah);
			$row[] = number_format ($dsb->harga_beli);
			$data[] = $row;
		}

		$output = '';
		$output = '
			<div class="row">
				<div class="col-2">	
					<div class="card text-white card-dark">
						<div class="card-body">
							<p class="text-white font-14">Sisa Rupiah Kamu<br> <u><b><i>'.$sisa.'</u></b></i></p>
						</div>
					</div>
				</div>

				<div class="col-5">
					<div class="card">
						<div class="card-body">
								<h4 class="mt-0 header-title">Stock dilaci kamu</h4>
							<div class="table-responsive">
								<table class="table table-striped mb-0">
									<thead>
										<tr align="center">
											<th width="50">No</th>
											<th>Mata Uang</th>
											<th>Harga Modal</th>
											<th>Stock</th> 
										</tr>
									</thead>
									<tbody>';
									$i=1;
									if($dsb->jumlah == 0 )
									{
										'kosong';
									}else
									foreach ($datastock as $dsb) {
							$output .= '
										<tr align="center">
											<td width="50"><font color="#000000">'.$i.'</font></td>
											<td ><font color="#000000">'.$dsb->nama_matauang.'</font></td>
											<td ><font color="#000000">'.'Rp. ' .number_format ($dsb->harga_beli).'</font></td>
											<td ><font color="#000000">'.number_format ($dsb->jumlah).'</font></td>
										</tr>';
										$i++;
										}
							$output .= '		
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-6">
					<div class="card">
						<div class="card-body">
								<h4 class="mt-0 header-title">Stock Global</h4>
							<div class="table-responsive">
								<table class="table table-striped mb-0">
									<thead>
										<tr align="center">
											<th width="50">No</th>
											<th>Mata Uang</th>
											<th>Harga Modal</th>
											<th>Stock</th> 
										</tr>
									</thead>
									<tbody>';
									$i=1;
									if($sl->jumlah_stock == 0 )
									{
										'kosong';
									}else
									foreach ($stock as $sl) {
							$output .= '
										<tr align="center">
											<td width="50"><font color="#000000">'.$i.'</font></td>
											<td ><font color="#000000">'.$sl->mata_uang.'</font></td>
											<td ><font color="#000000">'.'Rp. ' .number_format ($sl->harga_modal).'</font></td>
											<td ><font color="#000000">'.number_format ($sl->jumlah_stock).'</font></td>
										</tr>';
										$i++;
										}
							$output .= '		
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

			</div>	
		';
				
		echo $output;
	}

	public function deleteitembeli($rowid){
		$this->cart->update([
				'rowid'=>$rowid,
				'qty'=>0,]);
		echo json_encode(["status" => TRUE]);
	}
    
    
    
}