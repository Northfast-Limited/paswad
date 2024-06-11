<?php
header("Content-Type: application/json");
include_once "v1.0/checkClientDetails/frontend.php";
include_once "urlc/front.php";
include_once "../auth/index.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $ip = $_SERVER['SERVER_ADDR'];
    $domain =$_SERVER['SERVER_NAME'];
     $payload = base64_encode("$domain");
     verify_request_origin($payload,function($response){
        http_response_code(200);//ok
        //the response is trusted becouse it is from database and if provided again by the client , it should be 
        //verified first through the request verifiy origin endpoint
        preauth_client_details_check($response,function($preuth_token){
            //send this over to authenication again
            $authenication = new authenication();
                $authenication->generate_auth($preuth_token,function($auth_token) {
                     echo json_encode(array("authtoken"=>$auth_token));
                });
        });    
     });
}else {
    http_response_code(400);//Bad Request
    echo json_encode(array("Error:3456-0002883774662992" => "Invalid request"));
}

//func preauth_check_client_details
 //needs valid url signature
function preauth_client_details_check($urlSignature,$callback) {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    process_request($data,$callback);
}

//func verify request payload 
function process_request($data,$callback) {

//check for the correct body 
if ($data !== null ) {
    // Access the data and perform operations
    //check also for correct body structure
            //check if client secret and id contains valid data and doesnt contain invalid characters
    if (isset($data['client_id']) && isset($data['client_secret'])&& $data['client_id'] !== null && $data['client_secret'] !== null && $data['client_id'] !== "" && $data['client_secret'] !== "") {
        //create object of the api endpoint class
        $checkClientDetails = new fe_check_client_details();
        $client_id = $data['client_id'];
        $client_secret = $data['client_secret'];
        //final endpoint call
        $checkClientDetails -> fe_check_client_details($client_id, $client_secret,$callback);
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array("404" => "Invalid request. Missing client_id or client_secret,this ip will be blocked after 3 attempts."));
    } 
}else {
    http_response_code(400); // Bad Request
    echo json_encode(array("Error:0001-0002" => "Null data"));
}
}
?>

