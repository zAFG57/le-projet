<?php       
    use Model\Lang;

    include_once __DIR__ . '/../../model/lang.php';
    include_once __DIR__ . '/../../templates/nav.php';

    $title = "changer le mot de passe"; $css = "email-verification.css";

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    ob_start();  
?>

<header>
    <?=$nav?>
</header>



<div class="verificationForm">
    <h1><?=$lang->getFile()['forgotPasswordResponse']['changer']?><br/> <?=$lang->getFile()['forgotPasswordResponse']['mdp']?></h1>

    <form id="modifPassword">

        <div class="txtfield">
            <input type="password" name="newPasswordForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();modifyPassword();}" >
            <span></span>
            <label><?=$lang->getFile()['forgotPasswordResponse']['nmdp']?></label>
        </div>
        <div class="txtfield">
            <input type="password" name="newValidatePasswordForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();modifyPassword();}" >
            <span></span>
            <label><?=$lang->getFile()['forgotPasswordResponse']['vnmdp']?></label>
        </div>

        <input type="hidden" name="hash" value="<?=$_GET['h']?>">

        <div id="err"></div>
        
        <div class="submitButton" onclick="modifyPassword();"><p><?=$lang->getFile()['forgotPasswordResponse']['emdp']?></p></div>

        <div class="singinLink">
            <?=$lang->getFile()['forgotPasswordResponse']['duc']?> </br><a href="log_in.php"><?=$lang->getFile()['forgotPasswordResponse']['connect']?></a>
        </div>
        

    </form>
</div>



<script src="../public/js/modifyPassword.js"></script>



<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>