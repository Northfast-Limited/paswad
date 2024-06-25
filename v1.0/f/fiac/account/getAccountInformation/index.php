<?php
//totalFront
include_once '../../../../worker/ib/index.php'; 
// Step 1: Set headers to indicate JSON content
header("Content-Type: application/json");
// Step 2: Define your API endpoint
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    //decode received data
 // Retrieve the raw POST data
$jsonData = file_get_contents('php://input');
// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);
// Check if decoding was successful
if ($data !== null) {
   // Access the data and perform operations
   $endpoint = $data['AUTH'];
   $account_number = $data['account_number'];
   // Perform further processing or respond to the request
   //props and endpoint
$properties = ['firstName'=>$account_number];
$endpoint = 'getAccountInformation';
forwader($endpoint,$properties);
} else {
   // JSON decoding failed
   http_response_code(400); // Bad Request
   echo json_encode("Invalid JSON data");
}

} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid request"));
}
?>
