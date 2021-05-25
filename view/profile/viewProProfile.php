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
            <p>
                description <?php echo $user['id'] ?>
            </p>
        </div>


        <div class="btndiv">
            <div class="btn présta"><?=  $parsed_lang->{'préstation'}?></div>
            <div class="btn contact" onclick="window.location ='./chat?proID=<?=$user['id']?>'"><?=  $parsed_lang->{'contact'}?></div>
        </div>

    </div>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
