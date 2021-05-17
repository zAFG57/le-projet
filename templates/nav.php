<?php 

    use \Controller\ControllerUser;
    use \Controller\ControllerAdmin;

    include_once '../controller/user.php';
    include_once '../controller/panelAdmin.php';

    ob_start();  
    
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
                