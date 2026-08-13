<?php
session_start();
require "Authroller.php";
$Authroller = new Authroller;
$conn = $Authroller->conn;


// GENERATE UNIQUE ID
function generateUniqueId($length = 10)
{
  // Define the characters to be used in the ID
  $characters = time() . 'ABCDEFGHJKLMNPQRSTUVWXYZ';
  // Shuffle the characters
  $shuffledCharacters = str_shuffle($characters);
  // Return a substring of the shuffled characters of the desired length
  return substr($shuffledCharacters, 0, $length);
}
// GENERATE ACCOUNT NUMBERS
function generateRandomNumber($length = 10)
{
  // Define the characters to be used in the ID
  $characters = time();
  // Shuffle the characters
  $shuffledCharacters = str_shuffle($characters);
  // Return a substring of the shuffled characters of the desired length
  return substr($shuffledCharacters, 0, $length);
}

// SIGN IN
if (isset($_POST["sign_in"])) {
  $usrname = $_POST["username"];
  $paswrd = $_POST["password"];

  $sql = "SELECT * FROM auth_users WHERE username = '$usrname'";
  $query = $conn->prepare($sql);
  try {
    $query->execute();
    $row = $query->fetch();
    if ($query->rowcount() < 1) {
      echo "Incorrect Username, check and try again.";
    } else {
      if (password_verify($paswrd, $row["password"])) {
        if ($row['status'] == 1) {
          $_SESSION["aave_auth_login_id"] = $row["admin_id"];
          $_SESSION["admin_status"] = $row["status"];
          echo "Login successful, you will be redirected";
        } elseif ($row['status'] == 2) {
          echo "Account locked, contact admin for support";
        } elseif ($row['status'] == 0) {
          echo "Account not confirmed, contact admin for support.";
        }
      } else {
        echo "Incorrect Password, check and try again!";
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

// ADD NEW USER ACCOUNT
if (isset($_POST["add_account"])) {
  // ADMIN ID
  $admin_id = $_SESSION["aave_auth_login_id"];
  // USER DETAILS
  $firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_SPECIAL_CHARS);
  $lastname = filter_var($_POST["lastname"], FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $phone = filter_var($_POST["phone"], FILTER_SANITIZE_SPECIAL_CHARS);
  $gender = filter_var($_POST["gender"], FILTER_SANITIZE_SPECIAL_CHARS);
  $password = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);
  $dob = filter_var($_POST["dob"], FILTER_SANITIZE_SPECIAL_CHARS);
  $str_address = filter_var($_POST["str_address"], FILTER_SANITIZE_SPECIAL_CHARS);
  $city = filter_var($_POST["city"], FILTER_SANITIZE_SPECIAL_CHARS);
  $state = filter_var($_POST["state"], FILTER_SANITIZE_SPECIAL_CHARS);
  $zipcode = filter_var($_POST["zipcode"], FILTER_SANITIZE_SPECIAL_CHARS);
  $confirm_password = filter_var($_POST["confirm_password"], FILTER_SANITIZE_SPECIAL_CHARS);
  $current_balance = filter_var($_POST["current_balance"], FILTER_SANITIZE_SPECIAL_CHARS);
  $savings_balance = filter_var($_POST["savings_balance"], FILTER_SANITIZE_SPECIAL_CHARS);
  // GENERATE 4 RANDOM NUMBERS WITH LAST SIX OF TIME FUNCTION
  // $generate_id = generateUniqueId(10);
  // PASSWOD HASHING
  $hashpwd = password_hash($password, PASSWORD_DEFAULT);
  // Generate Account Number
  $current_account = substr(time(), strlen(time()) - 6) . rand(1000, 9999);
  $savings_account = substr(time(), strlen(time()) - 6) . rand(1109, 9988);

  // echo $generate_id;
  // return false;

  $checkinfo = $conn->prepare("SELECT email FROM users WHERE email='$email'");
  $checkinfo->execute();
  //
  if (strlen($password) < 6) {
?>
    <div class="alert-danger alert">
      <i class="close" data-dismiss="alert">&times;</i>
      <span><i class="fa fa-exclamation-triangle"></i> Passwords should be at least 6 characters.</span>
    </div>
  <?php
  } elseif ($password !== $confirm_password) {
  ?>
    <div class="alert-danger alert">
      <i class="close" data-dismiss="alert">&times;</i>
      <span><i class="fa fa-exclamation-triangle"></i> Passwords do not match.</span>
    </div>
  <?php
  } elseif ($checkinfo->rowcount() > 0) {
  ?>
    <div class="alert-danger alert">
      <i class="close" data-dismiss="alert">&times;</i>
      <span><i class="fa fa-exclamation-triangle"></i> Username or email already exists, try a new one.</span>
    </div>
    <?php
  } else {
    // validate password
    $sql = "INSERT INTO users(admin_id, firstname, lastname, email, phone,
        dob, gender,
        current_account, savings_account, savings_bal, current_bal,
        street_address, city, state, zipcode, password, alt_password)
        VALUES('$admin_id', '$firstname', '$lastname', '$email', '$phone',
        '$dob', '$gender',
        '$current_account', '$savings_account', '$savings_balance', '$current_balance',
        '$str_address', '$city', '$state', '$zipcode', '$hashpwd', '$password')";
    $query = $conn->prepare($sql);
    try {
      $query->execute();
    ?>
      <div class="alert-success alert">
        <i class="close" data-dismiss="alert">&times;</i>
        <span><i class="fa fa-exclamation-triangle"></i> New user successfully created.</span>
        <a href="users">View users</a>
      </div>
    <?php
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}

// Add plan
if (isset($_POST['fund_wallet'])) {
  $user_id = $_POST['user_id'];
  $asset = $_POST['asset'];
  $amount = filter_var($_POST['amount'], FILTER_SANITIZE_SPECIAL_CHARS);
  $amount = str_replace(',', '', $_POST['amount']);
  $amount = (float) $amount;
  $status = filter_var($_POST['status'], FILTER_SANITIZE_SPECIAL_CHARS);
  $user_info = $Authroller->singleUser($user_id);
  // Asset deta by slug
  $assetData = $Authroller->assetBySlug($asset, $user_id);
  $asset_rate = $assetData['price'];
  $asset_unit = round($amount / $asset_rate, 4);

  if ($amount < 1) {
    echo "Error, amount is invalid!";
    return false;
  }

  // trx data
  $trx_hash_generate = generateUniqueId();
  $snd_from = "0xa3f6b4" . str_shuffle("c8e1f02938d6eab9cc731e25df43") . "c7b1a4";
  $trx_data = [
    "trx" => $trx_hash_generate,
    "user_id" => $user_id,
    "type" => "credit",
    "amount" => $amount,
    "units" => $asset_unit,
    "send_from" => $snd_from,
    "send_to" => $assetData['slug'],
    "confirmation" => 10,
    "status" => $status
  ];

  try {
    // Make transactions
    $Authroller->chargeWallet($user_id, $asset, $asset_unit, 'credit', $trx_data);
    require 'deposit-mail.php';
    echo $user_info['name'] . " " . $assetData['name'] . " wallet successfully funded with " . $asset_unit . " " . $assetData['unit'];
    exit;
  } catch (Exception $e) {
    $conn->rollBack();
    // Handle error
  }
}


// update user status
if (isset($_GET['activate_user'])) {
  $user_id = $_GET['activate_user'];
  $status = $_GET['status'];
  // echo $user_id;
  $sql = "UPDATE users
    SET status = '$status'
  WHERE id = '$user_id'";

  $query = $conn->prepare($sql);
  try {
    $query->execute();
    echo "success";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if (isset($_POST['withdrawal_status'])) {
  $user_id = $_POST['withdrawal_status'];
  $status = $_POST['status'];
  $return_status = null;

  if ($status == 'false') $return_status = 'true';
  else $return_status = 'false';

  $sql = "UPDATE users
    SET withdrawal = '$return_status'
  WHERE id = '$user_id'";

  $query = $conn->prepare($sql);
  try {
    $query->execute();
    echo "success";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

// update user profile
if (isset($_POST['update_user'])) {
  $user_id = $_POST['update_user'];
  $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $phone = filter_var($_POST["phone"], FILTER_SANITIZE_SPECIAL_CHARS);
  $address = filter_var($_POST["address"], FILTER_SANITIZE_SPECIAL_CHARS);
  $status = filter_var($_POST["status"], FILTER_SANITIZE_SPECIAL_CHARS);

  // return false;
  $sql = "UPDATE users
  SET name = '$name',
  email = '$email',
  phone = '$phone',
  address = '$address',
  status = '$status'
  WHERE id = '$user_id'";

  $query = $conn->prepare($sql);
  try {
    $query->execute();
    echo "success";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}


// manage deposit
if (isset($_GET['payment_status'])) {
  $trx = $_GET['payment_status'];
  $confirm = $_GET['confirm'];
  $trx_info = $Authroller->singleTransaction($trx);
  $amount = $trx_info['amount'];
  $invoice = $trx_info['trx'];
  $user_id = $trx_info['user_id'];
  $status = 'pending';

  // adjust status by confirmation
  if ($confirm == 10) {
    $status = 'completed';
    $asset_slug = ($trx_info['type'] == 'withdraw') ? $trx_info['send_from'] : $trx_info['send_to'];
    $Charge = $Authroller->chargeWallet(
      $user_id,
      $asset_slug,
      $trx_info['units'],
      $trx_info['type']
    );
  } else if (($confirm < 10) && ($confirm > 5)) {
    $status = 'pending';
  } else if (($confirm < 5) && ($confirm > -1)) {
    $status = 'processing';
  } else if ($confirm == -1) {
    $status = 'failed';
  }
  // update transaction status
  $update_status = "UPDATE transactions
  SET status = '$status', confirmation = '$confirm'
  WHERE id = '$trx'";
  $query1 = $conn->prepare($update_status);

  try {
    $query1->execute();
    // $query2->execute();
    echo 'Status changed to "' . $status . '"';
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}


// Add wallet
if (isset($_POST['add_wallet'])) {
  $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
  $wallet_address = filter_var($_POST['wallet_address'], FILTER_SANITIZE_SPECIAL_CHARS);

  if ($_FILES['image']['size'] == 0) {
    echo "Please choose an image";
    return false;
  }

  // Check file
  $check_name = $_FILES['image']['name'];
  $file_ext = pathinfo($check_name, PATHINFO_EXTENSION);
  $save_name = 'wallet_' . generateUniqueId(10) . "." . $file_ext;
  $check_tmp_file = $_FILES["image"]["tmp_name"];
  $target_dir = "../api/public/uploads/";
  $check_target_file = $target_dir . $save_name;

  // Upload icon
  if (move_uploaded_file($check_tmp_file, $check_target_file)) {
    $sql = "INSERT INTO crypto_wallets(name, icon, wallet_address)
    VALUES('$name', '$save_name', '$wallet_address')";
    $query = $conn->prepare($sql);
    try {
      $query->execute();
      echo "Wallet added successfully";
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  } else {
    echo "An error occured, check image and try again";
    return false;
  }
}
// Update
if (isset($_POST['update_wallet'])) {
  $wallet_id = $_POST['update_wallet'];
  $price = filter_var($_POST['price'], FILTER_SANITIZE_SPECIAL_CHARS);
  $wallet_address = filter_var($_POST['wallet_address'], FILTER_SANITIZE_SPECIAL_CHARS);
  if (empty($price) || empty($wallet_address)) {
    echo "All inputs are reqired";
    return false;
  }

  if ($_FILES['qrcode']['size'] == 0) {
    $sql = "UPDATE assets
    SET price = '$price',
    wallet_address = '$wallet_address'
    WHERE id = '$wallet_id'";
  } else {
    // Check file
    $check_name = $_FILES['qrcode']['name'];
    $file_ext = pathinfo($check_name, PATHINFO_EXTENSION);
    $save_name = 'assetqr_' . generateUniqueId(10) . "." . $file_ext;
    $full_path = "https://wrattrom.com/api/public/uploads/" . $save_name;
    $check_tmp_file = $_FILES["qrcode"]["tmp_name"];
    $target_dir = "../../api/public/uploads/";
    $check_target_file = $target_dir . $save_name;
    if (move_uploaded_file($check_tmp_file, $check_target_file)) {
      $sql = "UPDATE assets
      SET price = '$price',
      wallet_address = '$wallet_address',
      qr_code = '$full_path'
      WHERE id = '$wallet_id'";
    } else {
      echo "Error occured while uploading file";
      return false;
    }
  }
  try {
    $query = $conn->prepare($sql);
    $query->execute();
    echo "Asset successfully updated";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}
// delete wallet
if (isset($_POST['delete_wallet'])) {
  $wallet_id = $_POST['delete_wallet'];
  $sql = "DELETE FROM crypto_wallets  WHERE id = '$wallet_id'";
  $query = $conn->prepare($sql);
  header('Content-Type: application/json');
  try {
    $query->execute();
    $response = [
      'id' => $wallet_id,
      'message' => 'Wallet deleted successfully'
    ];
    echo json_encode($response);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}



// UPDATE PROFILE
if (isset($_POST["update_admin"])) {

  $nickname = filter_var($_POST["nickname"], FILTER_SANITIZE_SPECIAL_CHARS);
  $username = filter_var($_POST["username"], FILTER_SANITIZE_SPECIAL_CHARS);
  // $password = filter_var($_POST["password"], FILTER_SANITIZE_SPECIAL_CHARS);

  // check password

  $sql = "UPDATE auth_users
    SET nickname = '$nickname',
    username = '$username'";

  $query = $conn->prepare($sql);
  try {
    $query->execute();
    echo "Details updated successfully";
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

// CHANGE ADMIN PASSWORD
if (isset($_POST["change_password"])) {
  $old_pass = trim($_POST["old_pass"]);
  $new_pass = trim($_POST["new_pass"]);
  $con_pass = trim($_POST["con_pass"]);

  if (empty($old_pass) || empty($new_pass) || empty($con_pass)) {
    echo "All fields are required";
    exit;
  }

  if ($new_pass !== $con_pass) {
    echo "New password and confirm password do not match";
    exit;
  }

  // Get current password from database
  $sql = "SELECT password FROM auth_users WHERE id = 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $row = $stmt->fetch();

  // Check old password
  if (!password_verify($old_pass, $row["password"])) {
    echo "Old password is incorrect";
    exit;
  }

  // Hash new password
  $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);

  // Update password
  $sql = "UPDATE auth_users SET password = '$hashed_pass', alt_password = '$new_pass' WHERE id = 1";
  $stmt = $conn->prepare($sql);

  if ($stmt->execute()) {
    echo "Password changed successfully";
  } else {
    echo "Error changing password, try again later";
  }
}

?>