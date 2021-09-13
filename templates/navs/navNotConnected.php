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
</div>
<form id="langform">
    <input type="hidden" value="fr" id="langinput" name="langinput"/>
</form>