<?php
class DB {
  private static $conn;

  public static function connect() {
    if (!self::$conn) {
      $host = 'localhost';
    //   $dbname = 'coinma';
    //   $user = 'root';
    //   $pass = '';
       $dbname = 'cratobyt_main';
       $user = 'cratobyt_main';
       $pass = 'Primestar1%';

      self::$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
      self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return self::$conn;
  }
}
?>