<?php session_start() ?>
<?php include_once('../templates/nav.php'); ?>

<?php 
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='réparation'");
}
?>
 
<?php $title = "mesréparation.com"; $css = "home.css"?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <!-- cette feuille css est la juste pour la forme de loupe dans le button ... -->
<?php ob_start(); ?>

    <header>
        <?=$nav?>
    </header>

    <div class="content">
        <form id="search">
            <input type="text" class="search__input" placeholder="produit à réparer" name="search" required onkeydown="if(event.key === 'Enter'){event.preventDefault();searchf();}">
            <button type="button" class="search__submit" onclick="searchf();" value=""><i class="fas fa-search"></i></button>
        </form>
    </div>

    <section class="maindiv">
        <div class="hover"> 
            <div onclick="window.location.href='../index?location=homePage';" class="électroménager">  <h1>électroménager</h1> <img class="img" src="../assets/électroménager.svg"/> </div>
            <div onclick="window.location.href='../index?location=homePage';" class="ordinateur">      <h1>ordinateur    </h1> <img class="img" src="../assets/ordinateur2.svg"/>    </div>
            <div onclick="window.location.href='../index?location=homePage';" class="téléphone">       <h1>téléphone     </h1> <img class="img" src="../assets/télephone.svg"/>      </div>
        </div>
    </section>

    
    
    <div id="resSearch">
        <div class="grid">



            <div class="card">
                <div class="cardgauche">
                    <div class="cardimg">   <img src="https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200009.jpg"/>  </div>
                </div>
                <div class="carddroit">
                    <div class="cardnom"><h1>ludovic castigliaa</h1></div>
                    <div class="cardétoile">★★★★</div>
                    <div class="carddescription"><h3>je suis un agriculteur qui amie niquer avec des vache et au fait j'ai le coronassssssssssssssssssssss aaaaaaaa aaaaaaa aaa fffff</h3></div>
                </div>
            </div>

            <div class="card">
                <div class="cardgauche">
                    <div class="cardimg">   <img src="https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200009.jpg"/>  </div>
                </div>
                <div class="carddroit">
                    <div class="cardnom"><h1>ludovic castigliaa</h1></div>
                    <div class="cardétoile">★★★★</div>
                    <div class="carddescription"><h3>je suis un agriculteur qui amie niquer avec des vache et au fait j'ai le coronassssssssssssssssssssss aaaaaaaa aaaaaaa aaa fffff</h3></div>
                </div>
            </div>

            <div class="card">
                <div class="cardgauche">
                    <div class="cardimg">   <img src="https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200009.jpg"/>  </div>
                </div>
                <div class="carddroit">
                    <div class="cardnom"><h1>ludovic castigliaa</h1></div>
                    <div class="cardétoile">★★★★</div>
                    <div class="carddescription"><h3>je suis un agriculteur qui amie niquer avec des vache et au fait j'ai le coronassssssssssssssssssssss aaaaaaaa aaaaaaa aaa fffff</h3></div>
                </div>
            </div>

            <div class="card">
                <div class="cardgauche">
                    <div class="cardimg">   <img src="https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200009.jpg"/>  </div>
                </div>
                <div class="carddroit">
                    <div class="cardnom"><h1>ludovic castigliaa</h1></div>
                    <div class="cardétoile">★★★★</div>
                    <div class="carddescription"><h3>je suis un agriculteur qui amie niquer avec des vache et au fait j'ai le coronassssssssssssssssssssss aaaaaaaa aaaaaaa aaa fffff</h3></div>
                </div>
            </div>




        </div>
    </div>

    
    
    








<?php $content = ob_get_clean(); ?>

<?php require('../templates/baseTemplate.php'); ?>

