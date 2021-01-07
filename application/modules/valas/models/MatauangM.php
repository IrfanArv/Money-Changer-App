<?php

class MatauangM extends CI_Model{
	var $table = 'matauang';
	var $column_order = array('nama','harga_jual','harga_beli','updated','ket'); 
	var $column_search = array('id_matauang','nama','harga_jual','harga_beli','updated','ket');
	var $order = array('id_matauang' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	private function _get_datatables_query()
	{
		
		$this->db->from($this->table);

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

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_matauang',$id);
		$query = $this->db->get();

		return $query->row();
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

	public function getall(){
		$this->db->select('*');
		$this->db->from('matauang');
		$query = $this->db->get();
		return $query->result();
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
	
	function get_rate(){
        $query = $this->db->get('matauang');
        return $query;  
	}
	
	function loadStock($mata_uang){ 
		$this->db->select('harga_modal'); 
		$this->db->where('mata_uang', $mata_uang);
		$this->db->group_by('harga_modal');
		$result = $this->db->get('stock')->result();
		
		return $result; 
	  } 


	function get_inv($id_teller)
	{
        $q = $this->db->query("SELECT MAX(RIGHT(no_invoice,4)) AS kd_max FROM pembelian WHERE DATE(tanggal_transaksi)=CURDATE() AND (SELECT MAX(LEFT(no_invoice,1)))='$id_teller'");
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
	    	
}