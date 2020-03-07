<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class Registrasi extends CI_Controller {
	
        public function __construct(){
                parent::__construct();
                if($this->session->userdata('id')){
                        header('location:http://localhost/valas');
                }
        }
	
	
	
	public function index(){
                $this->load->library('form_validation');

                $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.nama]',
                array('required' => 'Tidak Boleh Kosong',
                'is_unique' => 'Sudah Terdaftar'
                )
                );
                
                $this->form_validation->set_rules('password', 'Password', 'required',
                        array('required' => 'Tidak Boleh Kosong')
                );
                
                $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[password]',
                array('required' => 'Tidak Boleh Kosong',
                'matches' => 'Password Harus Sama'
                )
                );
                
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]',
                array('required' => 'Tidak Boleh Kosong',
                'is_unique' => 'Sudah Terdaftar',
                'valid_email' => 'Email Tidak Sah'
                )
                );

                if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('RegistV');
                        
                }else{
                        
                        $username = $this->input->post('username',true);
                        $email = $this->input->post('email',true);
                        $password0 = $this->input->post('password',true);
                        $password = $this->input->post('confirm_password',true);
                        $role = $this->input->post('role',true);
                        $data = array(
                                        'nama' => $username,
                                        'email' => $email,
                                        'password' => password_hash($password, PASSWORD_BCRYPT),
                                        'level' => $role,
                                        'aktif' => 0
                                        
                                        );
                                        
                                        
                                        $this->daftar_baru($data);
                                        
                                        //jika gagal hapus user
                                        $this->session->set_flashdata('message','<div class="alert alert-success " role="alert"><strong>Terimakasih telah mendaftar, tunggu  akunmu diaktivasi oleh admin yah</strong></div>');
                                        redirect('login');
                }
        }
        
        
        public function daftar_baru($data)
        {
                return $daftar = $this->RegistM->daftar_baru($data);
        }

}
