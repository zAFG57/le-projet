<?php 
    namespace Model;

    include_once 'config.php';

    class Csrf extends Config{
        protected static function createToken() {
            $seed = parent::urlSafeEncode(random_bytes(8));
            $t = time();
            // return session_id();
            $hash = parent::urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $t, parent::$CSRF_TOKEN_SECRET, true));
            return parent::urlSafeEncode($hash . '|' . $seed . '|' . $t);
        }
    
        protected static function validateToken($token) {
            $parts = explode('|', parent::urlSafeDecode($token));
            if(count($parts) === 3) {
                $hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2], parent::$CSRF_TOKEN_SECRET, true);
                if(hash_equals(parent::urlSafeEncode($hash), $parts[0])) {
                    return true;
                }
            }
            return false;
        }
    }