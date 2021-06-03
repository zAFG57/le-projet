<?php 
    namespace Model;

    include_once  __DIR__ . '/csrfConfig.php';

    class Logout extends Csrf{
        protected static function unSetVariables() {
            unset($_SESSION['userID'], $_SESSION['loggedin']);
            // session_destroy();
        }
    }