<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='profile'");
}
?>

<?php $title = "My Profile"; $css = "profile.css"?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    <div class='mainWrapper'>

<!-- username -->
        <div class="dispaly_values">
            <div class="actual_value"><?= 'test'?></div>
            <div class="modify_Value">test</div>
        </div>

<!-- password -->
        <div class="dispaly_values">
            <div class="actual_value">test2</div>
            <div class="modify_Value">test2</div>
        </div>

<!-- email -->
        <div class="dispaly_values">
            <div class="actual_value">test3</div>
            <div class="modify_Value">test3</div>
        </div>

    </div>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
