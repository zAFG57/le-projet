<div class="gauche">
    <a class="leftSiide" href="../index.php" title="Acceuil">
        <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
        <h1>Mesréparations.com </br><span>La réparation écologique et 100% française</span></h1>
    </a>
</div>

<div class="droit">
    <ul>
        <li><img src="../assets/drapeaufrancais.png" alt="drapeau français"></li>
        <li><a class="responsivlien2" onclick="transitionnavanim(); setTimeout(profile, 250)">Mon profil</a></li>
        <li><a class="responsivlien2" onclick="transitionnavanim(); setTimeout(réparation, 250)">mes réparations</a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()">Se déconnecter</div></li>
    </ul>
</div>
<div class="mesmessagenav" id="messagenav" onclick="messagecssanim()">
    <img src="../assets/mail.svg">
</div>


<script>
    function messagecssanim (){
        nav = document.getElementById('messagenav');
        nav.classList.add("messagenavanim");
        setTimeout(windowlocationmessage, 500); 
    }
    function windowlocationmessage (){
        window.location.href='../index?location=chat';
    }
    function transitionnavanim (){
        transition = document.getElementById('transition');
        transition2 = document.getElementById('transition2');
        transition.classList.add("transitionon");
        transition2.classList.add("transitionon2");
        setTimeout(remouveclaasnam , 500 ); 
    }
    function remouveclaasnam (){
        transition2.classList.remove('transitionon2'); 
        transition.classList.remove('transitionon'); 
    }
    function réparation() {
        window.location = '../index.php?location=homePage' ; 
    }
    function profile() {
        window.location = '../index.php?location=profile' ; 
    }
    


</script>



<div class="transition" id="transition"></div>
<div class="transition2" id="transition2"></div>