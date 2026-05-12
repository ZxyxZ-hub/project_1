<link rel="stylesheet" href="<?= base_url('css/shared-styles.css') ?>">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { 
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, rgb(231, 233, 235) 0%, rgb(171, 203, 207) 100%);
        color: #000;
    }

    /* Header with Navigation */
    .page-header {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .page-header-logo {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: contain;
    }

    .page-header-title h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: #000;
    }

    /* Page Layout */
    .page-wrap {
        max-width: 1100px;
        margin: 32px auto;
        padding: 0 20px;
    }

    /* Floating side actions */
    .side-actions{position:fixed;left:0;top:0;width:80px;height:100vh;z-index:1100;display:flex;align-items:flex-start;justify-content:flex-start;padding-top:20px;cursor:pointer}
    .side-indicator{position:fixed;left:12px;top:24px;font-size:34px;line-height:1;color:#dc2626;font-weight:900;opacity:0.9;transition:all 200ms ease;pointer-events:none;text-shadow:0 2px 6px rgba(0,0,0,0.18)}
    .side-actions:hover .side-indicator{opacity:1;left:16px}
    .side-actions .side-panel{position:fixed;left:0;top:20px;transform:translateX(-8px);display:flex;flex-direction:column;gap:12px;padding:16px;background:#fff;border-radius:0 8px 8px 0;opacity:0;transition:opacity .18s ease,transform .18s ease;pointer-events:none;box-shadow:0 12px 30px rgba(0,0,0,0.12);z-index:1200}
    .side-actions.show .side-panel{opacity:1;transform:translateX(0);pointer-events:auto}
    .side-actions .btn{padding:12px 18px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:0.95rem;display:inline-flex;align-items:center;gap:8px;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,0.08);min-width:140px;justify-content:center;transition:all 150ms ease;white-space:nowrap}
    .side-actions .btn-back{background:#dc2626;color:#fff}
    .side-actions .btn-back:hover{background:#b91c1c;transform:translateY(-2px)}

    /* overlay that blurs & darkens main content when panel open */
    .side-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.18);backdrop-filter:blur(4px);opacity:0;pointer-events:none;transition:opacity .18s ease;z-index:1000}
    .side-actions.show ~ .side-overlay{opacity:1;pointer-events:auto}

    /* Page Header Section */
    .page-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .page-section-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        color: #000;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Buttons */
    .btn, button {
        background: #21aef5;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(33,174,245,0.18);
        transition: all 180ms ease;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn:hover, button:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(33,174,245,0.28);
        filter: brightness(1.05);
    }

    .btn.danger {
        background: #dc2626 !important;
        color: #fff !important;
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.18) !important;
    }

    .btn.danger:hover {
        box-shadow: 0 12px 30px rgba(220, 38, 38, 0.28) !important;
    }

    /* Card Container */
    .card {
        background: #ffffff;
        border-radius: 12px;
        padding: 28px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 200ms ease;
    }

    .card:hover {
        border-color: #21aef5;
        box-shadow: 0 8px 24px rgba(33,174,245,0.08);
    }

    /* Saved items list */
    .saved-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .recent-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        padding: 18px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
        transition: all 200ms ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .recent-item:hover {
        border-color: #21aef5;
        box-shadow: 0 8px 20px rgba(33,174,245,0.1);
    }

    .recent-item > div:first-child {
        flex: 1;
        min-width: 0;
    }

    .recent-item strong {
        color: #000;
        font-weight: 700;
        font-size: 0.95rem;
        display: block;
        margin-bottom: 6px;
    }

    .recent-item small {
        color: #666;
        font-size: 0.85rem;
    }

    .recent-item div {
        display: flex;
        gap: 8px;
        font-size: 0.9rem;
        color: #666;
    }

    .recent-item-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .btn-view-item {
        background: #fbbf24 !important;
        color: #000 !important;
        border: none !important;
        padding: 8px 14px !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        font-size: 0.85rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.15) !important;
        transition: all 180ms ease !important;
        text-decoration: none !important;
    }

    .btn-view-item:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.25) !important;
    }

    .btn-delete-item {
        background: #dc2626 !important;
        color: #fff !important;
        border: none !important;
        padding: 8px 12px !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        font-size: 0.85rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15) !important;
        transition: all 180ms ease !important;
    }

    .btn-delete-item:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.25) !important;
    }

    /* Delete Confirmation Dialog */
    .delete-confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10001;
        backdrop-filter: blur(2px);
    }

    .delete-confirm-overlay.show {
        display: flex;
    }

    .delete-confirm-dialog {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        max-width: 420px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        text-align: center;
        animation: slideUp 0.4s cubic-bezier(0.2, 0.9, 0.2, 1);
    }

    .delete-confirm-dialog h3 {
        margin: 0 0 12px 0;
        color: #dc2626;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .delete-confirm-dialog p {
        color: #666;
        margin-bottom: 24px;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .delete-confirm-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .delete-confirm-actions button {
        padding: 10px 24px;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: all 180ms ease;
        font-size: 0.95rem;
        flex: 1;
    }

    .delete-confirm-actions .btn-confirm {
        background: #dc2626;
        color: #fff;
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.18);
    }

    .delete-confirm-actions .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(220, 38, 38, 0.28);
    }

    .delete-confirm-actions .btn-cancel {
        background: #f3f4f6;
        color: #333;
        border: 2px solid #e5e7eb;
    }

    .delete-confirm-actions .btn-cancel:hover {
        background: #e5e7eb;
        border-color: #d1d5db;
        transform: translateY(-2px);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Toast notification */
    .shout {
        position: fixed;
        top: 24px;
        right: 24px;
        background: #10b981;
        color: #fff;
        padding: 14px 20px;
        border-radius: 10px;
        box-shadow: 0 12px 36px rgba(16, 185, 129, 0.25);
        z-index: 99999;
        opacity: 0;
        transition: all 0.3s ease;
        text-align: center;
        font-size: 0.95rem;
        font-weight: 600;
        transform: translateX(400px);
        animation: slideInRight 0.4s ease;
    }

    .shout.show {
        transform: translateX(0);
        opacity: 1;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(400px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .shout.error {
        background: #dc2626;
        box-shadow: 0 12px 36px rgba(220, 38, 38, 0.25);
    }

    /* Empty state */
    .empty-state {
        padding: 60px 40px;
        text-align: center;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px dashed #e5e7eb;
    }

    .empty-state p {
        margin: 0;
        color: #666;
        font-size: 1rem;
    }

    .empty-state a {
        color: #21aef5;
        text-decoration: none;
        font-weight: 700;
    }

    .empty-state a:hover {
        text-decoration: underline;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
        .page-wrap {
            margin: 16px auto;
            padding: 0 16px;
        }

        .page-section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .recent-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .recent-item-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn-view-item,
        .btn-delete-item {
            width: 100% !important;
            justify-content: center !important;
        }
    }
</style>

<div class="side-actions" aria-hidden="false" id="sideActions">
    <span class="side-indicator">›</span>
    <div class="side-panel" role="toolbar" aria-orientation="vertical" aria-expanded="false">
        <button class="btn btn-back" type="button" onclick="history.back()">← Back</button>
    </div>
</div>
<div class="side-overlay" aria-hidden="true" id="sideOverlay"></div>

<div class="page-wrap">

    <div id="shout" class="shout" data-message="" aria-hidden="true" style="display:none">
        <div class="shout-inner"></div>
    </div>

    <!-- Delete Confirmation Dialog -->
    <div id="deleteItemConfirm" class="delete-confirm-overlay">
        <div class="delete-confirm-dialog">
            <h3>Delete Entry</h3>
            <p>Are you sure you want to delete this entry? This action cannot be undone.</p>
            <div class="delete-confirm-actions">
                <button type="button" class="btn-cancel" id="deleteCancelItem">Cancel</button>
                <button type="button" class="btn-confirm" id="deleteConfirmItem">Delete</button>
            </div>
        </div>
    </div>

    <!-- Delete All Confirmation Dialog -->
    <div id="deleteAllConfirm" class="delete-confirm-overlay">
        <div class="delete-confirm-dialog">
            <h3>Delete All Entries</h3>
            <p>Are you sure you want to delete ALL entries? This action cannot be undone and is permanent.</p>
            <div class="delete-confirm-actions">
                <button type="button" class="btn-cancel" id="deleteAllCancel">Cancel</button>
                <button type="button" class="btn-confirm" id="deleteAllConfirmBtn">Delete All</button>
            </div>
        </div>
    </div>




    <div class="page-section-header">
        <h1>Saved Form Reports</h1>
        <div class="header-actions">
            <button id="btnCreateNew" class="btn" type="button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Create New
            </button>
            <button id="btnDeleteAll" class="btn danger" type="button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Delete All
            </button>
        </div>
    </div>

    <div class="card">
        <?php if (!empty($forms)): ?>
            <div class="saved-list">
                <?php foreach($forms as $form): ?>
                    <div class="recent-item">
                        <div>
                            <?php
                                $from = !empty($form['from_name']) ? $form['from_name'] : '--Blank--';
                                $subjectFull = !empty($form['subject']) ? $form['subject'] : '--Blank--';
                                // Truncate helper (avoid cutting mid-word)
                                $max = 60;
                                if (mb_strlen($subjectFull) <= $max) {
                                    $subjectTrunc = esc($subjectFull);
                                } else {
                                    $part = mb_substr($subjectFull, 0, $max);
                                    $lastSpace = mb_strrpos($part, ' ');
                                    if ($lastSpace !== false && $lastSpace > intval($max * 0.4)) {
                                        $part = mb_substr($part, 0, $lastSpace);
                                    }
                                    $subjectTrunc = esc($part) . '...';
                                }
                            ?>
                            <div><strong>From:</strong> <?= esc($from) ?></div>
                            <div><strong>Subject:</strong> <small title="<?= esc($subjectFull) ?>"><?= $subjectTrunc ?></small></div>
                        </div>
                        <div class="recent-item-actions">
                            <a href="<?= site_url('form/view/' . $form['id']) ?>" class="btn-view-item" style="text-decoration: none;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                View
                            </a>
                            <button class="btn-delete-item delete-item-btn" data-id="<?= $form['id'] ?>" type="button">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No saved form reports yet. <a href="<?= site_url('form') ?>">Create your first entry!</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var currentDeleteId = null;
    var sideActions = document.getElementById('sideActions');
    var sideOverlay = document.getElementById('sideOverlay');
    var hoverTimeout;
    var deleteItemConfirm = document.getElementById('deleteItemConfirm');
    var deleteCancelItem = document.getElementById('deleteCancelItem');
    var deleteConfirmItem = document.getElementById('deleteConfirmItem');
    var btnCreateNew = document.getElementById('btnCreateNew');
    var btnDeleteAll = document.getElementById('btnDeleteAll');
    var deleteAllConfirm = document.getElementById('deleteAllConfirm');
    var deleteAllCancel = document.getElementById('deleteAllCancel');
    var deleteAllConfirmBtn = document.getElementById('deleteAllConfirmBtn');

    if (sideActions) {
        sideActions.addEventListener('mouseenter', function() {
            hoverTimeout = setTimeout(function() {
                sideActions.classList.add('show');
            }, 500);
        });

        sideActions.addEventListener('mouseleave', function() {
            clearTimeout(hoverTimeout);
            sideActions.classList.remove('show');
        });

        if (sideOverlay) {
            sideOverlay.addEventListener('click', function() {
                sideActions.classList.remove('show');
            });
        }
    }

    // Redirect to form creation page
    if (btnCreateNew) {
        btnCreateNew.addEventListener('click', function() {
            // Set flag to open modal automatically on form page
            sessionStorage.setItem('openFormModal', 'true');
            window.location.href = '<?= site_url('form') ?>';
        });
    }

    // Delete All button handler
    if (btnDeleteAll) {
        btnDeleteAll.addEventListener('click', function() {
            deleteAllConfirm.classList.add('show');
        });
    }

    // Cancel delete all
    if (deleteAllCancel) {
        deleteAllCancel.addEventListener('click', function() {
            deleteAllConfirm.classList.remove('show');
        });
    }

    // Confirm delete all
    if (deleteAllConfirmBtn) {
        deleteAllConfirmBtn.addEventListener('click', function() {
            var formData = new FormData();
            formData.append('action', 'delete_all');

            fetch('<?= site_url('form/delete') ?>', {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                console.log('Delete all response:', data);
                if (data && data.success) {
                    deleteAllConfirm.classList.remove('show');
                    
                    // Show success message
                    var shout = document.getElementById('shout');
                    if (shout) {
                        shout.classList.remove('error');
                        shout.classList.add('show');
                        shout.querySelector('.shout-inner').textContent = 'All entries deleted successfully';
                        shout.style.display = 'block';
                        shout.style.background = '#16a34a';
                        setTimeout(function() {
                            shout.classList.remove('show');
                            setTimeout(function() { 
                                shout.style.display = 'none';
                                // Reload page to show empty state
                                location.reload();
                            }, 300);
                        }, 2000);
                    }
                } else {
                    alert('Failed to delete all entries: ' + (data.message || 'Unknown error'));
                    deleteAllConfirm.classList.remove('show');
                }
            })
            .catch(function(error) {
                console.error('Delete all error:', error);
                alert('Error deleting all entries: ' + error.message);
                deleteAllConfirm.classList.remove('show');
            });
        });
    }

    // Attach delete handlers to all delete buttons
    document.querySelectorAll('.delete-item-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            currentDeleteId = this.dataset.id;
            deleteItemConfirm.classList.add('show');
        });
    });

    // Cancel delete
    if (deleteCancelItem) {
        deleteCancelItem.addEventListener('click', function() {
            deleteItemConfirm.classList.remove('show');
            currentDeleteId = null;
        });
    }

    // Confirm delete
    if (deleteConfirmItem) {
        deleteConfirmItem.addEventListener('click', function() {
            if (currentDeleteId) {
                var formData = new FormData();
                formData.append('id', currentDeleteId);
                formData.append('action', 'delete_single');

                fetch('<?= site_url('form/delete') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(function(response) {
                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }
                    return response.json();
                })
                .then(function(data) {
                    console.log('Delete response:', data);
                    if (data && data.success) {
                        deleteItemConfirm.classList.remove('show');
                        // Remove from list
                        var deletedItem = document.querySelector('.delete-item-btn[data-id="' + currentDeleteId + '"]').closest('.saved-item');
                        deletedItem.style.transition = 'opacity 0.3s ease';
                        deletedItem.style.opacity = '0';
                        setTimeout(function() {
                            deletedItem.remove();
                            
                            // Check if list is now empty
                            var remaining = document.querySelectorAll('.saved-item').length;
                            if (remaining === 0) {
                                location.reload();
                            }
                        }, 300);

                        // Show success message
                        var shout = document.getElementById('shout');
                        if (shout) {
                            shout.classList.remove('error');
                            shout.classList.add('show');
                            shout.querySelector('.shout-inner').textContent = 'Entry deleted successfully';
                            shout.style.display = 'block';
                            shout.style.background = '#16a34a';
                            setTimeout(function() {
                                shout.classList.remove('show');
                                setTimeout(function() { shout.style.display = 'none'; }, 300);
                            }, 3000);
                        }
                    } else {
                        alert('Failed to delete entry: ' + (data.message || 'Unknown error'));
                    }
                    currentDeleteId = null;
                })
                .catch(function(error) {
                    console.error('Delete error:', error);
                    alert('Error deleting entry: ' + error.message);
                    deleteItemConfirm.classList.remove('show');
                    currentDeleteId = null;
                });
            }
        });
    }
});
</script>
