<?php

class Otp {
  private $conn;

  public function __construct() {
    $this->conn = DB::connect();
  }

  public function create($email, $otp, $expiry) {
    $stmt = $this->conn->prepare("INSERT INTO otps (email, otp_code, expires_at) VALUES (?, ?, ?)");
    return $stmt->execute([$email, $otp, $expiry]);
  }

  public function findValidOtp($email, $otp) {
    $stmt = $this->conn->prepare("SELECT * FROM otps WHERE email = ? AND otp_code = ? AND verified = 0 ORDER BY id DESC LIMIT 1");
    $stmt->execute([$email, $otp]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function markVerified($id) {
    $stmt = $this->conn->prepare("UPDATE otps SET verified = 1 WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function deleteExpired() {
    $stmt = $this->conn->prepare("DELETE FROM otps WHERE expires_at < NOW() || verified = 1");
    return $stmt->execute();
  }
}
