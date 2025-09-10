<?php

namespace App\Controllers;

use App\Models\Notifications_Model;
use CodeIgniter\Controller;

class Notifications extends Controller
{
    public function CheckUpdatesNotifications()
    {
        $model = new Notifications_Model();

        // Get the latest update (created or updated)
        $lastRow = $model
            ->select( "GREATEST(MAX(created_at), MAX(updated_at)) as last_updated", false )
            ->first();

        $lastUpdated = $lastRow[ 'last_updated' ] ?? null;

        // Get actual notification data
        $notifications = getNotificationsData();

        $notifications[ 'last_updated' ] = $lastUpdated;

        return $this->response->setJSON( $notifications );
    }

    public function fetchUpdatesNotifications()
    {
        $model = new Notifications_Model();



        // Count grouped by notify_for, with latest timestamp
        $data[ 'per_type' ] = $model->select( 'notifications_tb_id, notify_for, COUNT(*) as total, MAX(created_at) as last_time' )
            ->where( 'status', 'Unseen' )
            ->groupBy( 'notify_for' )
            ->orderBy( 'last_time', 'DESC' )
            ->findAll();

        // Total notifications
        $data[ 'count' ] = $model
            ->where( 'status', 'Unseen' )
            ->countAllResults();

        return $this->response->setJSON( $data );
    }

    public function markAsSeen()
    {
        $notifyFor = $this->request->getPost( 'notifyFor' );

        $model = new Notifications_Model();

        $model->where( 'notify_for', $notifyFor )
            ->set( [ 'status' => 'Seen' ] )
            ->update();

        return $this->response->setJSON( [ 'status' => 'success' ] );

    }
}