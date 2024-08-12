<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//verify if token cookie exists, verify signature and redirect to dashboard
function check_exp($payload) {
    $currentTime = time();
    if ($payload['exp'] < $currentTime) {
        // If the token has expired, delete the cookie and redirect to the login page
        setcookie('token', '', time() - 3600, '/'); // Expire the cookie
        unset($_COOKIE['token']);
        header("Location: http://172.31.105.163/auth/onepass/v1.0/modules/signin/v1.0.0/webstacks/onepass/"); 
        exit;
    }else{
    header("Location: http://172.31.105.163/auth/onepass/v1.0/modules/dashboard/");
    exit();
    }
}
class class_dash_envylod{
    function loadEnv($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception("Environment file not found: $filePath");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue; // Skip empty lines and comments
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue; // Skip lines that don't contain exactly one '='
            }

            $key = trim($parts[0]);
            $value = trim($parts[1], "\"'"); // Remove surrounding quotes if any

            if ($key === '' || $value === '') {
                continue; // Skip if either key or value is empty
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
    // Split the JWT into its components
    list($header, $payload, $signature) = explode('.', $jwt);

    // Create a hash of the header and payload using the secret key
    $data = $header . '.' . $payload;
    $expectedSignature = base64UrlEncode(hash_hmac('sha256', $data, $secretKey, true));

    // Compare the expected signature with the actual signature
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
        //load env variable
        $class_dash_envylod = new class_dash_envylod();
        $filePath = '/var/www/html/auth/onepass/v1.0/.env';
        $class_dash_envylod->loadEnv($filePath);
        $secretKey = trim(getenv('JWT_SECRET'));
        if ($secretKey === false) {
            throw new Exception("JWT_SECRET not set in environment variables");
        }
        if (verifyJWTSignature($jwt, $secretKey)) {
            $decoded = decodeJWT($jwt);
            $header = $decoded['header'];
            $payload = $decoded['payload'];
            check_exp($decoded['header']);
            exit;
        } else {
         
        }
    } else {
    }
} catch (Exception $e) {
    error_log('Error decoding JWT: ' . $e->getMessage());
    http_response_code(400);
    echo 'An error occurred while verifying the JWT.';
}
?>
<!DOCTYPE html>
<html lang="en">
  <!--northfast webstacks-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="onepass.css">
    <link rel="stylesheet" href="notfiy.css">
    <link rel="stylesheet" href="bottomsheet/index.css">
    <link rel="stylesheet" href="wsStack/stack.css">
    
    <title>onepass</title>
</head>
<body>
  <!--uses northfast webstacks-->
  <!--notification sound--->
  <!--in the future all info will be dynamic -->
<div class="main-window" id="main">
  <div class="wsBody" id="wsBody">
     <div class="wsBodyHeader" id='wsBodyHeader'></div>       
      <div class="wsContent" id="wsContent">
  
      </div>  
  <!--display all data-->

<!---login caller-->
  </div>
</div>  
<!--end of main--->    
<!--bottom sheet -->
<div id="bottomSheet" class="bottom-sheet">
        <div class="bar"></div>
        <div class="content" id="content">
        </div>
    </div>
<script src="resize.js" type="module"></script>
<script src="./webstacks.js" type="module"></script>
<script src="./bottomsheet/index.js" type="module"></script>
<!-- <script src="./../calls/login.js" type="module"></script> -->
<!---->
<!--script 

look for a way to make it better and secure 
9-->
<script>
  function pwdCheckApi() {
    const remover = document.getElementById("stackNotification");

const wsBodyStackInnerContent = document.getElementById("wsBodyStackInnerContent");

// if (wsBodyStackInnerContent.contains(remover)) {
//   // If remover exists and is a child of wsStack
//   wsBodyStackInnerContent.removeChild(remover);
// }
//notification label 
     const notificationLabel = document.createElement('p')
     notificationLabel.classList = 'notificationLabel';
     notificationLabel.id = 'stackNotification';
   
  const mytitle = document.getElementById("mytitle");
  // wsBodyStackInnerContent.appendChild(notificationLabel);
const pwdCheckApiUrl = 'http://172.31.105.163/auth/onepass/v1.0/modules/signin/v1.0.0/confirmpassword/index.php';
const accountnumber = document.getElementById('email');
const pwdField = document.getElementById('password');
    const data = {
      //js form validation 
        email: String(accountnumber.value),
        password: String(pwdField.value),
        timestamp: String(pwdField.dataset.timestamp)
      };
    const requestOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    };
  //in the future to become general fetch for the whole system
        fetch(pwdCheckApiUrl, requestOptions)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          //response code is important for js ui side
          if (data && data.response && data.response.payload) {
    if (data.response.responseCode === 11) {
        console.log('Response code is 11');
        notificationLabel.style.color = 'green';
        notificationLabel.innerHTML = data.response.payload.message;
        const redi = data.response.payload.redirect;
        console.log('Redirecting to:', redi);

        // Check if the redi variable is a valid URL
        try {
            new URL(redi); // This will throw an error if redi is not a valid URL
            window.location.replace(redi);
        } catch (e) {
            console.error('Invalid URL for redirection:', redi);
        }
        
        // stack element
        // render only
        // contact API
    } else {
        notificationLabel.style.color = 'red';
        notificationLabel.innerHTML = data.response.payload.message;
    }
} else {
    console.error('Invalid response structure', data);
}

        })
        .catch(error => {
  
          notificationLabel.style.color = 'red';
          notificationLabel.innerHTML = error;
      
      ('Error:', error);
        });
}
</script>
</body>
</html>