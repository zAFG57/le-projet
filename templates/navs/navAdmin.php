<?php
    use \Controller\ControllerAdmin;
use Model\Admin;

require_once __DIR__ . '/../../templates/lang.php';
    include_once '../controller/panelAdmin.php';

    $json = 'navadmin';

    $admin = new Admin($_SESSION['userID'])
?>

<div class="gauche">
    <a class="leftSiide" href="../index.php" title="Acceuil">
        <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
        <h1><?=  $parsed_lang->{'Mesréparations'}?> </br><span><?=  $parsed_lang->{'larfrançaise'}?></span></h1>
    </a>
</div>

<div class="droit">
    <ul>
        <li id="drapeau" onclick="pays()" style="background-image: url('../../assets/<?=$_SESSION['l']?>.png');"></li>
        <ul id="selecterdedrapeu">
            <li id="drapeaufr" onclick="fr()"></li>
            <li id="drapeauus" onclick="en()"></li>
        </ul>
        <li><a class="responsivlien2" href="../index.php?location=profile"><?=  $parsed_lang->{'profil'}?></a></li>
        <li><a class="responsivlien2" href="/view/admin_panel.php?h=<?= password_hash($admin->getAdminToken(), PASSWORD_DEFAULT) ?>"><?=  $parsed_lang->{'admin'}?></a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()"><?=  $parsed_lang->{'déconnecter'}?></div></li>
    </ul>
</div>
<div class="mesmessagenav" onclick="window.location.href='../index.php?location=chat';">
    <img src="../assets/mail.svg">
</div>
<form id="langform">
    <input type="hidden" value="fr" id="langinput" name="langinput"/>
</form>