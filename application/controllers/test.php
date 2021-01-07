<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller{

    // constructor
    public function __construct(){
      parent::__construct();
    }

    public function postCURL($_url, $_param){

        $postData = '';
        //create name value pairs seperated by &
        foreach($_param as $k => $v) 
        { 
          $postData .= $k . '='.$v.'&'; 
        }
        rtrim($postData, '&');


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, false); 
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

        $output=curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public function index (){
        $params= array(
            "name" => 'Irfan'
            
         );
 $url = 'office.bafageh.com';
 
 echo '<br><hr><h2>'.$this->postCURL($url, $params).'</h2><br><hr><br>';
    }
}