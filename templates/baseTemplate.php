<?php 
    use \Model\Csrf;
    include_once "../model/csrfConfig.php";    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf_token" content="<?= Csrf::createToken()?>">
        <title><?= $title ?></title>
        <link href="../public/css/<?= $css ?>" rel="stylesheet" />
        <link href="../public/css/nav2.css" rel="stylesheet" />
        <link rel="icon" href="../assets/Sans_titre-8.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    </head>
        
    <body>
        <?= $content ?>
    </body>
    
</html>
