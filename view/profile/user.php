<?php include_once('../templates/nav.php'); ?>

<?php $title = "My Profile"; $css = "profile.css";?>
<?php ob_start(); ?>


    <head>
        <?= $nav ?>
    </head>

    <h1>User profile</h1>
    <?php var_dump($user) ?>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
