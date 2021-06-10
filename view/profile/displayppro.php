
<?php 
    use \Controller\ControllerService;
    
    include_once '../templates/nav.php';
    include_once '../controller/serviceManager.php';
?> 

<?php 
    $title = "mes préstation"; $css = "préstation.css";
    ob_start();  

    
    $json = 'displayppro';
    require('../templates/lang.php');
?>
<header>
    <?=$nav?> 
</header>


<div class="addprésta" onclick="window.location += '&addService'">
            <?=  $parsed_lang->{'ajouter_une_préstation'}?>
        </div>
         
<div class="main" id="main">
    
    <?php 
        
        $services = ControllerService::showAllServices($_SESSION['userID']);
        if (!empty($services)) {
            foreach ($services as $service) {
                echo '<form id="' . $service["id"] . '"><input type="hidden" value="' . $service["id"] . '"><input type="hidden" value="' . $service["user_id"] . '"><div class="service" onclick="remouvepresta(' . $service["id"] . ')" ><div class="titre"><h1>' . $service["title"] . '</h1></div><div class="description"><p>' . $service["description"] . '</p></div></div></form>';
            }
        } else {
            // pas de presta
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