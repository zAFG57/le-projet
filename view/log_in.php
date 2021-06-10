<?php session_start(); ?>
<?php include_once('../templates/nav.php'); ?>
<?php $title = "se connecter"; $css = "login.css";
    $json = 'login';
    require('../templates/lang.php');
?>
<?php ob_start(); ?>

<header>
    <?=$nav?> 
</header>
<div class="login_form">
    <h1><?=  $parsed_lang->{'connecter'}?></h1>

    <form id="loginform">

        <div class="txtfield">
            <input type="text" name="email" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}">
            <span></span>
            <label><?=  $parsed_lang->{'Email'}?></label>
        </div>

        <div class="txtfield">
            <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}">
            <span></span>
            <label><?=  $parsed_lang->{'mdp'}?></label>
        </div>

        <div class="pass" onclick="window.location = './forgot_password.php'"><?=  $parsed_lang->{'mdpoublier'}?></div>

        <div id="errs"></div>

        <div class="submitButton" onclick="login()"><p><?=  $parsed_lang->{'Connexion'}?></p></div>

        <div class="singupLink">
        <?=  $parsed_lang->{'pdcompte'}?> </br><a href="create_account.php"><?=  $parsed_lang->{'compte'}?></a>
        </div>
    </form>
</div>

<script src="../public/js/script.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>
 
