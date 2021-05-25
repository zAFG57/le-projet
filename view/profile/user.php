<?php include_once '../templates/nav.php'; ?>

<?php $title = "My Profile"; $css = "profile.css";?>
<?php ob_start(); 
        $json = 'user';
        require('../templates/lang.php');
?>


    <header>
        <?= $nav ?>
    </header>

 

<form id="modifprofile">
    <div class="haut">
        <div class="form">
            <input class="namein" value="<?= $user['username'] ?>" readonly name="usernameChange" id="nameinputmodif"/>
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
                    <input class="mailin" value="<?= $user['email'] ?>" readonly name="emailChange" id="mailinputmodif">
                    <div class="modifier mailsub" onclick="modifyInputEmail()"><img src="../assets/edit.svg"/></div>
                </div>

            </div>

            <div class="password">

                <div class="form">

                    <input class="passwordin" type="password"value="defaultPassword" readonly name="passwordChange" id="passwordinputmodif">
                    <div class="modifier passsub" onclick="modifyInputpassword()"><img src="../assets/edit.svg"/></div>

                </div>
            </div>  

            <input type="password" class="mdpverif" id="passwordverify" name="passwordVerifyChange" placeholder="<?=  $parsed_lang->{'mdp'}?>" />
            <input type="hidden" value="<?= $user['id'] ?>" name="userIdChange"/>
            <div class="subanuler"> 

                <div class="anuler" onclick="anulermodif()">
                    <h1><?=  $parsed_lang->{'annuler'}?></h1>
                </div>  
                <div id="subbmit" onclick="modifyUser()">
                    <h1><?=  $parsed_lang->{'enregistrer'}?></h1>
                </div>
                
            </div>
            <div id="err"></div>

        </div>

    </div>
</form>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
