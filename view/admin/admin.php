<?php 
    use \controller\ControllerAdmin;
    
    include_once __DIR__ . '/../../controller/serviceManager.php';
    include_once __DIR__ . '../../templates/nav.php';
?>

<?php $title = "Admin Panel"; $css = "adminPanel.css"?>
<?php ob_start(); ?>

<header>
    <?=$nav?>
</header>


    <div class="main">

        <div class="admingauche">

            <a class="lien" href="./admin_panel.php?h=<?= password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT) ?>">Admin panel</a>
            <a class="lien a" href="./admin_panel.php?h=<?= password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)?>&manageServices">demandes de prestations</a>
            
            <div class="statistique">
                statistique comming soon
            </div>
        </div>

        <div class="admindroit">
            <div class="jaipasdenompourcettediv">
                <div class="reutilisateur">recherche utilisateur</div>
                <div class="modifcontenu">modifier le contenu</div>
            </div>
        </div>
    </div>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?> 