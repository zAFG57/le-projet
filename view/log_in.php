<?php include_once('../templates/nav.php'); ?>

<?php $title = "se connecter"; $css = "login.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>
<div id="login_form">
    <h1>Se connecter</h1>
    <form action="" method="post">
        
        <input class="" type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="submit" value="connexion">
            
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>
