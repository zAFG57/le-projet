<?php
    session_start();
    require_once('../controller/panelAdmin.php');
    require_once('../controller/user.php');
    require_once('../controller/serviceManager.php');

    if(ControllerUser::isConnected()) {
        if(ControllerUser::isAdmin($_SESSION['userID']) && ControllerAdmin::validateAdminToken(ControllerAdmin::getHashToken($_SESSION['userID'])) && password_verify(ControllerAdmin::getHashToken($_SESSION['userID']), $_GET['h'])) {
            if (isset($_GET['manageServices'])) {
                if (!empty($_GET['manageServices']) && ControllerService::showServiceAttempt($_GET['manageServices'], $_SESSION['userID'], password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)) !== -1) {
                    require_once('admin/adminDisplayService.php');
                } else {
                    // echo ControllerService::showServiceAttempt($_GET['manageServices'], $_SESSION['userID'], password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)) !== -1;
                    require_once('admin/adminManageServices.php');
                }
            } else {
                require_once('admin/admin.php');
            }
            
        } else {
            echo 'you are not admin';
        }
    } else {
        echo 'no connected';
    }