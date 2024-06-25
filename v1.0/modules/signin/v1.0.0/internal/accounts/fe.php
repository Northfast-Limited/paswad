<?php
header("Content-Type: application/json");
include_once 'be.php';
class class_fe_check_account_details {
function verify_body_headers($data,$callback) {
    if ($data !== null ) {
        if (isset($data['accountnumber'])) {

            //create object of the api endpoint class
            $checkaccountdetails = new class_be_check_account_details();
            $accountnumber = $data['accountnumber'];
            $checkaccountdetails -> func_be_check_account_details($accountnumber,$callback);
        } else {
            http_response_code(400); // Bad Request
            echo json_encode(array("404" => "Missing account information"));
        } 
    }else {
        http_response_code(400); // Bad Request
        echo json_encode(array("Error:0001-0002" => "null body"));
    }
    }
}
