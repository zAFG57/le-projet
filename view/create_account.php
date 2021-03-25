<?php include_once('../templates/nav.php'); ?>

<?php $title = "créer mon compte"; $css = "create-account.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>
<div class="registerForm">
    <h1>Créer un compte</h1>

    <form>

        <div class="txtfield">
            <input type="text" name="username" onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" required autofocus>
            <span></span>
            <label>Nom d'utilisateur</label>
        </div>

        <div class="txtfield">
            <input type="text" name="email" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
            <span></span>
            <label>Email</label>
        </div>
      
        <div class="txtfield">
            <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
            <span></span>
            <label>Mot de passe</label>
        </div>

        <div class="txtfield">
            <input type="password" name="passwordVerify" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
            <span></span>
            <label>Confirmation</label>
        </div>
          
        <div class="submitButton" onclick="register();"><p>Créer mon compte</p></div>

        <div class="singinLink">
            Deja un compte ? </br><a href="log_in">Se connecter</a>
        </div>
        <div id="errs"></div>

    </form>
</div>
<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
