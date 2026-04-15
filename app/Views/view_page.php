<style>
/* Container */
.db-view{
	font-family: Arial, Helvetica, sans-serif;
	max-width:900px;
	margin:20px auto;
	background:#fff;
	padding:12px;
	border:2px solid #000;
	box-sizing:border-box;
}

.db-view header{
	display:flex;
	justify-content:space-between;
	align-items:center;
	gap:12px;
	margin-bottom:12px;
}

/* Grid layout: 2 columns. We'll explicitly place items so fields line up as requested. */
.record{
	display:grid;
	grid-template-columns: 1fr 2fr 1fr;
	gap:8px;
}

/* Make sure grid children can shrink so long words wrap instead of overflowing into adjacent cells */
.record > p{ min-width:0; }

/* From row (above the grid) */
.from-row{ margin-bottom:8px; }
.from-row .from-field{
	padding:8px;
	border:1px solid #000;
	min-height:40px;
	box-sizing:border-box;
}

.from-row .from-field::before{ content: "From: "; font-weight:bold; margin-right:8px; }

/* Field boxes */
.db-view p{
	margin:0;
	padding:10px;
	border:1px solid #000;
	background:#fff;
	box-sizing:border-box;
	word-wrap :break-word;
	overflow-wrap:break-word;
	word-break:break-word;
	hyphens:auto;
	min-height:40px;
}

/* Label prefix styling (keeps label separate from value and allows wrapping) */
.db-view p::before{
	font-weight:bold;
	margin-right:8px;
	display:inline-block;
}

/* Labels mapping (match DOM order) */
.db-view p.date-received::before{ content: "Date Received: "; }
.db-view p.origin::before{ content: "Origin/Source: "; }
.db-view p.reference::before{ content: "Reference No: "; }
.db-view p.subject::before{ content: "Subject: "; }
.db-view p.date-issued::before{ content: "Date Issued: "; }
.db-view p.instructions::before{ content: "Instructions/Remarks: "; }
.db-view p.target-date::before{ content: "Target Date: "; }

/* Layout placement using the new 3-column grid:
	Top row: Date Received (col1) | Origin (col2) | Reference (col3)
	Subject: full width
	Date Issued: placed in right column (col3)
	Instructions: left two columns (col1-col2) | Target Date: col3
*/
.db-view p.date-received{ grid-column: 1 / 2; text-align:center; }
.db-view p.origin{ grid-column: 2 / 3; text-align:center; }
.db-view p.reference{ grid-column: 3 / 4; text-align:center; }
.db-view p.subject{ grid-column: 1 / -1; min-height:140px; }
.db-view p.date-issued{ grid-column: 3 / 4; min-height:40px; }
.db-view p.instructions{ grid-column: 1 / 3; min-height:120px; }
.db-view p.target-date{ grid-column: 3 / 4; min-height:120px; }

/* Center the label text for top-row boxes */
.db-view p.date-received::before,
.db-view p.origin::before,
.db-view p.reference::before{ display:block; text-align:center; }

/* Make values wrap and center where appropriate */
.db-view p.date-received, .db-view p.origin, .db-view p.reference{ display:flex; align-items:center; justify-content:center; text-align:center; }

/* Buttons */
.btn-print{
	background: linear-gradient(90deg,#0ea5e9,#6366f1);
	color:#fff;
	padding:10px 20px;
	border:none;
	font-size:14px;
	cursor:pointer;
	border-radius:6px;
	text-decoration:none;
	display:inline-block;
}

.btn-close{
	background:#e11d48; /* red */
	color:#fff;
	border:none;
	padding:8px 12px;
	cursor:pointer;
	border-radius:6px;
	font-weight:700;
}

.btn-print:hover, .btn-close:hover{ transform:translateY(-2px); }

</style>
<style>
	.actions{ text-align:center; margin-top:14px; }
</style>

<div class="db-view">
	<header>
		<div style="display:flex;align-items:center;gap:8px;">
			<button class="btn-close" type="button" onclick="history.back()">Close</button>
		</div>
		<h2>Review</h2>
		<div class="meta">Record ID: <?= $form['id'] ?></div>
	</header>

	<div class="from-row">
		<p class="from-field"><?= $form['from_name'] ?></p>
	</div>

	<div class="record">
		<p class="date-received"><?= $form['date_received'] ?></p>
		<p class="origin"><?= $form['origin'] ?></p>
		<p class="reference"><?= $form['reference_no'] ?></p>

		<p class="subject"><?= $form['subject'] ?></p>

		<p class="date-issued"><?= isset($form['date_issued']) ? $form['date_issued'] : '' ?></p>

		<p class="instructions"><?= $form['instructions'] ?></p>
		<p class="target-date"><?= isset($form['target_date']) ? $form['target_date'] : '' ?></p>
	</div>

	<div class="actions">
		<?php $baseForPrint = preg_replace('#/view/[^/]+$#', '', rtrim(current_url(), '/')); ?>
		<a class="btn-print" href="<?= $baseForPrint . '/print/' . $form['id'] ?>">Print</a>
	</div>
</div>