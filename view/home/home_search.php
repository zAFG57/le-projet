<?php 
    use \controller\ControllerSearch;
    include_once __DIR__ . '/../../controller/search.php';
    include_once __DIR__ . '/../../templates/nav.php';

    if (!empty($_GET['query'])) {
        $resultSearch = ControllerSearch::searchService(htmlspecialchars($_GET['query']), (isset($_GET['page']) && intval($_GET['page']) && intval($_GET['page']) > 0) ? intval($_GET['page']) : 1, (isset($_GET['filter'])) ? $_GET['filter'] : '');
        $title = "Recherche - " . $_GET['query']; $css = "home.css";
        ob_start(); 
        ?>

        <header>
            <?=$nav?>
        </header>
        <div class="content">
            <form id="search">
                <input type="text" class="search__input" placeholder="object à réparer" required onkeydown="if(event.key === 'Enter'){event.preventDefault();searchf();}">
                <button type="button" class="search__submit" onclick="searchf();"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <?php
        if (empty($resultSearch)) {?>
            <div class="résultatproche"><h1>les trois résultats les plus proches sont:</h1><div><?php
            foreach (ControllerSearch::getNearestService($_GET['query'], 3) as $key) { ?>
                <div class="résultatprochebtn" onclick="window.location='./home.php?query=<?=$key[1]?>'"><?=$key[1]?></div>
                
                <?php }
            ?>
                </div></div>
            <?php 
        } else {
            ?> <div id="resSearch">
                    <div class="grid">
            <?php
            foreach ($resultSearch as $service) {
                ?>
                    <div class="card" onclick="window.location = './profile.php?user=' + <?=$service['user_id']?>">
                        <div class="cardgauche">
                            <div class="cardimg"><img src="<?= isset($service['userProfilePicture']) ? $service['userProfilePicture'] : 'https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200009.jpg'?>"/>  </div>
                        </div>
                        <div class="carddroit">
                            <div class="cardnom"><h1><?=$service['username']?></h1></div>
                            <div class="cardétoile"><?=ControllerSearch::createStars($service['note'])?></div>
                            <div class="carddescription"><h3><?=$service['description']?></h3></div>
                        </div>
                    </div>
                <?php
            }
            ?> 
                    </div>
                </div>
            <?php
        }
    }

    $content = ob_get_clean(); 

    require('../templates/baseTemplate.php'); 