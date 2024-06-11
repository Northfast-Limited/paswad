<?php
include_once 'middle.php';
//make a callback
function verify_request_origin($payload,$callback) {
    $fe_check_url_registration_status = new class_fe_check_url_registration_status();
              $payload;
          $fe_check_url_registration_status -> func_fe_check_url_registration_status($payload,$callback);
}