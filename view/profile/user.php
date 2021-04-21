<?php include_once('../templates/nav.php'); ?>

<?php $title = "My Profile"; $css = "profile.css";?>
<?php ob_start(); ?>


    <header>
        <?= $nav ?>
    </header>



<form id="modifprofile">
    <div class="haut">
        <div class="form">
            <input class="namein" value="<?= $user['username'] ?>" readonly />
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
                    <input class="mailin" value="<?= $user['email'] ?>" readonly>
                    <div class="modifier mailsub"><img src="../assets/edit.svg"/></div>
                </div>

            </div>

            <div class="password">

                <div class="form">

                    <input class="passwordin" value="<?= $user['username'] ?>" readonly>
                    <div class="modifier mailsub"><img src="../assets/edit.svg"/></div>

                </div>
            </div>  
            
            <div id="subbmit">
                <h1>enregistrer</h1>
            </div>
            <div id="err"></div>

        </div>

    </div>
</form>



<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
