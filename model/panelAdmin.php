<?php 

    require_once('config.php');
    require_once('database.php');


    class Admin extends Database {
        protected static function createAdminToken($id) {
            $seed = Config::urlSafeEncode(random_bytes(8));
            $t = time();
            $hash = Config::urlSafeEncode(hash_hmac('sha256',  $seed . $t . $id . session_id(), Config::$ADMIN_TOKEN_SECRET, true));
            return Config::urlSafeEncode($hash . '|' . $seed . '|' . $t . '|' . $id);
        }
    
        protected static function updateAdminToken($hash, $id) {
           
            if(parent::sqlUpdate('UPDATE admin SET hash=? WHERE user_id=?' ,'si', $hash, $id)){ 
                return true;
            }
            return false;
        }
    
        protected static function validateAdminToken($token) {
            $parts = explode('|', Config::urlSafeDecode($token));
            if(count($parts) === 4) {
                $hash = hash_hmac('sha256', $parts[1] . $parts[2] . $parts[3] . session_id(), Config::$ADMIN_TOKEN_SECRET, true);
                if(hash_equals($hash, Config::urlSafeDecode($parts[0]))) {
                    return true;
                }
            }
            return false;
        }

        protected static function getHashToken($id) {
            $res = parent::sqlSelect('SELECT hash FROM admin WHERE admin.user_id = ?' ,'i',$id);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro) {
                    return $userPro['hash'];  
                }
        }
    }

    protected static function getUsersNum() {
        return parent::sqlSelect('SELECT COUNT(id) FROM users')->fetch_assoc()['COUNT(id)'];
    }
}
    