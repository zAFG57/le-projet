<div class="verificationForm">
    <h1>Vérifier mon Email</h1>

    <form id="verificationForm">

        <div class="txtfield">
            <input type="text" name="validateEmail" required autofocus onkeydown="if(event.key === 'Enter'){event.preventDefault();sendValidateEmailRequest();}" >
            <span></span>
            <label>Email</label>
        </div>

        <div id="errs"></div>
        
        <div class="submitButton" onclick="sendValidateEmailRequest();"><p>Envoyer la vérification</p></div>

        <div class="singinLink">
            Déjà un compte ? </br><a href="log_in">Se connecter</a>
        </div>
        

    </form>
</div>