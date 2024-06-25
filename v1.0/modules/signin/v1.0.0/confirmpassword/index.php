<?php
//confirms password and returns a token for dashboard
// process final login process //queries the system config for features
header("Content-Type: application/json");
include_once "./fe/fe.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $ip = $_SERVER['SERVER_ADDR'];
    $domain =$_SERVER['SERVER_NAME'];
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    //generate the hash password and make the request ready for db query
    // process_request receives callback
    //response from backend 
     process_request($data,function($payload,$response){
        if($response != null){
            user_login($response,function($response){
                http_response_code(200);//ok
                echo $response;
             });
        }else{
            //invalid body or request format
            http_response_code(400);//Bad Request
            $response_code = 5;
            $payload = [
             'message' => "invalid body",
             'timestamp' => time()
            ];
            echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));   
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



function process_request($data,$callback) {
//build tempauthcode with provided email and current timestamp
if ($data !== null ) {
    if (isset($data['email'],$data['password'],$data['timestamp'])) {
        $email = $data['email'];
        $password = $data['password'];
        $timestamp = $data['timestamp'];
       //temp
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
function dashboard_token_link_generator($payload,$callback){
   
}
?>

