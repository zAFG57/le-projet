<?php ob_start(); ?>
<div class="leftSiide">
    <img class="logo" src="../assets/Logorond2.png" alt="logo" height="50px">
    <h1>Mesréparations.com</h1>
</div>
<nav>
    <ul class="nav_links">
        <li><a href="../view/home_page">Home</a></li>
        <li><a href="../view/create_professional_account">Je suis un professionnel</a></li>
        <li><a href="../view/log_in">se connecter</a></li>
        <li><a href="../view/create_account">créer un compte</a></li>
    </ul>
</nav>
<!-- <a href="">Je suis artisan</a> -->
<?php $nav = ob_get_clean(); ?>
