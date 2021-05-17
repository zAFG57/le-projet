<?php 
    include_once '../templates/nav.php';
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

<form id="addFerviceForm" enctype="multipart/form-data">
    <div class="main" id="catsouscat">
        <div class="cat">
            <div class="maintxt">vous pouvez réparer:</div>
            <div class="select">
                <select class="catégory" id="catégory" name="domain">
                <option value="">--catégory--</option>
                    <option value="telephone"> des téléphones</option>
                    <option value="ordinateur">des ordinateurs</option>
                    <option value="electro menager">de l'éléctro ménager</option>
                </select>
            </div>
        </div>
        <div class="souscatdiv">
            <div class="maintxt">plus particulièrement:</div>
            <div class="select" id="souscatjs">
                <select class="sous-cat" id="tel" name="subdomain">
                    <option value="">--sous catégorie--</option>
                </select>
                
            </div>
        </div>
        <div class="suivant" onclick="document.getElementById('catsouscat').style.display= 'none';document.getElementById('2').classList.add('active');">
            suivant
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="titreDescription">


            <input name="title" placeholder="votre titre" class="titre">

            <textarea name="description" class="description" placeholder="votre description"></textarea>


        <div class="suivant" onclick="document.getElementById('titreDescription').style.display= 'none';document.getElementById('3').classList.add('active');">
            suivant
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="documentlégeaux">


        <input name="doccumentsLegeaux" class="doccument" type="file" id="file" >
        <label for="file">clicker pour déposer votre jkbvdslbvs</label>




        <div id="err"></div>
        <div class="suivant" onclick="newPrestation()">
            Enregister
        </div>
    </div>

<form>



<script src="../public/js/script.js"></script>
<script>changeComboBoxValues()</script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>



