<?php
//confirms consent token for 2fa and returns a token for dashboard
//link validation to be addedd
//consent form for all client types, for some apps like react native , might do login and receive consent within the app

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include_once "./fe/fe.php";
//receive token from get request and process the information
if ($_SERVER['REQUEST_METHOD'] === 'GET') { 
    $ip = $_SERVER['SERVER_ADDR'];
    $domain =$_SERVER['SERVER_NAME'];
    $token = isset($_GET['token']) ? $_GET['token'] : null;

     process_request($token,function($payload,$response){
        if($response != null){
            token_validation($response,function($response){
                http_response_code(200);//ok
                $decoded_response = json_decode($response);
                if($decoded_response->response->responseCode == 1){
                    //generate dashboard jwt with a token generated with users public identifier
                    dashboard_token_link_generator($decoded_response);
                }else{
                    http_response_code(200);//Bad Request
                    $response_code = 5;
                    $payload = [
                        'message' => "invalid token, the token could not be verified, login request denined",
                        'timestamp' => time()
                       ];
                       echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));   
                }
             });
        }else{
            //invalid body or request format
            http_response_code(200);//Bad Request
            $response_code = 5;
            $payload = [
             'message' => "invalid body,no token found, read documentation at documentation.muslih.tech",
             'timestamp' => time()
            ];
            echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));   
             }

     });

}else {
    http_response_code(200);//Bad Request
    $response_code = 4;
    $payload = [
     'message' => "Bad request,this request type is not allowed for this api,read the documentation online at documentation.muslih.tech",
     'timestamp' => time()
    ];
    echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));
}


//request processor 
function process_request($token,$callback) {
//verify the token from the token database table 
if ($token !== null ) {
    if (isset($_GET['token'])) {
        $response = $token;
        if(is_callable($callback)) {
            call_user_func($callback,$response,$response);
            }else {
               http_response_code(404);//not found
               echo json_encode(array("invalid callback function" => "404/callback not found" ));
            }
    } else {
        http_response_code(200); // Bad Request
        $payload = 'invalid body';
        $positive_response_code = 0;
        //call the callback with response code
        if(is_callable($callback)) {
            call_user_func($callback,$payload,$positive_response_code);
            }else {
               http_response_code(200);//not found
               echo json_encode(array("invalid callback function" => "404/callback not found" ));
            }

    } 
}else {
    http_response_code(200); // Bad Request
    $payload = 'null data';
    $positive_response_code = 222;
    //call the callback with response code'?
    if(is_callable($callback)) {
        call_user_func($callback,$payload,$positive_response_code);
        }else {
           http_response_code(200);//not found
           echo json_encode(array("invalid callback function" => "404/callback not found" ));
        }
}
}
// generate jwt for the dashboard 
//final dashboard link response
function dashboard_token_link_generator($payload){
    $email = $payload->response->payload->email;
    $consent = $payload->response->payload->consent;
        $exp = time()+10;
        $timestamp = time();
        $header = [
         'typ' => "login",
         "alg" => "HS256",
         'status' => 'active account',
         'exp' => $exp,
         'timestamp' => $timestamp,
        ];

        $payload = [
            'email' => $email,
            'client' => 'browser',
            'role' => 'admin',
            'consentToken' => $consent
        ];
        $base64header =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($header)));
        $base64payload =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($payload)));
        $signature = hash_hmac('sha256', $base64header . "." . $base64payload, '**^$%#$@#FEWFewhgr3274y32gi2', true);
        $base64signature = str_replace(['+', '/', '='], ['', '', ''], base64_encode($signature));
        $dashboard_jwt =  "$base64header.$base64payload.$base64signature";

        $api_endpoint_status_code = 1;
        $payload = [
         'message' => "Dashboard link generated",
         'token'=> 'jwt',
         'content' => $dashboard_jwt
        ];
        //retunr html
        //wait for consent
        header('Content-Type: text/html'); // Set the content type to HTML
        $message = "<p>Someone is requesting a login to your account,We hae verified the token but consent is required, if this is you ,please click Accept to authorize the login request ,otherwise click Reject and the authorization server will be alerted.<p>";
        
        //onclick event will be fired by js fetch to contact consent update
        $accept_btn = "<button type='button' style='background-color:white;color:green;padding:0.4cm;border-width:0.01cm;border-radius:0.1cm;margin:0.3cm;cursor:pointer;'>Approve</button>";

        $reject_btn = "<button type='button' style='background-color:white;color:red;padding:0.4cm;border-width:0.01cm;border-radius:0.1cm;margin:0.3cm;cursor:pointer;'>Reject</button>";
    
        echo "$message$accept_btn$reject_btn";
        //$db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
    // echo $db_response;

    function end_user_consent_authorization($payload){
    //receive consent form update and callback login page
    }
}
?>
