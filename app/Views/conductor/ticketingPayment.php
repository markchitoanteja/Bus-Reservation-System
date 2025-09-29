<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ticketing & Payment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Ticketing & Payment</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedules Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List</h3>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <!-- Date buttons -->
                                <div class="col-lg-12 p-1">
                                    <h3 class="card-title mt-2 mr-2">Select Date:</h3>
                                    <div class="d-flex overflow-auto btn-group" role="group" aria-label="Select Dates">
                                        <?php $schedules = getAllDateShedulesByBus(); ?>

                                        <?php if ( !empty( $schedules ) ) : ?>
                                            <?php foreach ( $schedules as $DateSchedule ) : ?>
                                                <button class="btn btn-outline-primary btn-sm text-nowrap date-btn"
                                                    data-date="<?= $DateSchedule[ 'date' ] ?>">
                                                    <?= date( 'F j, Y', strtotime( $DateSchedule[ 'date' ] ) ) ?>
                                                </button>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <button class="btn text-muted small" disabled>No available schedule.</button>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="ticketingPayment" class="table table-hover schedulesTable">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Booking Reference</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Routes</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Payment Method</th>
                                            <th class="text-center">Payment Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>

                                    </thead>
                                    <tbody id="bookingTableBody" class="text-nowrap text-center">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- View Info Modal -->
<div class="modal fade" id="bookingInfoModal" tabindex="-1" aria-labelledby="bookingInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="bookingInfoModalLabel">Booking Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                        <strong>Seats:</strong>
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
                <button id="btnFullyPaid" href="javascript:void(0)" class="btn btn-success btn-md" data-id="">
                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                    <i class="fas fa-check-circle"></i> Fully Paid
                </button>

                <button id="btnNotPaid" href="javascript:void(0)" class="btn btn-secondary btn-md" data-id="">
                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                    <i class="fas fa-ban"></i> Not Paid
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>