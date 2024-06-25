<?php
include_once "./config/dbconfig/db.php";
class class_be_token_validation {
                function func_be_token_validation($payload,$callback){
                    $class_be_db_token_validation = new class_be_db_token_validation();
                    $statement = 'SELECT * FROM  immig  WHERE authtoken = :authtoken';
                    $authtoken = $payload;
                    $params  = array('authtoken' => $authtoken);
                    //get callback from the connection
                    $class_be_db_token_validation -> func_be_db_token_validation($statement,$params,$payload,$callback);
                }
    }
