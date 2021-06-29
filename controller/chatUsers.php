<?php 
    namespace Controller;

    use \Model\ChatUsers;
    
    include_once __DIR__ . '/../model/chatUsers.php';
    include_once __DIR__ . '/../controller/user.php';
    include_once __DIR__ . '/../controller/csrfConfig.php';
    
    class ControllerChatUsers extends ChatUsers {
        public static function newMessage($chatID, $msg, $userID){
            return parent::newMessage($chatID, $msg, $userID);
        }

        public static function displayMessages($userID, $chatID) {
            if (ControllerUser::userExisiting($userID) && parent::chatIdAlreadyExist($chatID)) {
                if (parent::belongsUser($userID, $chatID)) {
                    return self::getMessages($chatID, $userID);
                }
            } 
            return false;    
        }

        public static function getMessages($chatID, $userID){
            if (parent::chatIdAlreadyExist($chatID)) {
                return parent::getMessages($chatID, $userID);
            }
            false;
        }

        public static function newChat($user1ID, $user2ID){
            if (!parent::chatAlreadyCreated($user1ID, $user2ID)) {
                return parent::updateChat(parent::createChatId(), $user1ID, $user2ID);
            }
            false;
        }

        public static function getChatIDController($user1ID, $user2ID) {
            return parent::getChatID($user1ID, $user2ID);
        }

        public static function getChatIDExisting($chatID) {
            return parent::chatIdAlreadyExist($chatID);
        }

        public static function isChatAlreadyExisting($user1ID, $user2ID) {
            return parent::isChatAlreadyExisting($user1ID, $user2ID);
        }

        public static function getChatID($userID, $proID) {
            return parent::getChatID($userID, $proID);
        }

        public static function openChat($user1ID, $user2ID) {
            if(ControllerUser::userExisiting($user1ID) && ControllerUser::userExisiting($user2ID)){
                if (!(ControllerUser::isPro($user1ID) && ControllerUser::isPro($user2ID))) {
                    if (!parent::chatAlreadyCreated($user1ID, $user2ID)) {
                        if(self::newChat($user1ID, $user2ID)) {
                            return parent::getChatID($user1ID, $user2ID);
                        }
                    }
                } else {
                    return 1;
                }
            } else {
                return false;
            }
        }

        public static function getLastUser($userID, $chatID) {
            if(ControllerUser::userExisiting($userID) && parent::chatIdAlreadyExist($chatID)){
                return parent::getLastClient($chatID, $userID);
            }
        }
        
        public static function displayDiscussions($userID) {
            if (ControllerUser::userExisiting($userID)) {
                $res = [];

                $chatIDs = parent::getDiscutions($userID);

                if (empty($chatIDs)) {
                    return true;
                }
                foreach ($chatIDs as $chatID) {
                    // if (parent::lastMessageExisting($chatID['chat_id'])) {
                    $lastMessage = parent::getLastMessage($chatID['chat_id']);

                    $lastMessage['username'] = ControllerUser::getUserName(parent::getLastClient($chatID['chat_id'], $userID));

                    if (isset($lastMessage['message_content'])) {
                        $lastMessage['message_content'] = parent::decodeMessage($lastMessage['message_content'], $lastMessage['encryption_IV']);
                        $lastMessage['isMe'] = ControllerUser::getUserName($lastMessage['message_author_id']) === ControllerUser::getUserName($userID) || false;
                        unset($lastMessage['message_id'], $lastMessage['encryption_IV'], $lastMessage['message_creation'], $lastMessage['message_author_id']); 
                    } else {
                        $lastMessage['chat_id'] = $chatID['chat_id'];
                    }
                         
                    array_push($res, $lastMessage);
                }
                return $res;
            } else {
                return false;
            }
        }
    }

    if (isset($_POST['chatID']) && isset($_POST['csrf_token'])) {
        session_start();
        if (isset($_SESSION['userID'])) {
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                echo json_encode(ControllerChatUsers::displayMessages($_SESSION['userID'], $_POST['chatID']));
            }
        }
    }