<?php
namespace App\Controllers;
use App\Models\BusRoutes_Model;
use App\Models\BusTravelSchedules_Model;
use App\Models\Bookings_Model;
use App\Models\Passengers_Model;

class Booking extends BaseController
{
    public function getAvailableBuses()
    {
        $route       = $this->request->getPost( 'route' );
        $date        = $this->request->getPost( 'date' );
        $currentDate = date( 'Y-m-d' );

        $busRoutesModel = new BusRoutes_Model();

        $availableBuses = $busRoutesModel
            ->select( 'bus_routes_tb.*,
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

        $busRoutesModel = new BusRoutes_Model();
        $availableSeats = $busRoutesModel
            ->select( 'bus_routes_tb.*, bus_trav_sched_tb.bus_trav_sched_tb_id, bus_trav_sched_tb.occupied_seats' )
            ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
            ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
            ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
            ->where( 'bus_routes_tb.bus_routes_tb_id', $busId )
            ->where( 'bus_trav_sched_tb.date', $date )
            ->first();





        return $this->response->setJSON( $availableSeats );
    }

    function submitBooking()
    {
        if ( $redirect = require_user() ) {
            return $redirect;
        }
        $bookingModel            = new Bookings_Model();
        $routeModel              = new BusRoutes_Model();
        $busTravelSchedulesModel = new BusTravelSchedules_Model();
        $passengerModel          = new Passengers_Model();
        // Clean input
        // $bus_routes_tb_id        = trim( $this->request->getPost( 'bus' ) );
        $passengerCount   = (int) $this->request->getPost( 'passenger' );
        $seats            = trim( $this->request->getPost( 'seats' ) ); // e.g. "L1,M1,R1"
        $paymentMethod    = trim( $this->request->getPost( 'payment_method' ) );
        $busValue         = trim( $this->request->getPost( 'bus' ) ); // e.g. "5-10"
        $passengerNames   = $this->request->getPost( 'passenger_names' );
        $passengerAges    = $this->request->getPost( 'passenger_ages' );
        $passengerGenders = $this->request->getPost( 'passenger_genders' );
        // Split by dash
        list( $bus_routes_tb_id, $bus_trav_sched_tb_id ) = explode( '-', $busValue );
        // Default data
        $amount = 0;
        $status = 'Upcoming';

        // Get route fare
        $builder = $routeModel
            ->select( 'bus_routes_tb.*, routes_tb.ordinary_fare, routes_tb.aircon_fare, buses_tb.bus_type' )
            ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
            ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
            ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
            ->where( 'bus_routes_tb.bus_routes_tb_id', $bus_routes_tb_id )
            ->first(); // get a single row

        if ( $builder ) {
            $fare = $builder[ 'bus_type' ] === 'Ordinary'
                ? $builder[ 'ordinary_fare' ]
                : $builder[ 'aircon_fare' ];

            $amount = $fare * $passengerCount;
        }

        $bookingRef = generateBookingRef();
        // Data to insert
        $data = [ 
            'booking_ref'      => $bookingRef,
            'status'           => $status,
            'no_of_passenger'  => $passengerCount,
            'seats'            => $seats,
            'amount'           => $amount,
            'payment_method'   => $paymentMethod,
            'payment_status'   => 'Cash on Board',
            'created_at'       => date( 'Y-m-d H:i:s' ),
            'bus_routes_tb_id' => $bus_routes_tb_id,
            'users_id'         => session()->get( "user" )[ "id" ],
        ];

        // Insert booking
        $inserted = $bookingModel->insert( $data );
        // Get inserted booking_id
        $bookingId = $bookingModel->getInsertID();

        foreach ( $passengerNames as $index => $name ) {
            $passengerModel->insert( [ 
                'passengers_name' => trim( $name ),
                'age'             => $passengerAges[ $index ],
                'gender'          => $passengerGenders[ $index ],
                'created_at'      => date( 'Y-m-d H:i:s' ),
                'bookings_tb_id'  => $bookingId,
            ] );
        }

        if ( $inserted ) {
            $update = $busTravelSchedulesModel->set( 'occupied_seats', "CONCAT(IFNULL(occupied_seats, ''), ',', '{$seats}')", false )
                ->where( 'bus_trav_sched_tb_id', $bus_trav_sched_tb_id )
                ->update();

            if ( $update ) {
                session()->setFlashdata( [ 
                    "type"    => "success",
                    'message' => 'Booking completed successfully.'
                ] );
            }

        } else {
            session()->setFlashdata( [ 
                "type"    => "error",
                'title'   => 'Error!',
                'message' => 'Booking failed. Please try again.'
            ] );
        }

        return redirect()->to( base_url() . '/#booking' );

    }

}