<?php
include_once "./fe/fe.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $ip = $_SERVER['SERVER_ADDR'];
    $domain =$_SERVER['SERVER_NAME'];
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
     process_request($data,function($payload,$response){
        if($response != null){
            user_login($response,function($response){
                http_response_code(200);
                echo $response;
             });
        }else{
            http_response_code(400);
            $response_code = 5;
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
function process_request($data,$callback) {
if ($data !== null ) {
    if (isset($data['email'],$data['password'],$data['timestamp'])) {
        $email = $data['email'];
        $password = $data['password'];
        $timestamp = $data['timestamp'];
       $base64email =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($email)));
       $tempauthcode = "$base64email.$timestamp"; 
 $payload = [
   'tempauthcode' => $tempauthcode,
   'password' => $password
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
        $positive_response_code = 0;
        if(is_callable($callback)) {
            call_user_func($callback,$payload,$positive_response_code);
            }else {
               http_response_code(404);
               echo json_encode(array("invalid callback function" => "404/callback not found" ));
            }
    } 
}else {
    http_response_code(400);
    $payload = 'null data';
    $positive_response_code = 222;
    if(is_callable($callback)) {
        call_user_func($callback,$payload,$positive_response_code);
        }else {
           http_response_code(404);
           echo json_encode(array("invalid callback function" => "404/callback not found" ));
        }
}
}
?>