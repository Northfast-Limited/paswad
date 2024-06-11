<?php
//screen the received data
header("Content-Type: application/json");
//should include and communicate with backend
include_once '././v1.0/checkClientDetails/backend.php';
class security {
    //acccount status
    //account start transaction limit - 1300 usd
    /*
    block
   -blocked(with block errors) - possibly due to providing invalid client details 3 trials
     - in most cases can reset from online link. 
   -suspended- due to failure to provide last (jwt preuth token/jwt auth token/start key/or 
     access from invalid domain/ip address - to contact admin or due to inactivity.
     allow
   - active  - proceed
   - limited

    */
  
    function check_client_status($data,$count,$params,$callback) {
$preDecode = json_decode($data);
        //check for null data 
        if ($data !== null && $params !==null && $count !==null && isset($preDecode[0]->client_id)) {
        // echo $data;
        // print_r($post_cl_secret);
        $cl_operations = new be_client_operations();
        $dataDecoded = json_decode($data);
        $trials = $dataDecoded[0]->trials;
        $cl_id = $dataDecoded[0]->client_id;
        $cl_secret = $dataDecoded[0]->client_secret;
        $post_cl_id =$params[':cl_id'];
        $post_cl_secret =$params['cl_secret'];
        $client_name = $dataDecoded[0]->client_name;
        $client_status =$dataDecoded[0]->client_status;
     
        //check if client id matches the submitted one and note
        //one of them should match or both if they are correct
        //first check both 
        if($cl_id == $post_cl_id && $cl_secret == $post_cl_secret && $trials<3) {
          //client creds correct 
          //remove previous trials if exists
          if($trials<3) {
            $newTrial = 0;
            $cl_operations->be_client_trials_update($cl_id,$cl_secret,$newTrial,$callback);
          }
        
         $cl_operations->generate_preauth($dataDecoded,$callback);

     
          die();

        }elseif($cl_id != $post_cl_id && $cl_secret == $post_cl_secret && $trials<3) { 
          //secret correct ,id incorrect
          //add up trials /only update trials
          if($trials<3) {
            $newTrial = $trials+1;
            $cl_operations->be_client_trials_update($cl_id,$cl_secret,$newTrial,$callback);
          }
          http_response_code(400);//Bad Request
          echo json_encode(array("message" => "invalid client"));
          die();
        }elseif($cl_id == $post_cl_id && $cl_secret != $post_cl_secret && $trials<3){
        //secret incorrect , id correct
        //add up trials /only update trials
        if($trials<3) {
            $newTrial = $trials+1;
            $cl_operations->be_client_trials_update($cl_id,$cl_secret,$newTrial,$callback);
          }
        http_response_code(400);//Bad Request
        echo json_encode(array("message" => "invalid client"));
        die();

        }else {
            // notify the client that the account is locked
            http_response_code(400);//Bad Request
            echo json_encode(array("message" => "Account Blocked , contact administrator: info@muslih.tech"));
        }
    }
    
}

public  $jwt_header = [
    'alg' => 'HS256',
    'typ' => 'preuth_jwt',
    'request-url' => 'sso.login.northfast.co.ke/jwt/kittyauth1.0.0/validate',
    'origin-url' => 'user-registered-domain',
    'ctype' => 'preuth',
    'client_name'=> "muslih"
 ];
 //from server 
 // include claims and expiry information about the token
 public  $jwt_payload = [
  'issuer' => 'northfast.co.ke',
  'exp',
  'claims' => 'user-limited',
  'account_status' =>'active',
  'id' => 'TY349890840300',
 ];
    //encode data
        //create signature 
        public function encode() {
     
            // reserved symbol *
            $base64UrlHeader = base64_encode(json_encode($this->jwt_header));
            $this->jwt_payload['exp'] = time() + 30;
            $base64UrlPayload = base64_encode(json_encode($this->jwt_payload));
            $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);
            $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
            $jwt_token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
            echo json_encode($jwt_token);
            }
}

