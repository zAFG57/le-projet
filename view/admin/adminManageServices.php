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
    $services = ControllerService::showAllServicesAttempts($_SESSION['userID'], password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT));
    foreach ($services as $service) {
    ?>

        <div class="service" onclick="window.location='./admin_panel.php?h=<?=password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)?>&manageServices=<?=$service['service_id']?>'">
            <div class="titre">
                <h1><?=$service['title']?></h1>
            </div>
            <div class="description">
                <p>
                    <?=$service['description']?>
                </p>
            </div>
        </div>
    <?php
    }
?>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>