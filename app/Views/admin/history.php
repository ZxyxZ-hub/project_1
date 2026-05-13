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
    <title>Admin History - PRC</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body { height: 100%; }
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
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
            justify-content: space-between;
            padding: 12px 20px;
            color: #000;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: background 150ms ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .sidebar-stats {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
            margin-left: 12px;
        }

        .sidebar-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #000;
            border: 1px solid #d1d5db;
            border-radius: 999px;
            padding: 2px 8px;
            font-size: 0.72rem;
            font-weight: 700;
            line-height: 1.2;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            white-space: nowrap;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #f3f4f6;
            border-left-color: #21aef5;
            color: #21aef5;
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

        .header-title h1 {
            font-size: 1.5rem;
            color: #000;
            font-weight: 700;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logout-btn {
            background: #dc2626;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.95rem;
            transition: all 200ms ease;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        }

        .logout-btn:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.25);
        }

        .container {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

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
            overflow: visible;
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
            overflow: visible;
        }

        .tab-btn:hover {
            color: #21aef5;
        }

        .tab-btn.active {
            color: #21aef5;
            border-bottom-color: #21aef5;
        }

        .tab-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            height: 28px;
            background: #fff;
            color: #000;
            border: 1px solid #d1d5db;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 0 8px;
            border-radius: 999px;
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.2s ease, transform 0.2s ease;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 2;
        }

        .tab-btn:hover .tab-badge,
        .tab-badge.show {
            opacity: 1;
            transform: scale(1);
        }

        .tab-content { display:none; padding:20px; min-height:320px; }
        .tab-content.active { display:block; }

        .history-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 600px;
            overflow-y: auto;
        }

        .history-list::-webkit-scrollbar {
            width: 8px;
        }

        .history-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .history-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .history-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .history-item {
            background: #fff;
            border: 1px solid #e5e7eb;
            padding: 18px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 200ms ease, border-color 200ms ease;
        }

        .history-item:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-color: #d1d5db;
        }

        .history-item strong {
            color: #000;
            font-size: 1rem;
            display: block;
            margin-bottom: 4px;
        }

        .history-item small {
            color: #666;
            display: block;
            font-size: 0.85rem;
        }

        .history-item > div:first-child {
            flex: 1;
            min-width: 0;
        }

        .btn-view {
            background: #fbbf24;
            color: #000;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .alert { padding: 16px 20px; border-radius: 8px; margin-bottom: 24px; font-weight: 500; display:flex; align-items:center; gap:12px; }
        .alert-success { background:#d1fae5; color:#065f46; border:1px solid #a7f3d0 }
        .alert-error { background:#fee2e2; color:#7f1d1d; border:1px solid #fecaca }

        @media (max-width: 768px) {
            .main-wrapper { flex-direction: column; }
            .sidebar { width: 100%; border-right: none; border-bottom:1px solid #e5e7eb; padding:16px }
            header { flex-direction:column; gap:16px; padding:16px }
            .container { padding:20px }
        }
    </style>
</head>
<body>
<div class="main-wrapper">
    <!-- Sidebar copied from dashboard for consistent styling -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="<?= base_url('images/logo.png') ?>" alt="PRC Logo" class="prc-logo">
            <div>
                <div class="sidebar-title">Professional Regulation Commission</div>
            </div>
        </div>
        <?php $uri = current_url(true)->getPath(); ?>
        <?php $isAdminIndex = (strpos($uri, 'admin') !== false && strpos($uri, 'admin/users') === false && strpos($uri, 'admin/history') === false); ?>
        <?php $isAdminUsers = (strpos($uri, 'admin/users') !== false); ?>
        <?php $isAdminHistory = (strpos($uri, 'admin/history') !== false); ?>
        <ul class="sidebar-menu">
            <li>
                <a href="<?= base_url('admin') ?>" class="<?= $isAdminIndex ? 'active' : '' ?>">
                    <span class="sidebar-link-left"><span class="sidebar-icon">⏳</span> Pending Request</span>
                    <span class="sidebar-badge" id="pendingBadge"><?= esc(($pendingRequested ?? 0) + ($pendingAccepted ?? 0)) ?></span>
                </a>
            </li>
            <li><a href="<?= base_url('admin/users') ?>" class="<?= $isAdminUsers ? 'active' : '' ?>"><span class="sidebar-link-left"><span class="sidebar-icon">👥</span> Users</span></a></li>
            <li>
                <a href="<?= base_url('admin/history') ?>" class="<?= $isAdminHistory ? 'active' : '' ?>">
                    <span class="sidebar-link-left"><span class="sidebar-icon">📜</span> History</span>
                    <span class="sidebar-badge" id="historyBadge"><?= esc(($historyCreated ?? 0) + ($historyDeleted ?? 0)) ?></span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <div class="header-left">
                <div class="header-title"><h1>History</h1></div>
            </div>
            <div class="header-right">
                <form action="<?= base_url('auth/logout') ?>" method="POST" style="display:inline;">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </header>

        <div class="container">
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success">✅ <?= session('success') ?></div>
            <?php endif; ?>
            <?php if (session()->has('error')): ?>
                <div class="alert alert-error">❌ <?= session('error') ?></div>
            <?php endif; ?>

            <div class="tabs-container">
                <div class="tabs">
                        <button type="button" class="tab-btn active" onclick="showTab('created')">Created<span class="tab-badge" id="createdBadge">0</span></button>
                        <button type="button" class="tab-btn" onclick="showTab('deleted')">Deleted<span class="tab-badge" id="deletedBadge">0</span></button>
                </div>
            </div>

            <div id="created" class="tab-content active">
                <h2>Created Records</h2>
                <div class="history-list" id="createdList">
                            <?php if (!empty($created)): ?>
                                <?php foreach ($created as $h): ?>
                                    <div class="history-item">
                                        <div>
                                            <?php $actor = esc($h['actor_full_name'] ? $h['actor_full_name'] : $h['actor']); ?>
                                            <strong>Created By: <strong><?= $actor ?></strong></strong>
                                            <?php
                                                // Display using app timezone if available
                                                try {
                                                    $appTZ = config('App')->appTimezone ?: 'UTC';
                                                    $dt = new DateTime($h['action_at'], new DateTimeZone('UTC'));
                                                    $dt->setTimezone(new DateTimeZone($appTZ));
                                                    $display = $dt->format('M d, Y') . ' | Time: ' . $dt->format('g:i A');
                                                } catch (Exception $e) {
                                                    $display = $h['action_at'];
                                                }
                                            ?>
                                            <strong><?= esc($display) ?></strong>
                                            <div><small>From: <?= esc($h['from_name'] ?: '--') ?> | Subject: <?= esc($h['subject'] ?: '--') ?> | Date: <?= esc($h['date_received'] ?: '--') ?></small></div>
                                        </div>
                                        <div>
                                            <a class="btn-view" href="<?= base_url('admin/history/view/' . $h['id']) ?>">View</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No created records yet.</p>
                            <?php endif; ?>
                </div>
            </div>

            <div id="deleted" class="tab-content">
                <h2>Deleted Records</h2>
                <div class="history-list" id="deletedList">
                    <?php if (!empty($deleted)): ?>
                        <?php foreach ($deleted as $h): ?>
                            <div class="history-item">
                                <div>
                                    <?php $actor = esc($h['actor_full_name'] ? $h['actor_full_name'] : $h['actor']); ?>
                                    <strong>Deleted By: <strong><?= $actor ?></strong></strong>
                                    <?php
                                        try {
                                            $appTZ = config('App')->appTimezone ?: 'UTC';
                                            $dt = new DateTime($h['action_at'], new DateTimeZone('UTC'));
                                            $dt->setTimezone(new DateTimeZone($appTZ));
                                            $display = $dt->format('M d, Y') . ' | Time: ' . $dt->format('g:i A');
                                        } catch (Exception $e) {
                                            $display = $h['action_at'];
                                        }
                                    ?>
                                    <strong><?= esc($display) ?></strong>
                                    <div><small>From: <?= esc($h['from_name'] ?: '--') ?> | Subject: <?= esc($h['subject'] ?: '--') ?> | Date: <?= esc($h['date_received'] ?: '--') ?></small></div>
                                </div>
                                <div>
                                    <a class="btn-view" href="<?= base_url('admin/history/view/' . $h['id']) ?>">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No deleted records yet.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    </div>
</div>
<script>
function showTab(name) {
    document.querySelectorAll('.tab-content').forEach(function (tab) {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-btn').forEach(function (button) {
        button.classList.remove('active');
    });

    var content = document.getElementById(name);
    var button = Array.prototype.find.call(document.querySelectorAll('.tab-btn'), function (btn) {
        return btn.getAttribute('onclick') === "showTab('" + name + "')";
    });

    if (content) {
        content.classList.add('active');
    }

    if (button) {
        button.classList.add('active');
    }
}

(function () {
    var endpoint = '<?= base_url('admin/history/json') ?>';
    var storageKeys = {
        created: 'historySeenCreatedCount',
        deleted: 'historySeenDeletedCount'
    };
    var currentCounts = {
        created: parseInt(localStorage.getItem(storageKeys.created) || '0', 10),
        deleted: parseInt(localStorage.getItem(storageKeys.deleted) || '0', 10)
    };

    function setBadge(type, totalCount) {
        var badge = document.getElementById(type + 'Badge');
        var seenCount = parseInt(localStorage.getItem(storageKeys[type]) || '0', 10);
        var unread = Math.max(totalCount - seenCount, 0);

        if (!badge) return;

        if (unread > 0) {
            badge.textContent = unread;
            badge.classList.add('show');
        } else {
            badge.textContent = '';
            badge.classList.remove('show');
        }
    }

    function markSeen(type, totalCount) {
        localStorage.setItem(storageKeys[type], String(totalCount));
        setBadge(type, totalCount);
    }

    function bindBadgeInteractions(type) {
        var tab = document.querySelector('.tab-btn[onclick="showTab(\'' + type + '\')"]');
        if (!tab) return;

        tab.addEventListener('mouseenter', function () {
            markSeen(type, currentCounts[type]);
        });

        tab.addEventListener('click', function () {
            markSeen(type, currentCounts[type]);
        });
    }

    function pollHistory() {
        fetch(endpoint, { credentials: 'same-origin' })
            .then(function (res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function (data) {
                var createdCount = data.created ? data.created.length : 0;
                var deletedCount = data.deleted ? data.deleted.length : 0;

                currentCounts.created = createdCount;
                currentCounts.deleted = deletedCount;

                renderItems('createdList', data.created, 'created');
                renderItems('deletedList', data.deleted, 'deleted');

                setBadge('created', createdCount);
                setBadge('deleted', deletedCount);
            })
            .catch(function (err) {
                console.warn('history poll error', err);
            });
    }

    function renderItems(containerId, items, type) {
        var container = document.getElementById(containerId);
        if (!container) return;

        if (!items || items.length === 0) {
            container.innerHTML = '<p>No ' + type + ' records yet.</p>';
            return;
        }

        var html = '';
        items.forEach(function (h) {
            var actor = h.actor_full_name || h.actor || '--';
            var from = h.from_name || '--';
            var subject = h.subject || '--';
            var dateReceived = h.date_received || '--';
            var display = h.action_at_display || h.action_at || '';

            html += '<div class="history-item">';
            html += '<div>';
            html += '<strong>' + (type === 'created' ? 'Created By: ' : 'Deleted By: ') + '<strong>' + escapeHtml(actor) + '</strong></strong>';
            html += '<strong>' + escapeHtml(display) + '</strong>';
            html += '<div><small>From: ' + escapeHtml(from) + ' | Subject: ' + escapeHtml(subject) + ' | Date: ' + escapeHtml(dateReceived) + '</small></div>';
            html += '</div>';
            html += '<div><a class="btn-view" href="<?= base_url('admin/history/view/') ?>' + (h.id || '') + '">View</a></div>';
            html += '</div>';
        });

        container.innerHTML = html;
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        return String(text).replace(/[&"'<>]/g, function (s) {
            return ({'&': '&amp;', '"': '&quot;', "'": '&#39;', '<': '&lt;', '>': '&gt;'})[s];
        });
    }

    // Initialize badge state and bindings
    setBadge('created', currentCounts.created);
    setBadge('deleted', currentCounts.deleted);
    bindBadgeInteractions('created');
    bindBadgeInteractions('deleted');

    // If there are currently unread items, show them; otherwise keep hidden.
    pollHistory();
    setInterval(pollHistory, 5000);
})();
</script>
<script>
(function () {
    var endpoint = '<?= base_url('admin/sidebar-stats') ?>';

    function pollSidebarStats() {
        fetch(endpoint, { credentials: 'same-origin' })
            .then(function (res) {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(function (data) {
                // Calculate and update combined totals
                var pendingTotal = (data.pendingRequested || 0) + (data.pendingAccepted || 0);
                var historyTotal = (data.historyCreated || 0) + (data.historyDeleted || 0);
                
                document.getElementById('pendingBadge').textContent = pendingTotal;
                document.getElementById('historyBadge').textContent = historyTotal;
            })
            .catch(function (err) {
                console.warn('sidebar stats error', err);
            });
    }

    pollSidebarStats();
    setInterval(pollSidebarStats, 5000);
})();
</script>
</body>
</html>
