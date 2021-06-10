<?php 
    use \Controller\ControllerEmailVerification;

    include_once '../templates/nav.php';
    include_once '../controller/email_verification.php';

    $title = "Vérifier mon email"; 
    $css = "email-verification.css";

    ob_start(); 
    session_start();
 ?>
<header>
    <?=$nav?>
</header>

<?php 
    if (isset($_GET['id']) && $_GET['id'] !== '' && isset($_GET['hash']) && $_GET['hash'] !== '') {
        if(ControllerEmailVerification::verificationEmailValidation($_GET['id'], $_GET['hash'])){
            // email verified page a faire : require_once('email_verification_page_success.php')
            echo '<div id="blur"></div><div class="validation"><h1>votre compte a bien été vérifier</h1><div class="btn" onclick="window.location='."'../index.php?location=login'".'">se connecter</div></div>';
        } else {
            // error ocured page a faire : require_once('email_verification_page_not_success.php')
            echo '<div id="blur"></div><div class="validation"><h1>il y a une erreur, votre email doit être déjà vérrifier</h1><div class="btn" onclick="window.location='."'../index.php?location=login'".'">se connecter</div></div>';
        }
    } else {
        require_once('vEmail/email_verification_page.php');
    }
?>
   
<script src="../public/js/script.js"></script>



<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
