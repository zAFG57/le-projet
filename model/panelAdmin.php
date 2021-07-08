<?php 
    namespace Model;

    include_once 'database.php';

    class Admin extends User {

        protected $adminToken;
        /**
         * **Create an Admin object**
         * @param int $userID 
         * @param string $email
         * @param User $user
         * 
         * @return void
         */
        public function __construct(int $userID = NULL, string $email = NULL, User $user = NULL) {
            parent::__construct($userID, $email, $user);
            if ($this->isAdmin()) {
                $this->adminToken = $this->setAdminToken();
            } else {
                $this->__destruct();
            }
        }

        public function __destruct() {
            parent::__destruct();
        }


        private function setAdminToken(){
            if ($this->errorCode === 0) {
                $this->adminToken = parent::sqlSelect('SELECT token FROM admin WHERE user_id = ?', 'i', $this->userID);
            }
        }

        /**
         * @return bool|string the admin token for the user
         */
        public function getAdminToken() {
            return ($this->errorCode === 0) ? $this->adminToken : false;
        }

        /**
         * @return boolean if the user is admin
         */
        protected function isAdmin() : bool {
            if ($this->errorCode === 0) {
                $res = parent::sqlSelect('SELECT admin_type FROM admin WHERE user_id = ?', 'i', $this->userID);
                if ($res->num_rows === 1) {
                    $userPro = $res->fetch_assoc();
                    if($userPro) {
                        return $userPro['admin_type'] === 'super admin';  
                    }
                }
            }
            return false;
        }

        /**
         * @return bool|string the token
         */
        protected function createAdminToken() {
            if ($this->errorCode === 0) {
                $seed = Config::urlSafeEncode(random_bytes(8));
                $t = time();
                $hash = Config::urlSafeEncode(hash_hmac('sha256',  $seed . $t . $this->userID . session_id(), Config::ADMIN_TOKEN_SECRET, true));
                return Config::urlSafeEncode($hash . '|' . $seed . '|' . $t);
            }
            return false;
        }
    
        protected function validateAdminToken($token) {
            if ($this->errorCode === 0) {
                $parts = explode('|', Config::urlSafeDecode($token));
                if(count($parts) === 3) {
                    $hash = hash_hmac('sha256', $parts[1] . $parts[2] . $this->userID . session_id(), Config::ADMIN_TOKEN_SECRET, true);
                    if(hash_equals($hash, Config::urlSafeDecode($parts[0]))) {
                        return true;
                    }
                }
            }
            return false;
        }
        /**
         * @param string $token 
            * @return bool if the update successful
            */
        protected function updateAdminToken($token) {
            return ($this->errorCode === 0) ?  parent::sqlUpdate('UPDATE admin SET token=? WHERE user_id=?' ,'si', $token, $this->userID) : false;
        }
    }
    