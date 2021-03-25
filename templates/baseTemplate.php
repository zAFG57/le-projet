<?php require_once("../model/util.php")?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf_token" content="<?= createToken()?>">
        <title><?= $title ?></title>
        <link href="../public/css/<?= $css ?>" rel="stylesheet" />
        <link href="../public/css/nav2.css" rel="stylesheet" />
        <link rel="icon" href="../assets/Sans_titre-8.png">
    </head>
        
    <body>
        <?= $content ?>
    </body>
</html>
