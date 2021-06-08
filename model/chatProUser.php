<?php 
    namespace Model;

    include_once 'database.php';

    class ChatProUserMessage extends Database {
        
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

        protected static function getLastMessage($userID, $chatID) {
            return parent::sqlSelect('SELECT * FROM chat_messages WHERE chat_id=? ORDER BY message_creation DESC LIMIT 1', 'i', $chatID)->fetch_assoc();
        }

    }

    class ChatProUser extends ChatProUserMessage {
        protected static function newMessage($chatID, $msg, $userID){
            return parent::createMessage($chatID, $msg, $userID);
        }

        protected static function getMessages($chatId, $userID){
            $res = [];
            $messages = parent::getAllMessages($chatId);
            if (empty($messages)) {
                return true;
            }
            foreach ( $messages as $msg ) {
                $msg['message_content'] = parent::decodeMessage($msg['message_content'], parent::getIVFromMessageID($msg['message_id']));
                $msg['isMe'] = $msg['message_author_id'] === $userID;

                unset($msg['message_id'], $msg['chat_id'], $msg['encryption_IV']);      
                array_push($res, $msg);
            }
            return $res;
        }


        protected static function createChatId(){
            do {
                $id = rand(1, 1000000000);
            } while (self::chatIdAlreadyExist($id));
            return $id;
        }

        protected static function chatIdAlreadyExist($chatId) {
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE chat_id=?', 'i', $chatId)->num_rows === 1;
        }

        protected static function updateChat($chatId, $clientID, $proID) {
            return Database::sqlUpdate('INSERT INTO `chat_pro_client`(`chat_id`, `pro_id`, `client_id`, `chat_creation`) VALUES (?,?,?,?)', 'iiii', $chatId, $proID, $clientID, time());
        }

        protected static function chatAlreadyCreated($userID, $proID) {
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE pro_id=? AND client_id=?', 'ii', $proID, $userID)->num_rows >= 1;
        }

        protected static function getChatID($userID, $proID) {
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE pro_id=? AND client_id=?', 'ii', $proID, $userID)->fetch_assoc()['chat_id'];
        }


        protected static function belongsUsr($userID, $chatID) {
            return Database::sqlSelect('SELECT client_id FROM chat_pro_client WHERE chat_id=?', 'i', $chatID)->fetch_assoc()['client_id'] === $userID;
        }

        protected static function belongsPro($proID, $chatID) {
            return Database::sqlSelect('SELECT pro_id FROM chat_pro_client WHERE chat_id=?', 'i', $chatID)->fetch_assoc()['pro_id'] === $proID;
        }

        protected static function getLastProUserID($chatID){
            return Database::sqlSelect('SELECT pro_id FROM chat_pro_client WHERE chat_id=?', 'i', $chatID)->fetch_assoc()['pro_id'];
        }

        protected static function getLastClientUserID($chatID){
            return Database::sqlSelect('SELECT client_id FROM chat_pro_client WHERE chat_id=?', 'i', $chatID)->fetch_assoc()['client_id'];
        }

        protected static function getDiscutionsPro($proID){
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE pro_id=?', 'i', $proID)->fetch_all(MYSQLI_ASSOC);
        }

        protected static function getDiscutionsUser($userID){
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE client_id=?', 'i', $userID)->fetch_all(MYSQLI_ASSOC);
        }

        protected static function getLastMessage($userID, $chatID){
            return parent::getLastMessage($userID, $chatID);
        }

        protected static function decodeMessage($msg, $IV){
            return parent::decodeMessage($msg, $IV);
        }

    }

    
    