<?php include_once('../templates/nav.php'); ?>
<?php require_once('../model/util.php');?>

<?php $title = "Vérifier mon email"; $css = "email-verification.css"?>
<?php ob_start(); ?>
<header>
    <?=$nav?>
</header>
<?php 
    if (isset($_GET['id']) && $_GET['id'] !== '' && isset($_GET['hash']) && $_GET['hash'] !== '') {
        echo '<div class="emailVerfificationResult">';
        
        $db = connect();
        if($db) {
            $res = sqlSelect($db, 'SELECT username,hash,timestamp FROM requests WHERE id=? AND type=0', 'i', $_GET['id']);

            if ($res && $res->num_rows === 1) {
                $request = $res->fetch_assoc();
                if ($request['timestamp'] > time() - 60*60*24) {
                    if (password_verify(urlSafeDecode($_GET['hash']), $request['hash'])) {
                        if (sqlUpdate($db, 'UPDATE users SET verified=1 WHERE id=?', 'i', $request['username'])) {
                            sqlUpdate($db, 'DELETE FROM requests WHERE username=? and type=0', 'i', $request['username']);
                        }
                        echo '<h2>Votre Email a été vérifié</h2>';
                    } else {
                        echo '<h2>Hash invalide</h2>';
                    }
                } else {
                    echo '<h2>La requète de validation a expirer</h2>< /br><a href="./email_verification">cliquez pour en envoyer une autre</a>';
                }
                $res->free_result();
            } else {
                echo '<h2>Invalid verification</h2>';
            }
            $db->close();
        } else {
           echo '<h2>failed to connect to the database</h2>';
        }
        echo '</div>';
    } else {
        ?>
   

<div class="verificationForm">
    <h1>Vérifier mon Email</h1>

    <form id="verificationForm">

        <div class="txtfield">
            <input type="text" name="validateEmail" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();sendValidateEmailRequest();}" >
            <span></span>
            <label>Email</label>
        </div>

        <div id="errs"></div>
        
        <div class="submitButton" onclick="sendValidateEmailRequest();"><p>Envoyer la vérification</p></div>

        <div class="singinLink">
            Déjà un compte ? </br><a href="log_in">Se connecter</a>
        </div>
        

    </form>
</div>
<script src="../public/js/script.js"></script>
<?php
    }
?>



<?php $content = ob_get_clean();?>

<?php require('../templates/baseTemplate.php'); ?>
