<?php 
header('Content-Type: application/json; charset=utf-8');
//pureConfiguration
class config {
    public $host = 'localhost';
    public $database = 'api';
    public $username = 'root';
    public $password = '';
    function realConnect($pan , $executionProperty){
        $cfg = new config;
        cooker($pan,$executionProperty);
    }

}
