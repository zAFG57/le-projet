<?php 
    use \Controller\ControllerChatProUser;
    use \Controller\ControllerActionManager;
    use \model\ActionManager;
    
    include_once '../model/actionManager.php';
    include_once '../controller/actionManager.php';
    include_once '../controller/chatProUser.php';
?>

<div class="main">
    <a class="retourenarrière" href="chat.php"></a>
<div class="discution" id="scroll">
    <h1>différente discution</h1>
</div>
<div class="chat">

    <div class="mainchat" id="chat">
    </div>
    <div class="chatinput">

        <form class="message" id="message">

            <input id="chatin" type="text" placeholder="votre message" name="chatin" onkeydown="if(event.key === 'Enter'){event.preventDefault();sendMessage();}">
            <input id="userID" type="hidden" placeholder="votre message" name="userID" value="<?=ControllerChatProUser::getLastUser($_SESSION['userID'], intval($_GET['chatID'])) ?>" readonly>
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

<script src="../public/js/sendMessage.js"></script>
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