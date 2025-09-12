<?php
namespace App\Controllers;

use App\Models\Bookings_Model;
use App\Models\Passengers_Model;
use App\Models\Notifications_Model;

class MyBookings extends BaseController
{
    public function cancelBooking()
    {
        $bookingsModel      = new Bookings_Model();
        $passengersModel    = new Passengers_Model();
        $notificationsModel = new Notifications_Model();

        $bookingId = $this->request->getPost( 'id' );

        $booking = $bookingsModel->find( $bookingId );

        // Prevent cancellation if status is Ongoing
        if ( $booking[ 'status' ] === 'Ongoing' ) {
            session()->setFlashdata( [ 
                "type"    => "error",
                "message" => "Ongoing bookings cannot be cancelled."
            ] );

            return $this->response->setJSON( [ 
                "success" => true,
            ] );
        }

        if ( $bookingsModel->update( $bookingId, [ 'status' => 'Cancelled' ] ) ) {

            $passengersModel
                ->where( 'bookings_tb_id', $bookingId )
                ->set( [ 'travel_status' => 'Cancelled' ] )
                ->update();

            $notificationsModel->insert( [ 
                'notify_for' => 'Booking Cancelled',
                'which_tb'   => 'bookings_tb',
                'tb_id'      => $bookingId,
                'status'     => 'Unseen',
            ] );
            session()->setFlashdata( [ 
                "type"    => "success",
                "message" => "Booking cancelled successfully."
            ] );

            return $this->response->setJSON( [ 
                "success" => true,
            ] );
        }

        return $this->response->setJSON( [ 'success' => false, 'message' => 'Failed to cancel booking.' ] );
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


}