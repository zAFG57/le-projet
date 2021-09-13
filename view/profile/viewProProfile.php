<?php 
    use Model\Lang;

    include_once __DIR__ .'/../../templates/nav.php';
    include_once __DIR__ . '/../../model/lang.php';

    $title ="My Profile"; $css ="viewProProfile.css" ;

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));
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
            <div class="btn présta" onclick="window.location ='./profile.php?user=<?=$user['id']?>&presta=1'"><?= $lang->getFile()['viewproprofile']['préstation']?></div>
            <div class="btn contact" onclick="window.location ='./chat.php?proID=<?=$user['id']?>'"><?= $lang->getFile()['viewproprofile']['contact']?></div>
        </div>

    </div>


<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
