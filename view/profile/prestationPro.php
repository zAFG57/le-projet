<?php
    // session_start();
    require_once('../controller/user.php');

    if (controllerUser::userExisiting($_SESSION['userID']) ) {
        if (isset($_GET['addService'])) {
            require_once('./profile/addPrestationPro.php');
        } else {
            echo '<h1>MODIFIER MES PRESTATIONS</h1>';
        }
    }