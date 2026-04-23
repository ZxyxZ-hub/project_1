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
    <title>Users - Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, rgb(231, 233, 235) 0%, rgb(171, 203, 207) 100%); color: #000; overflow-y: scroll; }
        .main-wrapper { display:flex; min-height:100vh; }
        .sidebar { width:250px; background:#fff; border-right:1px solid #e5e7eb; padding:24px 0; box-shadow:0 2px 4px rgba(0,0,0,0.05); }
        .sidebar-header { display:flex; align-items:center; gap:12px; padding:0 20px; margin-bottom:32px; }
        .prc-logo { width:40px; height:40px; border-radius:8px; display:inline-block; object-fit:contain; }
        .sidebar-title { font-size:16px; font-weight:700; color:#000; line-height:1.2; }
        .sidebar-menu { list-style:none; }
        .sidebar-menu a { display:flex; align-items:center; gap:12px; padding:12px 20px; color:#000; text-decoration:none; font-size:0.95rem; font-weight:500; border-left:3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background:#f3f4f6; border-left-color:#667eea; color:#667eea; }

        .main-content { flex:1; display:flex; flex-direction:column; }
        header { background:transparent; border-bottom:1px solid rgba(229,231,235,0.6); padding:20px 40px; display:flex; justify-content:space-between; align-items:center; box-shadow:none; }
        .header-title h1 { font-size:1.5rem; color:#000; font-weight:700; }
        .logout-btn { background:#ef4444; color:#fff; border:none; padding:10px 24px; border-radius:8px; font-weight:600; cursor:pointer; }

        .container { flex:1; padding:40px; }
        /* Users page styles */
        .tabs { display:flex; gap:10px; margin-bottom:16px; }
        /* Tab buttons styled like dashboard */
        .tab-btn { background: none; color: #000; border: none; padding: 12px 20px; font-weight: 600; cursor: pointer; font-size: 0.95rem; transition: color 180ms ease, border-color 180ms ease; }
        .tab-btn:focus { outline: none; box-shadow: none; }
        .tab-btn.active { color: #3b82f6; border-bottom: 3px solid #3b82f6; }
        .tabs-container { background: transparent; border-radius: 12px; padding: 0; box-shadow: none; margin-bottom: 20px; }
        .tabs { display: flex; border-bottom: 1px solid #e5e7eb; }
        .tab-content { display: none; padding: 20px; min-height: 320px; }
        .tab-content.active { display: block; }
        .users-list { display:flex; flex-direction:column; gap:12px; max-height:600px; overflow:auto; }
        .user-item { background:#fff; border:1px solid #e5e7eb; padding:18px; border-radius:10px; display:flex; justify-content:space-between; align-items:center; }
        .user-info strong { color:#000; display:block; }
        .user-info small { color:#666; display:block; }
        .user-actions { display:flex; gap:10px; }

        @media (max-width:768px) { .sidebar { width:100%; border-right:none; border-bottom:1px solid #e5e7eb; } header { flex-direction:column; gap:16px; } .container { padding:20px; } }
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
                    <div class="tabs-container">
                        <div class="tabs">
                            <button class="tab-btn active" id="tab-users" onclick="showUserTab('users')">User Accounts</button>
                            <button class="tab-btn" id="tab-admins" onclick="showUserTab('admins')">Admin Accounts</button>
                        </div>
                    </div>

                    <div id="users" class="tab-content users-list active">
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                            <div class="user-item">
                                <div class="user-info">
                                        <strong>Username: <?= esc($u['email']) ?></strong>
                                        <!-- password display removed -->
                                    </div>
                                <div class="user-actions">
                                    <form method="post" action="<?= base_url('index.php/admin/reset-password/'.$u['id']) ?>" style="display:inline;">
                                        <?= csrf_field() ?>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No users found.</p>
                    <?php endif; ?>
                </div>

                <div id="admins" class="tab-content users-list" style="display:none;">
                    <?php if (!empty($admins)): ?>
                        <?php foreach ($admins as $a): ?>
                            <div class="user-item">
                                <div class="user-info">
                                        <strong>Username: <?= esc($a['email']) ?></strong>
                                        <!-- password display removed -->
                                    </div>
                                <div class="user-actions"></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No admins found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showUserTab(tab) {
            // toggle content
            document.getElementById('users').classList.toggle('active', tab === 'users');
            document.getElementById('admins').classList.toggle('active', tab === 'admins');
            // toggle display property for accessibility / fallback
            document.getElementById('users').style.display = (tab === 'users') ? 'block' : 'none';
            document.getElementById('admins').style.display = (tab === 'admins') ? 'block' : 'none';
            // toggle active button
            document.getElementById('tab-users').classList.toggle('active', tab === 'users');
            document.getElementById('tab-admins').classList.toggle('active', tab === 'admins');
        }
    </script>
</body>
</html>
