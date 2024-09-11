<?php
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
//no access allowed
$jsonData = file_get_contents('php://input');
// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);

} else {
    http_response_code(400);
    echo json_encode(array("message" => "access error"));
}

include_once 'backend.php';
//called from checkClientDetails preuth
//steps 
/*
-check if it is first time if(provide preauth after further security checks) if not
-check jwt-validity and was it last provided  authenication jwt and does the domain and signature match
-mark jwt as expired and used in the database //used jwts database,
- provide new preuth with expiry as 60s for using to get new authenication jwt
needed hashed details
*/
//get clientDetails from the database and donot expose 
//client_status should also be checked
class fe_check_client_details {

function fe_check_client_details($client_id,$client_secret,$callback) {
    $be = new be_check_credentials();
    //call backend and getbackresponse function to be called is check_credentials
    // returns valid,invalid,suspended,blocked,awaiting approval , jwt claim
    $be -> be_check_credentials($client_id,$client_secret,$callback);
    //will forward to jwt validity if has jwt or was provided one previously
    //will forward to callAuthenication if all checks pass nb://callAuthenication has no access to db , 
        //just provides stateless jwts
}
function first_time_check() {

}
//jwt payload check 
//jwt exp and all variables check 
//jwt invalid data check with signature
//signature check 
function jwt_validity() {

}
//should pass preauth payload jwt , with payload as either new_comer or jwt_renewal
// authenication server should check the validity of the preauth jwt provided
// and check the signature and data with public key
function call_auth($preauth) {

}
}
