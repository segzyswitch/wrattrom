<?php
require_once './classes/Auth.php';
require_once './classes/Otp.php';

$token = Auth::getBearerToken();
$payload = Auth::validateToken($token);
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true);
// Check if the token is valid
if (!$payload) {
  ApiResponse('error', 401, 'Unauthorized');
}
// Get the user ID from the token payload
$userId = $payload['uid'];
$OTP = new OTP();
$email = $_GET['email'] ?? $currentUser['email'] ?? null;

if ( !$email ) {
  return ApiResponse('error', 400, 'Email is required');
}

// delete expired
$OTP->deleteExpired();

// Create new
$otpCode = rand(10000, 99999); // 5-digit OTP
$expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

// MAIL settings
ini_set('SMTP', 'wrattrom.com');
ini_set('smtp_port', 465);

$message = "<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Your One time Password - Wrattrom Wallet</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    body {
      margin: 0;
      background-color: #222223;
      font-family: 'Poppins', sans-serif!important;
    }
    * {box-sizing:border-box;}
    .container {
      max-width: 500px;
      margin: auto;
      background-color: #222223;
      border-radius: 10px;
    }
    .mail-body {
      padding: 20px;
      background-color: #393737;
      color: #EFEFEF;
    }
    .confirm-button {
      display: inline-block;
      padding: 15px 30px;
      background-color: #25c866;
      color: #FFF;
      text-decoration: none;
    }
    .mail-footer {
      padding: 5px 15px;
      color: #ACACAC;
      font-size: .8em;
    }
    .mail-footer a {
      display: inline-block;
      padding-right: 10px;
      color: #ACACAC;
    }
  </style>
</head>
<body>
<div class='container'>
  <div class='mail-body'>
    <p><img src='https://wrattrom.com/logo.png' height='35' style='height:35px;' /></p>
    <p style='color:#efefef;'>Your one time password is</p>
    <h1>".$otpCode."</h1>
  </div>
  <div class='mail-footer'>
    <p>For security reasons, this link will expire in 24 hours. If you did notrequest for this, please ignore this email.</p>
    <p>If you have any questions or need help, feel free to contact our support team at support@wrattrom.com</p>
    <p>© 2024 Wrattrom Wallet!</p>
  </div>
</div>
</body>
</html>
";
$subject = "Your One time Password - Wrattrom Wallet";
$headers = "From: Wrattrom <noreply@wrattrom.com>\r\n";
$headers .= "Reply-To: Wrattrom <support@wrattrom.com>\r\n";
$headers .= "Return-Path: noreply@wrattrom.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if ( mail($email, $subject, $message, $headers) ) {
  if ($sendMail = $OTP->create($email, $otpCode, $expiry)) {
    ApiResponse('success', 200, 'Withdrawal requires verification. OTP sent to your email, keep it confidential', $sendMail);
  }else {
    ApiResponse('success', 400, 'OTP failed', $sendMail);
  }
}

// try {
//   $sendMail = mail($email, $subject, $message, $headers);
//   $OTP->create($email, $otpCode, $expiry);
//   // send email
//   ApiResponse('success', 200, 'OTP sent to email', $sendMail);
// } catch (PDOException $e) {
//   ApiResponse('error', 400, 'Operation failed, try again', $e);
// }
