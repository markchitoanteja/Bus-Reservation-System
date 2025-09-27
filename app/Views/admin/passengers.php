<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Passengers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Passengers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Passengers Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Passengers List</h3>
                        </div>

                        <div class="card-header">
                            <div class="row">
                                <!-- Date buttons -->
                                <div class="col-lg-6 p-1">
                                    <h3 class="card-title mt-2 mr-2">Select Date:</h3>
                                    <div class="d-flex overflow-auto btn-group" role="group" aria-label="Select Dates">
                                        <?php foreach ( getAllDateShedules() as $DateSchedule ) : ?>
                                            <button class="btn btn-outline-primary btn-sm text-nowrap date-btn"
                                                data-date="<?= $DateSchedule[ 'date' ] ?>">
                                                <?= date( 'F j, Y', strtotime( $DateSchedule[ 'date' ] ) ) ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Bus buttons -->
                                <div class="col-lg-6 p-1">
                                    <h3 class="card-title mt-2 ml-2 mr-2">Select Bus:</h3>
                                    <div class="d-flex overflow-auto btn-group" role="group" aria-label="Select Bus">
                                        <?php foreach ( getAllBusShedules() as $BusSchedule ) : ?>
                                            <button class="btn btn-outline-primary btn-sm text-nowrap bus-btn"
                                                data-bus_id="<?= $BusSchedule[ 'buses_tb_id' ] ?>">
                                                <?= $BusSchedule[ 'bus_name' ] ?> (<?= $BusSchedule[ 'bus_no' ] ?>) -
                                                <?= $BusSchedule[ 'bus_type' ] ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="passengerTable" class="table table-hover">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Booking ID</th>
                                            <th class="text-center">Passenger Name</th>
                                            <th class="text-center">Age</th>
                                            <th class="text-center">Gender</th>
                                            <th class="text-center">Route</th>
                                            <th class="text-center">Booking Reference</th>
                                            <th class="text-center">Booked By</th>
                                            <th class="text-center">Travel Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="passengerTableBody" class="text-nowrap text-center">

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