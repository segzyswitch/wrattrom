<?php require('config/session.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Wrattrom - Admin Dashboard</title>
	<link rel="shortcut icon" href="https://wrattrom.com/icon.png" type="image/x-icon">
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
			<div class="container-fluid px-0">
				<!-- <button id="right-sidebar-btn" class="right-sidebar-btn badge badge--primary avatar--md fs-20">
					<i class="bi bi-activity"></i>
				</button> -->
				<!-- <button type="button" class="btn btn--primary mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Setup
					Instructions</button> -->
				<div class="row g-4">
					<div class="col-md-6">
						<a href="	users" class="card card--hover mb-2 p-4">
							<div class="card-body">
								<div class="row align-items-center g-0">
									<div class="col-9">
										<h6 class="mb-0 fs-13 fw-normal text--muted">Total Users</h6>
										<h5 class="mb-1 mt-3"><?php echo count($Authroller->Users()); ?></h5>
									</div>
									<div class="col-3">
										<div class="bg--primary-light avatar--lg ms-auto me-0">
											<i class="las la-users text--primary fs-30"></i>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6">
						<a href="wallets" class="card card--hover mb-2 p-4">
							<div class="card-body">
								<div class="row align-items-center g-0">
									<div class="col-9">
										<h6 class="mb-0 fs-13 fw-normal text--muted">Assets</h6>
										<h5 class="mb-1 mt-3"><?php echo count($Authroller->allAssets()); ?></h5>
									</div>
									<div class="col-3">
										<div class="bg--pink-light avatar--lg ms-auto me-0">
											<i class="las la-credit-card text--pink fs-30"></i>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6">
						<a href="withdrawals" class="card card--hover mb-2 p-4">
							<div class="card-body">
								<div class="row align-items-center g-0">
									<div class="col-9">
										<h6 class="mb-0 fs-13 fw-normal text--muted">Total Withdrawals</h6>
										<h5 class="mb-1 mt-3"><?php echo count($Authroller->allWithdrawals()); ?></h5>
									</div>
									<div class="col-3">
										<div class="bg--info-light avatar--lg ms-auto me-0">
											<i class="las la-exchange-alt text--info fs-30"></i>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6">
						<a href="deposits" class="card card--hover mb-2 p-4">
							<div class="card-body">
								<div class="row align-items-center g-0">
									<div class="col-9">
										<h6 class="mb-0 fs-13 fw-normal text--muted">Total Depostis</h6>
										<h5 class="mb-1 mt-3"><?php echo count($Authroller->allDeposits()); ?></h5>
									</div>
									<div class="col-3">
										<div class="bg--info-light avatar--lg ms-auto me-0">
											<i class="las la-wallet text--info fs-30"></i>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-6">
						<a href="credits" class="card card--hover linear-card bg--linear-primary mb-2 p-4">
							<div class="card-body">
								<div class="row align-items-center g-0">
									<div class="col-9">
										<h6 class="mb-0 fs-13 fw-normal text-white">All Credits</h6>
										<h5 class="mb-1 mt-3 text-white"><?php echo count($Authroller->allCredits()); ?></h5>
									</div>
									<div class="col-3">
										<div class="bg--info-light avatar--lg ms-auto me-0">
											<i class="las la-wallet text--info fs-30"></i>
										</div>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
				<!-- <div class="row g-4">
					<div class="col-xxl-4 col-xl-4 col-lg-4">
						<div class="card mb-4">
							<div class="card-body position-relative">
								<div class="row g-2 mb-3">
									<div class="col-sm-12">
										<div class="card card--hover linear-card bg--linear-primary text-center h-100">
											<div class="card-body p-3">
												<h5 class="text-white opacity-75 fw-normal">Total Investments</h5>
												<h4 class="fw-bold mt-1 text-white fs-18">$22620</h4>
												<a href="investments" class="badge badge--outline"><i class="las la-arrow-circle-right fs-17"></i> View all</a>
											</div>
										</div>
									</div>
								</div>
								<ul class="list-group list-group-flush border-dashed mb-0">
									<li class="list-group-item px-0">
										<div class="d-flex">
											<div class="flex-grow-1 d-flex align-items-center gap-2">
												<i class="las la-wallet text--primary fs-24"></i>
												<h5 class="text--light fs-14">Running</h5>
											</div>
											<div class="flex-shrink-0 text-end">
												<h5 class="text--dark fs-14 fw-bold">$12920</h5>
											</div>
										</div>
									</li>
									<li class="list-group-item px-0">
										<div class="d-flex">
											<div class="flex-grow-1 d-flex align-items-center gap-2">
												<i class="las la-chart-line text--success fs-24"></i>
												<h5 class="text--light fs-14">Total Profits</h5>
											</div>
											<div class="flex-shrink-0 text-end">
												<h5 class="text--dark fs-14 fw-bold">$22797.32</h5>
											</div>
										</div>
									</li>
									<li class="list-group-item px-0">
										<div class="d-flex">
											<div class="flex-grow-1 d-flex align-items-center gap-2">
												<i class="las la-sort-amount-up text--info fs-24"></i>
												<h5 class="text--light fs-14">Completed</h5>
											</div>
											<div class="flex-shrink-0 text-end">
												<h5 class="text--dark fs-14 fw-bold">$0</h5>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xxl-4 col-xl-4 col-lg-4">
						<div class="card card-height-100 mb-4">
							<div class="card-header align-items-center d-flex">
								<h4 class="card-title mb-0 flex-grow-1">Deposit Statistics</h4>
							</div>

							<div class="card-body">
								<div class="text-center bg--success-light mb-3 p-4">
									<p class="text--success fs-14">Total Deposits</p>
									<h5 class="fw-bold mt-2 text--dark fs-17">$165975</h5>
								</div>
								<div class="d-flex flex-row justify-content-between flex-wrap gap-2">
									<div class="d-flex flex-column align-items-center flex-grow-1 bg--info-light">
										<div class="text-center p-3 w-100">
											<p class="text--info fs-12">Pending Deposits</p>
											<h5 class="fw-bold mt-2 text--dark">$39375</h5>
										</div>
									</div>
									<div class="d-flex flex-column align-items-center flex-grow-1 bg--primary-light">
										<div class="text-center p-3 w-100">
											<p class="text--primary fs-12">Completed deposits</p>
											<h5 class="fw-bold mt-2 text--dark">$1000</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xxl-4 col-xl-4 col-lg-4">
						<div class="card card-height-100">
							<div class="card-header align-items-center d-flex">
								<h4 class="card-title mb-0 flex-grow-1">Withdrawals Statistics</h4>
							</div>

							<div class="card-body">
								<div class="text-center bg--danger-light mb-3 p-4">
									<p class="text--danger fs-14">Total Withdraw</p>
									<h5 class="fw-bold mt-2 text--dark fs-17">$24210</h5>
								</div>
								<div class="d-flex flex-row justify-content-between flex-wrap gap-2">
									<div class="d-flex flex-column align-items-center flex-grow-1 bg--light">
										<div class="text-center p-3 w-100">
											<p class="text--light fs-12">Pending Withdraw</p>
											<h5 class="fw-bold mt-2 text--dark">$6505</h5>
										</div>
									</div>
									<div class="d-flex flex-column align-items-center flex-grow-1 bg--pink-light">
										<div class="text-center p-3 w-100">
											<p class="text--pink fs-12">Rejected Withdraw</p>
											<h5 class="fw-bold mt-2 text--dark">$0</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> -->
			</div>

			<!--
			<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Setup Instructions</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<h5 class="mb-4">To ensure your application runs smoothly, make sure you have the necessary setting
								configured:</h5>
							<ol class="setup-list">
								<li>
									<strong class="my-2">Application Settings</strong>
									<ul>
										<li>General</li>
										<li>System Configuration</li>
										<li>Commission &amp; Charges</li>
										<li>KYC Configuration</li>
										<li>Plugin Configuration</li>
										<li>Automation</li>
										<li>System Update</li>
									</ul>
								</li>
								<li>
									<strong class="my-2">Notifications Settings</strong>
									<ul>
										<li>Global Templates.</li>
										<li>Notification Templates</li>
										<li>Setup Mail Gateway</li>
										<li>Sms Gateways</li>
									</ul>
								</li>
							</ol>
							<p><strong>Complete Application Settings:</strong> Ensure all other application settings are properly
								configured before running your site.</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			-->
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