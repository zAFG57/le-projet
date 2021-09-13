<?php 
    namespace Request;
    
    use \Model\Logout;
    use \Model\Csrf;

    include_once __DIR__ . '/../model/logout.php';

    class LogoutRequest extends Logout {

        public static function logoutUser($csrfToken) {
            session_start();
            if(isset($csrfToken) && Csrf::validateToken($csrfToken)){ 
                Logout::unsetVariables();
                return 0;
            } else {
                return 1;
            }
        }
       
    }

    if(isset($_POST['csrf_token'])) {
        echo json_encode(LogoutRequest::logoutUser($_POST['csrf_token']));
    }

    