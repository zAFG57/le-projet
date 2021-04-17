
<div class="gauche">
    <a class="leftSiide" href="../index.php" title="Acceuil">
        <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
        <h1>Mesréparations.com </br><span>La réparation écologique et 100% française</span></h1>
    </a>
</div>

<div class="droit">
    <ul>
        <li><img src="../assets/drapeaufrancais.png" alt="drapeau français"></li>
        <li><a class="responsivlien2" href="../index.php?location=profile">Mon profil</a></li>
        <li><a class="responsivlien2" href="/view/admin_panel?h=<?= password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT) ?>">Admin panel</a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()">Se déconnecter</div></li>
    </ul>
</div>