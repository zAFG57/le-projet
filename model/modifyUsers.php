<?php 
    namespace Model;

use function PHPSTORM_META\type;

include_once __DIR__ . '/user.php';

    class ModifyUsers extends User {

    protected $modifyProfileAttempts;

        /**
         * **Create an ModifyUsers object**
         * @param int $userID 
         * @param string $email
         * @param User $user
         * 
         * @return void
         */
        public function __construct(int $userID = NULL, string $email = NULL, User $user = NULL) {
            parent::__construct($userID, $email, $user);
            $this->setModifyProfileAttempts();
        }
        
        /**
         * **set all attempts actives**
         * @return void
         */
        protected function setModifyProfileAttempts() {
            if ($this->errorCode === 0) {
                $attempts = parent::sqlSelect(
                    'SELECT * FROM modify_user_attempt WHERE user_id = ? AND timestamp>?',
                    'ii', 
                    $this->userID, time() - Config::MAX_ATTEMPTS_TIME_USERS['general']
                );

                if ($attempts && $attempts->num_rows >= 1 ) {
                    $this->sortAttempts($attempts->fetch_all(MYSQLI_ASSOC));
                    // $this->modifyProfileAttempts =  $attempts->fetch_all(MYSQLI_ASSOC);

                    return true;
                }

                $this->resetAttempts();
                return false;
            }
        }

        /**
         * @param array $data
         * @return void
         */
        private function sortAttempts(array $data) {
            if ($this->errorCode === 0) {
                $this->resetAttempts();
                foreach ($data as $attempt) {
                    array_push($this->modifyProfileAttempts[$attempt['type']], $attempt);
                }
            }
        }
        /**
         * reset the attempt variable 
         * @var array $modifyProfileAttempts
         */
        private function resetAttempts(){
            $this->modifyProfileAttempts = array(
                'username' => [],
                'password' => [],
                'bio' => [],
                'email' => [],
                'profile_picture' => []
            );
        }

        /**
         * @return array all modify profile attempts
         */
        public function getAttempts(){
            return ($this->setModifyProfileAttempts() && $this->errorCode === 0) ? $this->modifyProfileAttempts : false;
        }

        /**
         * @param string|array $input
         * @param string $type
         * @return bool if the input is accepted by the system
         */
        protected function isAcceptableInput($input, string $type) {
            if ($this->errorCode === 0) {
                switch ($type) {
                    case 'username':
                        return preg_match(Config::USERNAME_REGEX, $input);

                    case 'password':
                        return preg_match(Config::PASSWORD_REGEX, $input);
                    
                    case 'bio':
                        return preg_match(Config::BIO_REGEX, $input);
                    
                    case 'email':
                        return checkdnsrr(substr($input, strpos($input, '@') + 1), 'MX') && filter_var($input, FILTER_VALIDATE_EMAIL);
                    
                    case 'profile_picture':
                        return $this->validateImageType($input);
                    
                    default:
                        return false;
                }
            }
        }

        /**
         * @param array $file
         * @return bool if the file is accepted
         */
        protected function validateImageType($file) {
            if ($this->errorCode === 0) {
                if ($file["error"] === 0) {
                    $allowed = array('png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg');
                    return array_key_exists(pathinfo($file["name"], PATHINFO_EXTENSION), $allowed) && $file["size"] <= Config::MAX_SIZE_PROFILE_PICTURE;
                }
            }
            return false;
        }

        /**
         * @param string $type
         * @param string|array $args
         * 
         * @return bool if the modification successful
         */
        protected function modifyUserProfile($type, $args) {
            if ($this->errorCode === 0) {
                if ($type === 'profile_picture') {
                    $args = $this->modifyUserProfilePicture($args, Config::createRandomSeq(75), true);
                }
                return Database::sqlUpdate("UPDATE users SET {$type} = ? WHERE user_id = ?", 'si', $args, $this->userID);
            }
            return false;
        }

        /**
         * @param array $file
         * @param string $seq
         * @param bool $returnSeq
         * 
         * @return string|bool 
         */
        protected function modifyUserProfilePicture($file, $seq, $returnSeq) {
            if ($this->errorCode === 0) {
                if ($this->deleteUserProfilePicture($this->userID)) {
                    if ($this->addUserProfilePicture($this->userID, $file, $seq)) {
                        return $returnSeq ? $seq . pathinfo($file['name'], PATHINFO_EXTENSION) : true; 
                    }
                }
            }
            return false;
        }
        
        /**
         * @return bool if the deletation successful
         */
        private function deleteUserProfilePicture() {
            if ($this->errorCode === 0) {
                if (file_exists(Config::FOLDER_STACK_USERS . $this->userID . '/' . $this->profilePicture)) {
                    return unlink(Config::FOLDER_STACK_USERS .  $this->userID . '/' . $this->profilePicture);
                }
            }
            return false;
        }

        /**
         * @param array $file
         * @param string $seq
         * 
         * @return bool if the file has been save
         */
        private function addUserProfilePicture($file, $seq) {
            if ($this->errorCode === 0) {
                return move_uploaded_file($file["tmp_name"], Config::FOLDER_STACK_USERS .  $this->userID . '/' . $seq . '.' . pathinfo($file['name'], PATHINFO_EXTENSION));
            }
        }
    }
    