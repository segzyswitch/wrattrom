<?php
require_once './classes/Auth.php';

$token = Auth::getBearerToken();
$payload = Auth::validateToken($token);

if (!$payload) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid token']);
    exit;
}

// Optional: record logout event in DB or blacklist token (advanced)

echo json_encode(['message' => 'Logout successful. Please delete the token on client.']);
