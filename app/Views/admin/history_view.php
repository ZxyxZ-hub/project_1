<?php
$session = session();
if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
    return redirect()->to('/auth/login');
}
$details = json_decode($record['details'] ?? '', true);
if (!is_array($details)) {
    $details = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Record</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { 
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; 
            background: #f0f4f8; 
            color: #000; 
            margin: 0; 
            padding: 0;
        }
        body { position: relative; }
        
        .page-wrapper {
            max-width: 1400px;
            margin: 30px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .view-header {
            background: #f3f4f6;
            padding: 24px 32px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }
        
        .view-header-left h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
            color: #000;
        }
        
        .view-header-right {
            text-align: left;
        }
        
        .timestamp-badge {
            display: block;
            color: #000;
            padding: 0;
            border-radius: 0;
            font-size: 1rem;
            font-weight: 700;
            white-space: nowrap;
            margin-bottom: 8px;
        }
        
        .view-header-right .header-info {
            font-size: 0.95rem;
            color: #000;
            line-height: 1.6;
        }
        
        .view-header-right .header-info strong {
            font-weight: 700;
        }
        
        /* Sidebar styles */
        .side-actions{position:fixed;left:0;top:0;width:80px;height:100vh;z-index:1100;display:flex;align-items:flex-start;justify-content:flex-start;padding-top:20px;cursor:pointer}
        .side-indicator{position:fixed;left:12px;top:24px;font-size:34px;line-height:1;color:#dc2626;font-weight:900;opacity:0.9;transition:all 200ms ease;pointer-events:none;text-shadow:0 2px 6px rgba(0,0,0,0.18)}
        .side-actions:hover .side-indicator{opacity:1;left:16px}
        .side-actions .side-panel{position:fixed;left:0;top:20px;transform:translateX(-8px);display:flex;flex-direction:column;gap:12px;padding:16px;background:#fff;border-radius:0 8px 8px 0;opacity:0;transition:opacity .18s ease,transform .18s ease;pointer-events:none;box-shadow:0 12px 30px rgba(0,0,0,0.12);z-index:1200}
        .side-actions.show .side-panel{opacity:1;transform:translateX(0);pointer-events:auto}
        .side-actions .btn{padding:12px 18px;border-radius:8px;border:none;cursor:pointer;font-weight:600;font-size:0.95rem;display:inline-flex;align-items:center;gap:8px;text-decoration:none;box-shadow:0 4px 12px rgba(0,0,0,0.08);min-width:140px;justify-content:center;transition:all 150ms ease;white-space:nowrap}
        .side-actions .btn-back{background:#dc2626;color:#fff}
        .side-actions .btn-back:hover{background:#b91c1c;transform:translateY(-2px)}
        .side-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.18);backdrop-filter:blur(4px);opacity:0;pointer-events:none;transition:opacity .18s ease;z-index:1000}
        .side-actions.show ~ .side-overlay{opacity:1;pointer-events:auto}
        
        .form-section {
            padding: 32px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        .form-group {
            margin-bottom: 0;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: #000;
            margin-bottom: 6px;
        }
        
        .form-value {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 0.9rem;
            color: #333;
            word-wrap: break-word;
            white-space: pre-wrap;
            line-height: 1.4;
            min-height: 32px;
            display: flex;
            align-items: center;
        }
        
        .form-value.empty {
            color: #999;
            font-style: italic;
        }
        
        @media (max-width: 1024px) {
            .form-section {
                grid-template-columns: 1fr;
                padding: 24px;
            }
        }
        
        @media (max-width: 640px) {
            .page-wrapper {
                margin: 20px;
                border-radius: 0;
            }
            .view-header {
                flex-direction: column;
                padding: 16px;
            }
            .form-section {
                grid-template-columns: 1fr;
                padding: 16px;
            }
            .view-footer {
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="side-actions" aria-hidden="false" id="sideActions">
    <span class="side-indicator">›</span>
    <div class="side-panel" role="toolbar" aria-orientation="vertical" aria-expanded="false">
        <button class="btn btn-back" type="button" onclick="history.back()">← Back</button>
    </div>
</div>
<div class="side-overlay" aria-hidden="true" id="sideOverlay"></div>

<div class="page-wrapper">
    <div class="view-header">
        <div class="view-header-left">
            <h2>Record Details</h2>
        </div>
        <div class="view-header-right">
            <span class="timestamp-badge">
                <?php
                    try {
                        $appTZ = config('App')->appTimezone ?: 'UTC';
                        $dt = new DateTime($record['action_at'], new DateTimeZone('UTC'));
                        $dt->setTimezone(new DateTimeZone($appTZ));
                        echo 'Date: ' . $dt->format('M d, Y') . ' | Time: ' . $dt->format('g:i A');
                    } catch (Exception $e) {
                        echo esc($record['action_at']);
                    }
                ?>
            </span>
            <div class="header-info">
                <strong>Created By:</strong> <strong><?= esc($record['actor_full_name'] ? $record['actor_full_name'] : $record['actor']) ?></strong><br>
                <strong>Action:</strong> <strong><?= ucfirst(esc($record['action'])) ?></strong>
            </div>
        </div>
    </div>
    
    <div class="form-section">
        <div class="form-group">
            <label class="form-label">From Name</label>
            <div class="form-value <?= empty($record['from_name']) ? 'empty' : '' ?>">
                <?= !empty($record['from_name']) ? esc($record['from_name']) : 'No data' ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Date Received</label>
            <div class="form-value <?= empty($record['date_received']) ? 'empty' : '' ?>">
                <?= !empty($record['date_received']) ? date('M d, Y', strtotime($record['date_received'])) : 'No data' ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Origin</label>
            <div class="form-value <?= empty($record['origin']) ? 'empty' : '' ?>">
                <?= !empty($record['origin']) ? nl2br(esc($record['origin'])) : 'No data' ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Reference No</label>
            <div class="form-value <?= empty($record['reference_no']) ? 'empty' : '' ?>">
                <?= !empty($record['reference_no']) ? esc($record['reference_no']) : 'No data' ?>
            </div>
        </div>
        
        <div class="form-group full-width">
            <label class="form-label">Subject</label>
            <div class="form-value <?= empty($record['subject']) ? 'empty' : '' ?>" style="min-height: 60px;">
                <?= !empty($record['subject']) ? nl2br(esc($record['subject'])) : 'No data' ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Date Issued</label>
            <div class="form-value <?= empty($details['date_issued']) ? 'empty' : '' ?>">
                <?= !empty($details['date_issued']) ? date('M d, Y', strtotime($details['date_issued'])) : 'No data' ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label">Target Date</label>
            <div class="form-value <?= empty($details['target_date']) ? 'empty' : '' ?>">
                <?= !empty($details['target_date']) ? date('M d, Y', strtotime($details['target_date'])) : 'No data' ?>
            </div>
        </div>
        
        <div class="form-group full-width">
            <label class="form-label">Instructions</label>
            <div class="form-value <?= empty($details['instructions']) ? 'empty' : '' ?>" style="min-height: 60px;">
                <?= !empty($details['instructions']) ? nl2br(esc($details['instructions'])) : 'No data' ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var sideActions = document.getElementById('sideActions');
    var sideOverlay = document.getElementById('sideOverlay');
    var hoverTimeout;

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
});
</script>

</body>
</html>