<?php 

    require_once('../model/user.php');

    class ControllerUser extends User {
        public static function getUserInfo($id) {
            if (is_int($id)) {
                return parent::getInfoUser($id);
            }
        }

        public static function userExisiting($id) {
            return parent::userExisting($id);
        }
        public static function isPro($id) {
            if (is_int($id)) {
                return parent::isPro($id);
            }
        }

        public static function isConnected() {
            return parent::isConnected();
        }

        public static function isAdmin($id) {
            if (is_int($id)) {
                return parent::isAdmin($id);
            }
        }

        public static function getUserName($id) {
            if (is_int($id)) {
                return parent::getUserName($id);
            }
        }

    }
    