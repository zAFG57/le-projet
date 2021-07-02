<?php session_start(); ?>
<?php include_once('../templates/nav.php'); ?>
<?php 
    $json = 'modify';
    require('../templates/lang.php');
    $title = $parsed_lang->{'a'}; $css = "modifyProfile.css";
?>
<?php ob_start(); ?>

<header>
            <?= $nav?>  
</header>




<?php ob_start();?>  
<!--///////////////////////////////////////début du nom ////////////////////////////  -->
    <div class="form">
            <h1><?=$parsed_lang->{'d'};?></h1>
            <form id="form">
            <div class="txtfield">
                <input name="nom" required autofocus />
                <span></span>
                <label><?=$parsed_lang->{'e'};?></label>
            </div>
        

        <div class="btndiv">
                <div class="anuler"><?=$parsed_lang->{'c'};?></div>
                <div id="subbmit"><?=$parsed_lang->{'b'};?></div>
            </div>  

        </form>
    </div>
<!--///////////////////////////////////////fin du nom ////////////////////////////  -->
<?php $nom = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début du mail ////////////////////////////  -->
    <div class="form">
        
        <h1><?=$parsed_lang->{'f'};?></h1>
        <form id="form">
            <div class="txtfield">
                <input name="mail" required autofocus />
                <span></span>
                <label><?=$parsed_lang->{'g'};?></label>
            </div>
            <div class="txtfield">
                <input name="mailb" required autofocus />
                <span></span>
                <label><?=$parsed_lang->{'gb'}; ?></label>
            </div>

        <div class="btndiv">
                <div class="anuler"><?=$parsed_lang->{'c'};?></div>
                <div id="subbmit"><?=$parsed_lang->{'b'};?></div>
            </div>  

        </form>
    </div>
<!--///////////////////////////////////////fin du mail ////////////////////////////  -->
<?php $mail = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début du mdp ////////////////////////////  -->
    <div class="form">
        
        <h1><?=$parsed_lang->{'h'};?></h1>
        <form id="form">
            <div class="txtfield">
                <input name="amdp"  required autofocus />
                <span></span>
                <label><?=$parsed_lang->{'i'};?></label>
            </div> 
            <div class="txtfield">
                <input name="mdp"  required autofocus />
                <span></span>
                <label><?=$parsed_lang->{'ib'};?></label>
            </div> 
            <div class="txtfield">
                <input name="mdpb"  required autofocus />
                <span></span>
                <label><?=$parsed_lang->{'ic'};?></label>
            </div> 

            <div id="errs"></div>

            <div class="btndiv">
                <div class="anuler"><?=$parsed_lang->{'c'};?></div>
                <div id="subbmit"><?=$parsed_lang->{'b'};?></div>
            </div>  

        </form>
    </div>
<!--///////////////////////////////////////fin du mdp ////////////////////////////  -->
<?php $mdp = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début de la bio ////////////////////////////  -->
        <div class="form n">
            <h1><?=$parsed_lang->{'j'};?></h1>
            <form id="form">
            <div class="txtfieldn">
                <textarea id="bio" name="bio" placeholder="<?=$parsed_lang->{'k'};?>" onkeydown="resizetextarea()"></textarea>
            </div>

            <div class="btndiv">
                <div class="anuler"><?=$parsed_lang->{'c'};?></div>
                <div id="subbmit"><?=$parsed_lang->{'b'};?></div>
            </div>  

        </form>
    </div>
<!--///////////////////////////////////////fin de la bio ////////////////////////////  -->
<?php $bio = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début de la photo ////////////////////////////  -->
    <div class="form n">
            <h1><?=$parsed_lang->{'l'};?></h1>
        <form id="form">
            <div class="photodiv">    
                <h1 class="labelphoto" id="hun"><?=$parsed_lang->{'m'};?></h1>
                <label for="photo" class="labelphoto" id="labelphoto"></label>
                <input type="file" accept="image/png" onchange="loadFile(event)" class="photoinput" id="photo" style="display: none">
                <img id="output" class="labelphoto"/>
            </div>
            <div class="btndiv">
                <div class="anuler"><?=$parsed_lang->{'c'};?></div>
                <div id="subbmit"><?=$parsed_lang->{'b'};?></div>
            </div>  

        </form>
    </div>
<!--///////////////////////////////////////fin de la photo ////////////////////////////  -->
<?php $photo = ob_get_clean();?>




<?php ob_start();?>  
    <div class="navedit">
    
        <div class="éditbtn" onclick="window.location= './modifyProfile.php?edit=nom'"><?=$parsed_lang->{'n'};?></div>
        <div class="éditbtn" onclick="window.location= './modifyProfile.php?edit=mail'"><?=$parsed_lang->{'o'};?></div>
        <div class="éditbtn" onclick="window.location= './modifyProfile.php?edit=mdp'"><?=$parsed_lang->{'p'};?></div>
        <div class="éditbtn" onclick="window.location= './modifyProfile.php?edit=bio'"><?=$parsed_lang->{'q'};?></div>
        <div class="éditbtn" onclick="window.location= './modifyProfile.php?edit=photo'"><?=$parsed_lang->{'r'};?></div>
    
    </div>
<?php $editpiaf = ob_get_clean();?>













 <?php
    if (isset($_GET['edit'])) {
        if($_GET['edit'] === 'nom') {
            echo $nom;
        } elseif ($_GET['edit'] === 'mail') {
            echo $mail;
        } elseif ($_GET['edit'] === 'mdp') {
            echo $mdp;
        } elseif ($_GET['edit'] === 'bio') {
            echo $bio;
        } elseif ($_GET['edit'] === 'photo') {
            echo $photo;
        } else {
            echo '</br></br></br></br></br></br></br></br></br>il y a un problème';
        }

        echo $editpiaf ;

    } else {
        echo '</br></br></br></br></br></br></br></br></br>il y a un problème';
    }



?>



<script src="../public/js/script.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>




<script>
    function resizetextarea() {
        document.getElementById('bio').style.height = document.getElementById('bio').scrollHeight + "px";
    }

    var loadFile = function(event) {
        var output = document.getElementById('output');
        if (event.target.files[0].type === 'image/png') {
            output.src = URL.createObjectURL(event.target.files[0]);
        } else if (event.target.files[0].type === 'image/jpg') {
            output.src = URL.createObjectURL(event.target.files[0]);
        } else if (event.target.files[0].type === 'image/jpeg') {
            output.src = URL.createObjectURL(event.target.files[0]);
        } else {
            console.log(event.target.files[0].type);
        }
        output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
        }
    };


</script>