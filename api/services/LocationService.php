<?php

class LocationService
{
	public static function enrichFromBackend(string $ip): array
	{
		if (!$ip || $ip === '127.0.0.1') return [];

		// $url = "https://ipapi.co/$ip/json/";
		$url = "https://ipapi.co/json/";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ⚠️ disable SSL verify only for testing

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			echo "cURL Error: " . curl_error($ch);
		}

		curl_close($ch);

		$data = json_decode($response, true);
		// return print_r($response);
		return [
			'city'      => $data['city'] ?? null,
			'region'    => $data['region'] ?? null,
			'country'   => $data['country_name'] ?? null,
			'latitude'  => $data['latitude'] ?? null,
			'longitude' => $data['longitude'] ?? null,
		];
	}
}
