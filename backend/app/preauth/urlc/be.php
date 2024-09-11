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
 include_once  './config/config.php';   
    class class_be_urlc_connection {
        public $token;
        //general function
        //runs queries for all endpoints
        //in the future , we will have some 
        function connect($statement,$params,$callback) {

            $class_be_url_registration_status_check = new  class_be_url_registration_status_check;
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
                    http_response_code(200);//ok
                     
                    $status = "Valid url";
                    $db_response = json_encode($response);
                    //call token gen
                    $class_be_url_registration_status_check->generate_url_check_jwt($status,$db_response,function($url_token) {
                        $this->token = $url_token;
                    });

                    //end
                 if(is_callable($callback)) {
                 call_user_func($callback,$this->token);
                 }else {
                    http_response_code(404);//not found
                    echo json_encode(array("invalid callback" => "404/callback not found" ));
                 }
                }else {
                    http_response_code(404);//not found
                    echo json_encode(array("Error:" => "invalid url" ));
                }      
        }
    }
class class_be_url_registration_status_check {
//confirms provided  information and returns true or false(1 or 0)
            function func_be_url_registration_status_check($signature,$callback){
                $connection = new class_be_urlc_connection();
                $statement = 'SELECT * FROM  registeredUrls WHERE urlsignature = :urlsignature';
                $params  = array('urlsignature' => $signature);
                //get callback from the connection
                $connection -> connect($statement,$params,$callback);
            }
            function generate_url_check_jwt($status,$db_response,$callback){
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
                       http_response_code(404);//not found
                       echo json_encode(array("invalid callback" => "callback func failure" ));
                    }
                    
            }
}



//sample callback syntax
// function me($name,$callback) {
//     $results = $name+23732;
// if(is_callable($callback)) {
//     call_user_func($callback,$results);
// }else {
//     echo "errr";
// }

// }

// $name = 1;
// me($name,function($response){

// echo $response;
// });