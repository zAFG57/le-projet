<?php include_once('../templates/nav.php'); ?>

<?php $title = "créer mon compte";?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    <form action="" method="post">
    
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        
        <input type="password" name="password" placeholder="Mot de passe">
        <input type="password" name="passwordVerify" placeholder="Mot de passe">

        <input type="email" name="password" placeholder="email">

        <input type="submit" value="Créer mon compte">
        
    </form>

<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
