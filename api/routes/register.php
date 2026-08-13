<?php
require_once './classes/User.php';

$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$country = trim($data['country'] ?? '');
$phone = trim($data['phone'] ?? '');
$password = trim($data['password'] ?? '');
$c_password = trim($data['c_password'] ?? '');

// Check if User exists
$user = new User();
if ($user->findByEmail($email)) {
  ApiResponse('error', 409, 'Email already exists');
}
// Validate inputs
if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
  ApiResponse('error', 400, 'Please enter a valid email address');
}
// Validate inputs
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$password || !$country || !$phone || !$c_password) {
  ApiResponse('error', 400, 'All fields are required and email must be valid');
}
// Check password length
if (strlen($password) < 6) {
  ApiResponse('error', 400, 'Password must be at least 6 characters');
}
// Check if passwords match
if ($password !== $c_password) {
  ApiResponse('error', 400, 'Passwords do not match');
}

// MAIL settings
ini_set('SMTP', 'wrattrom.com');
ini_set('smtp_port', 465);

try {
$createdUser = $user->create($data);
$message = "<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>Activate Your Account - Wrattrom Wallet</title>
  <style>
    body {
      margin: 0;
      background-color: #222223;
      font-family: sans-serif;
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
    <p style='text-align:center;'><img src='https://wrattrom.com/logo.png' height='35' style='height:35px;' /></p>
    <h3>Hello, ".$name."</h3>
    <p>Welcome to Wrattrom Wallet wallet! We're excited to have you on board.</p>
    <p style='color:#fff;'>To activate your account, please confirm your email address by clicking the link below:</p>
    <p><a href='https://wrattrom.com/activate-account?uuid=".$createdUser['wallet_id']."' class='confirm-button'>Confirm Account</a></p>
    <p style='color:#fff;'>If the button above doesn’t work, please copy and paste the following link into your browser:</p>
    <p><a href='https://wrattrom.com/activate-account?uuid=".$createdUser['wallet_id']."'>https://wrattrom.com/activate-account?uuid=".$createdUser['wallet_id']."</a></p>
    <p style='color:#fff;'>Thank you for choosing Wrattrom Wallet wallet!</p>
  </div>
  <div class='mail-footer'>
    <p>For security reasons, this link will expire in 24 hours. If you did not sign up for an account with us, please ignore this email.</p>
    <p>If you have any questions or need help, feel free to contact our support team at support@wrattrom.com</p>
    <hr style='color:#ccc;' />
    <p style='display:flex;'>
      <a href='https://wrattrom.com'>Home</a>
      <a href='https://wrattrom.com/plans'>About</a>
      <a href='https://wrattrom.com/terms-conditions'>Terms & Conditions</a>
      <a href='https://wrattrom.com/contact'>Contact</a>
    </p>
    <p>© 2024 Wrattrom Wallet!</p>
  </div>
</div>
</body>
</html>
";
$subject = "Activate Your Account - Wrattrom Wallet";
$headers = "From: Wrattrom Wallet <info@wrattrom.com>\r\n";
$headers .= "Reply-To: Wrattrom Wallet <support@wrattrom.com>\r\n";
$headers .= "Return-Path: support@wrattrom.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if ( mail($email, $subject, $message, $headers) ) {
  // Send data
  ApiResponse('success', 200, 'User registered successfully, check your mail to confirm your account!', $createdUser);
}
} catch (PDOException $e) {
ApiResponse('success', 401, 'Registration failed, check your details and try again later');
}
  
