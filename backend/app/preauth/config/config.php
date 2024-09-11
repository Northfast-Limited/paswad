<?php 
header('Content-Type: application/json; charset=utf-8');
//restricted access
 //access only from sso.northfast.co.ke/preuth with secret key
 //otherwise restricted json response
//pureConfiguration
class db_config {
    public $host = '171.31.96.1';
    public $database = 'api';
    public $username = 'muslih';
    public $password = '0';
}

