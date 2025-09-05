<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\Passengers_Model;
class Passengers extends BaseController
{
    public function fetch()
    {
        $date  = $this->request->getPost( 'date' );
        $busId = $this->request->getPost( 'bus_id' );


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

}
