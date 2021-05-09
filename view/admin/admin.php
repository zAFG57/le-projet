<?php 
    require_once('../controller/serviceManager.php');
    require_once('../templates/nav.php');
?>

<?php $title = "Admin Panel"; $css = "adminPanel.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>
<h1>Admin panel</h1>

<a href="./admin_panel.php?h=<?= password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)?>&manageServices">demandes de prestations</a>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>