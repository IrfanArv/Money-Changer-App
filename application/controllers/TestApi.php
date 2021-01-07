<?php

// import library dari REST_Controller
require APPPATH . 'libraries/REST_Controller.php';

// extends class dari REST_Controller
class TestApi extends REST_Controller{

  // constructor
  public function __construct(){
    parent::__construct();
  }

  

  public function index_get(){
    $response = $this->StockM->all_person();
    $this->response($response);
  } 

}

?>