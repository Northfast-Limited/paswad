<?php
 include_once  'config.php';  
    class class_be_db_token_validation{
        function func_be_db_token_validation($statement,$params,$payload,$callback) {
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
                    $authtoken = $real_db_response[0]->authtoken; 
                    $email = $real_db_response[0]->email; 
                    $payload = [
                      'message'=>'Login approved',
                      'consent' => $authtoken,
                      'email' =>$email
                    ];
                    $api_endpoint_status_code = 1;
                    $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));

                        //something like successfull authorization or response code 
                        if(is_callable($callback)) {
                          call_user_func($callback,$db_response);
                          }else {
                             http_response_code(200);
                             echo json_encode(array("invalid callback" => "404/callback not found" ));
                          }
                }else {
                  $api_endpoint_status_code = 0;//true 9 - jwt generated 
                  $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));

                    http_response_code(200);//not found
                    if(is_callable($callback)) {
                        call_user_func($callback,$db_response);
                        }else {
                           http_response_code(200);//not found
                           echo json_encode(array("invalid callback" => "404/callback not found" ));
                        }
                }      
        }

    }
 
