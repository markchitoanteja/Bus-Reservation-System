<?php

use App\Models\Notifications_Model;

if ( !function_exists( 'getNotificationsData' ) ) {
    function getNotificationsData()
    {
        $model = new Notifications_Model();



        // Count grouped by notify_for, with latest timestamp
        $data[ 'per_type' ] = $model->select( 'notify_for, COUNT(*) as total, MAX(created_at) as last_time' )
            ->where( 'status', 'Unseen' )
            ->groupBy( 'notify_for' )
            ->orderBy( 'last_time', 'DESC' )
            ->findAll();

        // Total notifications
        $data[ 'count' ] = $model
            ->where( 'status', 'Unseen' )
            ->countAllResults();
        return $data;
    }
}

if ( !function_exists( 'timeAgo' ) ) {
    function timeAgo( $datetime )
    {
        $timestamp = strtotime( $datetime );
        $diff      = time() - $timestamp;

        if ( $diff < 5 ) {
            return "Just now";
        } elseif ( $diff < 60 ) {
            return $diff . "s ago";
        } elseif ( $diff < 3600 ) {
            return floor( $diff / 60 ) . "m ago";
        } elseif ( $diff < 86400 ) {
            return floor( $diff / 3600 ) . "h ago";
        } elseif ( $diff < 604800 ) {
            return floor( $diff / 86400 ) . "d ago";
        } else {
            return date( "M d", $timestamp );
        }
    }
}

if ( !function_exists( 'getNotifIcon' ) ) {
    function getNotifIcon( $type )
    {
        $icons = [ 
            'New Booking'        => 'fas fa-bus',
            'Booking Cancelled'  => 'fas fa-bus',
            'Boarding'           => 'fas fa-users',
            'In Transit'         => 'fas fa-users',
            'Arrived'            => 'fas fa-users',
            'Completed'          => 'fas fa-users',
            'Cancelled'          => 'fas fa-users',
            'Stranded'           => 'fas fa-users',
            'Delayed'            => 'fas fa-users',
            'New User'           => 'fas fa-user-plus',
            'System Maintenance' => 'fas fa-cogs',
            'Default'            => 'fas fa-info-circle'
        ];

        return $icons[ $type ] ?? $icons[ 'Default' ];
    }
}
