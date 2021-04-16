<?php 

    require_once('config.php');

    class Csrf extends Config{
        protected static function createToken() {
            $seed = self::urlSafeEncode(random_bytes(8));
            $t = time();
            $hash = self::urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $t, self::$CSRF_TOKEN_SECRET, true));
            return self::urlSafeEncode($hash . '|' . $seed . '|' . $t);
        }
    
        protected static function validateToken($token) {
            $parts = explode('|', self::urlSafeDecode($token));
            if(count($parts) === 3) {
                $hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2], self::$CSRF_TOKEN_SECRET, true);
                if(hash_equals($hash, self::urlSafeDecode($parts[0]))) {
                    return true;
                }
            }
            return false;
        }
    
        protected static function urlSafeEncode($m) {
            return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
        }
        protected static function urlSafeDecode($m) {
            return base64_decode(strtr($m, '-_', '+/'));
        }
    }