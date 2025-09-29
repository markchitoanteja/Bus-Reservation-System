<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Schedules</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Schedules</li>
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
                            <h3 class="card-title">Routes Schedule</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover schedulesTable">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Route</th>
                                            <th colspan="2" class="text-center">Schedule</th>
                                            <th colspan="3" class="text-center">Bus</th>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <th>Departure Time</th>
                                            <th>Bus No.</th>
                                            <th>Bus Name</th>
                                            <th>Bus Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ( getAllRoutesSchedulesByBus() as $schedule ) : ?>
                                            <tr class="text-nowrap">
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    From: <?= esc( $schedule[ 'origin' ] ) ?><br>To:
                                                    <?= esc( $schedule[ 'destination' ] ) ?>
                                                </td>
                                                <td><?= date( 'F j, Y', strtotime( $schedule[ 'date' ] ) ) ?></td>
                                                <td><?= date( 'h:i A', strtotime( $schedule[ 'dep_time' ] ) ) ?></td>
                                                <td><?= esc( $schedule[ 'bus_no' ] ) ?></td>
                                                <td><?= esc( $schedule[ 'bus_name' ] ) ?></td>
                                                <td><?= esc( $schedule[ 'bus_type' ] ) ?></td>

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