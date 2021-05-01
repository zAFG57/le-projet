<?php include_once('../templates/nav.php'); ?>

<?php $title = "My Profile"; $css = "profile.css";?>
<?php ob_start(); ?>


    <header>
        <?= $nav ?>
    </header>

<<<<<<< HEAD

=======
 
>>>>>>> 0b928407031195a245d6cca033ab2201eee4f4fd

<form id="modifprofile">
    <div class="haut">
        <div class="form">
<<<<<<< HEAD
            <input class="namein" value="<?= $user['username'] ?>" readonly name="usernameChange"/>
            <div class="modifier mailsub"><img src="../assets/edit.svg"/></div>
=======
            <input class="namein" value="<?= $user['username'] ?>" readonly name="usernameChange" id="nameinputmodif"/>
            <div class="modifier namesub" onclick="modifyInputName()"><img src="../assets/edit.svg"/></div>
>>>>>>> 0b928407031195a245d6cca033ab2201eee4f4fd
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

            <input type="password" class="mdpverif" id="passwordverify" name="passwordVerifyChange" placeholder="Mots de passe de vérification" />
            <input type="hidden" value="<?= $user['id'] ?>" name="userIdChange"/>
            <div class="subanuler">    
                <div id="subbmit" onclick="modifyUser()">
                    <h1>enregistrer</h1>
                </div>
                <div id="subbmit" onclick="anulermodif()">
                    <h1>annuler</h1>
                </div>
            </div>
            <div id="err"></div>

        </div>

    </div>
</form>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
