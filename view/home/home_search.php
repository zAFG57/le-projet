<?php 
    use \controller\ControllerSearch;
    include_once '../controller/search.php';
    include_once '../templates/nav.php';

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
        if (empty($resultSearch)) {
            var_dump(ControllerSearch::getNearestService($_GET['query'], 3, ''));
            foreach (ControllerSearch::getNearestService($_GET['query'], 1) as $key) { ?>
                <div class="noResFound"><?=$key[1]?></div>
                
                <?php }
            ?>
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