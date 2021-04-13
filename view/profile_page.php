<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>
<?php include_once('../model/connection.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='profile'");
}
?>

<?php $title = "My Profile"; $css = "profile.css"?>
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>
    

<?php 
$profiluser = getInfoUser();
if (isPro()) { ?>

    <div class="bvn">
        <h1> bienvenue <span><?= $profiluser['username'] ?></span></h1>
    </div>

    <div class="mainpro">

        <form> 

            <div class="titreprofilepro">
                <div class="proimg"><img src="<?= $profiluser['photolien']?>"></div>
            
                <input id="proinpt" class="namein" name="name" value="<?= $profiluser['username'] ?>">
                <div id="prodiv" class="namepro" ondblclick="nameédit()">
                    <h1><?= $profiluser['username'] ?></h1>
                </div>
            
            </div>
                

                <input id="proinpt" class="bioin" name="bio" value="<?= $profiluser['bio'] ?>">
                <div id="prodiv" class="biopro" ondblclick="bioédit()">
                    <h1><?= $profiluser['bio'] ?></h1>
                </div>           

                
                <input id="proinpt" class="emailin" name="email" value="<?= $profiluser['email'] ?>">
                <div id="prodiv" class="emailpro" ondblclick="emailédit()">
                    <h1><?= $profiluser['email'] ?></h1>
                </div>
                
                
                <input id="proinpt" class="réparationin" name="objets_reparables" value="<?= $profiluser['objets_reparables'] ?>">
                <div id="prodiv" class="réparationpro" ondblclick="réparationédit()">
                    <h1><?= $profiluser['objets_reparables'] ?></h1>
                </div>
                
        
        
        </form>
    
    </div>

    







<?php } else {?>

        <div class="main">

            <div class="haut">  
                <div class="photo"></div>
                <h1> $nom du useur </h1>
            </div>

            <div class="bas">

                <div class="email"><h1>$email du user</h1></div>
                <div class="mdp"><h1>des petit point en mode mdp secret</h1></div>

                <div class="changer">
                    <div class="changeremail"><h1>changer de mdp</h1></div>
                    <div class="changermdp"><h1>changer l'email</h1></div>
                </div>

            </div>

        </div>

<?php } ?>





<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
