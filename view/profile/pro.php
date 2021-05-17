<?php include_once '../templates/nav.php'; ?>

<?php $title = "My Profile"; $css = "profilepro.css";?>
<?php ob_start(); ?>


    <header>
        <?= $nav ?>
    </header>

    <div class="main">
        <div class="profil" onclick="window.location +='&action=1' ">
            <h1>modifier mon Profile</h1>
            <p>(mon email, ma photo, mon nom...)</p>
        </div>

        <div class="travail" onclick="window.location +='&action=2' ">
            <h1>ajouter une préstation</h1>
            <p>(crée un service, apporter des doccuments légaux)</p>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>