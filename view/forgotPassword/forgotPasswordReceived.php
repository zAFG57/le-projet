<?php       
    include_once '../templates/nav.php';
    $title = "changer le mot de passe"; $css = "email-verification.css";
    $json = 'forgotr';
    require('../templates/lang.php');
    ob_start();  
?>

<header>
    <?=$nav?>
</header>



<div class="verificationForm">
    <h1><?=$parsed_lang->{'changer'}?><br/> <?=$parsed_lang->{'mdp'}?></h1>

    <form id="modifPassword">

        <div class="txtfield">
            <input type="password" name="newPasswordForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();modifyPassword();}" >
            <span></span>
            <label><?=$parsed_lang->{'nmdp'}?></label>
        </div>
        <div class="txtfield">
            <input type="password" name="newValidatePasswordForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();modifyPassword();}" >
            <span></span>
            <label><?=$parsed_lang->{'vnmdp'}?></label>
        </div>

        <input type="hidden" name="hash" value="<?=$_GET['h']?>">

        <div id="err"></div>
        
        <div class="submitButton" onclick="modifyPassword();"><p><?=$parsed_lang->{'emdp'}?></p></div>

        <div class="singinLink">
            <?=$parsed_lang->{'duc'}?> </br><a href="log_in"><?=$parsed_lang->{'connect'}?></a>
        </div>
        

    </form>
</div>



<script src="../public/js/modifyPassword.js"></script>



<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>