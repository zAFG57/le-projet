<?php 

    session_start();

    include_once('../templates/nav.php');

    require_once('../controller/chatProUser.php');
    require_once('../controller/user.php');



    if (!ControllerUser::isConnected()) {
        header("Location: ../index.php?location=chat");
        exit;
    }

        if(isset($_GET['proID']) && ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID']))){
            header("Location: ./chat.php?chatID=". ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID'])));
            exit;
        }
?> 

<?php 
    $title = "Chat"; $css = "chat.css";
    ob_start();  
?>

<header>
    <?=$nav?>
</header>
        <form id="getConv">
            <input type="hidden" name="myIdForConvs" value="<?=$_SESSION['userID']?>">
        </form>
<?php
    if(isset($_GET['chatID']) && ControllerChatProUser::displayMessages($_SESSION['userID'], intval($_GET['chatID']))) {
        require_once('../view/chats/displayChat.php');
    } else {
        require_once('./chats/chatBase.php');
    }
    
?>

<script src="../public/js/script.js"></script>
<script>getConv()</script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>