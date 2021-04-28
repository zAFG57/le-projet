<?php include_once('../templates/nav.php'); ?>

<?php $title = "My Profile"; $css = "profile.css";?>
<?php ob_start(); ?>


    <head>
        <?= $nav ?>
    </head>

    <h1>User notFound</h1>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>