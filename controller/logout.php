<?php 
    namespace Controller;
    
    use \Model\Logout;

    include_once  __DIR__ . '/../model/logout.php';

    session_start();

    class ControllerLogout extends Logout {
        public static function logoutUser($csrfToken) {
            if(isset($csrfToken) && ControllerCsrf::validateCsrfToken($csrfToken)){ 
                parent::unSetVariables();
                return 0;
            } else {
                return 1;
            }
        }
       
    }

    if(isset($_POST['csrf_token'])) {
        echo json_encode(ControllerLogout::logoutUser(htmlspecialchars($_POST['csrf_token'])));
    }

    
  
    