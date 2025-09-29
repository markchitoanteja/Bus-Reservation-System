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
                                            <th colspan="2" class="text-center">Bus Type</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">2x2 Aircon with CR, 45-seater</th>
                                            <th class="text-center">2x3 Aircon without CR, 61-seater</th>
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
                                                    <?= number_format( $route[ 'with_cr_fare' ], 2 ) ?></td>
                                                <td><i class="fa fa-peso-sign"></i>
                                                    <?= number_format( $route[ 'without_cr_fare' ], 2 ) ?></td>
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