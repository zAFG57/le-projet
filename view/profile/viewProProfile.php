<?php include_once('../templates/nav.php'); ?>

<?php $title = "My Profile"; $css = "profile.css";?>
<?php ob_start(); ?>


    <header>
        <?= $nav ?>
    </header>

 <?php
 
 var_dump($user)
 
 ?>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
