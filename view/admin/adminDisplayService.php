<?php  
    require_once('../controller/serviceManager.php');
    require_once('../templates/nav.php');
?>

<?php $title = "Admin Panel - Manage services"; $css = "adminPanelDisplayServices.css"?>
<?php ob_start(); ?>

<header>
        <?=$nav?>
</header>
<?php
    $service = ControllerService::showServiceAttempt($_GET['manageServices'] ,$_SESSION['userID'], password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT));
?>

   <div class="main">
        <div class="back" onclick="window.location = './admin_panel.php?h=<?=password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)?>&manageServices' "><img src="../assets/retour.svg"></div>

        <div class="titre">
            <h1>
                <?=$service['title']?>
            </h1>
        </div>
        <div class="domsub">
            <div class="dommaine">domaine: <?=$service['domain']?></div>
            <div class="sousdommaine">sous-domaine: <?=$service['sub_domain']?></div>
        </div>
        <div class="description">
            <p>
                <?=$service['description']?>
            </p>
        </div>

        <div class="carosel">
            <div class="car" id="car">
                <div class="btn avant" onclick="avant()"><img src="../assets/gauche.svg"></div>
                <div class="btn après" onclick="après()"><img src="../assets/droit.svg"></div>
                <iframe src="../users/327088253/Correction DS.pdf"></iframe>
                <iframe src="../users/327088253/a.pdf"></iframe>
                <iframe src="../users/327088253/b.pdf"></iframe>
            </div>
        </div>
 

        <div class="verdict">
            <div class="refuser  verbtn" onclick="">refuser</div>
            <div class="accepter verbtn" onclick="">confirmer</div>
        </div>

    </div>

    <script>
        const car = document.getElementById("car");
        function après() {
            const pdfWidth = car.offsetWidth;
            car.scrollLeft += pdfWidth;
            if (car.scrollLeft + car.offsetWidth === car.scrollWidth) {
                car.scrollLeft = 0;
                console.log("fin du car");
            }
        }
        function avant() {
            const pdfWidth = car.offsetWidth;
            car.scrollLeft -= pdfWidth;
            if (car.scrollLeft === 0) {
                car.scrollLeft = car.scrollWidth;
                console.log('début du car');
            }
        }
    </script>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>