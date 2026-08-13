<?php
require_once './classes/Auth.php';
require_once './classes/Assets.php';

$token = Auth::getBearerToken();
$payload = Auth::validateToken($token);
$host = 'http://localhost/coima/public/uploads';
// Check if the token is valid
if (!$payload) {
  ApiResponse('error', 401, 'Unauthorized', null);
}
// Get the user ID from the token payload
$userId = $payload['uid'];

$user_id = $_GET['user_id'] ?? null;
$asset_id = $_GET['id'] ?? null;
$asset_slug = $_GET['slug'] ?? null;
$Assets = new Assets();


if ($user_id) {
  // Fetch assets by user ID
  $allAssets = $Assets->userAssets($user_id);
  // if (!$allAssets) {
  //   ApiResponse('error', 404, 'User id not found', null);
  // }
  // Append full image URL
  foreach ($allAssets as &$asset) {
    $rate_change = $asset['prev_price'] ? (($asset['price'] - $asset['prev_price']) / $asset['prev_price'] * 100) : 0;
    $asset['rate_change'] = round($rate_change >= 0 ? $rate_change : substr($rate_change, 1), 2);
    $asset['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
    $asset['volume_price'] = round($asset['price'] * $asset['volume'], 4);
  }
  ApiResponse('success', 200, 'Assets fetched successfully', $allAssets);
} else if ($asset_id) {
  // Fetch a single asset by ID
  $asset = $Assets->findById($asset_id, $userId);
  if ($asset) {
    $rate_change = $asset['prev_price'] ? (($asset['price'] - $asset['prev_price']) / $asset['prev_price'] * 100) : 0;
    $asset['rate_change'] = round($rate_change >= 0 ? $rate_change : substr($rate_change, 1), 2);
    $asset['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
  }
  ApiResponse('success', 200, 'Asset fetched successfully', $asset);
} else if ($asset_slug) {
  // Fetch a single asset by slug
  $asset = $Assets->assetBySlug($asset_slug, $userId);
  if ($asset) {
    $rate_change = $asset['prev_price'] ? (($asset['price'] - $asset['prev_price']) / $asset['prev_price'] * 100) : 0;
    $asset['rate_change'] = round($rate_change >= 0 ? $rate_change : substr($rate_change, 1), 2);
    $asset['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
    $asset['volume_price'] = round($asset['price'] * $asset['volume'], 4);
  }
  ApiResponse('success', 200, 'Asset fetched successfully', $asset);
} else {
  // Fetch all assets
  $allAssets = $Assets->fetchAll();

  if ( $allAssets ) {
    foreach ($allAssets as &$asset) {
      $rate_change = $asset['prev_price'] ? (($asset['price'] - $asset['prev_price']) / $asset['prev_price'] * 100) : 0;
      $asset['rate_change'] = round($rate_change >= 0 ? $rate_change : substr($rate_change, 1), 2);
      $asset['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
    }
  }
  ApiResponse('success', 200, 'Assets fetched successfully', $allAssets);
}
