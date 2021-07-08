<?php 
    namespace Model;
    
    include_once __DIR__ . '/database.php';

    /**
     * undocumented class
     * @author Jules
     */
    
    class User extends database{

        protected $userID;
        protected $userName;
        protected $email;
        protected $profilePicture;
        protected $bio;
        protected $pro;
        protected $verified;

        protected $errorCode = 0;


        /**
         * **Create an user object**
         * @param int $userID 
         * @param string $email
         * 
         * @return void
         */
        public function __construct(int $userID = NULL, string $email = NULL, User $user = NULL) {
            try {
                $this->setUserInfos($userID, $email, $user);
            } catch (\Throwable $th) {
                $this->errorCode = $th->getCode();
            }
        }

        /**
         * destruct the whole class
         */
        public function __destruct() {
            $this->userID = null;
            $this->userName = null;
            $this->email = null;
            $this->profilePicture = null;
            $this->bio = null;
            $this->pro = null;
            $this->verified = null;
            $this->errorCode = null;
        }

        /**
         * **Set all infos in the object**
         * @param int $userID 
         * @param string $email
         * 
         * @return void
         */
        private function setUserInfos(int $userID = NULL, string $email = NULL, User $user = NULL){
            if (!is_null($userID)) {
                $user = Database::sqlSelect('SELECT * FROM users WHERE user_id = ?', 'i', $userID);
            } elseif (!is_null($email)) {
                $user = Database::sqlSelect('SELECT * FROM users WHERE email = ?', 's', $email);
            }elseif (!is_null($user)) {
                $this->userID = $user->userID;
                $this->userName = $user->userName;
                $this->email = $user->email;
                $this->profilePicture = $user->profilePicture;
                $this->bio = $user->bio;
                $this->pro = $user->pro;
                $this->verified = $user->verified;
                $this->errorCode = $user->errorCode;
                return;
            } else {
                throw new \Exception("at least one arg is required", 1);
            }

            if ($user && $user->num_rows === 1) {
                $user =  $user->fetch_assoc();
                $this->userID = $user['user_id'];
                $this->userName = $user['username'];
                $this->email = $user['email'];
                $this->profilePicture = $user['profile_picture'];
                $this->bio = $user['bio'];
                $this->pro = $user['pro'];
                $this->verified = $user['verified'];
                return;
            }

            throw new \Exception("Unexisting user", 2);
            
        }

        /**
         * **Get the userID**
         * 
         * @return bool|int the userID of the user
         */
        public function getUserID() : int {
            return ($this->errorCode === 0) ? $this->userID : false;
        }

        /**
         * **Get the username**
         * 
         * @return boolean|string the username of the user
         */
        public function getUsername() : string {
            return  ($this->username === 0) ? $this->userID : false;
        }

        /**
         * **Get the email**
         * 
         * @return boolean|string the email of the user
         */
        public function getEmail() : string {
            return ($this->errorCode === 0) ? $this->email : false;
        }

        /**
         * **Get the ProfilePicture path**
         * 
         * @return boolean|string the profilePicture of the user
         */
        public function getProfilePicture() : string {
            return ($this->errorCode === 0) ? $this->profilePicture : false;
        }

        /**
         * **Get the Bio**
         * 
         * @return boolean|string the bio of the user
         */
        public function getBio() : string {
            return ($this->errorCode === 0) ? $this->bio : false;
        }

        /**
         * **Get the pro item**
         * 
         * @return boolean
         */
        public function isPro() : bool{
            return ($this->errorCode === 0) ? $this->pro : false;
        }

        /**
         * **Get the verified item**
         * 
         * @return boolean
         */
        public function isVerified() : bool{
            return ($this->errorCode === 0) ? $this->verified : false;
        }

        /**
         * **Get the error code**
         * 
         * @return int
         */
        public function getErrorCode() : int {
            return $this->errorCode;
        }

        /**
         * @return boolean connection statement
         */
        protected static function isConnected() : bool{
            return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']) && is_int($_SESSION['userID']) && $_SESSION['userID'] > 0;
        }

        /**
         * @param string $password
         * 
         * @return bool if the password is correct 
         */
        protected function isCorrectPassword(String $password) : bool{
            return ($this->errorCode === 0) ? password_verify($password, parent::sqlSelect('SELECT password FROM users WHERE user_id=?', 'i', $this->userID)->fetch_assoc()['password']) : false;
        }

        /**
         * @return bool|string the connection token 
         */
        protected function getConnectionToken() : string {
            return ($this->errorCode === 0) ? parent::sqlSelect('SELECT connection_token FROM users WHERE user_id=?', 'i', $this->userID)->fetch_assoc()['connection_token'] : false; 
        }

        /**
         * @return bool|string
         */
        protected function createConnectionHash() : string {
            return $this->errorCode === 0 ? parent::sqlUpdate('UPDATE users SET connection_token=? WHERE id=?', 'si', Config::createRandomSeq(100), $this->userID) : false; 
        }

        /**
         * @return bool the validity of the token in param
         */
        protected function verifyConnectionToken(string $token) : bool {
            return $this->errorCode === 0 ? password_verify($this->getConnectionToken(), $token) : false;
        }

        // protected static function protectEmail($email) {
        //     $email = explode ('@' , $email);
        //     return $email[0][0] . "..." .$email[0][-1] . "@" . $email[1];
        // }
    }

       