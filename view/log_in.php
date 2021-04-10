<?php session_start(); ?>
<?php include_once('../templates/nav.php'); ?>
<?php $title = "se connecter"; $css = "login.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?> 
</header>
<div class="login_form">
    <h1>Se connecter</h1>

    <form id="loginform">

        <div class="txtfield">
            <input type="text" name="email" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}">
            <span></span>
            <label>Email</label>
        </div>

        <div class="txtfield">
            <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}">
            <span></span>
            <label>Mot de passe</label>
        </div>

        <div class="pass">Mot de passe oublié ?</div>

        <div id="errs"></div>

        <div class="submitButton" onclick="login()"><p>Connexion</p></div>

        <div class="singupLink">
            Pas encore de compte ? </br><a href="create_account">créer mon compte</a>
        </div>
    </form>
</div>

<script src="../public/js/script.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>
