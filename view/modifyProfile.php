<?php 
    use Model\Lang;


    include_once __DIR__ . '/../templates/nav.php';

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    $title = $lang->getFile()['modify']['a']; $css = "modifyProfile.css";
?>
<?php ob_start(); ?>

<header>
    <?= $nav?>  
</header>



<?php ob_start();?>  
<!--///////////////////////////////////////début du nom ////////////////////////////  -->
    <div class="form">
            <h1><?=$lang->getFile()['modify']['d'];?></h1>
            <form id="form">
            <div class="formdiv">
            <div class="txtfield">
                <input name="mdp" required autofocus />
                <span></span>
                <label><?=$lang->getFile()['modify']['e'];?></label>
            </div>
        

            <div class="btndiv">
                <div class="anuler" onclick="window.location = window.location"><?=$lang->getFile()['modify']['c'];?></div>
                <div id="subbmit" onclick="mdpspawn();"><?=$lang->getFile()['modify']['b'];?></div>
            </div>  
            
        </div>
    </div>
<!--///////////////////////////////////////fin du nom ////////////////////////////  -->
<?php $nom = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début du mail ////////////////////////////  -->
    <div class="form">
        
        <h1><?=$lang->getFile()['modify']['f'];?></h1>
        <form id="form">
        <div class="formdiv">
            <div class="txtfield">
                <input name="mail" required autofocus />
                <span></span>
                <label><?=$lang->getFile()['modify']['g'];?></label>
            </div>
            <div class="txtfield">
                <input name="mailb" required autofocus />
                <span></span>
                <label><?=$lang->getFile()['modify']['gb']; ?></label>
            </div>

        <div class="btndiv">
                <div class="anuler" onclick="window.location = window.location"><?=$lang->getFile()['modify']['c'];?></div>
                <div id="subbmit" onclick="mdpspawn();"><?=$lang->getFile()['modify']['b'];?></div>
            </div>  
        </div>
    </div>
<!--///////////////////////////////////////fin du mail ////////////////////////////  -->
<?php $mail = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début du mdp ////////////////////////////  -->
    <div class="form">
        
        <h1><?=$lang->getFile()['modify']['h'];?></h1>
        <form id="form">
        <div class="formdiv">
            <div class="txtfield">
                <input name="mdp"  required autofocus />
                <span></span>
                <label><?=$lang->getFile()['modify']['ib'];?></label>
            </div> 
            <div class="txtfield">
                <input name="mdpb"  required autofocus />
                <span></span>
                <label><?=$lang->getFile()['modify']['ic'];?></label>
            </div> 

            <div id="errs"></div>

            <div class="btndiv">
                <div class="anuler" onclick="window.location = window.location"><?=$lang->getFile()['modify']['c'];?></div>
                <div id="subbmit" onclick="mdpspawn();"><?=$lang->getFile()['modify']['b'];?></div>
            </div>  
        </div>
    </div>
<!--///////////////////////////////////////fin du mdp ////////////////////////////  -->
<?php $mdp = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début de la bio ////////////////////////////  -->
        <div class="form n">
            <h1><?=$lang->getFile()['modify']['j'];?></h1>
            <form id="form">
            <div class="formdiv">
            <div class="txtfieldn">
                <textarea id="bio" name="bio" placeholder="<?=$lang->getFile()['modify']['k'];?>" onkeydown="resizetextarea()"></textarea>
            </div>

            <div class="btndiv">
                <div class="anuler" onclick="window.location = window.location"><?=$lang->getFile()['modify']['c'];?></div>
                <div id="subbmit" onclick="mdpspawn();"><?=$lang->getFile()['modify']['b'];?></div>
            </div>  
        </div>
    </div>
<!--///////////////////////////////////////fin de la bio ////////////////////////////  -->
<?php $bio = ob_get_clean();?>




<?php ob_start();?>  
<!--///////////////////////////////////////début de la photo ////////////////////////////  -->
    <div class="form n">
            <h1><?=$lang->getFile()['modify']['l'];?></h1>
        <form id="form">
        <div class="formdiv">
            <div class="photodiv">    
                <h1 class="labelphoto" id="hun"><?=$lang->getFile()['modify']['m'];?></h1>
                <label for="photo" class="labelphoto" id="labelphoto"></label>
                <input type="file" accept="image/png" onchange="loadFile(event)" class="photoinput" id="photo" style="display: none">
                <img id="output" class="labelphoto"/>
            </div>
            <div class="btndiv">
                <div class="anuler" onclick="window.location = window.location"><?=$lang->getFile()['modify']['c'];?></div>
                <div id="subbmit" onclick="mdpspawn();"><?=$lang->getFile()['modify']['b'];?></div>
            </div>      
        </div>
    </div>
<!--///////////////////////////////////////fin de la photo ////////////////////////////  -->
<?php $photo = ob_get_clean();?>




 <?php
    if (isset($_GET['edit'])) {
        if(isset($_GET['user']) && isset($_GET['action']) && $_GET['edit'] === 'nom') {
            echo $nom;
            $type = 'username';
        } elseif (isset($_GET['user']) && isset($_GET['action']) && $_GET['edit'] === 'mail') {
            echo $mail;
            $type = 'email';
        } elseif (isset($_GET['user']) && isset($_GET['action']) && $_GET['edit'] === 'mdp') {
            echo $mdp;
            $type = 'password';
        } elseif (isset($_GET['user']) && isset($_GET['action']) && $_GET['edit'] === 'bio') {
            echo $bio;
            $type = 'bio';
        } elseif (isset($_GET['user']) && isset($_GET['action']) && $_GET['edit'] === 'photo') {
            echo $photo;
            $type = 'profile_picture';
        } else {
            header("Location: ../../");
        }


        ob_start();?>  
        <div class="navbtn" onclick="éditbtnnav()">
            <img src="../assets/retour.svg">
        </div>
        <div class="navedit">
        
            <div class="éditbtn" onclick="change('nom')"><?=$lang->getFile()['modify']['n'];?></div>
            <div class="éditbtn" onclick="change('mail')"><?=$lang->getFile()['modify']['o'];?></div>
            <div class="éditbtn" onclick="change('mdp')"><?=$lang->getFile()['modify']['p'];?></div>
            <div class="éditbtn" onclick="change('bio')"><?=$lang->getFile()['modify']['q'];?></div>
            <div class="éditbtn" onclick="change('photo')"><?=$lang->getFile()['modify']['r'];?></div>
        
        </div>
    
        <div id="fond"></div>
        <div class="form" id="mdp">
                <h1><?=$lang->getFile()['modify']['s'];?></h1>

                <div class="formdiv">
                
                <div class="txtfield">
                    <input name="mdp" required autofocus />
                    <span></span>
                    <label><?=$lang->getFile()['modify']['t'];?></label>
                </div>
            
    
                <div class="btndiv">
                    <div class="anuler" onclick="window.location = window.location"><?=$lang->getFile()['modify']['c'];?></div>
                    <div id="subbmit" onclick="uploaddata('<?php echo $type ?>');"><?=$lang->getFile()['modify']['b'];?></div>
                </div> 
                </form>
            </div>
        </div>
    
        <?php $editpiaf = ob_get_clean();



        echo $editpiaf ;

    } else {
        header("Location: ../../");
    }



?>



<script src="../public/js/script.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('../templates/baseTemplate.php'); ?>




<script>
    function change(c) {
        var queryParams = new URLSearchParams(window.location.search);
        queryParams.set("edit", c);
        history.replaceState(null, null, "?" + queryParams.toString());
        window.location = window.location;
    }
    a = true;
    function éditbtnnav() {

        
        for (let i = 0; i < document.getElementsByClassName('éditbtn').length; i++) {
            document.getElementsByClassName('éditbtn')[i].style.transform = (a) ? 'translateX(var(--left))' : 'translateX(0vw)'
            document.getElementsByClassName('navbtn')[0].style.transform = (a) ? 'translateX(calc(var(--left) - var(--cent))) rotate(180deg)' : 'translateX(0vw) rotate(0deg)'
            document.getElementsByClassName('navbtn')[0].style.borderBottomRightRadius = (a) ? '0px' : '50px'
            document.getElementsByClassName('navbtn')[0].style.borderTopLeftRadius = (a) ? '50px' : '0px'
        }
        a = !a;

            

    }



    function resizetextarea() {
        document.getElementById('bio').style.height = document.getElementById('bio').scrollHeight + "px";
        document.getElementById('mdp').style.height = document.getElementById('bio').scrollHeight + "px";
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

    
    
    function uploaddata (type) {

        //userID // password // type // contenu

        form = document.getElementById('form');

        userID = <?= $_SESSION['userID']?>;
        console.table(type , userID);
        console.table(form);

        request('../controller/user.php', "#form", setloader = true, function(data) {
            window.location = window.location;
        })
    }


    function mdpspawn () {
        mdp = document.getElementById('mdp');
        fond = document.getElementById('fond');
        fond.style.zIndex = '15';
        mdp.style.zIndex = '15';
        fond.classList.add('opacity');
        mdp.classList.add('opacity');
    }

</script>