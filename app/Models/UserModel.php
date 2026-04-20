<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['email', 'password', 'full_name', 'role', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = false;

    public function getPendingUsers()
    {
        return $this->where('status', 'pending')->findAll();
    }

    public function getApprovedUsers()
    {
        return $this->where('status', 'approved')->findAll();
    }

    public function approveUser($userId, $role = 'user')
    {
        return $this->update($userId, [
            'status' => 'approved',
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function rejectUser($userId)
    {
        return $this->delete($userId);
    }

    public function updateRole($userId, $role)
    {
        return $this->update($userId, [
            'role' => $role,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function updatePassword($userId, $password)
    {
        return $this->update($userId, [
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}
