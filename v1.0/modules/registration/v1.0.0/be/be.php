<?php
include_once ".././config/dbconfig/db.php";
//check if account exists
class class_be_account_registration {
    //received jwt payload
                function func_be_account_registration($payload,$callback){
                    $class_be_db_account_registration = new class_be_db_account_registration();
                    //registration statement
                    $statement = '
                    INSERT INTO accounts (email,account_number,account_imsi,hashedpassword,trials,accountstatus,first_name,last_name,dob) 
                    VALUES (:email,:account_number, :account_imsi, :hashedpassword,:trials,:accountstatus,:first_name,:last_name,:dob)
                ';
                     $account_number = (string)mt_rand(100000, 999999);
                     $account_imsi= $payload['account_imsi'];
                     $email = $payload['email'];
                     $first_name = $payload['first_name'];
                     $last_name = $payload['last_name'];
                     $dob = $payload['dob'];
                     $password = $payload['password'];
                     $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $account_number = $payload;
                    $trials = 0;
                    $params  = array('email'=>$email,'account_number' =>"123421412",'account_imsi'=>$account_imsi,'hashedpassword'=>$hashedPassword,'trials'=>$trials,'accountstatus'=>'active','first_name'=>$first_name,'last_name'=>$last_name,'dob'=>$dob);
                    //get callback from the connection
                    $class_be_db_account_registration -> func_be_db_account_registration($statement,$params,$callback);
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
