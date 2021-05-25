<?php 
    session_start();
    include_once '../templates/nav.php'; 
    $title = "créer mon compte"; 
    $css = "create-account.css";
    $json = 'creeruncompte';
    require('../templates/lang.php');
    ob_start(); 
?>

<header>
    <?=$nav?>
</header>
<div class="registerForm">
    <h1><?=  $parsed_lang->{'creer_un_compte'}?></h1>

    <form id="registerForm">

        <div class="txtfield">
            <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
            <span></span>
            <label><?=  $parsed_lang->{'nom_dutilisateur'}?></label>
        </div>

        <div class="txtfield">
            <input type="text" name="email" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
            <span></span>
            <label><?=  $parsed_lang->{'Email'}?></label>
        </div>
      
        <div class="txtfield">
            <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
            <span></span>
            <label><?=  $parsed_lang->{'mdp'}?></label>
        </div>  

        <div class="txtfield">
            <input type="password" name="passwordVerify" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
            <span></span>
            <label><?=  $parsed_lang->{'confirm'}?></label>
        </div>
        <input type="hidden" name="pro" value="0">

        <div id="errs"></div>
        
        <div class="submitButton" onclick="register();"><p><?=  $parsed_lang->{'compte'}?></p></div>

        <div class="singinLink">
        <?=  $parsed_lang->{'djuncompte'}?> </br><a href="log_in"><?=  $parsed_lang->{'connecter'}?></a> | <a href="email_verification"><?=  $parsed_lang->{'verif'}?></a>
        </div>
        

    </form>
</div>
<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
