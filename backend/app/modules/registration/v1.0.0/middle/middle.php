<?php
include_once './be/be.php';
class class_fe_user_account_registration{
  // check signature from database
function func_fe_user_account_registration($payload,$callback){
$class_be_account_registration = new class_be_account_registration();
$class_be_account_registration -> func_be_account_registration($payload,$callback);
}
}