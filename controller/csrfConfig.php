<?php 
    namespace Controller;

    use \Model\Csrf;

<<<<<<< HEAD
<<<<<<< HEAD
    include_once __DIR__ . '/../model/csrfConfig.php';
=======
    include_once '../model/csrfConfig.php';
>>>>>>> origin/main
=======
    include_once '../model/csrfConfig.php';
>>>>>>> origin/wtf-énorme-merge

    class ControllerCsrf extends Csrf {
        public static function createCsrfToken() {
            return parent::createToken();
        }

<<<<<<< HEAD
<<<<<<< HEAD
        public static function validateCsrfToken($token) {
            return parent::validateToken($token);
=======
        public static function validateCsrfToken() {
            return parent::createToken();
>>>>>>> origin/main
        }
=======
        public static function validateCsrfToken() {
            return parent::createToken();
        }
        //public static function validateCsrfToken($token) {
        //    return parent::validateToken($token);
        //}
>>>>>>> origin/wtf-énorme-merge
    }