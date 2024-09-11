<?php
 include_once  'config.php';  
 //no update  
    class class_be_db_account_fetch{
        private $class_callback;
        function func_be_db_account_fetch($statement,$params,$callback) {
            //general execution
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
                    http_response_code(200);//ok
                    //generae tempauthenication code if the account details are correct
                     $email = $response[0]->email;
                    $api_endpoint_status_code = 1;//truth
                    $time = time();
                    $payload = [
                      'email' => $email,
                      'account status' => 'Valid',
                      'timestamp' => $time
                    ];
                    $db_response = json_encode(array("response" =>array("responseCode" =>$api_endpoint_status_code ,"payload"=>$payload)));
                    $this->func_be_db_temp_auth_code_gen($db_response);
                }else {
                    $api_endpoint_status_code = 0;//false
                    $payload = 'account not found';
                    $db_response = json_encode(array("response" =>array("responseCode" =>$api_endpoint_status_code ,"payload"=>$payload)));
                    http_response_code(200);//not found
                    //proper way should give feedback
                    if(is_callable($callback)) {
                        call_user_func($callback,$db_response);
                        }else {
                           http_response_code(200);//not found
                           echo json_encode(array("invalid callback" => "404/callback not found" ));
                        }
                }      
        }
        function func_be_db_auth_code_input($statement,$params,$callback) {
 //general execution
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
        //no response
         $api_endpoint_status_code = 1;//truth
         $Responsetime = time();
         $buttonIdentifier = time();
         $inputIdentifier = time();
         $dynamic  = "<input data-timestamp='$inputIdentifier' type='password' required placeholder='password' id='password'><button onclick='pwdCheckApi()'type='button' identifiertoken='$buttonIdentifier'>Continue</button>";
         $payload = [
           'message' => 'found',
           'affectedRows' => $count,
           'Responsetimestamp' => $Responsetime,
           'content' => $dynamic
         ];
         $db_response = json_encode(array("response" =>array("responseCode" =>$api_endpoint_status_code ,"payload"=>$payload)));
         //callback
             if(is_callable($callback)) {
             call_user_func($callback,$db_response);
             }else {
                http_response_code(404);//not found
                echo json_encode(array("invalid callback" => "404/callback not found" ));
             }

     }else {
         $api_endpoint_status_code = 0;//false
         // more detailed payload
         $payload = 'auth code saving failed';
         $db_response = json_encode(array("response" =>array("responseCode" =>$api_endpoint_status_code ,"payload"=>$payload)));
         http_response_code(404);//not found
         //proper way should give feedback
         if(is_callable($callback)) {
             call_user_func($callback,$db_response);
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
        function func_be_db_temp_auth_code_gen($payload) {
            $timestamp =time(); 
            $decodedPaylod = json_decode($payload);
            $email = $decodedPaylod->response->payload->email;
            $timestamp = $decodedPaylod->response->payload->timestamp;
            $base64email =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($email)));
            $tempauthcode = "$base64email.$timestamp"; 
            //query db and input  
            // echo json_encode($tempauthcode);
            //props for db connection 
            $class_db_account_fetch = new class_be_db_account_fetch();
            //update statement 
            //temp auth code expires
            $statement = 'UPDATE accounts set tempauthcode =:tempauthcode  WHERE email = :email';
            $params  = array('tempauthcode'=>$tempauthcode,'email' => $email);
            $this->func_be_db_auth_code_input($statement,$params,function($response){
       echo $response;
            });
        }


    }
