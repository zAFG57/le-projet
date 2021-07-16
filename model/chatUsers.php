<?php 
    namespace Model;

use function PHPSTORM_META\type;

include_once 'database.php';

    class ChatUsersMessage extends Database {

        // protected $messageInfo = array(
        //     'messageID' => null,
        //     'chatID' => null,
        //     'messageContent' => null,
        //     'messageCreation' => null,
        //     'authorID' => null,
        // );
        private $messageID;
        private $chatID;
        private $messageContent;
        private $messageCreation;
        private $authorID;

        public function __construct(string $messageID = null, ChatUsersMessage $message = null, array $messageArray = null, array $createMessage = null/* [content, authorID] */) {
            $this->setMessageInfo($messageID, $message, $messageArray);
            if (!is_null($createMessage)) {
                # code...
            }
        }

        private function setMessageInfo(string $messageID = null, ChatUsersMessage $message = null, array $messageArray = null) {
            if (!is_null($messageID)) {
                $messageInfo = Database::sqlSelect('SELECT * FROM chat_messages WHERE message_id = ?', 's', $messageID);
                if (!($messageInfo && $messageInfo->num_rows === 1)) {
                    return;
                }
                $messageInfo = $messageInfo->fetch_assoc();
                
            }
            if (!is_null($messageArray)) {
                $messageInfo = $messageArray;
            }

            if (!is_null($message)) {
                $this->messageID = $message->messageID;
                $this->chatID = $message->chatID;
                $this->messageContent = $message->messageContent;
                $this->messageCreation = $message->messageCreation;
                $this->authorID = $message->authorID;
                return;
            }

            if ($messageInfo) {
                $messageInfo['message_content'] = $this->decodeMessage($messageInfo['message_content'], $messageInfo['encryption_IV']);
                $this->messageID = $messageInfo['message_id'];
                $this->chatID = $messageInfo['chat_id'];
                $this->messageContent = $messageInfo['message_content'];
                $this->messageCreation = $messageInfo['message_creation'];
                $this->authorID = $messageInfo['message_author_id'];
                return;
            }
            
        }
        
        /** 
         * @param string $msg
         * @param int $userID
         * 
         * @return boolean if the message sucessfully created
         */
        public static function newMessage($chatID, $content, $authorID){
            $IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_MESSAGES_SCHEMA));
            return Database::sqlInsert('INSERT INTO chat_messages (message_id, chat_id, message_content, message_creation, message_author_id, encryption_IV) VALUES (?,?,?,?,?,?)', 'sisiis', self::createMessageId(), $chatID, self::encodeMessage($content, $IV), time(), $authorID, $IV);
        }

        protected static function createMessageId() {
            do {
                $id = Config::createRandomSeq(30);
            } while (self::messageIdAlreadyExist($id));
            return $id;
        }

        protected static function messageIdAlreadyExist($id) {
            return parent::sqlSelect('SELECT message_id FROM chat_messages WHERE message_id=?', 's', $id)->num_rows === 1;
        }

        // protected static function sendMessageToDB($messageId, $chatId, $messageContent, $creationTime, $mesAuthorId, $IV) {
        //     return 
        // }

        protected static function encodeMessage($msg, $IV) {
            return Config::urlSafeEncode(openssl_encrypt($msg, Config::ENCODING_MESSAGES_SCHEMA, Config::MESSAGE_KEY_SECRET, 0, $IV));
        }

        protected static function decodeMessage($msg, $IV) {
            return openssl_decrypt(Config::urlSafeDecode($msg),Config::ENCODING_MESSAGES_SCHEMA,  Config::MESSAGE_KEY_SECRET,0, $IV);
        }

        protected static function getMessagesFromChatID($chatID) {
            return parent::sqlSelect('SELECT message_id FROM chat_messages WHERE chat_id=?', 'i', $chatID)->fetch_assoc()['message_id'];
        }

        protected static function getMessageContentFromMessageID($msgID) {
            return parent::sqlSelect('SELECT message_content FROM chat_messages WHERE message_id=?', 's', $msgID)->fetch_assoc()['message_content'];
        }

        protected static function getIVFromMessageID($msgID) {
            return parent::sqlSelect('SELECT encryption_IV FROM chat_messages WHERE message_id=?', 's', $msgID)->fetch_assoc()['encryption_IV'];
        }

        protected static function getAllMessages($chatId) {
            return parent::sqlSelect('SELECT * FROM chat_messages WHERE chat_id=? ORDER BY message_creation ASC', 'i', $chatId)->fetch_all(MYSQLI_ASSOC);
        }

        protected static function getLastMessage($chatID) {
            return parent::sqlSelect('SELECT * FROM chat_messages WHERE chat_id=? ORDER BY message_creation DESC LIMIT 1', 'i', $chatID)->fetch_assoc();
        }

        protected static function lastMessageExisting($chatID) {
            return parent::sqlSelect('SELECT message_id FROM chat_messages WHERE chat_id=? LIMIT 1', 'i', $chatID)->num_rows >= 1;
        }

    }


        /** 
         * Chat Class Manage the whole chats
         * 
         * @author Jules GRIVOT PÉLISSON
         */

    class ChatUsers extends Database{

        protected $chatID;
        protected $proID;
        protected $clientID;

        protected $messages = [];

        /**
         * create an ChatUser object
         * 
         * @param int $chatID
         * @param ChatUsers $chat
         * @param int $clientID
         * @param int $proID
         * 
         * @return void
         */
        public function __construct(int $chatID = null, ChatUsers $chat = null, $clientID = null, $proID = null) {
            $this->setChat($chatID, $chat);
            $this->setMessages();
        }


        /**
         * @param int $chatID
         * @param ChatUsers $chat
         * @param int $clientID
         * @param int $proID
         * 
         * @return void
         */
        private function setChat(int $chatID = null, ChatUsers $chat = null, int $clientID = null, int $proID = null){
            if (!is_null($chatID)) {
                $chatInfo = Database::sqlSelect('SELECT * FROM chats_pro_client WHERE chat_id = ?', 'i', $chatID);
                if ($chatInfo &&  $chatInfo->num_rows === 1) {
                    $chatInfo = $chatInfo->fetch_assoc();

                    $this->chatID = $chatInfo['chat_id'];
                    $this->proID = $chatInfo['pro_id'];
                    $this->clientID = $chatInfo['client_id'];
                    return;
                }
            } elseif (!is_null($chat)) {
                $this->chatID = $chat->chatID;
                $this->proID = $chat->proID;
                $this->clientID = $chat->clientID;
                return;
            } elseif(!is_null($clientID) && !is_null($proID)) {
                $chatInfo = Database::sqlSelect('SELECT * FROM chats_pro_client WHERE pro_id = ? AND client_id = ?', 'i', $proID, $clientID);
                if ($chatInfo &&  $chatInfo->num_rows === 1) {
                    $chatInfo = $chatInfo->fetch_assoc();

                    $this->chatID = $chatInfo['chat_id'];
                    $this->proID = $chatInfo['pro_id'];
                    $this->clientID = $chatInfo['client_id'];
                    return;
                } else {
                    $this->createChat($clientID, $proID);
                }
            }
        }

        /**
         * create an chat 
         */
        private function createChat(int $clientID, int $proID) {
            if (!(new User($clientID))->isPro() && (new User($proID))->isPro()) {
                (Database::sqlInsert('INSERT INTO chats_pro_client (`chat_id`, `pro_id`, `client_id`, `chat_creation`) VALUES (?,?,?,?)', $this->createChatID(), $proID, $clientID, time())) ? $this->setChat(null, null, $clientID, $proID): false;
            }
        }

        /**
         * set all messages to the class
         */
        private function setMessages(){
            if (!is_null($this->chatID)) {
                $messages =  Database::sqlSelect('SELECT * FROM chat_messages WHERE chat_id = ? ORDER BY message_creation ASC', 'i', $this->chatID);
                if ($messages) {
                    if ($messages->num_rows >= 1) {
                        foreach ($messages->fetch_all(MYSQLI_ASSOC) as $message) {
                            // if (gettype($this->messages) === "array") {
                            array_push($this->messages, new ChatUsersMessage(null, null, $message));
                            // }
                        }
                    } else {
                        $this->messages = [false];
                    }
                }
            }
        }
        
        /**
         * create a new message
         */
        public function createMessage(string $content, int $authorID) {
            ChatUsersMessage::newMessage($this->chatID, $content, $authorID);
        }

        /**
         * @return string an unsued chatID
         */
        protected static function createChatID(){
            do {
                $id = rand(1, 1000000000);
            } while (self::chatIDAlreadyExist($id));
            return $id;
        }

        /**
         * @param int $chatId
         * 
         * @return boolean if the chat is already existing
         */
        protected static function chatIDAlreadyExist($chatId) {
            return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE chat_id=?', 'i', $chatId)->num_rows === 1;
        }

        /**
         * @param int $userID
         * @return array All user's discution's chatID
         */
        protected static function getDiscutions($userID){
            return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE client1_id=? or client2_id=?', 'ii', $userID, $userID)->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * @return int chatID
         */
        protected function getChatID() {
            return $this->chatID;
        }

        /**
         * @return int proID
         */
        protected function getProID() {
            return $this->proID;
        }

        /**
         * @return int clientID
         */
        protected function getClientID() {
            return $this->clientID;
        }

        /**
         * @return array messages
         */
        protected function getMessages() {
            return $this->messages;
        }

        // /**
        //  * @param int $chatId
        //  * 
        //  * @return boolean if the chat is already existing
        //  */
        // protected static function isChatAlreadyExisting($user1ID, $user2ID) {
        //     return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE (client1_id=? and client2_id=?) or (client1_id=? and client2_id=?)' , 'iiii', $user1ID, $user2ID, $user2ID, $user1ID)->num_rows === 1;
        // }

        //  /**
        //  * @param int $chatId
        //  * @param int $user1ID
        //  * @param int $user2ID
        //  * 
        //  * @return boolean if the chat sucessfully updated
        //  */
        // protected static function updateChat($chatId, $user1ID, $user2ID) {
        //     return Database::sqlUpdate('INSERT INTO `chat_users`(`chat_id`, `client1_id`, `client2_id`, `chat_creation`) VALUES (?,?,?,?)', 'iiii', $chatId, $user1ID, $user2ID, time());
        // }

        // /**
        //  * @param int $user1ID
        //  * @param int $user2ID
        //  * 
        //  * @return boolean if the chat is already created
        //  */
        // protected static function chatAlreadyCreated($user1ID, $user2ID) {
        //     return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE (client1_id=? AND client2_id=?) or (client1_id=? AND client2_id=?)', 'iiii', $user1ID, $user2ID, $user2ID, $user1ID)->num_rows >= 1;
        // }

        // /**
        //  * @param int $user1ID
        //  * @param int $user2ID
        //  * 
        //  * @return int the chatID
        //  */
        // protected static function getChatID($user1ID, $user2ID) {
        //     return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE (client1_id=? AND client2_id=?) or (client1_id=? AND client2_id=?)', 'iiii', $user1ID, $user2ID, $user2ID, $user1ID)->fetch_assoc()['chat_id'];
        // }

        // /**
        //  * @param int $userID
        //  * @param int $chatID
        //  * 
        //  * @return boolean if the chat belongs the client
        //  */
        // protected static function belongsUser($userID, $chatID) {
        //     return Database::sqlSelect('SELECT client1_id FROM chat_users WHERE chat_id=? and (client1_id=? or client2_id=?)', 'iii', $chatID, $userID, $userID)->num_rows === 1;
        // }

        // /**
        //  * @param int $chatID
        //  * @param int $userID
        //  * 
        //  * @return array the last client id
        //  */
        // protected static function getLastClient($chatID, $userID){
        //     $client = Database::sqlSelect('SELECT client1_id, client2_id FROM chat_users WHERE chat_id=? and (client1_id=? or client2_id=?)', 'iii', $chatID, $userID, $userID)->fetch_assoc();
        //     return $client['client1_id'] === $userID ? $client['client2_id'] : $client['client1_id'];
        // }

        

        // /**
        //  * @param int $userID
        //  * @param int $chatID
        //  * 
        //  * @return array the last message
        //  */
        // protected static function getLastMessage($chatID){
        //     return parent::getLastMessage($chatID);
        // }

        // /**
        //  * @param string $msg
        //  * @param string $IV
        //  * 
        //  * @return string the decoded message
        //  */
        // protected static function decodeMessage($msg, $IV){
        //     return parent::decodeMessage($msg, $IV);
        // }

    }