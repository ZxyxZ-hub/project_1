<?php
$session = session();
if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
    return redirect()->to('/auth/login');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="<?= csrf_header() ?>">
    <title>Admin Dashboard - PRC</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body { height: 100%; }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgb(231, 233, 235) 0%, rgb(171, 203, 207) 100%);
            color: #000;
            overflow-y: scroll;
        }

        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            padding: 24px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            margin-bottom: 32px;
        }

        .prc-logo {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: inline-block;
            object-fit: contain;
        }

        .sidebar-title {
            font-size: 16px;
            font-weight: 700;
            color: #000;
            line-height: 1.2;
        }

        .sidebar-subtitle {
            font-size: 10px;
            color: #666;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #000;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: background 150ms ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #f3f4f6;
            border-left-color: #667eea;
            color: #667eea;
        }

        .sidebar-icon {
            font-size: 18px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        header {
            background: transparent;
            border-bottom: 1px solid rgba(229,231,235,0.6);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: none;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-logo {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: contain;
        }

        .header-title h1 {
            font-size: 1.5rem;
            color: #000;
            font-weight: 700;
        }

        .search-box {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 10px 16px;
            border-radius: 8px;
            min-width: 300px;
            color: #000;
            font-size: 0.9rem;
        }

        .search-box::placeholder {
            color: #999;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logout-btn {
            background: #ef4444;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.95rem;
            transition: background 200ms ease, transform 180ms ease;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .container {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        /* Tabs */
        .tabs-container {
            background: transparent;
            border-radius: 12px;
            padding: 0;
            box-shadow: none;
            margin-bottom: 30px;
        }

        .tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            list-style: none;
        }

        .tab-btn {
            background: none;
            color: #000;
            border: none;
            padding: 16px 24px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.95rem;
            border-bottom: 3px solid transparent;
            transition: border-color 200ms ease, color 200ms ease;
            position: relative;
        }

        .tab-btn:hover {
            color: #667eea;
        }

        .tab-btn.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .tab-content {
            display: none;
            padding: 20px;
            min-height: 320px;
        }

        .tab-content.active {
            display: block;
        }

        .tab-content h2 {
            color: #000;
            font-size: 1.3rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        /* Users List */
        .users-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 600px;
            overflow-y: auto;
        }

        .user-item {
            background: #fff;
            border: 1px solid #e5e7eb;
            padding: 18px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 200ms ease, border-color 200ms ease;
        }

        .user-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }

        .user-info strong {
            color: #000;
            font-size: 1rem;
            display: block;
            margin-bottom: 4px;
        }

        .user-info small {
            color: #666;
            display: block;
            font-size: 0.85rem;
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            padding: 8px 14px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 150ms ease;
            color: #000;
        }

        .btn-view {
            background: #fbbf24;
            color: #000;
        }

        .btn-view:hover {
            background: #f59e0b;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #3b82f6;
            color: #fff;
        }

        .btn-edit:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #ef4444;
            color: #fff;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #fff;
            border-radius: 12px;
            padding: 32px;
            max-width: 450px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .modal-header h2 {
            color: #000;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .modal-close {
            background: #ef4444;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 150ms ease;
            color: #fff;
        }

        .modal-close:hover {
            background: #dc2626;
        }

        .modal-body {
            margin-bottom: 24px;
        }

        .info-row {
            margin-bottom: 16px;
        }

        .info-label {
            font-weight: 600;
            color: #000;
            margin-bottom: 6px;
            font-size: 0.95rem;
        }

        .info-value {
            color: #666;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            color: #000;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #000;
            transition: border-color 150ms ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: #000;
            font-size: 1.1rem;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 150ms ease;
            opacity: 0.6;
        }

        .toggle-password:hover {
            opacity: 0.9;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-modal {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 150ms ease;
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #000;
            border: 1px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            border-color: #9ca3af;
        }

        .btn-modal.btn-edit {
            background: #667eea;
            color: #fff;
        }

        .btn-modal.btn-edit:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        /* Flash Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #7f1d1d;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding: 16px;
            }

            header {
                flex-direction: column;
                gap: 16px;
                padding: 16px;
            }

            .header-left {
                flex-direction: column;
                width: 100%;
            }

            .search-box {
                min-width: 100%;
            }

            .container {
                padding: 20px;
            }

            .user-item {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .user-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .modal-content {
                width: 95%;
            }

            .tabs {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="<?= base_url('images/logo.png') ?>" alt="PRC Logo" class="prc-logo">
                    <div>
                        <div class="sidebar-title">Professional Regulation Commission</div>
                    </div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="<?= base_url('admin') ?>" class="active"><span class="sidebar-icon">⏳</span> Pending Request</a></li>
                <li><a href="<?= base_url('admin/users') ?>"><span class="sidebar-icon">👥</span> Users</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <div class="header-left">
                        <div class="header-title">
                            <h1>Pending Requests</h1>
                        </div>
                </div>
                <div class="header-right">
                    <form action="<?= base_url('auth/logout') ?>" method="POST" style="display: inline;">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </header>

            <div class="container">
                <!-- Flash Messages -->
                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success">
                        ✅ <?= session('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-error">
                        ❌ <?= session('error') ?>
                    </div>
                <?php endif; ?>

                <div class="tabs-container">
                    <div class="tabs">
                            <button class="tab-btn active" onclick="showTab('pending')">Pending Users</button>
                            <button class="tab-btn" onclick="showTab('approved')">Approved Users</button>
                        </div>
                </div>

        <!-- Pending Users Tab -->
        <div id="pending" class="tab-content active">
            <h2>Pending Sign-ups</h2>
            <div class="users-list" id="pendingUsers">
                <?php if (!empty($pendingUsers)): ?>
                    <?php foreach ($pendingUsers as $user): ?>
                        <div class="user-item">
                            <div class="user-info">
                                <strong><?= $user['full_name'] ?></strong>
                                <small>Username: <?= $user['email'] ?></small>
                            </div>
                            <div class="user-actions">
                                <button class="btn-small btn-view" onclick="openViewModal(<?= $user['id'] ?>, '<?= $user['full_name'] ?>', '<?= $user['email'] ?>')">👁️ View</button>
                                <button class="btn-small btn-edit" onclick="openApproveModal(<?= $user['id'] ?>, '<?= $user['full_name'] ?>')">☑️ Approve</button>
                                <button class="btn-small btn-delete" onclick="denyUser(<?= $user['id'] ?>)">❌ Deny</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No pending sign-ups</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Approved Users Tab -->
        <div id="approved" class="tab-content">
            <h2>Approved Users</h2>
            <div class="users-list" id="approvedUsers">
                <?php if (!empty($approvedUsers)): ?>
                    <?php foreach ($approvedUsers as $user): ?>
                        <div class="user-item">
                            <div class="user-info">
                                <strong><?= $user['full_name'] ?></strong>
                                <small>Username: <?= $user['email'] ?> | Role: <?= ucfirst($user['role']) ?></small>
                            </div>
                            <div class="user-actions">
                                <button class="btn-small btn-view" onclick="openApprovedViewModal(<?= $user['id'] ?>, '<?= $user['full_name'] ?>', '<?= $user['email'] ?>', '<?= $user['role'] ?>')">👁️ View</button>
                                <button class="btn-small btn-edit" onclick="openEditPasswordModal(<?= $user['id'] ?>, '<?= $user['full_name'] ?>')">🔑 Reset Pass</button>
                                <button class="btn-small btn-delete" onclick="deleteUser(<?= $user['id'] ?>)">🗑️ Delete</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No approved users</p>
                <?php endif; ?>
            </div>
        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Pending User Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>User Details</h2>
                <button class="modal-close" onclick="closeModal('viewModal')">✕</button>
            </div>
            <div class="modal-body">
                <div class="info-row">
                    <div class="info-label">Full Name</div>
                    <div class="info-value" id="viewFullName"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Username</div>
                    <div class="info-value" id="viewEmail"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Approved User Modal -->
    <div id="approvedViewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>User Details</h2>
                <button class="modal-close" onclick="closeModal('approvedViewModal')">✕</button>
            </div>
            <div class="modal-body">
                <div class="info-row">
                    <div class="info-label">Full Name</div>
                    <div class="info-value" id="approvedViewFullName"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Username</div>
                    <div class="info-value" id="approvedViewEmail"></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Current Role</div>
                    <div class="info-value" id="approvedViewRole"></div>
                </div>
                <div class="form-group">
                    <label for="newRole">Change Role</label>
                    <select id="newRole" onchange="updateRole()">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve User Modal -->
    <div id="approveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Approve User</h2>
                <button class="modal-close" onclick="closeModal('approveModal')">✕</button>
            </div>
            <div class="modal-body">
                <div class="info-row">
                    <div class="info-label">User</div>
                    <div class="info-value" id="approveUserName"></div>
                </div>
                <div class="form-group">
                    <label for="approveRole">Assign Role</label>
                    <select id="approveRole">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-modal btn-secondary" onclick="closeModal('approveModal')">Cancel</button>
                <button class="btn-modal btn-edit" onclick="approveUser()">Approve</button>
            </div>
        </div>
    </div>

    <!-- Edit Password Modal -->
    <div id="editPasswordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reset Password</h2>
                <button class="modal-close" onclick="closeModal('editPasswordModal')">✕</button>
            </div>
            <div class="modal-body">
                <div class="info-row">
                    <div class="info-label">User</div>
                    <div class="info-value" id="editPasswordUserName"></div>
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password:</label>
                    <div class="password-wrapper">
                        <input type="password" id="newPassword" placeholder="Enter new password" required>
                        <button type="button" class="toggle-password" id="toggleNewPassword" aria-label="Toggle password visibility">
                            <svg class="eye-hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                            <svg class="eye-shown" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password:</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirmPassword" placeholder="Confirm new password" required>
                        <button type="button" class="toggle-password" id="toggleConfirmPassword" aria-label="Toggle password visibility">
                            <svg class="eye-hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                            <svg class="eye-shown" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-modal btn-secondary" onclick="closeModal('editPasswordModal')">Cancel</button>
                <button class="btn-modal btn-edit" onclick="resetPassword()">Reset Password</button>
            </div>
        </div>
    </div>

    <!-- Approve User Form (hidden) -->
    <form id="approveUserForm" method="POST" action="" style="display:none;">
        <?= csrf_field() ?>
        <input type="hidden" name="role" id="approveUserRole">
    </form>

    <!-- Update Role Form (hidden) -->
    <form id="updateRoleForm" method="POST" action="" style="display:none;">
        <?= csrf_field() ?>
        <input type="hidden" name="role" id="updateRoleValue">
    </form>

    <!-- Reset Password Form (hidden) -->
    <form id="resetPasswordForm" method="POST" action="" style="display:none;">
        <?= csrf_field() ?>
        <input type="hidden" name="password" id="resetPasswordValue">
    </form>

    <!-- Deny User Form (hidden) -->
    <form id="denyUserForm" method="POST" action="" style="display:none;">
        <?= csrf_field() ?>
    </form>

    <!-- Delete User Form (hidden) -->
    <form id="deleteUserForm" method="POST" action="" style="display:none;">
        <?= csrf_field() ?>
    </form>

    <script>
        let currentUserId = null;
        let currentUserRole = null;

        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        function openViewModal(userId, fullName, email) {
            currentUserId = userId;
            document.getElementById('viewFullName').textContent = fullName;
            document.getElementById('viewEmail').textContent = email;
            document.getElementById('viewModal').classList.add('active');
        }

        function openApprovedViewModal(userId, fullName, email, role) {
            currentUserId = userId;
            currentUserRole = role;
            document.getElementById('approvedViewFullName').textContent = fullName;
            document.getElementById('approvedViewEmail').textContent = email;
            document.getElementById('approvedViewRole').textContent = role.charAt(0).toUpperCase() + role.slice(1);
            document.getElementById('newRole').value = role;
            document.getElementById('approvedViewModal').classList.add('active');
        }

        function openApproveModal(userId, fullName) {
            currentUserId = userId;
            document.getElementById('approveUserName').textContent = fullName;
            document.getElementById('approveModal').classList.add('active');
        }

        function openEditPasswordModal(userId, name) {
            currentUserId = userId;
            document.getElementById('editPasswordUserName').textContent = name;
            document.getElementById('editPasswordModal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        async function approveUser() {
            const role = document.getElementById('approveRole').value;
            const form = document.getElementById('approveUserForm');
            form.action = `<?= base_url('admin/approve-user/') ?>${currentUserId}`;
            document.getElementById('approveUserRole').value = role;
            form.submit();
        }

        async function denyUser(userId) {
            if (!confirm('Are you sure you want to deny this user?')) return;
            const form = document.getElementById('denyUserForm');
            form.action = `<?= base_url('admin/deny-user/') ?>${userId}`;
            form.submit();
        }

        async function updateRole() {
            const role = document.getElementById('newRole').value;
            
            if (!currentUserId) {
                alert('Error: User ID not set');
                return;
            }

            const form = document.getElementById('updateRoleForm');
            form.action = `<?= base_url('admin/update-role/') ?>${currentUserId}`;
            document.getElementById('updateRoleValue').value = role;
            form.submit();
        }

        async function resetPassword() {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }

            if (newPassword.length < 6) {
                alert('Password must be at least 6 characters!');
                return;
            }

            const form = document.getElementById('resetPasswordForm');
            form.action = `<?= base_url('admin/reset-password/') ?>${currentUserId}`;
            document.getElementById('resetPasswordValue').value = newPassword;
            form.submit();
        }

        async function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) return;

            const form = document.getElementById('deleteUserForm');
            form.action = `<?= base_url('admin/delete-user/') ?>${userId}`;
            form.submit();
        }

        // Initialize password toggle buttons
        function setupPasswordToggle(buttonId, inputId) {
            var button = document.getElementById(buttonId);
            var input = document.getElementById(inputId);
            
            if (button && input) {
                var eyeHidden = button.querySelector('.eye-hidden');
                var eyeShown = button.querySelector('.eye-shown');
                
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    var type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    
                    // Swap eye icons
                    if (type === 'text') {
                        eyeHidden.style.display = 'none';
                        eyeShown.style.display = 'block';
                        button.classList.add('active');
                    } else {
                        eyeHidden.style.display = 'block';
                        eyeShown.style.display = 'none';
                        button.classList.remove('active');
                    }
                });
            }
        }

        // Setup both password fields in the reset password modal
        setupPasswordToggle('toggleNewPassword', 'newPassword');
        setupPasswordToggle('toggleConfirmPassword', 'confirmPassword');

        // Close modal when clicking outside
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });
    </script>
        </div>
    </div>
    </div>
</body>
</html>
