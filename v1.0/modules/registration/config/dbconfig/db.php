<?php
 include_once  'config.php';  
 //no update  
    class class_be_db_account_registration{
        private $class_callback;
        function func_be_db_account_registration($statement,$params,$callback) {
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
                    $api_endpoint_status_code=1;
                    $time = time();
                    $payload = [
                      'status' => 'registration successful',
                      'timestamp' => $time
                    ];
                    $db_response = json_encode(array("response" =>array("responseCode" =>$api_endpoint_status_code ,"payload"=>$payload)));
                    if(is_callable($callback)) {
                        call_user_func($callback,$db_response);
                        }else {
                           http_response_code(200);//not found
                           echo json_encode(array("invalid callback" => "404/callback not found" ));
                        }
                }else {
                    $api_endpoint_status_code = 0;//false
                    $payload = 'registration failed';
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

    }
