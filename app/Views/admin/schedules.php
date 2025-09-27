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
                <!-- Bus Travel Schedule -->
                <div class="col-lg-12">
                    <button class="btn btn-primary mb-3 float-right" data-toggle="modal"
                        data-target="#addBusTravelScheduleModal">
                        <i class="fas fa-plus"></i>&nbsp;Add New Bus Travel Schedule
                    </button>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bus Travel Schedule</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover schedulesTable">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th>No.</th>
                                            <th>Date</th>
                                            <th>Bus No.</th>
                                            <th>Bus Name</th>
                                            <th>Bus Type</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ( getAllBusSchedules() as $schedule ) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= date( 'F j, Y', strtotime( $schedule[ 'date' ] ) ) ?></td>
                                                <td><?= esc( $schedule[ 'bus_no' ] ) ?></td>
                                                <td><?= esc( $schedule[ 'bus_name' ] ) ?></td>
                                                <td><?= esc( $schedule[ 'bus_type' ] ) ?></td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-info btn-sm mr-1 edit-BusTravelSchedule"
                                                        data-id="<?= $schedule[ 'bus_trav_sched_tb_id' ] ?>"
                                                        data-date="<?= esc( $schedule[ 'date' ] ) ?>"
                                                        data-bus_id="<?= esc( $schedule[ 'buses_tb_id' ] ) ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                        class="btn btn-danger btn-sm delete-BusTravelSchedule"
                                                        data-id="<?= $schedule[ 'bus_trav_sched_tb_id' ] ?>"
                                                        data-url="schedules/deleteBusTravelSchedule">
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

                <div class="col-lg-12 mt-3">
                    <button class="btn btn-primary mb-3 float-right" data-toggle="modal"
                        data-target="#addRouteScheduleModal">
                        <i class="fas fa-plus"></i>&nbsp;Add New Routes Schedule
                    </button>
                </div>
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
                                        <?php foreach ( getAllRoutesSchedules() as $schedule ) : ?>
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
                                                <td class="text-center">
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-info btn-sm mr-1 edit-schedule"
                                                        data-id="<?= $schedule[ 'bus_routes_tb_id' ] ?>"
                                                        data-route="<?= esc( $schedule[ 'routes_tb_id' ] ) ?>"
                                                        data-date="<?= esc( $schedule[ 'date' ] ) ?>"
                                                        data-departure="<?= esc( $schedule[ 'dep_time' ] ) ?>"
                                                        data-bus="<?= esc( $schedule[ 'bus_trav_sched_tb_id' ] ) ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                        class="btn btn-danger btn-sm delete-routeSchedule"
                                                        data-id="<?= $schedule[ 'bus_routes_tb_id' ] ?>"
                                                        data-url="schedules/deleteRouteSchedule">
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

<!-- Add New Bus Travel Schedule Modal -->
<div class="modal fade" id="addBusTravelScheduleModal" tabindex="-1" role="dialog"
    aria-labelledby="addBusTravelScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addBusTravelScheduleForm" action="schedules/addBusTravelSchedule" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBusTravelScheduleModalLabel">Add New Bus Travel Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="BusTravelScheduleErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>
                    <div class="form-group">
                        <label for="BusTravelScheduleDate">Date</label>
                        <input type="date" class="form-control" id="BusTravelScheduleDate" name="date" required>
                        <small id="dateError" class="text-danger" style="display:none;">Please select a future
                            date.</small>
                    </div>
                    <div class="form-group">
                        <label for="BusTravelScheduleBus">Bus</label>
                        <select class="form-control" id="BusTravelScheduleBus" name="bus_id" required>
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
                    <button type="submit" class="btn btn-primary" id="addBusTravelScheduleSubmitBtn">
                        <span id="addBusTravelScheduleBtnText">Add Schedule</span>
                        <span id="addBusTravelScheduleBtnLoader" class="spinner-border spinner-border-sm d-none"
                            role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Bus Travel Schedule Modal -->
<div class="modal fade" id="editBusTravelScheduleModal" tabindex="-1" role="dialog"
    aria-labelledby="editBusTravelScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editBusTravelScheduleForm" action="schedules/editBusTravelSchedule" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBusTravelScheduleModalLabel">Edit Bus Travel Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="EditBusTravelScheduleErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>
                    <input type="hidden" id="editBusTravelScheduleId" name="bus_trav_sched_tb_id">

                    <div class="form-group">
                        <label for="EditBusTravelScheduleDate">Date</label>
                        <input type="date" class="form-control" id="EditBusTravelScheduleDate" name="date" required>
                        <small id="editDateError" class="text-danger" style="display:none;">
                            Please select a future date.
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="EditBusTravelScheduleBus">Bus</label>
                        <select class="form-control" id="EditBusTravelScheduleBus" name="bus_id" required>
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
                    <button type="submit" class="btn btn-primary" id="editBusTravelScheduleSubmitBtn">
                        <span id="editBusTravelScheduleBtnText">Save Changes</span>
                        <span id="editBusTravelScheduleBtnLoader" class="spinner-border spinner-border-sm d-none"
                            role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <script>
    $(document).ready(function () {
        // Validation for Edit Date
        $("#EditBusTravelScheduleDate").on("blur input change", function () {
            let selectedDate = new Date($(this).val());
            let today = new Date();

            today.setHours(0, 0, 0, 0);
            selectedDate.setHours(0, 0, 0, 0);

            if (selectedDate <= today) {
                $("#editDateError").show();
                $(this).addClass("is-invalid");
            } else {
                $("#editDateError").hide();
                $(this).removeClass("is-invalid");
            }
        });

        // Populate edit modal with existing data
        $(".edit-schedule-btn").on("click", function () {
            let scheduleId = $(this).data("id");
            let scheduleDate = $(this).data("date");
            let busId = $(this).data("bus-id");

            $("#editBusTravelScheduleId").val(scheduleId);
            $("#EditBusTravelScheduleDate").val(scheduleDate);
            $("#EditBusTravelScheduleBus").val(busId);
        });
    });
</script> -->


<!-- Add New Route Schedule Modal -->
<div class="modal fade" id="addRouteScheduleModal" tabindex="-1" role="dialog"
    aria-labelledby="addRouteScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addRouteScheduleForm" action="schedules/addRouteSchedule" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRouteScheduleModalLabel">Add New Route Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="addRouteScheduleErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>

                    <div class="form-group">
                        <label for="addRouteScheduleRoute">Route</label>
                        <select class="form-control" id="addRouteScheduleRoute" name="route_id" required>
                            <option value="" disabled selected>Select Route</option>
                            <?php foreach ( getAllRoutes() as $route ) : ?>
                                <option value="<?= $route[ 'routes_tb_id' ] ?>">
                                    <?= esc( $route[ 'origin' ] ) ?> — <?= esc( $route[ 'destination' ] ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="addRouteScheduleDate">Date</label>
                        <input type="date" class="form-control" id="addRouteScheduleDate" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="addRouteScheduleDeparture">Departure Time</label>
                        <input type="time" class="form-control" id="addRouteScheduleDeparture" name="departure_time"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="addRouteScheduleBus">Bus</label>
                        <select id="addRouteScheduleBus" name="bus_id" class="form-control" required>
                            <option value="" disabled selected>Select bus</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addRouteScheduleSubmitBtn">
                        <span id="addRouteScheduleBtnText">Add Schedule</span>
                        <span id="addRouteScheduleBtnLoader" class="spinner-border spinner-border-sm d-none"
                            role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Edit Schedule Modal -->
<div class="modal fade" id="editRouteScheduleModal" tabindex="-1" role="dialog"
    aria-labelledby="editRouteScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editRouteScheduleForm" action="schedules/editRouteSchedule" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRouteScheduleModalLabel">Edit Route Schedule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editRouteScheduleErrorAlert" class="alert alert-danger d-none" role="alert">

                    </div>
                    <input type="hidden" name="bus_routes_tb_id" id="editRouteScheduleId">
                    <div class="form-group">
                        <label for="editRouteScheduleRoute">Route</label>
                        <select class="form-control" id="editRouteScheduleRoute" name="route_id" required>
                            <option value="">Select Route</option>
                            <?php foreach ( getAllRoutes() as $route ) : ?>
                                <option value="<?= $route[ 'routes_tb_id' ] ?>">
                                    <?= esc( $route[ 'origin' ] ) ?> — <?= esc( $route[ 'destination' ] ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editRouteScheduleDate">Date</label>
                        <input type="date" class="form-control" id="editRouteScheduleDate" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="editRouteScheduleDeparture">Departure Time</label>
                        <input type="time" class="form-control" id="editRouteScheduleDeparture" name="departure_time"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="editRouteScheduleBus">Bus</label>
                        <select id="editRouteScheduleBus" name="bus_id" class="form-control" required>
                            <option value="" disabled selected>Select bus</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editRouteScheduleSubmitBtn">
                        <span id="editRouteScheduleBtnText">Update Schedule</span>
                        <span id="editRouteScheduleBtnLoader" class="spinner-border spinner-border-sm d-none"
                            role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>