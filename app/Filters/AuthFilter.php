<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Check if user is logged in
        if (!$session->get('logged_in')) {
            return redirect()->to(base_url('auth/login'));
        }

        // If route requires admin role, check it
        if ($arguments && in_array('admin', $arguments)) {
            if ($session->get('role') !== 'admin') {
                // Use a safe fallback instead of redirect()->back() to avoid loops
                return redirect()->to('/')->with('error', 'You do not have permission to access this page');
            }
        }

        // If route requires user role, check it
        if ($arguments && in_array('user', $arguments)) {
            if (!in_array($session->get('role'), ['user', 'admin'])) {
                return redirect()->to('/')->with('error', 'You do not have permission to access this page');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing on response
    }
}
