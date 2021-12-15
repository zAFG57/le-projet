<?php 
    namespace Request;

    use Model\Csrf;

    include_once __DIR__ . '/../model/csrfConfig.php';
    // include_once __DIR__ . '/../model/config.php';
    include_once __DIR__ . '/../model/serviceManager.php';


    class CreateService extends \Model\ServiceManager {
        public static function createServiceRequest($csrf, $domain, $subDomain, $title, $description, $file){
            session_start();
            if(Csrf::validateToken($csrf)){
                return (new \Model\ServiceManager($_SESSION['userID']))->createService($domain, $subDomain, $title, $description, $file);
            }
        }
    }
    

    if ($_SERVER['REQUEST_METHOD'] && isset($_POST['domain']) && isset($_POST['subdomain']) && isset($_POST['title']) && isset($_POST['description']) && isset($_FILES['doccumentsLegeaux']) && isset($_POST['csrf_token'])) {
        echo json_encode(CreateService::createServiceRequest($_POST['csrf_token'], $_POST['domain'], $_POST['subdomain'], $_POST['title'], $_POST['description'], $_FILES['doccumentsLegeaux']));
    }