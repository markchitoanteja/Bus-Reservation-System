$(document).ready(function () {
  $("#editProfileBtn").click(function () {
    $("#updateName").val(user.name);
    $("#updateEmail").val(user.email);
    $("#updateRole").val(user.user_type);

    $("#updateProfileModal").modal("show");
  });

  // Update Profile Form Validation
  const $updateProfileForm = $("#updateProfileForm");

  if ($updateProfileForm.length) {
    const $modal = $("#updateProfileModal");

    const $name = $("#updateName");
    const $email = $("#updateEmail");
    const $password = $("#updatePassword");
    const $confirmPassword = $("#updateConfirmPassword");
    const $submitBtn = $("#updateProfileSubmitBtn");
    const $spinner = $("#updateProfileLoadingSpinner");

    const $confirmPasswordRequired = $("#confirmPasswordRequired");
    const $confirmPasswordMismatch = $("#confirmPasswordMismatch");
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
      const passVal = $password.val().trim();
      const confirmVal = $confirmPassword.val().trim();

      // Name validation
      if (!nameVal) {
        $name.addClass("is-invalid");
        valid = false;
      } else {
        $name.removeClass("is-invalid");
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
      formData.append("name", nameVal);
      formData.append("email", emailVal);

      if (passVal) {
        formData.append("password", passVal);
      }

      $.ajax({
        url: "update_profile",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (response) {
          stopModalLoading($modal, $submitBtn, $spinner);

          if (!response.success) {
            if (response.error_type === "email_exists") {
              $email.addClass("is-invalid");
              $emailExistsFeedback
                .removeClass("d-none")
                .text("This email is already associated with another account.");
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
