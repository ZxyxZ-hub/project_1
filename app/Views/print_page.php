<style>
@media print {
    @page {
        size: 8.5in 13in;
        margin: 20px;
    }
    
    .print-controls {
        display: none !important;
    }
}

/* Container */
.db-view {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    max-width: 900px;
    margin: 20px auto;
    background: #fff;
    padding: 18px;
    border: 3px solid #666;
    box-sizing: border-box;
}

.db-view .top-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}

/* Header section */
.db-view .header-section {
    text-align: center;
    margin-bottom: 20px;
    border-bottom: 2px solid #666;
    padding-bottom: 12px;
}

.db-view .header-section .org-name {
    font-weight: 700;
    font-size: 1.1rem;
    margin: 0 0 4px 0;
}

.db-view .header-section .office-name {
    font-size: 0.95rem;
    margin: 0 0 8px 0;
}

.db-view .header-section .director-info {
    font-size: 0.9rem;
    margin: 0;
}

/* Info row (Date Received, Origin, Reference) */
.info-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}

.info-row p {
    margin: 0;
    padding: 12px;
    border: 2px solid #666;
    background: #fff;
    box-sizing: border-box;
    font-size: 0.9rem;
    min-height: 50px;
    display: flex;
    align-items: center;
}

.info-row p::before {
    font-weight: 700;
    display: block;
    width: 100%;
}

.info-row .date-received::before { content: "Date Received:"; }
.info-row .origin::before { content: "Origin/Source:"; }
.info-row .reference::before { content: "Reference No.:"; }

/* From row */
.from-row { margin-bottom: 12px; }
.from-row .from-field {
    padding: 12px;
    border: 2px solid #666;
    min-height: 40px;
    box-sizing: border-box;
    font-weight: 700;
}

.from-row .from-field::before { content: "From: "; font-weight: 700; margin-right: 8px; }

/* Field boxes */
.db-view p {
    margin: 0;
    padding: 12px;
    border: 2px solid #666;
    background: #fff;
    box-sizing: border-box;
    word-wrap: break-word;
    overflow-wrap: break-word;
    word-break: break-word;
    hyphens: auto;
    min-height: 40px;
}

/* Label prefix styling */
.db-view p::before {
    font-weight: 700;
    margin-right: 8px;
    display: inline-block;
}

/* Subject field - full width */
.subject-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 12px;
}

.db-view p.subject {
    grid-column: 1 / -1;
    min-height: 100px;
    display: block;
}

.db-view p.subject::before { content: "Subject: "; }

.db-view p.date-issued {
    min-height: 50px;
}

.db-view p.date-issued::before { content: "Date Issued:"; }

/* Bottom section - Instructions and Target Date */
.bottom-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.db-view p.instructions {
    min-height: 120px;
    display: block;
}

.db-view p.instructions::before { content: "Instructions/Remarks: "; display: block; margin-bottom: 8px; }

.db-view p.target-date {
    min-height: 120px;
    display: block;
}

.db-view p.target-date::before { content: "Target Date: "; display: block; margin-bottom: 8px; }

/* Buttons */
.btn-back {
    background: #f70b0b;
    color: #fff;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
    border-radius: 6px;
    font-weight: 700;
    font-size: 14px;
    box-shadow: 0 4px 12px rgba(247, 11, 11, 0.18);
    transition: transform 180ms ease;
}

.btn-back:hover {
    transform: translateY(-2px);
}

.btn-print-btn {
    background: #21aef5ff;
    color: #000;
    padding: 8px 12px;
    border: none;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(33, 174, 245, 0.18);
    transition: transform 180ms ease;
}

.btn-print-btn:hover {
    transform: translateY(-2px);
}
</style>

<div class="db-view">
    <div class="top-controls print-controls">
        <button class="btn-back" type="button" onclick="history.back()">← Back</button>
        <button class="btn-print-btn" onclick="window.print()">Print</button>
    </div>

    <div class="header-section">
        <p class="org-name">Professional Regulation Commission</p>
        <p class="office-name">Davao Regional Office</p>
        <p class="director-info">Director: Raquel R. Abanites</p>
    </div>

    <div class="info-row">
        <p class="date-received"><?= $form['date_received'] ?></p>
        <p class="origin"><?= $form['origin'] ?></p>
        <p class="reference"><?= $form['reference_no'] ?></p>
    </div>

    <div class="from-row">
        <p class="from-field"><?= $form['from_name'] ?></p>
    </div>

    <div class="subject-section">
        <p class="subject"><?= $form['subject'] ?></p>
        <p class="date-issued"><?= isset($form['date_issued']) ? $form['date_issued'] : '' ?></p>
    </div>

    <div class="bottom-section">
        <p class="instructions"><?= $form['instructions'] ?></p>
        <p class="target-date"><?= isset($form['target_date']) ? $form['target_date'] : '' ?></p>
    </div>
</div>