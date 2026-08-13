<?php

class Authroller
{  /* online server */
  //  private $db_server = 'localhost';
  //   private $db_username = 'cratobyt_main';
  //   private $db_password = 'Primestar1%';
  //   private $db_name = 'cratobyt_main';

  /* local server */
  private $db_server = 'localhost';
  private $db_username = 'root';
  private $db_password = '';
  private $db_name = 'wrattrom';
  
  // DB Connection
  public $conn;

  public function __construct() {
    try {
      $this->conn = @new PDO("mysql:host=$this->db_server;dbname=$this->db_name", $this->db_username, $this->db_password);
      // set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //echo "Connected successfully";
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      exit;
    }
  }

  public function Admin() {
    $admin_id = $_SESSION["aave_auth_login_id"];
    $sql = "SELECT * FROM auth_users WHERE admin_id = '$admin_id'";
    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetch();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
  // All users
  public function Users() {
    $sql = "SELECT * FROM users ORDER BY id DESC";
    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
  // Single User
  public function singleUser($id) {
    $sql = "SELECT * FROM users WHERE id = '$id'";
    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetch();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
  // user By UUID
  public function userByUUID($uuid) {
    $sql = "SELECT * FROM users WHERE wallet_id = '$uuid'";
    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetch();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
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

  // All transactions
  public function allTransactions() {
    $sql = "SELECT * FROM transactions
    ORDER BY id DESC";

    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
  // Single transaction
  public function singleTransaction($trx_id) {
    // $admin_id = $_SESSION["aave_auth_login_id"];
    $sql = "SELECT * FROM transactions
    WHERE id = '$trx_id'";

    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetch();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
  // Add transaction
  public function addTransaction($data) {
    $sql = "INSERT INTO transactions(trx, user_id, type, amount, units, send_from, send_to, confirmation, status)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $query = $this->conn->prepare($sql);
    $query->execute([
      $data["trx"],
      $data["user_id"],
      $data["type"],
      $data["amount"],
      $data["units"],
      $data["send_from"],
      $data["send_to"],
      $data["confirmation"],
      $data["status"]
    ]);
    return true;
  }
  // Fund Wallet
  public function chargeWallet($user_id, $asset_slug, $volume, $chargetype, $trx_data = null) {
    // Find Asset
    $assetData = $this->userAssetBySlug($user_id, $asset_slug);
    $asset_balance = $assetData['volume'];
    $finalvolume;
    if ($chargetype=='withdraw') $finalvolume = round(($asset_balance - $volume) * 1, 4);
    else $finalvolume = round(($asset_balance + $volume), 4);
    $sql = "UPDATE my_assets SET volume = '$finalvolume' WHERE user_id = ? AND asset_id = ?";
    $query = $this->conn->prepare($sql);
    try {
      if ($trx_data != null) $this->conn->beginTransaction();
      $query->execute([$user_id, $assetData['id']]);
      if ($trx_data != null) $this->addTransaction($trx_data);
      if ($trx_data != null) $this->conn->commit();
      return true;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // All deposits
  public function allDeposits() {
    // $admin_id = $_SESSION["aave_auth_login_id"];
    $sql = "SELECT t.*, a.id AS asset_id, a.name AS name FROM transactions t
    INNER JOIN assets a ON a.slug = t.send_to
    WHERE t.type = 'deposit'
    ORDER BY t.id DESC";

    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
  
  // All withdrawals
  public function allWithdrawals() {
    $sql = "SELECT t.*, a.id AS asset_id, a.name AS name FROM transactions t
    INNER JOIN assets a ON a.slug = t.send_from
    WHERE t.type = 'withdraw'
    ORDER BY t.id DESC";

    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
  
  // All Credits
  public function allCredits() {
    $sql = "SELECT t.*, a.id AS asset_id, a.name AS name FROM transactions t
    INNER JOIN assets a ON a.slug = t.send_to
    WHERE t.type = 'credit'
    ORDER BY t.id DESC";

    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // All Assets
  public function allAssets() {
    // $admin_id = $_SESSION["aave_auth_login_id"];
    $sql = "SELECT * FROM assets
    ORDER BY id DESC";

    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // Assets by slug
  // public function assetBySlug($slug) {
  //   // $admin_id = $_SESSION["aave_auth_login_id"];
  //   $sql = "SELECT * FROM assets WHERE slug = '$slug'";
  //   try {
  //     $query = $this->conn->prepare($sql);
  //     $query->execute();
  //     $data = $query->fetch();
  //     $rate_change = $data['prev_price'] ? round(($data['price'] - $data['prev_price']) / $data['prev_price'] * 100, 2) : 0;
  //     $data['rate_change'] = $rate_change >= 0 ? $rate_change : substr($rate_change, 1);
  //     $data['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
  //     return $data;
  //   } catch (PDOException $e) {
  //     return $e->getMessage();
  //   }
  // }
  
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
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $rate_change = $data['prev_price'] ? round(($data['price'] - $data['prev_price']) / $data['prev_price'] * 100, 2) : 0;
    $data['rate_change'] = $rate_change >= 0 ? $rate_change : substr($rate_change, 1);
    $data['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
    return $data;
  }

  public function userAssets($userId) {
    $stmt = $this->conn->prepare(
      "SELECT * FROM my_assets
      INNER JOIN assets ON my_assets.asset_id = assets.id
      WHERE my_assets.user_id = ? ORDER BY rand()"
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // User Assets by slug
  public function userAssetBySlug($user_id, $slug) {
    $stmt = $this->conn->prepare(
      "SELECT * FROM my_assets
      INNER JOIN assets ON my_assets.asset_id = assets.id
      WHERE assets.slug = ? AND my_assets.user_id = ?"
    );
    $stmt->execute([$slug, $user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  // Running investments
  public function runningInvestments() {
    // $admin_id = $_SESSION["aave_auth_login_id"];
    $sql = "SELECT * FROM trades
    WHERE status = 'running'
    ORDER BY id DESC";

    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // Plans
  public function allPlans() {
    // $admin_id = $_SESSION["aave_auth_login_id"];
    $sql = "SELECT * FROM plans
    ORDER BY id DESC";
    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  // Wallets
  public function Wallets() {
    // $admin_id = $_SESSION["aave_auth_login_id"];
    $sql = "SELECT * FROM assets
    ORDER BY id DESC";
    try {
      $query = $this->conn->prepare($sql);
      $query->execute();
      $data = $query->fetchAll();
      return $data;
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }
}
?>