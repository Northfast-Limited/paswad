<?php
// //include mailer
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require '/home/muslihabdi/PHPMailer/src/Exception.php';
// require '/home/muslihabdi/PHPMailer/src/PHPMailer.php';
// require '/home/muslihabdi/PHPMailer/src/SMTP.php';

// //two step code generation
// class func_be_two_step_authenication {
// //payload includes email// public identifier // a
// function func_be_two_step_authenication($payload){
//   $class_be_db_two_step_code_add_record = new class_be_db_two_step_code_add_record();
// $email = $payload['email'];
// $timestamp = time();
// $expiry = time()+60;
// //base

// $base64_encoded_email = base64_encode($email);
// $base64_encoded_timestamp = base64_encode($timestamp);
// $base64_encoded_expiry = base64_encode($expiry);
// $random_number = mt_rand(100000000000000, 999999999999999);
// $base64_encoded_random = base64_encode($timestamp+$random_number+$expiry);
// //cleaned
// $cleaned_string_email = preg_replace('/[^a-zA-Z0-9]/', '', str_replace(['=', '@'], '', $base64_encoded_email));
// $cleaned_string_random = preg_replace('/[^a-zA-Z0-9]/', '',str_replace(['=', '@'], '', $base64_encoded_random));
// $cleaned_string_timestamp = base64_encode(preg_replace('/[^a-zA-Z0-9]/', '',str_replace(['=', '@'], '',$base64_encoded_timestamp)));
// $cleaned_string_expiry = base64_encode(preg_replace('/[^a-zA-Z0-9]/', '',str_replace(['=', '@'], '',$base64_encoded_expiry)));
// //dot seperator 
// $unique_token = "$cleaned_string_email.$cleaned_string_random.$cleaned_string_expiry.$cleaned_string_timestamp";
// //put it in db 
// //record email and token 
// $statement = 'UPDATE  immig SET email = :email, authtoken= :authtoken';
// $params  = array('email' => $email,'authtoken' => $unique_token);
// //get callback from the connection
// $class_be_db_two_step_code_add_record->func_be_db_two_step_code_add_record($statement,$params);
//     }
// }

// //database
// //worker class -pseudo name
// //data insertion
// class class_be_db_config {
//     public $host = 'localhost';
//     public $database = 'api';
//     public $username = 'muslih';
//     public $password = '0';
// }
//     class class_be_db_two_step_code_add_record{
//       private $class_callback;
//       private $password;
//         function func_be_db_two_step_code_add_record($statement,$params) {
//             $config = new class_be_db_config;
//             $dsn = 'pgsql:host ='. $config->host .';dbname='.$config->database;
//             $sql = new PDO($dsn , $config->username,$config->password);
//             $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//                 $realStatement = $statement;
//                 $stmnt = $sql ->prepare($statement);
//                 $stmnt->execute($params);
//                 $response = $stmnt->fetchAll(PDO::FETCH_OBJ);
//                 $sql ->prepare($realStatement);
//                 $count = $stmnt -> rowCount();
//                 if($count === 1) {
//                   $this->func_db_be_mailer($params);
//                 }else {
//                   //two step code generation failure error->db side 
//                   $api_endpoint_status_code = 0;//failure
//                   $payload = [
//                     'message' => 'second verification stage  failed,please try again later',
//                     'timestamp' => time(),
//                     ];
//                   $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
//                     http_response_code(200);//failure but endpoint functions
//                  echo $db_response;
//                 }      
//         }
//         //only for 2fa mailing
//         //responds with dynamic 2fa code input content
//         function func_db_be_mailer($payload) {
//              $email = $payload['email'];
//              $token = $payload['authtoken'];
//              $link  = "local.muslih.tech/api/v1.0/auth/?token=$token";

// // Create a new PHPMailer instance
// $mail = new PHPMailer(true);

// try {
//     // Server settings
//     $mail->isSMTP();                                            // Send using SMTP
//     $mail->Host       = 'smtp.hostinger.com';                     // SMTP server
//     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//     $mail->Username   = 'no-reply@northfast.co.ke';                    // SMTP username
//     $mail->Password   = 'wp_vidco@BK221409@Muslih@Abdiker@Mohamed_^)$^)$';                         // SMTP password
//     $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//     $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//     // Recipients
//     $mail->setFrom('no-reply@northfast.co.ke', 'northfast');
//     $mail->addAddress($email, 'unspecified');     // Add a recipient
//     $mail->addReplyTo('replyto@northfast.co.ke', 'northfast limited');

//     // Content
//     $mail->isHTML(true);                                        // Set email format to HTML
//     $mail->Subject = 'two factor authenication';
//     $mail->Body    = "This is your two factor authenication code 2634,
//     do not share <a href='$link'>local.muslih.tech/api/v1.0/auth/</a><br>
//      <button type='button' style='color:white;background-color:green;padding:0.2cm'>Approve</button><span></span><button type='button' style='color:white;background-color:red;padding:0.2cm'>Reject</button>
//     ";
//     $mail->AltBody = 'Dont share this link';

//     $mail->send();
//     //final db api response success
//     $email_split = str_split($email); 
//     $api_endpoint_status_code = 1;//failure
//     $dynamic = "<h2>This login request has to be verified, we sent an email to <spanstyle='color:green'>$email_split[0]************* </span> </h2>";
//     $payload = [
//       'message' => "Message has been sent to $email_split[0]*************,please check your email , this login  request has to be verfied first",
//       'content' => $dynamic,
//       'timestamp' => time(),
//       ];
//     $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
//       http_response_code(200);//failure but endpoint functions
//    echo $db_response;
// } catch (Exception $e) {
//   //error response 
//   $api_endpoint_status_code = 0;//failure
//   $payload = [
//     'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
//     'timestamp' => time(),
//     ];
//   $db_response = json_encode(array('response'=>array('responseCode'=>$api_endpoint_status_code,'payload'=>$payload)));
//     http_response_code(200);//failure but endpoint functions
//  echo $db_response;

// }
//         }
//     }
 