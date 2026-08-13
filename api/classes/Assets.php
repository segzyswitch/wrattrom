<?php
class Assets {
  private $conn;

  public function __construct() {
    $this->conn = DB::connect();
  }

  public function fetchAll() {
    $stmt = $this->conn->prepare("SELECT * FROM assets ORDER BY id ASC");
    $stmt->execute([]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function userAssets($userId) {
    $stmt = $this->conn->prepare(
      "SELECT * FROM my_assets
      INNER JOIN assets ON my_assets.asset_id = assets.id
      WHERE my_assets.user_id = ? ORDER BY assets.id ASC"
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findById($id, $userId) {
    $stmt = $this->conn->prepare(
      "SELECT assets.*,
      COALESCE(my_assets.volume, '0.00') AS volume
      FROM assets
      LEFT JOIN my_assets
      ON my_assets.asset_id = assets.id
      AND my_assets.user_id = ?
      WHERE assets.id = ?"
    );
    $stmt->execute([$userId, $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  // All assets by slug
  public function assetBySlug($slug, $userId) {
    $stmt = $this->conn->prepare(
      "SELECT assets.*,
      COALESCE(my_assets.volume, '0.00') AS volume
      FROM assets
      LEFT JOIN my_assets
      ON my_assets.asset_id = assets.id
      AND my_assets.user_id = ?
      WHERE assets.slug = ?"
    );
    $stmt->execute([$userId, $slug]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  // User assets by slug
  // public function myAssetBySlug($slug, $userId) {
  //   $stmt = $this->conn->prepare(
  //     "SELECT * FROM my_assets
  //     INNER JOIN assets ON my_assets.asset_id = assets.id
  //     WHERE assets.slug = ? AND my_assets.user_id = ?"
  //   );
  //   $stmt->execute([$slug, $userId]);
  //   return $stmt->fetch(PDO::FETCH_ASSOC);
  // }

  private function generateUniqueWalletId() {
    do {
      $walletId = $this->generateWalletId();
      $exists = $this->walletIdExists($walletId);
    } while ($exists);

    return $walletId;
  }

  private function generateWalletId() {
    return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
  }

  private function walletIdExists($walletId) {
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE wallet_id = ?");
    $stmt->execute([$walletId]);
    return $stmt->fetchColumn() !== false;
  }
}
