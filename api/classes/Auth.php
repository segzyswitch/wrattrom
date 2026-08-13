<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth {
	private static $secret_key; // store this in .env ideally
	private static $algo = 'HS256';
  private $conn;

  public function __construct() {
    $this->conn = DB::connect();
  }

	public static function init() {
    self::$secret_key = $_ENV['JWT_SECRET'];
	}

	public static function generateToken($userId) {
		self::init();
		$payload = [
			'iss' => $_ENV['JWT_ISS'],  // issuer
			'aud' => $_ENV['JWT_AUD'],  // audience
			'iat' => time(),            // issued at
			'exp' => time() + ((60 * 60) * 12), // expires in 12 hour
			'uid' => $userId            // custom user ID claim
		];

		return JWT::encode($payload, self::$secret_key, self::$algo);
	}

	public static function validateToken($token) {
		self::init();
		try {
			$decoded = JWT::decode($token, new Key(self::$secret_key, self::$algo));
			return (array)$decoded;
		} catch (Exception $e) {
			return false;
		}
	}

	public static function getBearerToken() {
		$headers = apache_request_headers();
		if (isset($headers['Authorization'])) {
			if (preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

	// Log client details
	public function logLogin($userId, $info) {
		$stmt = $this->conn->prepare(
			"INSERT INTO account_session 
			(user_id, ip, user_agent, platform, city, region, country, latitude, longitude, geo_accuracy) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
		);
		$stmt->execute([
			$userId,
			$info['ip'] ?? '',
			$info['userAgent'] ?? '',
			$info['platform'] ?? '',
			$info['city'] ?? '',
			$info['region'] ?? '',
			$info['country'] ?? '',
			$info['latitude'] ?? '',
			$info['longitude'] ?? '',
			$info['geo_accuracy'] ?? 'ip'
		]);
	}
}
