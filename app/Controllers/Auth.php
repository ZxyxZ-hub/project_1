<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Show login page
    public function login()
    {
        $session = session();

        // If already logged in, route to the proper dashboard instead
        if ($session->get('logged_in')) {
            if ($session->get('role') === 'admin') {
                return redirect()->to('/admin');
            }

            return redirect()->to('/form');
        }

        return view('auth/login');
    }

    // Handle login form submission
    public function loginSubmit()
    {
        $username = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username not found');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Invalid password');
        }

        if ($user['status'] !== 'approved') {
            return redirect()->back()->with('error', 'Your account is pending approval');
        }

        // Set session
        session()->set([
            'user_id' => $user['id'],
            'username' => $user['email'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'logged_in' => true
        ]);

        // Redirect based on role
        if ($user['role'] === 'admin') {
            return redirect()->to('/admin');
        }

        return redirect()->to('/form');
    }

    // Show signup page
    public function signup()
    {
        return view('auth/signup');
    }

    // Handle signup form submission
    public function signupSubmit()
    {
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|min_length[3]|max_length[100]|is_unique[users.email]',
            'password' => 'required|min_length[6]|max_length[255]',
            'password_confirm' => 'required|min_length[6]|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => 'pending',
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/auth/login')->with('success', 'Account created successfully! Please wait for admin approval.');
        }

        return redirect()->back()->with('error', 'Failed to create account');
    }

    // Handle logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Logged out successfully');
    }
}
