<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use App\Models\HistoryModel;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function getSidebarStats(): array
    {
        $stats = [
            'pendingRequested' => 0,
            'pendingAccepted' => 0,
            'historyCreated' => 0,
            'historyDeleted' => 0,
        ];

        try {
            $stats['pendingRequested'] = (new UserModel())->where('status', 'pending')->countAllResults();
            $stats['pendingAccepted'] = (new UserModel())->where('status', 'approved')->countAllResults();
        } catch (\Throwable $e) {
            log_message('error', 'Failed to load user sidebar stats: ' . $e->getMessage());
        }

        try {
            $historyModel = new HistoryModel();
            $stats['historyCreated'] = $historyModel->where('action', 'created')->countAllResults();
            $stats['historyDeleted'] = $historyModel->where('action', 'deleted')->countAllResults();
        } catch (\Throwable $e) {
            log_message('error', 'Failed to load history sidebar stats: ' . $e->getMessage());
        }

        return $stats;
    }

    // Show history list (create/delete events)
    public function history()
    {
        $historyModel = new HistoryModel();
        try {
            $data['created'] = $historyModel->where('action', 'created')->orderBy('action_at', 'DESC')->findAll();
            $data['deleted'] = $historyModel->where('action', 'deleted')->orderBy('action_at', 'DESC')->findAll();
            $data = array_merge($data, $this->getSidebarStats());
            return view('admin/history', $data);
        } catch (\Throwable $e) {
            // If history table is missing, create it and retry once
            $msg = $e->getMessage();
            if (stripos($msg, "doesn't exist") !== false || stripos($msg, 'no such table') !== false) {
                try {
                    $db = db_connect();
                    $db->query("CREATE TABLE IF NOT EXISTS `history` (
                        `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                        `item_table` VARCHAR(50) NOT NULL,
                        `item_id` INT(11) NULL,
                        `action` VARCHAR(20) NOT NULL,
                        `actor` VARCHAR(100) NULL,
                        `actor_full_name` VARCHAR(100) NULL,
                        `action_at` DATETIME NULL,
                        `from_name` VARCHAR(255) NULL,
                        `subject` TEXT NULL,
                        `date_received` DATE NULL,
                        `details` TEXT NULL,
                        PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
                    );

                    // Retry fetching history lists
                    $data['created'] = $historyModel->where('action', 'created')->orderBy('action_at', 'DESC')->findAll();
                    $data['deleted'] = $historyModel->where('action', 'deleted')->orderBy('action_at', 'DESC')->findAll();
                    $data = array_merge($data, $this->getSidebarStats());
                    return view('admin/history', $data);
                } catch (\Throwable $ex) {
                    log_message('error', 'Failed to create history table: ' . $ex->getMessage());
                    return redirect()->back()->with('error', 'History table missing and could not be created: ' . $ex->getMessage());
                }
            }

            log_message('error', 'Error loading history: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load history: ' . $e->getMessage());
        }
    }

    // View a single history record in detail
    public function historyView($id)
    {
        $historyModel = new HistoryModel();
        if (!is_numeric($id)) {
            return redirect()->back()->with('error', 'Invalid history ID');
        }
        $record = $historyModel->find($id);
        if (! $record) {
            return redirect()->back()->with('error', 'History record not found');
        }
        $data['record'] = $record;
        return view('admin/history_view', $data);
    }

    // Return history lists as JSON for real-time polling
    public function historyJson()
    {
        $historyModel = new HistoryModel();
        try {
            $created = $historyModel->where('action', 'created')->orderBy('action_at', 'DESC')->findAll(100);
            $deleted = $historyModel->where('action', 'deleted')->orderBy('action_at', 'DESC')->findAll(100);

            // Add ISO timestamps (assume stored in UTC) for reliable client-side parsing
            $appTZ = config('App')->appTimezone ?: 'UTC';
            foreach ($created as &$c) {
                if (!empty($c['action_at'])) {
                    try {
                        $dt = new \DateTime($c['action_at'], new \DateTimeZone('UTC'));
                        $c['action_at_iso'] = $dt->format(DATE_ATOM);
                        // also add server-formatted display in app timezone
                        $dt->setTimezone(new \DateTimeZone($appTZ));
                        $c['action_at_display'] = $dt->format('M d, Y | g:i A');
                    } catch (\Throwable $_) {
                        $c['action_at_iso'] = $c['action_at'];
                        $c['action_at_display'] = $c['action_at'];
                    }
                }
            }
            foreach ($deleted as &$d) {
                if (!empty($d['action_at'])) {
                    try {
                        $dt = new \DateTime($d['action_at'], new \DateTimeZone('UTC'));
                        $d['action_at_iso'] = $dt->format(DATE_ATOM);
                        $dt->setTimezone(new \DateTimeZone($appTZ));
                        $d['action_at_display'] = $dt->format('M d, Y | g:i A');
                    } catch (\Throwable $_) {
                        $d['action_at_iso'] = $d['action_at'];
                        $d['action_at_display'] = $d['action_at'];
                    }
                }
            }

            return $this->response->setJSON(['created' => $created, 'deleted' => $deleted]);
        } catch (\Throwable $e) {
            // If table missing or other DB issue, return empty lists and log
            log_message('error', 'historyJson error: ' . $e->getMessage());
            return $this->response->setJSON(['created' => [], 'deleted' => []]);
        }
    }

    // Return sidebar totals for admin pages
    public function sidebarStatsJson()
    {
        return $this->response->setJSON($this->getSidebarStats());
    }

    // Show admin dashboard
    public function index()
    {
        $data = [
            'pendingUsers' => $this->userModel->where('status', 'pending')->findAll(),
            'approvedUsers' => $this->userModel->where('status', 'approved')->findAll(),
        ];

        $data = array_merge($data, $this->getSidebarStats());

        return view('admin/dashboard', $data);
    }

    // List users separated by role (user | admin)
    public function users()
    {
        $data = [
            'users' => $this->userModel->where('role', 'user')->findAll(),
            'admins' => $this->userModel->where('role', 'admin')->findAll(),
        ];

        $data = array_merge($data, $this->getSidebarStats());

        return view('admin/users', $data);
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
