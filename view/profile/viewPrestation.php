<?php include_once '../templates/nav.php'; ?>

<?php 
    $title ="My Profile" ;
    $css ="viewProProfile.css" ;
    $json = 'viewproprofile';
    require('../templates/lang.php');
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
        
        <div class="description">
            <h1>il faudra faire en sort de display les préstation de la personne</h1>
        </div>

    </div>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>