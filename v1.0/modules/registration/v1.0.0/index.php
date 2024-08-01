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
        if($response_code == 1){
            user_login($payload,function($response){
                echo $response;
             });
        }else{
         echo 'invalid body';
        }

     });

}else {
    http_response_code(400);
    $response_code = 4;
    $payload = [
     'message' => "Bad request,request type not allowed",
     'timestamp' => time()
    ];
    echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));
}



function process_request($data,$callback) {

if ($data !== null) {
    if (isset($data['fields'])) {
        $payload = $data['accountnumber'];
        $positive_response_code = 1;
        if(is_callable($callback)) {
            call_user_func($callback,$payload,$positive_response_code);
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

