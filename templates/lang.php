<?php 
    // use \Controller\Csrf;
    include_once "../model/csrfConfig.php";
?>
<?php
    
    if (isset($_GET['l']) && htmlspecialchars($_GET['l']) === 'en') {
        $chemin = '../public/js/langue/en/';
        $_SESSION['l'] = htmlspecialchars($_GET['l']);
    } elseif (isset($_GET['l']) && htmlspecialchars($_GET['l']) === 'fr') {
        $_SESSION['l'] = htmlspecialchars($_GET['l']);
    } elseif (!isset($_GET['l']) && !isset( $_SESSION['l'])) {
        $_SESSION['l'] = 'fr';
    }
    
    $chemin = __DIR__ . '/../public/js/langue/'. htmlspecialchars($_SESSION['l']) .'/';





    if ($json)  {
        $parsed_lang = json_decode(file_get_contents($chemin . $json . ".json"));
    }

