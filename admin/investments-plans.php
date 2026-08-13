<?php require('config/session.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wrattrom - Investment schemes</title>
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
        <h3 class="page-title">Investment plans</h3>

        <div class="filter-action">
          <a href="#addNew" data-bs-toggle="modal" class="i-btn btn--primary btn--md"><i class='las la-plus'></i> Add New
            Plan</a>
        </div>
        <div class="card">
          <div class="responsive-table">
            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Investment Limit</th>
                  <th>Interest</th>
                  <th>Time</th>
                  <th>Recommend</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $count = 1;
                foreach ($Authroller->allPlans() as $key => $value) {
                  ?>
                <tr id="tRow<?php echo $value['id']; ?>">
                  <td data-label="Initiated At">
                    <span><?php echo $count; ?></span>
                  </td>
                  <td data-label="Name">
                    <span><?php echo $value['name']; ?></span>
                  </td>
                  <td data-label="Investment Limit">
                    <?php echo '$'.$value['min_limit'].' - $'.$value['max_limit']; ?>
                  </td>
                  <td data-label="Interest">
                    <?php echo $value['interest'].'%'; ?>
                  </td>
                  <td data-label="Time">
                    <?php echo $value['duration']; ?> Days
                  </td>
                  <td data-label="Recommend">
                    <?php
                    if ( $value['recomend'] == 1 ) echo 'Yes';
                    else echo 'No';
                    ?>
                  </td>
                  <td data-label="Action">
                    <a href="javascript:void(0)"
                      class="edit-plan"
                      data-id="<?php echo $value['id']; ?>"
                      data-name="<?php echo $value['name']; ?>"
                      data-duration="<?php echo $value['duration']; ?>"
                      data-interest="<?php echo $value['interest']; ?>"
                      data-min_limit="<?php echo $value['min_limit']; ?>"
                      data-max_limit="<?php echo $value['max_limit']; ?>"
                      data-description="<?php echo $value['description']; ?>">
                      <span>Edit</span>
                    </a>
                    <a href="javascript:void(0)"
                      data-id="<?php echo $value['id']; ?>"
                      class="text-danger mx-1 delete-btn">
                      <span>Delete</span>
                    </a>
                  </td>
                </tr>
                  <?php
                  $count++;
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
  <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="planForm" action="#" class="modal-content">
        <div class="modal-header">
          <h5>New Investment Plan</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">Enter plan details below</p>
          <div class="form-item mb-3">
            <label class="form-label">Plan name</label>
            <input type="text" name="name" class="form-control" required />
          </div>
          <div class="form-item mb-3">
            <label class="form-label">Duration <small>(Number of days)</small></label>
            <input type="number" min="5" name="duration" class="form-control" required />
          </div>
          <div class="form-item mb-3">
            <label class="form-label">Interest</label>
            <input type="text" name="interest" class="form-control" required />
            <small>This percentage of the capital will be earned daily.</small>
          </div>
          <div class="row mb-3">
            <div class="col-6 form-item">
              <label class="form-label">Minimum amount</label>
              <input type="number" name="min_limit" min="10" class="form-control" required />
            </div>
            <div class="col-6 form-item">
              <label class="form-label">Maximum amount</label>
              <input type="number" name="max_limit" min="10" class="form-control" required />
            </div>
          </div>
          <div class="form-item mb-3">
            <label class="form-label">Description</label>
            <textarea type="text" name="desc" class="form-control" required></textarea>
          </div>
          <div class="form-item mb-3">
            <label class="form-label" id="recomend"><input type="checkbox" name="recomend" /> Recommend plan</label>
            <input type="hidden" id="query_type" name="new_plan">
          </div>
        </div>
        <div class="modal-footer">
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
          <p class="text--danger m-0">Are you sure you want to delete this plan?</p>
          <input type="hidden" name="delete_plan" value="">
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
    $(".edit-plan").click(function(){
      $("#query_type").attr('name', 'edit_plan');
      const id = $(this).data('id');
      const name = $(this).data('name');
      const duration = $(this).data('duration');
      const interest = $(this).data('interest');
      const min_limit = $(this).data('min_limit');
      const max_limit = $(this).data('max_limit');
      const description = $(this).data('description');
      // Set values to modal input
      $('#addNew input[name="name"]').val(name);
      $('#addNew input[name="duration"]').val(duration);
      $('#addNew input[name="interest"]').val(interest);
      $('#addNew input[name="min_limit"]').val(min_limit);
      $('#addNew input[name="max_limit"]').val(max_limit);
      $('#addNew textarea[name="desc"]').val(description);
      $('#addNew input[name="edit_plan"]').val(id);
      // Popup the modal
      $("#recomend").hide(0);
      $("#addNew").modal('show');
    });

    $(".delete-btn").click(function() {
      const id = $(this).data('id');
      $("#confirmModal input[name='delete_plan']").val(id)
      $("#confirmModal").modal('show');
    });
  </script>
  <?php
  if ( isset($_GET['message']) ) {
    ?>
      <script>
        notify('success', '<?php echo $_GET["message"] ?>');
      </script>
    <?php
  }
  ?>
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