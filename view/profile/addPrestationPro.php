<?php 

    include_once('../templates/nav.php');
 
?> 

<?php 
    $title = "add Service"; $css = "addService.css";
    ob_start();  
?>

<header>
    <?=$nav?>
</header>
        
<div class="progression">

    <div id="1" class="étape active">catégorie du service</div>
    <div id="2" class="étape">titre et description</div>
    <div id="3" class="étape fin">doccument légaux</div>

</div>

<form id="addFerviceForm">
    <div class="main" id="catsouscat">
        <div class="cat">
            <div class="maintxt">vous pouvez réparer:</div>
            <div class="select">
                <select class="catégory" id="catégory" name="category">
                <option value="">--catégory--</option>
                    <option value="téléphone"> des téléphones</option>
                    <option value="ordinateur">des ordinateurs</option>
                    <option value="cat">de l'éléctro ménager</option>
                </select>
            </div>
        </div>
        <div class="souscatdiv">
            <div class="maintxt">plus particulièrement:</div>
            <div class="select" id="souscatjs">
                <select class="sous-cat" id="tel" name="souscategory">
                    <option value="">--sous cathégorie--</option>
                    <option value="apple"> apple</option>
                    <option value="samsung">samsung</option>
                    <option value="oppo">oppo</option>
                    <option value="oneplus">oneplus</option>
                    <option value="huawei">huawei</option>
                    <option value="sony">sony</option>
                    <option value="xiaomi">xiaomi</option>
                    <option value="nokia">nokia</option>
                    <option value="honor">honor</option>
                    <option value="autre">autre</option>
                </select>
                
            </div>
        </div>
        <div class="suivant" onclick="document.getElementById('catsouscat').style.display= 'none';document.getElementById('2').classList.add('active');">
            suivant
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="titreDescription">


            <input name="titre" placeholder="votre titre" class="titre">

            <textarea name="description" class="description" placeholder="votre description"></textarea>


        <div class="suivant" onclick="document.getElementById('titreDescription').style.display= 'none';document.getElementById('3').classList.add('active');">
            suivant
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="documentlégeaux">


        <input name="doccumentsLegeaux" class="doccument" type="file" id="file" enctype="multipart/form-data">
        <label for="file">clicker pour déposer votre jkbvdslbvs</label>





        <div class="suivant" onclick="">
            enregister
        </div>
    </div>

<form>



<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>






