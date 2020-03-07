<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

/*
| -------------------------------------------------------------------------
| Memcached settings
| -------------------------------------------------------------------------
| Your Memcached servers can be specified below.
|
|	See: https://codeigniter.com/user_guide/libraries/caching.html#memcached
|
*/
$config = array(
	'default' => array(
		'hostname' => '127.0.0.1',
		'port'     => '11211',
		'weight'   => '1',
	),
);
