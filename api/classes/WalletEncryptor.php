<?php
class WalletEncryptor
{
	private const CIPHER = 'AES-256-CBC';
	private const SECRET_KEY = 'q7#dm2p9@+3L<jB&1gVk!Zx7%vC9eTp$'; // Exactly 32 chars (256-bit)
	private const SECRET_IV = 'C4r@toByT_1vKey!';                 // Exactly 16 chars (128-bit)
	private const EXPIRY_MINUTES = 5; // Token valid for 5 minutes

	public static function encrypt(string $walletId): string
	{
		$payload = [
			'wallet_id' => $walletId,
			'ts' => time() // UNIX timestamp
		];
		$json = json_encode($payload);

		$ciphertext = openssl_encrypt($json, self::CIPHER, self::SECRET_KEY, OPENSSL_RAW_DATA, self::SECRET_IV);
		$hmac = hash_hmac('sha256', $ciphertext, self::SECRET_KEY, true);

		$combined = base64_encode($hmac . $ciphertext);
		return rtrim(strtr($combined, '+/', '-_'), '='); // URL-safe
	}

	public static function decrypt(string $token): ?string
	{
		$decoded = base64_decode(strtr($token, '-_', '+/'), true);

		if ($decoded === false || strlen($decoded) < 32) {
			return null; // invalid or too short
		}

		$hmac = substr($decoded, 0, 32);
		$ciphertext = substr($decoded, 32);

		// Check HMAC integrity
		$calcHmac = hash_hmac('sha256', $ciphertext, self::SECRET_KEY, true);
		if (!hash_equals($hmac, $calcHmac)) {
			return null; // tampered
		}

		$json = openssl_decrypt($ciphertext, self::CIPHER, self::SECRET_KEY, OPENSSL_RAW_DATA, self::SECRET_IV);
		$payload = json_decode($json, true);

		if (!$payload || !isset($payload['wallet_id'], $payload['ts'])) {
			return null;
		}

		// Expiry check
		if (time() - $payload['ts'] > self::EXPIRY_MINUTES * 60) {
			return null; // expired
		}

		return $payload['wallet_id'];
	}
}
