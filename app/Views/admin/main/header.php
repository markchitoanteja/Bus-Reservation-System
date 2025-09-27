<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= session( 'title' ) ?? '' ?> | Mega Bus Lines Corp.</title>


    <link rel="shortcut icon" href="<?= base_url( 'favicon.ico?v=2' ) ?>" type="image/x-icon" />


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
            <img class="animation__shake" src="<?= base_url() ?>public/dist/admin/img/favicon.ico" alt="Logo"
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
                    <a class="nav-link" data-toggle="dropdown" href="#" id="notifBell">
                        <i class="far fa-bell"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notifArea">

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
                <img src="<?= base_url() ?>public/dist/admin/img/favicon.ico" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Mega Bus Lines Corp.</span>
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