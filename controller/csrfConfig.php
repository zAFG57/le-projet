<?php 
    namespace Controller;

    use \Model\Csrf;

    include_once __DIR__ . '/../model/csrfConfig.php';

    class ControllerCsrf extends Csrf {
        public static function createCsrfToken() {
            return parent::createToken();
        }

        public static function validateCsrfToken($token) {
            return parent::validateToken($token);
        }
    }