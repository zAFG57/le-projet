<?php  
    session_start();
    
    use \Model\User;
    use \Model\ServiceManager;

    include_once __DIR__ . '/../templates/nav.php';
    include_once __DIR__ . '/../model/user.php';
    include_once __DIR__ . '/../model/serviceManager.php';
    
    
    if (!User::isConnected()) {
        header("Location: ../index.php?location=profile");
        exit;
    } elseif (!isset($_GET['user'])) {
        $userForProfile = new User($_SESSION['userID']);
        if ($userForProfile->getUserID()) {
            // header("Location: ../index.php?location=profile&user=$_SESSION['userID']");
            header("Location: ./profile.php?user=" . $userForProfile->getUserID());
            exit;
        } else {
            // utilisateur non trouvé
            require_once('./profile/userNotFound.php');
        }
    } else {
        $userForProfile = new ServiceManager(intval($_GET['user']));

        if ($userForProfile->getUserID()) {
            
            // $user = controllerUser::getUserInfo(intval($_GET['user']));

            if (intval($_GET['user']) === $_SESSION['userID'] && isset($_GET['action']) && intval($_GET['action']) === 1) {
                require_once('./profile/user.php');
            } elseif (intval($_GET['user']) === $_SESSION['userID'] && isset($_GET['action']) && intval($_GET['action']) === 2){
                require_once('./profile/prestationPro.php');
            } elseif (intval($_GET['user']) === $_SESSION['userID'] ){
                require_once('./profile/pro.php');

            } elseif ($userForProfile->getUserService() !== null) {
                 if (isset($_GET['presta']) && intval($_GET['presta']) === 1) {
                    require_once('./profile/viewPrestation.php');
                } else {
                    require_once('./profile/viewProProfile.php');
                } 
            } else {  
                require_once('./profile/userNotFound.php');
            }
        
        } else {
            require_once('./profile/userNotFound.php');
        }
    }