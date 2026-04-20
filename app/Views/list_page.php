<style>
    /* Buttons + layout (inline) */
    .page-wrap {
        max-width: 980px;
        margin: 18px auto;
        padding: 18px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Back button for navigation */
    .btn-back {
        position: absolute;
        top: 18px;
        left: 18px;
        background: rgb(247, 11, 11);
        color: rgb(255, 255, 255);
        border: 2px solid rgb(247, 11, 11);
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 28px;
    }

    .page-header h1 {
        margin: 0;
        color: #000;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .btn {
        background: #21aef5ff;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(33,174,245,0.18);
        transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 14px 34px rgba(33,174,245,0.22);
    }

    .btn.danger {
        background: #dc2626 !important;
        color: #fff !important;
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.18) !important;
    }

    .btn.danger:hover {
        box-shadow: 0 14px 34px rgba(220, 38, 38, 0.25) !important;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
    }

    .btn:disabled:hover {
        transform: none !important;
        box-shadow: 0 8px 20px rgba(33,174,245,0.18) !important;
    }

    .btn.danger:disabled:hover {
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.18) !important;
    }

    .card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 8px 30px rgba(7,12,18,0.06);
        margin-bottom: 18px;
    }

    /* Saved items list */
    .saved-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .saved-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 14px;
        border-radius: 8px;
        border: 3px solid #666;
        background: #ffffff;
    }

    .saved-item-info {
        flex: 1;
        min-width: 0;
    }

    .saved-item strong {
        color: #000;
        font-weight: 700;
        font-size: 1rem;
        display: block;
        margin-bottom: 4px;
    }

    .saved-item .meta {
        color: #666;
        font-size: 0.85rem;
    }

    .saved-item-actions {
        display: flex;
        gap: 8px;
    }

    .btn-view-item {
        background: #fbbf24 !important;
        color: #000 !important;
        border: none !important;
        padding: 8px 14px !important;
        border-radius: 6px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        font-size: 0.9rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 6px 16px rgba(251, 191, 36, 0.15) !important;
        transition: transform 180ms ease, box-shadow 180ms ease !important;
    }

    .btn-view-item:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 24px rgba(251, 191, 36, 0.25) !important;
    }

    /* Delete Button Styles */
    .btn-delete-item {
        background: #dc2626 !important;
        color: #fff !important;
        border: none !important;
        padding: 8px 12px !important;
        border-radius: 6px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        font-size: 0.9rem !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.15) !important;
        transition: transform 180ms ease, box-shadow 180ms ease !important;
    }

    .btn-delete-item:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 10px 24px rgba(220, 38, 38, 0.25) !important;
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
    }

    .delete-confirm-overlay.show {
        display: flex;
    }

    .delete-confirm-dialog {
        background: #ffffff;
        border-radius: 16px;
        padding: 28px;
        max-width: 400px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        text-align: center;
        animation: slideUp 0.4s ease;
    }

    .delete-confirm-dialog h3 {
        margin-top: 0;
        color: #dc2626;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .delete-confirm-dialog p {
        color: #000;
        margin-bottom: 20px;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .delete-confirm-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .delete-confirm-actions button {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: all 180ms ease;
        font-size: 0.95rem;
    }

    .delete-confirm-actions .btn-confirm {
        background: #dc2626;
        color: #fff;
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.18);
    }

    .delete-confirm-actions .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(220, 38, 38, 0.25);
    }

    .delete-confirm-actions .btn-cancel {
        background: #f3f4f6;
        color: #333;
        border: 2px solid #d1d5db;
    }

    .delete-confirm-actions .btn-cancel:hover {
        background: #e5e7eb;
        border-color: #b4b8bf;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Toast notification */
    .shout {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-10px);
        background: #16a34a;
        color: #fff;
        padding: 12px 18px;
        border-radius: 10px;
        box-shadow: 0 12px 36px rgba(0,0,0,0.18);
        z-index: 99999;
        opacity: 0;
        transition: transform .3s ease, opacity .3s ease;
        text-align: center;
        font-size: 1rem;
        animation: slideDown 0.4s ease;
    }

    .shout.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }

    .shout-inner {
        font-weight: 700;
    }

    .shout.error {
        background: #dc2626;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateX(-50%) translateY(-20px); }
        to { opacity: 1; transform: translateX(-50%) translateY(0); }
    }

    /* Empty state */
    .empty-state {
        padding: 40px;
        text-align: center;
        background: #f9fafb;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
    }

    .empty-state p {
        margin: 0;
        color: #666;
        font-size: 1rem;
    }

    /* Responsive tweaks */
    @media (max-width: 720px) {
        .page-wrap {
            padding: 12px;
            margin: 12px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .saved-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .saved-item-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn-view-item,
        .btn-delete-item {
            width: 100% !important;
            justify-content: center !important;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="page-wrap">
    <button class="btn-back" type="button" onclick="history.back()">← Back</button>

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
            <p>Are you sure you want to delete ALL entries? This action cannot be undone.</p>
            <div class="delete-confirm-actions">
                <button type="button" class="btn-cancel" id="deleteAllCancel">Cancel</button>
                <button type="button" class="btn-confirm" id="deleteAllConfirm">Delete All</button>
            </div>
        </div>
    </div>

    <div class="page-header">
        <h1>Saved Data</h1>
        <div class="header-actions">
            <button id="btnCreateNew" class="btn" type="button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Create
            </button>
            <button id="btnDeleteAll" class="btn danger" type="button" <?php echo empty($forms) ? 'disabled' : ''; ?>>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    <div class="saved-item">
                        <div class="saved-item-info">
                            <strong><?= esc($form['from_name']) ?></strong>
                            <div class="meta">
                                <?= esc($form['subject']) ?> | 
                                <?= esc($form['date_received']) ?>
                            </div>
                        </div>
                        <div class="saved-item-actions">
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
                <p>No data yet. <a href="<?= site_url('form') ?>" style="color: #21aef5ff; text-decoration: none; font-weight: 700;">Create your first entry!</a></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var currentDeleteId = null;
    var deleteItemConfirm = document.getElementById('deleteItemConfirm');
    var deleteCancelItem = document.getElementById('deleteCancelItem');
    var deleteConfirmItem = document.getElementById('deleteConfirmItem');
    var btnCreateNew = document.getElementById('btnCreateNew');
    var btnDeleteAll = document.getElementById('btnDeleteAll');
    var deleteAllConfirm = document.getElementById('deleteAllConfirm');
    var deleteAllCancel = document.getElementById('deleteAllCancel');
    var deleteAllConfirmBtn = document.getElementById('deleteAllConfirm');

    // Redirect to form creation page
    if (btnCreateNew) {
        btnCreateNew.addEventListener('click', function() {
            window.location.href = '<?= site_url('form') ?>';
        });
    }

    // Delete All button
    if (btnDeleteAll) {
        btnDeleteAll.addEventListener('click', function(e) {
            e.preventDefault();
            deleteAllConfirm.classList.add('show');
        });
    }

    // Cancel Delete All
    if (deleteAllCancel) {
        deleteAllCancel.addEventListener('click', function() {
            deleteAllConfirm.classList.remove('show');
        });
    }

    // Confirm Delete All
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
                                location.reload();
                            }, 300);
                        }, 3000);
                    }
                } else {
                    alert('Failed to delete entries: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(function(error) {
                console.error('Delete all error:', error);
                alert('Error deleting entries: ' + error.message);
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
