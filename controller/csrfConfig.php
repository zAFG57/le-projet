<?php 
    namespace Controller;

    use \Model\Csrf;

<<<<<<< HEAD
    include_once __DIR__ . '/../model/csrfConfig.php';
=======
    include_once '../model/csrfConfig.php';
>>>>>>> origin/main

    class ControllerCsrf extends Csrf {
        public static function createCsrfToken() {
            return parent::createToken();
        }

<<<<<<< HEAD
        public static function validateCsrfToken($token) {
            return parent::validateToken($token);
=======
        public static function validateCsrfToken() {
            return parent::createToken();
>>>>>>> origin/main
        }
    }