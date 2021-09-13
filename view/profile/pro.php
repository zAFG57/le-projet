<?php 
    use Model\Lang;

    include_once __DIR__ . '/../../templates/nav.php';
    include_once __DIR__ . '/../../model/lang.php';

    $title = "My Profile"; $css = "profilepro.css";

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    ob_start();
?>


    <header>
        <?= $nav ?>
    </header>

    <div class="main">
        <div class="profil" onclick="window.location +='&action=1' ">
            <h1><?=  $lang->getFile()['pro']['gauche_titre']?></h1>
            <p><?=  $lang->getFile()['pro']['gauche']?></p>
        </div>

        <div class="travail" onclick="window.location +='&action=2' ">
            <h1><?=  $lang->getFile()['pro']['droit_titre']?></h1>
            <p><?=  $lang->getFile()['pro']['droit']?></p>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>