<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bookings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Bookings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bookings List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="bookingsTable" class="table table-hover">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th rowspan="2" class="text-center">No.</th>
                                            <th rowspan="2" class="text-center">Booking Reference</th>
                                            <th rowspan="2" class="text-center">Name</th>
                                            <th rowspan="2" class="text-center">Routes</th>
                                            <th colspan="2" class="text-center">Departure</th>
                                            <th rowspan="2" class="text-center">Bus</th>
                                            <th rowspan="2" class="text-center">No. of Passenger</th>
                                            <th rowspan="2" class="text-center">Seat No.</th>
                                            <th rowspan="2" class="text-center">Ticket Fare</th>
                                            <th rowspan="2" class="text-center">Total Amount</th>
                                            <th rowspan="2" class="text-center">Amount Paid</th>
                                            <th rowspan="2" class="text-center">Payment Method</th>
                                            <th rowspan="2" class="text-center">Payment Status</th>
                                            <th rowspan="2" class="text-center">Status</th>
                                            <!-- <th rowspan="2" class="text-center">Actions</th> -->
                                        </tr>
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ( getAllBookingsByBus() as $route ) : ?>
                                            <tr class="text-nowrap">
                                                <td><?= $no++ ?></td>
                                                <td><?= esc( $route[ 'booking_ref' ] ) ?></td>
                                                <td><?= esc( $route[ 'name' ] ) ?></td>
                                                <td>
                                                    <?= esc( $route[ 'origin' ] ) ?> — <?= esc( $route[ 'destination' ] ) ?>
                                                </td>
                                                <td><?= date( 'F j, Y', strtotime( $route[ 'date' ] ) ) ?></td>
                                                <td><?= date( 'h:i A', strtotime( $route[ 'dep_time' ] ) ) ?></td>
                                                <td><?= esc( $route[ 'bus_name' ] ) ?> (<?= esc( $route[ 'bus_no' ] ) ?>) -
                                                    <?= esc( $route[ 'bus_type' ] ) ?>
                                                </td>
                                                <td class="text-center"><?= esc( $route[ 'no_of_passenger' ] ) ?></td>
                                                <td><?= esc( $route[ 'seats' ] ) ?></td>
                                                <td>
                                                    <i class="fa fa-peso-sign"></i>&nbsp;<?= esc(
                                                        number_format(
                                                            $route[ 'bus_type' ] === '2x2 Aircon with CR, 45-seater'
                                                            ? $route[ 'with_cr_fare' ]
                                                            : $route[ 'without_cr_fare' ],
                                                            2
                                                        )
                                                    ) ?>
                                                </td>
                                                <td><i
                                                        class="fa fa-peso-sign"></i>&nbsp;<?= esc( number_format( $route[ 'amount' ] ) ) ?>
                                                </td>
                                                <td><i
                                                        class="fa fa-peso-sign"></i>&nbsp;<?= esc( number_format( $route[ 'amount_paid' ] ) ) ?>
                                                </td>
                                                <td class="text-center"><?= esc( $route[ 'payment_method' ] ) ?></td>
                                                <td><?= esc( $route[ 'payment_status' ] ) ?></td>
                                                <td>
                                                    <?php
                                                    // Map status to badge classes
                                                    $badgeClasses = [
                                                        'Scheduled' => 'badge-primary',
                                                        'Ongoing'   => 'badge-primary',
                                                        'Cancelled' => 'badge-danger',
                                                        'Confirmed' => 'badge-success'
                                                    ];

                                                    $status     = $route[ 'status' ];
                                                    $badgeClass = $badgeClasses[ $status ] ?? 'badge-secondary'; // fallback for unknown status
                                                    ?>
                                                    <span class="badge <?= $badgeClass ?>"><?= esc( $status ) ?></span>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
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