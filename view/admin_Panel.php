<?php
    session_start();
    require_once('../controller/panelAdmin.php');
    require_once('../controller/user.php');


    if(ControllerUser::isConnected()) {
        if(ControllerUser::isAdmin($_SESSION['userID']) && ControllerAdmin::validateAdminToken(ControllerAdmin::getHashToken($_SESSION['userID'])) && password_verify(ControllerAdmin::getHashToken($_SESSION['userID']), $_GET['h'])) {
            echo 'you are admin';
        } else {
            echo 'you are not admin';
        }
    } else {
        echo 'no connected';
    }