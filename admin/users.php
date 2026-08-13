<?php require('config/session.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Wrattrom - Manage Users</title>
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
	<style>
		/* toggle-switch */
		.toggle-switch {
			display: inline-block;
			cursor: pointer;
			width: 38px;
			height: 18px;
			background-color: #eee;
			position: relative;
			border-radius: 15px;
		}
		.toggle-switch input { display: none; }
		.toggle-switch .switch-dot {
			width: 18px;
			height: 18px;
			background-color: #8a8a8a;
			border-radius: 50%;
			position: absolute;
			top: 0;
			left: 0;
			transition: all .3s;
		}
		.toggle-switch input:checked + .switch-dot {
			left: 20px;
			background-color: rgb(4, 179, 138);
		}
		table tr:nth-child(even) {
			background-color: rgba(0,0,0,.02)!important;
		}
	</style>
</head>

<body>

	<!-- SIDEBAR -->
	<?php include 'inc/sidebar.php'; ?>

	<div id="mainContent" class="main_content">
		<!-- HEADER -->
		<?php include 'inc/header.php'; ?>

		<div class="dashboard_container">
			<section>
				<h3 class="page-title">Manage Users</h3>

				<div class="card mb-4">
					<form action="javascript:void(0)" class="position-relative">
						<input type="search" id="search" class="form-control" style="padding-left:45px;" placeholder="Enter Wallet ID" />
						<label for="search" class="p-2 ps-3 text-muted" style="position:absolute;top:0;left:0;">
							<i class="bi bi-search h5"></i>
						</label>
					</form>
				</div>
				<div class="card">
					<div class="responsive-table">
						<table id="walletTable">
							<thead>
								<tr>
									<th>#WALLETID</th>
									<th>Name</th>
									<th>Location</th>
									<th>Withdrawal</th>
									<th>Wallet Balance</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($Authroller->Users() as $key => $value) {
									?>
								<tr>
									<td data-label="Wallet ID">
										<span><?php echo $value['wallet_id'] ?></span>
									</td>
									<td data-label="Name">
										<a href="user-details?uuid=<?php echo $value['wallet_id'] ?>"><?php echo $value['name'] ?></a>
									</td>
									<td data-label="Location">
										<span><?php 
										$user_id = $value['id'];
										$conn = $Authroller->conn;
										$query = $conn->prepare("SELECT * FROM account_session WHERE user_id='$user_id' ORDER BY id DESC");
										$query->execute();
										$lastLocation = $query->fetch();
										if ($lastLocation) print_r($lastLocation['country']);
										else echo $value['country'];
										?></span>
									</td>
									<td data-label="Withdrawal">
										<label class="toggle-switch">
											<input type="checkbox"
												onchange="modifyWithdrawal(<?php echo $value['id'] ?>, <?php echo $value['withdrawal'] ?>)"
												class="toggle-checkbox"
												<?php if ($value['withdrawal']=='true') echo 'checked';  ?>
											/>
											<span class="switch-dot"></span>
										</label>
										<i class="spinner-border spinner-border-sm switch-loader d-none"
											id="spinner<?php echo $value['id'] ?>">
										</i>
									</td>
									<td data-label="Wallet">$<?php echo number_format($Authroller->walletBalance($value['id']), 2) ?></td>
									<td data-label="Status">
										<span class="badge badge--success">Active</span>
									</td>
									<td data-label="Action">
										<p class="m-0"><a href="fund-wallet?uuid=<?php echo $value['wallet_id'] ?>">Fund wallet</a></p>
									</td>
								</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>

	<script src="assets/theme/global/js/jquery-3.7.1.min.js"></script>
	<script>
		// search
		$('#search').on('input', function () {
			const filter = $(this).val().toLowerCase();

			$('#walletTable tbody tr').each(function () {
				const walletId = $(this).find('td:eq(0)').text().toLowerCase();

				$(this).toggle(walletId.includes(filter));
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
		
		// Withdrawal Switch
		function modifyWithdrawal(userid, status) {
			const formdata = new FormData();
			formdata.append('withdrawal_status', userid);
			formdata.append('status', status);
			$.ajax({
				url: "config/process.php",
				type: "POST",
				data: formdata,
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(`#spinner${userid}`).removeClass('d-none');
					$(`#spinner${userid}`).addClass('d-inline-block');
				},
				success: function(data) {
					// return console.log(data.message)
					$(`#spinner${userid}`).removeClass('d-inline-block');
					$(`#spinner${userid}`).addClass('d-none');
					if ( data.search('success') !== -1 ) {
						notify('success', 'Withdrawal status updated!');
					}else {
						notify('warning', data);
					}
				},
				error: function() {
					$(`#spinner${userid}`).removeClass('d-inline-block');
					$(`#spinner${userid}`).addClass('d-none');
					notify('danger', 'An unknown error occured, try again')
				}
			});
		}

		$(document).ready(function () {
			$('.created-update').on('click', function () {
				const modal = $('#credit-add-return');
				const id = $(this).data('id');
				modal.find('input[name=id]').val(id);
				modal.modal('show');
			});

			$('.wallets').on('click', function () {
				$('.modal-pay-list').empty();
				const modal = $('#list-wallet');
				const walletData = $(this).data('id');
				const currency = "$";
				const walletProperties = ['primary_balance', 'investment_balance', 'trade_balance', 'practice_balance'];
				walletProperties.forEach(property => {
					const propertyName = property.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
					const balanceValue = currency + parseFloat(walletData[property]).toFixed(2);
					const listItem = `<li>
							<span>${propertyName}</span>
							<span>${balanceValue}</span>
							</li>`;

					modal.find('.modal-pay-list').append(listItem);
				});

				modal.modal('show');
			});
		});
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