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

    <div class="étape active">catégorie du service</div>
    <div class="étape">mots cléf</div>
    <div class="étape">votre experience</div>
    <div class="étape">doccument légaux</div>
    <div class="étape">photo</div>
    <div class="étape fin">validation</div>

</div>

<div class="main">
    <div class="cat">
        <div class="maintxt">vous pouvez réparer:</div>
        <div class="select">
            <select class="catégory" id="catégory">
                <option value="téléphone"> des téléphones</option>
                <option value="ordinateur">des ordinateurs</option>
                <option value="cat">de l'éléctro ménager</option>
            </select>
        </div>
    </div>
    <div class="souscatdiv">
        <br/>
        <div class="maintxt">plus particulièrement:</div>
        <div class="select">
            <select class="sous-cat" id="sous-cat">
                <option value="téléphone"> des téléphones</option>
                <option value="ordinateur">des ordinateurs</option>
                <option value="cat">de l'éléctro ménager</option>
            </select>
        </div>
    </div>
</div>



<script src="../public/js/script.js"></script>
<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>
