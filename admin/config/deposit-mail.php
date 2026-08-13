<?php
// Boundaries
// $separator = md5(time());
// $eol = PHP_EOL;

// Logo path
// $logoPath = "https://wrattrom.com/logo.png"; // your website logo in same directory
// $logoData = file_get_contents($logoPath);
// $logoBase64 = chunk_split(base64_encode($logoData));
// $cid = "logo123"; // arbitrary ID


$link = "https://wrattrom.com/app/history/".$trx_hash_generate;

// MAIL settings
ini_set('SMTP', 'wrattrom.com');
ini_set('smtp_port', 465);

$message = "<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <title>You recieved a payment - CratoByte</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    * {
        box-sizing:border-box;
      font-family: 'Poppins', sans-serif!important;
    }
    body {
      margin: 0;
      background-color: #222223;
      font-family: 'Poppins', sans-serif!important;
    }
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
    <p style='text-align:center;'><img src='https://wrattrom.com/logo.png' alt='CratoByte' height='35' style='height:35px;'></p>
    <h2 style='color:#fff;text-align:center;'>You recieved $asset_unit ".$assetData['unit']."</h2>
    <p style='display:flex;'>Amount: <span style='margin-left:auto;opacity:.7;'>$".number_format($amount, 2)."</span></p>
    <p style='display:flex;'>From: <span style='margin-left:auto;opacity:.7;'>".substr($snd_from, 0,10)."...</span></p>
    <p style='display:flex;'>To: <span style='margin-left:auto;opacity:.7;'>".$assetData['name']." wallet</span></p>
    <p style='display:flex;'>Invoice: <span style='margin-left:auto;opacity:.7;'>".$trx_hash_generate."</span></p>
    <p style='display:flex;'>Confirmation: <span style='margin-left:auto;opacity:.7;'>10</span></p>
    <p style='display:flex;'>Status: <span style='margin-left:auto;opacity:.7;'>completed</span></p>
    <p style='display:flex;'>Date: <span style='margin-left:auto;opacity:.7;'>".date('d/m/y')."</span></p>
    <p style='color:#eee;margin:0;margin-top:25px;'>Balance will be settled once transaction is confirmed, view transaction at <a href='".$link."'>".$link."</a></p>
    <p style='color:#eee;margin:0;'>Thank you for choosing CratoByte wallet!</p>
  </div>
</div>
</body>
</html>
";
// subject
$subject = "You recieved a payment - CratoByte";
// Headers
$headers = "From: CratoByte <noreply@wrattrom.com>\r\n";
$headers .= "Reply-To: CratoByte <support@wrattrom.com>\r\n";
$headers .= "Return-Path: noreply@wrattrom.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$sendMail = mail($user_info['email'], $subject, $message, $headers);
