<?php 
    namespace model;

    include_once __DIR__ . '/user.php';
    
    class ForgotPassword extends User {

        protected $attemptActive;

        /**
         * **Create an user object**
         * @param int $userID 
         * @param string $email
         * @param User $user
         * 
         * @return void
         */
        public function __construct(int $userID = NULL, string $email = NULL, User $user = NULL) {
            parent::__construct($userID, $email, $user);
            $this->setAttemptActive();
        }

        /**
         * **set all attempts actives**
         * @return void
         */
        protected function setAttemptActive() {
            if ($this->errorCode === 0) {
                $lastAttempt = parent::sqlSelect('SELECT * FROM forgot_password_attempts WHERE user_id=? AND timestamp>? AND status="on"', 'ii', $this->userID, time() - Config::MAX_ATTEMPTS_FORGOT_PASSWORD[0]);
                if ($lastAttempt && $lastAttempt->num_row >= 1 ) {
                    $this->attemptActive = $lastAttempt->fetch_assoc();
                    return;
                }
                $this->attemptActive = null;
            }
        }

        /**
         * **Create an token for forgot password**
         * 
         * @return string Token 
         */
        protected function createTokenForgotPassword() {
            $seed = Config::urlSafeEncode(random_bytes(8));
            $t = time();
            $hash = Config::urlSafeEncode(hash_hmac('sha256', $seed . $t, Config::FORGOT_PASS_SECRET_TOKEN, true));
            return Config::urlSafeEncode($hash . '|' . $seed . '|' . $t);
        }

        /**
         * **verify the token for forgot password**
         * @param string $token
         * 
         * @return bool if the token is verified
         */
        protected function validateTokenForgotPassword($token) {
            $parts = explode('|', Config::urlSafeDecode($token));
            if(count($parts) === 3) {
                $hash = hash_hmac('sha256', $parts[1] . $parts[2], Config::FORGOT_PASS_SECRET_TOKEN, true);
                if(hash_equals($hash, Config::urlSafeDecode($parts[0]))) {
                    return true;
                }
            }
            return false;
        }

        /**
         * @param string $hash
         * @return bool if the attempt has sucessfully created
         */
        protected function createForgotPasswordAttempt($hash) : bool {
            return ($this->setAttemptActive() && $this->errorCode === 0 && $this->attemptActive !== null) ? parent::sqlInsert('INSERT INTO forgot_password_attempts VALUES (NULL, ?, ?, ?, ?, "on")', 'issi', $this->userID,  $hash, $_SERVER['REMOTE_ADDR'], time()) : false;
        }
        
        /**
         * @param string $hash
         * @return bool if the attempt has sucessfully destroyed
         */
        protected function destroyAttempt($hash) : bool {
            return ($this->setAttemptActive() && $this->errorCode === 0 && $this->attemptActive !== null) ? parent::sqlUpdate('UPDATE forgot_password_attempts SET status="off" WHERE hash = ? and user_id = ?', 'si', $hash, $this->userID) : false;
        }

        /**
         * @return array the actives attempts
         */
        protected function getAttemptActive() {
            return ($this->setAttemptActive() && $this->errorCode === 0 && $this->attemptActive !== null) ? $this->attemptActive : false;
        }
    }
    