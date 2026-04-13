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
            background: #ffffff;
            color: #21aef5ff;
            border: 2px solid #21aef5ff;
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
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(33,174,245,0.18);
        transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
    }

    .btn:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 14px 34px rgba(33,174,245,0.22);
    }

    .btn.secondary {
        background: transparent;
        color: #21aef5ff;
        border: 2px solid #21aef5ff;
        box-shadow: none;
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
    .saved-list { display: flex; flex-direction: column; gap: 10px; }
    .saved-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #eef8ff;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
    }
    .saved-item strong { color: #0b5480; }
    .saved-item a { color: #21aef5ff; text-decoration: none; font-weight: 700; }

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

    /* Responsive tweaks */
    @media (max-width: 720px) {
        .page-wrap { padding: 12px; margin: 12px; }
        .actions { flex-direction: column; }
        .btn { width: 100%; }
        .full-view { padding: 18px; }
    }
</style>

    <style>
        /* Shout (toast) */
        .shout{position:fixed;top:20px;left:50%;transform:translateX(-50%) translateY(-10px);background:#16a34a;color:#fff;padding:12px 18px;border-radius:10px;box-shadow:0 12px 36px rgba(0,0,0,0.18);z-index:99999;opacity:0;transition:transform .25s ease,opacity .25s ease}
        .shout.show{transform:translateX(-50%) translateY(0);opacity:1}
        .shout-inner{font-weight:700}
        .shout.error{background:#dc2626}
    </style>

<div class="page-wrap">
    <button class="btn-back" type="button" onclick="history.back()">Back</button>
    <?php
        $success = isset($success) ? $success : session()->getFlashdata('success');
        $error   = isset($error) ? $error : session()->getFlashdata('error');
        $msg     = $success ?: $error ?: '';
        $type    = $success ? 'success' : ($error ? 'error' : '');
    ?>
    <div id="shout" class="shout <?= $type ?>" data-message="<?= $msg ? esc($msg) : '' ?>" aria-hidden="<?= $msg ? 'false' : 'true' ?>" <?= $msg ? '' : 'style="display:none"' ?> >
        <div class="shout-inner"><?= $msg ? esc($msg) : '' ?></div>
    </div>
    <div class="actions">
        <button id="btnCreate" class="btn" type="button">Create</button>
        <button id="btnView" class="btn secondary" type="button">View</button>
    </div>

    <div id="createSection" class="card">
        <h2>Fill Form</h2>

        <form method="post" action="">
            <input name="from_name" placeholder="From"><br>
            <input type="date" name="date_received"><br>
            <input name="origin" placeholder="Origin"><br>
            <input name="reference_no" placeholder="Reference No"><br>
            <textarea name="subject" placeholder="Subject"></textarea><br>
            <textarea name="instructions" placeholder="Instructions"></textarea><br>
            <button type="submit">Save</button>
        </form>
    </div>

    <div id="viewSection" class="card hidden" aria-hidden="true">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:12px;">
            <h2 style="margin:0;">Saved Data</h2>
            <div style="display:flex; gap:8px;">
                <button id="closeView" class="btn secondary" type="button">Close</button>
            </div>
        </div>

        <div class="saved-list">
            <?php foreach($forms as $f): ?>
                <div class="saved-item">
                    <div>
                        <strong><?= htmlspecialchars($f['from_name'], ENT_QUOTES, 'UTF-8') ?></strong><br>
                        <small><?= htmlspecialchars($f['date_received'] ?? '', ENT_QUOTES, 'UTF-8') ?> — <?= htmlspecialchars($f['subject'] ?? '', ENT_QUOTES, 'UTF-8') ?></small>
                    </div>
                    <div>
                        <a href="#" class="view-link" data-id="<?= $f['id'] ?>">View</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btnCreate = document.getElementById('btnCreate');
    var btnView = document.getElementById('btnView');
    var createSection = document.getElementById('createSection');
    var viewSection = document.getElementById('viewSection');
    var closeView = document.getElementById('closeView');

    btnCreate.addEventListener('click', function (e) {
        e.preventDefault();
        createSection.classList.remove('hidden');
        viewSection.classList.add('hidden');
        viewSection.classList.remove('full-view');
        viewSection.setAttribute('aria-hidden', 'true');
        createSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    btnView.addEventListener('click', function (e) {
        e.preventDefault();
        viewSection.classList.remove('hidden');
        createSection.classList.add('hidden');
        viewSection.classList.add('full-view');
        viewSection.setAttribute('aria-hidden', 'false');
        viewSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    closeView.addEventListener('click', function () {
        viewSection.classList.remove('full-view');
        viewSection.classList.add('hidden');
        viewSection.setAttribute('aria-hidden', 'true');
        createSection.classList.remove('hidden');
        createSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });

    // Show shout (toast) if server set a success message, then clear the form
    var shout = document.getElementById('shout');
    if (shout && shout.dataset && shout.dataset.message) {
        // ensure create section visible
        createSection.classList.remove('hidden');
        viewSection.classList.add('hidden');
        viewSection.classList.remove('full-view');

        shout.style.display = 'block';
        // small delay so CSS transition runs
        setTimeout(function () { shout.classList.add('show'); }, 10);

        // clear all fields so user can type another entry
        var formEl = document.querySelector('form');
        if (formEl) {
            try { formEl.reset(); } catch (e) { /* ignore */ }
        }

        // auto-hide after 3s
        setTimeout(function () {
            shout.classList.remove('show');
            setTimeout(function () { shout.style.display = 'none'; }, 250);
        }, 3000);
    }

    // If the page was opened with #view, show the saved-data view automatically
    if (window.location.hash === '#view') {
        // ensure the view section is shown
        viewSection.classList.remove('hidden');
        createSection.classList.add('hidden');
        viewSection.classList.add('full-view');
        viewSection.setAttribute('aria-hidden', 'false');
        viewSection.scrollIntoView({ behavior: 'instant', block: 'start' });
        // remove hash so repeated reloads behave normally
        history.replaceState(null, document.title, window.location.pathname + window.location.search);
    }

    // Handle dynamic View link navigation so links always use the same host/path
    document.querySelectorAll('.view-link').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var id = this.dataset.id;
            var base = window.location.href.replace(/#.*$/, '');
            // remove trailing /view/... if present
            base = base.replace(/\/view\/[^\/]+$/, '');
            // ensure no trailing slash
            base = base.replace(/\/$/, '');
            window.location.href = base + '/view/' + id;
        });
    });
});
</script>