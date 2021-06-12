<?php 

    use \Controller\ControllerChatUsers;

    $json = 'chatBase';
    require('../templates/lang.php');
    include_once __DIR__ . '/../../controller/chatUsers.php';
?>
<link href="../public/css/chatBase.css" rel="stylesheet" />
<div class="main">

<div class="discution" id="scroll">
    <div class="mesDiscussions"><?= $parsed_lang->{'différente_discution'}?></div>
    <?php
    $discussitions = ControllerChatUsers::displayDiscussions($_SESSION['userID']);
    var_dump($discussitions);
    if (!empty($discussitions)) {
        foreach ($discussitions as $conv) {
            ?>
                <a href="./chat.php?chatID=<?=$conv['chat_id']?>" class="discutionlien">
                    <div>
                        <h1 class="discutionnom"><?=$conv['username']?></h1>
                        <?php if (isset($conv['message_content'])) {?>
                            <h2 class="discutionmessage"><span><?=$conv['isMe'] === true ? "Moi" : $conv['username']?> : </span><?=$conv['message_content']?></h2>
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
            <h1><?=  $parsed_lang->{'bvn'}?></h1>
    </div>
</div>

</div>