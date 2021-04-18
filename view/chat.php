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

        
    // }
    
    // if (isset($_GET['chatID']) && isset($_SESSION['userID'])) {
    //     $amsg = ControllerChatProUser::displayMessages($_SESSION['userID'], intval($_GET['chatID']));
    //     if (!$amsg) {
    //         header("Location: ./chat.php");
    //         exit;
    //     } else {
    //          var_dump($amsg);
    //     }
    // }

    // var_dump(ControllerChatProUser::newMessage(ControllerChatProUser::openChat($_SESSION['userID'], intval($_GET['proID'])), 'Deuxième Message', $_SESSION['userID']));
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

                <div class="mainchat" id="scroll">

                    <div class="me"><span>sdhgzsgzsg</span></div>
                    <div class="me"><span>fhqdhrdfqhq</span></div>
                    <div  class="you"><span>dfhqdfhqdfhfhbdfh</span></div>
                    <div class="you"><span>sqfqsfqsfqsfq</span></div>
                    <div class="me"><span>fhdfhdqfhqdfhfdhqdfh</span></div>
                    <div class="me"><span>dfhdfhdfhFGDFGDFGDFGDFGDFGDFGDGqhfdhqhdfh</span></div>
                    <div  class="you"><span>dqhdfhdqhfrdqhdfhf</span></div>
                    <div class="me"><span>fdqhfhdqhqrdhfh</span></div>
                    <div  class="you"><span>fhdfhdfhdfhdfhfdh</span></div>
                    <div class="me"><span>fhefqfqFDGDFGDFGDFGDFGDFGDFGDsdfqsf ujhrfzhefjklzhfizep fehzufhzeilfhuzie fhezuifhziuefga zgaulfqmfhisodfma zdfhuaipzfhiuapzf qsfqs</span></div>
                    <div class="me"><span>qsqsfqsfqsfqsfqsf</span></div>
                    <div class="me"><span>o^ùkmhjktyhdfg</span></div>
                    <div  class="you"><span>sdfsdgdfbhfgjnfgjk</span></div>
                    <div class="me"><span>DFGHDFGDGDFGFD<br/><br/><br/>GDFGdfvngrukikjtfg</span></div>

                </div>
                <div class="chatinput">

                    <form class="message" id="message">

                        <input id="chatin" type="text" placeholder="votre message" name="chatin" onkeydown="if(event.key === 'Enter'){event.preventDefault();sendMessage();}">
                        <input id="userID" type="hidden" placeholder="votre message" name="userID" value="<?=327088253?>" readonly>
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
            var chat = document.getElementsByClassName('mainchat')[0];
            chat.scrollTop = chat.scrollHeight;
            document.getElementById('scroll').style.scrollBehavior = "smooth"
        </script>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>