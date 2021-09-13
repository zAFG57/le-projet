<?php    
    use Model\Lang;   
    include_once __DIR__ . '/../../templates/nav.php';
    include_once __DIR__ . '/../../model/lang.php';


    $title = "changer le mdp email"; $css = "email-verification.css";
    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    ob_start();  
?>

<header>
    <?=$nav?>
</header>


<div class="verificationForm">
    <h1><?=$lang->getFile()['forgotPassword']['changer']?><br/><?=$lang->getFile()['forgotPassword']['mdp']?></h1>

    <form id="resetPasswordAttempt">

        <div class="txtfield">
            <input type="text" name="emailForgotPassword" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();sendResetPasswordAttempt();}" >
            <span></span>
            <label><?=$lang->getFile()['forgotPassword']['Email']?></label>
        </div>

        <div id="err"></div>
        
        <div class="submitButton" onclick="sendResetPasswordAttempt();"><p><?=$lang->getFile()['forgotPassword']['mail']?></p></div>

        <div class="singinLink">
            <?=$lang->getFile()['forgotPassword']['djuc']?></br><a href="log_in.php"><?=$lang->getFile()['forgotPassword']['connecter']?></a>
        </div>
        

    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>