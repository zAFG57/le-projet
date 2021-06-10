<?php 
    use \Controller\ControllerChatProUser;
    use \Controller\ControllerActionManager;
    use \model\ActionManager;
    use \Controller\ControllerUser;
    
    include_once __DIR__ . '/../../model/actionManager.php';
    include_once __DIR__ . '/../../controller/actionManager.php';
    include_once __DIR__ . '/../../controller/chatProUser.php';
    include_once __DIR__ . '/../../controller/user.php';

    $json = 'displayChat';
    require('../templates/lang.php');
?>

<div class="main">
    <a class="retourenarrière" href="chat.php"></a>
<div class="discution" id="scroll">
    <h1><?=  $parsed_lang->{'différente_discution'}?></h1>
</div>
<div class="chat">

    <div class="mainchat" id="chat">
    </div>
    <div class="chatinput">

        <form class="message" id="message">

            <input id="chatin" type="text" placeholder="<?=  $parsed_lang->{'message'}?>" onkeydown="if(event.key === 'Enter'){event.preventDefault();sendMessage();}">
            <input type="hidden" name="action_token" value="<?=ControllerActionManager::createRequestAction(ActionManager::$NEW_MESSAGE_ACTION_TOKEN)?>">
            <div class="send" onclick="sendMessage()" >
                <img src="../assets/avion.svg">
            </div>

        </form>

    </div>

</div>

</div>

<form id="getMessage">
    <input type="hidden" name="chatID" value="<?=intval($_GET['chatID'])?>" readonly>
</form>


<form id="data">
    <input type="hidden" id="userID" value="<?=$_SESSION['userID']?>" readonly>
    <input type="hidden" id="userIDTo" value="<?=intval($_GET['chatID'])?>" readonly>
    <input type="hidden" id="userToken" value="<?=password_hash(ControllerUser::getHashFromUserID($_SESSION['userID']), PASSWORD_DEFAULT)?>" readonly>
</form>

<!-- <script src="../public/js/sendMessage.js"></script> -->
<script>
    // getMessage();
    // function getToBot() {
    //     // document.getElementById('scroll').style.scrollBehavior = "unset"
    //     var chat = document.getElementsByClassName('mainchat')[0];
    //     chat.scrollTop = chat.scrollHeight;
    //     document.getElementById('scroll').style.scrollBehavior = "smooth"
    // }
    // getToBot(); 

</script>