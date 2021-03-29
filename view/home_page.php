<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='homePage'");
}
?>

<?php $title = "Company name"; $css = "home.css"?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
   <h1 class="presentation">Avec Mesréparations.com, trouvez un </br> réparateur <span>proche de chez vous.</span></h1>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
