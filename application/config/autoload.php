<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

$autoload['packages'] = array();

$autoload['libraries'] = array('database','session','pagination','form_validation','layout','cart');

$autoload['drivers'] = array();

$autoload['helper'] = array('url','date');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('MatauangM','BackofficeM','RegistM','UserM','StockM');
