<?php
    namespace Model;

    include_once '../model/config.php';

    class ActionManager extends Config {
        public static $NEW_MESSAGE_ACTION_TOKEN = 'My token';
        public static $GET_CONV_ACTION_TOKEN = 'another token';

        protected static function allowRequestAction($actionToken, $schema) {
            $parts = explode('|', Config::urlSafeDecode($actionToken));
            if(count($parts) === 3) {
                if ($parts[2] >= time() - 30*60) {
                    $hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2] . $_SERVER['REMOTE_ADDR'], $schema, true);
                    if(hash_equals($hash, Config::urlSafeDecode($parts[0]))) {
                        return true;
                    }
                }
            }
            return false;
        }

        protected static function createRequestAction($schema){
            $seed = Config::urlSafeEncode(random_bytes(16));
            $time = time();
            $hash = Config::urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $time . $_SERVER['REMOTE_ADDR'] , $schema, true));
            return Config::urlSafeEncode($hash . '|' . $seed . '|' . $time);
        }
    }