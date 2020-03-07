<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Layout {

    protected $_CI;

    function __construct() {
        $this->_CI = &get_instance();
    }

    function display($theme, $data = null) {
        $data['_content'] = $this->_CI->load->view($theme, $data, true);
        $data['_header'] = $this->_CI->load->view('theme/header', $data, true);
        $data['_footer'] = $this->_CI->load->view('theme/footer', $data, true);
        $this->_CI->load->view('theme/layout', $data);
    }

}


