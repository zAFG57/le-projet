<?php session_start(); ?>
<?php include_once('../templates/nav.php'); ?>

<?php $title = "créer mon compte";$css = "create-pro-account.css"?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>

    <div class="registerForm"> 
        <h1>Créer un compte professionnelle</h1>
        <form id="registerForm"> 

            <div class="txtfield">
                <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
                <span></span>
                <label>Nom</label>
            </div>

            <div class="txtfield">
                <input type="text" name="username" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
                <span></span>
                <label>Prénom</label>
            </div>

            <div class="txtfield">
                <input type="text" name="email" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
                <span></span>
                <label>Email</label>
            </div>
      
            <div class="txtfield">
                <input type="password" name="password" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}">
                <span></span>
                <label>Mot de passe</label>
            </div>

            <div class="txtfield">
                <input type="password" name="passwordVerify" required onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" >
                <span></span>
                <label>Confirmation</label>
            </div>

            <div id="errs"></div>
        
            <div class="submitButton" onclick="registerpro();"><p>Créer mon compte</p></div>

            <div class="singinLink">
                Déjà un compte ? </br><a href="log_in">Se connecter</a> | <a href="email_verification">Vérifier mon email</a>
            </div>
        

        </form>
    </div>

<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
