<?php 

    use \Model\User;
    use \Model\Admin;

    include_once __DIR__ . '/../model/user.php';
    include_once __DIR__ . '/../model/panelAdmin.php';

    ob_start();  
    
    if(User::isConnected()) {
        $user = new Admin($_SESSION['userID']);
        if (!$user->isAdmin()){ 
            if($user->updateAdminToken($user->createAdminToken())){
                include_once __DIR__ . '/navs/navAdmin.php';
            }
        } else {
            include_once __DIR__ . '/navs/navConnected.php';
        }

    } else {
        include_once __DIR__ . '/navs/navNotConnected.php';
    }
?>

<script src="../public/js/script.js"></script>
<?php $nav = ob_get_clean(); ?>
                