<?php
header("Content-Type: application/json");

include_once "./fe/fe.php";
//do some authenication 
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $ip = $_SERVER['SERVER_ADDR'];
    $domain =$_SERVER['SERVER_NAME'];
    //data 
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
     process_request($data,function($payload,$response_code){
        // echo $payload;
        // echo $response_code;
     
        if($response_code == 1){
            user_login($payload,function($response){
                echo $response;
             });
        }else{
         echo 'invalid body';
        }

     });

}else {
    http_response_code(400);//Bad Request
    $response_code = 4;
    $payload = [
     'message' => "Bad request",
     'timestamp' => time()
    ];
    echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));
}
// //user consent for oauth 2.0
// function preauth_client_details_check($urlSignature,$callback) {
//     $jsonData = file_get_contents('php://input');
//     $data = json_decode($jsonData, true);
//     process_request($data,$callback);
// }

//func verify request payload 
function process_request($data,$callback) {
//check for the correct body 
//reusable
if ($data !== null ) {
    if (isset($data['accountnumber'])) {
        $payload = $data['accountnumber'];
        $positive_response_code = 1;
        //call the callback with response code
        if(is_callable($callback)) {
            call_user_func($callback,$payload,$positive_response_code);
            }else {
               http_response_code(404);//not found
               echo json_encode(array("invalid callback function" => "404/callback not found" ));
            }
    } else {
        http_response_code(400); // Bad Request
        $payload = 'invalid body';
        $positive_response_code = 0;
        //call the callback with response code
        if(is_callable($callback)) {
            call_user_func($callback,$payload,$positive_response_code);
            }else {
               http_response_code(404);//not found
               echo json_encode(array("invalid callback function" => "404/callback not found" ));
            }

    } 
}else {
    http_response_code(400); // Bad Request
    $payload = 'null data';
    $positive_response_code = 222;
    //call the callback with response code'?
    if(is_callable($callback)) {
        call_user_func($callback,$payload,$positive_response_code);
        }else {
           http_response_code(404);//not found
           echo json_encode(array("invalid callback function" => "404/callback not found" ));
        }
}
}
//generate link with jwt token and username details
// after password entry the user to be notified of any sign in or added apps
/// 2 factor authenication to be made via email 

?>

