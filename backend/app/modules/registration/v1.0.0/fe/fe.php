<?php
include_once './middle/middle.php';
function user_registration($payload,$callback) {
    $class_fe_user_account_registration = new class_fe_user_account_registration();
   $class_fe_user_account_registration -> func_fe_user_account_registration($payload,$callback);
}