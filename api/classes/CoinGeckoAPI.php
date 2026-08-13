<?php
require_once "classes/DB.php"; // your DB connection class
$DB = new DB();

class CoinGeckoAPI extends DB
{
  private string $baseUrl = "https://api.coingecko.com/api/v3/";
  private string $apiKey;

  public function __construct(string $apiKey)
  {
    $this->apiKey = $apiKey;
  }

  public function fetchPrices(array $ids, string $vsCurrency = "usd") : array
  {
    $idsParam = implode(",", $ids);
    // return '$idsParam';
    $url = $this->baseUrl . "simple/price?ids={$idsParam}&vs_currencies={$vsCurrency}";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "x-cg-demo-api-key: {$this->apiKey}"
      ]
    ]);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
      throw new Exception("cURL Error: " . curl_error($ch));
    }

    curl_close($ch);
    $data = json_decode($response, true);

    if (!is_array($data)) {
      throw new Exception("Invalid API response: " . $response);
    }

    return $data;
  }
}

class AssetUpdater
{
  private PDO $conn;
  private CoinGeckoAPI $api;

  public function __construct(CoinGeckoAPI $api)
  {
    $this->conn = DB::connect();
    $this->api = $api;
  }

  public function updatePrices(array $slugMap)
  {
    $prices = $this->api->fetchPrices(array_unique(array_values($slugMap)));

    foreach ($slugMap as $slug => $cgId) {
      if (isset($prices[$cgId]['usd'])) {
        $newPrice = $prices[$cgId]['usd'];

        // Fetch old price first
        $stmt = $this->conn->prepare("SELECT price FROM assets WHERE slug = :slug");
        $stmt->execute([':slug' => $slug]);
        $oldPrice = $stmt->fetchColumn();

        // Update with new + previous price
        $stmt = $this->conn->prepare("
                    UPDATE assets 
                    SET prev_price = :prev_price,
                        price = :price,
                        createdat = NOW()
                    WHERE slug = :slug
                ");
        $stmt->execute([
          ':prev_price' => $oldPrice,
          ':price' => $newPrice,
          ':slug' => $slug
        ]);
      }
    }

    echo "✅ Asset prices updated successfully!\n";
  }
}
