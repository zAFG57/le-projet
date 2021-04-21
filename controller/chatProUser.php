<?php 

    require_once('../model/chatProUser.php');
    require_once('../controller/user.php');
    require_once('../controller/csrfConfig.php');

    

    class ControllerChatProUser extends ChatProUser {
        public static function newMessage($chatID, $msg, $userID){
            return parent::newMessage($chatID, $msg, $userID);
        }

        public static function displayMessages($userID, $chatID) {
            if (ControllerUser::userExisiting($userID) && parent::chatIdAlreadyExist($chatID)) {
                if (ControllerUser::isPro($userID)) {
                    if (parent::belongsPro($userID, $chatID)) {
                        return self::getMessages($chatID, $userID);
                    } 
                } else {
                    if (parent::belongsUsr($userID, $chatID)) {
                        return self::getMessages($chatID, $userID);
                    }
                }
            } 
                return false;    
        }

        public static function getMessages($chatID, $userID){
            if (parent::chatIdAlreadyExist($chatID)) {
                return parent::getMessages($chatID, $userID);
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
                    return false;
                }
                // return $proID;
            } else {
                return false;
            }
        }

        public static function getLastUser($userID, $chatID) {
            if(ControllerUser::userExisiting($userID)){

                //verifier si le chat existe
                if (ControllerUser::isPro($userID)) {
                    return parent::getLastClientUserID($chatID);
                } else {
                    return parent::getLastProUserID($chatID);
                }
            }
        }

        public static function displayDiscussions($userID) {
            if (ControllerUser::userExisiting($userID)) {
                $res = [];

                if (ControllerUser::isPro($userID)) {
                    $chatIDs = parent::getDiscutionsPro($userID);

                    if (empty($chatIDs)) {
                        return true;
                    }
                    foreach ($chatIDs as $chatID) {
                        $lastMessage = parent::getLastMessage($userID, $chatID['chat_id']);
                        $lastMessage['message_content'] = parent::decodeMessage($lastMessage['message_content'], $lastMessage['encryption_IV']);
                        
                        $lastMessage['username'] = ControllerUser::getUserName(parent::getLastClientUserID($chatID['chat_id']));
                        $lastMessage['isMe'] = ControllerUser::getUserName($lastMessage['message_author_id']) === ControllerUser::getUserName($userID);

                        unset($lastMessage['message_id'], $lastMessage['encryption_IV'], $lastMessage['message_creation'], $lastMessage['message_author_id']);      
                        array_push($res, [$lastMessage]);
                    }
                    return $res[0];
                } else {
                    $chatIDs = parent::getDiscutionsUser($userID);

                    if (empty($chatIDs)) {
                        return true;
                    }
                    foreach ($chatIDs as $chatID) {
                     
                        $lastMessage = parent::getLastMessage($userID, $chatID['chat_id']);
                        $lastMessage['message_content'] = parent::decodeMessage($lastMessage['message_content'], $lastMessage['encryption_IV']);
                        
                        
                        $lastMessage['username'] = ControllerUser::getUserName(parent::getLastProUserID($chatID['chat_id']));
                        $lastMessage['isMe'] = ControllerUser::getUserName($lastMessage['message_author_id']) === ControllerUser::getUserName($userID);

                        unset($lastMessage['message_id'], $lastMessage['encryption_IV'], $lastMessage['message_creation'], $lastMessage['message_author_id']);      
                        array_push($res, [$lastMessage]);
                    }
                    return $res[0];
                }
            } else {
                return -4;
            }
        }
    }

    if (isset($_POST['chatin']) && isset($_POST['userID'])  && isset($_POST['csrf_token'])) {
        if (empty($_POST['chatin'])) {
            echo false;
        } else {
            session_start();

            if(isset($_SESSION['userID'])){
                if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                
                    if(ControllerUser::isPro(intval($_POST['userID']))) {
                        echo json_encode(ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($_SESSION['userID']), intval($_POST['userID'])), htmlspecialchars($_POST['chatin']), $_SESSION['userID']));
                    } else if(ControllerUser::isPro(intval($_SESSION['userID']))) {
                        echo json_encode(ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($_POST['userID']), intval($_SESSION['userID'])), htmlspecialchars($_POST['chatin']), $_SESSION['userID']));

                    } else {
                        echo false;
                    }
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


    if (isset($_POST['myIdForConvs']) && isset($_POST['csrf_token'])) { 
        session_start();
        // echo json_encode($_POST['myIdForConvs']);
        if (isset($_SESSION['userID']) && intval($_POST['myIdForConvs']) === $_SESSION['userID']) {
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                echo json_encode(ControllerChatProUser::displayDiscussions($_SESSION['userID']));
            } else {
                echo -1;
            }
        } else {
            echo -2;
        }
    }