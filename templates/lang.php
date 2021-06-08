<?php 
    use \Controller\ControllerCsrf;
    include_once "../controller/csrfConfig.php";    
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
    
    $chemin = '../public/js/langue/'. $_SESSION['l'] .'/';





    if ($json)  {
        $parsed_lang = json_decode(file_get_contents($chemin . $json . ".json"));
    }
?>

<script>
        console.log("'<?=  $json?>'");
        console.log("'<?=  $_SESSION['l']?>'")
</script>