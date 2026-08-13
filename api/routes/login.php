<?php
require_once './classes/User.php';
require_once './classes/Auth.php';
require_once './services/LocationService.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['email']) || !isset($data['password'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Email and password are required']);
  exit;
}
$deviceInfo = $data['device_info'] ?? [];

$User = new User();
$Auth = new Auth();
$found = $User->findByEmail($data['email']);

// Enrich if frontend didn't send valid location
if (empty($deviceInfo['latitude']) || empty($deviceInfo['longitude'])) {
  $locationFallback = LocationService::enrichFromBackend($deviceInfo['ip'] ?? $_SERVER['REMOTE_ADDR']);
  $deviceInfo = array_merge($deviceInfo, $locationFallback);
  $deviceInfo['geo_accuracy'] = 'ip';

  // return print_r($deviceInfo);
}

if ($found && password_verify($data['password'], $found['password'])) {
//   Check verified
  if ( $found['status'] == 0 ) {
    ApiResponse('error', 401, 'User not verified, please check email or contact support', null);
  }
  
  $token = Auth::generateToken($found['id']);
  // print_r($deviceInfo);
  // return false;
  // Log user session
  $Auth->logLogin($found['id'], $deviceInfo);

  // save to notifications
  $locationText = trim("{$deviceInfo['city']}, {$deviceInfo['country']}", ', ');
  $platform = $deviceInfo['platform'] ?? 'Unknown platform';
  $feed = "New login from $locationText on $platform";
  $User->popNotification($found['id'], 'login', $feed);
  
  // Add wallet balance to user details
  $found['wallet_bal'] = $User->walletBalance($found['id']);
  // API response
  echo json_encode([
    "status" => 'success',
    "message" => 'Login successful',
    "token" => $token,
    "data" => $found
  ]);
} else {
  ApiResponse('error', 401, 'Invalid credentials', null);
}