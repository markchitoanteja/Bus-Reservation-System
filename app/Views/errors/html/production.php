<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <link rel="shortcut icon" href="<?= base_url( 'favicon.ico' ) ?>" type="image/x-icon" />

    <title><?= lang( 'Errors.whoops' ) ?></title>

    <style>
        <?= preg_replace( '#[\r\n\t ]+#', ' ', file_get_contents( __DIR__ . DIRECTORY_SEPARATOR . 'debug.css' ) ) ?>
    </style>
</head>

<body>

    <div class="container text-center">

        <h1 class="headline"><?= lang( 'Errors.whoops' ) ?></h1>

        <p class="lead"><?= lang( 'Errors.weHitASnag' ) ?></p>

    </div>

</body>

</html>