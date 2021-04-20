<?php 

    session_start();

    include_once('../templates/nav.php');

    require_once('../controller/chatProUser.php');
    require_once('../controller/user.php');



    if (!ControllerUser::isConnected()) {
        header("Location: ../index.php?location=chat");
        exit;
    }

        if(ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID']))){
            header("Location: ./chat.php?chatID=". ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID'])));
            exit;
        } else {
            header("Location: ./chat.php");
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

<?php

    if(isset($_GET['chatID']) && ControllerChatProUser::displayMessages($_SESSION['userID'], intval($_GET['chatID']))) {
        require_once('../view/chats/displayChat.php');
    } else {
        require_once('./chats/chatBase.php');
    }
    
?>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>