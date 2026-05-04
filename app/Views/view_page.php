<style>
html,body{font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif;margin:0;padding:0}
body{position:relative;padding-bottom:60px}
.btn-back-outer{position:fixed;bottom:12px;left:50%;transform:translateX(-85px);z-index:1000}
.btn-print-outer{position:fixed;bottom:12px;left:50%;transform:translateX(5px);z-index:1000}
.btn-back,.btn-print{padding:10px 18px;border-radius:6px;border:none;cursor:pointer;font-weight:700;font-size:14px;transition:all 150ms ease;display:inline-block;text-decoration:none}
.btn-back{background:#dc2626;color:#fff}
.btn-back:hover{background:#b91c1c;transform:translateY(-2px)}
.btn-print{background:#21aef5;color:#000}
.btn-print:hover{background:#1a8dd0;transform:translateY(-2px)}
.form-wrapper{max-width:920px;margin:18px auto;background:#fff;position:relative}

/* Modular Containers */
.form-container{margin-bottom:0;background-color:#e0f2ff}
.container-1{display:grid;grid-template-columns:1fr 2fr;gap:0;padding:0;align-items:stretch;min-height:120px;border:1px solid #000}
.logo-section{width:100%;text-align:center;flex-shrink:0;background-color:#e0f2ff;display:flex;flex-direction:column;align-items:center;justify-content:center;border-right:1px solid #000;margin:0;padding:0}
.logo-section img{width:65px;height:65px;margin:8px;object-fit:contain}
.logo-section .director-name{font-size:12px;font-weight:700;line-height:1.2;white-space:normal;padding:0 8px 8px 8px}
.header-section{flex:1;display:flex;flex-direction:column;justify-content:flex-start;text-align:left;padding:8px 0 0 12px}
.header-section .org-name{font-weight:700;font-size:14px;margin:0 0 2px 0;text-align:center}
.header-section .office-name{font-size:15px;font-weight:700;margin:8px 0 0 0;text-align:center}

/* Container 2: Date Received, Origin, Reference */
.container-2{display:grid;grid-template-columns:1fr 1fr 1fr;border:1px solid #000}
.field-group{border-right:1px solid #000;padding:0;display:flex;flex-direction:column;min-height:100px}
.field-group:last-child{border-right:none}
.field-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-bottom:1px solid #000;padding:8px;display:flex;align-items:center;justify-content:center;background-color:#e0f2ff}
.field-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:center;display:flex;align-items:center;justify-content:center}

/* Container 3: Subject (full width, large) */
.container-3{border:1px solid #000;padding:0;display:grid;grid-template-columns:1fr 2fr;gap:0;min-height:220px}
.subject-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-right:1px solid #000;border-bottom:1px solid #000;padding:8px;display:flex;align-items:center;justify-content:center;background-color:#e0f2ff}
.subject-label:empty{border:none}
.subject-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:left;display:flex;align-items:center;justify-content:flex-start;border-bottom:1px solid #000}

/* Container 4: Date Issued (3 columns like container 2) */
.container-4{display:grid;grid-template-columns:1fr 1fr 1fr;border:1px solid #000}
.date-issued-group{border-right:1px solid #000;padding:0;display:flex;flex-direction:column;min-height:100px}
.date-issued-group:last-child{border-right:none}
.date-issued-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-bottom:1px solid #000;padding:8px;display:flex;align-items:center;justify-content:center;background-color:#e0f2ff}
.date-issued-label:empty{border:none}
.date-issued-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:center;display:flex;align-items:center;justify-content:center}

/* Container 5: Instructions/Remarks + Target Date */
.container-5{border:1px solid #000;display:grid;grid-template-columns:2fr 1fr;gap:0}
.instructions-part{padding:0;border-right:1px solid #000;display:flex;flex-direction:column;min-height:200px}
.instructions-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-bottom:1px solid #000;padding:8px}
.instructions-label:empty{border:none}
.instructions-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;overflow-wrap:break-word;white-space:pre-wrap;text-align:center;display:flex;align-items:center;justify-content:center}
.target-date-part{padding:0;display:flex;flex-direction:column;min-height:200px}
.target-date-label{font-weight:700;font-size:14px;margin-bottom:0;text-align:center;border-bottom:1px solid #000;padding:8px}
.target-date-label:empty{border:none}
.target-date-data{flex:1;background:#e0f2ff;padding:8px;font-size:14px;word-wrap:break-word;text-align:center;display:flex;align-items:center;justify-content:center}

@media print{.btn-back-outer,.btn-print-outer{display:none}body{margin:0;padding:0;padding-top:0}.form-wrapper{margin:0;max-width:100%}}
</style>


<div class="btn-back-outer">
	<button class="btn-back" onclick="window.history.back()">Back</button>
</div>

<?php $baseForPrint = preg_replace('#/view/[^/]+$#', '', rtrim(current_url(), '/')); ?>
<div class="btn-print-outer">
	<a class="btn-print" href="<?= $baseForPrint . '/print/' . $form['id'] ?>">Print</a>
</div>

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