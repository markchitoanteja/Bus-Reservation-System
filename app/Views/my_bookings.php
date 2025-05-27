<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Bookings — Eastern Goldtrans</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/dist/home/css/style.css?v=1.1.6" />

    <style>
        /* Base layout setup */
        html,
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        footer {
            margin-top: auto;
            background-color: #212529;
            color: #fff;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-light fw-bold" href="/">
                <img src="public/dist/img/logo.png" alt="Logo" width="40" class="me-2" /> Eastern Goldtrans Tours
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#booking">Book</a></li>
                    <li class="nav-item dropdown">
                        <?php if (session()->get("user")) : ?>
                            <a class="nav-link text-light active" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                                <span class="d-none d-md-inline"><?= session()->get("user")["name"] ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" id="editProfileBtn">
                                        <i class="fa fa-user-edit me-2"></i> Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item active" href="javascript:void(0)">
                                        <i class="fas fa-ticket-alt me-2"></i> My Bookings
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" id="logoutBtn">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        <?php else: ?>
                            <a class="nav-link text-light" href="javascript:void(0)" id="accountBtn">Account</a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="pt-5 mt-5">
        <div class="container py-5">
            <div class="mb-4">
                <h2 class="text-center">My Bookings</h2>
                <p class="text-center text-muted fst-italic">
                    This section is currently in prototype mode. Features and content are subject to change.
                </p>
            </div>

            <?php if (session()->get("user")) : ?>
                <div class="alert alert-info text-center shadow-sm">
                    <i class="fas fa-info-circle me-2"></i> Booking details will be available soon.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Booking ID</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>Travel Date</th>
                                <th>Passengers</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <em><i class="fas fa-clock me-2"></i>Booking records will be shown here once available.</em>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i> Please log in to view your bookings.
                </div>
            <?php endif ?>
        </div>
    </main>

    <footer class="text-center py-4 bg-dark text-light">
        <div class="container">
            <p class="mb-1">&copy; 2025 Eastern Goldtrans Tours Inc. All rights reserved.</p>
        </div>
    </footer>

    <?php if (session()->get("user")) : ?>
        <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateProfileModalLabel">Edit your Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="updateProfileForm" novalidate>
                            <!-- Error Alert -->
                            <div class="alert alert-danger text-center d-none" id="updateProfileErrorAlert" role="alert">
                                Failed to update profile. Please try again.
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="updateName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="updateName" required>
                                <div class="invalid-feedback">Please enter a valid name.</div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="updateEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="updateEmail" required>
                                <div class="invalid-feedback">Please enter a valid email.</div>
                                <div class="invalid-feedback d-none" id="emailExistsFeedback">Email already exists.</div>
                            </div>

                            <!-- Password (Optional) -->
                            <div class="mb-3">
                                <label for="updatePassword" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="updatePassword">
                                <small class="form-text text-muted">Leave blank to keep your current password.</small>
                                <div class="invalid-feedback">Password is invalid.</div>
                            </div>

                            <!-- Confirm Password (Required only if Password is filled) -->
                            <div class="mb-3">
                                <label for="updateConfirmPassword" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="updateConfirmPassword">
                                <div class="invalid-feedback" id="confirmPasswordRequired">Confirm password is required when changing your password.</div>
                                <div class="invalid-feedback d-none" id="confirmPasswordMismatch">Passwords do not match.</div>
                            </div>

                            <!-- Hidden User ID -->
                            <input type="hidden" id="updateUserId" value="<?= session()->get('user')['id'] ?>" />
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100" id="updateProfileSubmitBtn" form="updateProfileForm">
                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="updateProfileLoadingSpinner"></span>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        const notification = <?php echo json_encode(session()->getFlashdata()); ?>;
        const user = <?php echo json_encode(session()->get("user")); ?>;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            if (notification && Object.keys(notification).length > 0) {
                displayPopupMessage(notification.message, notification.type);
            }

            $("#editProfileBtn").click(function() {
                $("#updateName").val(user.name);
                $("#updateEmail").val(user.email);
                $("#updateRole").val(user.user_type);

                $("#updateProfileModal").modal("show");
            });

            // Handle logout button click
            $('#logoutBtn').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('<?= base_url('logout') ?>', function(response) {
                            if (response.success) {
                                window.location.href = '<?= base_url() ?>';
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        }, 'json');
                    }
                });
            });

            // Update Profile Form Validation
            const $updateProfileForm = $('#updateProfileForm');

            if ($updateProfileForm.length) {
                const $modal = $('#updateProfileModal');

                const $name = $('#updateName');
                const $email = $('#updateEmail');
                const $password = $('#updatePassword');
                const $confirmPassword = $('#updateConfirmPassword');
                const $submitBtn = $('#updateProfileSubmitBtn');
                const $spinner = $('#updateProfileLoadingSpinner');

                const $confirmPasswordRequired = $('#confirmPasswordRequired');
                const $confirmPasswordMismatch = $('#confirmPasswordMismatch');
                const $emailExistsFeedback = $('#emailExistsFeedback');
                const $errorAlert = $('#updateProfileErrorAlert');
                const $userId = $('#updateUserId');

                $updateProfileForm.on('submit', function(e) {
                    e.preventDefault();
                    let valid = true;

                    // Clear previous error messages
                    $emailExistsFeedback.addClass('d-none');
                    $errorAlert.addClass('d-none');

                    const nameVal = $name.val().trim();
                    const emailVal = $email.val().trim();
                    const passVal = $password.val().trim();
                    const confirmVal = $confirmPassword.val().trim();

                    // Name validation
                    if (!nameVal) {
                        $name.addClass('is-invalid');
                        valid = false;
                    } else {
                        $name.removeClass('is-invalid');
                    }

                    // Email validation
                    if (!emailVal || !$email[0].checkValidity()) {
                        $email.addClass('is-invalid');
                        valid = false;
                    } else {
                        $email.removeClass('is-invalid');
                    }

                    // Password + Confirm Password validation
                    if (passVal || confirmVal) {
                        if (!confirmVal) {
                            $confirmPassword.addClass('is-invalid');
                            $confirmPasswordRequired.removeClass('d-none');
                            $confirmPasswordMismatch.addClass('d-none');
                            valid = false;
                        } else if (passVal !== confirmVal) {
                            $confirmPassword.addClass('is-invalid');
                            $confirmPasswordRequired.addClass('d-none');
                            $confirmPasswordMismatch.removeClass('d-none');
                            valid = false;
                        } else {
                            $confirmPassword.removeClass('is-invalid');
                            $confirmPasswordRequired.addClass('d-none');
                            $confirmPasswordMismatch.addClass('d-none');
                        }
                    } else {
                        // If both are empty, it's allowed
                        $password.removeClass('is-invalid');
                        $confirmPassword.removeClass('is-invalid');
                        $confirmPasswordRequired.addClass('d-none');
                        $confirmPasswordMismatch.addClass('d-none');
                    }

                    if (!valid) return;

                    // Start modal loading
                    startModalLoading($modal, $submitBtn, $spinner);

                    const formData = new FormData();
                    formData.append('id', $userId.val());
                    formData.append('name', nameVal);
                    formData.append('email', emailVal);

                    if (passVal) {
                        formData.append('password', passVal);
                    }

                    $.ajax({
                        url: 'update_profile',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'JSON',
                        success: function(response) {
                            stopModalLoading($modal, $submitBtn, $spinner);

                            if (!response.success) {
                                if (response.error_type === "email_exists") {
                                    $email.addClass("is-invalid");
                                    $emailExistsFeedback.removeClass("d-none").text("This email is already associated with another account.");
                                } else {
                                    $("#updateProfileErrorAlert").addClass("d-block").removeClass("d-none");
                                }
                            } else {
                                location.reload();
                            }
                        },
                        error: function(_, _, error) {
                            stopModalLoading($modal, $submitBtn, $spinner);
                            console.error(error);
                            $errorAlert.removeClass('d-none').addClass('d-block');
                        }
                    });
                });

                // Real-time field validation

                $name.on('input change', function() {
                    $(this).val().trim() ?
                        $(this).removeClass('is-invalid') :
                        $(this).addClass('is-invalid');
                });

                $email.on('input change', function() {
                    const isValid = $(this).val().trim() && this.checkValidity();
                    if (isValid) {
                        $(this).removeClass('is-invalid');
                        $emailExistsFeedback.addClass('d-none');
                    } else {
                        $(this).addClass('is-invalid');
                    }
                });

                $password.on('input change', function() {
                    const passVal = $(this).val().trim();
                    const confirmVal = $confirmPassword.val().trim();

                    if (!passVal && !confirmVal) {
                        $(this).removeClass('is-invalid');
                        $confirmPassword.removeClass('is-invalid');
                        $confirmPasswordRequired.addClass('d-none');
                        $confirmPasswordMismatch.addClass('d-none');
                        return;
                    }

                    if (passVal && confirmVal && passVal !== confirmVal) {
                        $confirmPassword.addClass('is-invalid');
                        $confirmPasswordRequired.addClass('d-none');
                        $confirmPasswordMismatch.removeClass('d-none');
                    } else {
                        $confirmPassword.removeClass('is-invalid');
                        $confirmPasswordRequired.addClass('d-none');
                        $confirmPasswordMismatch.addClass('d-none');
                    }
                });

                $confirmPassword.on('input change', function() {
                    const confirmVal = $(this).val().trim();
                    const passVal = $password.val().trim();

                    if (!passVal && !confirmVal) {
                        $(this).removeClass('is-invalid');
                        $confirmPasswordRequired.addClass('d-none');
                        $confirmPasswordMismatch.addClass('d-none');
                        return;
                    }

                    if (!confirmVal && passVal) {
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
        });
    </script>
</body>

</html>