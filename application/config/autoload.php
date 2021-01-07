<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// NOTED ID USER TELLER HARUS 1 CHAR KARNA QUERY GET INV MENGACU KE MAX LEFT 1 
// DIMANA MAX LEFT 1 TSBT MERUPAKAN ID USER UNTUK TELLER

$autoload['packages'] = array();

$autoload['libraries'] = array('database','session','pagination','form_validation','layout','cart','header','DB_Sync');

$autoload['drivers'] = array();

$autoload['helper'] = array('url','date');

$autoload['config'] = array();

$config['composer_autoload'] = "vendor/autoload.php";

$autoload['language'] = array();

$autoload['model'] = array('valas/MatauangM','valas/BackofficeM','setting/RegistM','setting/UserM','valas/StockM','valas/RelasiM','valas/PenjualanM');
