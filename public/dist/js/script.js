$(document).ready(function () {
    // Section Navigation Highlighting
    const $sections = $("section[id], header[id]");
    const $navLinks = $(".nav-link");

    let formSubmitting = false;

    if (notification && Object.keys(notification).length > 0) {
        displayPopupMessage(notification.message, notification.type);
    }

    $(document).on('hide.bs.modal', function (e) {
        if (formSubmitting) {
            e.preventDefault(); // Prevent closing
        }
    });

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
    const $promoModal = $('#promoModal');
    if ($promoModal.length) {
        $promoModal.on('show.bs.modal', function (event) {
            const $button = $(event.relatedTarget);
            const title = $button.data('title') || '';
            const content = $button.data('content') || '';
            const image = $button.data('image') || '';

            $('#promoModalTitle').text(title);
            $('#promoModalContent').text(content);
            $('#promoModalImg').attr({
                src: image,
                alt: title
            });
        });
    }

    // Fullscreen Image Modal Logic
    $('.promo-card img').css("cursor", "pointer").on('click', function () {
        const $img = $(this);
        $('#fullImage').attr({
            src: $img.attr("src"),
            alt: $img.attr("alt")
        });
        new bootstrap.Modal($('#fullImageModal')[0]).show();
    });

    // Account/Login Modal
    const $accountBtn = $('#accountBtn');
    const loginModalInstance = new bootstrap.Modal($('#loginModal')[0]);

    if ($accountBtn.length) {
        if (!user) {
            $accountBtn.on('click', function () {
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
    const $loginForm = $('#loginForm');
    if ($loginForm.length) {
        const $modal = $('#loginModal');
        const $email = $('#loginEmail');
        const $password = $('#loginPassword');
        const $role = $('#loginRole'); // Select input for user_type
        const $submitBtn = $('#loginSubmitBtn');
        const $spinner = $('#loginLoadingSpinner');

        $loginForm.on('submit', function (e) {
            e.preventDefault();

            let valid = true;

            // Validate email
            if (!$email.val() || !$email[0].checkValidity()) {
                $email.addClass('is-invalid');
                valid = false;
            } else {
                $email.removeClass('is-invalid');
            }

            // Validate password
            if (!$password.val()) {
                $password.addClass('is-invalid');
                valid = false;
            } else {
                $password.removeClass('is-invalid');
            }

            // Validate role selection
            if (!$role.val()) {
                $role.addClass('is-invalid');
                valid = false;
            } else {
                $role.removeClass('is-invalid');
            }

            if (!valid) return;

            // Start global loading animation
            startModalLoading($modal, $submitBtn, $spinner);

            // Prepare FormData
            const formData = new FormData();
            formData.append('email', $email.val());
            formData.append('password', $password.val());
            formData.append('user_type', $role.val()); // Add user_type

            // AJAX Request
            $.ajax({
                url: 'login',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
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
                            window.location.href = "admin";
                        } else {
                            location.reload(); // Regular users
                        }
                    }
                },
                error: function (_, _, error) {
                    stopModalLoading($modal, $submitBtn, $spinner);
                    console.error(error);
                }
            });
        });

        // Input field validation feedback
        [$email, $password, $role].forEach($input => {
            $input.on('input change', function () {
                $(this).val().trim()
                    ? $(this).removeClass('is-invalid')
                    : $(this).addClass('is-invalid');
            });
        });
    }

    // Sign Up Form Validation
    const $signUpForm = $('#signUpForm');
    if ($signUpForm.length) {
        const $modal = $('#loginModal');

        const $name = $("#registerName");
        const $email = $("#registerEmail");
        const $password = $("#registerPassword");
        const $confirmPassword = $("#registerConfirmPassword");
        const $submitBtn = $('#signUpSubmitBtn');
        const $spinner = $('#signUpLoadingSpinner');

        const $confirmPasswordRequired = $('#confirmPasswordRequired');
        const $confirmPasswordMismatch = $('#confirmPasswordMismatch');
        const $emailExistsFeedback = $('#emailExistsFeedback');

        $signUpForm.on('submit', function (e) {
            e.preventDefault();

            let valid = true;

            // Clear previous server-side error
            $emailExistsFeedback.addClass('d-none');

            // Name
            if (!$name.val().trim()) {
                $name.addClass('is-invalid');
                valid = false;
            } else {
                $name.removeClass('is-invalid');
            }

            // Email
            if (!$email.val().trim() || !$email[0].checkValidity()) {
                $email.addClass('is-invalid');
                valid = false;
            } else {
                $email.removeClass('is-invalid');
            }

            // Password
            if (!$password.val().trim()) {
                $password.addClass('is-invalid');
                valid = false;
            } else {
                $password.removeClass('is-invalid');
            }

            // Confirm Password
            const passVal = $password.val().trim();
            const confirmVal = $confirmPassword.val().trim();

            if (!confirmVal) {
                $confirmPassword.addClass('is-invalid');
                $confirmPasswordRequired.removeClass('d-none');
                $confirmPasswordMismatch.addClass('d-none');
                valid = false;
            } else if (confirmVal !== passVal) {
                $confirmPassword.addClass('is-invalid');
                $confirmPasswordRequired.addClass('d-none');
                $confirmPasswordMismatch.removeClass('d-none');
                valid = false;
            } else {
                $confirmPassword.removeClass('is-invalid');
                $confirmPasswordRequired.addClass('d-none');
                $confirmPasswordMismatch.addClass('d-none');
            }

            if (!valid) return;

            // Start global loading
            startModalLoading($modal, $submitBtn, $spinner);

            const formData = new FormData();
            formData.append('name', $name.val());
            formData.append('email', $email.val());
            formData.append('password', $password.val());

            $.ajax({
                url: 'signup',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    stopModalLoading($modal, $submitBtn, $spinner);

                    if (!response.success) {
                        if (response.error_type === "email_exists") {
                            $email.addClass("is-invalid");
                            $emailExistsFeedback.removeClass("d-none");
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
                }
            });
        });

        // Real-time validation
        $name.on('input change', function () {
            $(this).val().trim()
                ? $(this).removeClass('is-invalid')
                : $(this).addClass('is-invalid');
        });

        $email.on('input change', function () {
            const isValid = $(this).val().trim() && this.checkValidity();
            if (isValid) {
                $(this).removeClass('is-invalid');
                $emailExistsFeedback.addClass("d-none");
            } else {
                $(this).addClass('is-invalid');
            }
        });

        $password.on('input change', function () {
            const passVal = $(this).val().trim();
            passVal ? $(this).removeClass('is-invalid') : $(this).addClass('is-invalid');

            // Re-check confirm password
            const confirmVal = $confirmPassword.val().trim();
            if (confirmVal) {
                if (confirmVal !== passVal) {
                    $confirmPassword.addClass('is-invalid');
                    $confirmPasswordRequired.addClass('d-none');
                    $confirmPasswordMismatch.removeClass('d-none');
                } else {
                    $confirmPassword.removeClass('is-invalid');
                    $confirmPasswordRequired.addClass('d-none');
                    $confirmPasswordMismatch.addClass('d-none');
                }
            }
        });

        $confirmPassword.on('input change', function () {
            const confirmVal = $(this).val().trim();
            const passVal = $password.val().trim();

            if (!confirmVal) {
                $(this).addClass('is-invalid');
                $confirmPasswordRequired.removeClass('d-none');
                $confirmPasswordMismatch.addClass('d-none');
            } else if (confirmVal !== passVal) {
                $(this).addClass('is-invalid');
                $confirmPasswordRequired.addClass('d-none');
                $confirmPasswordMismatch.removeClass('d-none');
            } else {
                $(this).removeClass('is-invalid');
                $confirmPasswordRequired.addClass('d-none');
                $confirmPasswordMismatch.addClass('d-none');
            }
        });
    }

    // Booking Form Submission
    const $bookingForm = $("#booking form");
    if ($bookingForm.length) {
        const $from = $("#from");
        const $to = $("#to");
        const $date = $("#date");
        const $passenger = $("#passenger");

        // Handle form submit
        $bookingForm.on("submit", function (e) {
            e.preventDefault();
            let valid = true;

            // Basic empty check for all fields
            [$from, $to, $date, $passenger].forEach($input => {
                if (!$input.val().trim()) {
                    $input.addClass("is-invalid");
                    valid = false;
                } else {
                    $input.removeClass("is-invalid");
                }
            });

            // Check if origin and destination are the same, but only if both have values
            const fromVal = $from.val().trim().toLowerCase();
            const toVal = $to.val().trim().toLowerCase();

            if (fromVal && toVal && fromVal === toVal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Selection',
                    text: 'Origin and destination cannot be the same.',
                    confirmButtonText: 'OK'
                });
                $from.addClass("is-invalid");
                $to.addClass("is-invalid");
                valid = false;
            }

            // Check if date is not in the past
            const selectedDate = new Date($date.val());
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize to midnight for comparison

            if ($date.val().trim() && selectedDate < today) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date',
                    text: 'Please select a date that is today or later.',
                    confirmButtonText: 'OK'
                });
                $date.addClass("is-invalid");
                valid = false;
            }

            if (!valid) return;

            // Successful submission alert
            Swal.fire({
                icon: 'success',
                title: 'Booking Submitted',
                html: `Demo Booking:<br><strong>From:</strong> ${$from.val()}<br><strong>To:</strong> ${$to.val()}<br><strong>Date:</strong> ${$date.val()}<br><strong>Passengers:</strong> ${$passenger.val()}<br><br><em>This is a demo. Booking is not functional yet.</em>`,
                confirmButtonText: 'OK'
            });

            $bookingForm[0].reset();
        });

        // Real-time input validation
        [$from, $to, $date, $passenger].forEach($input => {
            $input.on("input change", function () {
                const value = $(this).val().trim();

                // Basic required field check
                if (value) {
                    $(this).removeClass("is-invalid");
                } else {
                    $(this).addClass("is-invalid");
                }

                // Extra check for from/to: if both filled and not equal, remove invalid styling
                const fromVal = $from.val().trim().toLowerCase();
                const toVal = $to.val().trim().toLowerCase();

                if (fromVal && toVal && fromVal !== toVal) {
                    $from.removeClass("is-invalid");
                    $to.removeClass("is-invalid");
                }
            });
        });
    }

    // Lazy Load Videos
    const $videos = $("video[data-src]");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
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
            confirmButtonText: 'OK',
            timer: 2000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    $("#logoutBtn").click(function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, log out',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'logout',
                    type: 'POST',
                    success: function () {
                        location.reload();
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            }
        });
    });
});