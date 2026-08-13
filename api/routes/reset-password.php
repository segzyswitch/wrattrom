<?php

require_once './classes/WalletEncryptor.php';

$pwd = $_POST['pwd'] ?? '';
$retype_pwd = $_POST['retype_pwd'] ?? '';
$token = $_POST['token'] ?? '';

if (empty($pwd) || empty($token) || empty($retype_pwd)) {
	ApiResponse('error', 404, 'All fields are required');
}
if ( $pwd !== $retype_pwd ) {
	ApiResponse('error', 404, 'Passwords do not match');
}

$walletId = WalletEncryptor::decrypt($token);

if (!$token) {
	ApiResponse('error', 404, '❌ Invalid or expired reset link.');
}

// change password
$User = new User();
$hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

try {
	$changePassword = $User->changePassword($token, $hashedPassword);
} catch (PDOException $th) {
	return ApiResponse('error', 500, $th->getMessage());
}

ApiResponse('success', 200, "✅ Password has been reset successfully. You can now log in with your new password.");