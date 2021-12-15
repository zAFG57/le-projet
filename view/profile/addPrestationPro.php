<?php 
    use Model\Lang;

    include_once __DIR__ . '/../../templates/nav.php';
    include_once __DIR__ . '/../../model/lang.php';

    $title = "add Service"; $css = "addService.css";

    $lang = new Lang((isset($_GET['l'])) ? $_GET['l'] : ((isset($_SESSION['l'])) ? $_SESSION['l'] : null));

    ob_start();
?>

<header>
    <?=$nav?>
</header>
        
<div class="progression">

    <div id="1" class="étape active"><?=  $lang->getFile()['addPrestationPro']['catégorie_du_service']?></div>
    <div id="2" class="étape"><?=  $lang->getFile()['addPrestationPro']['titre_et_description']?></div>
    <div id="3" class="étape fin"><?=  $lang->getFile()['addPrestationPro']['doccument_légaux']?></div>

</div>

<form id="addServiceForm" enctype="multipart/form-data">
    <div class="main" id="catsouscat">
        <div class="cat">
            <div class="maintxt"><?=  $lang->getFile()['addPrestationPro']['vous_pouvez_réparer']?></div>
            <div class="select">
                <select class="catégory" id="catégory" name="domain">
                <option value=""><?=  $lang->getFile()['addPrestationPro']['category']?></option>
                    <option value="telephone"><?=  $lang->getFile()['addPrestationPro']['téléphones']?></option>
                    <option value="ordinateur"><?=  $lang->getFile()['addPrestationPro']['ordinateurs']?></option>
                    <option value="electro menager"><?=  $lang->getFile()['addPrestationPro']['éléctro ménager']?></option>
                </select>
            </div>
        </div>
        <div class="souscatdiv">
            <div class="maintxt"><?=  $lang->getFile()['addPrestationPro']['plus_particulièrement']?></div>
            <div class="select" id="souscatjs">
                <select class="sous-cat" id="tel" name="subdomain">
                    <option value=""><?=  $lang->getFile()['addPrestationPro']['sous_catégorie']?></option>
                </select>
                
            </div>
        </div>
        <div class="suivant" onclick="document.getElementById('catsouscat').style.display= 'none';document.getElementById('2').classList.add('active');">
            <?=  $lang->getFile()['addPrestationPro']['suivant']?>
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="titreDescription">


            <input name="title" placeholder="<?=  $lang->getFile()['addPrestationPro']['votre_titre']?>" class="titre">

            <textarea name="description" class="description" placeholder="<?=  $lang->getFile()['addPrestationPro']['votre_description']?>"></textarea>


        <div class="suivant" onclick="document.getElementById('titreDescription').style.display= 'none';document.getElementById('3').classList.add('active');">
            <?=  $lang->getFile()['addPrestationPro']['suivant']?>
        </div>
    </div>


<!--   ////////////////////////////////////////////////////////////////////////// -->

    <div class="main" id="documentlégeaux">


        <input name="doccumentsLegeaux" class="doccument" type="file" id="file" >
        <label for="file"><?=  $lang->getFile()['addPrestationPro']['déposer_votre_cb']?></label>




        <div id="err"></div>
        <div class="suivant" onclick="newPrestation()">
            <?= $lang->getFile()['addPrestationPro']['enregister']?>
        </div>
    </div>

<form>



<script src="../public/js/script.js"></script>
<script>changeComboBoxValues()</script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>



