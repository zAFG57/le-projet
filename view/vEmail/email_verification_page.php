<?php 
    $json = 'verif';
    require('../templates/lang.php');   
?>
<div class="verificationForm">
    <h1><?=$parsed_lang->{'vemail'}?></h1>

    <form id="verificationForm">

        <div class="txtfield">
            <input type="text" name="validateEmail" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();sendValidateEmailRequest();}" >
            <span></span>
            <label><?=$parsed_lang->{'Email'}?></label>
        </div>

        <div id="errs"></div>
        
        <div class="submitButton" onclick="sendValidateEmailRequest();"><p><?=$parsed_lang->{'elv'}?></p></div>

        <div class="singinLink">
            <?=$parsed_lang->{'duc'}?></br><a href="log_in"><?=$parsed_lang->{'connect'}?></a>
        </div>
        

    </form>
</div>