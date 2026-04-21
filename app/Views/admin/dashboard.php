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
    <title>Admin Dashboard - ORD Form System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #21aef5ff 0%, #3eb9f7ff 100%);
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        header h1 {
            font-size: 1.8rem;
        }

        .logout-btn {
            background: #f70b0b;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(247, 11, 11, 0.3);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab-btn {
            background: #21aef5ff;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: background 200ms ease;
        }

        .tab-btn.active {
            background: #1e9dd8ff;
        }

        .tab-content {
            display: none;
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .tab-content.active {
            display: block;
        }

        .users-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .user-item {
            border: 2px solid #e0e0e0;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info strong {
            color: #2b2b2b;
            font-size: 1rem;
        }

        .user-info small {
            color: #666;
            display: block;
            font-size: 0.9rem;
        }

        .user-actions {
            display: flex;
            gap: 8px;
        }

        .btn-small {
            padding: 8px 14px;
            border-radius: 6px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: transform 180ms ease;
        }

        .btn-small:hover {
            transform: translateY(-2px);
        }

        .btn-view {
            background: #fbbf24;
            color: #000;
        }

        .btn-edit {
            background: #21aef5ff;
            color: #fff;
        }

        .btn-delete {
            background: #f70b0b;
            color: #fff;
        }

        /* Modal/Floating Form */
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
            border-radius: 16px;
            padding: 28px;
            max-width: 450px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-header h2 {
            color: #2b2b2b;
            font-weight: 700;
        }

        .modal-close {
            background: #f70b0b;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 180ms ease;
            color: #fff;
        }

        .modal-close:hover {
            background: #c9090d;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: 700;
            color: #2b2b2b;
            margin-bottom: 4px;
        }

        .info-value {
            color: #666;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            color: #2b2b2b;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: border-color 150ms ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #21aef5ff;
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
            color: black;
            font-size: 1.2rem;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 180ms ease, opacity 180ms ease;
            opacity: 0.5;
        }

        .toggle-password:hover {
            color: black;
            opacity: 0.7;
        }

        .toggle-password.active {
            opacity: 1;
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
            font-weight: 700;
            cursor: pointer;
            transition: all 180ms ease;
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #333;
            border: 2px solid #d1d5db;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            border-color: #b4b8bf;
        }

        .btn-edit {
            background: #21aef5ff;
            color: #fff;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(33, 174, 245, 0.3);
        }

        @media (max-width: 720px) {
            header {
                flex-direction: column;
                gap: 15px;
            }

            .user-item {
                flex-direction: column;
                gap: 15px;
            }

            .user-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .modal-content {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>📋 Admin Dashboard</h1>
        <form action="<?= base_url('auth/logout') ?>" method="POST" style="display: inline;">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <!-- Flash Messages -->
    <?php if (session()->has('success')): ?>
        <div style="background: #10b981; color: white; padding: 15px 20px; margin: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            ✅ <?= session('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->has('error')): ?>
        <div style="background: #ef4444; color: white; padding: 15px 20px; margin: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
            ❌ <?= session('error') ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('pending')">⏳ Pending Sign-ups</button>
            <button class="tab-btn" onclick="showTab('approved')">✅ Approved Users</button>
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
            form.action = `<?= base_url('index.php/admin/approve-user/') ?>${currentUserId}`;
            document.getElementById('approveUserRole').value = role;
            form.submit();
        }

        async function denyUser(userId) {
            if (!confirm('Are you sure you want to deny this user?')) return;
            const form = document.getElementById('denyUserForm');
            form.action = `<?= base_url('index.php/admin/deny-user/') ?>${userId}`;
            form.submit();
        }

        async function updateRole() {
            const role = document.getElementById('newRole').value;
            
            if (!currentUserId) {
                alert('Error: User ID not set');
                return;
            }

            const form = document.getElementById('updateRoleForm');
            form.action = `<?= base_url('index.php/admin/update-role/') ?>${currentUserId}`;
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
            form.action = `<?= base_url('index.php/admin/reset-password/') ?>${currentUserId}`;
            document.getElementById('resetPasswordValue').value = newPassword;
            form.submit();
        }

        async function deleteUser(userId) {
            if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) return;

            const form = document.getElementById('deleteUserForm');
            form.action = `<?= base_url('index.php/admin/delete-user/') ?>${userId}`;
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
</body>
</html>
