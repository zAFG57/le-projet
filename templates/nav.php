<?php ob_start(); ?>

<?php 
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {

?>
<a class="leftSiide" href="../index.php?location=homePage" title="Acceuil">
    <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
    <h1>Mesréparations.com</h1>
</a>
<nav>
    <ul class="nav_links pre">
        <li><img src="../assets/drapeaufrancais.png" alt="drapeau français" height="25px"></li>
        <li><a class="responsivlien" href="../index.php?location=login" title="Se connecter">Se connecter</a></li>
        <li><a class="responsivlien" href="../index.php?location=createAccount" title="Créer mon compte">Créer un compte</a></li>
        <li><a class="responsivlien" id="pro" href="../index.php?location=createProAccount" title="Je suis un professionel">Je suis un professionnel</a></li>
    </ul>
</nav>


<?php 
    } else {
?>

<a class="leftSiide" href="../index.php" title="Acceuil">
    <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
    <h1>Mesréparations.com</h1>
</a>
<nav>
    <ul class="nav_links">
        <li><img src="../assets/drapeaufrancais.png" alt="drapeau français" height="25px"></li>
        <li><a class="responsivlien2" href="../index.php?location=profile">Mon profil</a></li>
        <li><a class="responsivlien2" href="../index.php?location=réparation">une réparation?</a></li>
        <li><div class="responsivlien2" onclick="logout()">Se déconnecter</div></li>
    </ul>
</nav>
 

<?php }?>
<script src="../public/js/script.js"></script>
<?php $nav = ob_get_clean(); ?>
                