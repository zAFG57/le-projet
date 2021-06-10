<?php 
    namespace Controller;

    use \Model\Connection;

    include_once __DIR__ . '/../model/connection.php';

    class ControllerConnection extends Connection {
        public static function createConnectionToken($connectionHahs) {
            return parent::createToken($connectionHahs);
        }

        public static function validateConnectionToken($token, $connectionHahs) {
            return parent::validateToken($token, $connectionHahs);
        }
    }