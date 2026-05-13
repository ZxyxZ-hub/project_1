<link rel="stylesheet" href="<?= base_url('css/shared-styles.css') ?>">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, rgb(231, 233, 235) 0%, rgb(171, 203, 207) 100%); }
    
    body { color: #000; }

    /* Page Header with Navigation */
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

    .page-header-right {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    /* Page Layout */
    .page-wrap {
        max-width: 1100px;
        margin: 32px auto;
        padding: 0 20px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
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
    .side-actions .btn-logout{background:#dc2626;color:#fff}
    .side-actions .btn-logout:hover{background:#b91c1c;transform:translateY(-2px)}

    /* overlay that blurs & darkens main content when panel open */
    .side-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.18);backdrop-filter:blur(4px);opacity:0;pointer-events:none;transition:opacity .18s ease;z-index:1000}
    .side-actions.show ~ .side-overlay{opacity:1;pointer-events:auto}

    /* Actions Section */
    .actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

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

    .btn.secondary {
        background: #fbbf24 !important;
        color: #000 !important;
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.18) !important;
    }

    .btn.secondary:hover {
        box-shadow: 0 12px 30px rgba(251, 191, 36, 0.28) !important;
    }

    /* Card Container */
    .card {
        background: #ffffff;
        border-radius: 12px;
        padding: 28px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 24px;
        transition: all 200ms ease;
    }

    .card:hover {
        border-color: #21aef5;
        box-shadow: 0 8px 24px rgba(33,174,245,0.08);
    }

    .card h2 {
        margin: 0 0 16px 0;
        font-size: 1.4rem;
        font-weight: 700;
        color: #000;
    }

    .card p {
        margin: 0;
        color: #666;
        font-size: 1rem;
        line-height: 1.6;
    }

    /* Recent Items Scroll */
    .recently-added-scroll {
        max-height: 400px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 6px;
        width: 100%;
        box-sizing: border-box;
    }

    .recently-added-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .recently-added-scroll::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }

    .recently-added-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .recently-added-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .recent-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 14px;
        margin-bottom: 10px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        transition: all 200ms ease;
    }

    .recent-item:hover {
        background: #ffffff;
        border-color: #21aef5;
        box-shadow: 0 4px 12px rgba(33,174,245,0.1);
    }

    .recent-item strong {
        color: #000;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .recent-item small {
        color: #666;
        font-size: 0.85rem;
    }

    .recent-item div {
        display: flex;
        gap: 8px;
        font-size: 0.9rem;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9998;
        animation: fadeIn 0.3s ease;
        backdrop-filter: blur(2px);
    }

    .modal-overlay.show {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .floating-form-container {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        max-width: 540px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideUp 0.4s cubic-bezier(0.2, 0.9, 0.2, 1);
        position: relative;
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

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #f0f0f0;
    }

    .modal-header h2 {
        margin: 0;
        color: #000;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .modal-close {
        background: #f3f4f6;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 180ms ease;
        color: #666;
        flex-shrink: 0;
    }

    .modal-close:hover {
        background: #e5e7eb;
        color: #000;
        transform: rotate(90deg);
    }

    .modal-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-weight: 600;
        color: #000;
        font-size: 0.95rem;
    }

    .modal-form input,
    .modal-form textarea {
        padding: 12px 14px !important;
        margin: 0 !important;
        border-radius: 10px !important;
        border: 2px solid #e5e7eb !important;
        font-size: 0.95rem !important;
        background: #f9fafb !important;
        box-sizing: border-box !important;
        outline: none !important;
        color: #000 !important;
        font-weight: 500 !important;
        transition: all 180ms ease !important;
        font-family: inherit !important;
    }

    .modal-form input:focus,
    .modal-form textarea:focus {
        border-color: #21aef5 !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(33, 174, 245, 0.1) !important;
    }

    .modal-form textarea {
        min-height: 120px !important;
        resize: vertical !important;
    }

    .modal-form button[type="submit"] {
        margin: 0 !important;
        padding: 12px 20px !important;
        background: #21aef5 !important;
        color: #fff !important;
        border: none !important;
        border-radius: 10px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        font-size: 0.95rem !important;
        box-shadow: 0 8px 20px rgba(33, 174, 245, 0.18) !important;
        transition: all 180ms ease !important;
        margin-top: 12px !important;
    }

    .modal-form button[type="submit"]:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 12px 30px rgba(33, 174, 245, 0.28) !important;
    }

    /* Toast Notifications */
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

    /* Confirmation Dialog */
    .confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        animation: fadeIn 0.3s ease;
        backdrop-filter: blur(2px);
    }

    .confirm-overlay.show {
        display: flex;
    }

    .confirm-dialog {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        max-width: 420px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
        text-align: center;
        animation: slideUp 0.4s cubic-bezier(0.2, 0.9, 0.2, 1);
    }

    .confirm-dialog h3 {
        margin: 0 0 12px 0;
        color: #000;
        font-size: 1.2rem;
        font-weight: 700;
    }

    .confirm-dialog p {
        color: #666;
        margin-bottom: 24px;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .confirm-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .confirm-actions button {
        padding: 10px 24px;
        border-radius: 10px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: all 180ms ease;
        font-size: 0.95rem;
        flex: 1;
    }

    .confirm-actions .btn-stay {
        background: #21aef5;
        color: #fff;
        box-shadow: 0 8px 20px rgba(33, 174, 245, 0.18);
    }

    .confirm-actions .btn-stay:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(33, 174, 245, 0.28);
    }

    .confirm-actions .btn-exit {
        background: #f3f4f6;
        color: #333;
        border: 2px solid #e5e7eb;
    }

    .confirm-actions .btn-exit:hover {
        background: #e5e7eb;
        border-color: #d1d5db;
        transform: translateY(-2px);
    }

    /* Hidden utility */
    .hidden { display: none !important; }

    /* Responsive */
    @media (max-width: 768px) {
        .page-wrap { margin: 16px auto; padding: 0 16px; }
        .actions { flex-direction: column; }
        .btn { width: 100%; }
        .floating-form-container { padding: 24px; }
        .page-header { padding: 12px 16px; }
    }
</style>

    <style>
        /* Shout (toast) */
        .shout{position:fixed;top:20px;left:50%;transform:translateX(-50%) translateY(-10px);background:#16a34a;color:#fff;padding:12px 18px;border-radius:10px;box-shadow:0 12px 36px rgba(0,0,0,0.18);z-index:99999;opacity:0;transition:transform .3s ease,opacity .3s ease;text-align:center;font-size:1rem;animation:slideDown 0.4s ease}
        .shout.show{transform:translateX(-50%) translateY(0);opacity:1}
        .shout-inner{font-weight:700}
        .shout.error{background:#dc2626}
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateX(-50%) translateY(-20px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        
        /* Confirmation Dialog */
        .confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        }
        
        .confirm-overlay.show {
            display: flex;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .confirm-dialog {
            background: #ffffff;
            border-radius: 16px;
            padding: 28px;
            max-width: 400px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            text-align: center;
            animation: slideUp 0.4s ease;
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
        
        .confirm-dialog h3 {
            margin-top: 0;
            color: #000;
            font-size: 1.2rem;
            font-weight: 700;
        }
        
        .confirm-dialog p {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        .confirm-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        
        .confirm-actions button {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            transition: all 180ms ease;
            font-size: 0.95rem;
        }
        
        .confirm-actions .btn-stay {
            background: #21aef5ff;
            color: #fff;
            box-shadow: 0 8px 20px rgba(33, 174, 245, 0.18);
        }
        
        .confirm-actions .btn-stay:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(33, 174, 245, 0.25);
        }
        
        .confirm-actions .btn-exit {
            background: #f3f4f6;
            color: #333;
            border: 2px solid #d1d5db;
        }
        
        .confirm-actions .btn-exit:hover {
            background: #e5e7eb;
            border-color: #b4b8bf;
        }
    </style>

<div class="page-wrap">
    <div class="side-actions" aria-hidden="false" id="sideActions">
        <span class="side-indicator">›</span>
        <div class="side-panel" role="toolbar" aria-orientation="vertical" aria-expanded="false">
            <form action="<?= base_url('auth/logout') ?>" method="POST" style="margin:0;">
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>
    <div class="side-overlay" aria-hidden="true" id="sideOverlay"></div>
    <?php
        $success = isset($success) ? $success : session()->getFlashdata('success');
        $error   = isset($error) ? $error : session()->getFlashdata('error');
        $msg     = $success ?: $error ?: '';
        $type    = $success ? 'success' : ($error ? 'error' : '');
    ?>
    <div id="shout" class="shout <?= $type ?>" data-message="<?= $msg ? esc($msg) : '' ?>" aria-hidden="<?= $msg ? 'false' : 'true' ?>" <?= $msg ? '' : 'style="display:none"' ?> >
        <div class="shout-inner"><?= $msg ? esc($msg) : '' ?></div>
    </div>
    
    <!-- Confirmation Dialog -->
    <div id="confirmDialog" class="confirm-overlay">
        <div class="confirm-dialog">
            <h3 id="confirmTitle">Data Saved Successfully!</h3>
            <p id="confirmMessage">Would you like to add another entry or are you done?</p>
            <div class="confirm-actions">
                <button type="button" class="btn-stay" id="btnStay">Add Another</button>
                <button type="button" class="btn-exit" id="btnDone">Done</button>
            </div>
        </div>
    </div>
    
    <!-- Modal Overlay -->
    <div id="formModal" class="modal-overlay">
        <div class="floating-form-container">
            <div class="modal-header">
                <h2>Fill Form</h2>
                <button class="modal-close" type="button" id="modalClose" aria-label="Close form">×</button>
            </div>
            
            <form method="post" action="" class="modal-form">
                <div class="form-group">
                    <label for="from_name">From Name</label>
                    <input id="from_name" name="from_name" placeholder="Enter name" required>
                </div>
                
                <div class="form-group">
                    <label for="date_received">Date Received</label>
                    <input id="date_received" type="date" name="date_received" required>
                </div>
                
                <div class="form-group">
                    <label for="origin">Origin</label>
                    <input id="origin" name="origin" placeholder="Enter origin" required>
                </div>
                
                <div class="form-group">
                    <label for="reference_no">Reference No</label>
                    <input id="reference_no" name="reference_no" placeholder="Enter reference number" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <textarea id="subject" name="subject" placeholder="Enter subject" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="date_issued">Date Issued</label>
                    <input id="date_issued" type="date" name="date_issued" required>
                </div>
                
                <div class="form-group">
                    <label for="instructions">Instructions</label>
                    <textarea id="instructions" name="instructions" placeholder="Enter instructions"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="target_date">Target Date</label>
                    <input id="target_date" type="date" name="target_date">
                </div>
                
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <div class="actions">
        <button id="btnCreate" class="btn" type="button"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> Create</button>
        <a href="<?= site_url('form/list') ?>" class="btn secondary" style="text-decoration: none; text-align: center;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> View All</a>
    </div>

    <div id="createSection" class="card">
        <h2>Ready to create</h2>
        <p>Click the <strong>Create</strong> button above to open the form.</p>
    </div>

    <!-- Latest Data Display (Live Preview) -->
    <div id="latestDataSection" class="card">
        <h2 style="margin-top: 0; margin-bottom: 18px; font-size: 1.3rem; color: #000; font-weight: 700;">Recently Added</h2>
        <div class="recently-added-scroll" id="recentlyAddedContainer">
            <div style="display: flex; flex-direction: column; gap: 10px; width: 100%;" id="recentItemsList">
                <div style="padding: 16px; text-align: center; color: #000; background: #f9fafb; border-radius: 8px; border: 2px solid #000; font-weight: 600;">
                    <p style="margin: 0; font-size: 0.95rem;">No data yet. Create your first entry!</p>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var sideActions = document.getElementById('sideActions');
    var sideOverlay = document.getElementById('sideOverlay');
    var hoverTimeout;
    var btnCreate = document.getElementById('btnCreate');
    var formModal = document.getElementById('formModal');
    var modalClose = document.getElementById('modalClose');
    var createSection = document.getElementById('createSection');

    if (sideActions) {
        sideActions.addEventListener('mouseenter', function () {
            hoverTimeout = setTimeout(function () {
                sideActions.classList.add('show');
            }, 500);
        });

        sideActions.addEventListener('mouseleave', function () {
            clearTimeout(hoverTimeout);
            sideActions.classList.remove('show');
        });

        if (sideOverlay) {
            sideOverlay.addEventListener('click', function () {
                sideActions.classList.remove('show');
            });
        }
    }

    // Open floating form modal
    btnCreate.addEventListener('click', function (e) {
        e.preventDefault();
        formModal.classList.add('show');
    });

    // Close floating form modal
    modalClose.addEventListener('click', function () {
        formModal.classList.remove('show');
    });

    // Don't close modal when clicking outside - only close with X button

    // Check if modal should be opened automatically (from list page)
    if (sessionStorage.getItem('openFormModal') === 'true') {
        formModal.classList.add('show');
        sessionStorage.removeItem('openFormModal');
    }

    // Handle form submission via AJAX to keep modal open
    var modalForm = document.querySelector('.modal-form');
    var isSubmitting = false; // Flag to prevent duplicate submissions
    if (modalForm) {
        modalForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
            // Prevent duplicate submissions
            if (isSubmitting) {
                return;
            }
            isSubmitting = true;
            
            var formData = new FormData(modalForm);
            var actionUrl = modalForm.getAttribute('action') || '';
            
            fetch(actionUrl, {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {
                // Show success message in the toast with smooth animation
                var shout = document.getElementById('shout');
                if (shout) {
                    shout.classList.remove('error');
                    shout.classList.add('show');
                    shout.textContent = 'Saved successfully';
                    shout.style.display = 'block';
                    shout.style.background = '#16a34a';
                }
                
                // Keep the success message visible for 5 seconds
                // Then show confirmation dialog
                var confirmDialog = document.getElementById('confirmDialog');
                var timerDuration = 5000; // 5 seconds
                
                setTimeout(function () {
                    // Hide the toast smoothly
                    if (shout) {
                        shout.classList.remove('show');
                        setTimeout(function () { shout.style.display = 'none'; }, 300);
                    }
                    
                    // Show confirmation dialog
                    if (confirmDialog) {
                        confirmDialog.classList.add('show');
                    }
                    
                    // Reset submission flag
                    isSubmitting = false;
                }, timerDuration);
            })
            .catch(function(error) {
                // Show error message in the toast
                var shout = document.getElementById('shout');
                if (shout) {
                    shout.classList.add('error');
                    shout.classList.add('show');
                    shout.textContent = 'Error saving data. Please try again.';
                    shout.style.display = 'block';
                }
                
                // Auto-hide error after 5s
                setTimeout(function () {
                    if (shout) {
                        shout.classList.remove('show');
                        setTimeout(function () { shout.style.display = 'none'; }, 250);
                    }
                    
                    // Reset submission flag
                    isSubmitting = false;
                }, 5000);
            });
        });
    }
    
    // Handle confirmation dialog buttons
    var confirmDialog = document.getElementById('confirmDialog');
    var btnStay = document.getElementById('btnStay');
    var btnDone = document.getElementById('btnDone');
    
    if (btnStay) {
        btnStay.addEventListener('click', function () {
            // Clear form but keep modal open
            if (modalForm) {
                modalForm.reset();
            }
            confirmDialog.classList.remove('show');
            // Focus on first input for better UX
            var firstInput = modalForm.querySelector('input, textarea');
            if (firstInput) {
                setTimeout(function() { firstInput.focus(); }, 200);
            }
            // Reset submission flag
            isSubmitting = false;
        });
    }
    
    if (btnDone) {
        btnDone.addEventListener('click', function () {
            // Clear form and close modal
            if (modalForm) {
                modalForm.reset();
            }
            confirmDialog.classList.remove('show');
            formModal.classList.remove('show');
            // Hide the "Ready to create" section to show normal state
            createSection.classList.remove('hidden');
            // Reset submission flag
            isSubmitting = false;
        });
    }

    // Show shout (toast) if server set a success message on page load (when redirected)
    var shout = document.getElementById('shout');
    if (shout && shout.dataset && shout.dataset.message) {
        // Ensure create section visible and modal closed
        createSection.classList.remove('hidden');
        formModal.classList.remove('show');

        shout.style.display = 'block';
        // small delay so CSS transition runs
        setTimeout(function () { shout.classList.add('show'); }, 10);

        // auto-hide after 3s
        setTimeout(function () {
            shout.classList.remove('show');
            setTimeout(function () { shout.style.display = 'none'; }, 250);
        }, 3000);
    }

    // Live preview of recently added items - refresh every 5 seconds
    function updateRecentlyAdded() {
        fetch('<?= site_url('form/recent') ?>')
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(function(data) {
                var container = document.getElementById('recentItemsList');
                if (!container) {
                    console.error('Container not found');
                    return;
                }

                console.log('Recent items data:', data);
                
                if (data.forms && data.forms.length > 0) {
                    // Show ALL items (not limited to 4)
                    var items = data.forms;
                    var html = '';
                    items.forEach(function(item) {
                        var from = item.from_name || '--Blank--';
                        var subject = item.subject || '--Blank--';
                        var createdBy = item.created_by || '--Unknown--';
                        var truncated = truncateText(subject, 60);

                        html += '<div class="recent-item">' +
                            '<div><strong>From:</strong> ' + escapeHtml(from) + '</div>' +
                            '<div><strong>Subject:</strong> <small title="' + escapeHtml(subject) + '">' + escapeHtml(truncated) + '</small></div>' +
                            '<div><strong>Created by:</strong> ' + escapeHtml(createdBy) + '</div>' +
                            '</div>';
                    });
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<div style="padding: 16px; text-align: center; color: #000; background: #f9fafb; border-radius: 8px; border: 2px solid #000; font-weight: 600;"><p style="margin: 0; font-size: 0.95rem;">No data yet. Create your first entry!</p></div>';
                }
            })
            .catch(function(error) {
                console.error('Error fetching recent items:', error);
                var container = document.getElementById('recentItemsList');
                if (container) {
                    container.innerHTML = '<div style="padding: 16px; text-align: center; color: #dc2626; background: #fef2f2; border-radius: 8px; border: 2px solid #dc2626; font-weight: 600;"><p style="margin: 0; font-size: 0.95rem;">Error loading data</p></div>';
                }
            });
    }

    // Helper function to escape HTML
    function escapeHtml(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Helper to truncate long text nicely (avoid cutting mid-word)
    function truncateText(text, maxLen) {
        if (!text) return '';
        text = text.toString();
        if (text.length <= maxLen) return text;
        var truncated = text.substr(0, maxLen);
        var lastSpace = truncated.lastIndexOf(' ');
        if (lastSpace > Math.floor(maxLen * 0.4)) {
            truncated = truncated.substr(0, lastSpace);
        }
        return truncated.trim() + '...';
    }

    // Load recent items on page load
    updateRecentlyAdded();

    // Auto-refresh every 5 seconds
    setInterval(updateRecentlyAdded, 5000);
});
</script>