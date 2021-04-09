<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='réparation'");
}
?>
 
<?php $title = ""; $css = "réparation.css"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <!-- cette feuille css est la juste pour la forme de loupe dans le button ... -->
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    


    <div class="content">
        <div class="search">
              <input type="text" class="search__input" aria-label="search" placeholder="produit à réparer">
              <button class="search__submit" aria-label="submit search"><i class="fas fa-search"></i></button>
        </div>
    </div>

    <section class="maindiv">
        <div class="hover"> 
            <div onclick="window.location.href='../index?location=homePage';" class="électroménager">  <h1>électroménager</h1> <img class="img" src="../assets/électroménager.svg"/> </div>
            <div onclick="window.location.href='../index?location=homePage';" class="ordinateur">      <h1>ordinateur    </h1> <img class="img" src="../assets/ordinateur2.svg"/>    </div>
            <div onclick="window.location.href='../index?location=homePage';" class="téléphone">       <h1>téléphone     </h1> <img class="img" src="../assets/télephone.svg"/>      </div>
        </div>
    </section>








<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
