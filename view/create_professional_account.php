<?php 
    session_start();
    include_once '../templates/nav.php' ;
    $title = "créer mon compte";
    $css = "create-pro-account.css";
    $json = 'créeprocompte';
    require('../templates/lang.php');
    ob_start(); 
?>

    <header>
        <?=$nav?>
    </header>

    <div class="registerForm"> 
        <h1><?=  $parsed_lang->{'creeruncompte'}?></h1>
        <form id="registerForm"> 

            <div class="txtfield">
                <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
                <span></span>
                <label><?=  $parsed_lang->{'uttilisateur'}?></label>
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

            <div id="errs"></div>
        
            <div class="submitButton" onclick="registerpro();"><p><?=  $parsed_lang->{'creermoncompte'}?></p></div>

            <div class="singinLink">
                <?=  $parsed_lang->{'djuncompte'}?></br><a href="log_in"><?=  $parsed_lang->{'déco'}?></a> | <a href="email_verification"><?=  $parsed_lang->{'verifmonemail'}?></a>
            </div>
        

        </form>
    </div>

<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
