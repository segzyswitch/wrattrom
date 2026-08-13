<?php
header("Content-Type: application/json");

// Autoload or require files
require_once __DIR__ . '/config/env.php';
require_once './config/config.php';
require_once './classes/DB.php';
require_once './classes/User.php';

// Simple routing
$pre_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = substr($pre_uri, strlen('/api'));
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
  // Test route
  case '/test':
    ApiResponse('success', 200, 'Test');
  break;
  
  // Update prices
  case '/update-prices':
    require './routes/update-prices.php';
  break;
  
  // Password recovery
  case '/recovery':
    require './routes/recovery.php';
  break;
  
  // Reset Password
  case '/reset-password':
    require './routes/reset-password.php';
  break;

  // connect-wallet
  case '/connect-wallet':
    require './routes/connect-wallet.php';
  break;

  // Register route
  case '/register':
    if ($method === 'POST') {
      require './routes/register.php';
    } else {
      // http_response_code(405);
      ApiResponse('error', 405, 'Invalid request');
    }
  break;

  // Login route
  case '/login':
    if ($method === 'POST') {
      require './routes/login.php';
    } else {
      // http_response_code(405);
      ApiResponse('error', 405, 'Invalid request');
    }
  break;

  // Logout route
  case '/logout':
    if ($method === 'POST') {
      require './routes/logout.php';
    } else {
      // http_response_code(405);      
      ApiResponse('error', 405, 'Invalid request');
    }
  break;

  // User route
  case '/user':
    if ($method === 'GET') {
      require './routes/user.php';
    } else {
      // http_response_code(405);
      ApiResponse('error', 405, 'Invalid request');
    }
  break;

  // ... your other routes here ...

  // Assets routes
  case '/assets':
    if ($method === 'GET') {
      require './routes/assets.php';
    } else {
      // http_response_code(405);
      ApiResponse('error', 405, 'Invalid request');
    }
  break;
    
  // History routes
  case '/history':
    require './routes/history.php';
  break;
  // Notifications routes
  case '/deposit':
    require './routes/history.php';
  break;
    
  // Notifications routes
  case '/notifications':
    if ($method === 'GET') {
      require './routes/notifications.php';
    } else {
      // http_response_code(405);
      ApiResponse('error', 405, 'Invalid request');
    }
  break;
    
  // Notifications routes
  case '/otp':
    require './routes/otp.php';
  break;

  // default
  default:
    http_response_code(404);
    echo json_encode(['error' => $uri.' Not Found']);
}