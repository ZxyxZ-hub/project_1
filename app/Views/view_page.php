<style>
	.db-view{font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;max-width:900px;margin:22px auto;background:#f7fafc;padding:20px;border-radius:12px;border:1px solid #e6eef6;box-shadow:0 6px 20px rgba(13,38,59,0.06)}
	.db-view header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
	.db-view h2{margin:0;color:#0f172a;font-size:20px;letter-spacing:0.2px}
	.db-view .meta{color:#64748b;font-size:13px}
	.record{display:grid;grid-template-columns:repeat(1,1fr);gap:10px}
	.db-view p{background:#ffffff;padding:12px 14px;border-radius:10px;border:1px solid #e6eef6;margin:0;display:flex;align-items:flex-start;gap:12px}
	.db-view p::before{font-weight:600;color:#334155;min-width:130px}
	.db-view p:nth-of-type(1)::before{content:"From"}
	.db-view p:nth-of-type(2)::before{content:"Date Received"}
	.db-view p:nth-of-type(3)::before{content:"Origin"}
	.db-view p:nth-of-type(4)::before{content:"Reference No"}
	.db-view p:nth-of-type(5)::before{content:"Subject"}
	.db-view p:nth-of-type(6)::before{content:"Instructions"}
	.db-view .instructions{white-space:pre-wrap;color:#0b1220}
	.actions{display:flex;justify-content:flex-end;margin-top:14px}
	.btn-print{background:linear-gradient(90deg,#0ea5e9,#6366f1);color:#fff;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:600;border:none;box-shadow:0 8px 24px rgba(99,102,241,0.18)}
	.btn-print:hover{transform:translateY(-2px)}
	@media(min-width:720px){.record{grid-template-columns:repeat(2,1fr)} .db-view p.full{grid-column:1/-1}}
</style>

<div class="db-view">
	<header>
		<div style="display:flex;align-items:center;gap:8px;">
			<button class="btn-close" type="button" onclick="history.back()">Close</button>
		</div>
		<h2>Review</h2>
		<div class="meta">Record ID: <?= $form['id'] ?></div>
	</header>

	<div class="record">
		<p><?= $form['from_name'] ?></p>
		<p><?= $form['date_received'] ?></p>
		<p><?= $form['origin'] ?></p>
		<p><?= $form['reference_no'] ?></p>
		<p><?= $form['subject'] ?></p>
		<p class="full instructions"><?= $form['instructions'] ?></p>
	</div>

	<div class="actions">
		<?php $baseForPrint = preg_replace('#/view/[^/]+$#', '', rtrim(current_url(), '/')); ?>
		<a class="btn-print" href="<?= $baseForPrint . '/print/' . $form['id'] ?>">Print</a>
	</div>
</div>

<style>
    .btn-back{background:#fff;border:1px solid #e6eef6;padding:8px 10px;border-radius:8px;cursor:pointer;font-weight:700;margin-right:12px}
    .btn-back:hover{transform:translateY(-2px)}
</style>
<style>
	.btn-close{background:#fff;border:1px solid #e6eef6;padding:8px 10px;border-radius:8px;cursor:pointer;font-weight:700;color:#0b1220}
	.btn-close:hover{transform:translateY(-2px)}
</style>