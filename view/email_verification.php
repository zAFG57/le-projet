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
        } else {
            // error ocured page a faire : require_once('email_verification_page_not_success.php')
        }
    } else {
        require_once('vEmail/email_verification_page.php');
    }
?>
   
<script src="../public/js/script.js"></script>



<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
