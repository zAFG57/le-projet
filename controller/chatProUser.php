<?php 

    require_once('../model/chatProUser.php');
    require_once('../controller/user.php');
    require_once('../controller/csrfConfig.php');

    

    class ControllerChatProUser extends ChatProUser {
        public static function newMessage($chatID, $msg, $userID){
            return parent::newMessage($chatID, $msg, $userID);
        }

        public static function displayMessages($userID, $chatID) {
            // return 'ouo';
            if (ControllerUser::userExisiting($userID) && parent::chatIdAlreadyExist($chatID)) {
                if (ControllerUser::isPro($userID)) {
                    if (parent::belongsPro($userID, $chatID)) {
                        return self::getMessages($chatID);
                    } 
                } else {
                    if (parent::belongsUsr($userID, $chatID)) {
                        return self::getMessages($chatID);
                    }
                }
            } 
                return false;    
        }

        public static function getMessages($chatID){
            if (parent::chatIdAlreadyExist($chatID)) {
                return parent::getMessages($chatID);
            }
        }

        public static function newChat($userID, $proID){
            if (!parent::chatAlreadyCreated($userID, $proID)) {
                return parent::updateChat(parent::createChatId(), $userID, $proID);
            }
        }

        public static function getChatIDController($userID, $proID) {
            return parent::getChatID($userID, $proID);
        }

        public static function getChatIDExisting($chatID) {
            return parent::chatIdAlreadyExist($chatID);
        }

        public static function getChatAlreadyExisting($userID, $proID) {
            return parent::chatIdAlreadyExist($userID, $proID);
        }

        public static function getChatID($userID, $proID) {
            return parent::getChatID($userID, $proID);
        }

        public static function openChat($userID, $proID) {
            if(ControllerUser::userExisiting($userID) && ControllerUser::userExisiting($proID)){
                if (!ControllerUser::isPro($userID) && ControllerUser::isPro($proID)) {
                    if (!parent::chatAlreadyCreated($userID, $proID)) {
                        if(self::newChat($userID, $proID)) {
                            return parent::getChatID($userID, $proID);
                        }
                    } else {
                        return parent::getChatID($userID, $proID);
                    }
                } else {
                    return -1;
                }
                // return $proID;
            } else {
                return -2;
            }
        }
    }

    if (isset($_POST['chatin']) && isset($_POST['userID'])  && isset($_POST['csrf_token'])) {
        session_start();

        if(isset($_SESSION['userID'])){
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
            
                if(ControllerUser::isPro(intval($_POST['userID']))) {
                    echo json_encode(ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($_SESSION['userID']), intval($_POST['userID'])), $_POST['chatin'], $_SESSION['userID']));
                } else if(ControllerUser::isPro(intval($_SESSION['userID']))) {
                    echo json_encode(ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($_POST['userID']), intval($_SESSION['userID'])), $_POST['chatin'], $_SESSION['userID']));

                } else {
                    echo -100;
                }
            }
        }
    }


    if (isset($_POST['chatID']) && isset($_POST['csrf_token'])) {
        session_start();
        if (isset($_SESSION['userID'])) {
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                echo json_encode(ControllerChatProUser::displayMessages($_SESSION['userID'], $_POST['chatID']));
            }
        }
    }