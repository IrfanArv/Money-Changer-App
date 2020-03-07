<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class Login extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('id')){
			header("location: http://localhost/valas");
			}
	}

	
	public function index() 
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required',
		array('required' => 'email harus di isi')
		);
		$this->form_validation->set_rules('password', 'password', 'required',
                        array('required' => 'password harus di isi')
                );
                if ($this->form_validation->run() == FALSE)
                {
                    $this->load->view('LoginV');
                }else{
                        $email = $this->input->post('email');
                        $password = $this->input->post('password');
                        $this->proses_masuk($email, $password);
                        
                    }
	}
	
	public function proses_masuk($email, $password)
	{
		$data = $this->UserM->cek_email_member($email);
		if($data['email'] == '')
		{
			$this->session->set_flashdata('error_email','Email salah gan');
			$this->load->view('LoginV');
		}
		else
		{
			if($data['aktif'] == 0)
			{
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Akun anda belum aktif, hubungi Administrator untuk aktivasi</div>');
				$this->load->view('LoginV');
			}
			else
			{
				if(password_verify($password, $data['password']))
				{
					
					$this->load->library('user_agent');
					$data_browser =[
						'id_user' => $data["id"],
						'browser' => $this->agent->browser(),
						'browser_version' => $this->agent->version(),
						'os' => $this->agent->platform(),
						'waktu_login' => date("Y-m-m h:i:s"),
						'ip_address' => $this->input->ip_address()
					];
					
					$input_browser = $this->UserM->input_browser($data_browser);
					if($input_browser)
					{
						$cookie = $this->_acak($data['id']);
						$cookie_id = $data['id'];
						$data_input_cookie = [
							'cookie' => $cookie,
							'id_user_cookie' => $data['id']
						];
						$data_update_cookie = [
							'cookie' => $cookie,
							];
						$data_session = [
							'id'  => $data['id'],
							'username'  => $data['nama'],
							'email'  => $data['email'],
							'level'  => $data['level']
						];
						$this->_input_cookie($data_input_cookie, $data_update_cookie, $data_session, $cookie_id);
						$this->_cookie_session($data_session,$cookie);
						header("location: http://localhost/valas");
					}
					
				}
				else
				{
					$this->session->set_flashdata('error_password','Dicek lagi passwordnya');
					$this->load->view('LoginV');
				}
				
			}
		}
		
	}
	
	private function _input_cookie($data_input_cookie, $data_update_cookie, $data_session, $cookie_id)
	{

		$cek_cookie = $this->UserM->cek_cookie_db($cookie_id);
		if($cek_cookie)
		{
			$this->UserM->update_cookie($data_update_cookie,$cookie_id);
			return;
		}
		else 
		{
			$input_cookie = $this->UserM->input_cookie($data_input_cookie);
			return;
		}
	}

	private function _cookie_session($data_session,$cookie)
	{
		$this->load->helper('cookie');
		set_cookie('id',$cookie,'604800');
		$this->session->set_userdata($data_session);
		return;
	}

	private function _acak($n)
	{
		$key = 'q6w7ert4yu8iop3asd2fgh0jk5lzx9cvb1nm';
		$text = strlen($key)-1;
		$hasil = array();
		$hasil = '';
			for($i=0; $i<$n; $i++){
				for($j=0; $j<32; $j++){
					$buat = rand(0, strlen($key)-1);
					$hasil .= $key[$buat];
				}
			}
		return $hasil;
	}


}
