<?php
include_once './middle/middle.php';
function token_validation($payload,$callback) {
    $class_fe_user_token_validation = new class_fe_user_token_validation();
   $class_fe_user_token_validation -> func_fe_user_token_validation($payload,$callback);
}