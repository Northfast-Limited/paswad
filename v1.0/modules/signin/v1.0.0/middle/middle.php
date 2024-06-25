<?php
include_once './be/be.php';
class class_fe_user_account_login{
  // check signature from database
function func_fe_user_account_login($payload,$callback){
$class_be_account_login = new class_be_check_account();
$class_be_account_login -> func_be_check_account($payload,$callback);
}
}