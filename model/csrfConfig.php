<?php 
    namespace Model;

    include_once __DIR__ . '/config.php';

    class Csrf extends Config{
        public static function createToken() {
            $seed = parent::urlSafeEncode(random_bytes(8));
            $t = time();
            $hash = parent::urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $t, Config::CSRF_TOKEN_SECRET, true));
            return parent::urlSafeEncode($hash . '|' . $seed . '|' . $t);
        }
    
        public static function validateToken($token) {
            $parts = explode('|', parent::urlSafeDecode($token));
            if(count($parts) === 3) {
                $hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2], Config::CSRF_TOKEN_SECRET, true);
                if(hash_equals(parent::urlSafeEncode($hash), $parts[0])) {
                    return true;
                }
            }
            return false;
        }
    }