<?php 

    require_once('../model/logout.php');
    require_once('csrfConfig.php');

    session_start();

    class ControllerLogout extends Logout {
        public static function logoutUser() {
            if(isset($_POST['csrf_token']) && ControllerCsrf::validateCsrfToken($_POST['csrf_token'])){ 
                parent::unSetVariables();
                return 0;
            } else {
                return 1;
            }
        }
       
    }

    if(isset($_POST['csrf_token'])) {
        echo json_encode(ControllerLogout::logoutUser());
    }

    
  
    