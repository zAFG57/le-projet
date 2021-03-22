<?php include_once('../templates/nav.php'); ?>

<?php $title = "créer mon compte"; $css = "create-account.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>
<form id="registerForm">
    
    <input type="text" name="username" placeholder="Nom d'utilisateur" onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
    <input type="password" name="password" placeholder="Mot de passe" onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
    <input type="password" name="passwordVerify" placeholder="Mot de passe" onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
    <input type="email" name="email" placeholder="email" onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >

    <div class="submitButton" onclick="register();">register</div>
    <div id="errs"></div>
</form>
<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
