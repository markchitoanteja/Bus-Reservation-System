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
    <style>
        .button-row {
            display: flex;
            flex-wrap: nowrap;
            /* Prevent wrapping */
            overflow-x: auto;
            /* Enable horizontal scroll on small screens */
            gap: 8px;
            /* Space between buttons */
            margin-bottom: 10px;
        }

        .button-row .btn-wrapper-with-cr {
            flex: 0 0 calc((100% - 40px) / 5);
            /* 6 items with 8px gap between each */
            text-align: center;
        }

        .button-row .btn-wrapper-without-cr {
            flex: 0 0 calc((100% - 40px) / 6);
            /* 6 items with 8px gap between each */
            text-align: center;
        }

        .button-row .btn {
            width: 100%;
        }

        .button-row .btn-wrapper-with-cr.two-col {
            flex: 0 0 calc((100% - 40px) / 5 * 2 + 8px);
            /* Span two normal columns (+1 gap) */
        }

        .button-row .btn-wrapper-without-cr.three-col {
            flex: 0 0 calc((100% - 40px) / 6 * 3 + 16px);
            /* Span 3 columns + 2 gaps of 8px each */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-light fw-bold" href="/">
                <img src="public/dist/home/img/logo.png" alt="Logo" width="40" class="me-2" /> Eastern Goldtrans Tours
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#gallery">Gallery</a>
                    </li>
                    <li class="nav-item"><a class="nav-link text-light" href="<?= base_url() ?>#booking">Book</a></li>
                    <li class="nav-item dropdown">
                        <?php if ( session()->get( "user" ) ) : ?>
                            <a class="nav-link text-light active" href="javascript:void(0)" role="button"
                                data-bs-toggle="dropdown">
                                <span class="d-none d-md-inline"><?= session()->get( "user" )[ "name" ] ?></span>
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
                        <?php else : ?>
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
            </div>

            <div class="table-responsive">
                <table id="bookingsTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>Booking Reference</th>
                            <th>Booking Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $myBookings = getMyBookings(); ?>

                        <?php if ( !empty( $myBookings ) ) : ?>
                            <?php foreach ( $myBookings as $myBooking ) : ?>
                                <?php
                                $fare = ( $myBooking[ 'bus_type' ] === '2x2 Aircon with CR, 45-seater' )
                                    ? $myBooking[ 'with_cr_fare' ]
                                    : $myBooking[ 'without_cr_fare' ];

                                $btnDisabled = in_array( $myBooking[ 'status' ], [ 'Cancelled', 'Ongoing' ] ) ? 'true' : 'false';

                                ?>
                                <tr class="text-nowrap">
                                    <td><?= esc( $myBooking[ 'booking_ref' ] ) ?></td>
                                    <td><?= date( 'F j, Y', strtotime( $myBooking[ 'date_created' ] ) ) ?></td>
                                    <td class="text-center">
                                        <?php
                                        // Map status to badge classes
                                        $badgeClasses = [
                                            'Scheduled' => 'bg-primary',
                                            'Ongoing'   => 'bg-primary',
                                            'Cancelled' => 'bg-danger',
                                            'Confirmed' => 'bg-success'
                                        ];

                                        $status     = $myBooking[ 'status' ];
                                        $badgeClass = $badgeClasses[ $status ] ?? 'bg-secondary'; // fallback for unknown status
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= esc( $status ) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm view-booking"
                                            style="margin-right: 3px;" data-id="<?= $myBooking[ 'bookings_tb_id' ] ?>"
                                            data-btn="<?= $btnDisabled ?>"
                                            data-date="<?= date( 'F j, Y g:i A', strtotime( $myBooking[ 'date_created' ] ) ) ?>"
                                            data-ref="<?= $myBooking[ 'booking_ref' ] ?>"
                                            data-origin="<?= $myBooking[ 'origin' ] ?>"
                                            data-destination="<?= $myBooking[ 'destination' ] ?>"
                                            data-depdate="<?= date( 'F j, Y', strtotime( $myBooking[ 'date' ] ) ) ?>"
                                            data-deptime="<?= date( 'g:i A', strtotime( $myBooking[ 'dep_time' ] ) ) ?>"
                                            data-bus="<?= $myBooking[ 'bus_name' ] ?>"
                                            data-bustype="<?= $myBooking[ 'bus_type' ] ?>"
                                            data-seats="<?= $myBooking[ 'seats' ] ?>"
                                            data-amountpaid="<?= esc( number_format( $myBooking[ 'amount_paid' ] ) ) ?>"
                                            data-paymentmethod="<?= $myBooking[ 'payment_method' ] ?>"
                                            data-paymentstatus="<?= $myBooking[ 'payment_status' ] ?>"
                                            data-noofpassengers="<?= $myBooking[ 'no_of_passenger' ] ?>"
                                            data-fare="<?= esc( number_format( $fare ) ) ?>"
                                            data-total="<?= esc( number_format( $myBooking[ 'amount' ] ) ) ?>"
                                            data-status="<?= $myBooking[ 'status' ] ?>">
                                            <i class="fas fa-eye"></i> View
                                        </a>

                                        <a href="javascript:void(0)"
                                            class="btn btn-danger btn-sm cancel-booking <?= in_array( $myBooking[ 'status' ], [ 'Cancelled', 'Ongoing' ] ) ? 'disabled' : '' ?>"
                                            data-id="<?= $myBooking[ 'bookings_tb_id' ] ?>"
                                            data-url="<?= base_url( 'myBookings/cancelBooking' ) ?>">
                                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i class="fas fa-ban"></i> Cancel Booking
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">No bookings available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>


    <footer class="text-center py-4 bg-dark text-light">
        <div class="container">
            <p class="mb-1">&copy; 2025 Eastern Goldtrans Tours Inc. All rights reserved.</p>
        </div>
    </footer>

    <!-- View Info Modal -->
    <div class="modal fade" id="bookingInfoModal" tabindex="-1" aria-labelledby="bookingInfoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="bookingInfoModalLabel">Booking Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Booking Details -->
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Booking Reference:</strong>
                            <span id="infoBookingRef"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Date Created:</strong>
                            <span id="infoDateCreated"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Origin:</strong>
                            <span id="infoOrigin"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Destination:</strong>
                            <span id="infoDestination"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Departure Time:</strong>
                            <span id="infoSchedule"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Bus:</strong>
                            <span id="infoBus"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Bus Type:</strong>
                            <span id="infoBusType"></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <strong>No. of Passengers:</strong>
                            <span id="infoPassengerCount"></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <div class="d-flex justify-content-between align-items-center p-1">
                                <strong>Seats:</strong>
                                <button class="btn btn-pink btn-sm p-1 ms-3" id="viewSeatsBtn" data-bs-toggle="modal"
                                    data-bs-target="#seatMapModal" title="View Seat Map">
                                    <i class="fas fa-eye"></i>
                                    View Seat Map
                                </button>
                            </div>

                            <span id="infoSeats"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Payment Method:</strong>
                            <span id="infoPaymentMethod"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Payment Status:</strong>
                            <span id="infoPaymentStatus"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Amount Paid:</strong>
                            <span id="infoAmountPaid"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Fare:</strong>
                            <span id="infoFare"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Total:</strong>
                            <span id="infoTotal"></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>Status:</strong>
                            <span id="infoStatus"></span>
                        </li>
                    </ul>


                    <!-- Passengers List -->
                    <ul class="list-group" id="infoPassengers"></ul>
                </div>


                <div class="modal-footer">
                    <button id="cancel-booking" data-url="<?= base_url( 'myBookings/cancelBooking' ) ?>"
                        class="btn btn-danger">
                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                            aria-hidden="true"></span>
                        <i class="fas fa-ban"></i> Cancel Booking</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Seat Map Modal -->
    <div class="modal fade" id="seatMapModal" tabindex="-1" aria-labelledby="seatMapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seatMapModalLabel">Seat Map</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-3" id="seatModalContainer"></div>
                </div>
            </div>
        </div>
    </div>

    <?php if ( session()->get( "user" ) ) : ?>
        <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel"
            aria-hidden="true">
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

                            <!-- Contact Number -->
                            <div class="mb-3">
                                <label for="updateContact" class="form-label">Contact Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">+63</span>
                                    <input type="tel" class="form-control" id="updateContact" placeholder="9XXXXXXXXX"
                                        pattern="^9\d{9}$" maxlength="10" required>
                                    <div class="invalid-feedback d-none" id="updateContactInvalidFeedback"></div>
                                </div>
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
                                <div class="invalid-feedback" id="confirmPasswordRequired">Confirm password is required when
                                    changing your password.</div>
                                <div class="invalid-feedback d-none" id="confirmPasswordMismatch">Passwords do not match.
                                </div>
                            </div>

                            <!-- Hidden User ID -->
                            <input type="hidden" id="updateUserId" value="<?= session()->get( 'user' )[ 'users_id' ] ?>" />
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100" id="updateProfileSubmitBtn"
                            form="updateProfileForm">
                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"
                                id="updateProfileLoadingSpinner"></span>
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script>
        const notification = <?php echo json_encode( session()->getFlashdata() ); ?>;
        const user = <?php echo json_encode( session()->get( "user" ) ); ?>;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="public/dist/home/js/editProfile.script.js?v4.3.4"></script>

    <script>
        const BASE_URL = "<?= base_url() ?>";
    </script>
    <script src="<?= base_url( 'public/dist/home/js/my_bookings.script.js?v7' ) ?>"></script>

</body>

</html>