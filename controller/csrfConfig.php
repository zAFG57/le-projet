<?php 
    namespace Controller;

    use \Model\Csrf;

    include_once '../model/csrfConfig.php';

    class ControllerCsrf extends Csrf {
        public static function createCsrfToken() {
            return parent::createToken();
        }

        public static function validateCsrfToken() {
            return parent::createToken();
        }
    }