<?php include_once('../templates/header.php'); ?>

<?php $title = "se connecter";?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    <form action="" method="post">
    
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="submit" value="connexion">
        
    </form>
<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>
