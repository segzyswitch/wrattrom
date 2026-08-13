<?php require('config/session.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wrattrom - Admin Settings</title>
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
      <section class="mt-3 rounded_box">
        <div class="container-fluid p-0 mb-3 pb-2">
          <div class="row d-flex align-items-start rounded">
            <div class="col-xxl-3 col-xl-4 col-lg-5 mb-30">
              <div class="card b-radius-5 overflow-hidden profile-card">
                <div class="card-body">
                  <div class="d-flex p-2 bg--lite--violet align-items-center mb-3 flex-column gap-2">
                    <div class="avatar avatar--xl">
                      <img src="assets/files/f1wopRAnc9Sza4L6.png" alt="Admin">
                    </div>
                    <div class="pl-3">
                      <h5 class="text--light m-0 p-0"><?php echo $admin_info['nickname'] ?></h5>
                    </div>
                  </div>
                  <ul class="list-group gap-1 mb-0">
                    <li
                      class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                      Name<span class="fw-normal"><?php echo $admin_info['nickname'] ?></span>
                    </li>
                    <li
                      class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                      Username<span class="fw-normal"><?php echo $admin_info['username'] ?></span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-xxl-9 col-xl-8 col-lg-7">
              <div class="card mb-3">
                <div class="p-3">
                  <ul class="nav nav-style-two nav-pills mb-1 gap-3 justify-content-center" id="pills-tab"
                    role="tablist">
                    <li class="nav-item flex-grow-1" role="presentation">
                      <button class=" nav-link w-100 text-center active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Profile Setting</button>
                    </li>
                    <li class="nav-item flex-grow-1" role="presentation">
                      <button class=" nav-link w-100 text-center" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Password Update</button>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                  <div class="card mb-4">
                    <div class="card-header">
                      <h4 class="card-title">Profile Update</h4>
                    </div>
                    <div class="card-body">
                      <form action="#" method="POST" enctype="multipart/form-data" id="updateAdminForm">
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text"
                            class="form-control" id="name"
                            value="<?php echo $admin_info['nickname'] ?>"
                            placeholder="Enter Name"
                            required name="nickname"
                          />
                        </div>
                        <div class="mb-3">
                          <label for="username" class="form-label">Username</label>
                          <input type="text"
                            class="form-control" id="username"
                            value="<?php echo $admin_info['username'] ?>"
                            name="username" required
                          />
                        </div>
                        <!-- <div class="mb-3">
                          <label for="image" class="form-label">Image</label>
                          <input type="file" class="form-control" id="image" name="image">
                        </div> -->
                        <!-- <div class="mb-3">
                          <label for="pasw1" class="form-label">Enter password to confirm</label>
                          <input type="text" class="form-control" id="pasw1" placeholder="******" name="password" required />
                        </div> -->
                        <input type="hidden" name="update_admin" value="true" />
                        <button type="submit" class="btn btn--primary btn--md submit-btn">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                  <div class="card">
                    <div class="card-header">
                      <h5>Password Update</h5>
                    </div>
                    <div class="card-body">
                      <form action="javascript:void(0)" method="post" id="changePasswordForm" class="needs-validation">
                        <div class="mb-3">
                          <label for="paswd1" class="form-label">Current Password <sup class="text-danger">*</sup></label>
                          <input type="password" class="form-control" id="paswd1" name="old_pass"
                            placeholder="Enter Current Password" required="" />
                        </div>
                        <div class="mb-3">
                          <label for="paswd2" class="form-label">New Password <sup class="text-danger">*</sup></label>
                          <input type="password" class="form-control" id="paswd2" name="new_pass" placeholder="Enter New Password" required="" />
                        </div>
                        <div class="mb-3">
                          <label for="paswd3" class="form-label">Confirm Password <sup class="text-danger">*</sup></label>
                          <input type="password" class="form-control" name="con_pass" id="paswd3" placeholder="Confirm New Password" required="" />
                        </div>
                        <input type="hidden" name="change_password" value="true" />
                        <button class="btn btn--primary btn--md">Save Changes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <footer>
      <div class="footer-content">
        <p>© 2024 Wrattrom. All rights reserved.</p>
        <div class="footer-right">
          <ul>
            <li><a href="https://support.kloudinnovation.com/" target="_blank">Support</a></li>
          </ul>
          <span>App-Version: 2.0</span>
        </div>
      </div>
    </footer>
  </div>
  
  <script src="assets/theme/global/js/jquery-3.7.1.min.js"></script>
  <script>
    
	// updateAdmin Form
	$("#updateAdminForm").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    	$("#updateAdminForm .submit-btn").addClass('disabled');
		    $("#updateAdminForm .submit-btn").html("Loading <i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    	$("#updateAdminForm .submit-btn").removeClass('disabled');
		    $("#updateAdminForm .submit-btn").html("Save Changes");
		    if ( data.search('success') !== -1 ) {
		    	notify('success', data);
					console.log(data);
          window.location.reload;
		    }else {
		    	notify('warning', data);
		    }
	    },
	    error: function() {
	    	$("#updateAdminForm .submit-btn").removeClass('disabled');
		    $("#updateAdminForm .submit-btn").html("Save Changes");
		    notify('danger', 'An unknown error occured, try again')
	    }
	  });
	});

	// changePassword Form
	$("#changePasswordForm").on('submit', function(){
	  event.preventDefault();

	  $.ajax({
	    url: "config/process.php",
	    type: "POST",
	    data: new FormData(this),
	    cache: false,
	    contentType: false,
	    processData: false,
	    beforeSend: function() {
	    	$("#changePasswordForm .submit-btn").addClass('disabled');
		    $("#changePasswordForm .submit-btn").html("Loading <i class='spinner-border spinner-border-sm'></i>");
	    },
	    success: function(data) {
	    	$("#changePasswordForm .submit-btn").removeClass('disabled');
		    $("#changePasswordForm .submit-btn").html("Save Changes");
		    if ( data.search('success') !== -1 ) {
		    	notify('success', data);
					console.log(data);
					// window.location.reload;
          $("#changePasswordForm")[0].reset();
		    }else {
		    	notify('warning', data);
		    }
	    },
	    error: function() {
	    	$("#changePasswordForm .submit-btn").removeClass('disabled');
		    $("#changePasswordForm .submit-btn").html("Save Changes");
		    notify('danger', 'An unknown error occured, try again')
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