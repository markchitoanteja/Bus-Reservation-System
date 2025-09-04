<?php

use CodeIgniter\HTTP\RedirectResponse;

if ( !function_exists( 'require_user' ) ) {
    /**
     * Checks if user is logged in and is a regular user.
     * Redirects with flashdata if not authorized.
     *
     * @return RedirectResponse|null
     */
    function require_user() : ?RedirectResponse
    {
        $session = session();

        // Check if logged in
        if ( !$session->has( 'user' ) ) {
            $session->setFlashdata( [ 
                'type'    => 'error',
                'message' => 'You must log in first!',
            ] );
            return redirect()->to( base_url() );
        }

        $user = $session->get( 'user' );

        // Check if user type is "user"
        if ( !isset( $user[ 'user_type' ] ) || $user[ 'user_type' ] !== 'user' ) {
            $session->setFlashdata( [ 
                'type'    => 'error',
                'message' => 'Access denied! Users only.',
            ] );
            return redirect()->to( base_url() );
        }

        return null; // User is allowed
    }
}
