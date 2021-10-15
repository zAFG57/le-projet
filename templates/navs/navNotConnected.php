<?php
    use Model\Lang;

    include_once __DIR__ . '/../../model/lang.php';
    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));
?>


<div class="gauche">
        <a class="leftSiide" href="../index.php?location=homePage" title="Acceuil">
            <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
            <h1><?=  $lang->getFile()['navNotConnected']['Mesréparations']?> </br><span><?=  $lang->getFile()['navNotConnected']['larfrançaise']?></span></h1>
        </a>
</div>

<div class="droit">
    <ul>
        <li id="drapeau" onclick="pays()" style="background-image: url('../../assets/<?=$_SESSION['l']?>.png');"></li>
        <ul id="selecterdedrapeu">
            <li id="drapeaufr" onclick="fr()"></li>
            <li id="drapeauus" onclick="en()"></li>
        </ul>
        <li><a class="responsivlien" href="../index.php?location=login" title="Se connecter"><?=  $lang->getFile()['navNotConnected']['connecter']?></a></li>
        <li><a class="responsivlien" href="../index.php?location=createAccount" title="Créer mon compte"><?=  $lang->getFile()['navNotConnected']['compte']?></a></li>
        <li><a class="responsivlien" id="pro" href="../index.php?location=createProAccount" title="Je suis un professionel"><?=  $lang->getFile()['navNotConnected']['pro']?></a></li>
    </ul>
    

    <div class="burgeur" onclick="navresponsive()">
        <span class="burgerhaut"></span>
        <span class="burgermillieu"></span>
        <span class="burgerbas"></span>
    </div>



</div>
<div class="contentnav">
        <ul class="ulnavresponsiv" style="top: -100vh;">
            <div class="drapeaure">lang:
                <li id="drapeaure" onclick="paysre();" style="background-image: url('../../assets/<?=$_SESSION['l']?>.png');"></li>
                <ul class="drapeaure" id="selecterdedrapeure">
                    <li id="drapeaufrre" onclick="fr()"></li>
                    <li id="drapeauusre" onclick="en()"></li>
                </ul>
            </div>
            <li><a class="responsivlien2" href="../index.php?location=login" title="Se connecter"><?=$lang->getFile()['navNotConnected']['connecter']?></a></li>
            <li><a class="responsivlien2" href="../index.php?location=createAccount" title="Créer mon compte"><?=$lang->getFile()['navNotConnected']['compte']?></a></li>
            <li><a class="responsivlien2 créerunpro" href="../index.php?location=createProAccount" title="Je suis un professionel"><?=$lang->getFile()['navNotConnected']['pro']?></a></li>
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