<?php 
    include_once '../templates/nav.php';
?> 

<?php 
    $title = "add Service"; $css = "addService.css";
    ob_start();  
    $json = 'addPrestationPro';
    require('../templates/lang.php');
?>

<header>
    <?=$nav?>
</header>
        
<div class="progression">

    <div id="1" class="étape active"><?=  $parsed_lang->{'catégorie_du_service'}?></div>
    <div id="2" class="étape"><?=  $parsed_lang->{'titre_et_description'}?></div>
    <div id="3" class="étape fin"><?=  $parsed_lang->{'doccument_légaux'}?></div>

</div>

<form id="addFerviceForm" enctype="multipart/form-data">
    <div class="main" id="catsouscat">
        <div class="cat">
            <div class="maintxt"><?=  $parsed_lang->{'vous_pouvez_réparer'}?></div>
            <div class="select">
                <select class="catégory" id="catégory" name="domain">
                <option value=""><?=  $parsed_lang->{'category'}?></option>
                    <option value="telephone"><?=  $parsed_lang->{'téléphones'}?></option>
                    <option value="ordinateur"><?=  $parsed_lang->{'ordinateurs'}?></option>
                    <option value="electro menager"><?=  $parsed_lang->{'éléctro ménager'}?></option>
                </select>
            </div>
        </div>
        <div class="souscatdiv">
            <div class="maintxt"><?=  $parsed_lang->{'plus_particulièrement'}?></div>
            <div class="select" id="souscatjs">
                <select class="sous-cat" id="tel" name="subdomain">
                    <option value=""><?=  $parsed_lang->{'sous_catégorie'}?></option>
                </select>
                
            </div>
        </div>
        <div class="suivant" onclick="document.getElementById('catsouscat').style.display= 'none';document.getElementById('2').classList.add('active');">
            <?=  $parsed_lang->{'suivant'}?>
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="titreDescription">


            <input name="title" placeholder="<?=  $parsed_lang->{'votre_titre'}?>" class="titre">

            <textarea name="description" class="description" placeholder="<?=  $parsed_lang->{'votre_description'}?>"></textarea>


        <div class="suivant" onclick="document.getElementById('titreDescription').style.display= 'none';document.getElementById('3').classList.add('active');">
            <?=  $parsed_lang->{'suivant'}?>
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="documentlégeaux">


        <input name="doccumentsLegeaux" class="doccument" type="file" id="file" >
        <label for="file"><?=  $parsed_lang->{'déposer_votre_cb'}?></label>




        <div id="err"></div>
        <div class="suivant" onclick="newPrestation()">
            <?=  $parsed_lang->{'enregister'}?>
        </div>
    </div>

<form>



<script src="../public/js/script.js"></script>
<script>changeComboBoxValues()</script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>



