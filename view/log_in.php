<?php 
    use Model\Lang;

    session_start(); 

    include_once __DIR__ . '/../templates/nav.php';
    include_once __DIR__ . '/../model/lang.php';

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    $title = "se connecter"; $css = "login.css";
?>
<?php ob_start(); ?>

<header>
    <?=$nav?> 
</header>
<div class="login_form">
    <h1><?=  $lang->getFile()['login']['connecter']?></h1>

    <form id="loginform">

        <div class="txtfield">
            <input type="text" name="email" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}">
            <span></span>
            <label><?=  $lang->getFile()['login']['Email']?></label>
        </div>

        <div class="txtfield">
            <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}">
            <span></span>
            <label><?=  $lang->getFile()['login']['mdp']?></label>
        </div>

        <div class="pass" onclick="window.location = './forgot_password.php'"><?=  $lang->getFile()['login']['mdpoublier']?></div>

        <div id="errs"></div>

        <div class="submitButton" onclick="login()"><p><?=  $lang->getFile()['login']['Connexion']?></p></div>

        <div class="singupLink">
        <?=  $lang->getFile()['login']['pdcompte']?> </br><a href="create_account.php"><?=  $lang->getFile()['login']['compte']?></a>
        </div>
    </form>
</div>

<script src="../public/js/script.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>
 
