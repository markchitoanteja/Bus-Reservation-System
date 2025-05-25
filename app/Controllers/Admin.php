<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Admin extends BaseController
{
    public function index(): string|RedirectResponse
    {
        $session = session();

        // Check if 'user' exists in session
        if (!$session->has('user')) {
            $session->setFlashdata([
                'type' => 'error',
                'message' => 'You must log in first!',
            ]);
            return redirect()->to(base_url());
        }

        // Get user data from session
        $user = $session->get('user');

        // Check if user_type is 'admin'
        if (!isset($user['user_type']) || $user['user_type'] !== 'admin') {
            $session->setFlashdata([
                'type' => 'error',
                'message' => 'Access denied! Admins only.',
            ]);
            
            return redirect()->to(base_url());
        }

        // Load dashboard view if user is admin
        return view('admin/dashboard');
    }
}
