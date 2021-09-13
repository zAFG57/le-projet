<?php 
    use Model\Lang;
    
    include_once __DIR__ . '/../../templates/nav.php';

    $title = "mes préstation"; $css = "préstation.css";

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    ob_start();
?>
<header>
    <?=$nav?> 
</header>


<div class="addprésta" onclick="window.location += '&addService'">
            <?= $lang->getFile()['displayServicesPro']['ajouter_une_préstation']?>
        </div>
         
<div class="main" id="main">
    
    <?php 
        
        // $services = Service::showAllServices($_SESSION['userID']);
        if (!empty($userForProfile->getUserService())) {
            foreach ($userForProfile->getUserService() as $service) {
                echo '<form id="' . $service->getServiceID() . '"><input type="hidden" value="' . $service->getServiceID() . '"><input type="hidden" value="' . $service->getUserID() . '"><div class="service" onclick="remouvepresta(' . $service->getServiceID() . ')" ><div class="titre"><h1>' . $service->getTitle() . '</h1></div><div class="description"><p>' . $service->getDescription() . '</p></div></div></form>';
            }
        } else {
            /**
             * @todo 
             */
            // pas de presta
            // le
        }
    ?>

</div>
<div class="scrolltop" onclick="main.scrollTop = 0;"><div></div></div>





<script>
    var main = document.getElementsByClassName('main')[0];
</script>
<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>