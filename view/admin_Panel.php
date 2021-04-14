<?php
    session_start();
    require_once(MainPath . 'model/connection.php');

    if(isConnected()) {
        if(isAdmin($_SESSION['userID']) && validateAdminToken(getHashToken($_SESSION['userID'])) && password_verify(getHashToken($_SESSION['userID']), $_GET['h'])) {
            echo 'you are admin';
        } else {
            echo 'you are not admin';
        }
    } else {
        echo 'no connected';
    }