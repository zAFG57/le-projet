<?php 
    use Model\Lang;
    use \Controller\ControllerChatUsers;

    include_once __DIR__ . '/../../controller/chatUsers.php';
    include_once __DIR__ . '/../../model/lang.php';

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

?>
<link href="../public/css/chatBase.css" rel="stylesheet" />
<div class="main">

<div class="discution" id="scroll">
    <div class="mesDiscussions"><?= $lang->getFile()['chatBase']['différente_discution']?></div>
    <?php
    $discussitions = ControllerChatUsers::displayDiscussions($_SESSION['userID']);
    // var_dump($discussitions);
    if (!empty($discussitions)) {
        foreach ($discussitions as $conv) {
            ?>
                <a href="./chat.php?chatID=<?=$conv['chat_id']?>" class="discutionlien">
                    <div>
                        <h1 class="discutionnom"><?=htmlspecialchars($conv['username'])?></h1>
                        <?php if (isset($conv['message_content'])) {?>
                            <h2 class="discutionmessage"><span><?=$conv['isMe'] === true ? "Moi" : htmlspecialchars($conv['username'])?> : </span><?=htmlspecialchars($conv['message_content'])?></h2>
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
    <div class="bvnsurvosmessage">
            <h1><?=  $lang->getFile()['chatBase']['bvn']?></h1>
    </div>
</div>

</div>