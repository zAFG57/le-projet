<?php 
    use \controller\ControllerService;
    use \controller\ControllerAdmin;

    include_once __DIR__ . '/../../controller/serviceManager.php';
    include_once __DIR__ . '/../../templates/nav.php';

    $title = "Admin Panel - Manage services"; $css = "adminPanelManageServices.css";
    ob_start(); 
?>

<header>
        <?=$nav?>
</header>

<div class="main">
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

</div>

<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>