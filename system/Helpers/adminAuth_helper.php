<?php

use CodeIgniter\HTTP\RedirectResponse;

if ( !function_exists( 'require_admin' ) ) {
    /**
     * Checks if user is logged in and is an admin.
     * Redirects with flashdata if not authorized.
     *
     * @return RedirectResponse|null
     */
    function require_admin() : ?RedirectResponse
    {
        $session = session();

        if ( !$session->has( 'user' ) ) {
            $session->setFlashdata( [ 
                'type'    => 'error',
                'message' => 'You must log in first!',
            ] );
            return redirect()->to( base_url() );
        }

        $user = $session->get( 'user' );

        if ( !isset( $user[ 'user_type' ] ) || $user[ 'user_type' ] !== 'admin' ) {
            $session->setFlashdata( [ 
                'type'    => 'error',
                'message' => 'Access denied! Admins only.',
            ] );
            return redirect()->to( base_url() );
        }

        return null; // User is admin
    }
}
