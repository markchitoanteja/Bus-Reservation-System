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
                    <button class="btn btn-primary mb-3 float-right" data-toggle="modal"
                        data-target="#addScheduleModal">
                        <i class="fas fa-plus"></i>&nbsp;Add New Schedule
                    </button>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Schedules List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="schedulesTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Route</th>
                                            <th colspan="2" class="text-center">Schedule</th>
                                            <th colspan="3" class="text-center">Bus</th>
                                            <th rowspan="2" class="text-center">Actions</th>
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
                                        <?php foreach ( getAllSchedules() as $schedule ) : ?>
                                            <tr>
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
                                                <td class="text-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-info btn-sm mr-1 edit-schedule"
                                                        data-id="<?= $schedule[ 'bus_trav_sched_tb_id' ] ?>"
                                                        data-route="<?= esc( $schedule[ 'routes_tb_id' ] ) ?>"
                                                        data-date="<?= esc( $schedule[ 'date' ] ) ?>"
                                                        data-departure="<?= esc( $schedule[ 'dep_time' ] ) ?>"
                                                        data-bus="<?= esc( $schedule[ 'buses_tb_id' ] ) ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                        class="btn btn-danger btn-sm delete-schedule"
                                                        data-id="<?= $schedule[ 'bus_trav_sched_tb_id' ] ?>"
                                                        data-url="schedules/deleteSchedule">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </a>
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

<!-- Add New Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addScheduleForm" action="schedules/addSchedule" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">Add New Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="scheduleErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>
                    <div class="form-group">
                        <label for="scheduleRoute">Route</label>
                        <select class="form-control" id="scheduleRoute" name="route_id" required>
                            <option value="">Select Route</option>
                            <?php foreach ( getAllRoutes() as $route ) : ?>
                                <option value="<?= $route[ 'routes_tb_id' ] ?>">
                                    <?= esc( $route[ 'origin' ] ) ?> — <?= esc( $route[ 'destination' ] ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="scheduleDate">Date</label>
                        <input type="date" class="form-control" id="scheduleDate" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="scheduleDeparture">Departure Time</label>
                        <input type="time" class="form-control" id="scheduleDeparture" name="departure_time" required>
                    </div>
                    <div class="form-group">
                        <label for="scheduleBus">Bus</label>
                        <select class="form-control" id="scheduleBus" name="bus_id" required>
                            <option value="">Select Bus</option>
                            <?php foreach ( getAllBuses() as $bus ) : ?>
                                <option value="<?= $bus[ 'buses_tb_id' ] ?>">
                                    <?= esc( $bus[ 'bus_name' ] ) ?> (<?= esc( $bus[ 'bus_no' ] ) ?> -
                                    <?= esc( $bus[ 'bus_type' ] ) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addScheduleSubmitBtn">
                        <span id="addScheduleBtnText">Add Schedule</span>
                        <span id="addScheduleBtnLoader" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editScheduleForm" action="schedules/editSchedule" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel">Edit Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editScheduleErrorAlert" class="alert alert-danger d-none" role="alert">

                    </div>
                    <input type="hidden" name="schedule_id" id="editScheduleId">
                    <div class="form-group">
                        <label for="editScheduleRoute">Route</label>
                        <select class="form-control" id="editScheduleRoute" name="route_id" required>
                            <option value="">Select Route</option>
                            <?php foreach ( getAllRoutes() as $route ) : ?>
                                <option value="<?= $route[ 'routes_tb_id' ] ?>">
                                    <?= esc( $route[ 'origin' ] ) ?> — <?= esc( $route[ 'destination' ] ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editScheduleDate">Date</label>
                        <input type="date" class="form-control" id="editScheduleDate" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="editScheduleDeparture">Departure Time</label>
                        <input type="time" class="form-control" id="editScheduleDeparture" name="departure_time"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="editScheduleBus">Bus</label>
                        <select class="form-control" id="editScheduleBus" name="bus_id" required>
                            <option value="">Select Bus</option>
                            <?php foreach ( getAllBuses() as $bus ) : ?>
                                <option value="<?= $bus[ 'buses_tb_id' ] ?>">
                                    <?= esc( $bus[ 'bus_name' ] ) ?> (<?= esc( $bus[ 'bus_no' ] ) ?> -
                                    <?= esc( $bus[ 'bus_type' ] ) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editScheduleSubmitBtn">
                        <span id="editScheduleBtnText">Update Schedule</span>
                        <span id="editScheduleBtnLoader" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>