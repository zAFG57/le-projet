<?php 

    include_once('../templates/nav.php');
    require_once('../controller/serviceManager.php');

?> 

<?php 
    $title = "mes préstation"; $css = "préstation.css";
    ob_start();  
?>

<header>
    <?=$nav?>
</header>
        

<div class="addprésta" onclick="window.location += '&addService'">
            ajouter une préstation <span></span>
        </div>
        
<div class="main" id="main">
    <?php 
        $services = ControllerService::showAllServices($_SESSION['userID']);

        foreach ($services as $service) {
            echo '<div class="préstation">' . $service['title'] . '<div class="suppr"><img src="../assets/trash.svg"></img></div></div>';
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