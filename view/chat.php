<?php 
    session_start();
    use \Controller\ControllerChatProUser;
    use \Controller\ControllerActionManager;
    use \Controller\ControllerUser;
    use \model\ActionManager;

    include_once __DIR__ . '/../controller/actionManager.php';
    include_once __DIR__ . '/../controller/chatProUser.php';
    include_once __DIR__ . '/../controller/chatProUser.php';
    include_once __DIR__ . '/../controller/user.php';
    include_once __DIR__ . '/../templates/nav.php';
    include_once __DIR__ . '/../model/actionManager.php';


    if (!ControllerUser::isConnected()) {
        header("Location: ../index.php?location=chat");
        exit;
    }

    if(isset($_GET['proID']) && ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID']))){
        header("Location: ./chat.php?chatID=". ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID'])));
        exit;
    }

    $title = "Chat"; $css = "chat.css";
    ob_start();  
?>

<header>
    <?=$nav?>
</header>
        <form id="getConv">
            <input type="hidden" name="myIdForConvs" value="<?=$_SESSION['userID']?>">
            <input type="hidden" name="action_token" value="<?=ControllerActionManager::createRequestAction(ActionManager::$GET_CONV_ACTION_TOKEN)?>">
        </form>
<?php
    if(isset($_GET['chatID']) && ControllerChatProUser::displayMessages($_SESSION['userID'], intval($_GET['chatID']))) {
        require_once('../view/chats/displayChat.php');
    } else {
        require_once('./chats/chatBase.php');
    }
    
?>
<script src="../public/js/baseScript.js"></script>
<script src="../public/js/script.js"></script>
<script>getConv()</script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>