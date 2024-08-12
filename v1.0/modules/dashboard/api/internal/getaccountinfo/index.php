<?php

//request for active jwt token with claims to retreive user information
include_once "./fe/fe.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $ip = $_SERVER['SERVER_ADDR'];
    $domain =$_SERVER['SERVER_NAME'];
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
     process_request($data,function($payload,$response){
        //check for response code
        if($response !=0){
            getaccountinfo($response,function($response){
                http_response_code(200);
                echo $response;
             });
        }else{
            http_response_code(400);
            $response_code = 0;
            $payload = [
             'message' => "invalid body",
             'timestamp' => time()
            ];
            echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));   
             }
     });
}else {
    http_response_code(400);
    $response_code = 4;
    $payload = [
     'message' => "Bad request",
     'timestamp' => time()
    ];
    echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));
}
//token decoder
function base64UrlDecode($data) {
    $base64 = str_replace(['-', '_'], ['+', '/'], $data);
    $base64 = str_pad($base64, strlen($base64) % 4, '=', STR_PAD_RIGHT);
    return base64_decode($base64);
}
//validate jwt first
function isValidJWT($token) {
    $parts = explode('.', $token);
    return count($parts) === 3;
}
function decodeJWT($token) {
    if (!isValidJWT($token)) {
        http_response_code(400);
        $payload = 'invalid body';
        echo json_encode($payload);
        exit;
    }

    list($header, $payload, $signature) = explode('.', $token);

    // Decode base64 URL-encoded strings
    $header = base64UrlDecode($header);
    $payload = base64UrlDecode($payload);

    return [
        'header' => json_decode($header, true),
        'payload' => json_decode($payload, true),
        'signature' => $signature // Optionally include the signature
    ];
}
function process_request($data,$callback) {
if ($data !== null ) {
    //request must have timestamp for help in analytics
    //timestamp verification
    //user verification
    //request ip verification
    //limited requested resource approval
    if (isset($data['token'])) {
        //initial login timestamp required
        $token = $data['token'];
        //decode token and extract email
        $decodedToken = decodeJWT($token);
        //extract email from token
        $user_identifier = $decodedToken['header']['userId'];
        $timestamp =  $decodedToken['header']['timestamp'];
       $base64email =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($user_identifier)));
       $tempauthcode = "$base64email.$timestamp"; 

 $payload = [
   'userId' => $user_identifier
 ]; 
        $response = $payload;
        if(is_callable($callback)) {
            call_user_func($callback,$payload,$response);
            }else {
               http_response_code(404);
               echo json_encode(array("invalid callback function" => "404/callback not found" ));
            }
    } else {
      
        http_response_code(400);
        $payload = 'invalid body';
        $response_code = 0;
        if(is_callable($callback)) {
            call_user_func($callback,$payload,$response_code);
            }else {
               http_response_code(404);
               echo json_encode(array("invalid callback function" => "404/callback not found" ));
            }
    } 
}else {
    http_response_code(400);
    $payload = 'invalid body';
    $response_code = 0;
    if(is_callable($callback)) {
        call_user_func($callback,$payload,$response_code);
        }else {
           http_response_code(404);
           echo json_encode(array("invalid callback function" => "404/callback not found" ));
        }
}
}
?>