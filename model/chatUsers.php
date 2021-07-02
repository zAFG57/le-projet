<?php 
    namespace Model;

    include_once 'database.php';

    class ChatUsersMessage extends Database {
        
        protected static function createMessage($chatID, $content, $authorId) {
            $IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::$ENCODING_MESSAGES_SCHEMA));
            return self::sendMessageToDB(self::createMessageId(), $chatID, self::encodeMessage($content, $IV), time(), $authorId, $IV);
        }

        protected static function createMessageId() {
            do {
                $id = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(30/strlen($x)) )),1,30);
            } while (self::messageIdAlreadyExist($id));
            return $id;
        }

        protected static function messageIdAlreadyExist($id) {
            return parent::sqlSelect('SELECT message_id FROM chat_messages WHERE message_id=?', 's', $id)->num_rows === 1;
        }

        protected static function sendMessageToDB($messageId, $chatId, $messageContent, $creationTime, $mesAuthorId, $IV) {
            return parent::sqlInsert('INSERT INTO chat_messages (message_id, chat_id, message_content, message_creation, message_author_id, encryption_IV) VALUES (?,?,?,?,?,?)', 'sisiis', $messageId, $chatId, $messageContent, $creationTime, $mesAuthorId, $IV);
        }

        protected static function encodeMessage($msg, $IV) {
            return Config::urlSafeEncode(openssl_encrypt($msg, Config::$ENCODING_MESSAGES_SCHEMA, Config::$MESSAGE_KEY_SECRET, 0, $IV));
        }

        protected static function decodeMessage($msg, $IV) {
            return openssl_decrypt(Config::urlSafeDecode($msg),Config::$ENCODING_MESSAGES_SCHEMA,  Config::$MESSAGE_KEY_SECRET,0, $IV);
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

    class ChatUsers extends ChatUsersMessage {

        /** 
         * @param int $chatID 
         * @param string $msg
         * @param int $userID
         * 
         * @return boolean if the message sucessfully created
         */
        protected static function newMessage($chatID, $msg, $userID){
            return parent::createMessage($chatID, $msg, $userID);
        }

        /**
         * @param int $chatId
         * @param int $userID
         * 
         * @return array all messages of the user on the chat
         */
        protected static function getMessages($chatId, $userID){
            $res = [];
            $messages = parent::getAllMessages($chatId);
            if (empty($messages)) {
                return false;
            }
            foreach ($messages as $msg ) {
                $msg['message_content'] = parent::decodeMessage($msg['message_content'], parent::getIVFromMessageID($msg['message_id']));
                $msg['isMe'] = $msg['message_author_id'] === $userID;

                unset($msg['message_id'], $msg['chat_id'], $msg['encryption_IV']);      
                array_push($res, $msg);
            }
            return $res;
        }

        /**
         * @return string an unsued chatID
         */
        protected static function createChatId(){
            do {
                $id = rand(1, 1000000000);
            } while (self::chatIdAlreadyExist($id));
            return $id;
        }

        /**
         * @param int $chatId
         * 
         * @return boolean if the chat is already existing
         */
        protected static function chatIdAlreadyExist($chatId) {
            return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE chat_id=?', 'i', $chatId)->num_rows === 1;
        }

        /**
         * @param int $chatId
         * 
         * @return boolean if the chat is already existing
         */
        protected static function isChatAlreadyExisting($user1ID, $user2ID) {
            return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE (client1_id=? and client2_id=?) or (client1_id=? and client2_id=?)' , 'iiii', $user1ID, $user2ID, $user2ID, $user1ID)->num_rows === 1;
        }

         /**
         * @param int $chatId
         * @param int $user1ID
         * @param int $user2ID
         * 
         * @return boolean if the chat sucessfully updated
         */
        protected static function updateChat($chatId, $user1ID, $user2ID) {
            return Database::sqlUpdate('INSERT INTO `chat_users`(`chat_id`, `client1_id`, `client2_id`, `chat_creation`) VALUES (?,?,?,?)', 'iiii', $chatId, $user1ID, $user2ID, time());
        }

        /**
         * @param int $user1ID
         * @param int $user2ID
         * 
         * @return boolean if the chat is already created
         */
        protected static function chatAlreadyCreated($user1ID, $user2ID) {
            return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE (client1_id=? AND client2_id=?) or (client1_id=? AND client2_id=?)', 'iiii', $user1ID, $user2ID, $user2ID, $user1ID)->num_rows >= 1;
        }

        /**
         * @param int $user1ID
         * @param int $user2ID
         * 
         * @return int the chatID
         */
        protected static function getChatID($user1ID, $user2ID) {
            return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE (client1_id=? AND client2_id=?) or (client1_id=? AND client2_id=?)', 'iiii', $user1ID, $user2ID, $user2ID, $user1ID)->fetch_assoc()['chat_id'];
        }

        /**
         * @param int $userID
         * @param int $chatID
         * 
         * @return boolean if the chat belongs the client
         */
        protected static function belongsUser($userID, $chatID) {
            return Database::sqlSelect('SELECT client1_id FROM chat_users WHERE chat_id=? and (client1_id=? or client2_id=?)', 'iii', $chatID, $userID, $userID)->num_rows === 1;
        }

        /**
         * @param int $chatID
         * @param int $userID
         * 
         * @return array the last client id
         */
        protected static function getLastClient($chatID, $userID){
            $client = Database::sqlSelect('SELECT client1_id, client2_id FROM chat_users WHERE chat_id=? and (client1_id=? or client2_id=?)', 'iii', $chatID, $userID, $userID)->fetch_assoc();
            return $client['client1_id'] === $userID ? $client['client2_id'] : $client['client1_id'];
        }

        /**
         * @param int $userID
         * @return array All user's discution's chatID
         */
        protected static function getDiscutions($userID){
            return Database::sqlSelect('SELECT chat_id FROM chat_users WHERE client1_id=? or client2_id=?', 'ii', $userID, $userID)->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * @param int $userID
         * @param int $chatID
         * 
         * @return array the last message
         */
        protected static function getLastMessage($chatID){
            return parent::getLastMessage($chatID);
        }

        /**
         * @param string $msg
         * @param string $IV
         * 
         * @return string the decoded message
         */
        protected static function decodeMessage($msg, $IV){
            return parent::decodeMessage($msg, $IV);
        }

    }