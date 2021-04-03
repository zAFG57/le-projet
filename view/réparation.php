<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='réparation'");
}
?>

<?php $title = ""; $css = "réparation.css"?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    


    <section class="maindiv">


        <div class="hover"> 


            <div onclick="window.location.href='../index?location=recherche';" class="électroménager">  <h1>électroménager</h1> <img class="img" src="../assets/électroménager.svg"/> </div>


            <div onclick="window.location.href='../index?location=recherche';" class="ordinateur">      <h1>ordinateur    </h1> <img class="img" src="../assets/ordinateur2.svg"/>    </div>


            <div onclick="window.location.href='../index?location=recherche';" class="téléphone">       <h1>téléphone     </h1> <img class="img" src="../assets/télephone.svg"/>      </div>
            
        </div>

    </section>








<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
