<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Admin extends BaseController
{
    public function index(): string|RedirectResponse
    {
        // Check if user is logged in (assuming 'user' key in session)
        if (!session()->has('user')) {
            // Set flashdata message
            session()->setFlashdata([
                'type' => 'error',
                'message' => 'You must log in first!',
            ]);

            // Redirect to base URL
            return redirect()->to(base_url());
        }

        // Load dashboard view if user exists
        return view('admin/dashboard');
    }
}
