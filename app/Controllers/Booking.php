<?php
namespace App\Controllers;
use App\Models\BusRoutes_Model;
use App\Models\BusTravelSchedules_Model;
class Booking extends BaseController
{
    public function getAvailableBuses()
    {
        $route       = $this->request->getPost( 'route' );
        $date        = $this->request->getPost( 'date' );
        $currentDate = date( 'Y-m-d' );

        $busRoutesModel = new BusRoutes_Model();

        $availableBuses = $busRoutesModel
            ->select( '
            bus_trav_sched_tb.bus_trav_sched_tb_id, 
            buses_tb.buses_tb_id, 
            buses_tb.bus_name, 
            buses_tb.bus_no, 
            buses_tb.bus_type
        ' )
            ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
            ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
            ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
            ->where( 'routes_tb.routes_tb_id', $route )
            ->where( 'bus_trav_sched_tb.date', $date )
            ->where( 'bus_trav_sched_tb.date >=', $currentDate )
            ->findAll();

        return $this->response->setJSON( $availableBuses );
    }

    public function getBusAvailableSeats()
    {
        $busId = $this->request->getPost( 'busId' );
        $date  = $this->request->getPost( 'date' );

        $busRoutesModel = new BusTravelSchedules_Model();

        $availableSeats = $busRoutesModel
            ->select( 'bus_trav_sched_tb.bus_trav_sched_tb_id, bus_trav_sched_tb.occupied_seats' )
            ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
            ->where( 'bus_trav_sched_tb.bus_trav_sched_tb_id', $busId )
            ->where( 'bus_trav_sched_tb.date', $date )
            ->first();





        return $this->response->setJSON( $availableSeats );
    }

}