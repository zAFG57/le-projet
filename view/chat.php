<?php 
include_once('../templates/nav.php');

    session_start();
    require_once('../controller/chatProUser.php');
    require_once('../controller/user.php');
    // // echo $_SESSION['userID'];

    if (isset($_GET['proID']) && isset($_SESSION['userID'])) {
        if(ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID'])) > 0){
            header("Location: ./chat.php?chatID=". ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID'])));
            exit;
        } else {
            header("Location: ./chat.php");
            exit;
        }
    }

    $title = "Chat"; $css = "chat.css";
    ob_start(); 
?>
<header>
    <?=$nav?>
</header>
        <div class="main">

            <div class="discution" id="scroll">
                <h1>différente discution</h1>
            </div>

            <div class="chat">

                <div class="mainchat" id="chat">
                </div>
                <div class="chatinput">

                    <form class="message" id="message">

                        <input id="chatin" type="text" placeholder="votre message" name="chatin" onkeydown="if(event.key === 'Enter'){event.preventDefault();sendMessage();}">
                        <input id="userID" type="hidden" placeholder="votre message" name="userID" value="<?=ControllerChatProUser::getLastUser($_SESSION['userID'], $_GET['chatID']) ?>" readonly>
                        <div class="send" onclick="sendMessage()" >
                            <img src="../assets/avion.svg">
                        </div>

                    </form>

                </div>

            </div>

        </div>
        
        <form id="getMessage">
            <input type="hidden" name="chatID" value="<?=$_GET['chatID']?>" readonly>
        </form>

        <script src="../public/js/script.js"></script>
        <script>
            getMessage();
           function  getToBot() {
                // document.getElementById('scroll').style.scrollBehavior = "unset"
                var chat = document.getElementsByClassName('mainchat')[0];
                chat.scrollTop = chat.scrollHeight;
                document.getElementById('scroll').style.scrollBehavior = "smooth"
            }
            getToBot();
            
        </script>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>