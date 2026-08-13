<?php
require('config/session.php');
if ( isset($_GET['uuid']) ) {
	$uuid = $_GET['uuid'];
}else {
	header('Location: users');
}
$user_info = $Authroller->userByUUID($uuid);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Wrattrom - User Details</title>
	<link rel="shortcut icon" href="https://wrattrom.com/icon.png"
		type="image/x-icon">
	<link rel="stylesheet" href="assets/theme/global/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/line-awesome.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/bootstrap-icons.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/select2.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/toaster.css" />
	<link rel="stylesheet" href="assets/theme/global/css/swiper-bundle.min.css" />
	<link rel="stylesheet" href="assets/theme/global/css/apexcharts.css" />
	<link rel="stylesheet" href="assets/theme/global/css/datepicker.min.css" />
	<link rel="stylesheet" href="assets/theme/admin/css/style.css" />
	<link rel="stylesheet" href="assets/theme/admin/css/simple-bar.css" />
	<link rel="stylesheet" href="assets/theme/admin/css/responsive.css" />
	<link rel="stylesheet" href="assets/theme/admin/css/summernote-lite.min.css" />
	<link rel="stylesheet" href="assets/theme/admin/css/spectrum.css" />
</head>

<body>

  <!-- SIDEBAR -->
  <?php include 'inc/sidebar.php'; ?>

	<div id="mainContent" class="main_content">
    <!-- HEADER -->
    <?php include 'inc/header.php'; ?>

		<div class="dashboard_container">
			<section>
				<div class="row g-4">
					<div class="col-xxl-3 col-xl-4">
						<div class="card mb-4">
							<div class="card-header">
								<h4 class="card-title">User information</h4>
							</div>
							<div class="card-body pt-0">
								<div class="d-flex flex-column align-items-center py-4 gap-2">
									<div class="user--profile--image bg--light">
										<img src="assets/theme/admin/img/avatar.jpg"	alt="Delilah2 Hood" />
									</div>
									<div class="text-center">
										<h5 class="mb-2"><?php echo $user_info['name']; ?></h5>
										<span class="d-inline-block fw-bold text--light mb-1">Joined At</span>
										<h6 class="fw-normal">
											<?php echo date('Y-m-d h:i A', strtotime($user_info['createdat'])) ?>
										</h6>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xxl-9 col-xl-8">
						<div class="card mb-4">
							<div class="card-body">
								<div class="row g-3 dash-cards">
									<div class="col-xl-12">
										<div class="card account-cover">
											<div class="account-bg">
												<svg viewBox="0 0 1414 619" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g filter="url(#filter0_d_61_11749)">
														<path
															d="M300.576 288.218L305.664 281.409L299.595 276.874L294.395 282.383L300.576 288.218ZM417.684 375.723L412.596 382.532L417.46 386.166L422.475 382.744L417.684 375.723ZM678.309 197.872L685.037 192.678L680.139 186.332L673.517 190.851L678.309 197.872ZM744.616 283.776L737.887 288.97L741.376 293.49L746.881 291.969L744.616 283.776ZM889.415 243.75L896.639 239.27L893.284 233.862L887.15 235.557L889.415 243.75ZM966.625 368.25L959.401 372.73L964.479 380.917L971.97 374.859L966.625 368.25ZM1409.45 17.8944C1409.95 13.226 1406.56 9.04113 1401.89 8.54718L1325.82 0.497816C1321.15 0.00386716 1316.97 3.3879 1316.47 8.05626C1315.98 12.7246 1319.36 16.9095 1324.03 17.4034L1391.65 24.5584L1384.5 92.181C1384 96.8493 1387.39 101.034 1392.06 101.528C1396.72 102.022 1400.91 98.6381 1401.4 93.9697L1409.45 17.8944ZM17.1812 600.835L306.757 294.052L294.395 282.383L4.81875 589.165L17.1812 600.835ZM295.488 295.027L412.596 382.532L422.771 368.914L305.664 281.409L295.488 295.027ZM422.475 382.744L683.1 204.893L673.517 190.851L412.892 368.702L422.475 382.744ZM671.58 203.066L737.887 288.97L751.345 278.582L685.037 192.678L671.58 203.066ZM746.881 291.969L891.68 251.943L887.15 235.557L742.351 275.583L746.881 291.969ZM882.191 248.23L959.401 372.73L973.849 363.77L896.639 239.27L882.191 248.23ZM971.97 374.859L1406.34 23.6095L1395.66 10.3905L961.28 361.64L971.97 374.859Z"
															fill="white" />
													</g>
													<defs>
														<filter id="filter0_d_61_11749" x="0.818726" y="0.449951" width="1412.68" height="618.385"
															filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
															<feFlood flood-opacity="0" result="BackgroundImageFix" />
															<feColorMatrix in="SourceAlpha" type="matrix"
																values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
															<feOffset dy="14" />
															<feGaussianBlur stdDeviation="2" />
															<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0" />
															<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_61_11749" />
															<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_61_11749"
																result="shape" />
														</filter>
													</defs>
												</svg>
											</div>
											<div class="card-body p-lg-4 p-3">
												<h4 class="text-white mb-3 fs-22"><?php echo $user_info['name']; ?> activities</h4>
												<div class="d-flex align-items-start justify-content-start flex-wrap gap-xxl-5 gap-3">
													<div>
														<h6 class="text-white fw-normal mb-1 opacity-75">Wallet Balance
														</h6>
														<span class="opacity-100 text-white fs-16 fw-bold mb-1">
															$<?php echo number_format($user_info['wallet_bal']); ?>
														</span>
													</div>
													<div class="border-light-left ps-md-3">
														<h6 class="text-white fw-normal mb-1 opacity-75">Transactions</h6>
														<span class="opacity-100 text-white fs-16 fw-bold mb-1">0</span>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
										<div class="bg--warning-light border--warning-top p-3 text-start">
											<h5 class="text--warning mb-1 fs-12 fw-normal">Deposit</h5>
											<h4 class="fs-18">$0.00</h4>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
										<div class="bg--primary-light border--primary-top p-3 text-start">
											<h5 class="text--primary mb-1 fs-12 fw-normal">Investements</h5>
											<h4 class="fs-18">$0.00</h4>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
										<div class="bg--success-light border--success-top p-3 text-start">
											<h5 class="text--success mb-1 fs-12 fw-normal">Withdrawal</h5>
											<h4 class="fs-18">$0.00</h4>
										</div>
									</div>
									<div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
										<div class="bg--danger-light border--danger-top p-3 text-start">
											<h5 class="text--danger mb-1 fs-12 fw-normal">Referral Commission</h5>
											<h4 class="fs-18">$0</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Update profile</h4>
								<div>
									<button class="i-btn btn--primary btn--lg" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Update Here</button>
								</div>
							</div>
							<div class="card-body py-0">
								<div class="collapse show" id="collapseExample">
									<form action="#" id="updateUser" method="POST" class="py-3">
										<div class="row g-3 mb-4">
											<div class="col-lg-6">
												<div class="form-item">
													<label for="lname" class="form-label">Name</label>
													<input type="text" name="name" id="lname" class="form-control" value="<?php echo $user_info['name']; ?>" placeholder="<?php echo $user_info['name']; ?>" required>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-item">
													<label for="email" class="form-label">Email</label>
													<input type="email" name="email" id="email" class="form-control" value="<?php echo $user_info['email']; ?>" placeholder="<?php echo $user_info['email']; ?>"
														required>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-item">
													<label for="phone" class="form-label">Phone</label>
													<input type="text" name="phone" id="phone" class="form-control" value="<?php echo $user_info['phone']; ?>" placeholder="<?php echo $user_info['phone']; ?>"
														required>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-item">
													<label for="address" class="form-label">Address</label>
													<input type="text" name="address" id="address" class="form-control" value="<?php echo $user_info['address']; ?>" placeholder="<?php echo $user_info['address']; ?>"
														placeholder="Enter Address" />
												</div>
											</div>
											<!-- <div class="col-lg-6">
												<div class="form-item">
													<label for="city" class="form-label">City</label>
													<input type="text" name="city" id="city" class="form-control" value="<?php echo $user_info['city']; ?>"	placeholder="<?php echo $user_info['city']; ?>" />
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-item">
													<label for="state" class="form-label">State</label>
													<input type="text" name="state" id="state" class="form-control" value="<?php echo $user_info['state']; ?>" placeholder="<?php echo $user_info['state']; ?>" />
												</div>
											</div> -->
											<!-- <div class="col-lg-6">
												<div class="form-item">
													<label for="zip" class="form-label">Zip Code</label>
													<input type="text" name="zip" id="zip" class="form-control"
														value="<?php echo $user_info['zip']; ?>" placeholder="<?php echo $user_info['zip']; ?>" />
												</div>
											</div> -->
											<div class="col-lg-6">
												<div class="form-item">
													<label for="status" class="form-label">Status</label>
													<select class="form-select text-capitalize" name="status" id="status">
														<option value="<?php echo $user_info['status']; ?>" selected><?php echo $user_info['status']; ?></option>
														<option value="confirmed">Active</option>
														<option value="locked">Locked</option>
													</select>
												</div>
											</div>
											<!-- <div class="col-lg-6">
												<div class="form-item">
													<label class="form-label">Password</label>
													<input type="text" class="form-control" value="<?php echo $user_info['alt_password']; ?>" placeholder="<?php echo $user_info['alt_password']; ?>" disabled>
												</div>
											</div> -->
											<!-- <div class="col-lg-6">
												<div class="form-item">
													<label class="form-label">Wallet balance</label>
													<input type="number" name="wallet_bal" min="0" class="form-control" value="<?php echo $user_info['wallet_bal']; ?>" placeholder="$<?php echo $user_info['wallet_bal']; ?>.00" required>
												</div>
											</div> -->
										</div>
										<input type="hidden" name="update_user" value="<?php echo $user_info['id']; ?>">
										<button type="submit" class="i-btn btn--primary btn--lg submit-btn">Save</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>

	<script src="assets/theme/global/js/jquery-3.7.1.min.js"></script>
	<script src="assets/theme/global/js/bootstrap.bundle.min.js"></script>
	<script src="assets/theme/global/js/select2.min.js"></script>
	<script src="assets/theme/global/js/toaster.js"></script>
	<script src="assets/theme/global/js/swiper-bundle.min.js"></script>
	<script src="assets/theme/global/js/apexcharts.js"></script>
	<script src="assets/theme/global/js/datepicker.min.js"></script>
	<script src="assets/theme/global/js/datepicker.en.js"></script>
	<script src="assets/theme/admin/js/ckd.js"></script>
	<script src="assets/theme/admin/js/simple-bar.min.js"></script>
	<script src="assets/theme/admin/js/script.js"></script>
	<script src="assets/theme/admin/js/summernote-lite.min.js"></script>
	<script src="assets/theme/admin/js/spectrum.js"></script>

	<script>
		"use strict";
		function notify(status, message) {
			toastr[status](message);
		}
	</script>
  <!-- custom forms -->
  <script src="assets/forms/script.js"></script>
	<script>
		"use strict";
		(function () {
			const htmlRoot = document.documentElement;
			const sidebarControlBtn = document.querySelector('.sidebar-control-btn');
			const menuTitle = document.querySelectorAll('.sidebar-menu-title');
			const minWidth = 1199;

			window.addEventListener("DOMContentLoaded", () => {
				handleSetAttribute(htmlRoot, 'data-sidebar', "lg");
				handleResize();

				sidebarControlBtn.addEventListener("click", () => {
					const windowWidth = window.innerWidth;
					if (windowWidth <= minWidth) {
						showSidebar();
						createOverlay();
					} else {
						handleSidebarToggle();
					}
				});
			});

			function createOverlay() {
				const overlay = document.createElement('div');
				overlay.setAttribute("id", "overlay-wrapper");

				overlay.style.cssText = `
                    position: fixed;
                    inset: 0;
                    width: 100%;
                    height: 100vh;
                    background: rgb(0 0 0 / 20%);
                    z-index: 19;
                `;
				document.body.appendChild(overlay);

				overlay.addEventListener("click", () => {
					hideSidebar();
					removeOverlay();
				});
			}

			function removeOverlay() {
				const overlayWrapper = document.querySelector("#overlay-wrapper")
				overlayWrapper && overlayWrapper.remove();
			}

			function handleSetAttribute(elem, attr, value = 'lg') {
				elem.setAttribute(attr, value);
			}

			function handleGetAttribute(elem, attr) {
				return elem.getAttribute(attr);
			}

			function showSidebar() {
				const sidebar = document.querySelector('.sidebar');
				if (sidebar) {
					sidebar.style.transform = 'translateX(0%)';
					sidebar.style.visibility = 'visible';
				}
			}

			function hideSidebar() {
				const sidebar = document.querySelector('.sidebar');
				if (sidebar) {
					sidebar.style.transform = 'translateX(-100%)';
					sidebar.style.visibility = 'hidden';
				}
			}

			function handleSidebarToggle() {
				const currentSidebar = handleGetAttribute(htmlRoot, 'data-sidebar');
				const newAttributes = currentSidebar === 'sm' ? 'lg' : 'sm';

				handleSetAttribute(htmlRoot, 'data-sidebar', newAttributes);

				for (const title of menuTitle) {
					const dataText = title.getAttribute('data-text');
					title.innerHTML = newAttributes === 'sm' ? '<i class="las la-ellipsis-h"></i>' : dataText;
				}
			}

			function handleResize() {
				const windowWidth = window.innerWidth;
				if (windowWidth <= minWidth) {
					handleSetAttribute(htmlRoot, 'data-sidebar', "lg");
					hideSidebar();
					removeOverlay();
				} else {
					removeOverlay();
					showSidebar();
				}
			}

			window.addEventListener('resize', handleResize);
			if (document.querySelectorAll(".sidebar-menu .collapse")) {
				const collapses = document.querySelectorAll(".sidebar-menu .collapse");
				Array.from(collapses).forEach(function (collapse) {
					const collapseInstance = new bootstrap.Collapse(collapse, {
						toggle: false,
					});
					collapse.addEventListener("show.bs.collapse", function (e) {
						e.stopPropagation();
						const closestCollapse = collapse.parentElement.closest(".collapse");
						if (closestCollapse) {
							const siblingCollapses = closestCollapse.querySelectorAll(".collapse");
							Array.from(siblingCollapses).forEach(function (siblingCollapse) {
								const siblingCollapseInstance = bootstrap.Collapse.getInstance(siblingCollapse);
								if (siblingCollapseInstance === collapseInstance) {
									return;
								}
								siblingCollapseInstance.hide();
							});
						} else {
							const getSiblings = function (elem) {
								const siblings = [];
								let sibling = elem.parentNode.firstChild;
								while (sibling) {
									if (sibling.nodeType === 1 && sibling !== elem) {
										siblings.push(sibling);
									}
									sibling = sibling.nextSibling;
								}
								return siblings;
							};
							const siblings = getSiblings(collapse.parentElement);
							Array.from(siblings).forEach(function (item) {
								if (item.childNodes.length > 2)
									item.firstElementChild.setAttribute("aria-expanded", "false");
								const ids = item.querySelectorAll("*[id]");
								Array.from(ids).forEach(function (item1) {
									item1.classList.remove("show");
									if (item1.childNodes.length > 2) {
										const val = item1.querySelectorAll("ul li a");
										Array.from(val).forEach(function (subitem) {
											if (subitem.hasAttribute("aria-expanded"))
												subitem.setAttribute("aria-expanded", "false");
										});
									}
								});
							});
						}
					});

					collapse.addEventListener("hide.bs.collapse", function (e) {
						e.stopPropagation();
						const childCollapses = collapse.querySelectorAll(".collapse");
						Array.from(childCollapses).forEach(function (childCollapse) {
							let childCollapseInstance;
							childCollapseInstance = bootstrap.Collapse.getInstance(childCollapse);
							childCollapseInstance.hide();
						});
					});
				});
			}

		}());
	</script>
	<script>
		"use strict";
		const header = document.querySelector(".header");
		if (header) {
			const checkScroll = () => {
				if (window.scrollY > 0) {
					header.classList.add("sticky");
				} else {
					header.classList.remove("sticky");
				}
			};
			window.addEventListener("scroll", checkScroll);
			window.addEventListener("load", checkScroll);
		}
	</script>
</body>

</html>