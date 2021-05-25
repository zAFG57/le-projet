<?php include_once '../templates/nav.php'; ?>

<?php $title = "My Profile"; $css = "profilepro.css";?>
<?php ob_start(); 
$json = 'pro';
require('../templates/lang.php');
?>


    <header>
        <?= $nav ?>
    </header>

    <div class="main">
        <div class="profil" onclick="window.location +='&action=1' ">
            <h1><?=  $parsed_lang->{'gauche_titre'}?></h1>
            <p><?=  $parsed_lang->{'gauche'}?></p>
        </div>

        <div class="travail" onclick="window.location +='&action=2' ">
            <h1><?=  $parsed_lang->{'droit_titre'}?></h1>
            <p><?=  $parsed_lang->{'droit'}?></p>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>