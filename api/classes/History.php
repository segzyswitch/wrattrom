<?php
require_once './classes/Assets.php';

class History {
  private $conn;
  private $Assets;

  public function __construct() {
    $this->conn = DB::connect();
    $this->Assets = new Assets();
  }

  public function fetchAll($userId) {
    $stmt = $this->conn->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY id DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findById($id, $userId) {
    $stmt = $this->conn->prepare(
      "SELECT * FROM transactions
      WHERE id = ? AND user_id = ?"
    );
    $stmt->execute([$id, $userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function historyBySlug($trx_hash) {
    $stmt = $this->conn->prepare(
      "SELECT * FROM transactions
      WHERE trx = ?"
    );
    $stmt->execute([$trx_hash]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  public function makeTransaction($data) {
    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO transactions(trx, user_id, type, amount, units, send_from, send_to, confirmation, optional_file, status, createdat)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $query = $this->conn->prepare($sql);
    return $query->execute([
      $data["trx"],
      $data["user_id"],
      $data["type"],
      $data["amount"],
      $data["units"],
      $data["send_from"],
      $data["send_to"],
      $data["confirmation"],
      $data["proof"],
      $data["status"],
      $date
    ]);
  }
  
  // Charge Wallet
  public function chargeWallet($user_id, $asset_slug, $volume, $chargetype, $trx_data, $proof = null) {
    // Find Asset
    $assetData = $this->Assets->assetBySlug($asset_slug, $user_id);
    $asset_balance = $assetData['volume'];
    $finalvolume;
    if ($chargetype=='credit') $finalvolume = round(($asset_balance + $volume), 4);
    elseif ($chargetype=='withdraw') $finalvolume = $asset_balance;
    elseif ($chargetype=='deposit') $finalvolume = $asset_balance;
    else $finalvolume = round(($asset_balance - $volume), 4);
    $sql = "UPDATE my_assets SET volume = '$finalvolume' WHERE user_id = ? AND asset_id = ?";
    $query = $this->conn->prepare($sql);
    try {
      $this->conn->beginTransaction();
      $query->execute([$user_id, $assetData['id']]);
      $this->makeTransaction($trx_data);
      $this->conn->commit();
      return true;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

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
