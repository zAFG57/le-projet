<?php 

    session_start();

    require_once('../templates/nav.php');
    require_once('../controller/user.php');
    require_once('../controller/user.php');

    if (!controllerUser::isConnected()) {
        header("Location: ../index.php?location=profile");
        exit;
    } else if (!isset($_GET['user'])) {
        if (controllerUser::userExisiting($_SESSION['userID'])) {
            // header("Location: ../index.php?location=profile&user=$_SESSION['userID']");
            header("Location: ./profile.php?user=" . $_SESSION['userID']);
            exit;
        } else {
            // utilisateur non trouvé
            require_once('./profile/userNotFound.php');
        }
    } else {
        if (controllerUser::userExisiting(intval($_GET['user']))) {
            if (controllerUser::isPro(intval($_GET['user']))) {
                $user = controllerUser::getUserInfo(intval($_GET['user']));
                require_once('./profile/pro.php');
            } else if(intval($_GET['user']) === $_SESSION['userID']) {
                $user = controllerUser::getUserInfo(intval($_SESSION['userID']));
                require_once('./profile/user.php');
            }
            
        } else {
            // utilisateur non trouvé
            require_once('./profile/userNotFound.php');
        }
    }