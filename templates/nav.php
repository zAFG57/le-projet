<?php ob_start(); ?>
<a class="leftSiide" href="../view/home_page" title="Acceuil">
    <img class="logo" src="../assets/Sans_titre-8.png" alt="logo" height="50px">
    <h1>Mesréparations.com</h1>
</a>
<nav>
    <ul class="nav_links">
        <li><img src="../assets/drapeaufrancais.png" alt="drapeua français" height="25px"></li>
        <li><a href="../view/log_in" title="Se connecter">Se connecter</a></li>
        <li><a href="../view/create_account" title="Créer mon compte">Créer un compte</a></li>
        <li><a id="pro" a href="../view/create_professional_account" title="Je suis un professionel">Je suis un professionnel</a></li>
    </ul>
</nav>
<?php $nav = ob_get_clean(); ?>
