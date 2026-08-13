<?php
// Enable CORS for Nuxt
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

function ApiResponse($status, $code, $message, $data=null) {
  echo json_encode([
    "status" => $status,
    "message" => $message,
    "data" => $data
  ]);
  http_response_code($code);
  exit();
}

// Stop preflight OPTIONS requests from failing
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(200);
  exit();
}


function isValidEthereumAddress($address) {
  return preg_match('/^0x[a-fA-F0-9]{40}$/', $address) === 1;
}
function isValidBitcoinAddress($address) {
  if (preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $address)) return true; // Legacy
  if (preg_match('/^(bc1)[0-9a-z]{39,59}$/', $address)) return true;          // Bech32
  return false;
}
function isValidSolanaAddress($address) {
  return preg_match('/^[1-9A-HJ-NP-Za-km-z]{32,44}$/', $address) === 1;
}
function isValidTronAddress($address) {
  return preg_match('/^T[1-9A-HJ-NP-Za-km-z]{33}$/', $address) === 1;
}
function isValidTonAddress($address) {
  return preg_match('/^[A-Za-z0-9\-_]{48,66}$/', $address) === 1;
}
function isValidXrpAddress($address) {
  return preg_match('/^r[1-9A-HJ-NP-Za-km-z]{24,34}$/', $address) === 1;
}
function validateWallet($address, $chain = "ethereum") {
  $chain = strtolower($chain);

  switch ($chain) {
    case "ethereum":
    case "erc20":
    case "bsc":      // Binance Smart Chain
    case "polygon":   // Polygon
      return isValidEthereumAddress($address);

    case "bitcoin":
      return isValidBitcoinAddress($address);

    case "solana":
      return isValidSolanaAddress($address);

    case "tron":
    case "trc20":
      return isValidTronAddress($address);
      
    case "tron":
      return isValidTronAddress($address);

    case "xrp":
      return isValidXrpAddress($address);

    case "usdt":
      // Auto-detect chain
      if (isValidEthereumAddress($address)) return "ERC20 (Ethereum/BSC/Polygon)";
      if (isValidTronAddress($address))     return "TRC20 (Tron)";
      if (isValidSolanaAddress($address))   return "SPL (Solana)";
      return false;

    default:
      return true;
  }
}


?>