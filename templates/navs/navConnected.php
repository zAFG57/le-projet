<?php 
    use Model\Lang;

    include_once __DIR__ . '/../../model/lang.php';
    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));
?>

<div class="gauche">
    <a class="leftSiide" href="../index.php" title="Acceuil">
        <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
        <h1><?= $lang->getFile()['navConnected']['Mesréparations']?> </br><span><?=  $lang->getFile()['navConnected']['larfrançaise']?></span></h1>
    </a>
</div>

<div class="droit">
    <ul>

        <li id="drapeau" onclick="pays()" style="background-image: url('../../assets/<?=$_SESSION['l']?>.png');"></li>

        <ul id="selecterdedrapeu">
            <li id="drapeaufr" onclick="fr()"></li>
            <li id="drapeauus" onclick="en()"></li>
        </ul>

        <li><a class="responsivlien2" href="../index.php?location=profile"><?=  $lang->getFile()['navConnected']['profil']?></a></li>
        <li><a class="responsivlien2" href="../index.php?location=réparation"><?=  $lang->getFile()['navConnected']['réparations']?></a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()"><?=  $lang->getFile()['navConnected']['déconnecter']?></div></li>
    </ul>

    <div class="burgeur" onclick="navresponsive()">
        <span class="burgerhaut"></span>
        <span class="burgermillieu"></span>
        <span class="burgerbas"></span>
    </div>


</div>
<div class="mesmessagenav" onclick="window.location.href='../index.php?location=chat';">
    <img src="../assets/mail.svg">
</div>
</div> 


<div class="contentnav">
        <ul class="ulnavresponsiv" style="top: -100vh;">
            <div class="drapeaure">lang:
                <li id="drapeaure" onclick="paysre();" style="background-image: url('../../assets/<?=$_SESSION['l']?>.png');"></li>
                <ul class="drapeaureul" id="selecterdedrapeure">
                    <li id="drapeaufrre" onclick="fr()"></li>
                    <li id="drapeauusre" onclick="en()"></li>
                </ul>
            </div>
            <li><a class="responsivlien2" href="../index.php?location=profile"><?=$lang->getFile()['navConnected']['profil']?></a></li>
            <li><a class="responsivlien2" href="../index.php?location=réparation"><?=$lang->getFile()['navConnected']['réparations']?></a></li>
            <li><div id="pro" class="responsivlien2" onclick="logout()"><?=$lang->getFile()['navConnected']['déconnecter']?></div></li>
        </ul>
        <div class="lesbull" style="top: -100vh;">
            <div class="bulla"></div>
            <div class="bullb"></div>
            <div class="bullc"></div>
        </div>
    </div>



<form id="langform">
    <input type="hidden" value="fr" id="langinput" name="langinput"/>
</form>


