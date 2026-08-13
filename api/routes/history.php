<?php
require_once './classes/Auth.php';
require_once './classes/History.php';
require_once './classes/Assets.php';
require_once './classes/Otp.php';
require_once './classes/UploadController.php';
require_once './classes/WalletValidator.php';

$history = new History();
$Assets = new Assets();
$OTP = new OTP();
$user = new User();
$WalletValidator = new WalletValidator();

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
$trx_id = $_GET['id'] ?? null;
$trx_hash = $_GET['hash'] ?? null;
$UploadController = new UploadController();
$currentUser = $user->findById($userId);

function generateUniqueId($length = 10) {
  // Define the characters to be used in the ID
  $characters = time().'ABCDEFGHJKLMNPQRSTUVWXYZ';
  // Shuffle the characters
  $shuffledCharacters = str_shuffle($characters);
  // Return a substring of the shuffled characters of the desired length
  return substr($shuffledCharacters, 0, $length);
}

// POST = withdrawal
if ( $method === 'POST' ) {
  if ( isset($data["withdrawal"]) ) {
    $amount = $data["amount"];
    $asset_id = $data["asset_id"];
    $wallet_addr = $data["wallet_addr"];

    // Check required fields
    if ( (!$amount || ($amount < 1)) || !$asset_id || !$wallet_addr ) {
      ApiResponse('error', 400, 'All fields are required');
    }
    
    $assetData = $Assets->findById($asset_id, $userId);
    $asset_rate = $assetData['price'];
    $volume = round($amount / $asset_rate, 4);
    $validateWallet = $WalletValidator->validateBySlug($assetData['slug'], $wallet_addr, $assetData['shortname']);

    // Validate wallet address
    if ( !$validateWallet['valid'] ) {
      ApiResponse('error', 400, 'Please enter a valid '.$assetData['shortname'].' address');
    }
    
    // Check wallet balance
    if ($volume > $assetData['volume']) {
      ApiResponse('error', 400, 'Insufficient '.$assetData['name'].' balance');
    }
    
    // send OTP
    require './routes/otp.php';
  }else
  if ( isset($data["confirm_withdrawal"]) ) {
    $amount = $data["amount"];
    $asset_id = $data["asset_id"];
    $wallet_addr = $data["wallet_addr"];
    $otp = $data["otp"];
    // Check required fields
    if ( !$otp) {
      ApiResponse('error', 400, 'OTP is required');
    }
    // Validate OTP
    $otpVerified = $OTP->findValidOtp($currentUser['email'], $otp);
    if ( !$otpVerified ) {
      return ApiResponse('error', 400, 'OTP invalid or expired');
    }
    
    $assetData = $Assets->findById($asset_id, $userId);
    $asset_rate = $assetData['price'];
    $volume = round($amount / $asset_rate, 4);
    // Validate wallet address
    $validateWallet = $WalletValidator->validateBySlug($assetData['slug'], $wallet_addr, $assetData['shortname']);
    if ( !$validateWallet['valid'] ) {
      ApiResponse('error', 400, 'Please enter a valid '.$assetData['shortname'].' address');
    }
    // Check wallet balance
    if ($volume > $assetData['volume']) {
      ApiResponse('error', 400, 'Insufficient '.$assetData['name'].' balance');
    }
    // Check network fee balance
    if ( ($assetData['shortname'] == 'ERC20') || ($assetData['shortname'] == 'TRC20') ) {
      $Network = null;
      if ($assetData['shortname'] == 'ERC20') $Network = $Assets->assetBySlug('ethereum', $userId);
      elseif ($assetData['shortname'] =='TRC20') $Network = $Assets->assetBySlug('tron', $userId);

      if ( $currentUser['withdrawal'] == 'false' ) {
        $msg = "You do not have {$Network['name']}({$Network['shortname']}) to cover your network fees!";
        if ($assetData['shortname'] == 'ERC20') $msg = "You do not have enough Ethereum(ERC20) to cover your required network fees!";
        if ($assetData['shortname'] == 'TRC20') $msg = "You do not have enough Tron(TRX) to cover your required network fees!";
        ApiResponse('error', 400, $msg);
      }
    }
    // trx data
    $trx_hash_generate = generateUniqueId();
    $trx_data = [
      "trx" => $trx_hash_generate,
      "user_id" => $userId,
      "type" => "withdraw",
      "amount" => $amount,
      "units" => $volume,
      "send_from" => $assetData['slug'],
      "send_to" => $wallet_addr,
      "confirmation" => 0,
      "proof" => null,
      "status" => "processing"
    ];
    
    $msg = "Withdrawal of {$volume} {$assetData['unit']} has been submitted, you will be notified once transaction is completed!";
    try {
      require './config/withdrawal-mail.php';
      $history->chargeWallet($userId, $assetData['slug'], $volume, 'withdraw', $trx_data);
      ApiResponse('success', 200, $msg, $trx_data);
    } catch (PDOException $th) {
      ApiResponse('error', 200, 'withdrawal failed', $th);
    }
  }else
  if ( isset($_POST["deposit"]) ) {
    $amount = $_POST["amount"];
    $asset_id = $_POST["asset_id"];
    $wallet_addr = $_POST["wallet_addr"];
    $proof = null;
    
    if ( isset($_FILES["proof"]) ) {
      $proof = $_FILES["proof"];
      $proof = $UploadController->uploadImage($proof);
    }else {
      ApiResponse('error', 400, 'You must u');
    }

    // return print_r($amount);
    if (!$amount || ($amount < 1)) {
      ApiResponse('error', 400, 'Amount is required');
    }
    $assetData = $Assets->findById($asset_id, $userId);
    // return print_r($assetData);
    $asset_rate = $assetData['price'];
    $volume = round($amount / $asset_rate, 4);
    
    $trx_hash_generate = generateUniqueId();
    // trx data
    $trx_data = [
      "trx" => $trx_hash_generate,
      "user_id" => $userId,
      "type" => "deposit",
      "amount" => $amount,
      "units" => $volume,
      "send_from" => $wallet_addr,
      "send_to" => $assetData['slug'],
      "confirmation" => 0,
      "status" => "processing",
      "proof" => $proof
    ];
    try {
      require './config/deposit-mail.php';
      $history->chargeWallet($userId, $assetData['slug'], $volume, 'deposit', $trx_data);
      ApiResponse('success', 200, 'Transaction submitted, '.$volume.' '.$assetData['unit'].' will be added to your '.$assetData['name'].' balance once transaction is confirmed', $trx_data);
    } catch (PDOException $th) {
      ApiResponse('error', 200, 'withdrawal failed', $th);
    }
  }
}
else
// GET
if ($trx_id) {
  // Fetch a single asset by ID
  $single_history = $history->findById($trx_id, $userId);
  if (!$single_history) {
    ApiResponse('error', 404, 'Id not found');
  }
  ApiResponse('success', 200, 'Transactions fetched successfully', $single_history);
} else if ($trx_hash) {
  // Fetch a single asset by slug
  $single_history = $history->historyBySlug($trx_hash);
  if (!$single_history) {
    ApiResponse('error', 404, 'Id not found');
  }

  if ($single_history['type'] == 'credit') {
    $joinAsset = $Assets->assetBySlug($single_history['send_to'], $userId);
    unset($joinAsset['createdat']);
    $single_history = array_merge($single_history, $joinAsset);
  }
  if ($single_history['type'] == 'deposit') {
    $joinAsset = $Assets->assetBySlug($single_history['send_to'], $userId);
    unset($joinAsset['createdat']);
    $single_history = array_merge($single_history, $joinAsset);
  }
  if ($single_history['type'] == 'withdraw') {
    $joinAsset = $Assets->assetBySlug($single_history['send_from'], $userId);
    unset($joinAsset['createdat']);
    $single_history = array_merge($single_history, $joinAsset);
  }
  ApiResponse('success', 200, 'Transactions fetched successfully', $single_history);
} else {
  // Fetch all history
  $allHistory = $history->fetchAll($userId);
  // Append full image URL
  foreach ($allHistory as &$history) {
    if ($history['type'] == 'credit') $history['asset'] = $Assets->assetBySlug($history['send_to'], $userId);
    if ($history['type'] == 'deposit') $history['asset'] = $Assets->assetBySlug($history['send_to'], $userId);
    if ($history['type'] == 'withdraw') $history['asset'] = $Assets->assetBySlug($history['send_from'], $userId);
  }
  ApiResponse('success', 200, 'Transactions fetched successfully', $allHistory);
}
