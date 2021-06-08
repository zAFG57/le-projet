<?php       
    include_once '../templates/nav.php';
    $title = "changer le mdp email"; 
    $css = "email-verification.css";
    $json = 'forgotps';
    require('../templates/lang.php');
    ob_start();  
?>

<header>
    <?=$nav?>
</header>


<div class="verificationForm">
    <h1><?=$parsed_lang->{'changer'}?><br/><?=$parsed_lang->{'mdp'}?></h1>

    <form id="resetPasswordAttempt">

        <div class="txtfield">
            <input type="text" name="emailForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();sendResetPasswordAttempt();}" >
            <span></span>
            <label><?=$parsed_lang->{'Email'}?></label>
        </div>

        <div id="err"></div>
        
        <div class="submitButton" onclick="sendResetPasswordAttempt();"><p><?=$parsed_lang->{'mail'}?></p></div>

        <div class="singinLink">
            <?=$parsed_lang->{'djuc'}?></br><a href="log_in.php"><?=$parsed_lang->{'connecter'}?></a>
        </div>
        

    </form>
</div>







<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>