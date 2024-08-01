<?php
//use authenication directory to do internal user and account authenication
// include_once  'config.php';  
// //no update  
// //env loads
// function loadEnv($filePath) {
//     if (!file_exists($filePath)) {
//         throw new Exception("Environment file not found: $filePath");
//     }

//     $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//     foreach ($lines as $line) {
//         if (strpos($line, '#') === 0) {
//             continue; // Skip comments
//         }
//         list($key, $value) = explode('=', $line, 2) + [NULL, NULL];
//         if ($key && $value) {
//             putenv("$key=$value");
//             $_ENV[$key] = $value;
//             $_SERVER[$key] = $value; // For compatibility with other systems
//         }
//     }
// }

// // Load the .env file
// loadEnv('/var/www/html/auth/onepass/v1.0/.env');
// $jwtSecret = getenv('JWT_SECRET');
// echo $jwtSecret;
function base64UrlDecode($data) {
    // Replace URL-safe Base64 characters with standard Base64 characters
    $base64 = str_replace(['-', '_'], ['+', '/'], $data);
    
    // Add padding if necessary
    $base64 = str_pad($base64, strlen($base64) % 4, '=', STR_PAD_RIGHT);
    
    // Decode the Base64 string
    return base64_decode($base64);
}

function decodeJWT($jwt) {
    // Split the JWT into its components
    list($header, $payload, $signature) = explode('.', $jwt);
    
    // Decode the Base64Url encoded parts
    $header = base64UrlDecode($header);
    $payload = base64UrlDecode($payload);
    // Decode JSON into PHP arrays/objects
    $headerData = json_decode($header, true);
    $payloadData = json_decode($payload, true);
    return [
        'header' => $headerData,
        'payload' => $payloadData,
        'signature' => $signature
    ];
}

// Example usage
try {
    // Retrieve the JWT from the cookie
    if (isset($_COOKIE['session_token'])) {
        $jwt = $_COOKIE['session_token'];
        // Decode the JWT
        $decoded = decodeJWT($jwt);

        // Access the decoded data
        $header = $decoded['header'];
        $payload = $decoded['payload'];
        // Example: Access user ID and username from the payload
        $userId = $payload['data']['userId'] ?? 'Unknown';
        $userName = $payload['data']['userName'] ?? 'Unknown';
    } else {
    }
} catch (Exception $e) {
    // Handle errors
    error_log('Error decoding JWT: ' . $e->getMessage());
    // Respond with an appropriate error message to the client
    http_response_code(400);
    echo 'An error occurred while decoding the JWT cookie.';
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="core.css">
    <link rel="stylesheet" href="bottomsheet-modal/styles.css">
    <link rel="stylesheet" href="profileBox/profileBox.css">
    <title>dashboard</title>
    
</head>
<body>
<div class="main-window" id="main">
    
<div class="wsBody" id="wsBody">
<!-- Rounded switch -->

<div class="logoholder">
    <div class="lg1"></div>
    <div class="lg2"></div>
    <div class="lg3"></div>
</div>
    <h1 style="color:white">northfast onepass</h1>
    <div class="wsHeader" id='wsHeader'>
            <div class="accountsettings" id="accountsettings"> 
                
             <div class="profileimageHolder" id="profileimageHolder"><img title="profile" src="./res/user.png" alt="profile" srcset=""></div>
             <div class="accountnameHolder">   
                    <!--consent screen-->
<div class="consentScreen-default" id="consentScreen">
    <div class="consentContent" id="consentContent">
    <p>You are about to delete a connection</p>
    </div>
   <div class="consentControls" id="consentControls">
    <button type="button" class="consentAccept" id="consentAccept">Accept</button>
    <button type="button" class="consentReject" id="consentReject">Reject</button>
</div>
</div>
<!--end of consent screen-->
                <div class="wsContent">
              <h3 class="titleS">Sessions</h3>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo">
                    <h5>gari.co.ke</h5>
                </div>
                <div class="controls" id="controls">
                    <button type="button"  class="delete"  id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo">
                    <h5>premier</h5>
                </div>
                <div class="controls" id="controls">
                    <button type="button" class="delete"  id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">remove access</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
              <div class="appholder" id="appholder">
                <div class="appnameorlogo" id="appnameorlogo"><h5>northfast drive</h5></div>
                <div class="controls" id="controls">
                    <button type="button" class="delete" id="delete">Delete</button>
                </div>
              </div>
           </div>
        </div>
            </div> 
    </div>
    
 
    <div class="wsFooter" id="wsFooter"></div>
    </div>       

</div>     
<!--end of main window-->          
</div>
    <!--bottom sheet -->
    <div id="bottomSheet" class="bottom-sheet">
        <div class="bar"></div>
        <div class="content" id="content"></div>
    </div>
<!--end of bottomsheet-->  

<script type="module" src="./profileman/index.js"></script>
<script src="webStacks.js" type="module"></script>
<!-- <script src="././sections/accounts/api.js" type="module"></script> -->
<!---->
</body>
</html>