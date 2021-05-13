<?php 

    require_once('../model/config.php');
    require_once('../model/panelAdmin.php');
    
    class ControllerAdmin extends Admin {
        public static function createAdminToken($id) {
            if (is_int($id)) {
                return parent::createAdminToken($id);
            }
        }

        public static function updateAdminToken($hash, $id) {
            if (is_int($id) && $hash !== "") {
                return parent::updateAdminToken($hash, $id);
            }
        }

        public static function validateAdminToken($token) {
            return parent::validateAdminToken($token); 
        }

        public static function getHashToken($id) {
            if (is_int($id)) {
                return parent::getHashToken($id); 
            }
        }

        public static function getUsersNum() {
            return parent::getUsersNum();  
        }

        public static function verifAll($userID, $hash) {
            return ControllerAdmin::validateAdminToken(ControllerAdmin::getHashToken($userID)) && password_verify(ControllerAdmin::getHashToken($userID), $hash);
        }
    }


