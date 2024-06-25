<?php
include_once './be/be.php';
class class_fe_user_token_validation{
  // check signature from database
function func_fe_user_token_validation($payload,$callback){
$class_be_token_validation = new class_be_token_validation();
$class_be_token_validation -> func_be_token_validation($payload,$callback);
}
}