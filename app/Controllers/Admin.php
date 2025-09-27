<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Admin extends BaseController
{
    /**
     * View dashboard page.
     *
     * @return string
     */
    public function index() : string|RedirectResponse
    {
        if ( $redirect = require_admin() ) {
            return $redirect;
        }

        session()->set( 'title', 'Dashboard' );
        session()->set( 'active_tab', 'dashboard' );

        // Load dashboard view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/dashboard' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View bookings page.
     *
     * @return string|RedirectResponse
     */
    public function viewBookings() : string|RedirectResponse
    {
        if ( $redirect = require_admin() ) {
            return $redirect;
        }

        session()->set( 'title', 'Bookings' );
        session()->set( 'active_tab', 'bookings' );

        // Load bookings view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/bookings' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View passengers page.
     *
     * @return string|RedirectResponse
     */
    public function viewPassengers() : string|RedirectResponse
    {
        if ( $redirect = require_admin() ) {
            return $redirect;
        }

        session()->set( 'title', 'Passengers' );
        session()->set( 'active_tab', 'passengers' );

        // Load passengers view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/passengers' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";

    }

    /**
     * View routes page.
     *
     * @return string|RedirectResponse
     */
    public function viewRoutes() : string|RedirectResponse
    {
        if ( $redirect = require_admin() ) {
            return $redirect;
        }

        session()->set( 'title', 'Routes' );
        session()->set( 'active_tab', 'routes' );

        // Load routes view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/routes' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View buses page.
     *
     * @return string|RedirectResponse
     */
    public function viewBuses() : string|RedirectResponse
    {
        if ( $redirect = require_admin() ) {
            return $redirect;
        }

        session()->set( 'title', 'Buses' );
        session()->set( 'active_tab', 'buses' );

        // Load buses view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/buses' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    public function viewSchedules() : string|RedirectResponse
    {
        if ( $redirect = require_admin() ) {
            return $redirect;
        }

        session()->set( 'title', 'Schedules' );
        session()->set( 'active_tab', 'schedules' );

        // Load schedules view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/schedules' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View settings page.
     *
     * @return string|RedirectResponse
     */
    public function viewSettings() : string|RedirectResponse
    {
        if ( $redirect = require_admin() ) {
            return $redirect;
        }

        session()->set( 'title', 'Settings' );
        session()->set( 'active_tab', 'settings' );

        // Load settings view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/settings' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

}
