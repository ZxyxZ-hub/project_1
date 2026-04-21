<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Show admin dashboard
    public function index()
    {
        $data = [
            'pendingUsers' => $this->userModel->where('status', 'pending')->findAll(),
            'approvedUsers' => $this->userModel->where('status', 'approved')->findAll(),
        ];

        return view('admin/dashboard', $data);
    }

    // Approve a pending user
    public function approveUser($userId)
    {
        $role = $this->request->getPost('role') ?? 'user';

        if (!$userId) {
            return redirect()->back()->with('error', 'Invalid user ID');
        }

        $updated = $this->userModel->update($userId, [
            'status' => 'approved',
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updated !== false) {
            return redirect()->back()->with('success', 'User approved successfully');
        }

        return redirect()->back()->with('error', 'Failed to approve user');
    }

    // Deny/reject a pending user
    public function denyUser($userId)
    {
        if (!$userId) {
            return redirect()->back()->with('error', 'Invalid user ID');
        }

        $deleted = $this->userModel->delete($userId);

        if ($deleted) {
            return redirect()->back()->with('success', 'User denied successfully');
        }

        return redirect()->back()->with('error', 'Failed to deny user');
    }

    // Update user role
    public function updateRole($userId)
    {
        $role = $this->request->getPost('role');

        if (!$userId || !$role) {
            return redirect()->back()->with('error', 'Invalid user ID or role');
        }

        $updated = $this->userModel->update($userId, [
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updated !== false) {
            return redirect()->back()->with('success', 'Role updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update role');
    }

    // Reset user password
    public function resetPassword($userId)
    {
        $password = $this->request->getPost('password');

        if (!$userId || !$password) {
            return redirect()->back()->with('error', 'Invalid user ID or password');
        }

        $updated = $this->userModel->update($userId, [
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updated !== false) {
            return redirect()->back()->with('success', 'Password reset successfully');
        }

        return redirect()->back()->with('error', 'Failed to reset password');
    }

    // Delete an approved user
    public function deleteUser($userId)
    {
        if (!$userId) {
            return redirect()->back()->with('error', 'Invalid user ID');
        }

        $deleted = $this->userModel->delete($userId);

        if ($deleted) {
            return redirect()->back()->with('success', 'User deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete user');
    }
}
