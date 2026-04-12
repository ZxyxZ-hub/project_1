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
<button onclick="window.print()">Print</button>