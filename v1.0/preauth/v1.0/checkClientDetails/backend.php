<?php
//prauth database
//no get only post to check, no get, no delete,update only with admin approval
// hashed client details the following to be specific:
/* Client id , client secret , client_name-case_sensitive: ,
$timestamp((strictly in the last 60 secsonds, for security purposes)):
echo hash('sha256', 'The quick brown fox jumped over the lazy dog.');

even this preauth needs specific details and secret key to access the endpoint for checking 
client_details

author: Muslih Abdiker Ali

*/
//seperate from the main api gateway - for the web application
//authenication api enpoint ="checkClientDetails";

   //cooker class
    //cooks the connection
    //prepares and calls the connection
    //has access to config.php
 include_once  '././config/config.php';   
 include_once '././security/index.php';
    class connection {
        //general function
        //runs queries for all endpoints
        //in the future , we will have some 
        function connect($statement,$params,$callback) {
            $security = new security();
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
                    foreach($response as $data) {
                        $responseData = json_encode([$data]);
                    }
                    //forward the data for security screening
                    $security->check_client_status($responseData,$count,$params,$callback);

                }else {
                    echo json_encode(array("invalid client" => "be_nfound/account_stattus_update" ));
                }      
        }
    }
class be_check_credentials {
//confirms provided client information and returns full client  details for now 
            function be_check_credentials($client_id,$client_secret,$callback){
                $connection = new connection();
                $statement = 'SELECT * FROM  preauth WHERE client_id = :cl_id OR client_secret = :cl_secret';
                $params  = array(':cl_id' => $client_id,'cl_secret' => $client_secret);
                $connection -> connect($statement,$params,$callback);
            }
}
//strictly for updating trials,and account_status
//hass access to connection
class be_client_operations {
       //block with the correct client_id, client_secret
     function be_client_status_update($client_id,$client_secret,$cl_status,$callback) {
        $connection = new connection();
        $statement = 'UPDATE preauth SET client_status=:cl_status  WHERE client_id=:cl_id AND client_secret=:cl_secret';
        $params = array(':cl_id' => $client_id,':cl_secret'=>$client_secret,':cl_status'=>$cl_status);
        $connection -> connect($statement,$params,$callback);
     }
     function be_client_trials_update($client_id,$client_secret,$trials,$callback) {
        $connection = new connection();
        $statement = 'UPDATE preauth SET trials=:trials WHERE client_id=:cl_id AND client_secret=:cl_secret';
        $params = array(':cl_id' => $client_id,':cl_secret'=>$client_secret,':trials'=>$trials);
        $connection -> connect($statement,$params,$callback);
     }
     //generate token  

     function generate_preauth($data,$callback){
        $client_id = $data[0]->client_id;
        $client_name = $data[0]->client_name;
        $trials =$data[0]->trials;
        $client_status=$data[0]->client_status;
        $exp = time()+10;
        $timestamp = time();
        $header = [
         'typ' => "preauth",
         "alg" => "HS256",
         'status' => $client_status,
         'exp' => $exp,
         'timestamp' => $timestamp,
        ];

        $payload = [
            'client-id' => $client_id,
            'client-name' => $client_name,
            'role' => 'admin'
        ];
        $base64header =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($header)));
        $base64payload =  str_replace(['+', '/', '='], ['', '', ''],base64_encode(json_encode($payload)));
        $signature = hash_hmac('sha256', $base64header . "." . $base64payload, '**^$%#$@#FEWFewhgr3274y32gi2', true);
        $base64signature = str_replace(['+', '/', '='], ['', '', ''], base64_encode($signature));
        $preauth_token =  "$base64header.$base64payload.$base64signature";
        if(is_callable($callback)) {                                          
            call_user_func($callback,$preauth_token);
            }else {
               http_response_code(404);//not found
               echo json_encode(array("invalid callback" => "callback func failure" ));
            }
            
    }
}


