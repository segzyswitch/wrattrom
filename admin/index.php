<?php
session_start();
if ( isset($_SESSION["aave_auth_login_id"]) && isset($_SESSION["admin_status"]) ) {
  header("Location: dashboard");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Wrattrom - Admin Login</title>
	<link rel="shortcut icon" href="https://wrattrom.com/icon.png" type="image/x-icon">
	<link rel="stylesheet" href="assets/theme/global/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/line-awesome.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/bootstrap-icons.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/select2.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/toaster.css" />
	<link rel="stylesheet" href="assets/theme/global/css/swiper-bundle.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/apexcharts.css" />
	<link rel="stylesheet" href="assets/theme/global/css/datepicker.min.css" />
	<link rel="stylesheet" href="assets/theme/admin/auth/css/style.css" />
</head>
<body>
	<section class="admin-form">
		<div class="container">
			<div class="login-content row g-0 justify-content-center">
				<div class="col-xl-5 col-lg-6 order-lg-2 order-1">
					<div class="form-wrapper-one flex-column rounded-4">
						<div class="logo-area text-center mb-2">
							<div class="mx-auto d-inline-block bg-dark p-2 rounded-3 mb-3">
								<img src="https://wrattrom.com/logo.png"
									class="w-100 m-0"
									height="45"
									alt="Wrattrom"
								/>
							</div>
							<h1><i class="bi bi-lock-fill"></i></h1>
						</div>
						<form action="#" id="loginForm" method="POST">
							<div class="form-inner email">
								<label for="login-email">Email</label>
								<input type="text" id="login-email" name="username" placeholder="Username or Email Address" required />
							</div>
							<div class="form-inner password">
								<label for="login-password">Password</label>
								<input type="password" name="password" id="login-password" placeholder="Enter Password" required />
							</div>
							<div class="d-flex justify-content-between align-items-center mb-20">
								<!-- <div class="forgot-pass">
									<a href="javascript:void(0)">Forgot Password?</a>
								</div> -->
							</div>
							<input type="hidden" name="sign_in">
							<button type="submit" class="btn btn--dark btn--lg w-100 submit-btn">Sign In</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="squire-container">
		<ul class="squares"></ul>
	</div>
	<script src="assets/theme/global/js/jquery-3.7.1.min.js"></script>
	<script>
		"use strict";
		function notify(status, message) {
			toastr[status](message);
		}
	</script><!-- AJAX FORM -->
	<script type="text/javascript">
	$("#loginForm").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    $("#loginForm .submit-btn").html("<i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    $("#loginForm .submit-btn").html("Sign In");
	    if ( data.search('success') !== -1 ) {
	    	notify('success', data);
	      window.location.href = "dashboard";
	    }else {
	    	notify('warning', data);
	      // $("#loginForm .feedback").html(data);
	    }
	    },
	    error: function() {
	    $("#loginForm .submit-btn").html("Sign In");
	    notify('warning', 'An error occured, try again!');
	    // $("#loginForm .feedback").html("<div class='alert alert-danger'>An error occured, try again!</div>");
	    }
	  });
	});
	</script>
	<script src="assets/theme/global/js/bootstrap.bundle.min.js"></script>
	<script src="assets/theme/global/js/select2.min.js"></script>
	<script src="assets/theme/global/js/toaster.js"></script>
	<script src="assets/theme/global/js/swiper-bundle.min.js"></script>
	<script src="assets/theme/global/js/apexcharts.js"></script>
	<script src="assets/theme/global/js/datepicker.min.js"></script>
	<script src="assets/theme/global/js/datepicker.en.js"></script>
</body>
</html>
