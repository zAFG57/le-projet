<?php 
    use Model\Lang;

    include_once __DIR__ . '/../../templates/nav.php';
    include_once __DIR__ . '/../../model/lang.php';
    // include_once __DIR__ . '/../../templates/lang.php';
    // include_once __DIR__ . '/../../controller/serviceManager.php';

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    $title = "My Profile"; $css = "profile.css";

    ob_start();
?>
    <header>
        <?= $nav ?>
    </header>

<form id="modifprofile">
    <div class="haut">
        <div class="form">
            <input class="namein" value="<?= $user->getUsername() ?>" readonly name="usernameChange" id="nameinputmodif"/>
            <div class="modifier namesub" onclick="modifyInputName()"><img src="../assets/edit.svg"/></div>
        </div>
    </div>
    <div class="main">

        <div class="gauchephoto">
            <!-- <img src="?< $user['profilePicture'] ?>">  -->
        </div>

        <div class="droitmailpass">

            <div class="mail">
                <div class="form">
                    <input class="mailin" value="<?= $user->getEmail() ?>" readonly name="emailChange" id="mailinputmodif">
                    <div class="modifier mailsub" onclick="modifyInputEmail()"><img src="../assets/edit.svg"/></div>
                </div>
            </div>

            <div class="password">

                <div class="form">

                    <input class="passwordin" type="password"value="defaultPassword" readonly name="passwordChange" id="passwordinputmodif">
                    <div class="modifier passsub" onclick="modifyInputpassword()"><img src="../assets/edit.svg"/></div>

                </div>
            </div>  

            <input type="password" class="mdpverif" id="passwordverify" name="passwordVerifyChange" placeholder="<?=  $lang->getFile()['user']['mdp']?>" />
            <input type="hidden" value="<?= $user->getUserID() ?>" name="userIdChange"/>
            <div class="subanuler"> 

                <div class="anuler" onclick="anulermodif()">
                    <h1><?= $lang->getFile()['user']['annuler']?></h1>
                </div>  
                <div id="subbmit" onclick="modifyUser()">
                    <h1><?=  $lang->getFile()['user']['enregistrer']?></h1>
                </div>
                
            </div>
            <div id="err"></div>

        </div>

    </div>
</form>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
