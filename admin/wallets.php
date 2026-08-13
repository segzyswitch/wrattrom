<?php require('config/session.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wrattrom - Manage Wallets</title>
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
      <section>
        <h3 class="page-title">Manage Wallets</h3>
        <div class="filter-action">
          <a href="#addNew" data-bs-toggle="modal" onclick="newWallet()" class="i-btn btn--primary btn--md">
            <i class='fas fa-plus'></i> Add New Wallet
          </a>
        </div>
        <div class="card">
          <div class="responsive-table">
            <table>
              <thead>
                <tr>
                  <th>Wallet</th>
                  <th>Price</th>
                  <th>Market</th>
                  <th>Address</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($Authroller->Wallets() as $key => $value) {
                  $rate_change = $value['prev_price'] ? round(($value['price'] - $value['prev_price']) / $value['prev_price'] * 100, 2) : 0;
                  $value['rate_change'] = $rate_change >= 0 ? $rate_change : substr($rate_change, 1);
                  $value['rate_status'] = $rate_change >= 0 ? 'up' : 'down';
                  ?>
                <tr id="tRow<?php echo $value['id']; ?>">
                  <td data-label="Name" class="d-flex">
                    <img width="35" class="my-auto" src="<?php echo $value['icon'] ?>" />
                    <div class="my-auto lh-sm ps-2">
                      <small class="d-block"> <?php echo $value['name']; ?></small>
                      <small> <?php echo $value['shortname']; ?></small>
                    </div>
                  </td>
                  <td data-label="Wallet Address">
                    <span>$<?php echo number_format($value['price'], 2); ?></span>
                  </td>
                  <td data-label="Wallet Address">
                    <?php
                    if ( round($rate_change) > 0 ) {
                      ?><span class="bg-success text-white px-2 rounded-3">+<?php echo $rate_change; ?>%</span><?php
                    }else {
                      ?><span class="bg-danger text-white px-2 rounded-3"><?php echo $rate_change; ?>%</span><?php
                    }
                    ?>
                  </td>
                  <td data-label="Wallet Address">
                    <span><?php echo $value['wallet_address']; ?></span>
                  </td>
                  <td data-label="Action">
                    <a href='javascript:void(0)'
                      class="edit-payment"
                      data-id="<?php echo $value['id']; ?>"
                      data-name="<?php echo $value['name']; ?>"
                      data-price="<?php echo $value['price']; ?>"
                      data-address="<?php echo $value['wallet_address']; ?>">
                      <span>Edit</span>
                    </a>
                    <a href='javascript:void(0)'
                      data-id="<?php echo $value['id']; ?>"
                      class="text-danger mx-1 delete-btn">
                      <span>Delete</span>
                    </a>
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


  <!-- Modal -->
  <div class="modal fade" id="addNew" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="newWalletForm" action="#" class="modal-content">
        <div class="modal-header">
          <h5 id="modal-title">New Payment Method</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">Enter wallet details below</p>
          <div class="form-item mb-3 icon-input">
            <label class="form-label">Icon</label>
            <input type="file" name="image" class="form-control" />
          </div>
          <div class="form-item mb-3 qr-input">
            <label class="form-label">Qr code</label>
            <input type="file" name="qrcode" class="form-control" />
          </div>
          <div class="form-item mb-3 name-input">
            <label class="form-label">Wallet name</label>
            <input type="text" name="name" class="form-control" />
          </div>
          <div class="form-item mb-3">
            <label class="form-label">Short code</label>
            <input type="text" name="shortcode" class="form-control" />
          </div>
          <div class="form-item mb-3">
            <label class="form-label">Unit</label>
            <input type="text" name="unit" class="form-control" />
          </div>
          <div class="form-item mb-3 price-input">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control" />
          </div>
          <div class="form-item mb-3 wallet-input">
            <label class="form-label">Wallet address</label>
            <input type="text" name="wallet_address" class="form-control" />
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" id="query_type" name="add_wallet">
          <button type="button" class="btn text--danger me-auto" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn--primary submit-btn">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <!-- confirm modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="confirmForm" action="#" class="modal-content">
        <div class="modal-header">
          <h5>Confirm action</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body border-bottom">
          <p class="text--danger m-0" id="queryText">Are you sure you want to delete this payment method?</p>
          <input type="hidden" name="delete_wallet" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn text--muted me-auto" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn--danger submit-btn">Delete</button>
        </div>
      </form>
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
    function newWallet() {
      $("#query_type").attr('name', 'add_wallet');
      $(".icon-input").show(0);
      $("input").val("");
    }
    $(".edit-payment").click(function(){
      $("#query_type").attr('name', 'update_wallet');
      const id = $(this).data('id');
      const name = $(this).data('name');
      const address = $(this).data('address');
      const price = $(this).data('price');
      // Hide all form inputs
      $('#addNew .form-item').hide(0);
      // Set values to modal input
      $('#addNew .qr-input').val(name);
      $('#addNew .qr-input').show(0);
      $('#addNew .price-input input').val(price);
      $('#addNew .price-input').show(0);
      $('#addNew .wallet-input input').val(address);
      $('#addNew .wallet-input').show(0);
      $('#addNew input[name="update_wallet"]').val(id);
      // Popup the modal
      $(".icon-input").hide(0);
      // $(".modal-title").text("Edit Wallet");
      $("#addNew").modal('show');
    });

    $(".delete-btn").click(function() {
      const id = $(this).data('id');
      // return notify('success', id)
      $("#confirmModal input[name='delete_wallet']").val(id)
      $("#confirmModal").modal('show');
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