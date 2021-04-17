<?php 

    require_once('database.php');
    class ChatProUserMessage extends Database {
        
        public static function createMessage($chatID, $content, $authorId) {
            $IV = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-192-CBC'));
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
            return Config::urlSafeEncode(openssl_encrypt($msg, "AES-192-CBC", Config::$MESSAGE_KEY_SECRET, 0, $IV));
        }

        protected static function decodeMessage($msg, $IV) {
            return openssl_decrypt(Config::urlSafeDecode($msg),"AES-192-CBC",  Config::$MESSAGE_KEY_SECRET,0, $IV);
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

        public static function getAllMessages($chatId) {
            return parent::sqlSelect('SELECT * FROM chat_messages WHERE chat_id=? ORDER BY message_creation DESC', 'i', $chatId)->fetch_all(MYSQLI_ASSOC);
        }
    }

    class ChatProUser extends ChatProUserMessage {
        protected static function newMessage($msg, $userID){
            return parent::createMessage(124578, $msg, $userID);
        }

        protected static function getMessages($chatId){
            $res = [];
            foreach (parent::getAllMessages($chatId) as $msg ) {
                $msg['message_content'] = parent::decodeMessage($msg['message_content'], parent::getIVFromMessageID($msg['message_id']));
                unset($msg['message_id'], $msg['chat_id'], $msg['encryption_IV']);      
                array_push($res, $msg);
            }
            return $res;
        }

        protected static function createChatId(){
            do {
                $id = rand(1, 1000000000);
            } while (self::chatIdAlreadyExisting($id));
            return $id;
        }

        protected static function chatIdAlreadyExist($chatId) {
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE chat_id=?', 'i', $chatId)->num_rows === 1;
        }

        protected static function updateChat($chatId, $proID, $clientID) {
            return Database::sqlUpdate('INSERT INTO chat_pro_client WHERE chat_id=?', 'i', $chatId)->num_rows === 1;
        }

        protected static function chatAlreadyCreated($proID, $userID) {
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE pro_id=? AND client_id=?', 'ii', $proID, $userID)->num_rows === 1;
        }

        protected static function getChatID($proID, $userID) {
            return Database::sqlSelect('SELECT chat_id FROM chat_pro_client WHERE pro_id=? AND client_id=?', 'ii', $proID, $userID)->fetch_assoc()['chat_id'];
        }
    }

    
    