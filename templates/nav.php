<?php 
    ob_start();  
    require_once('../controller/user.php');
    require_once('../controller/panelAdmin.php');
    
    if(ControllerUser::isConnected()) { 
        if (isset($_SESSION['userID']) && ControllerUser::isAdmin($_SESSION['userID'])){ 
            if(ControllerAdmin::updateAdminToken(ControllerAdmin::createAdminToken($_SESSION['userID']), $_SESSION['userID'])){
                require_once('navs/navAdmin.php');
            }
        } else {
            require_once('navs/navConnected.php');
        }

    } else {
        require_once('navs/navNotConnected.php');
    }
?>

<script src="../public/js/script.js"></script>
<?php $nav = ob_get_clean(); ?>
                