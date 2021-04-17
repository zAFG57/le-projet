<?php 

    require_once('../model/chatProUser.php');

    class ControllerChatProUser extends ChatProUser {
        public static function newMessage($msg, $userID){
            return parent::newMessage($msg, $userID);
        }


        public static function getMessages(){
            return parent::getMessages();
        }

        public static function newChat($msg, $userID, $proID){
            return parent::getMessages();
        }
    }
    