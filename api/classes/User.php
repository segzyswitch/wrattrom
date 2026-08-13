<?php
class User {
  private $conn;

  public function __construct() {
    $this->conn = DB::connect();
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

  public function create($data) {
    $walletId = $this->generateUniqueWalletId();
    // Hash the password and register the user
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("INSERT INTO
      users (wallet_id, name, email, password, phone, country)
      VALUES (?, ?, ?, ?, ?, ?)"
    );
    
    // 2. Insert default wallets for the user
    $walletSql = "INSERT INTO my_assets (user_id, asset_id, volume)
                  SELECT ?, id, '0.00' FROM assets";
    $walletStmt = $this->conn->prepare($walletSql);
    
    $this->conn->beginTransaction();
    $stmt->execute([
      $walletId,
      $data['name'],
      $data['email'],
      $password,
      $data['phone'],
      $data['country']
    ]);
    $id = $this->conn->lastInsertId();
    $walletStmt->execute([$id]);
    // Commit transaction
    $this->conn->commit();
    // return user ID
    return $this->findById($id);
  }

  public function findByEmail($email) {
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findById($id) {
    // Make sure to remove sensitive informations
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // change password
  public function changePassword($wallet_id, $hashedPassword) {
    $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE wallet_id = ?");
    return $stmt->execute([$hashedPassword, $wallet_id]);
  }

  public function walletBalance($user_id) {
    $stmt = $this->conn->prepare(
      "SELECT SUM(uw.volume * w.price) AS wallet_balance
      FROM my_assets uw
      INNER JOIN assets w ON uw.asset_id = w.id
      WHERE uw.user_id = ?"  
    );
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return (float) ($row['wallet_balance'] ?? '0.00');
  }
  
  public function popNotification($userId, $type, $feed) {
    $stmt = $this->conn->prepare(
      "INSERT INTO notifications (user_id, type, feed)
      VALUES (?, ?, ?)"
    );
    $stmt->execute([$userId, $type, $feed]);
  }
  
  public function getUserNotifications(int $userId): array {
    $sql = "SELECT * FROM notifications WHERE user_id = ?";
    $sql .= " ORDER BY createdat DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$userId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  private function walletIdExists($walletId) {
    $stmt = $this->conn->prepare("SELECT id FROM users WHERE wallet_id = ?");
    $stmt->execute([$walletId]);
    return $stmt->fetchColumn() !== false;
  }
}
