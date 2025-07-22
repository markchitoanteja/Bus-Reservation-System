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

        // Load bookings view if user is admin
        $headerView = view( 'admin/main/header' );
        $bodyView   = view( 'admin/bookings' );
        $footerView = view( 'admin/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }
}
