<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Routes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Routes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Routes Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <button class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addRouteModal">
                        <i class="fas fa-plus"></i>&nbsp;Add New Route
                    </button>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Routes List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="routesTable" class="table table-hover">
                                    <thead class="table-bordered">
                                        <tr>
                                            <th rowspan="2" class="text-center">No.</th>
                                            <th rowspan="2" class="text-center">Origin</th>
                                            <th rowspan="2" class="text-center">Destination</th>
                                            <th colspan="2" class="text-center">Fare Type</th>
                                            <th rowspan="2" class="text-center">Actions</th>
                                        </tr>
                                        <tr>

                                            <th class="text-center">Ordinary</th>
                                            <th class="text-center">Aircon</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ( getAllRoutes() as $route ) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc( $route[ 'origin' ] ) ?></td>
                                                <td><?= esc( $route[ 'destination' ] ) ?></td>
                                                <td><i class="fa fa-peso-sign"></i>
                                                    <?= number_format( $route[ 'ordinary_fare' ], 2 ) ?></td>
                                                <td><i class="fa fa-peso-sign"></i>
                                                    <?= number_format( $route[ 'aircon_fare' ], 2 ) ?></td>

                                                <td class="text-center">
                                                    <a href="#" class="btn btn-info btn-sm mr-1 edit-route"
                                                        data-id="<?= $route[ 'routes_tb_id' ] ?>"
                                                        data-origin="<?= esc( $route[ 'origin' ] ) ?>"
                                                        data-destination="<?= esc( $route[ 'destination' ] ) ?>"
                                                        data-ordinary="<?= esc( $route[ 'ordinary_fare' ] ) ?>"
                                                        data-aircon="<?= esc( $route[ 'aircon_fare' ] ) ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-route"
                                                        data-id="<?= $route[ 'routes_tb_id' ] ?>"
                                                        data-url="routes/deleteRoute">
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

<!-- Add New Route Modal -->
<div class="modal fade" id="addRouteModal" tabindex="-1" role="dialog" aria-labelledby="addRouteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addRouteForm" action="routes/addRoute" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRouteModalLabel">Add New Route</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="routeErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>
                    <div class="form-group">
                        <label for="routeOrigin">Origin</label>
                        <input type="text" class="form-control" id="routeOrigin" name="origin"
                            placeholder="e.g. Can-Avid" required>
                    </div>
                    <div class="form-group">
                        <label for="routeDestination">Destination</label>
                        <input type="text" class="form-control" id="routeDestination" name="destination"
                            placeholder="e.g. Borongan" required>
                    </div>
                   <div class="form-group">
                        <label for="routeOrdinary">Ordinary Fare</label>
                        <input type="number" class="form-control" id="routeOrdinary" name="ordinary_fare"
                            placeholder="e.g. 500" required>
                    </div>
                    <div class="form-group">
                        <label for="routeAircon">Aircon Fare</label>
                        <input type="number" class="form-control" id="routeAircon" name="aircon_fare"
                            placeholder="e.g. 700" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addRouteSubmitBtn">
                        <span id="addRouteBtnText">Add Route</span>
                        <span id="addRouteBtnLoader" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Route Modal -->
<div class="modal fade" id="editRouteModal" tabindex="-1" role="dialog" aria-labelledby="editRouteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editRouteForm" action="routes/editRoute" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRouteModalLabel">Edit Route</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editRouteErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>
                    <input type="hidden" name="route_id" id="editRouteId">
                    <div class="form-group">
                        <label for="editRouteOrigin">Origin</label>
                        <input type="text" class="form-control" id="editRouteOrigin" name="origin"
                            placeholder="e.g. Can-Avid" required>
                    </div>
                    <div class="form-group">
                        <label for="editRouteDestination">Destination</label>
                        <input type="text" class="form-control" id="editRouteDestination" name="destination"
                            placeholder="e.g. Borongan" required>
                    </div>
                    <div class="form-group">
                        <label for="editRouteOrdinary">Ordinary Fare</label>
                        <input type="number" class="form-control" id="editRouteOrdinary" name="ordinary"
                            placeholder="e.g. 500" required>
                    </div>
                    <div class="form-group">
                        <label for="editRouteAircon">Aircon Fare</label>
                        <input type="number" class="form-control" id="editRouteAircon" name="aircon"
                            placeholder="e.g. 700" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editRouteSubmitBtn">
                        <span id="editRouteBtnText">Update Route</span>
                        <span id="editRouteBtnLoader" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>