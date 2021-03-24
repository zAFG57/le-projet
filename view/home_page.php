<?php include_once('../templates/nav.php'); ?>

<?php $title = "Company name"; $css = "home.css"?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
   <!-- <h1>This is the home page</h1> -->

<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
