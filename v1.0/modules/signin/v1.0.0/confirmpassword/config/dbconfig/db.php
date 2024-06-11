<?php
 include_once  'config.php';  
 include_once   '../../../twoStepAuthenication/v1.0/immig1/generator/index.php';
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
                  $api_endpoint_status_code = 7;//true 9 - jwt generated 
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
                   $api_endpoint_status_code = 11;//true 9 - jwt generated 
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
        function func_be_db_dashboard_jwt_generator($payload){
          //two ste authenica
          $func_be_two_step_authenication = new func_be_two_step_authenication();
               $func_be_two_step_authenication->func_be_two_step_authenication($payload);
        }

    }
 
