$(document).ready(function () {
  // $("#bookingsTable").DataTable({
  //   ordering: false,
  //   searching: false,
  //   paging: false,
  //   info: false,
  //   bordered: true,
  // });

  if (notification && Object.keys(notification).length > 0) {
    displayPopupMessage(notification.message, notification.type);
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

  // Handle logout button click
  $("#logoutBtn").on("click", function () {
    Swal.fire({
      title: "Are you sure?",
      text: "You will be logged out.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, logout",
      cancelButtonText: "No, cancel",
      customClass: {
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(
          "logout",
          function (response) {
            if (response.success) {
              window.location.href = "<?= base_url() ?>";
            } else {
              Swal.fire({
                title: "Error!",
                text: response.message,
                icon: "error",
              });
            }
          },
          "json"
        );
      }
    });
  });

  $(".view-booking, .cancel-booking").click(function () {
    Swal.fire({
      icon: "info",
      title: "Under Development",
      text: "This action is currently under development.",
      confirmButtonText: "OK",
      confirmButtonColor: "#3085d6",
      customClass: {
        confirmButton: "btn btn-primary ml-2",
        cancelButton: "btn btn-danger",
      },
    });
  });

  $("#editProfileBtn").click(function () {
    $("#updateName").val(user.name);
    $("#updateContact").val(user.contact_no);
    $("#updateEmail").val(user.email);
    $("#updateRole").val(user.user_type);

    $("#updateProfileModal").modal("show");
  });

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
    });
  }
});
