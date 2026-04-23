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
    <title>Users and Admin Accounts - Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgb(231, 233, 235) 0%, rgb(171, 203, 207) 100%);
            color: #000;
            overflow-y: scroll;
        }

        .main-wrapper { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            padding: 24px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .sidebar-header { display:flex; align-items:center; gap:12px; padding:0 20px; margin-bottom:24px; }
        .prc-logo { width:40px; height:40px; border-radius:8px; object-fit:contain; }
        .sidebar-title { font-size:16px; font-weight:700; color:#000; }
        .sidebar-menu { list-style:none; padding:0; margin:0; }
        .sidebar-menu li { margin:0; }
        .sidebar-menu a {
            display:flex; align-items:center; gap:12px;
            padding:10px 20px; color:#000; text-decoration:none;
            font-size:0.95rem; font-weight:500; border-left:3px solid transparent;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active { background:#f3f4f6; border-left-color:#667eea; color:#667eea; }
        .sidebar-icon { font-size:18px; }

        /* Main content */
        .main-content { flex: 1; display: flex; flex-direction: column; }
        header { background: transparent; border-bottom: 1px solid rgba(229,231,235,0.6); padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: none; }
        .header-title h1 { font-size: 1.5rem; color: #000; font-weight: 700; }
        .logout-btn { background: #ef4444; color: #fff; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.95rem; }

        .container { flex: 1; padding: 40px; overflow-y: auto; }

        /* Tabs */
        .tabs-container { background: transparent; border-radius: 12px; padding: 0; box-shadow: none; margin-bottom: 30px; }
        .tabs { display: flex; border-bottom: 1px solid #e5e7eb; list-style: none; }
        .tab-btn { background: none; color: #000; border: none; padding: 16px 24px; font-weight: 600; cursor: pointer; font-size: 0.95rem; border-bottom: 3px solid transparent; transition: border-color 200ms ease, color 200ms ease; position: relative; }
        .tab-btn:hover { color: #667eea; }
        .tab-btn.active { color: #667eea; border-bottom-color: #667eea; }

        .tab-content { display: none; padding: 20px; min-height: 320px; }
        .tab-content.active { display: block; }

        /* Users list / cards */
        .users-list { display:flex; flex-direction:column; gap:15px; max-height:600px; overflow-y:auto; }
        .users-list::-webkit-scrollbar { width:8px; }
        .users-list::-webkit-scrollbar-track { background:#f1f1f1; border-radius:4px; }
        .users-list::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:4px; }
        .users-list::-webkit-scrollbar-thumb:hover { background:#94a3b8; }

        .user-item { background: #fff; border: 1px solid #e5e7eb; padding: 18px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; transition: box-shadow 200ms ease, border-color 200ms ease; }
        .user-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-color: #d1d5db; }
        .user-info strong { color: #000; font-size: 1rem; display: block; margin-bottom: 4px; }
        .user-info small { color: #666; display: block; font-size: 0.85rem; }

        @media (max-width: 880px) {
            .sidebar { width:100%; border-right:none; border-bottom:1px solid #e5e7eb; }
            .main-wrapper { flex-direction:column; }
            .container { padding:20px; }
            .user-item { flex-direction:column; align-items:flex-start; gap:12px; }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="<?= base_url('images/logo.png') ?>" alt="PRC Logo" class="prc-logo">
                <div>
                    <div class="sidebar-title">Professional Regulation Commission</div>
                </div>
            </div>

            <?php $uri = service('uri')->getPath();
                  $isAdminUsers = (strpos($uri, 'admin/users') !== false);
                  $isAdminIndex = (strpos($uri, 'admin') !== false) && !$isAdminUsers;
            ?>

            <ul class="sidebar-menu">
                <li><a href="<?= base_url('admin') ?>" class="<?= $isAdminIndex ? 'active' : '' ?>"><span class="sidebar-icon">⏳</span> Pending Request</a></li>
                <li><a href="<?= base_url('admin/users') ?>" class="<?= $isAdminUsers ? 'active' : '' ?>"><span class="sidebar-icon">👥</span> Users</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <div class="header-left">
                    <div class="header-title"><h1>Users and Admin Accounts</h1></div>
                </div>
                <div class="header-right">
                    <form action="<?= base_url('auth/logout') ?>" method="POST" style="display:inline;">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </header>

            <div class="container">
                <?php if (session()->has('success')): ?>
                    <div style="margin-bottom:18px;padding:12px 16px;border-radius:8px;background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;">
                        ✅ <?= session('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->has('error')): ?>
                    <div style="margin-bottom:18px;padding:12px 16px;border-radius:8px;background:#fee2e2;color:#7f1d1d;border:1px solid #fecaca;">
                        ❌ <?= session('error') ?>
                    </div>
                <?php endif; ?>

                <div class="tabs-container">
                    <div class="tabs">
                        <button class="tab-btn active" id="tab-users" onclick="showTab('users')">User Accounts</button>
                        <button class="tab-btn" id="tab-admins" onclick="showTab('admins')">Admin Accounts</button>
                    </div>
                </div>

                <div id="users" class="tab-content active">
                    <h2 style="margin-bottom:12px;">User Accounts</h2>
                    <div class="users-list">
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $u): ?>
                                <div class="user-item">
                                    <div class="user-info">
                                        <strong><?= esc($u['full_name'] ?? $u['email']) ?></strong>
                                        <small>Username: <?= esc($u['email']) ?> | Status: User Account</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No users found.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="admins" class="tab-content">
                    <h2 style="margin-bottom:12px;">Admin Accounts</h2>
                    <div class="users-list">
                        <?php if (!empty($admins)): ?>
                            <?php foreach ($admins as $a): ?>
                                <div class="user-item">
                                    <div class="user-info">
                                        <strong><?= esc($a['full_name'] ?? $a['email']) ?></strong>
                                        <small>Username: <?= esc($a['email']) ?> | Status: Admin</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No admins found.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function showTab(name) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById(name).classList.add('active');
            document.getElementById('tab-' + name).classList.add('active');
        }
    </script>
</body>
</html>
