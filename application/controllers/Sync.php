<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

class Sync extends CI_Controller {

    
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


    public function index(){
        $this->load->view('TestView');
    }

    public function send(){
        $nilai1		  = $this->input->post('data1',TRUE);
        $nilai2		  = $this->input->post('data2',TRUE);
        $nilai3		  = $this->input->post('data3',TRUE);

        $url = "https://office.bafageh.com/test";
        
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS,"data1=".$nilai1."&data2=".$nilai2."&data3=".$nilai3);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_exec($curlHandle);
        curl_close($curlHandle);
    }


    
}
