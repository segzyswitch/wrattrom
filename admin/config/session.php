<?php
session_start();
require_once "config/Authroller.php";
$Authroller = new Authroller;

if ( isset($_SESSION["aave_auth_login_id"]) && isset($_SESSION["admin_status"]) ) {
  // ADMIN ID
  $admin_id = $_SESSION["aave_auth_login_id"];
  // ADMIN USER INFO
  $admin_info = $Authroller->Admin();

  if ( $_SESSION["admin_status"] == 0 ) {
  	unset($_SESSION["aave_auth_login_id"]);
		unset($_SESSION["admin_status"]);
  	header("Location: index?locked");
  }
}else {
  header("Location: index");
}
?>