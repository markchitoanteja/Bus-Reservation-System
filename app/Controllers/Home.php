<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Assuming you have a session or auth service to check user data
        $session = session();

        if ($session->has('user')) {
            // User data present, redirect to admin
            return redirect()->to(base_url('admin'));
        }

        // No user data, load the home view
        return view('home');
    }
}