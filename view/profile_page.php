<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='profile'");
}
?>

<?php $title = "My Profile"; $css = "profile.css"?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    
    <div class="main">

        <div class="haut">
            <div class="photo"></div>
            <h1> $nom du useur </h1>
        </div>

        <div class="bas">

            <div class="email"><h1>$email du user</h1></div>
            <div class="mdp"><h1>des petit point en mode mdp secret</h1></div>

            <div class="changer">
                <div class="changeremail"><h1>changer de mdp</h1></div>
                <div class="changermdp"><h1>changer l'email</h1></div>
            </div>

        </div>
    </div>







<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
