<?php
require_once './classes/Auth.php';
require_once './classes/User.php';

$token = Auth::getBearerToken();
$payload = Auth::validateToken($token);
$host = 'http://localhost/coima/public/uploads';
// Check if the token is valid
if (!$payload) {
  ApiResponse('error', 401, 'Unauthorized');
}
// Get the user ID from the token payload
$userId = $payload['uid'];
// $trx_id = $_GET['id'] ?? null;
$User = new User();

// Fetch all history
$allHistory = $User->getUserNotifications($userId);

// foreach ($allHistory as &$history) {}
ApiResponse('success', 200, 'Notifications fetched successfully', $allHistory ?? []);
