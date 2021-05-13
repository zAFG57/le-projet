<?php require_once("../controller/csrfConfig.php")?>
<!DOCTYPE html>
<html>
    <head>
        <script data-ad-client="ca-pub-3418139482018352" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf_token" content="<?= ControllerCsrf::createCsrfToken()?>">
        <title><?= $title ?></title>
        <link href="../public/css/<?= $css ?>" rel="stylesheet" />
        <link href="../public/css/nav2.css" rel="stylesheet" />
        <link rel="icon" href="../assets/Sans_titre-8.png">
    </head>
        
    <body>
        <?= $content ?>
    </body>
</html>
