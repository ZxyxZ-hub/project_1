<style>
html,body{font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif;margin:0;padding:0}
.body-with-side-actions{position:relative;padding-bottom:0}
body{position:relative;padding-bottom:0}
/* Floating side actions (hover to reveal) */
.side-actions{position:fixed;left:0;top:50%;transform:translateY(-50%);z-index:1100;display:flex;align-items:center}
.side-actions .side-tab{width:36px;height:56px;display:flex;align-items:center;justify-content:center;background:#1a1a1a;color:#fff;border-top-right-radius:6px;border-bottom-right-radius:6px;cursor:pointer;font-weight:700;box-shadow:0 6px 18px rgba(0,0,0,0.08)}
.side-actions .side-panel{position:relative;left:44px;display:flex;flex-direction:column;gap:26px;padding:14px 16px;background:#fff;border-radius:8px;opacity:0;transform:translateX(-8px);transition:opacity .18s ease,transform .18s ease;pointer-events:none;box-shadow:0 12px 30px rgba(0,0,0,0.12)}
.side-actions:hover .side-panel,.side-actions:focus-within .side-panel{opacity:1;transform:translateX(0);pointer-events:auto}
.side-actions .btn{padding:14px 20px;border-radius:8px;border:none;cursor:pointer;font-weight:700;font-size:0.98rem;display:inline-flex;align-items:center;gap:8px;text-decoration:none;box-shadow:0 8px 20px rgba(0,0,0,0.08);min-width:150px;justify-content:center}
.side-actions .btn-back{background:#dc2626;color:#fff}
.side-actions .btn-back:hover{background:#b91c1c}
.side-actions .btn-print{background:#21aef5;color:#000}
.side-actions .btn-print:hover{background:#1a8dd0}

/* overlay that blurs & darkens main content when panel open */
.side-overlay{position:fixed;inset:0;background:rgba(0,0,0,0.18);backdrop-filter:blur(4px);opacity:0;pointer-events:none;transition:opacity .18s ease;z-index:1000}
.side-actions:hover ~ .side-overlay,.side-actions:focus-within ~ .side-overlay{opacity:1;pointer-events:auto}
.form-wrapper{max-width:1200px;margin:18px auto;background:#fff;position:relative}

/* Modular Containers */
.form-container{margin-bottom:0;background-color:#e0f2ff}
/* Experiment: remove all gridlines across containers */
.no-gridlines-experiment{display:block}
.container-1,
.container-2,
.container-3,
.container-4,
.container-5,
.field-label,
.field-data,
.subject-label,
.subject-data,
.date-issued-label,
.date-issued-data,
.instructions-part,
.instructions-label,
.target-date-label,
.target-date-data,
.logo-section,
.header-section {
	border: none !important;
	border-right: none !important;
	border-left: none !important;
	border-bottom: none !important;
}
/* Use a fixed narrow left column so elements align vertically across containers */
.container-1{display:grid;grid-template-columns:170px 1fr 170px 1fr 170px 1fr;gap:0;padding:0;align-items:stretch;min-height:120px;border:0.5px solid #1a1a1a}
.logo-section{text-align:center;flex-shrink:0;background-color:#e0f2ff;display:flex;flex-direction:column;align-items:center;justify-content:center;border-right:0.5px solid #1a1a1a;margin:0;padding:0;grid-column:1/2}
.logo-section img{width:65px;height:65px;margin:8px;object-fit:contain}
.logo-section .director-name{font-size:12px;font-weight:700;line-height:1.2;white-space:normal;padding:0 8px 8px 8px}
.header-section{flex:1;display:flex;flex-direction:column;justify-content:flex-start;text-align:left;padding:8px 0 0 12px;grid-column:2/7;border-left:0.5px solid #1a1a1a;border-right:0.5px solid #1a1a1a}
.header-section .org-name{font-weight:700;font-size:14px;margin:0 0 2px 0;text-align:center}
.header-section .office-name{font-size:15px;font-weight:700;margin:8px 0 0 0;text-align:center}

.container-2{display:grid;grid-template-columns:170px 1fr 170px 1fr 170px 1fr;border:1px solid #1a1a1a;gap:0}
.field-group{padding:0;display:contents}
.field-data:nth-child(2n) {
	border-right:1px solid #1a1a1a
}
.field-data:last-of-type {
	border-right:none
}
.field-label{font-weight:700;font-size:13px;margin:0;text-align:center;border-bottom:1px solid #1a1a1a;border-right:1px solid #1a1a1a;border-left:1px solid #1a1a1a;padding:8px;display:flex;align-items:center;justify-content:center;background-color:#e0f2ff;white-space:nowrap;min-height:80px}
.field-data{background:#e0f2ff;padding:8px;font-size:13px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:center;display:flex;align-items:center;justify-content:center;border-bottom:1px solid #1a1a1a;border-left:1px solid #1a1a1a;min-height:80px}

.container-3{border:1px solid #1a1a1a;padding:0;display:grid;grid-template-columns:170px 1fr;gap:0;min-height:220px}
.subject-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-right:1px solid #1a1a1a;border-bottom:1px solid #1a1a1a;padding:8px;display:flex;align-items:center;justify-content:center;background-color:#e0f2ff}
.subject-label:empty{border:none}
.subject-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:left;display:flex;align-items:center;justify-content:flex-start;border-bottom:1px solid #1a1a1a}

.container-4{display:grid;grid-template-columns:170px 1fr 170px 1fr 170px 1fr;border:1px solid #1a1a1a;gap:0}
.date-issued-group{padding:0;display:contents}
.date-issued-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-bottom:1px solid #1a1a1a;border-right:1px solid #1a1a1a;padding:8px;display:flex;align-items:center;justify-content:center;background-color:#e0f2ff;min-height:100px}
.date-issued-label:empty{border-bottom:1px solid #1a1a1a;border-right:1px solid #1a1a1a}
.date-issued-data{background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:center;display:flex;align-items:center;justify-content:center;border-bottom:1px solid #1a1a1a;border-right:1px solid #1a1a1a;min-height:100px}
.date-issued-group:nth-child(1) .date-issued-data{border-right:none}
.date-issued-group:nth-child(2) .date-issued-label{border-right:none}
.date-issued-group:nth-child(3) .date-issued-data{border-right:none}

/* Container 5: Instructions/Remarks + Target Date */
.container-5{border:1px solid #1a1a1a;display:grid;grid-template-columns:2fr 1fr;gap:0}
.instructions-part{padding:0;display:flex;flex-direction:column;min-height:200px;border-right:1px solid #1a1a1a}
.instructions-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-bottom:1px solid #1a1a1a;padding:8px}
.instructions-label:empty{border:none}
.instructions-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:center;display:flex;align-items:center;justify-content:center}
.target-date-part{padding:0;display:flex;flex-direction:column;min-height:200px}
.target-date-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-bottom:1px solid #1a1a1a;border-left:1px solid #1a1a1a;padding:8px}
.target-date-label:empty{border:none}
.target-date-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;text-align:center;display:flex;align-items:center;justify-content:center;border-left:1px solid #1a1a1a}

/* Strong override: apply super-thin gridlines across containers */
.container-1,
.container-2,
.container-3,
.container-4,
.container-5,
.field-label,
.field-data,
.subject-label,
.subject-data,
.date-issued-label,
.date-issued-data,
.instructions-part,
.instructions-label,
.target-date-label,
.target-date-data,
.logo-section,
.header-section {
	border: 0.3px solid #1a1a1a !important;
	border-right: 0.3px solid #1a1a1a !important;
	border-left: 0.3px solid #1a1a1a !important;
	border-bottom: 0.3px solid #1a1a1a !important;
}

/* Targeted: remove vertical grid lines #3 and #4 on the Date Issued row */
/* Counting vertical lines left->right where each date-issued group spans two columns */
.container-4 .date-issued-group:nth-child(1) .date-issued-data,
.container-4 .date-issued-group:nth-child(2) .date-issued-label,
.container-4 .date-issued-group:nth-child(2) .date-issued-data {
	border-right: none !important;
	border-left: none !important; /* also clear any left borders that may form the inner lines */
}

/* Ensure the middle group's label/data don't show inner separators */
.container-4 .date-issued-group:nth-child(2) .date-issued-label,
.container-4 .date-issued-group:nth-child(2) .date-issued-data {
	border-left: none !important;
	border-right: none !important;
}

/* Make vertical gridlines #2 and #5 darker in the 6-column containers */
/* Ensure both adjacent cells show a solid dark border so the line is consistent */
.container-1 > *:nth-child(2),
.container-2 > *:nth-child(2),
.container-4 > *:nth-child(2) {
	border-right: 1px solid #1a1a1a !important;
}
.container-1 > *:nth-child(3),
.container-2 > *:nth-child(3),
.container-4 > *:nth-child(3) {
	border-left: 1px solid #1a1a1a !important;
}
.container-1 > *:nth-child(5),
.container-2 > *:nth-child(5),
.container-4 > *:nth-child(5) {
	border-right: 1px solid #1a1a1a !important;
}
.container-1 > *:nth-child(6),
.container-2 > *:nth-child(6),
.container-4 > *:nth-child(6) {
	border-left: 1px solid #1a1a1a !important;
}

@media print{.side-actions{display:none}body{margin:0;padding:0;padding-top:0}.form-wrapper{margin:0;max-width:100%}}
</style>

<?php $baseForPrint = preg_replace('#/view/[^/]+$#', '', rtrim(current_url(), '/')); ?>
<div class="side-actions" aria-hidden="false">
	<button class="side-tab" aria-label="Open actions" tabindex="0">▸</button>
	<div class="side-panel" role="toolbar" aria-orientation="vertical" aria-expanded="false">
		<a class="btn btn-print" href="<?= $baseForPrint . '/print/' . $form['id'] ?>" tabindex="0">Print</a>
		<button class="btn btn-back" onclick="window.history.back()" tabindex="0">Back</button>
	</div>
</div>
<div class="side-overlay" aria-hidden="true"></div>

<div class="form-wrapper">
	<!-- Container 1: Logo + Director + PRC Header -->
	<div class="form-container container-1">
		<div class="logo-section">
			<img src="<?= base_url('images/logo.png') ?>" alt="PRC Logo">
			<div class="director-name">From: Director Raquel A. Abrantes</div>
		</div>
		<div class="header-section">
			<p class="org-name">Professional Regulation Commission</p>
			<p class="office-name">Davao Regional Office</p>
		</div>
		</div>

	<!-- Container 2: Date Received | Origin/Source | Reference No. -->
	<div class="form-container container-2">
		<div class="field-group">
			<span class="field-label">Date Received</span>
			<div class="field-data"><?= $form['date_received'] ? date('d-M-Y', strtotime($form['date_received'])) : '' ?></div>
		</div>
		<div class="field-group">
			<span class="field-label">Origin/Source</span>
			<div class="field-data"><?= nl2br(htmlspecialchars($form['origin'] ?? '')) ?></div>
		</div>
		<div class="field-group">
			<span class="field-label">Reference No.</span>
			<div class="field-data"><?= nl2br(htmlspecialchars($form['reference_no'] ?? '')) ?></div>
		</div>
	</div>

	<!-- Container 3: Subject (Full Width) -->
	<div class="form-container container-3">
		<span class="subject-label">Subject</span>
		<div class="subject-data"><?= nl2br(htmlspecialchars($form['subject'] ?? '')) ?></div>
	</div>

	<!-- Container 4: Date Issued (3 columns) -->
	<div class="form-container container-4">
		<div class="date-issued-group">
			<span class="date-issued-label"></span>
			<div class="date-issued-data"></div>
		</div>
		<div class="date-issued-group">
			<span class="date-issued-label"></span>
			<div class="date-issued-data"></div>
		</div>
		<div class="date-issued-group">
			<span class="date-issued-label">Date Issued</span>
			<div class="date-issued-data"><?= $form['date_issued'] ? date('d-M-Y', strtotime($form['date_issued'])) : '' ?></div>
		</div>
	</div>

	<!-- Container 5: Instructions/Remarks + Target Date -->
	<div class="form-container container-5">
		<div class="instructions-part">
			<span class="instructions-label">Instructions/Remarks</span>
			<div class="instructions-data"><?= nl2br(htmlspecialchars($form['instructions'] ?? '')) ?></div>
		</div>
		<div class="target-date-part">
			<span class="target-date-label">Target Date</span>
			<div class="target-date-data"><?= $form['target_date'] ? date('d-M-Y', strtotime($form['target_date'])) : '' ?></div>
		</div>
	</div>
</div>
<script>
// Toggle aria-expanded on the toolbar for accessibility when panel opens
(function(){
	var side = document.querySelector('.side-actions');
	if(!side) return;
	var panel = side.querySelector('.side-panel');
	function open(){ panel && panel.setAttribute('aria-expanded','true'); }
	function close(){ panel && panel.setAttribute('aria-expanded','false'); }
	side.addEventListener('mouseenter', open);
	side.addEventListener('mouseleave', close);
	side.addEventListener('focusin', open);
	side.addEventListener('focusout', function(e){
		// if focus moves outside the side-actions, close
		if(!side.contains(e.relatedTarget)) close();
	});
})();
</script>