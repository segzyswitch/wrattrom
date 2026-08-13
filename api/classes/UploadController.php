<?php
class UploadController {
  private $uploadDir;
  private $baseUrl;

  public function __construct() {
    $this->uploadDir = __DIR__ . '/../public/uploads/';
    
    // Auto-detect your API base URL
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $this->baseUrl = $protocol . $host . "/api/public/uploads/";
  }

  public function uploadImage($file) {
    // ✅ 1. File exists?
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return [
            "status" => "error",
            "message" => "No file uploaded or upload error"
        ];
    }

    // ✅ 2. Validate type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        return [
            "status" => "error",
            "message" => "Invalid file type (allowed: jpg, png, gif, webp)"
        ];
    }

    // ✅ 3. Generate unique filename
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = uniqid("img_", true) . "." . $ext;
    $targetPath = $this->uploadDir . $fileName;

    // ✅ 4. Move uploaded file
    try {
      move_uploaded_file($file['tmp_name'], $targetPath);
      return $this->baseUrl . $fileName;
    } catch (PDOException $th) {
      return $th;
    }
  }
}
