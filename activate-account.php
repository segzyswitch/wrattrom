<?php
if (!isset($_GET['uuid'])) {
	header("Location: ./");
	return false;
}
$uuid = $_GET['uuid'];
require "api/classes/DB.php";
$DB = new DB;
$conn = $DB->connect();

$check = $conn->prepare("SELECT status FROM users WHERE wallet_id = '$uuid'");
try {
	$check->execute();
	$get_status = $check->fetch();
	$user_status = $get_status['status'];
	if ( $user_status == 1 ) {
		echo "Link already expired! <a href='./'>Go home</a>";
		return false;
	}
} catch (PDOException $e) {
	echo $e->getMessage();
	return false;
}

// Update user
$sql = "UPDATE users
SET status = 1
WHERE wallet_id = '$uuid'";
$query = $conn->prepare($sql);
try {
	$query->execute();
} catch (PDOException $e) {
	echo $e->getMessage();
	return false;
}

// /usr/local/bin/ea-php81 /home/cratobyt/public_html/api/routes/cron-update-prices.php >> /home/cratobyt/update_prices.log 2>&1
?>
<!DOCTYPE html>
<html lang="en-US" style="scroll-behavior: smooth;">

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta id="siteViewport" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Activate account | Wrattrom</title>
	<meta name="title" content="Wrattrom | The Safest Next-Generation Crypto Wallet">
	<meta name="description"
		content="Wrattrom is the safest next-generation crypto wallet — secure, simple, and built for everyone. Save, swap, and trade 1000+ cryptocurrencies and tokens with ultra-high security, password protection, and encrypted backups. Manage your digital assets easily from your phone or card, anywhere in the world.">
	<meta name="keywords"
		content="Wrattrom, crypto wallet, secure crypto wallet, best crypto wallet, crypto trading, swap crypto, digital assets, cryptocurrency storage, password protection, encrypted backup, next generation wallet">
	<meta name="author" content="Wrattrom" />
	<!-- Open Graph / Facebook -->
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://wrattrom.com">
	<meta property="og:title" content="Wrattrom | The Safest Next-Generation Crypto Wallet">
	<meta property="og:description"
		content="Experience the safest crypto wallet for everyone. Save, swap, and trade over 1000+ cryptocurrencies with Wrattrom — simple, secure, and built for the future.">
	<meta property="og:image" content="https://wrattrom.com/icon.png">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

	<link rel="icon" href="https://wrattrom.com/icon.png" sizes="32x32" />
	<link rel="icon" href="https://wrattrom.com/icon.png" sizes="192x192" />
	<link rel="apple-touch-icon" href="https://wrattrom.com/icon.png" />

	<link rel='stylesheet' id='google-fonts-1-css'
		href='https://fonts.googleapis.com/css?family=Roboto%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CRoboto+Slab%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CInter%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2C400%2C400italic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic&amp;display=auto&amp;ver=6.8.2'
		type='text/css' media='all' />
	<link rel='stylesheet' id='elementor-icons-shared-0-css'
		href='wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min52d5.css?ver=5.15.3' type='text/css'
		media='all' />
	<link rel='stylesheet' id='elementor-icons-fa-solid-css'
		href='wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min52d5.css?ver=5.15.3' type='text/css'
		media='all' />
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<style>
		body {
			background-color: #222223;
			scroll-behavior: smooth;
		}
		.page-container {
			min-height: 100dvh;
			display: flex;
		}
		.page-card {
			background-color: #2E2D2D;
			border-radius: 15px;
			color: #cfcfcf;
		}
		.signin-btn {
			padding: 10px 30px;
			border-radius: 30px;
			background-color: #25c866;
			border-color: #25c866;
		}
	</style>
</head>

<body>

<div class="container-fluid page-container">
		<div class="col-sm-4 mx-auto py-4 px-0 my-auto text-center">
			<div class="page-card p-3 py-4">
				<p class="display-1 mb-4"><i>🎉</i></p>
				<p class="h3 fw-light mb-3">Account successfully activated!</p>
				<p class="mb-4">Your account has been activated and you're all set to start using Wrattrom walllet. We're excited to have you on board!</p>
				<p class="mb-4 py-2"><a href="./app" class="btn btn-success signin-btn">Sign In</a></p>
				<div class="w-100 text-center">
					<a href="./" class="mx-2 text-muted">Home</a>
					<a href="#about" class="mx-2 text-muted">About</a>
					<a href="#contact" class="mx-2 text-muted">Contact</a>
				</div>
			</div>
	</div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

<!-- CHATWOOT -->
<script>
	(function(d,t) {
		var BASE_URL="https://app.chatwoot.com";
		var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=BASE_URL+"/packs/js/sdk.js";
		g.async = true;
		s.parentNode.insertBefore(g,s);
		g.onload=function(){
			window.chatwootSDK.run({
				websiteToken: 'SWZh4kDwZJd9ks5JZN2pPLwv',
				baseUrl: BASE_URL
			})
		}
	})(document,"script");
</script>

</html>