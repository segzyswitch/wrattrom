<?php
require_once('classes/CoinGeckoAPI.php');

$db = new DB();
$apiKey = "CG-89hfoLE3KwHhfG4cEQ6HBw58";
$gecko = new CoinGeckoAPI($apiKey);
$updater = new AssetUpdater($gecko);

// Map your DB slugs => CoinGecko IDs
$slugMap = [
	"bitcoin" => "bitcoin",
	"usdt" => "tether",
	"xrp" => "ripple",
	"usdt-erc20" => "tether",
	"tron" => "tron",
	"ethereum" => "ethereum",
	"solana" => "solana"
];

// Run update
$updater->updatePrices($slugMap);
