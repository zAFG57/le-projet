<?php include_once('../templates/nav.php'); ?>

<?php $title = "My Profile"; $css = "profile.css";?>
<?php ob_start(); ?>


    <header>
        <?= $nav ?>
    </header>



<form id="modifprofile">
    <div class="haut">
        <div class="form">
            <input class="namein" value="<?= $user['username'] ?>" readonly name="usernameChange"/>
            <div class="modifier mailsub"><img src="../assets/edit.svg"/></div>
        </div>
    </div>
    <div class="main">

        <div class="gauchephoto">
            <!-- <img src="?< $user['profilePicture'] ?>">  -->
        </div>

        <div class="droitmailpass">

            <div class="mail">
                <div class="form">
                    <input class="mailin" value="<?= $user['email'] ?>" readonly name="emailChange">
                    <div class="modifier mailsub"><img src="../assets/edit.svg"/></div>
                </div>

            </div>

            <div class="password">

                <div class="form">

                    <input class="passwordin" value="defaultPassword" type="password" readonly name="passwordChange">
                    <div class="modifier mailsub"><img src="../assets/edit.svg"/></div>

                </div>
            </div>  

            <input type="password" class="mdpverif" id="passwordverify" name="passwordVerifyChange" placeholder="Mots de passe de vérification" />
            <input type="hidden" value="<?= $user['id'] ?>" name="userIdChange"/>
            <div class="subanuler">    
                <div id="subbmit">
                    <h1 onclick="modifyUser()">enregistrer</h1>
                </div>
                <div id="subbmit">
                    <h1>annuler</h1>
                </div>
            </div>
            <div id="err"></div>

        </div>

    </div>
</form>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
