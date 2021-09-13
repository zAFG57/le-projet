<?php 
    use Model\Lang;

    session_start();
   
    include_once __DIR__ . '/../templates/nav.php';
    include_once __DIR__ . '/../model/lang.php';
   
    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    $title = "créer mon compte"; $css = "create-account.css";
    ob_start(); 
?>

<header>
    <?=$nav?>
</header>
<div class="registerForm">
    <h1><?= $lang->getFile()['createAccount']['creer_un_compte']?></h1>

    <form id="registerForm">

        <div class="txtfield">
            <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
            <span></span>
            <label><?=  $lang->getFile()['createAccount']['nom_dutilisateur']?></label>
        </div>

        <div class="txtfield">
            <input type="text" name="email" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
            <span></span>
            <label><?=  $lang->getFile()['createAccount']['Email']?></label>
        </div>
      
        <div class="txtfield">
            <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
            <span></span>
            <label><?=  $lang->getFile()['createAccount']['mdp']?></label>
        </div>  

        <div class="txtfield">
            <input type="password" name="passwordVerify" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
            <span></span>
            <label><?=  $lang->getFile()['createAccount']['confirm']?></label>
        </div>
        <input type="hidden" name="pro" value="0">

        <div id="errs"></div>
        
        <div class="submitButton" onclick="register();"><p><?=  $lang->getFile()['createAccount']['compte']?></p></div>

        <div class="singinLink">
        <?=  $lang->getFile()['createAccount']['djuncompte']?> </br><a href="log_in.php"><?=  $lang->getFile()['createAccount']['connecter']?></a> | <a href="email_verification.php"><?=  $lang->getFile()['createAccount']['verif']?></a>
        </div>
        

    </form>
</div>
<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
