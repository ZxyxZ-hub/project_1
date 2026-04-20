<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Admin extends ResourceController
{
    protected $userModel;
    protected $format = 'json';

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
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Method not allowed', 405);
        }

        $role = $this->request->getPost('role') ?? 'user';

        $updated = $this->userModel->update($userId, [
            'status' => 'approved',
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updated) {
            return $this->respond(['success' => true, 'message' => 'User approved successfully']);
        }

        return $this->fail('Failed to approve user');
    }

    // Deny/reject a pending user
    public function denyUser($userId)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Method not allowed', 405);
        }

        $deleted = $this->userModel->delete($userId);

        if ($deleted) {
            return $this->respond(['success' => true, 'message' => 'User denied successfully']);
        }

        return $this->fail('Failed to deny user');
    }

    // Update user role
    public function updateRole($userId)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Method not allowed', 405);
        }

        $newRole = $this->request->getPost('role');

        if (!in_array($newRole, ['user', 'admin'])) {
            return $this->fail('Invalid role');
        }

        $updated = $this->userModel->update($userId, [
            'role' => $newRole,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updated) {
            return $this->respond(['success' => true, 'message' => 'Role updated successfully']);
        }

        return $this->fail('Failed to update role');
    }

    // Reset user password
    public function resetPassword($userId)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Method not allowed', 405);
        }

        $newPassword = $this->request->getPost('password');

        if (strlen($newPassword) < 6) {
            return $this->fail('Password must be at least 6 characters');
        }

        $updated = $this->userModel->update($userId, [
            'password' => password_hash($newPassword, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($updated) {
            return $this->respond(['success' => true, 'message' => 'Password reset successfully']);
        }

        return $this->fail('Failed to reset password');
    }

    // Delete an approved user
    public function deleteUser($userId)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->fail('Method not allowed', 405);
        }

        $deleted = $this->userModel->delete($userId);

        if ($deleted) {
            return $this->respond(['success' => true, 'message' => 'User deleted successfully']);
        }

        return $this->fail('Failed to delete user');
    }
}
