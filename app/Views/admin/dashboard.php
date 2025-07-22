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
                            <span class="info-box-number">36</span>
                        </div>
                    </div>
                </div>

                <!-- Most Booked Route -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Most Booked Route</span>
                            <span class="info-box-number">Borongan - Pasay</span>
                        </div>
                    </div>
                </div>

                <!-- Buses in Transit -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-shuttle-van"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Buses in Transit</span>
                            <span class="info-box-number">7</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Customer Support -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-headset"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Support Tickets</span>
                            <span class="info-box-number">4</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table: Recent Bookings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Bookings</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Route</th>
                                <th>Departure</th>
                                <th>Terminal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#EGT2025001</td>
                                <td>Anna Tolosa</td>
                                <td>Guiuan - Pasay</td>
                                <td>May 27, 2025</td>
                                <td>Pasay</td>
                                <td><span class="badge badge-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>#EGT2025002</td>
                                <td>Jerome Gomez</td>
                                <td>Oras - Cubao</td>
                                <td>May 27, 2025</td>
                                <td>Cubao</td>
                                <td><span class="badge badge-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td>#EGT2025003</td>
                                <td>Maricel Dela Cruz</td>
                                <td>San Julian - Pasay</td>
                                <td>May 28, 2025</td>
                                <td>Pasay</td>
                                <td><span class="badge badge-success">Confirmed</span></td>
                            </tr>
                            <tr>
                                <td>#EGT2025004</td>
                                <td>Ronald Santiago</td>
                                <td>Dolores - Cubao</td>
                                <td>May 29, 2025</td>
                                <td>Cubao</td>
                                <td><span class="badge badge-danger">Cancelled</span></td>
                            </tr>
                            <tr>
                                <td>#EGT2025005</td>
                                <td>Karen Borja</td>
                                <td>Taft - Pasay</td>
                                <td>May 30, 2025</td>
                                <td>Pasay</td>
                                <td><span class="badge badge-success">Confirmed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>