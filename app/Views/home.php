<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Eastern Goldtrans Tours Inc.</title>

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="public/dist/home/css/style.css?v=1.1.6" />
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-light fw-bold" href="#">
                <img src="public/dist/home/img/logo.png" alt="Logo" loading="lazy" width="40" class="me-2" /> Eastern Goldtrans Tours
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link text-light active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="#booking">Book</a></li>
                    <li class="nav-item dropdown">
                        <?php if (session()->get("user")) : ?>
                            <a class="nav-link text-light" href="javascript:void(0)" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-none d-md-inline">
                                    <?= session()->get("user")["name"] ?>
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountBtn">
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" id="editProfileBtn">
                                        <i class="fa fa-user-edit me-2"></i> Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="my_bookings">
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
                            <a class="nav-link text-light" href="javascript:void(0)" id="accountBtn">
                                Account
                            </a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="home" class="hero text-center d-flex align-items-center justify-content-center">
        <div class="container text-white">
            <h1 class="display-4 fw-bold">Eastern Goldtrans Tours</h1>
            <p class="lead">Serving Since 1994 — <strong>Serbisyong Ginto</strong> saan man <strong>Patungo</strong></p>
            <a href="#booking" class="btn btn-primary-theme btn-lg mt-3">Book Now</a>
        </div>
    </header>

    <section id="about" class="py-5 text-center bg-light">
        <div class="container">
            <h2 class="section-title mb-4">Why Choose Eastern Goldtrans?</h2>
            <p class="lead mx-auto" style="max-width: 750px;">
                Since <strong>1994</strong>, <strong>Eastern Goldtrans Tours Inc.</strong> has been a trusted name in transportation across Eastern Visayas.
                With over <strong>30 years</strong> of experience, we provide <span class="text-danger fw-semibold">safe</span>,
                <span class="text-danger fw-semibold">comfortable</span>, and <span class="text-danger fw-semibold">reliable</span> travel solutions for individuals, families, and groups.
            </p>
            <div class="row mt-5">
                <div class="col-md-4">
                    <h5 class="fw-bold">🚍 Modern Fleet</h5>
                    <p>Our buses are air-conditioned, GPS-enabled, and built for comfort to ensure a smooth ride every time.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">🛡 Trusted Safety</h5>
                    <p>We prioritize safety with well-maintained vehicles and experienced, courteous drivers.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">📲 Easy Booking</h5>
                    <p>Book your trip anytime, anywhere using our simple and secure online booking system.</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <p class="mx-auto" style="max-width: 750px;">
                        We don’t just move people — we connect communities. Whether you’re off on a business trip,
                        a family gathering, or a personal journey, Eastern Goldtrans is here to make every trip count.
                    </p>
                    <p class="small">
                        Visit our <a href="https://www.facebook.com/goldtranstoursofficial/" target="_blank" rel="noopener noreferrer">official Facebook page</a> for updates, promos, and travel tips.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="py-5 bg-white text-center">
        <div class="container">
            <h2 class="section-title mb-4">Promotions & Announcements</h2>
            <div class="row g-4">
                <div class="col-lg-12 mx-auto">
                    <div class="video-wrapper shadow rounded mb-4">
                        <div class="ratio ratio-16x9 rounded">
                            <iframe src="https://www.youtube.com/embed/BBXwadCYC08" title="Welcome to Eastern Goldtrans Tours Inc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen class="w-100 rounded"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mx-auto">
                    <div class="row g-4 justify-content-center">
                        <div class="col-sm-6 col-md-4">
                            <div class="promo-card shadow rounded overflow-hidden">
                                <img src="public/dist/home/img/promo1.jpg" loading="lazy" alt="Celebrating 50,000 Followers" class="img-fluid card-img" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="public/dist/home/img/promo1.jpg" data-alt="Celebrating 50,000 Followers" />
                                <div class="promo-content p-3 text-start">
                                    <h5 class="card-title mb-2">Celebrating 50,000 Followers!</h5>
                                    <p class="card-text">Thank you for helping us reach this amazing milestone on Facebook!</p>
                                    <button class="btn btn-link read-more-btn p-0" data-bs-toggle="modal" data-bs-target="#promoModal" data-title="Celebrating 50,000 Followers!" data-content="Thank you for helping us reach this amazing milestone on Facebook! We appreciate every like, share, and comment. Stay tuned for exclusive giveaways and more exciting updates." data-image="public/dist/home/img/promo1.jpg">Read More</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="promo-card shadow rounded overflow-hidden">
                                <img src="public/dist/home/img/promo2.jpg" alt="Long Weekend Booking" class="img-fluid card-img" loading="lazy" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="public/dist/home/img/promo2.jpg" data-alt="Long Weekend Booking" />
                                <div class="promo-content p-3 text-start">
                                    <h5 class="card-title mb-2">Pa Book Ka Na!</h5>
                                    <p class="card-text">Prepare for the upcoming long weekend this October. Secure your seat now!</p>
                                    <button class="btn btn-link read-more-btn p-0" data-bs-toggle="modal" data-bs-target="#promoModal" data-title="Pa Book Ka Na!" data-content="Get ready for the long weekend this October! Our trips fill up fast during holidays, so be sure to reserve your seat early to avoid the rush. Book now and travel stress-free!" data-image="public/dist/home/img/promo2.jpg">Read More</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="promo-card shadow rounded overflow-hidden">
                                <img src="public/dist/home/img/promo3.jpg" alt="New Terminal Coming Soon" loading="lazy" class="img-fluid card-img" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="public/dist/home/img/promo3.jpg" data-alt="New Terminal Coming Soon" />
                                <div class="promo-content p-3 text-start">
                                    <h5 class="card-title mb-2">Coming Soon: New Terminal</h5>
                                    <p class="card-text">Announcing new features and a better terminal experience for you.</p>
                                    <button class="btn btn-link read-more-btn p-0" data-bs-toggle="modal" data-bs-target="#promoModal" data-title="Coming Soon: New Terminal" data-content="We're building a more convenient and comfortable terminal for our passengers. Expect modern amenities, faster service, and a better overall experience — all launching soon!" data-image="public/dist/home/img/promo3.jpg">Read More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="py-5 bg-light">
        <div class="container form-section">
            <div class="text-center mb-4">
                <h2 class="section-title mb-0">Book a Ticket</h2>
                <small class="text-muted">Note: this is still not connected to the database.</small>
            </div>
            <form class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="from" class="form-label">From</label>
                        <input list="all-locations" class="form-control" id="from" placeholder="Select origin" required>
                    </div>
                    <div class="col-md-6">
                        <label for="to" class="form-label">To</label>
                        <input list="all-locations" class="form-control" id="to" placeholder="Select destination" required>
                    </div>
                    <datalist id="all-locations">
                        <!-- Manila Terminals -->
                        <option value="Sampaloc, Manila">
                        <option value="PITX, Manila">
                        <option value="Pasay, Manila">
                        <option value="Cubao, Quezon City">

                            <!-- Eastern Samar Towns -->
                        <option value="Oras">
                        <option value="Dolores">
                        <option value="Taft">
                        <option value="Sulat">
                        <option value="San Julian">
                        <option value="Borongan">
                    </datalist>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Travel Date</label>
                        <input type="date" id="date" class="form-control" min="" required>
                    </div>
                    <div class="col-md-6">
                        <label for="passenger" class="form-label">No. of Passengers</label>
                        <input type="number" class="form-control" id="passenger" min="1" value="1" required>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary-theme btn-lg">Search Buses</button>
                </div>
            </form>
        </div>
    </section>

    <footer class="text-center py-4 bg-dark text-light">
        <div class="container">
            <p class="mb-1">&copy; 2025 Eastern Goldtrans Tours Inc. All rights reserved.</p>
        </div>
    </footer>

    <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow">
                <img src="" alt="Promo Image" id="promoModalImg" class="w-100" style="object-fit:cover;max-height:300px;" />
                <div class="modal-body bg-white text-start p-4">
                    <h4 class="text-danger fw-bold mb-3" id="promoModalTitle"></h4>
                    <p class="text-dark" id="promoModalContent"></p>
                    <div class="text-end">
                        <button type="button" class="btn btn-primary-theme" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
            <div class="modal-content bg-black border-0">
                <div class="modal-body d-flex justify-content-center align-items-center">
                    <img src="" alt="Full Image" class="img-fluid" id="fullImage" />
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login to Your Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="loginFormDiv">
                        <form id="loginForm" novalidate>
                            <div class="alert alert-danger text-center d-none" id="loginErrorAlert" role="alert">
                                Invalid email or password. Please try again.
                            </div>
                            <div class="mb-3">
                                <label for="loginRole" class="form-label">Login as</label>
                                <select id="loginRole" class="form-select" required>
                                    <option value="user" selected>Passenger</option>
                                    <option value="admin">Administrator</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="loginEmail" required>
                                <div class="invalid-feedback">Please enter a valid email.</div>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="loginPassword" required>
                                <div class="invalid-feedback">Password is required.</div>
                            </div>
                        </form>
                    </div>
                    <div class="d-none" id="signUpFormDiv">
                        <form id="signUpForm" novalidate>
                            <div class="alert alert-danger text-center d-none" id="signUpErrorAlert" role="alert">
                                Failed to create user. Please try again.
                            </div>
                            <div class="mb-3">
                                <label for="registerName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="registerName" required>
                                <div class="invalid-feedback">Please enter a valid name.</div>
                            </div>
                            <div class="mb-3">
                                <label for="registerEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="registerEmail" required>
                                <div class="invalid-feedback">Please enter a valid email.</div>
                                <div class="invalid-feedback d-none" id="emailExistsFeedback">Email is already in use.</div>
                            </div>
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="registerPassword" required>
                                <div class="invalid-feedback">Password is required.</div>
                            </div>

                            <div class="mb-3">
                                <label for="registerConfirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="registerConfirmPassword" required>
                                <div class="invalid-feedback" id="confirmPasswordRequired">Confirm Password is required.</div>
                                <div class="invalid-feedback d-none" id="confirmPasswordMismatch">Passwords do not match.</div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100" id="loginSubmitBtn" form="loginForm">
                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="loginLoadingSpinner"></span>
                        Login
                    </button>

                    <button type="submit" class="btn btn-primary w-100 d-none" id="signUpSubmitBtn" form="signUpForm">
                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="signUpLoadingSpinner"></span>
                        Sign Up
                    </button>

                    <div class="w-100 text-center mt-2" id="passengerSignupPrompt">
                        <small>Don't have an account? <a href="javascript:void(0)" id="createAccountLink">Create one</a></small>
                    </div>

                    <div class="w-100 text-center mt-2 d-none" id="passengerLoginPrompt">
                        <small>Already have an account? <a href="javascript:void(0)" id="loginLink">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="public/dist/home/js/script.js?v=1.3.4"></script>
</body>

</html>