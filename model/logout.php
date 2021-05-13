<?php 

    require_once('csrfConfig.php');

    class Logout extends Csrf{
        protected static function unSetVariables() {
            unset($_SESSION['userID'], $_SESSION['loggedin']);
            // session_destroy();
        }
    }