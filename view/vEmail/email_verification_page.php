<?php 
    use Model\Lang;
    
    include_once __DIR__ . '/../../model/lang.php';

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

?>
<div class="verificationForm">
    <h1><?= $lang->getFile()['verification']['vemail']?></h1>

    <form id="verificationForm">

        <div class="txtfield">
            <input type="text" name="validateEmail" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();sendValidateEmailRequest();}" >
            <span></span>
            <label><?=$lang->getFile()['verification']['Email']?></label>
        </div>

        <div id="errs"></div>
        
        <div class="submitButton" onclick="sendValidateEmailRequest();"><p><?=$lang->getFile()['verification']['elv']?></p></div>

        <div class="singinLink">
            <?=$lang->getFile()['verification']['duc']?></br><a href="log_in.php"><?=$lang->getFile()['verification']['connect']?></a>
        </div>
        

    </form>
</div>