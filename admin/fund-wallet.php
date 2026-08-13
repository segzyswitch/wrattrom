<?php
require('config/session.php');
if ( !isset($_GET['uuid']) ) {
  # code...
  header("Location: users");
  exit;
}
if ( $userData = $Authroller->userByUUID($_GET['uuid']) ) {
}else {
  header("Location: users");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wrattrom - Fund user wallet</title>
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
      <section class="row">
        <div class="col-sm-4">
          <div class="card b-radius-5 overflow-hidden profile-card">
            <div class="card-body">
              <div class="d-flex p-2 bg--lite--violet align-items-center mb-3 flex-column gap-2">
                <div class="avatar avatar--xl">
                  <img src="assets/theme/admin/img/avatar.jpg" alt="Admin">
                </div>
                <div class="pl-3 text-center">
                  <h5 class="text--light m-0 p-0 text-uppercase"><?php echo $userData['name']; ?></h5>
                  <small class="d-block"><?php echo $userData['email']; ?></small>
                </div>
              </div>
              <ul class="list-group gap-1 mb-0">
                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                  Wallet ID<span class="fw-normal"><?php echo $userData['wallet_id'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                  Wallet Balance<span class="fw-normal">$<?php echo number_format($Authroller->walletBalance($userData['id']), 2) ?></span>
                </li>
                <?php
                foreach ($Authroller->userAssets($userData['id']) as $key => $value) {
                  $rate_change = $value['prev_price'] ? round(($value['price'] - $value['prev_price']) / $value['prev_price'] * 100, 2) : 0;
                  $value['rate_change'] = $rate_change >= 0 ? $rate_change : substr($rate_change, 1);
                  $value['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
                  $value['volume_price'] = round($value['price'] * $value['volume'], 2);
                  ?>
                <li class="list-group-item d-none d-sm-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0 p-2 py-1">
                  <img src="<?php echo $value['icon'] ?>" width="30" class="rounded-circle" alt="" />
                  <div class="w-100 d-flex ps-2">
                    <h5 class="my-auto"><?php echo $value['name'] ?></h5>
                    <div class="my-auto ms-auto text-end">
                      <small class="fw-normal d-block"><?php echo $value['volume']." ".$value['unit'] ?></small>
                      <small class="fw-normal d-block">$<?php echo number_format($value['volume_price'], 2) ?></small>
                    </div>
                  </div>
                </li>
                  <?php
                }
                ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="card mb-4">
            <div class="card-header d-block">
              <h4 class="mb-1">Fund wallet</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="users">Users</a></li>
                  <li class="breadcrumb-item active">Fund wallet</li>
                </ol>
              </nav>
              <!-- <h4 class="card-title">Profile Update</h4> -->
            </div>
            <div class="card-body">
              <form action="#" id="fundingForm" method="POST">
                <div class="mb-3">
                  <label for="asset" class="form-label">Select wallet</label>
                  <select name="asset" id="asset" class="form-control" required>
                    <option value="">Select wallet</option>
                    <?php
                    foreach ($Authroller->allAssets() as $key => $value) {
                      ?>
                      <option value="<?php echo $value['slug'] ?>"
                        data-unit="<?php echo $value['unit'] ?>"
                        data-price="<?php echo $value['price'] ?>">
                        <?php echo $value['name']." (".$value['shortname'].")"; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
                  <small class="text-success" id="descriptionText"></small>
                </div>
                <div class="mb-3">
                  <label for="amount" class="form-label">Amount ($)</label>
                  <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter amount in $" required />
                </div>
                <div class="mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select name="status" id="status" class="form-control" required>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                  </select>
                </div>
                <input type="hidden" name="user_id" value="<?php echo $userData['id']; ?>">
                <input type="hidden" name="fund_wallet" value="true">
                <button type="submit" class="btn btn--primary btn--md submit-btn">Fund wallet</button>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script>
  const openpage = document.querySelector('.sidebar-menu-link[href="#collapseInvControl"]');
  document.querySelector('#collapseInvControl').classList.add('show');
  openpage.classList.remove('collapse');
  openpage.classList.add('active');
  </script>

  <script src="assets/theme/global/js/jquery-3.7.1.min.js"></script>
  <script src="assets/forms/script.js"></script>
  <script>
    $('#asset').on('change', function () {
      const selectedOption = $(this).find('option:selected');
      if (!selectedOption.val()) {
      $('#descriptionText').text(``);
        return false;
      };
      const unit = selectedOption.data('unit') || '';
      const price = selectedOption.data('price') || '';
      const formatted = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      }).format(price);
      
      $('#descriptionText').text(`1 ${unit} is currently at ${formatted}`);
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
    function upcomingPaymentCount() {
      const elements = document.querySelectorAll('.payment_time');
      elements.forEach(function (element) {
        var profitTime = element.getAttribute('data-profit-time');
        var countDownDate = new Date(profitTime).getTime();

        var x = setInterval(function () {
          var now = new Date().getTime();
          var distance = countDownDate - now;

          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          element.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

          if (distance < 0) {
            clearInterval(x);
            element.innerHTML = "EXPIRED";
          }
        }, 1000);
      });
    }

    document.addEventListener('DOMContentLoaded', upcomingPaymentCount);
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