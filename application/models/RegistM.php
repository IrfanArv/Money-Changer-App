<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class RegistM extends CI_Model {
	
	public function daftar_baru($data)
	{
		return $this->db->insert('user',$data);
	}
    
    public function update_aktif($email)
    {
        $data = ['aktif' => 1];
        $this->db->where('email',$email);
        return $this->db->update('user', $data);
    }
    
    
    public function delete_user($email)
    {
        $this->db->where('email',$email);
        return $this->db->delete('user');
    }
    
}