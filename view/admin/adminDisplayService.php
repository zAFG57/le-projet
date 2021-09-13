<?php 
    use \Controller\ControllerService;
    use \controller\ControllerAdmin;

    include_once __DIR__ . '/../../controller/serviceManager.php';
    include_once __DIR__ . '../../templates/nav.php';

    $title = "Admin Panel - Manage services"; 
    $css = "adminPanelDisplayServices.css";
    
    ob_start(); ?>

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
                <?=ControllerService::displayPDF($service['user_id'], $_GET['manageServices']);?>
            </div>
        </div>

        <form id="aceptServicesForm">
            <input type="hidden" value="<?=password_hash(ControllerAdmin::getHashToken($_SESSION['userID']), PASSWORD_DEFAULT)?>" name="adminToken"></input>
            <input type="hidden" value=<?=$_GET['manageServices']?> name="serviceIDSubmited"></input>
        </form>

        <div id="err"></div>

        <div class="verdict">
            <div class="refuser  verbtn" onclick="rejectPrestation()">refuser</div>
            <div class="accepter verbtn" onclick="acceptPrestation()">confirmer</div>
        </div>

    </div>
    <script src="../../public/js/adminScript.js"></script>
    <script>
        const car = document.getElementById("car");
        function après() {
            const pdfWidth = car.offsetWidth;
            car.scrollLeft += pdfWidth;
            if (car.scrollLeft + car.offsetWidth === car.scrollWidth) {
                car.scrollLeft = 0;
            }
        }
        function avant() {
            const pdfWidth = car.offsetWidth;
            car.scrollLeft -= pdfWidth;
            if (car.scrollLeft === 0) {
                car.scrollLeft = car.scrollWidth;
            }
        }
    </script>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>