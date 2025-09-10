$(document).ready(function () {
  // Section Navigation Highlighting
  const $sections = $("section[id], header[id]");
  const $navLinks = $(".nav-link");

  let formSubmitting = false;

  if (notification && Object.keys(notification).length > 0) {
    displayPopupMessage(notification.message, notification.type);
  }

  $(document).on("hide.bs.modal", function (e) {
    if (formSubmitting) {
      e.preventDefault(); // Prevent closing
    }
  });

  setMinDateToTomorrow("#date");

  function setMinDateToTomorrow(selector) {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    $(selector).attr("min", tomorrow.toISOString().split("T")[0]);
  }

  function setActiveLinkByHash() {
    const hash = window.location.hash || "#home";
    $navLinks.removeClass("active");
    const $activeLink = $navLinks.filter(`[href='${hash}']`);
    if ($activeLink.length) {
      $activeLink.addClass("active");
    } else {
      $navLinks.filter("[href='#home']").addClass("active");
    }
  }

  function onScroll() {
    const scrollPos = $(window).scrollTop() + 100;
    let found = false;

    $sections.each(function () {
      const $section = $(this);
      const offsetTop = $section.offset().top;
      const offsetBottom = offsetTop + $section.outerHeight();

      if (scrollPos >= offsetTop && scrollPos < offsetBottom) {
        $navLinks.removeClass("active");
        $navLinks.each(function () {
          if ($(this).attr("href").includes($section.attr("id"))) {
            $(this).addClass("active");
          }
        });
        found = true;
        return false; // exit loop
      }
    });

    if (!found && scrollPos < 200) {
      $navLinks.removeClass("active");
      $navLinks.filter("[href='#home']").addClass("active");
    }
  }

  $(window).on("load hashchange", setActiveLinkByHash);
  $(window).on("scroll", onScroll);

  // Promo Modal: Populate content dynamically
  const $promoModal = $("#promoModal");
  if ($promoModal.length) {
    $promoModal.on("show.bs.modal", function (event) {
      const $button = $(event.relatedTarget);
      const title = $button.data("title") || "";
      const content = $button.data("content") || "";
      const image = $button.data("image") || "";

      $("#promoModalTitle").text(title);
      $("#promoModalContent").text(content);
      $("#promoModalImg").attr({
        src: image,
        alt: title,
      });
    });
  }

  // Fullscreen Image Modal Logic
  $(".promo-card img")
    .css("cursor", "pointer")
    .on("click", function () {
      const $img = $(this);
      $("#fullImage").attr({
        src: $img.attr("src"),
        alt: $img.attr("alt"),
      });
      new bootstrap.Modal($("#fullImageModal")[0]).show();
    });

  // Account/Login Modal
  const $accountBtn = $("#accountBtn");
  const loginModalInstance = new bootstrap.Modal($("#loginModal")[0]);

  if ($accountBtn.length) {
    if (!user) {
      $accountBtn.on("click", function () {
        loginModalInstance.show();
      });

      $("#loginRole").on("change", function () {
        const selectedRole = $(this).val();

        if (selectedRole === "admin") {
          $("#passengerSignupPrompt").addClass("d-none");
        } else {
          $("#passengerSignupPrompt").removeClass("d-none");
        }
      });

      $("#createAccountLink").click(function () {
        $("#loginFormDiv").addClass("d-none");
        $("#signUpFormDiv").removeClass("d-none");

        $("#passengerSignupPrompt").addClass("d-none");
        $("#passengerLoginPrompt").removeClass("d-none");

        $("#loginSubmitBtn").addClass("d-none");
        $("#signUpSubmitBtn").removeClass("d-none");

        $("#loginModalLabel").text("Create an Account");
      });

      $("#passengerLoginPrompt").click(function () {
        $("#loginFormDiv").removeClass("d-none");
        $("#signUpFormDiv").addClass("d-none");

        $("#passengerSignupPrompt").removeClass("d-none");
        $("#passengerLoginPrompt").addClass("d-none");

        $("#loginSubmitBtn").removeClass("d-none");
        $("#signUpSubmitBtn").addClass("d-none");

        $("#loginModalLabel").text("Login to Your Account");
      });
    }
  }

  // Login Form Validation
  const $loginForm = $("#loginForm");
  if ($loginForm.length) {
    const $modal = $("#loginModal");
    const $email = $("#loginEmail");
    const $password = $("#loginPassword");
    const $role = $("#loginRole"); // Select input for user_type
    const $submitBtn = $("#loginSubmitBtn");
    const $spinner = $("#loginLoadingSpinner");

    $loginForm.on("submit", function (e) {
      e.preventDefault();

      let valid = true;

      // Validate email
      if (!$email.val() || !$email[0].checkValidity()) {
        $email.addClass("is-invalid");
        valid = false;
      } else {
        $email.removeClass("is-invalid");
      }

      // Validate password
      if (!$password.val()) {
        $password.addClass("is-invalid");
        valid = false;
      } else {
        $password.removeClass("is-invalid");
      }

      // Validate role selection
      if (!$role.val()) {
        $role.addClass("is-invalid");
        valid = false;
      } else {
        $role.removeClass("is-invalid");
      }

      if (!valid) return;

      // Start global loading animation
      startModalLoading($modal, $submitBtn, $spinner);

      // Prepare FormData
      const formData = new FormData();
      formData.append("email", $email.val());
      formData.append("password", $password.val());
      formData.append("user_type", $role.val()); // Add user_type

      // AJAX Request
      $.ajax({
        url: "login",
        data: formData,
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function (response) {
          stopModalLoading($modal, $submitBtn, $spinner);

          if (!response.success) {
            $("#loginErrorAlert").addClass("d-block").removeClass("d-none");
          } else {
            const user_type = response.user_type;

            // Redirect based on user type
            if (user_type === "admin") {
              window.location.href = "admin/dashboard";
            } else {
              location.reload(); // Regular users
            }
          }
        },
        error: function (_, _, error) {
          stopModalLoading($modal, $submitBtn, $spinner);
          console.error(error);
        },
      });
    });

    // Input field validation feedback
    [$email, $password, $role].forEach(($input) => {
      $input.on("input change", function () {
        $(this).val().trim()
          ? $(this).removeClass("is-invalid")
          : $(this).addClass("is-invalid");
      });
    });
  }

  document
    .getElementById("registerContact")
    .addEventListener("input", function (e) {
      this.value = this.value.replace(/[^0-9]/g, ""); // Remove non-numeric characters
    });
  // Sign Up Form Validation
  const $signUpForm = $("#signUpForm");
  if ($signUpForm.length) {
    const $modal = $("#loginModal");

    const $name = $("#registerName");
    const $contact = $("#registerContact");
    const $email = $("#registerEmail");
    const $password = $("#registerPassword");
    const $confirmPassword = $("#registerConfirmPassword");
    const $submitBtn = $("#signUpSubmitBtn");
    const $spinner = $("#signUpLoadingSpinner");

    const $confirmPasswordRequired = $("#confirmPasswordRequired");
    const $confirmPasswordMismatch = $("#confirmPasswordMismatch");
    const $emailExistsFeedback = $("#emailExistsFeedback");
    const $contactExistsFeedback = $("#contactExistsFeedback");
    const $contactInvalidFeedback = $("#contactInvalidFeedback");

    $signUpForm.on("submit", function (e) {
      e.preventDefault();

      let valid = true;

      // Clear previous server-side error
      $emailExistsFeedback.addClass("d-none");

      // Name
      if (!$name.val().trim()) {
        $name.addClass("is-invalid");
        valid = false;
      } else {
        $name.removeClass("is-invalid");
      }

      // Contact Number
      const contactVal = $contact.val().trim(); // $contact = $("#registerContact")
      if (!/^9/.test(contactVal)) {
        // Must start with 9
        $contact.addClass("is-invalid");
        $contactInvalidFeedback
          .text(
            "Contact number must start with 9 and be 10 digits long (e.g., 9XXXXXXXXX)."
          )
          .removeClass("d-none");
      } else {
        // Valid
        $contact.removeClass("is-invalid");
        $contactInvalidFeedback.addClass("d-none");
      }

      // Email
      if (!$email.val().trim() || !$email[0].checkValidity()) {
        $email.addClass("is-invalid");
        valid = false;
      } else {
        $email.removeClass("is-invalid");
      }

      // Password
      if (!$password.val().trim()) {
        $password.addClass("is-invalid");
        valid = false;
      } else {
        $password.removeClass("is-invalid");
      }

      // Confirm Password
      const passVal = $password.val().trim();
      const confirmVal = $confirmPassword.val().trim();

      if (!confirmVal) {
        $confirmPassword.addClass("is-invalid");
        $confirmPasswordRequired.removeClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
        valid = false;
      } else if (confirmVal !== passVal) {
        $confirmPassword.addClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.removeClass("d-none");
        valid = false;
      } else {
        $confirmPassword.removeClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
      }

      if (!valid) return;

      // Start global loading
      startModalLoading($modal, $submitBtn, $spinner);

      const formData = new FormData();
      formData.append("name", $name.val());
      formData.append("email", $email.val());
      formData.append("contact", $contact.val());
      formData.append("password", $password.val());

      $.ajax({
        url: "signup",
        data: formData,
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function (response) {
          stopModalLoading($modal, $submitBtn, $spinner);

          if (!response.success) {
            if (response.error_type === "email_exists") {
              $email.addClass("is-invalid");
              $emailExistsFeedback.removeClass("d-none");
            } else if (response.error_type === "contact_exists") {
              $contact.addClass("is-invalid");
              $contactInvalidFeedback
                .text("Contact number is already in use.")
                .removeClass("d-none");
            } else {
              $("#signUpErrorAlert").addClass("d-block").removeClass("d-none");
            }
          } else {
            location.reload();
          }
        },
        error: function (_, _, error) {
          stopModalLoading($modal, $submitBtn, $spinner);
          console.error(error);
          $("#signUpErrorAlert").addClass("d-block").removeClass("d-none");
        },
      });
    });

    // Real-time validation
    $name.on("input change", function () {
      $(this).val().trim()
        ? $(this).removeClass("is-invalid")
        : $(this).addClass("is-invalid");
    });

    $contact.on("input change", function () {
      const val = $(this).val().trim();
      const isValid = /^9\d{9}$/.test(val); // must start with 9 and have 10 digits total

      if (!isValid) {
        // Must start with 9
        $contact.addClass("is-invalid");
        $contactInvalidFeedback
          .text(
            "Contact number must start with 9 and be 10 digits long (e.g., 9XXXXXXXXX)."
          )
          .removeClass("d-none");
      } else {
        // Valid
        $contact.removeClass("is-invalid");
        $contactInvalidFeedback.addClass("d-none");
      }
    });

    $email.on("input change", function () {
      const isValid = $(this).val().trim() && this.checkValidity();
      if (isValid) {
        $(this).removeClass("is-invalid");
        $emailExistsFeedback.addClass("d-none");
      } else {
        $(this).addClass("is-invalid");
      }
    });

    $password.on("input change", function () {
      const passVal = $(this).val().trim();
      passVal
        ? $(this).removeClass("is-invalid")
        : $(this).addClass("is-invalid");

      // Re-check confirm password
      const confirmVal = $confirmPassword.val().trim();
      if (confirmVal) {
        if (confirmVal !== passVal) {
          $confirmPassword.addClass("is-invalid");
          $confirmPasswordRequired.addClass("d-none");
          $confirmPasswordMismatch.removeClass("d-none");
        } else {
          $confirmPassword.removeClass("is-invalid");
          $confirmPasswordRequired.addClass("d-none");
          $confirmPasswordMismatch.addClass("d-none");
        }
      }
    });

    $confirmPassword.on("input change", function () {
      const confirmVal = $(this).val().trim();
      const passVal = $password.val().trim();

      if (!confirmVal) {
        $(this).addClass("is-invalid");
        $confirmPasswordRequired.removeClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
      } else if (confirmVal !== passVal) {
        $(this).addClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.removeClass("d-none");
      } else {
        $(this).removeClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
      }
    });
  }

  // Lazy Load Videos
  const $videos = $("video[data-src]");
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const $video = $(entry.target);
        $video.attr("src", $video.data("src"));
        observer.unobserve(entry.target);
      }
    });
  });

  $videos.each(function () {
    observer.observe(this);
  });

  function startModalLoading($modal, $submitBtn, $spinner) {
    formSubmitting = true;
    $submitBtn.prop("disabled", true);
    $spinner.removeClass("d-none");
    $modal.find(".btn-close").hide(); // Hide close button
  }

  function stopModalLoading($modal, $submitBtn, $spinner) {
    formSubmitting = false;
    $submitBtn.prop("disabled", false);
    $spinner.addClass("d-none");
    $modal.find(".btn-close").show(); // Show close button
  }

  function displayPopupMessage(message, type = "info") {
    const validTypes = ["success", "error", "warning", "info", "question"];
    const icon = validTypes.includes(type) ? type : "info";

    Swal.fire({
      icon: icon,
      title: message,
      confirmButtonText: "OK",
      timer: 2000,
      timerProgressBar: true,
      showConfirmButton: false,
      toast: true,
      position: "top-end",
      customClass: {
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
      buttonsStyling: false, // disable SweetAlert default button styles
    });
  }

  $("#logoutBtn").click(function () {
    Swal.fire({
      title: "Are you sure?",
      text: "You will be logged out.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, log out!",
      customClass: {
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "logout",
          type: "POST",
          success: function () {
            location.reload();
          },
          error: function (_, _, error) {
            console.error(error);
          },
        });
      }
    });
  });

  $("#editProfileBtn").click(function () {
    $("#updateName").val(user.name);
    $("#updateContact").val(user.contact_no);
    $("#updateEmail").val(user.email);
    $("#updateRole").val(user.user_type);

    $("#updateProfileModal").modal("show");
  });

  // Update Profile Form Validation
  const $updateProfileForm = $("#updateProfileForm");

  if ($updateProfileForm.length) {
    const $modal = $("#updateProfileModal");

    const $name = $("#updateName");
    const $contact = $("#updateContact");
    const $email = $("#updateEmail");
    const $password = $("#updatePassword");
    const $confirmPassword = $("#updateConfirmPassword");
    const $submitBtn = $("#updateProfileSubmitBtn");
    const $spinner = $("#updateProfileLoadingSpinner");

    const $confirmPasswordRequired = $("#confirmPasswordRequired");
    const $confirmPasswordMismatch = $("#confirmPasswordMismatch");
    const $contactInvalidFeedback = $("#updateContactInvalidFeedback");
    const $emailExistsFeedback = $("#emailExistsFeedback");
    const $errorAlert = $("#updateProfileErrorAlert");
    const $userId = $("#updateUserId");

    $updateProfileForm.on("submit", function (e) {
      e.preventDefault();
      let valid = true;

      // Clear previous error messages
      $emailExistsFeedback.addClass("d-none");
      $errorAlert.addClass("d-none");

      const nameVal = $name.val().trim();
      const emailVal = $email.val().trim();
      const contactVal = $contact.val().trim();
      const passVal = $password.val().trim();
      const confirmVal = $confirmPassword.val().trim();

      // Name validation
      if (!nameVal) {
        $name.addClass("is-invalid");
        valid = false;
      } else {
        $name.removeClass("is-invalid");
      }

      // Contact Number
      if (!/^9/.test(contactVal)) {
        // Must start with 9
        $contact.addClass("is-invalid");
        $contactInvalidFeedback
          .text(
            "Contact number must start with 9 and be 10 digits long (e.g., 9XXXXXXXXX)."
          )
          .removeClass("d-none");
      } else {
        // Valid
        $contact.removeClass("is-invalid");
        $contactInvalidFeedback.addClass("d-none");
      }

      // Email validation
      if (!emailVal || !$email[0].checkValidity()) {
        $email.addClass("is-invalid");
        valid = false;
      } else {
        $email.removeClass("is-invalid");
      }

      // Password + Confirm Password validation
      if (passVal || confirmVal) {
        if (!confirmVal) {
          $confirmPassword.addClass("is-invalid");
          $confirmPasswordRequired.removeClass("d-none");
          $confirmPasswordMismatch.addClass("d-none");
          valid = false;
        } else if (passVal !== confirmVal) {
          $confirmPassword.addClass("is-invalid");
          $confirmPasswordRequired.addClass("d-none");
          $confirmPasswordMismatch.removeClass("d-none");
          valid = false;
        } else {
          $confirmPassword.removeClass("is-invalid");
          $confirmPasswordRequired.addClass("d-none");
          $confirmPasswordMismatch.addClass("d-none");
        }
      } else {
        // If both are empty, it's allowed
        $password.removeClass("is-invalid");
        $confirmPassword.removeClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
      }

      if (!valid) return;

      // Start modal loading
      startModalLoading($modal, $submitBtn, $spinner);

      const formData = new FormData();
      formData.append("id", $userId.val());
      formData.append("name", $name.val());
      formData.append("email", $email.val());
      formData.append("contact", $contact.val());

      if (passVal) {
        formData.append("password", passVal);
      }

      $.ajax({
        url: "updateProfile",
        data: formData,
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function (response) {
          stopModalLoading($modal, $submitBtn, $spinner);

          if (!response.success) {
            if (response.error_type === "email_exists") {
              $email.addClass("is-invalid");
              $emailExistsFeedback
                .removeClass("d-none")
                .text("This email is already associated with another account.");
            } else if (response.error_type === "contact_exists") {
              $contact.addClass("is-invalid");
              $contactInvalidFeedback
                .text("Contact number is already in use.")
                .removeClass("d-none");
            } else {
              $("#updateProfileErrorAlert")
                .addClass("d-block")
                .removeClass("d-none");
            }
          } else {
            location.reload();
          }
        },
        error: function (_, _, error) {
          stopModalLoading($modal, $submitBtn, $spinner);
          console.error(error);
          $errorAlert.removeClass("d-none").addClass("d-block");
        },
      });
    });

    // Real-time field validation

    $name.on("input change", function () {
      $(this).val().trim()
        ? $(this).removeClass("is-invalid")
        : $(this).addClass("is-invalid");
    });

    $contact.on("input change", function () {
      const val = $(this).val().trim();
      const isValid = /^9\d{9}$/.test(val); // must start with 9 and have 10 digits total

      if (!isValid) {
        // Must start with 9
        $contact.addClass("is-invalid");
        $contactInvalidFeedback
          .text(
            "Contact number must start with 9 and be 10 digits long (e.g., 9XXXXXXXXX)."
          )
          .removeClass("d-none");
      } else {
        // Valid
        $contact.removeClass("is-invalid");
        $contactInvalidFeedback.addClass("d-none");
      }
    });

    $email.on("input change", function () {
      const isValid = $(this).val().trim() && this.checkValidity();
      if (isValid) {
        $(this).removeClass("is-invalid");
        $emailExistsFeedback.addClass("d-none");
      } else {
        $(this).addClass("is-invalid");
      }
    });

    $password.on("input change", function () {
      const passVal = $(this).val().trim();
      const confirmVal = $confirmPassword.val().trim();

      if (!passVal && !confirmVal) {
        $(this).removeClass("is-invalid");
        $confirmPassword.removeClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
        return;
      }

      if (passVal && confirmVal && passVal !== confirmVal) {
        $confirmPassword.addClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.removeClass("d-none");
      } else {
        $confirmPassword.removeClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
      }
    });

    $confirmPassword.on("input change", function () {
      const confirmVal = $(this).val().trim();
      const passVal = $password.val().trim();

      if (!passVal && !confirmVal) {
        $(this).removeClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
        return;
      }

      if (!confirmVal && passVal) {
        $(this).addClass("is-invalid");
        $confirmPasswordRequired.removeClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
      } else if (confirmVal !== passVal) {
        $(this).addClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.removeClass("d-none");
      } else {
        $(this).removeClass("is-invalid");
        $confirmPasswordRequired.addClass("d-none");
        $confirmPasswordMismatch.addClass("d-none");
      }
    });
  }
});
