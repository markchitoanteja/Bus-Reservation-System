<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\Routes_Model;

class Routes extends BaseController
{
    public function checkRouteExists()
    {
        $origin      = ucwords( trim( $this->request->getPost( 'route_origin' ) ) );
        $destination = ucwords( trim( $this->request->getPost( 'route_destination' ) ) );

        $routesModel = new Routes_Model();

        $exists = $routesModel
            ->where( 'origin', $origin )
            ->where( 'destination', $destination )
            ->first();

        return $this->response->setJSON( [ 'exists' => $exists ? true : false ] );
    }

    public function checkEditRouteExists()
    {
        $routeOrigin      = ucwords( trim( $this->request->getPost( 'route_origin' ) ) );
        $routeDestination = ucwords( trim( $this->request->getPost( 'route_destination' ) ) );
        $routeId          = $this->request->getPost( 'route_id' ); // Get current route ID (if any)

        $routesModel = new Routes_Model();

        // Build query
        $query = $routesModel
            ->where( 'origin', $routeOrigin )
            ->where( 'destination', $routeDestination );

        if ( !empty( $routeId ) ) {
            // Exclude the current route by ID
            $query->where( 'routes_tb_id !=', $routeId );
        }

        $exists = $query->first();

        return $this->response->setJSON( [ 'exists' => $exists ? true : false ] );
    }

    public function addRoute()
    {
        $origin      = ucwords( trim( $this->request->getPost( 'origin' ) ) );
        $destination = ucwords( trim( $this->request->getPost( 'destination' ) ) );

        $routesModel = new Routes_Model();

        $data = [ 
            'origin'      => $origin,
            'destination' => $destination,
            'created_at'  => date( 'Y-m-d H:i:s' ),
            'updated_at'  => date( 'Y-m-d H:i:s' ),
        ];

        $inserted = $routesModel->insert( $data );

        if ( $inserted ) {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Success!',
                'text'  => 'Route added successfully.'
            ] );
        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Failed to add route. Please try again.'
            ] );
        }

        return redirect()->back();
    }

    public function editRoute()
    {
        $routeId          = $this->request->getPost( 'route_id' );
        $routeOrigin      = ucwords( trim( $this->request->getPost( 'origin' ) ) );
        $routeDestination = ucwords( trim( $this->request->getPost( 'destination' ) ) );

        $routesModel = new Routes_Model();

        $updateData = [ 
            'origin'      => $routeOrigin,
            'destination' => $routeDestination,
            'updated_at'  => date( 'Y-m-d H:i:s' ) // set manually
        ];

        $routesModel->update( $routeId, $updateData );

        if ( $routesModel->affectedRows() > 0 ) {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Updated!',
                'text'  => 'Route information updated successfully.'
            ] );
        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Failed to update route information. Please try again.'
            ] );
        }
        return redirect()->back();
    }

    public function deleteRoute()
    {
        $routeId     = $this->request->getPost( 'route_id' );
        $routesModel = new Routes_Model();
        $route       = $routesModel->find( $routeId );

        if ( $route ) {
            $routesModel->delete( $routeId );
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Deleted!',
                'text'  => 'Route deleted successfully.'
            ] );


        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Route not found.'
            ] );
        }

        return redirect()->back();

    }

}