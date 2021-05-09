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
            <input id="userID" type="hidden" placeholder="votre message" name="userID" value="<?=ControllerChatProUser::getLastUser($_SESSION['userID'], intval($_GET['chatID'])) ?>" readonly>
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

<script>
    getMessage();
    function  getToBot() {
        var chat = document.getElementsByClassName('mainchat')[0];
        chat.scrollTop = chat.scrollHeight;
        document.getElementById('scroll').style.scrollBehavior = "smooth"
    }
    getToBot(); 

</script>