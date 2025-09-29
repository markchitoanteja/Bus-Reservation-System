<?php

use CodeIgniter\HTTP\RedirectResponse;

if ( !function_exists( 'require_conductor' ) ) {
    /**
     * Checks if user is logged in and is an conductor.
     * Redirects with flashdata if not authorized.
     *
     * @return RedirectResponse|null
     */
    function require_conductor() : ?RedirectResponse
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

        if ( !isset( $user[ 'user_type' ] ) || $user[ 'user_type' ] !== 'conductor' ) {
            $session->setFlashdata( [
                'type'    => 'error',
                'message' => 'Access denied! conductors only.',
            ] );
            return redirect()->to( base_url() );
        }

        return null; // User is conductor
    }
}
