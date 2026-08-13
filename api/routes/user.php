<?php
require_once './classes/Auth.php';
require_once './classes/User.php';

$token = Auth::getBearerToken();

if (empty($token)) ApiResponse('error', 404, 'User not found');

$payload = Auth::validateToken($token);

if (!$payload) {
  ApiResponse('error', 401, 'Unauthorized');
}

$userId = $payload['uid'];
$user = new User();
$currentUser = $user->findById($userId);

if (!$currentUser) {
  ApiResponse('error', 404, 'User not found');
}

// Set wallet balance
$currentUser['wallet_bal'] = $user->walletBalance($userId);
// Return user data with wallet balance
ApiResponse('success', 200, 'Data fetched successfully', $currentUser);
