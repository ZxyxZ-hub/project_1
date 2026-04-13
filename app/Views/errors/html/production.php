<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= lang('Errors.whoops') ?></title>

    <style>
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>

    <div class="container text-center">

        <h1 class="headline"><?= lang('Errors.whoops') ?></h1>

        <p class="lead"><?= lang('Errors.weHitASnag') ?></p>

        <p><button class="btn-back" type="button" onclick="history.back()">Back</button></p>

    </div>

    <style>
        .btn-back{padding:8px 12px;border-radius:6px;border:1px solid #e6eef6;background:#fff;cursor:pointer;font-weight:700}
    </style>

</body>

</html>
