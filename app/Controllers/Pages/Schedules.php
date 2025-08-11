<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;
use App\Models\BusRoutes_Model;
use App\Models\BusTravelSchedules_Model;
use CodeIgniter\HTTP\RedirectResponse;

class Schedules extends BaseController
{

    /**
     * Check if a bus travel schedule already exists for the given date and bus.
     *
     * Receives `date` and `bus_id` from POST data and queries the database
     * to determine if a schedule entry already exists. Returns a JSON
     * response with a boolean `exists` flag.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON response containing the existence status.
     */
    public function checkBusTravelScheduleExists()
    {
        $date  = $this->request->getPost( 'date' );
        $busId = $this->request->getPost( 'bus_id' );

        $schedulesModel = new BusTravelSchedules_Model();

        $exists = $schedulesModel
            ->where( 'date', $date )
            ->where( 'buses_tb_id', $busId )
            ->countAllResults() > 0;

        return $this->response->setJSON( [ 'exists' => $exists ] );
    }

    /**
     * Adds a new bus travel schedule to the database.
     *
     * Retrieves the schedule date and bus ID from the POST request,
     * creates a new schedule record with the current timestamps,
     * and inserts it into the BusTravelSchedules_Model.
     * Sets a flash message indicating success or failure,
     * then redirects back to the previous page.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the previous page after insertion.
     */
    public function addBusTravelSchedule()
    {
        $date  = $this->request->getPost( 'date' );
        $busId = $this->request->getPost( 'bus_id' );

        $schedulesModel = new BusTravelSchedules_Model();

        $data = [ 
            'date'        => $date,
            'buses_tb_id' => $busId,
            'created_at'  => date( 'Y-m-d H:i:s' ),
            'updated_at'  => date( 'Y-m-d H:i:s' ),
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

    /**
     * Edits an existing bus travel schedule.
     *
     * Receives the schedule ID, date, and bus ID from POST data,
     * updates the corresponding record in the BusTravelSchedules_Model,
     * and sets a flash message indicating success or failure.
     * Redirects back to the previous page after the operation.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the previous page after updating.
     */
    public function checkEditBusTravelScheduleExists()
    {
        $busId     = $this->request->getPost( 'bus_id' );
        $date      = $this->request->getPost( 'date' );
        $currentId = $this->request->getPost( 'id' ); // current schedule ID

        $schedulesModel = new BusTravelSchedules_Model();

        $exists = $schedulesModel
            ->where( 'buses_tb_id', $busId )
            ->where( 'date', $date )
            ->where( 'bus_trav_sched_tb_id !=', $currentId ) // direct exclusion
            ->countAllResults() > 0;

        return $this->response->setJSON( [ 'exists' => $exists ] );
    }

    /**
     * Edits an existing bus travel schedule.
     *
     * Receives the schedule ID, date, and bus ID from POST data,
     * updates the corresponding record in the BusTravelSchedules_Model,
     * and sets a flash message indicating success or failure.
     * Redirects back to the previous page after the operation.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the previous page after updating.
     */
    public function editBusTravelSchedule()
    {
        $scheduleId = $this->request->getPost( 'bus_trav_sched_tb_id' ); // schedule ID to update
        $date       = $this->request->getPost( 'date' );
        $busId      = $this->request->getPost( 'bus_id' );

        $schedulesModel = new BusTravelSchedules_Model();

        $data = [ 
            'date'        => $date,
            'buses_tb_id' => $busId,
            'updated_at'  => date( 'Y-m-d H:i:s' ),
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

    /**
     * Deletes a bus travel schedule.
     *
     * Receives the schedule ID from POST data,
     * deletes the corresponding record in the BusTravelSchedules_Model,
     * and sets a flash message indicating success or failure.
     * Redirects back to the previous page after the operation.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the previous page after deletion.
     */
    public function deleteBusTravelSchedule()
    {
        $scheduleId = $this->request->getPost( 'schedule_id' );

        $schedulesModel = new BusTravelSchedules_Model();

        if ( $schedulesModel->delete( $scheduleId ) ) {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Deleted!',
                'text'  => 'Schedule deleted successfully.'
            ] );
        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Failed to delete schedule.'
            ] );
        }

        return redirect()->back();
    }


    public function getBusesByDate()
    {
        $date        = $this->request->getPost( 'date' );
        $currentDate = date( 'Y-m-d' );

        $busesModel = new BusTravelSchedules_Model();

        $availableBuses = $busesModel
            ->select( 'bus_trav_sched_tb.bus_trav_sched_tb_id, buses_tb.buses_tb_id, buses_tb.bus_name, buses_tb.bus_no, buses_tb.bus_type' )
            ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
            ->where( 'bus_trav_sched_tb.date', $date )
            ->where( 'bus_trav_sched_tb.date >=', $currentDate )
            ->findAll();

        return $this->response->setJSON( $availableBuses );
    }


    /**
     * Checks if a bus travel schedule exists for a given route, date, and bus.
     *
     * Accepts 'route_id', 'date', and 'bus_id' parameters via POST and checks
     * for the existence of a matching schedule in the BusTravelSchedules_Model.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON response indicating existence.
     */
    public function checkRouteScheduleExists()
    {
        $routeId = $this->request->getPost( 'route_id' );
        $busId   = $this->request->getPost( 'bus_id' );

        $schedulesModel = new BusRoutes_Model();

        $exists = $schedulesModel
            ->where( 'routes_tb_id', $routeId )
            ->where( 'bus_trav_sched_tb_id', $busId )
            ->countAllResults() > 0;

        return $this->response->setJSON( [ 'exists' => $exists ] );
    }

    /**
     * Adds a new bus travel schedule.
     *
     * Receives the route ID, date, departure time, and bus ID from POST data,
     * creates a new schedule record in the BusTravelSchedules_Model,
     * and sets a flash message indicating success or failure.
     * Redirects back to the previous page after the operation.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the previous page after insertion.
     */
    public function addRouteSchedule()
    {
        $routeId       = $this->request->getPost( 'route_id' );
        $departureTime = $this->request->getPost( 'departure_time' );
        $busId         = $this->request->getPost( 'bus_id' );

        $schedulesModel = new BusRoutes_Model();

        $data = [ 
            'dep_time'             => $departureTime,
            'created_at'           => date( 'Y-m-d H:i:s' ),
            'updated_at'           => date( 'Y-m-d H:i:s' ),
            'routes_tb_id'         => $routeId,
            'bus_trav_sched_tb_id' => $busId,
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

    /**
     * Checks if an edited bus travel schedule exists for a given route, date, and bus.
     *
     * Accepts 'route_id', 'date', 'bus_id', and 'id' (current schedule ID) parameters via POST
     * and checks for the existence of a matching schedule in the BusTravelSchedules_Model.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON response indicating existence.
     */
    public function checkEditRouteScheduleExists()
    {
        $routeId    = $this->request->getPost( 'route_id' );
        $busId      = $this->request->getPost( 'bus_id' );
        $scheduleId = $this->request->getPost( 'schedule_id' );

        $schedulesModel = new BusRoutes_Model();

        $exists = $schedulesModel
            ->where( 'routes_tb_id', $routeId )
            ->where( 'bus_trav_sched_tb_id', $busId )
            ->where( 'bus_routes_tb_id !=', $scheduleId )
            ->countAllResults() > 0;

        return $this->response->setJSON( [ 'exists' => $exists ] );
    }

    /**
     * Edits an existing bus travel schedule.
     *
     * Receives the schedule ID, date, and bus ID from POST data,
     * updates the corresponding record in the BusTravelSchedules_Model,
     * and sets a flash message indicating success or failure.
     * Redirects back to the previous page after the operation.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the previous page after updating.
     */
    public function editRouteSchedule()
    {
        $bus_routes_tb_id = $this->request->getPost( 'bus_routes_tb_id' );
        $routeId          = $this->request->getPost( 'route_id' );
        $departureTime    = $this->request->getPost( 'departure_time' );
        $busId            = $this->request->getPost( 'bus_id' );

        $schedulesModel = new BusRoutes_Model();

        $data = [ 
            'dep_time'             => $departureTime,
            'updated_at'           => date( 'Y-m-d H:i:s' ),
            'routes_tb_id'         => $routeId,
            'bus_trav_sched_tb_id' => $busId,
        ];

        if ( $schedulesModel->update( $bus_routes_tb_id, $data ) ) {
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

    /**
     * Deletes a bus travel schedule.
     *
     * Receives the schedule ID from POST data,
     * deletes the corresponding record in the BusTravelSchedules_Model,
     * and sets a flash message indicating success or failure.
     * Redirects back to the previous page after the operation.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects back to the previous page after deletion.
     */
    public function deleteRouteSchedule()
    {
        $scheduleId     = $this->request->getPost( 'schedule_id' );
        $schedulesModel = new BusRoutes_Model();
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