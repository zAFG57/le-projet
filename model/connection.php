<?php
    namespace Model;

    include_once 'config.php';

    class Connection extends Config {
        protected static function createToken($connectionHahs) {
            $connectionHahs = Config::urlSafeDecode($connectionHahs);
            $seed = parent::urlSafeEncode(random_bytes(8));
            $t = time();
            $hash = parent::urlSafeEncode(hash_hmac('sha256', session_id() . $connectionHahs . $seed . $t, parent::$CONNECTION_SECRET_TOKEN, true));
            return parent::urlSafeEncode($hash . '|' . $seed . '|' . $t);
        }
    
        protected static function validateToken($token, $connectionHahs) {
            $connectionHahs = Config::urlSafeDecode($connectionHahs);
            $parts = explode('|', parent::urlSafeDecode($token));
            if(count($parts) === 3) {
                $hash = hash_hmac('sha256', session_id() . $connectionHahs . $parts[1] . $parts[2], parent::$CONNECTION_SECRET_TOKEN, true);
                if(hash_equals($hash, parent::urlSafeDecode($parts[0]))) {
                    return true;
                }
            }
            return false;
        }
    }