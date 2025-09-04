<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | Eastern Goldtrans Tours Inc.</title>

    <link rel="shortcut icon" href="<?= base_url( 'favicon.ico' ) ?>" type="image/x-icon" />


    <!-- Fonts & Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/plugins/fontawesome-free/css/all.min.css">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url() ?>public/dist/admin/css/sweetAlertStyle.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/dist/admin/css/adminlte.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <link rel="stylesheet"
        href="<?= base_url() ?>public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url() ?>public/dist/admin/img/logo-circle.png" alt="Logo"
                height="60" width="60">
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
                <img src="<?= base_url() ?>public/dist/admin/img/logo.png" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Goldtrans Tours Inc.</span>
            </a>

            <div class="sidebar">
                <!-- User Info -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>public/dist/admin/img/uploads/default-user-image.webp"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Administrator</a>
                    </div>
                </div>

                <!-- Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                        <li class="nav-item">
                            <a href="dashboard"
                                class="nav-link <?= session()->get( 'active_tab' ) === 'dashboard' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-header">MANAGEMENT</li>

                        <li class="nav-item">
                            <a href="bookings"
                                class="nav-link <?= session()->get( 'active_tab' ) === 'bookings' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Bookings</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="passengers"
                                class="nav-link <?= session()->get( 'active_tab' ) === 'passengers' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Passengers</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="routes"
                                class="nav-link <?= session()->get( 'active_tab' ) === 'routes' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-route"></i>
                                <p>Routes</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="buses"
                                class="nav-link <?= session()->get( 'active_tab' ) === 'buses' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-bus"></i>
                                <p>Buses</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="schedules"
                                class="nav-link <?= session()->get( 'active_tab' ) === 'schedules' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>Schedules</p>
                            </a>
                        </li>



                        <li class="nav-header">SYSTEM</li>

                        <li class="nav-item">
                            <a href="settings"
                                class="nav-link <?= session()->get( 'active_tab' ) === 'settings' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Settings</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link logoutBtn" data-url="<?= base_url() ?>">
                                <i class="nav-icon fas fa-sign-out-alt"></i>

                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>