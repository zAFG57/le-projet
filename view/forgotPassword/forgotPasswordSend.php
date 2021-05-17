<?php       
    include_once '../templates/nav.php';
    $title = "changer le mdp email"; 
    $css = "email-verification.css";
    ob_start();  
?>

<header>
    <?=$nav?>
</header>


<div class="verificationForm">
    <h1>changer mon<br/> mot de passe</h1>

    <form id="resetPasswordAttempt">

        <div class="txtfield">
            <input type="text" name="emailForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();sendResetPasswordAttempt();}" >
            <span></span>
            <label>Email</label>
        </div>

        <div id="err"></div>
        
        <div class="submitButton" onclick="sendResetPasswordAttempt();"><p>envoyer le mail</p></div>

        <div class="singinLink">
            Déjà un compte ? </br><a href="log_in">Se connecter</a>
        </div>
        

    </form>
</div>







<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>