<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\Buses_Model;

class Buses extends BaseController
{
    /**
     * Check if bus number already exists.
     *
     * @return RedirectResponse
     */
    public function checkBusExists()
    {
        $busName = ucwords( trim( $this->request->getPost( 'bus_name' ) ) );
        $busNo   = trim( $this->request->getPost( 'bus_number' ) );

        $busesModel = new Buses_Model();
        $exists     = $busesModel
            ->where( 'bus_no', $busNo )
            ->Where( 'bus_name', $busName )
            ->first();

        return $this->response->setJSON( [ 'exists' => $exists ? true : false ] );
    }

    /**
     * Check if edit bus number already exists.
     *
     * @return RedirectResponse
     */
    public function checkEditBusExists()
    {
        $busName = ucwords( trim( $this->request->getPost( 'bus_name' ) ) );
        $busNo   = trim( $this->request->getPost( 'bus_number' ) );
        $busId   = $this->request->getPost( 'bus_id' ); // Get current bus ID (if any)

        $busesModel = new Buses_Model();

        // Build query
        $query = $busesModel
            ->where( 'bus_no', $busNo )
            ->where( 'bus_name', $busName );

        if ( !empty( $busId ) ) {
            // Exclude the current bus by ID
            $query->where( 'buses_tb_id !=', $busId );
        }

        $exists = $query->first();

        return $this->response->setJSON( [ 'exists' => $exists ? true : false ] );
    }

    /**
     * Add a new bus.
     *
     * @return RedirectResponse
     */
    public function addBus()
    {
        $busName = ucwords( trim( $this->request->getPost( 'bus_name' ) ) );
        $busNo   = trim( $this->request->getPost( 'bus_number' ) );
        $busType = trim( $this->request->getPost( 'bus_type' ) );

        // Create a new bus entry
        $busesModel = new Buses_Model();

        $data = [ 
            'bus_name'   => $busName,
            'bus_no'     => $busNo,
            'bus_type'   => $busType,
            'created_at' => date( 'Y-m-d H:i:s' ),
            'updated_at' => date( 'Y-m-d H:i:s' ),
        ];

        $inserted = $busesModel->insert( $data );

        if ( $inserted ) {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Success!',
                'text'  => 'Bus added successfully.'
            ] );
        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Failed to add bus. Please try again.'
            ] );
        }

        return redirect()->back();
    }

    /**
     * Edit an existing bus.
     *
     * @return RedirectResponse
     */
    public function editBus()
    {
        $busId   = $this->request->getPost( 'bus_id' );
        $busName = ucwords( trim( $this->request->getPost( 'bus_name' ) ) );
        $busNo   = trim( $this->request->getPost( 'bus_number' ) );
        $busType = $this->request->getPost( 'bus_type' );

        $busesModel = new Buses_Model();


        $updateData = [ 
            'bus_name'   => $busName,
            'bus_no'     => $busNo,
            'bus_type'   => $busType,
            'updated_at' => date( 'Y-m-d H:i:s' ) // set manually
        ];

        $busesModel->update( $busId, $updateData );

        if ( $busesModel->affectedRows() > 0 ) {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Updated!',
                'text'  => 'Bus information updated successfully.'
            ] );
        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Failed to update bus information. Please try again.'
            ] );
        }
        return redirect()->back();
    }

    /**
     * Delete a bus.
     *
     * @return RedirectResponse
     */
    public function deleteBus()
    {
        $busId    = $this->request->getPost( 'bus_id' );
        $busModel = new Buses_Model();
        $bus      = $busModel->find( $busId );

        if ( $bus ) {
            $busModel->delete( $busId );
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'success',
                'title' => 'Deleted!',
                'text'  => 'Bus deleted successfully.'
            ] );


        } else {
            session()->setFlashdata( 'swalAlert', [ 
                'icon'  => 'error',
                'title' => 'Error!',
                'text'  => 'Bus not found.'
            ] );
        }

        return redirect()->back();

    }


}
