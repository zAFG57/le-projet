<<<<<<< HEAD
<?php ob_start(); ?>

<?php 
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

?>
        <div class="gauche">
            <a class="leftSiide" href="../index.php?location=homePage" title="Acceuil">
                <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
                <h1>Mesréparations.com </br><span>La réparation écologique et 100% française</span> </h1>
            </a>
        </div>
        <div class="droit">
                <ul>
                    <li><img src="../assets/drapeaufrancais.png" alt="drapeau français" height="25px"></li>
                    <li><a class="responsivlien" href="../index.php?location=login" title="Se connecter">Se connecter</a></li>
                    <li><a class="responsivlien" href="../index.php?location=createAccount" title="Créer mon compte">Créer un compte</a></li>
                    <li><a class="responsivlien" id="pro" href="../index.php?location=createProAccount" title="Je suis un professionel">Je suis un professionnel</a></li>
                </ul>
        </div>


<?php 
    } else {
?>

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
        <li><a class="responsivlien2" href="../index.php?location=réparation">une réparation?</a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()">Se déconnecter</div></li>
    </ul>
    </div>

 

<?php }?>
<script src="../public/js/script.js"></script>
<?php $nav = ob_get_clean(); ?>
=======
<?php ob_start(); ?>

<?php 
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

?>
        <div class="gauche">
            <a class="leftSiide" href="../index.php?location=homePage" title="Acceuil">
                <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
                <h1>Mesréparations.com </br><span>La réparation écologique et 100% française</span> </h1>
            </a>
        </div>
        <div class="droit">
                <ul>
                    <li><img src="../assets/drapeaufrancais.png" alt="drapeau français" height="25px"></li>
                    <li><a class="responsivlien" href="../index.php?location=login" title="Se connecter">Se connecter</a></li>
                    <li><a class="responsivlien" href="../index.php?location=createAccount" title="Créer mon compte">Créer un compte</a></li>
                    <li><a class="responsivlien" id="pro" href="../index.php?location=createProAccount" title="Je suis un professionel">Je suis un professionnel</a></li>
                </ul>
        </div>


<?php 
    } else {
?>

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
        <li><a class="responsivlien2" href="../index.php?location=réparation">une réparation?</a></li>
        <li><div id="pro" class="responsivlien2" onclick="logout()">Se déconnecter</div></li>
    </ul>
    </div>

 

<?php }?>
<script src="../public/js/script.js"></script>
<?php $nav = ob_get_clean(); ?>
>>>>>>> e15dc6e8c5762f944feffb3300714a4f6e3710b4
                