<style>
/* Container */
.db-view{
	font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
	max-width:900px;
	margin:20px auto;
	background:#fff;
	padding:18px;
	border:3px solid #666;
	box-sizing:border-box;
}

.db-view header{
	display:flex;
	justify-content:space-between;
	align-items:center;
	gap:12px;
	margin-bottom:18px;
}

.db-view header h2{
	font-weight:700;
	font-size:1.5rem;
	margin:0;
}

/* Grid layout: 2 columns. We'll explicitly place items so fields line up as requested. */
.record{
	display:grid;
	grid-template-columns: 1fr 2fr 1fr;
	gap:12px;
}

/* Make sure grid children can shrink so long words wrap instead of overflowing into adjacent cells */
.record > p{ min-width:0; }

/* From row (above the grid) */
.from-row{ margin-bottom:12px; }
.from-row .from-field{
	padding:12px;
	border:3px solid #666;
	min-height:40px;
	box-sizing:border-box;
	font-weight:700;
}

.from-row .from-field::before{ content: "From: "; font-weight:700; margin-right:8px; }

/* Field boxes */
.db-view p{
	margin:0;
	padding:12px;
	border:3px solid #666;
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
	font-weight:700;
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
	background: #21aef5ff;
	color:#000;
	padding:12px 24px;
	border:none;
	font-size:14px;
	font-weight:700;
	cursor:pointer;
	border-radius:8px;
	text-decoration:none;
	display:inline-flex;
	align-items:center;
	gap:8px;
	box-shadow: 0 8px 20px rgba(251, 191, 36, 0.18);
	transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
}

.btn-print:hover{
	transform: translateY(-4px) scale(1.02);
	box-shadow: 0 14px 34px rgba(251, 191, 36, 0.22);
}

.btn-close{
	background:#f70b0b;
	color:#fff;
	padding:12px 24px;
	border:none;
	cursor:pointer;
	border-radius:8px;
	font-weight:700;
	font-size:14px;
	box-shadow: 0 8px 20px rgba(247, 11, 11, 0.18);
	transition: transform 180ms ease, box-shadow 180ms ease, filter 180ms ease;
}

.btn-close:hover{
	transform: translateY(-4px) scale(1.02);
	box-shadow: 0 14px 34px rgba(247, 11, 11, 0.22);
}

</style>
<style>
	.actions{ text-align:center; margin-top:18px; }
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