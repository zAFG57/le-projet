<?php       
    include_once '../templates/nav.php';
    $title = "changer le mot de passe"; $css = "email-verification.css";
    ob_start();  
?>

<header>
    <?=$nav?>
</header>



<div class="verificationForm">
    <h1>changer mon<br/> mot de passe</h1>

    <form id="modifPassword">

        <div class="txtfield">
            <input type="password" name="newPasswordForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();modifyPassword();}" >
            <span></span>
            <label>nouveau mot de passe</label>
        </div>
        <div class="txtfield">
            <input type="password" name="newValidatePasswordForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();modifyPassword();}" >
            <span></span>
            <label> verfication du nouveau mot de passe</label>
        </div>

        <input type="hidden" name="hash" value="<?=$_GET['h']?>">

        <div id="err"></div>
        
        <div class="submitButton" onclick="modifyPassword();"><p>enregister mon mot de passe</p></div>

        <div class="singinLink">
            Déjà un compte ? </br><a href="log_in">Se connecter</a>
        </div>
        

    </form>
</div>



<script src="../public/js/modifyPassword.js"></script>



<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>