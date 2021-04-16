<?php 

    require_once('csrfConfig.php');

    class Logout extends Csrf{
        protected static function unSetVariables() {
            session_destroy();
        }
    }