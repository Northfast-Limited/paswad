<?php
include_once 'be.php';
class class_fe_check_url_registration_status {

  // check signature from database
function func_fe_check_url_registration_status($signature,$callback){
$be_url_status_check = new class_be_url_registration_status_check();
$be_url_status_check -> func_be_url_registration_status_check($signature,$callback);
}
}