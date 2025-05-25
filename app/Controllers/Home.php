<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();

        if ($session->has('user')) {
            $user = $session->get('user');

            // Check if user_type is 'user'
            if (isset($user['user_type']) && $user['user_type'] === 'user') {
                // User is logged in and is a 'user'
                // You can load a user-specific view or redirect somewhere else
                return view('home');  // example user dashboard view
            } else {
                // User is logged in but NOT a 'user' (e.g., admin or other)
                // Redirect to admin or another appropriate place
                return redirect()->to(base_url('admin'));
            }
        }

        // No user data in session, load the public home page
        return view('home');
    }
}
