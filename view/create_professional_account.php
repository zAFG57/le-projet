<?php 
    use Model\Lang;
    session_start();

    include_once __DIR__ . '/../templates/nav.php';
    include_once __DIR__ . '/../model/lang.php';

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));
    $title = "créer mon compte"; $css = "create-pro-account.css";
    ob_start(); 
?>

    <header>
        <?=$nav?>
    </header>

    <div class="registerForm"> 
        <h1><?= $lang->getFile()['createProAccount']['creeruncompte']?></h1>
        <form id="registerForm"> 

            <div class="txtfield">
                <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
                <span></span>
                <label><?=  $lang->getFile()['createProAccount']['uttilisateur']?></label>
            </div>

            <div class="txtfield">
                <input type="text" name="email" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
                <span></span>
                <label><?=  $lang->getFile()['createProAccount']['Email']?></label>
            </div>
      
            <div class="txtfield">
                <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
                <span></span>
                <label><?=  $lang->getFile()['createProAccount']['mdp']?></label>
            </div>

            <div class="txtfield">
                <input type="password" name="passwordVerify" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
                <span></span>
                <label><?=  $lang->getFile()['createProAccount']['confirm']?></label>
            </div>

            <div id="errs"></div>
        
            <div class="submitButton" onclick="registerpro();"><p><?=  $lang->getFile()['createProAccount']['creermoncompte']?></p></div>

            <div class="singinLink">
                <?=  $lang->getFile()['createProAccount']['djuncompte']?></br><a href="log_in.php"><?=  $lang->getFile()['createProAccount']['déco']?></a> | <a href="email_verification.php"><?=  $lang->getFile()['createProAccount']['verifmonemail']?></a>
            </div>
        

        </form>
    </div>

<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
