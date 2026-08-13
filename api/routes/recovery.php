<?php
require_once './classes/User.php';
require_once './classes/WalletEncryptor.php';
$User = new User();
$email = $_GET['email'] ?? '';

if (empty($email)) {
    ApiResponse('error', 404, 'Email is requried');
}

$foundUser = $User->findByEmail($email);

if (!$foundUser) {
    ApiResponse('error', 404, 'User not found with email: ' . htmlspecialchars($email));
}

$walletId = $foundUser['wallet_id'];
$token = WalletEncryptor::encrypt($walletId);

$link = "https://wrattrom.com/app/reset-password/" . urlencode($walletId);

// MAIL settings
ini_set('SMTP', 'wrattrom.com');
ini_set('smtp_port', 465);

$message = "<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Wrattrom Wallet - Reset Your Password</title>
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
      color: #fff;
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
    <p><img src='https://wrattrom.com/logo.png' height='50' /></p>
    <p style='color:#fff;'>To reset your password, please click the link below:</p>
    <p><a href='".$link."' class='confirm-button'>Reset Password</a></p>
    <p style='color:#fff;'>If the button above doesn't work, please copy and paste the following link into your browser:</p>
    <p><a href='".$link."'>".$link."</a></p>
    <p style='color:#fff;'>Thank you for choosing Wrattrom wallet!</p>
  </div>
  <div class='mail-footer'>
    <p>For security reasons, this link will expire in 5 minutes. If you did notrequest for this, please ignore this email.</p>
    <p>© 2024 Wrattrom!</p>
  </div>
</div>
</body>
</html>
";
$subject = "Wrattrom Wallet - Reset Your Password";
$headers = "From: Wrattrom <info@wrattrom.com>\r\n";
$headers .= "Reply-To: Wrattrom <support@wrattrom.com>\r\n";
$headers .= "Return-Path: info@wrattrom.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if ( mail($email, $subject, $message, $headers) ) {
  ApiResponse(
    'success',
    200,
    "We've sent a link to reset your mail which expires in 5 minutes. Please check your inbox (or spam folder) for further instructions.",
    ['reset_link' => $link]
  );    
}
