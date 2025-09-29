<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Models\Conductor_Model;
use App\Models\Passengers_Model;
use App\Models\Bookings_Model;
class Conductor extends BaseController
{
    /**
     * View dashboard page.
     *
     * @return string
     */
    public function index() : string|RedirectResponse
    {
        if ( $redirect = require_conductor() ) {
            return $redirect;
        }

        $conductorModel = new Conductor_Model();

        // Get logged in user ID
        $userId = session()->get( 'user' )[ 'users_id' ];

        // Fetch conductor info based on user_id
        $conductor = $conductorModel
            ->where( 'users_id', $userId )
            ->first();

        if ( $conductor ) {
            session()->set( "conductor", [
                "conductor_id" => $conductor[ "conductor_tb_id" ],
                "bus_id"       => $conductor[ "buses_tb_id" ],
            ] );
        }


        session()->set( 'title', 'Dashboard' );
        session()->set( 'active_tab', 'dashboard' );

        // Load dashboard view if user is conductor
        $headerView = view( 'conductor/main/header' );
        $bodyView   = view( 'conductor/dashboard' );
        $footerView = view( 'conductor/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View bookings page.
     *
     * @return string|RedirectResponse
     */
    public function viewBookings() : string|RedirectResponse
    {
        if ( $redirect = require_conductor() ) {
            return $redirect;
        }

        session()->set( 'title', 'Bookings' );
        session()->set( 'active_tab', 'bookings' );

        // Load bookings view if user is conductor
        $headerView = view( 'conductor/main/header' );
        $bodyView   = view( 'conductor/bookings' );
        $footerView = view( 'conductor/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View passengers page.
     *
     * @return string|RedirectResponse
     */
    public function viewPassengers() : string|RedirectResponse
    {
        if ( $redirect = require_conductor() ) {
            return $redirect;
        }

        session()->set( 'title', 'Passengers' );
        session()->set( 'active_tab', 'passengers' );

        // Load passengers view if user is conductor
        $headerView = view( 'conductor/main/header' );
        $bodyView   = view( 'conductor/passengers' );
        $footerView = view( 'conductor/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";

    }

    /**
     * View routes page.
     *
     * @return string|RedirectResponse
     */
    public function viewRoutes() : string|RedirectResponse
    {
        if ( $redirect = require_conductor() ) {
            return $redirect;
        }

        session()->set( 'title', 'Routes' );
        session()->set( 'active_tab', 'routes' );

        // Load routes view if user is conductor
        $headerView = view( 'conductor/main/header' );
        $bodyView   = view( 'conductor/routes' );
        $footerView = view( 'conductor/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View schedules page.
     *
     * @return string|RedirectResponse
     */
    public function viewSchedules() : string|RedirectResponse
    {
        if ( $redirect = require_conductor() ) {
            return $redirect;
        }

        session()->set( 'title', 'Schedules' );
        session()->set( 'active_tab', 'schedules' );

        // Load schedules view if user is conductor
        $headerView = view( 'conductor/main/header' );
        $bodyView   = view( 'conductor/schedules' );
        $footerView = view( 'conductor/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    /**
     * View ticketing & payment page.
     *
     * @return string|RedirectResponse
     */
    public function viewTicketingPayment() : string|RedirectResponse
    {
        if ( $redirect = require_conductor() ) {
            return $redirect;
        }

        session()->set( 'title', 'Ticketing & Payment' );
        session()->set( 'active_tab', 'ticketing_payment' );

        // Load ticketing & payment view if user is conductor
        $headerView = view( 'conductor/main/header' );
        $bodyView   = view( 'conductor/ticketingPayment' );
        $footerView = view( 'conductor/main/footer' );

        return "{$headerView}{$bodyView}{$footerView}";
    }

    public function fetch()
    {
        $date  = $this->request->getPost( 'date' );
        $busId = session()->get( 'conductor' )[ 'bus_id' ];

        $passengersModel = new Passengers_Model();

        $availablePassengers = $passengersModel
            ->select( 'passengers_tb.*, bookings_tb.*, bus_routes_tb.*, routes_tb.*, bus_trav_sched_tb.*, buses_tb.*, users.*' )
            ->join( 'bookings_tb', 'bookings_tb.bookings_tb_id = passengers_tb.bookings_tb_id' )
            ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
            ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
            ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
            ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
            ->join( 'users', 'users.users_id = bookings_tb.users_id' )
            ->where( 'bus_trav_sched_tb.date', $date )
            ->where( 'buses_tb.buses_tb_id', $busId )
            ->findAll();

        return $this->response->setJSON( $availablePassengers );

    }

    public function fetchBookings()
    {
        $date  = $this->request->getPost( 'date' );
        $busId = session()->get( 'conductor' )[ 'bus_id' ];

        $passengersModel = new Bookings_Model();

        $availableBookings = $passengersModel
            ->select( 'bookings_tb.*, bookings_tb.created_at AS date_created, bus_routes_tb.*,bus_trav_sched_tb.*,routes_tb.*,buses_tb.*,users.*' )
            ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
            ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
            ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
            ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
            ->join( 'users', 'users.users_id = bookings_tb.users_id' )
            ->where( 'bus_trav_sched_tb.date', $date )
            ->where( 'buses_tb.buses_tb_id', $busId ) // ✅ only bookings for this bus
            ->orderBy( 'bus_trav_sched_tb.date', 'ASC' )
            ->findAll();

        return $this->response->setJSON( $availableBookings );

    }

    public function getPassengers()
    {
        $bookingId      = $this->request->getPost( 'booking_id' );
        $passengerModel = new Passengers_Model();

        $passengers = $passengerModel->where( 'bookings_tb_id', $bookingId )->findAll();

        return $this->response->setJSON( [
            'success'    => true,
            'passengers' => $passengers
        ] );
    }

    public function markFullyPaid()
    {
        $bookingId     = $this->request->getPost( 'id' );
        $bookingAmount = $this->request->getPost( 'amount' );
        $bookingsModel = new Bookings_Model();

        $bookingsModel->where( 'bookings_tb_id', $bookingId )
            ->set( [ 'payment_status' => 'Fully Paid' ] )
            ->set( [ 'amount_paid' => $bookingAmount ] )
            ->update();

        if ( $bookingsModel ) {
            session()->setFlashdata( 'swalAlert', [
                'icon'  => 'success',
                'title' => 'Success!',
                'text'  => 'Booking marked as Fully Paid.'
            ] );
            return $this->response->setJSON( [
                'success' => true,
                'message' => 'Booking marked as Fully Paid.'
            ] );
        }

        session()->setFlashdata( 'swalAlert', [
            'icon'  => 'error',
            'title' => 'Error!',
            'text'  => 'Failed to update booking. Please try again.'
        ] );
        return redirect()->back();
    }

    public function markNotPaid()
    {
        $bookingId     = $this->request->getPost( 'id' );
        $bookingsModel = new Bookings_Model();

        $bookingsModel->where( 'bookings_tb_id', $bookingId )
            ->set( [ 'payment_status' => 'Cash on Board' ] )
            ->set( [ 'amount_paid' => 0 ] )
            ->update();

        if ( $bookingsModel ) {
            session()->setFlashdata( 'swalAlert', [
                'icon'  => 'success',
                'title' => 'Success!',
                'text'  => 'Booking marked as not Paid.'
            ] );
            return $this->response->setJSON( [
                'success' => true,
                'message' => 'Booking marked as not Paid.'
            ] );
        }

        session()->setFlashdata( 'swalAlert', [
            'icon'  => 'error',
            'title' => 'Error!',
            'text'  => 'Failed to update booking. Please try again.'
        ] );
        return redirect()->back();
    }
}
