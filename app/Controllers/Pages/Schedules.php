<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\Schedules_Model;

class Schedules extends BaseController
{
    public function checkScheduleExists()
    {
        $routeId = $this->request->getPost( 'route_id' );
        $date    = $this->request->getPost( 'date' );
        $busId   = $this->request->getPost( 'bus_id' );

        $schedulesModel = new Schedules_Model();

        $exists = $schedulesModel
            ->where( 'routes_tb_id', $routeId )
            ->where( 'date', $date )
            ->where( 'buses_tb_id', $busId )
            ->countAllResults() > 0;

        return $this->response->setJSON( [ 'exists' => $exists ] );
    }

    public function checkEditScheduleExists()
    {
        $routeId   = $this->request->getPost( 'route_id' );
        $date      = $this->request->getPost( 'date' );
        $busId     = $this->request->getPost( 'bus_id' );
        $currentId = $this->request->getPost( 'id' ); // current schedule ID

        $schedulesModel = new Schedules_Model();

        $exists = $schedulesModel
            ->where( 'routes_tb_id', $routeId )
            ->where( 'date', $date )
            ->where( 'buses_tb_id', $busId )
            ->where( 'bus_trav_sched_tb_id !=', $currentId ) // direct exclusion
            ->countAllResults() > 0;

        return $this->response->setJSON( [ 'exists' => $exists ] );
    }

    public function addSchedule()
    {
        $routeId       = $this->request->getPost( 'route_id' );
        $date          = $this->request->getPost( 'date' );
        $departureTime = $this->request->getPost( 'departure_time' );
        $busId         = $this->request->getPost( 'bus_id' );

        $schedulesModel = new Schedules_Model();

        $data = [ 
            'date'         => $date,
            'dep_time'     => $departureTime,
            'buses_tb_id'  => $busId,
            'routes_tb_id' => $routeId,
            'created_at'   => date( 'Y-m-d H:i:s' ),
            'updated_at'   => date( 'Y-m-d H:i:s' ),
        ];

        if ( $schedulesModel->insert( $data ) ) {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Added!',
                'text'  => 'Schedule added successfully.'
            ] );

        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Failed to add schedule.'
            ] );
        }
        return redirect()->back();
    }

    public function editSchedule()
    {
        $scheduleId    = $this->request->getPost( 'schedule_id' ); // schedule ID to update
        $routeId       = $this->request->getPost( 'route_id' );
        $date          = $this->request->getPost( 'date' );
        $departureTime = $this->request->getPost( 'departure_time' );
        $busId         = $this->request->getPost( 'bus_id' );

        $schedulesModel = new Schedules_Model();

        $data = [ 
            'date'         => $date,
            'dep_time'     => $departureTime,
            'buses_tb_id'  => $busId,
            'routes_tb_id' => $routeId,
            'updated_at'   => date( 'Y-m-d H:i:s' ),
        ];

        if ( $schedulesModel->update( $scheduleId, $data ) ) {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Updated!',
                'text'  => 'Schedule updated successfully.'
            ] );
        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Failed to update schedule.'
            ] );
        }

        return redirect()->back();
    }

    public function deleteSchedule()
    {
        $scheduleId     = $this->request->getPost( 'schedule_id' );
        $schedulesModel = new Schedules_Model();
        $schedule       = $schedulesModel->find( $scheduleId );

        if ( $schedule ) {
            $schedulesModel->delete( $scheduleId );
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Deleted!',
                'text'  => 'Schedule deleted successfully.'
            ] );


        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Schedule not found.'
            ] );
        }

        return redirect()->back();

    }
}