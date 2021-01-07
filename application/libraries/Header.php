<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Header {

    protected $_CI;

    function __construct() {
        $this->_CI = &get_instance();
    }

    function get(){

        header('location:/BAFAGEH/valas');
    }

}


