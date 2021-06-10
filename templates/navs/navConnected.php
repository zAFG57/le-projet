<?php $json = 'navconnected';
require('../templates/lang.php');
?>

<div class="gauche">
    <a class="leftSiide" href="../index.php" title="Acceuil">
        <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
        <h1><?=  $parsed_lang->{'Mesréparations'}?> </br><span><?=  $parsed_lang->{'larfrançaise'}?></span></h1>
    </a>
</div>

<div class="droit">
    <ul>
<<<<<<< HEAD
        <li><img src="../assets/drapeaufrancais.png" alt="drapeau français"></li>
=======
        <li id="drapeau" onclick="pays()" ></li>
        <ul id="selecterdedrapeu">
            <li id="drapeaufr" onclick="fr()"></li>
            <li id="drapeauus" onclick="en()"></li>
        </ul>
>>>>>>> origin/main
        <li><a class="responsivlien2" href="../index.php?location=profile"><?=  $parsed_lang->{'profil'}?></a></li>
        <li><a class="responsivlien2" href="../index.php?location=réparation"><?=  $parsed_lang->{'réparations'}?></a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()"><?=  $parsed_lang->{'déconnecter'}?></div></li>
    </ul>
</div>
<div class="mesmessagenav" onclick="window.location.href='../index?location=chat';">
    <img src="../assets/mail.svg">
<<<<<<< HEAD
</div>
=======
</div> 




 
<script>
    drapeau = document.getElementById('drapeau');
    select = document.getElementById('selecterdedrapeu');
    function pays() {
        drapeau.style.display = 'none';
        select.style.display = 'flex';
    }
    function fr() {
        drapeau.style.display = 'block';
        drapeau.style.background = 'url("../../assets/drapeaufrancais.png")';
        drapeau.style.backgroundSize = 'cover';
        select.style.display = 'none';
    }
    function en() {
        drapeau.style.display = 'block';
        drapeau.style.background = 'url("../../assets/drapeauUS.png")';
        drapeau.style.backgroundSize = 'cover';
        select.style.display = 'none';
    }


</script>
>>>>>>> origin/main
