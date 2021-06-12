<?php 
    use \Controller\ControllerChatUsers;
    use \Controller\ControllerActionManager;
    use \model\ActionManager;
    use \Controller\ControllerUser;
    
    include_once __DIR__ . '/../../model/actionManager.php';
    include_once __DIR__ . '/../../controller/actionManager.php';
    include_once __DIR__ . '/../../controller/chatUsers.php';
    include_once __DIR__ . '/../../controller/user.php';

    $json = 'displayChat';
    require('../templates/lang.php');
?>

<div class="main">
    <a class="retourenarrière" href="chat.php"></a>
<div class="discution" id="scroll">
    <div class="mesDiscussions"><?=  $parsed_lang->{'différente_discution'}?></div>
    <?php
    $discussitions = ControllerChatUsers::displayDiscussions($_SESSION['userID']);
    if (!empty($discussitions)) {
        foreach ($discussitions as $conv) {
            ?>
                <a href="./chat.php?chatID=<?=$conv['chat_id']?>" class="discutionlien">
                    <div>
                        <h1 class="discutionnom"><?=$conv['username']?></h1>
                        <?php if (isset($conv['message_content'])) { ?>
                                <h2 class="discutionmessage" id="<?=$conv['chat_id']?>"><span><?=$conv['isMe'] === true ? "Moi" : $conv['username']?> : </span> <span><?=htmlspecialchars($conv['message_content'])?></span></h2>
                            <?php
                        } else {
                            ?>
                                <h2 class="discutionmessage">aucun message</h2>
                            <?php
                        }
                        ?>
                    </div>
                </a>
            <?php
        }
    }
        ?>
    
</div>
<div class="chat">

    <div class="mainchat" id="chat">
        <?php 
            $content = ControllerChatUsers::displayMessages($_SESSION['userID'], $_GET['chatID']);
            if ($content) {
                foreach ($content as $element) {
                    ?>
                        <div class="<?= ($element['isMe'] === true) ? "me" : "you"?>"><span><?=htmlspecialchars($element['message_content'])?></span></div>
                    <?php
                }
            }
        ?>
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
    function getToBot() {
            // document.getElementById('scroll').style.scrollBehavior = "unset"
            var chat = document.getElementsByClassName('mainchat')[0];
            chat.scrollTop = chat.scrollHeight;
            document.getElementById('scroll').style.scrollBehavior = "smooth"
        }
    getToBot(); 

</script>