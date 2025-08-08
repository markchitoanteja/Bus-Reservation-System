<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Buses</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Buses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Buses Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <button class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addBusModal">
                        <i class="fas fa-plus"></i>&nbsp;Add New Bus
                    </button>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Buses List</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="busesTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Bus No.</th>
                                            <th>Bus Name</th>
                                            <th>Bus Type</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ( getAllBuses() as $bus ) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc( $bus[ 'bus_no' ] ) ?></td>
                                                <td><?= esc( $bus[ 'bus_name' ] ) ?></td>
                                                <td><?= esc( $bus[ 'bus_type' ] ) ?></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-info btn-sm mr-1 edit-bus"
                                                        data-id="<?= $bus[ 'buses_tb_id' ] ?>"
                                                        data-busno="<?= esc( $bus[ 'bus_no' ] ) ?>"
                                                        data-busname="<?= esc( $bus[ 'bus_name' ] ) ?>"
                                                        data-bustype="<?= esc( $bus[ 'bus_type' ] ) ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm delete-bus"
                                                        data-id="<?= $bus[ 'buses_tb_id' ] ?>" data-url="buses/deleteBus">
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


<!-- Add New Bus -->
<div class="modal fade" id="addBusModal" tabindex="-1" role="dialog" aria-labelledby="addBusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="addBusForm" action="buses/addBus" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBusModalLabel">Add New Bus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="busErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>
                    <div class="form-group">
                        <label for="busNumber">Bus Number</label>
                        <input type="text" class="form-control" id="busNumber" name="bus_number" placeholder="e.g. 1234"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="busName">Bus Name</label>
                        <input type="text" class="form-control" id="busName" name="bus_name"
                            placeholder="e.g. Goldtrans Tours" required>
                    </div>

                    <div class="form-group">
                        <label for="busType">Bus Type</label>
                        <select name="bus_type" id="busType" class="form-control" required>
                            <option value="" selected>Select Bus Type</option>
                            <option value="Ordinary">Ordinary</option>
                            <option value="Air-Con">Air-Con</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="addBusSubmitBtn">
                        <span id="addBusBtnText">Add Bus</span>
                        <span id="addBusBtnLoader" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Bus Modal -->
<div class="modal fade" id="editBusModal" tabindex="-1" role="dialog" aria-labelledby="editBusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editBusForm" action="buses/editBus" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBusModalLabel">Edit Bus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="editBusErrorAlert" class="alert alert-danger d-none" role="alert">
                        <!-- Error will show here -->
                    </div>
                    <input type="hidden" name="bus_id" id="editBusId">
                    <div class="form-group">
                        <label for="editBusNumber">Bus Number</label>
                        <input type="text" class="form-control" id="editBusNumber" name="bus_number"
                            placeholder="e.g. 1234" required>
                    </div>
                    <div class="form-group">
                        <label for="editBusName">Bus Name</label>
                        <input type="text" class="form-control" id="editBusName" name="bus_name"
                            placeholder="e.g. Goldtrans Tours" required>
                    </div>
                    <div class="form-group">
                        <label for="editBusType">Bus Type</label>
                        <select name="bus_type" id="editBusType" class="form-control" required>
                            <option value="" selected>Select Bus Type</option>
                            <option value="Ordinary">Ordinary</option>
                            <option value="Air-Con">Air-Con</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editBusSubmitBtn">
                        <span id="editBusBtnText">Update Bus</span>
                        <span id="editBusBtnLoader" class="spinner-border spinner-border-sm d-none" role="status"
                            aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>