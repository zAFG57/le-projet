<?php 

    require_once('../model/csrfConfig.php');

    class ControllerCsrf extends Csrf {
        public static function createCsrfToken() {
            return parent::createToken();
        }

        public static function validateCsrfToken() {
            return parent::createToken();
        }
    }