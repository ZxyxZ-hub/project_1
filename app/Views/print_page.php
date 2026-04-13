<style>
@media print {
    @page {
        size: 8.5in 13in;
        margin: 20px;
    }
}
body {
    font-family: Arial;
}
.box {
    border: 1px solid black;
    padding: 10px;
}
</style>

<h3 style="text-align:center;">REAL ESTATE FORM</h3>

<div class="box">
    <p><b>From:</b> <?= $form['from_name'] ?></p>
    <p><b>Date Received:</b> <?= $form['date_received'] ?></p>
    <p><b>Origin:</b> <?= $form['origin'] ?></p>
    <p><b>Reference No:</b> <?= $form['reference_no'] ?></p>

    <p><b>Subject:</b><br><?= $form['subject'] ?></p>

    <p><b>Instructions:</b><br><?= $form['instructions'] ?></p>
</div>

<br>
<div style="display:flex;gap:12px;align-items:center;">
    <button class="btn-back" type="button" onclick="history.back()">Back</button>
    <button onclick="window.print()">Print</button>
</div>

<style>
    .btn-back{background:#fff;border:1px solid #000;padding:6px 10px;border-radius:6px;cursor:pointer;font-weight:700}
    @media print{.btn-back{display:none}}
</style>