<?php 
    namespace Model;

    include_once 'database.php';

    class Login extends User {

        protected $loginAttempts;

        /**
         * **Create an Login object**
         * @param int $userID 
         * @param string $email
         * 
         * @return void
         */
        public function __construct(int $userID = NULL, string $email = NULL, User $user = NULL) {
            parent::__construct($userID, $email, $user);
            $this->setLoginAttempts();
        }

        /**
         * destruct the class
         */
        public function __destruct() {
            parent::__destruct();
            $this->loginAttempts = null;
        }

        private function setLoginAttempts() {
            return ($this->loginAttempts = ($this->errorCode === 0) ? Database::sqlSelect('SELECT * FROM loginattempts WHERE user_id = ? and timestamp > ?','ii', time() - 60*60, $this->userID)->fetch_all(MYSQLI_ASSOC) : null) ? true : false;
        }

        public function getLoginAttempts() {
            return $this->errorCode === 0 ? $this->loginAttempts : false;
        }

        /**
         * @return bool if the login attempt has created
         */
        protected function createLoginAttempt() {
            return ($this->errorCode === 0) ? Database::sqlInsert('INSERT INTO loginattempts VALUES (NULL, ?, ?, ?)', 'isi', $this->userID, $_SERVER['REMOTE_ADDR'], time()) : false;
        }

        /**
         * @param string $ip
         * 
         * @return bool if the login attempt has deleted
         */
        protected function suppAttempts(string $ip) {
            return ($this->errorCode === 0) ? Database::sqlUpdate('DELETE FROM loginattempts WHERE user_id=? AND ip=?', 'is', $this->userID, $ip) : false;
        }

        /**
         * @return bool if the sessions variables has setted
         */
        protected function setSessionVariables() {
            return ($this->errorCode === 0 && $_SESSION['loggedin'] = true && $_SESSION['userID'] = $this->userID) ? true : false;
        }
    }



