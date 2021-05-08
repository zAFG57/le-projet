<?php 
    require_once('../controller/serviceManager.php');
    require_once('../templates/nav.php');
?>

<?php $title = "Admin Panel - Manage services"; $css = "adminPanelManageServices.css"?>
<?php ob_start(); ?>

<header>
        <?=$nav?>
</header>
<h1>manage services</h1>


<?php
    var_dump(ControllerService::showAllServicesAttempts($_SESSION['userID'], password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)));
?>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>