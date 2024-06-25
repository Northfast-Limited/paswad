<?php
 include_once  'config.php';  
 //no update  
    class class_be_db_account_fetch{
      private $class_callback;
      private $password;
        function func_be_db_account_fetch($statement,$params,$payload,$callback) {
          $this->class_callback = $callback;
          $this->password = $payload['password'];
            $config = new db_config;
            $dsn = 'pgsql:host ='. $config->host .';dbname='.$config->database;
            $sql = new PDO($dsn , $config->username,$config->password);
            $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                $realStatement = $statement;
                $stmnt = $sql ->prepare($statement);
                $stmnt->execute($params);
                $response = $stmnt->fetchAll(PDO::FETCH_OBJ);
                $sql ->prepare($realStatement);
                $count = $stmnt -> rowCount();
                if($count === 1) {
                    $real_db_response = $response;
                    $hashedpassword = $real_db_response[0]->hashedpassword;
                    $tempauthcode = $real_db_response[0]->tempauthcode; 
                    $email = $real_db_response[0]->email; 
                    $payload = [
                      'hashedpassword' => $hashedpassword,
                      'tempauthcode' => $tempauthcode,
                      'email' =>$email
                    ];
                    $api_endpoint_status_code = 1;

                        // $db_response = json_encode(array("response" =>$real_db_response,"responseCode" =>$api_endpoint_status_code));
                        $this->func_be_db_time_password_check($payload);
                }else {
                  $api_endpoint_status_code = 0;//true 9 - jwt generated 
                  $payload = [
                    'message' => 'Wrong password try again',
                    'timestamp' => time(),
                    ];
                  $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
                    http_response_code(404);//not found
                    //proper way should give feedback
                    if(is_callable($callback)) {
                        call_user_func($callback,$db_response);
                        }else {
                           http_response_code(404);//not found
                           echo json_encode(array("invalid callback" => "404/callback not found" ));
                        }
                }      
        }
//syntax of my functions
//callback5
//explode tempauth code
        function func_be_db_time_password_check($payload) {
          $hashedpassword = $payload['hashedpassword'];
          $tempauthcode = $payload['tempauthcode']; 
          $email = $payload['email'];
          $explode_tempeuthcode = explode(".", $tempauthcode);
          $wanted_time = $explode_tempeuthcode[1];
          //current time 
          $current_timestamp = time();
          
         if(password_verify($this->password,$hashedpassword) && ($current_timestamp - $wanted_time)<60){
          //call jwt token generator for dashboard
          $payload = [
            'email' => $email
          ];
          //after verifiying the timestamp it is nothing to the user to get to the next level ,which is obtaining a password link.

          $this->func_be_db_dashboard_jwt_generator($payload);
      
              }else if(password_verify($this->password,$hashedpassword) && ($current_timestamp - $wanted_time)>60){
                  //request expired
                  $api_endpoint_status_code = 0;//true 9 - jwt generated 
                  $payload = [
                    'message' => 'request expired,please refresh',
                    'timestamp' => time(),
                    ];
                  $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
                  if(is_callable($this->class_callback)) {
                   call_user_func($this->class_callback,$db_response);
                   }else {
                      http_response_code(404);//not found
                      echo json_encode(array("wrong password" => "404/wrong password" ));
                   };
              }else {
                   //request expired
                   $api_endpoint_status_code = 0;//true 9 - jwt generated 
                   $payload = [
                     'message' => 'Wrong Password,remaining trials 3',
                     'timestamp' => time(),
                     ];
                   $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
                   if(is_callable($this->class_callback)) {
                    call_user_func($this->class_callback,$db_response);
                    }else {
                       http_response_code(404);//not found
                       echo json_encode(array("callback error" => "404/callback not found" ));
                    };
              }
        }
        //no callbacks,provides response as genereated jwt
        //exactly three api calls per client for login
        //to be update tonight 

        //requester is always a client, either system or thirdparty on behalf of the end user, if it is system
        // the default redirect uri is the dashboard of authenicator 
        function func_be_db_dashboard_jwt_generator($payload){
            $client_id = "0000";
            $client_name = "system";
            $client_status="active";
            $exp = time()+10;
            $timestamp = time();
            $header = [
             'typ' => "auth",
             "alg" => "HS256",
             'status' => $client_status,
             'exp' => $exp,
             'timestamp' => $timestamp,
            ];
    
            $payload = [
                'client-id' => $client_id,
                'client-name' => $client_name,
                'token-role' => 'admin'
            ];
            $base64header =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($header)));
            $base64payload =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($payload)));
            $signature = hash_hmac('sha256', $base64header . "." . $base64payload, '**^$%#$@#FEWFewhgr3274y32gi2', true);
            $base64signature = str_replace(['+', '/', '='], ['', '', ''], base64_encode($signature));
            $token =  "$base64header.$base64payload.$base64signature";

          //generate dashboard token and redirect to dashboard//dynamic redirect url
          $api_endpoint_status_code = 11;//true 9 - jwt generated 
          $payload = [
            'message' => 'success',
            'redirect' => "http://172.31.105.163/auth/onepass/v1.0/modules/dashboard/?jwt=$token",
            'timestamp' => time(),
            ];
            //should redirect to dashboard or provide menu according to the client type
          $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
      
          echo $db_response;
        }

    }
 
