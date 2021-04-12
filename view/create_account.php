<<<<<<< HEAD
<?php session_start(); ?>
<?php include_once('../templates/nav.php'); ?>
<?php $title = "créer mon compte"; $css = "create-account.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>
<div class="registerForm">
    <h1>Créer un compte</h1>

    <form id="registerForm">

        <div class="txtfield">
            <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
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
        <input type="hidden" name="pro" value="0">

        <div id="errs"></div>
        
        <div class="submitButton" onclick="register();"><p>Créer mon compte</p></div>

        <div class="singinLink">
            Déjà un compte ? </br><a href="log_in">Se connecter</a> | <a href="email_verification">Vérifier mon email</a>
        </div>
        

    </form>
</div>
<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
=======
<?php session_start(); ?>
<?php include_once('../templates/nav.php'); ?>
<?php $title = "créer mon compte"; $css = "create-account.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>
<div class="registerForm">
    <h1>Créer un compte</h1>

    <form id="registerForm">

        <div class="txtfield">
            <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
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
        <input type="hidden" name="pro" value="0">

        <div id="errs"></div>
        
        <div class="submitButton" onclick="register();"><p>Créer mon compte</p></div>

        <div class="singinLink">
            Déjà un compte ? </br><a href="log_in">Se connecter</a> | <a href="email_verification">Vérifier mon email</a>
        </div>
        

    </form>
</div>
<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
>>>>>>> e15dc6e8c5762f944feffb3300714a4f6e3710b4
