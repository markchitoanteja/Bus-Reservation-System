<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Eastern Goldtrans Tours Inc.</title>
    
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url() ?>public/plugins/fontawesome-free/css/all.min.css">
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url() ?>public/dist/admin/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url() ?>public/dist/admin/img/logo-circle.png" alt="Logo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- Notifications Icon -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">4</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">4 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-truncate" style="max-width: 250px;">
                            <i class="fas fa-bus mr-2"></i> 2 Bookings from Pasay
                            <span class="float-right text-muted text-sm">5m</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-truncate" style="max-width: 250px;">
                            <i class="fas fa-exclamation-circle mr-2"></i> 1 Delay reported...
                            <span class="float-right text-muted text-sm">12m</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-truncate" style="max-width: 250px;">
                            <i class="fas fa-user-plus mr-2"></i> New user from E. Samar
                            <span class="float-right text-muted text-sm">30m</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-truncate" style="max-width: 250px;">
                            <i class="fas fa-cogs mr-2"></i> System maintenanc...
                            <span class="float-right text-muted text-sm">1h</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">View All</a>
                    </div>
                </li>

                <!-- Settings Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-cog"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="fas fa-user-circle mr-2"></i> My Profile</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"><i class="fas fa-info-circle mr-2"></i> About Us</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item logoutBtn"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="<?= base_url() ?>public/dist/admin/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Goldtrans Tours Inc.</span>
            </a>

            <div class="sidebar">
                <!-- User Info -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>public/dist/admin/img/uploads/default-user-image.webp" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Administrator</a>
                    </div>
                </div>

                <!-- Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                        <li class="nav-item">
                            <a href="dashboard.html" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header">MANAGEMENT</li>

                        <li class="nav-item">
                            <a href="bookings.html" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Bookings</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="passengers.html" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Passengers</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="routes.html" class="nav-link">
                                <i class="nav-icon fas fa-route"></i>
                                <p>Routes</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="buses.html" class="nav-link">
                                <i class="nav-icon fas fa-bus"></i>
                                <p>Buses</p>
                            </a>
                        </li>

                        <li class="nav-header">SYSTEM</li>

                        <li class="nav-item">
                            <a href="settings.html" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Settings</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link logoutBtn">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

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

        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; 2025 Eastern Goldtrans Tours Inc.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="<?= base_url() ?>public/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>public/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="<?= base_url() ?>public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="<?= base_url() ?>public/dist/admin/js/adminlte.js"></script>

    <script>
        $(document).ready(function() {
            $('.logoutBtn').on('click', function(e) {
                $.ajax({
                    url: '../logout',
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.href = <?= json_encode(base_url()) ?>;
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>

</html>