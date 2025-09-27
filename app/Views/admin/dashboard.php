<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <!-- Total Bookings -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-ticket-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Bookings Today</span>
                            <span class="info-box-number"><?= getTotalBookingsToday(); ?></span>
                        </div>
                    </div>
                </div>



                <!-- Buses in Transit -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-shuttle-van"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Buses in Transit</span>
                            <span class="info-box-number"><?= getBusesInTransit(); ?></span>
                        </div>
                    </div>
                </div>



                <!-- Most Booked Route -->
                <div class="col-md-12 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Most Booked Route</span>
                            <?php $routes = getMostBookedRoutes(); ?>

                            <?php if ( $routes ) : ?>
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr>
                                                <th>Origin</th>
                                                <th>Destination</th>
                                                <th>Total Bookings</th>
                                                <th>Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ( $routes as $r ) : ?>
                                                <tr class="text-nowrap">
                                                    <td><?= esc( $r[ 'origin' ] ) ?></td>
                                                    <td><?= esc( $r[ 'destination' ] ) ?></td>
                                                    <td><?= esc( $r[ 'total_bookings' ] ) ?></td>
                                                    <td><?= $r[ 'percentage' ] ?>%</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else : ?>
                                <span class="info-box-number">No bookings yet</span>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">

                    <!-- Table: Recent Bookings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Bookings</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th rowspan="2">Booking Reference</th>
                                            <th rowspan="2">Customer</th>
                                            <th rowspan="2">Route</th>
                                            <th colspan="2" class="text-center">Departure</th>
                                            <th rowspan="2">Status</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ( !empty( getAllRecentBookings() ) ) : ?>
                                            <?php foreach ( getAllRecentBookings() as $route ) : ?>
                                                <tr class="text-nowrap">
                                                    <td><?= esc( $route[ 'booking_ref' ] ) ?></td>
                                                    <td><?= esc( $route[ 'name' ] ) ?></td>
                                                    <td>
                                                        <?= esc( $route[ 'origin' ] ) ?> — <?= esc( $route[ 'destination' ] ) ?>
                                                    </td>
                                                    <td><?= date( 'F j, Y', strtotime( $route[ 'date' ] ) ) ?></td>
                                                    <td><?= date( 'h:i A', strtotime( $route[ 'dep_time' ] ) ) ?></td>
                                                    <td>
                                                        <?php
                                                        // Map status to badge classes
                                                        $badgeClasses = [ 
                                                            'Pending'   => 'badge-warning',
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
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No recent bookings found</td>
                                            </tr>
                                        <?php endif; ?>
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