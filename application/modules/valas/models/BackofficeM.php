<?php

class BackofficeM extends CI_Model{
	var $table = 'pembelian';
	var $column_order = array('no_invoice','teller','total','tanggal_transaksi','status','approved_by'); 
	var $column_search = array('no_invoice','teller','total','tanggal_transaksi','status','approved_by'); 
	var $order = array('no_invoice' => 'desc'); 

	public function __construct()
	{
		parent::__construct(); 
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');
		$status = "Menunggu";
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status', $status);
		

		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	private function _get_datatables_query2()
	{
		$this->db->from($this->table);
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
	
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables2()
	{
		$this->_get_datatables_query2();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered2()
	{
		$this->_get_datatables_query2();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status','Menunggu');
		return $this->db->count_all_results();
	}

	public function count_all2()
	{
		$this->db->from($this->table);
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		return $this->db->count_all_results();
	}


	public function count_transaksibeli()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->select("*");
        $this->db->from("pembelian");
        $this->db->join('detail_pembelian','detail_pembelian.invoice_no=pembelian.no_invoice');
		$this->db->where('no_invoice',$id);
		$query = $this->db->get();
		return $query->result();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_matauang', $id);
		$this->db->delete($this->table);
	}

	function getall(){
		$query = $this->db->query("SELECT * FROM matauang");
		return $query;
	}



	
	public function cari_rate($key)
	{
		$this->db->select('*');
		$this->db->like('nama', $key);
		$this->db->or_like('id_matauang', $key);
		$query = $this->db->get('matauang');
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $data)
			{
				$hasil[] = $data;
			}
			return $hasil;
		}
	}

	function get_no_invoice(){
        $q = $this->db->query("SELECT MAX(RIGHT(no_invoice,4)) AS kd_max FROM pembelian WHERE DATE(tanggal_transaksi)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('dmy').$kd;
	}

	function get_total_beli(){
		$user = $this->session->userdata('username');
		$status = "Selesai";
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		// $hasil = $this->db->query("SELECT sum(total) FROM (SELECT total FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE() ) AS subquery");
		// return $hasil;
		$this->db->select_sum('total');
		$this->db->where('approved_by',$user);
		$this->db->where('status',$status);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$result = $this->db->get('pembelian')->row();  
		// return $result->total;
		return 'Rp. ' . number_format( $result->total, 0 , '' , '.' ) . ',-';
	}

	function get_total_beli_teller(){
		$user = $this->session->userdata('username');
		$status = "Selesai";
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		// $hasil = $this->db->query("SELECT sum(total) FROM (SELECT total FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE() ) AS subquery");
		// return $hasil;
		$this->db->select_sum('total');
		$this->db->where('teller',$user);
		$this->db->where('status',$status);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$result = $this->db->get('pembelian')->row();  
		// return $result->total;
		return 'Rp. ' . number_format( $result->total, 0 , '' , '.' ) . ',-';
	}

	function get_total_beli_gagal(){
		$user = $this->session->userdata('username');
		$status = "Di Tolak";
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		// $hasil = $this->db->query("SELECT sum(total) FROM (SELECT total FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE() ) AS subquery");
		// return $hasil;
		$this->db->select_sum('total');
		$this->db->where('approved_by',$user);
		$this->db->where('status',$status);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$result = $this->db->get('pembelian')->row();  
		// return $result->total;
		return 'Rp. ' . number_format( $result->total, 0 , '' , '.' ) . ',-';
	}

	function get_total_beli_gagal_teller(){
		$user = $this->session->userdata('username');
		$status = "Di Tolak";
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		// $hasil = $this->db->query("SELECT sum(total) FROM (SELECT total FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE() ) AS subquery");
		// return $hasil;
		$this->db->select_sum('total');
		$this->db->where('teller',$user);
		$this->db->where('status',$status);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$result = $this->db->get('pembelian')->row();  
		// return $result->total;
		return 'Rp. ' . number_format( $result->total, 0 , '' , '.' ) . ',-';
	}

	public function get_detail_beli_sukses($user,$status)
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select("*");
        $this->db->from("pembelian");
		$this->db->where('approved_by',$user);
		$this->db->where('status',$status);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_detail_beli_sukses_teller($user,$status)
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select("*");
        $this->db->from("pembelian");
		$this->db->where('teller',$user);
		$this->db->where('status',$status);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_riwayat_transaksi($user)
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select("*");
        $this->db->from("pembelian");
		$this->db->where('teller',$user);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->order_by('no_invoice', 'DESC');
		$this->db->limit('5');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_detail_beli($user)
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select("*");
        $this->db->from("pembelian");
		$this->db->where('teller',$user);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$query = $this->db->get();
		return $query->result();
	}

	function get_transaksi_teller(){
		$user = $this->session->userdata('username');
		
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		// $hasil = $this->db->query("SELECT sum(total) FROM (SELECT total FROM pembelian WHERE approved_by='$teller' AND status='$status' AND DATE(tanggal_transaksi)=CURDATE() ) AS subquery");
		// return $hasil;
		$this->db->select_sum('total');
		$this->db->where('teller',$user);
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$result = $this->db->get('pembelian')->row();  
		// return $result->total;
		return 'Rp. ' . number_format( $result->total, 0 , '' , '.' ) . ',-';
	}

	function recap_teller_sukses(){
		// $hasil = $this->db->query("SELECT teller,SUM(total) AS total_transaksi, COUNT(*) AS jumlah_transaksi FROM pembelian WHERE DATE(tanggal_transaksi)=CURDATE() AND status='Selesai' GROUP BY teller");
		// return $hasil;
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status','Selesai');
		$this->db->group_by('teller'); 
		$query = $this->db->get();
		return $query->result();
	}

	function recap_teller_gagal(){
		// $hasil = $this->db->query("SELECT teller,SUM(total) AS total_transaksi, COUNT(*) AS jumlah_transaksi FROM pembelian WHERE DATE(tanggal_transaksi)=CURDATE() AND status='Selesai' GROUP BY teller");
		// return $hasil;
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status','Di Tolak');
		$this->db->group_by('teller'); 
		$query = $this->db->get();
		return $query->result();
	}

	public function count_recap_teller()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status','Selesai');
		$this->db->group_by('teller'); 
		return $this->db->count_all_results();
	}

	public function count_recap_teller_gagal()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status','Di Tolak');
		$this->db->group_by('teller'); 
		return $this->db->count_all_results();
	}

	function count_filtered_teller_recap()
	{
		$this->_get_datatables_query_teller();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_filtered_teller_recap_gagal()
	{
		$this->_get_datatables_query_teller_gagal();
		$query = $this->db->get();
		return $query->num_rows();
	}

	private function _get_datatables_query_teller()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status','Selesai');
		$this->db->group_by('teller'); 
	
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	private function _get_datatables_query_teller_gagal()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->where('status','Di Tolak');
		$this->db->group_by('teller'); 
	
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function RecapTellerDate($start_date, $end_date){
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->select('count(*) AS jumlah_transaksi_gagal');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi) >=',$start_date); 
		$this->db->where('DATE(tanggal_transaksi) <=',$end_date);
		$this->db->where('status','Selesai');
		$this->db->group_by('status'); 
		$this->db->group_by('teller'); 
		$query = $this->db->get();
		return $query->result();
	}

	public function RecapTellerDateGagal($start_date, $end_date){
		$this->db->select('teller');
		$this->db->select_sum('total');
		$this->db->select('count(*) AS jumlah_transaksi');
		$this->db->select('count(*) AS jumlah_transaksi_gagal');
		$this->db->from('pembelian');
		$this->db->where('DATE(tanggal_transaksi) >=',$start_date); 
		$this->db->where('DATE(tanggal_transaksi) <=',$end_date);
		$this->db->where('status','Di Tolak');
		$this->db->group_by('status'); 
		$this->db->group_by('teller'); 
		$query = $this->db->get();
		return $query->result();
	}
	
	// SELECT sum(jumlah),nama_matauang FROM pembelian JOIN detail_pembelian ON no_invoice=invoice_no 
	// where approved_by = "deni" 
	//  and tanggal_transaksi BETWEEN "2020-02-21 08:55:38" AND "2020-02-21 22:55:38"
	// GROUP BY nama_matauang;

	public function getstockuser($user)
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('nama_matauang');
		$this->db->select('harga_beli');
		$this->db->select_sum('jumlah');
		$this->db->join('detail_pembelian','detail_pembelian.invoice_no=pembelian.no_invoice');
        $this->db->from("pembelian");
		$this->db->where('pembelian.approved_by',$user);
		$this->db->where('pembelian.status','Selesai');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->group_by('nama_matauang'); 
		$this->db->group_by('harga_beli'); 
		$query = $this->db->get();
		return $query->result();
	}

	public function getdatalaci(){
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d');
		$this->db->select('nama_matauang');
		$this->db->select('approved_by');
		$this->db->select('harga_beli');
		$this->db->select_sum('jumlah');
		$this->db->join('detail_pembelian','detail_pembelian.invoice_no=pembelian.no_invoice');
        $this->db->from("pembelian");
		$this->db->where('pembelian.status','Selesai');
		$this->db->where('DATE(tanggal_transaksi)',$curr_date);
		$this->db->group_by('nama_matauang'); 
		$this->db->group_by('harga_beli'); 
		// $this->db->order_by("jumlah", "desc");
		$this->db->order_by("approved_by", "asc");
		$query = $this->db->get();
		return $query->result();
	}
	 

	// public function getstockuser($user)
	// {
	// 	$date = new DateTime("now");
	// 	$curr_date = $date->format('Y-m-d');
	// 	$this->db->select('mata_uang');
	// 	$this->db->select('harga_modal');
	// 	$this->db->select_sum('jumlah_stock');
    //     $this->db->from("stock_user");
	// 	$this->db->where('acc_by',$user);
	// 	$this->db->where('DATE(date)',$curr_date);
	// 	$this->db->group_by('harga_modal'); 
	// 	$query = $this->db->get();
	// 	return $query->result();
	// } 

	public function getallstock(){  
		$this->db->select('*');
		$this->db->select_sum('jumlah_stock');
		$this->db->from("stock");
		$this->db->group_by('harga_modal');
		$this->db->order_by("jumlah_stock");
		$query = $this->db->get();
		return $query->result();
	}

	public function getdatamodal(){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where('level','2');
		$this->db->where('aktif','1');
		$this->db->order_by("nama", "asc");
		$query = $this->db->get();
		return $query->result();
	}

	
	function get_data_pembelian(){ 
		$hasil = $this->db->query("SELECT sum(total), MONTHNAME(tanggal_transaksi) AS bulan, WEEK(tanggal_transaksi) AS minggu, CONCAT(DATE_FORMAT(tanggal_transaksi, '%Y-%m-%d'), ' - ', DATE_FORMAT(tanggal_transaksi, '%Y-%m-%d') + INTERVAL 7 DAY) AS week FROM pembelian WHERE status='Selesai' GROUP BY WEEK(tanggal_transaksi)");
		return $hasil;
	}

	function get_inv()
	{
        $q = $this->db->query("SELECT MAX(RIGHT(id_jual,4)) AS kd_max FROM penjualan WHERE DATE(tanggal_transaksi)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
		}
        date_default_timezone_set('Asia/Jakarta');
        return date('dmy').$kd;
	}

	public function get_penjualan_detail($id)
	{
		$this->db->select("*");
        $this->db->from("penjualan");
        $this->db->join('relasi','relasi.id_relasi=penjualan.relasi_id');
		$this->db->where('id_jual',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
    	
}