<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class AdminValas extends CI_Controller {

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

// CART
    public function chartjual()
    {
		$data = $this->BackofficeM->get_data_pembelian()->result();
		echo json_encode($data);
    }
// CART

// STOCK 
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

    function listStock()
    {
        $mata_uang = $this->input->post('mata_uang');
        $harga = $this->MatauangM->loadStock($mata_uang);

        $lists = "<option value=''>Pilih</option>";
        
        foreach($harga as $data){
          $lists .= "<option value='".$data->harga_modal."'>".$data->harga_modal."</option>"; 
        }
        
        $callback = array('list_Stock'=>$lists); 
    
        echo json_encode($callback); 
    }
// STOCK

// MATA UANG

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
// MATA UANG

// DROP BARANG
    public function barang()
    { 
        $data['title']=$title = 'Drop Rupiah';
        $this->layout->display('valas/admin/DropV', $data);  
    }

    public function list_barang()
	{
		$list = $this->UserM->barang();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $rct) {
			$no++;
			$row = array();
			$row[] = $rct->nama;
			$row[] = 'Rp. ' . number_format( $rct->modal, 0 , '' , '.' ) . ',-';
			$row[] = date('d M Y - H:i:s', strtotime($rct->tanggal));
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->UserM->count_barang_user(),
			"recordsFiltered" => $this->UserM->filter_user_barang(),
			"data" => $data,
		);
	    echo json_encode($output);
	}

	public function drop_barang()
	{
		$list = $this->UserM->barang();
		$data = array();
		foreach ($list as $rct) {
			$row = array();
			$row[] = $rct->id;
			$row[] = $rct->nama;
			$row[] = 'Rp. ' . number_format( $rct->modal, 0 , '' , '.' ) . ',-';
			$row[] = date('d M Y - H:i:s', strtotime($rct->tanggal));
			$data[] = $row;
		}
		$output = '';
		foreach ($list as $rct) {
		$output .= '
		<input type="hidden" value="'.$rct->id.'" name="id[]"/> 
		<div class="form-group row">
			<label class="col-sm-2 col-form-label text-left">'.$rct->nama.'</label>
			<div class="col-sm-5">
				<input name="jumlah[]" type="number" class="form-control" value="'.$rct->modal.'" placeholder="'.'Rp. ' . number_format( $rct->modal, 0 , '' , '.' ) . ',-'.'" required>
			</div>
		</div>
		';
		}
		echo $output;
	}
	
	
	public function update_barang()
	{
		$user_id = $this->input->post('id'); 
		$result = array();

		foreach($user_id AS $key => $val){
			$result[] = array(
				"id" => $user_id[$key],
				"modal"  => $_POST['jumlah'][$key]
			);
		}
		$this->db->update_batch('user', $result, 'id');
		echo json_encode(array("status" => TRUE));
	}

	public function tarik_barang()
	{
		$id = $this->input->post('id'); 
		$jumlah = 0;
		$updateArray = array();

		foreach($id AS $key => $val){
			$updateArray[] = array(
				"id" => $id[$key],
				"modal"  => $jumlah[$key]
			);
		}
		$this->db->update_batch('user', $updateArray, 'id');
		echo json_encode(array("status" => TRUE));
	}

	public function jumlah_barang()
	{ 
		$query = $this->UserM->get_total_barang();
		echo json_encode($query);
	}

    
	// DROP BARANG
// DROP BARANG

// START FUNCTION USER

    public function user()
    {
        $data['title']=$title = 'Daftar User';
        $this->layout->display('valas/admin/UserV', $data); 
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
            }elseif ($user->level == 4){
                $row[] = "<span class='btn btn-dark btn-round waves-effect waves-light'>General Manager</span>";
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
 

// RECAP TELLER
    public function recap_teller()
    {
        $data['title']=$title = 'Recap Pembelian Teller';
        $this->layout->display('valas/admin/RecapTellerV', $data); 
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

    function DateRecapTellerSuccess()
	{
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
    
    function DateRecapTellerGagal()
	{
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
    
// RECAP TELLER

// TRANSAKSI PEMBELIAN HARI INI
    public function transcation_today()
    {
        $data['title']=$title = 'Transaksi Pembelian Hari ini';
        $this->layout->display('valas/admin/PembelianV', $data); 
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
            }
            // elseif($pmb->status == "Menunggu"){
            //     $row[] = '<button class="btn btn-primary btn-round waves-effect waves-light" roler="button" onClick="terimatransaksi('."'".$pmb->no_invoice."'".')"><i class="mdi mdi-shield-check-outline"></i> Terima Transaksi</button>';
            // }
            

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
            'status' => 'Di Tolak'
            // 'approved_by' => $nama
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
            'status' => 'Selesai'
            // 'approved_by' => $nama
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
// TRANSAKSI PEMBELIAN HARI INI

// TRANSAKSI PENJUALAN
    public function laci_user()
	{
        $datalaci = $this->BackofficeM->getdatalaci();
        $datamodal = $this->BackofficeM->getdatamodal();
		$data = array();
		foreach ($datalaci as $dl) {
            $row = array();
            $row[] = $dl->nama_matauang;
            $row[] = $dl->approved_by;
            $row[] = 'Rp. ' . number_format( $dl->harga_beli, 0 , '' , '.' ) . ',-';
            $row[] = number_format($dl->jumlah);
            
            $data[] = $row;
        }

        foreach ($datamodal as $dl) {
            $row = array();
            $row[] = $dl->nama;
            $row[] = 'Rp. ' . number_format( $dl->modal, 0 , '' , '.' ) . ',-';
            $data[] = $row;
        }

		$output = '';
		$output = '
			<div class="row">
				<div class="col-7">
					<div class="card">
						<div class="card-body">
								<h4 class="mt-0 header-title">Stock Peruser</h4>
							<div class="table-responsive">
								<table class="table table-striped mb-0">
									<thead>
										<tr align="center">
                                            <th width="50">No</th>
                                            <th>User</th>
											<th>Mata Uang</th>
											<th>Harga Modal</th>
                                            <th>Stock Barang</th> 
                                            
										</tr>
									</thead>
									<tbody>';
                                    $i=1;
                                    $sum = 0;
                                    
									foreach ($datalaci as $dl) {
                                    $sum+= $dl->jumlah;
                                    
							$output .= '
										<tr align="center">
											<td width="50"><font color="#000000">'.$i.'</font></td>
                                            <td ><font color="#000000">'.$dl->approved_by.'</font></td>
                                            <td ><font color="#000000">'.$dl->nama_matauang.'</font></td>
											<td ><font color="#000000">'.'Rp. ' .number_format ($dl->harga_beli).'</font></td>
                                            <td ><font color="#000000">'.number_format ($dl->jumlah).'</font></td>
                                            
										</tr>';
										$i++;
										}
							$output .= '		
                                    </tbody>
                                    <tfoot>
										<tr align="center">
                                            <th></th>
                                            <th></th>
											<th></th>
											<th><h4><font color="#000000">Total Barang</font></h4></th> 
                                            <th><h4><font color="#000000">'.number_format ($sum).'</font></h4></th> 
                                            
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
                </div>
                
                <div class="col-5">
					<div class="card">
						<div class="card-body">
								<h4 class="mt-0 header-title">Modal </h4>
							<div class="table-responsive">
								<table class="table table-striped mb-0">
									<thead>
										<tr align="center">
                                            <th width="50">No</th>
                                            <th>User</th>
                                            <th>Sisa Modal</th> 
                                            
										</tr>
									</thead>
									<tbody>';
                                    $i=1;
                                    $sum = 0;
                                    
									foreach ($datamodal as $dl) {
                                    $sum+= $dl->modal;
                                    
							$output .= '
										<tr align="center">
											<td width="50"><font color="#000000">'.$i.'</font></td>
                                            <td ><font color="#000000">'.$dl->nama.'</font></td>
											<td ><font color="#000000">'.'Rp. ' .number_format ($dl->modal).'</font></td>
                                            
										</tr>';
										$i++;
										}
							$output .= '		
                                    </tbody>
                                    <tfoot>
										<tr align="center">
                                            <th></th>
                                            <th><h4><font color="#000000">Total Barang</font></h4></th> 
                                            <th><h4><font color="#000000">'.'Rp. ' .number_format ($sum).'</font></h4></th> 
                                            
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>	
		';
				
		echo $output;
    }    

    public function cari_mata_uang()
    {
        
        $matauang = $this->MatauangM->get_rate()->result();
        
        $output  = '<option value="">Pilih</option>';
                    foreach ($matauang as $row):
        $output .= '
                    <option value="'.$row->nama.'">'.$row->nama.'</option>
                    ';
                    endforeach;
        echo $output;
    
    }

    public function getRelasi()
    {
        
        $relasi = $this->RelasiM->get_relasi()->result();
        $spaces = ' | ';
        $output  = '<option value="">Pilih</option>';
                    foreach ($relasi as $row):
        $output .= '
                    <option value="'.$row->id_relasi.'">'.$row->nama.''.$spaces.''.$row->nama_perusahaan.'</option>
                    ';
                    endforeach;
        echo $output;
    
    }
        
    public function add_transaksijual()
    {
        $data = [
            'id' => rand(5, 2000),
            'name' => $this->input->post('id'),
            'price' => str_replace('.', '', $this->input->post('jual')),
            'qty' => $this->input->post('jumlahjual'),
            'harga_modal' => str_replace('.', '', $this->input->post('harga_modal'))
        ];
        $insert = $this->cart->insert($data);
        echo json_encode(["status" => TRUE]);
    }

    public function cart_jual()
    {
        $data = [];
        $no = 1; 
        foreach ($this->cart->contents() as $item){
            $row = [];
            $row[] = $item["name"];
            $row[] = 'Rp. ' . number_format( $item['harga_modal'], 0 , '' , '.' ) . ',-';
            $row[] = 'Rp. ' . number_format( $item['price'], 0 , '' , '.' ) . ',-';
            $row[] = $item["qty"];
            $row[] = 'Rp. ' . number_format( $item['subtotal'], 0 , '' , '.' ) . ',-';
            
            //add html for action
            $row[] = '<a 
                href="javascript:void()" style="color:rgb(255,128,128);
                text-decoration:none" onclick="deleteitembeli('
                    ."'".$item["rowid"]."'".','."'".$item['subtotal'].
                    "'".')"> <i class="fas fa-times"></i></a>';
            $data[] = $row;
            $no++;
        }
        $output = [
            "data" => $data,
        ];
        echo json_encode($output);
    }

    public function deleteitembeli($rowid)
    {
        $this->cart->update([
                'rowid'=>$rowid,
                'qty'=>0,]);
        echo json_encode(["status" => TRUE]);
    }

    public function addpenjualan() 
    {
        if($this->cart->contents() !==[]){
            $relasi     = $this->input->post('relasi');
            $invoice    = $this->BackofficeM->get_inv();
            $i = 0;
            $total		= $this->cart->total();
                foreach ($this->cart->contents() as $insert){
                    $no_invoice	= $invoice;
                    $relasi	    = $relasi;
                    $data = [
                        'id_jual'       => $invoice,
                        'relasi_id'     => $relasi,
                        'harga_modal'   => $insert['harga_modal'],
                        'harga_jual'    => $insert['price'],
                        'mata_uang'     => $insert['name'],
                        'jumlah_valas' => $insert['qty'],
                        'subtotal' => $insert['subtotal'],
                    ];
                    $masuk[] = $data;
                    $i++; 
 
                }
                $insert = $this->db->insert_batch('penjualan', $masuk);
                
                if($insert){
                    $this->cart->destroy();
                    $response['redirect'] = 'valas/AdminValas/faktur/'.$invoice;
                    echo json_encode($response);
                    die;

                }else{
                    echo json_encode(["status" => FALSE]);
                }
        }else{
            echo('Transaksi Kosong');
        }

    }

    public function faktur($id)
    {   
        
        $data['jual']=$this->BackofficeM->get_penjualan_detail($id);
        $detail = $this->BackofficeM->get_penjualan_detail($id);

        foreach($detail as $t){
            $data['nama'] = $t->nama;
            $data['nama_perusahaan'] = $t->nama_perusahaan;
            $data['alamat'] = $t->alamat;
            $data['telpon'] = $t->telpon;
            $data['id_jual'] = $t->id_jual;
            $data['tanggal_transaksi'] = $t->tanggal_transaksi;
        } 
        $data['title']=$title = 'Faktur Penjualan Valas';
        $this->layout->display('valas/admin/penjualan/DetailJual',$data, true); 
    }

    public function penjualan()
    {
        $data['title']=$title = 'Data Penjualan Valas';
        $this->layout->display('valas/admin/penjualan/Penjualan', $data); 
    }

    public function detail_penjualan()
    {
        $data['title']=$title = 'Rincian Penjualan Valas';
        $this->layout->display('valas/admin/penjualan/Rincian', $data); 
    }

    public function detail_penjualan_list($id_jual)
    {
        
        $list = $this->PenjualanM->get_datatables2($id_jual);
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $rl) { 
            
            $no++;
            $row = array();
            $row[] = '<span style="font-size:12px;" class="badge badge-boxed badge-soft-primary">'.'#'.$rl->id_jual.'</span>';
            $row[] = '<span style="font-size:12px;" class="badge badge-boxed badge-soft-success">'.date('d M Y - H:i:s', strtotime($rl->tanggal_transaksi)).'</span>';
            $row[] = $rl->nama;
            $row[] = $rl->nama_perusahaan;
            $row[] = 'Rp. ' . number_format( $rl->subtotal, 0 , '' , '.' ) . ',-';
            
            $row[] = '<a class="btn btn-sm btn-primary" href="#" onclick=" window.open(detail_penjualan/'."".$rl->id_jual."".');" title="Lihat Rincian Penjualan"><i class="dripicons-list"></i> Rincian</a>
                <a class="btn btn-sm btn-secondary" target="_balnk" href="faktur/'."".$rl->id_jual."".'" title="Lihat Faktur Penjualan"><i class="dripicons-clipboard" ></i> Faktur</a>';
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->PenjualanM->count_all(),
                        "recordsFiltered" => $this->PenjualanM->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function penjualan_list()
    {
        $list = $this->PenjualanM->get_datatables();
        $data = array();
        $no = $_POST['start'];
        
        foreach ($list as $rl) { 
            
            $no++;
            $row = array();
            $row[] = '<span style="font-size:12px;" class="badge badge-boxed badge-soft-primary">'.'#'.$rl->id_jual.'</span>';
            $row[] = '<span style="font-size:12px;" class="badge badge-boxed badge-soft-success">'.date('d M Y - H:i:s', strtotime($rl->tanggal_transaksi)).'</span>';
            $row[] = $rl->nama;
            $row[] = $rl->nama_perusahaan;
            $row[] = 'Rp. ' . number_format( $rl->subtotal, 0 , '' , '.' ) . ',-';
            
            $row[] = '<a class="btn btn-sm btn-primary" href="#" onclick=" window.open('."".$rl->id_jual."".');" title="Lihat Rincian Penjualan"><i class="dripicons-list"></i> Rincian</a>
                <a class="btn btn-sm btn-secondary" target="_balnk" href="faktur/'."".$rl->id_jual."".'" title="Lihat Faktur Penjualan"><i class="dripicons-clipboard" ></i> Faktur</a>';
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->PenjualanM->count_all(),
                        "recordsFiltered" => $this->PenjualanM->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }
    
// TRANSAKSI PENJUALAN

// RELASI
    public function relasi()
    {
        $data['title']=$title = 'Data Relasi Valas';
        $this->layout->display('valas/admin/RelasiV', $data); 
    }

    public function relasi_list()
    {
        $list = $this->RelasiM->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rl) {
            $no++;
            $row = array();
            $row[] = $rl->nama;
            $row[] = $rl->nama_perusahaan;
            $row[] = $rl->telpon;
            $row[] = $rl->alamat;
            $row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Update" onclick="edit_relasi('."'".$rl->id_relasi."'".')"><i class="dripicons-pencil"></i></a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="relasi_delete('."'".$rl->id_relasi."'".')"><i class="dripicons-trash"></i></a>';
        
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->RelasiM->count_all(),
                        "recordsFiltered" => $this->RelasiM->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function add_relasi()
    {

        $data = array(
            'nama' => $this->input->post('nama'),
            'nama_perusahaan' => $this->input->post('nama_perusahaan'),
            'telpon' => $this->input->post('no_tel'),
            'alamat' => $this->input->post('alamat')
            );
        $insert = $this->RelasiM->save($data);
        echo json_encode(array("status" => TRUE));
    }

    public function update_relasi()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'nama_perusahaan' => $this->input->post('nama_perusahaan'),
            'telpon' => $this->input->post('no_tel'),
            'alamat' => $this->input->post('alamat')
            );
        $this->RelasiM->update(array('id_relasi' => $this->input->post('id_relasi')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function edit_relasi($id)
    {
        $data = $this->RelasiM->get_by_id($id);
        echo json_encode($data);
    }

    public function delete_relasi($id)
    {
        $this->RelasiM->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    

// RELASI

}