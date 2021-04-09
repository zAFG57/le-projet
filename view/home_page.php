<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='homePage'");
}
?>

<?php $title = "Company name"; $css = "home.css"?>
<?php ob_start(); ?>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <!-- cette feuille css est la juste pour la forme de loup dans le button ... -->


    <header>
        <?=$nav?> 
    </header>
   <h1 class="presentation">Avec Mesréparations.com, trouvez un </br> réparateur <span>proche de chez vous.</span></h1>



        <div class="content">
            <div class="search">
              <input type="text" class="search__input" aria-label="search" placeholder="produit à réparer">
              <button class="search__submit" aria-label="submit search"><i class="fas fa-search"></i></button>
            </div>
        </div>







<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
