<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function check_exp($payload) {
    $currentTime = time();
    if ($payload['exp'] < $currentTime) {
        // If the token has expired, delete the cookie and redirect to the login page
        //no need for redirect
        setcookie('token', '', time() - 3600, '/'); // Expire the cookie
        unset($_COOKIE['token']);
        exit;
    }else{

    }
}
class class_dash_envylod {
    function loadEnv($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception("Environment file not found: $filePath");
        }
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue;
            }
            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }
            $key = trim($parts[0]);
            $value = trim($parts[1], "\"'");
            if ($key === '' || $value === '') {
                continue; 
            }
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

function base64UrlDecode($data) {
    $base64 = str_replace(['-', '_'], ['+', '/'], $data);
    $base64 = str_pad($base64, strlen($base64) % 4, '=', STR_PAD_RIGHT);
    return base64_decode($base64);
}

function base64UrlEncode($data) {
    $base64 = base64_encode($data);
    $base64 = str_replace(['+', '/'], ['-', '_'], $base64);
    return rtrim($base64, '=');
}

function verifyJWTSignature($jwt, $secretKey) {
    list($header, $payload, $signature) = explode('.', $jwt);
    $base64header = base64UrlEncode(json_encode(base64UrlDecode($header)));
    $base64payload = base64UrlEncode(json_encode(base64UrlDecode($payload)));
    $data = $header . '.' . $payload;
    $expectedSignature = base64UrlEncode(hash_hmac('sha256', $data, $secretKey, true));
    return hash_equals($expectedSignature, $signature);
}

function decodeJWT($jwt) {
    list($header, $payload) = explode('.', $jwt);
    $header = base64UrlDecode($header);
    $payload = base64UrlDecode($payload);
    return [
        'header' => json_decode($header, true),
        'payload' => json_decode($payload, true)
    ];
}

//jwt verification
try {
    if (isset($_COOKIE['token'])) {
        $jwt = $_COOKIE['token'];
        $class_dash_envylod = new class_dash_envylod();
        $filePath = '/var/www/html/auth/onepass/v1.0/.env';

        try {
            $class_dash_envylod->loadEnv($filePath);
            $secretKey = trim(getenv('JWT_SECRET'));
            if ($secretKey === false) {
                throw new Exception("JWT_SECRET not set in environment variables");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }

        if (verifyJWTSignature($jwt, $secretKey)) {
            $decoded = decodeJWT($jwt);
            $header = $decoded['header'];
            $payload = $decoded['payload'];
            check_exp($header);
        } else {
            header('Location: http://172.31.105.163/auth/onepass/v1.0/modules/signin/v1.0.0/webstacks/onepass/'); // Redirect to login page
            exit();
        }
    } else {
        header('Location: http://172.31.105.163/auth/onepass/v1.0/modules/signin/v1.0.0/webstacks/onepass/'); // Redirect to login page
        exit();
    }
} catch (Exception $e) {
    error_log('Error decoding JWT: ' . $e->getMessage());
    http_response_code(400);
    echo 'An error occurred while verifying the JWT.';
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
    <h1 style="color:white">paswad</h1>
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

<!-- <script type="module" src="./profileman/index.js"></script> -->
<!-- <script src="webStacks.js" type="module"></script> -->
<!-- <script src="././sections/accounts/api.js" type="module"></script> -->
<!---->
</body>
</html>