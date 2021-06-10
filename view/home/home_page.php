
<?php include_once '../templates/nav.php';
$json = 'home';
require('../templates/lang.php');
 ?>

<?php 
// if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
//     header("Location: ../index.php?location='réparation'");
// }
?>
 
<?php $title = "mesréparation.com"; $css = "home.css"?>

<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    <?php var_dump($_SERVER['SERVER_NAME']) // woula c trop bien ?>
    <div class="content">
        <form id="search">
            <input type="text" class="search__input" placeholder="<?=  $parsed_lang->{'obj'}?>" name="search" required onkeydown="if(event.key === 'Enter'){event.preventDefault();searchf();}">
            <button type="button" class="search__submit" onclick="searchf();" value=""><i class="fas fa-search"></i></button>
        </form>
    </div>

    <section class="maindiv">
        <div class="hover"> 
            <div onclick="window.location.href='../view/home.php?query=electromenager&filter=domain';" class="électroménager">  <h1><?=  $parsed_lang->{'électroménager'}?></h1> <img class="img" src="../assets/électroménager.svg"/> </div>
            <div onclick="window.location.href='../view/home.php?query=ordinateur&filter=domain';" class="ordinateur">      <h1><?=  $parsed_lang->{'ordi'}?></h1> <img class="img" src="../assets/ordinateur2.svg"/>    </div>
            <div onclick="window.location.href='../view/home.php?query=telephone&filter=domain';" class="téléphone">       <h1><?=  $parsed_lang->{'tel'}?></h1> <img class="img" src="../assets/télephone.svg"/>      </div>
        </div>
    </section>
    
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>

