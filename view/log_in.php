<?php include_once('../templates/nav.php'); ?>

<?php $title = "se connecter"; $css = "login.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>
<div class="login_form">
    <h1>Se connecter</h1>

    <form action="" method="post">

        <div class="txtfield">
            <input type="text" name="username" required autofocus>
            <span></span>
            <label>Nom d'utilisateur</label>
        </div>

        <div class="txtfield">
            <input type="password" name="password" required>
            <span></span>
            <label>Mot de passe</label>
        </div>

        <div class="pass">Mot de passe oublié ?</div>


        <div class="submitButton" onclick="alert('test')"><p>Connexion</p></div>

        <div class="singupLink">
            Pas encore de compte ? </br><a href="create_account">créer mon compte</a>
        </div>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>
