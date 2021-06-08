<?php
    $json = 'navadmin';
    require('../templates/lang.php');
    use \Controller\ControllerAdmin;
    include_once '../controller/panelAdmin.php';
?>

<div class="gauche">
    <a class="leftSiide" href="../index.php" title="Acceuil">
        <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
        <h1><?=  $parsed_lang->{'Mesréparations'}?> </br><span><?=  $parsed_lang->{'larfrançaise'}?></span></h1>
    </a>
</div>

<div class="droit">
    <ul>
        <li><img src="../assets/drapeaufrancais.png" alt="drapeau français" width="27"></li>
        <li><a class="responsivlien2" href="../index.php?location=profile"><?=  $parsed_lang->{'profil'}?></a></li>
        <li><a class="responsivlien2" href="/view/admin_panel.php?h=<?= password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT) ?>"><?=  $parsed_lang->{'admin'}?></a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()"><?=  $parsed_lang->{'déconnecter'}?></div></li>
    </ul>
</div>
<div class="mesmessagenav" onclick="window.location.href='../index.php?location=chat';">
    <img src="../assets/mail.svg">
</div>