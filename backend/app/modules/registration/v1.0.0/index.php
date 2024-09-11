<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header("Content-Type: application/json");
include_once "./fe/fe.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $ip = $_SERVER['SERVER_ADDR'];
    $domain =$_SERVER['SERVER_NAME'];
    //data 
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
     process_request($data,function($payload,$response_code){     
        if($response_code == 1){
            user_registration($payload,function($response){
                echo $response;
             });
        }else{
            //mature response
            http_response_code(400);
            $Responsetime = time();
            $api_endpoint_status_code = '467.890.311';
            $payload = [
                'message' => 'badRQ311',
                'Responsetimestamp' => $Responsetime
              ];
              $api_response = json_encode(array("response" =>array("responseCode" =>$api_endpoint_status_code ,"payload"=>$payload)));
              echo $api_response;
        }
     });
}else {
    http_response_code(400);
    $response_code = 4;
    $payload = [
     'message' => "Bad request,request type not allowed",
     'timestamp' => time()
    ];
    echo json_encode(array("response"=>array('responseCode'=>$response_code ,'payload'=>$payload)));
}

function process_request($data,$callback) {
if ($data !== null) {
    if (isset($data['fields'])) {
        $payload = $data['fields'];
        //verify fields contains all data required
        $result = validateRegistrationData($data);
         if (!$result['success']) {
            http_response_code(400);
            $Responsetime = time();
            $api_endpoint_status_code = '467.890.300';
            $payload = [
            'message' => 'badRQ300',
            'Responsetimestamp' => $Responsetime,
            'status'=>$result['message']
            ];
          $api_response = json_encode(array("response" =>array("responseCode" =>$api_endpoint_status_code ,"payload"=>$payload)));
          echo $api_response;
            exit();
         } else {
       //mature response/valid
         $response_code = 1;
         if(is_callable($callback)) {
         call_user_func($callback,$payload,$response_code);
         }else {
            http_response_code(404);//not found
            echo json_encode(array("invalid callback" => "404/callback not found" ));
         }
        }
    }
}
}
//validation function
function validateRegistrationData($data) {
    $requiredFields = ['account_imsi', 'email', 'first_name', 'last_name','dob','password'];
    // Extract fields from the input data
    $payload = $data['fields'] ?? [];
    foreach ($requiredFields as $field) {
        if (!array_key_exists($field, $payload) || empty($payload[$field])) {
            return [
                'success' => false,
                'message' => "systaxerr1.1: $field"
            ];
        }
    }
    //validate mail
    if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'mailerr1.1'
        ];
    }
    //pass
    return [
        'success' => true,
        'message' => 'valid'
    ];
}
?>

