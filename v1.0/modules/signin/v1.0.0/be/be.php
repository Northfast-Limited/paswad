<?php
include_once ".././config/dbconfig/db.php";
//check if account exists
class class_be_check_account {
    //received jwt payload
                function func_be_check_account($payload,$callback){
                    $class_db_account_fetch = new class_be_db_account_fetch();
                    $statement = 'SELECT * FROM  accounts  WHERE email = :email';
                    //difference is heare
                    //explode and decode the payload
                    $account_number = $payload;
                    $params  = array('email' => $account_number);
                    //get callback from the connection
                    $class_db_account_fetch -> func_be_db_account_fetch($statement,$params,$callback);
                }
                //generate login jwt if details correct 
                function generate_login_token($status,$db_response,$callback){
                    $decoded_db_response = json_decode($db_response);
                    $url_id = $decoded_db_response[0]->signatureid;
                    $exp = time() + 40;
                    $timestamp = time();
                    $header = [
                     'typ' => "url-check",
                     "alg" => "HS256",
                     'status' => $status,
                     'exp' => $exp
                    ];
    
                    $payload = [
                     'urlid' =>$url_id,
                    ];
                    $base64header =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($header)));
                    $base64payload =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($payload)));
                    $signature = hash_hmac('sha256', $base64header . "." . $base64payload, '**^$%#$@#FEWFewhgr3274y32gi2', true);
                    $base64signature = str_replace(['+', '/', '='], ['', '', ''], base64_encode($signature));
                    $url_token =  "$base64header.$base64payload.$base64signature";
                    if(is_callable($callback)) {                                          
                        call_user_func($callback,$url_token);
                        }else {
                              //invalid body or request format
            http_response_code(400);//Bad Request
            $response_code = 5;
            $payload = [
             'message' => "failed callback",
             'timestamp' => time()
            ];
            echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));   
                        }
                        
                }
    }
//mailer send to registered mail

class class_be_verify_account_password {
    function func_be_verify_account_password($payload,$callback) {
        
    }
}
function two_factor_authenication($instructions,$callback) {
}
    //token validation
function validate_received_token($token,$callback) {
}

    
function func_pwd_link_generator($payload,$callback){
    //link should include referenece to account number

    //callback to the calling function incase of error or successful generation
    //generates password entry links /this can be used for general purpose logins and whatsapp banking
    
    // $decoded_db_response = json_decode($db_response);
    // $url_id = $decoded_db_response[0]->signatureid;
    // $timestamp = time();
    // $header = [
    //  'typ' => "url-check",
    //  "alg" => "HS256",
    //  'type' => 'pel',//pwd entry link 
    //  'exp' => $exp //exp 20 seconds
    // ];

    //payload information
    $timestamp = time();
    $expiry = time() + 60;
    $random = rand(500000, 1500000);
    $button_token = base64_encode("$random.$payload");
    $payload = [
     'tempauthcode'=> $payload,
     'responseCode' => "1",
     'typ' => "consent",
     'client' => 'system',//generated for which client eg. internal system,thirdparty,eg. whatsapp
     'expiry' => $expiry,
     'timestamp' => $timestamp //exp 20 seconds
    ];
    //take password and query the api together with the account number/email
    $response = "<input type='password' name='' id='' placeholder='password' required><button class='$button_token' type='button' id='loginBtn'>Log in</button>";
    //two response arrays 
    // response message 
    //response
    $response = json_encode(array('response' =>$response ,'payload'=>$payload));
    // $base64header =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($header)));
    // $base64payload =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($payload)));
    // $signature = hash_hmac('sha256', $base64header . "." . $base64payload, '**^$%#$@#FEWFewhgr3274y32gi2', true);
    // $base64signature = str_replace(['+', '/', '='], ['', '', ''], base64_encode($signature));
    // $url_token =  "$base64header.$base64payload.$base64signature";
    if(is_callable($callback)) {                                          
        call_user_func($callback,$response);
        }else {
            //failed callback
            http_response_code(400);//Bad Request
            $response_code = 6;
            $payload = [
             'message' => "failed callback",
             'timestamp' => time()
            ];
            echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));   
        }
}
