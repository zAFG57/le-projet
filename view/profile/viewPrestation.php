<?php include_once '../templates/nav.php'; ?>

<?php 
    $title = $user['username'] . " profile" ;
    $css ="viewPrestation.css" ;
    $json = 'viewproprofile';
    // require('../templates/lang.php');
    include_once __DIR__. '/../../templates/lang.php';
    include_once __DIR__ . '/../../controlleur/serviceManager.php';
    use \Controller\ControllerService;
    $presta = ControllerService::showAllServices(htmlspecialchars($_GET['user']), false);
?>

<?php ob_start(); ?>

    <header>
        <?= $nav ?>
    </header>

  
    
    <div class="main">



        <div class="nom">
            <h1>
                <?php echo $user['username'] ?>
            </h1>
        </div>
        
        <div class="container">
            
            <?php
            foreach ($presta as $service) {
                ?>
                    <section onclick="window.location='profile.php?user=<?=$service['user_id']?>&presta=0'"><div class="titre"><?=$service['title']?></div><div class="desc"><?=$service['description']?></div></section>
                <?php
            }
            ?> 
            
        </div>
        
    </div>
    
    <div class="scrolltop" onclick="main.scrollTop = 0;"><div></div></div>
    
    
    <script>
    var main = document.getElementsByClassName('container')[0];
    </script>
    <script src="../public/js/script.js"></script>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>