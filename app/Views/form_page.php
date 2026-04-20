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

    .actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
        margin-bottom: 18px;
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

    .btn.secondary {
        background: #fbbf24 !important;
        color: #000 !important;
        border: none !important;
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.18) !important;
    }

    .btn.secondary:hover {
        box-shadow: 0 14px 34px rgba(251, 191, 36, 0.22) !important;
    }

    #closeView {
        background: #f70b0b !important;
        color: #fff !important;
        box-shadow: 0 8px 20px rgba(247, 11, 11, 0.18) !important;
    }

    #closeView:hover {
        box-shadow: 0 14px 34px rgba(247, 11, 11, 0.22) !important;
    }

    .card {
        background: #ffffff;
        border-radius: 12px;
        padding: 18px;
        box-shadow: 0 8px 30px rgba(7,12,18,0.06);
        margin-bottom: 18px;
    }

    /* Form inputs nicer spacing */
    form input, form textarea, form button[type="submit"] {
        width: 100%;
        padding: 10px 12px;
        margin: 8px 0;
        border-radius: 8px;
        border: 1px solid #e6eef7;
        font-size: 0.95rem;
        background: #fbfdff;
        box-sizing: border-box;
        outline: none;
    }

    form textarea { min-height: 110px; resize: vertical; }

    form button[type="submit"] {
        background: #21aef5ff;
        color: #fff;
        border: none;
        padding: 10px 14px;
        cursor: pointer;
        border-radius: 8px;
        font-weight: 700;
        margin-top: 8px;
    }

    /* Saved items list */
    .saved-list { display: flex; flex-direction: column; gap: 12px; }
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
    .saved-item strong { color: #000; font-weight: 700; font-size: 1rem; }
    .saved-item a { color: #21aef5ff; text-decoration: none; font-weight: 700; }

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

    /* Scrollable Recently Added Container */
    .recently-added-scroll {
        max-height: 330px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 4px;
        width: 100%;
        box-sizing: border-box;
    }

    .recently-added-scroll::-webkit-scrollbar {
        width: 10px;
    }

    .recently-added-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .recently-added-scroll::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: 10px;
    }

    .recently-added-scroll::-webkit-scrollbar-thumb:hover {
        background: #888;
    }

    .recent-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 12px;
        border-radius: 8px;
        border: 2px solid #000;
        background: #ffffff;
        transition: all 200ms ease;
    }

    .recent-item:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .recent-item strong {
        color: #000;
        font-weight: 700;
        font-size: 1rem;
    }

    .recent-item small {
        color: #666;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Hidden utility */
    .hidden { display: none !important; }

    /* Full page view mode for saved data */
    .full-view {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        overflow: auto;
        background: #ffffff;
        padding: 28px;
        z-index: 9999;
    }

    .full-view h2 {
        font-weight: 700;
        font-size: 1.5rem;
    }

    /* Floating Modal Form */
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
        animation: fadeIn 0.2s ease;
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
        padding: 28px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: slideUp 0.3s ease;
        position: relative;
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

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h2 {
        margin: 0;
        color: #000;
        font-weight: 700;
    }

    .modal-close {
        background: #f3f4f6;
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
    }

    .modal-close:hover {
        background: #e5e7eb;
    }

    .modal-form {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group label {
        font-weight: 700;
        color: #000;
        font-size: 0.95rem;
    }

    .modal-form input,
    .modal-form textarea {
        padding: 12px !important;
        margin: 0 !important;
        border-radius: 8px !important;
        border: 2px solid #d1d5db !important;
        font-size: 0.95rem !important;
        background: #f9fafb !important;
        box-sizing: border-box !important;
        outline: none !important;
        color: #000 !important;
        font-weight: 500 !important;
        transition: border-color 180ms ease, background-color 180ms ease;
    }

    .modal-form input:focus,
    .modal-form textarea:focus {
        border-color: #21aef5ff !important;
        background: #ffffff !important;
    }

    .modal-form textarea {
        min-height: 120px !important;
        resize: vertical !important;
    }

    .modal-form button[type="submit"] {
        margin: 0 !important;
        padding: 12px 18px !important;
        background: #21aef5ff !important;
        color: #fff !important;
        border: none !important;
        border-radius: 8px !important;
        font-weight: 700 !important;
        cursor: pointer !important;
        font-size: 0.95rem !important;
        box-shadow: 0 8px 20px rgba(33, 174, 245, 0.18) !important;
        transition: transform 180ms ease, box-shadow 180ms ease !important;
        margin-top: 12px !important;
    }

    .modal-form input:disabled,
    .modal-form textarea:disabled {
        background: #f3f4f6 !important;
        color: #999 !important;
        cursor: not-allowed !important;
        border-color: #d1d5db !important;
    }

    .modal-form input:disabled::placeholder,
    .modal-form textarea:disabled::placeholder {
        color: #bbb !important;
    }

    /* Responsive tweaks */
    @media (max-width: 720px) {
        .page-wrap { padding: 12px; margin: 12px; }
        .actions { flex-direction: column; }
        .btn { width: 100%; }
        .full-view { padding: 18px; }
        .floating-form-container { width: 95%; padding: 20px; }
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
    <button class="btn-back" type="button" onclick="history.back()">Close</button>
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
                    <label for="instructions">Instructions</label>
                    <textarea id="instructions" name="instructions" placeholder="Enter instructions"></textarea>
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
    var btnCreate = document.getElementById('btnCreate');
    var formModal = document.getElementById('formModal');
    var modalClose = document.getElementById('modalClose');
    var createSection = document.getElementById('createSection');

    // Open floating form modal
    btnCreate.addEventListener('click', function (e) {
        e.preventDefault();
        formModal.classList.add('show');
        // Reinitialize field access when opening the form
        setTimeout(function() {
            initializeFieldAccess();
        }, 100);
    });

    // Close floating form modal
    modalClose.addEventListener('click', function () {
        formModal.classList.remove('show');
    });

    // Prevent Enter key from submitting form on input fields
    // Allow Enter to create new lines in textareas
    var modalForm = document.querySelector('.modal-form');
    if (modalForm) {
        var inputFields = modalForm.querySelectorAll('input');
        inputFields.forEach(function(field) {
            field.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    }

    // Sequential field access - only enable next field when current is filled
    var formGroups = document.querySelectorAll('.form-group');
    var sequentialFields = [];
    
    formGroups.forEach(function(group, index) {
        var field = group.querySelector('input, textarea');
        if (field && field.name !== 'instructions') {
            sequentialFields.push(field);
        }
    });

    // Initialize: disable all fields except the first one
    function initializeFieldAccess() {
        sequentialFields.forEach(function(field, index) {
            if (index === 0) {
                field.disabled = false;
            } else {
                field.disabled = true;
            }
        });
        // Instructions field is always enabled
        var instructionsField = document.getElementById('instructions');
        if (instructionsField) {
            instructionsField.disabled = false;
        }
    }

    // Check if a field is filled
    function isFieldFilled(field) {
        return field && field.value && field.value.trim() !== '';
    }

    // Update field access based on previous fields
    function updateFieldAccess() {
        sequentialFields.forEach(function(field, index) {
            if (index === 0) {
                field.disabled = false;
            } else {
                // Check if all previous fields are filled
                var allPreviousFilled = true;
                for (var i = 0; i < index; i++) {
                    if (!isFieldFilled(sequentialFields[i])) {
                        allPreviousFilled = false;
                        break;
                    }
                }
                field.disabled = !allPreviousFilled;
            }
        });
    }

    // Add event listeners to all sequential fields
    sequentialFields.forEach(function(field) {
        field.addEventListener('input', function() {
            updateFieldAccess();
        });
        field.addEventListener('change', function() {
            updateFieldAccess();
        });
    });

    // Initialize on form open
    initializeFieldAccess();

    // Handle form submission via AJAX to keep modal open
    var modalForm = document.querySelector('.modal-form');
    if (modalForm) {
        modalForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
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
                // Reinitialize sequential field access
                setTimeout(function() {
                    initializeFieldAccess();
                }, 50);
            }
            confirmDialog.classList.remove('show');
            // Focus on first input for better UX
            var firstInput = modalForm.querySelector('input, textarea');
            if (firstInput) {
                setTimeout(function() { firstInput.focus(); }, 200);
            }
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
                        html += '<div class="recent-item">' +
                            '<strong>' + escapeHtml(item.from_name) + '</strong>' +
                            '<small>' + escapeHtml(item.date_received) + ' — ' + escapeHtml(item.subject) + '</small>' +
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

    // Load recent items on page load
    updateRecentlyAdded();

    // Auto-refresh every 5 seconds
    setInterval(updateRecentlyAdded, 5000);
});
</script>