<?php 
    namespace Model;

    use Controller\ControllerEmailVerification;
    
    include_once __DIR__ . '/../controller/email_verification.php';
    include_once __DIR__ . '/database.php';

    /**
     * undocumented class
     * @author Jules
     */
    
    class User extends database{

        public function __construct($id) {
            self::getInfoUser($id);
        }

        protected static function getInfoUser($id, $protectEmail = true, $getPassword = false, $bothEmail = false) {
            if (!$id) return;

            $userInfo = -1;
            if ($getPassword) {
                $res = parent::sqlSelect('SELECT 
                users.id, users.username, users.password, users.email, users.verified, users.pro
                FROM users 
                WHERE users.id = ?',
                'i', $id);

            } else {
                $res = parent::sqlSelect('SELECT 
                users.id, users.username, users.email, users.verified, users.pro
                FROM users 
                WHERE users.id = ?',
                'i', $id);
             }
            if ($res && $res->num_rows === 1) {
                $userInfo = $res->fetch_assoc();
                if ($bothEmail) {
                    $userInfo['emailProtected'] = self::protectEmail($userInfo['email']);
                    // return  $userInfo['emailProtected'];
                }

                if ($protectEmail) {
                    $userInfo['email'] = self::protectEmail($userInfo['email']);
                } 
            
                // return $userInfo;
                if (self::isPro($userInfo['id'])) {
                    $ress = parent::sqlSelect('SELECT 
                    ville, objets_reparables, note
                    FROM pro_users WHERE pro_users.user_id = ?',
                    'i', $id);

                    if ($ress && $ress->num_rows === 1) {
                        $userInfo += $ress->fetch_assoc();
                    } 
                }
            }
            return $userInfo;
        }

        protected static function isPro($id){
            return parent::sqlSelect('SELECT users.pro FROM users WHERE users.id = ?', 'i', $id)->fetch_assoc()['pro'] === 1;
        }

        protected static function isConnected() {
            return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']) && is_int($_SESSION['userID']) && $_SESSION['userID'] > 0;
        }

        protected static function isAdmin($id) {
            $res = parent::sqlSelect('SELECT admin_type FROM admin WHERE admin.user_id = ?', 'i', $id);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro) {
                    return $userPro['admin_type'] === 'super admin';  
                }
            }
            return false;
        }

        protected static function userExisting($id) {
            return parent::sqlSelect('SELECT id FROM users WHERE id = ?', 'i', $id)->num_rows === 1;
        }

        protected static function getUserName($id) {
            return parent::sqlSelect('SELECT username FROM users WHERE id = ?', 'i', $id)->fetch_assoc()['username'];
            
        }

        protected static function protectEmail($email) {
            $email = explode ('@' , $email);
            return $email[0][0] . "..." .$email[0][-1] . "@" . $email[1];
        }



        // modification on users

        protected static function modifyUsername($id, $username) {
            // if ()) {
                // return ControllerEmailVerification::sendEmailToModifyUsername($id);
            // }
            return parent::sqlUpdate('UPDATE users SET username=? WHERE id = ?', 'si', $username, $id);
        } 

        protected static function modifyPassword($id, $newPassword) {
            return parent::sqlUpdate('UPDATE users SET password=? WHERE id = ?', 'si', password_hash($newPassword, PASSWORD_DEFAULT), $id);
            // if () {
                // return ControllerEmailVerification::sendEmailToModifyPassword($id);
            // }
        }

        protected static function modifyEmail($id, $newEmail) {
            return parent::sqlUpdate('UPDATE users SET email=? WHERE id = ?', 'si', $newEmail, $id);
            // if () {
                // ControllerEmailVerification::sendValidationEmailFromArgs($newEmail, $csrfToken);
                // return parent::sqlUpdate('UPDATE users SET verified=0 WHERE id = ?', 'i', $id);
            // }
        }

        protected static function maxAttemptsChangeUsernameAchieved($id) {
            return parent::sqlSelect('SELECT COUNT(change_username_attempts.id) FROM users LEFT JOIN change_username_attempts ON users.id = change_username_attempts.user_id AND change_username_attempts.timestamp>? WHERE users.id=? GROUP BY users.id', 'ii', time() - 60*60*24*10, $id)->fetch_assoc()['COUNT(change_username_attempts.id)'] >= Config::$maxChangeAttempt;
        }

        protected static function maxAttemptsChangeEmailAchieved($id) {
            return parent::sqlSelect('SELECT COUNT(change_email_attempts.id) FROM users LEFT JOIN change_email_attempts ON users.id = change_email_attempts.user_id AND change_email_attempts.timestamp>? WHERE users.id=? GROUP BY users.id', 'ii', time() - 60*60*24*90, $id)->fetch_assoc()['COUNT(change_email_attempts.id)'] >= Config::$maxChangeAttempt;
        }

        protected static function maxAttemptsChangePasswordAchieved($id) {
            return parent::sqlSelect('SELECT COUNT(change_password_attempts.id) FROM users LEFT JOIN change_password_attempts ON users.id = change_password_attempts.user_id AND change_password_attempts.timestamp>? WHERE users.id=? GROUP BY users.id', 'ii', time() - 60*60*24*5, $id)->fetch_assoc()['COUNT(change_password_attempts.id)'] >= Config::$maxChangeAttempt;
        }




        protected static function addAttemptChangeUsername($id) {
            return parent::sqlInsert('INSERT INTO change_username_attempts VALUES (NULL, ?, ?, ?)', 'isi', $id, $_SERVER['REMOTE_ADDR'], time());
        }

        protected static function addAttemptChangeEmail($id) {
            return parent::sqlInsert('INSERT INTO change_email_attempts VALUES (NULL, ?, ?, ?)', 'isi', $id, $_SERVER['REMOTE_ADDR'], time());
        }

        protected static function addAttemptChangePass($id) {
            return parent::sqlInsert('INSERT INTO change_password_attempts VALUES (NULL, ?, ?, ?)', 'isi', $id, $_SERVER['REMOTE_ADDR'], time());
        }

        protected static function addAttemptChangeForgotPass($userID) {
            return parent::sqlInsert('INSERT INTO change_password_attempts VALUES (NULL, ?, ?, ?)', 'isi', $userID, $_SERVER['REMOTE_ADDR'], time());
        }





        
        protected static function createTokenForgotPassword() {
            $seed = Config::urlSafeEncode(random_bytes(8));
            $t = time();
            $hash = Config::urlSafeEncode(hash_hmac('sha256', $seed . $t, Config::$FORGOT_PASS_SECRET_TOKEN, true));
            return Config::urlSafeEncode($hash . '|' . $seed . '|' . $t);
        }

        protected static function saveForgotPasswordAttempt($userID, $hash) {
            return parent::sqlInsert('INSERT INTO forgot_password_attempts VALUES (NULL, ?, ?, ?, ?, "on")', 'issi', $userID,  $hash, $_SERVER['REMOTE_ADDR'], time());
        }

        protected static function getHashForgotPasswordAttempt($userID) {
            return parent::sqlSelect('SELECT hash FROM forgot_password_attempts WHERE user_id=? AND timestamp>? AND status="on"', 'ii', $userID, time() - 30*60)->fetch_assoc()['hash'];
        }

        protected static function maxForgotPasswordAttemptAchieved($userID) {
            return parent::sqlSelect('SELECT id FROM forgot_password_attempts WHERE user_id=? AND timestamp>?', 'ii', $userID, time() - 30*60)->num_rows >= 1;
        }

        protected static function validateTokenForgotPassword($token) {
            $parts = explode('|', Config::urlSafeDecode($token));
            if(count($parts) === 3) {
                $hash = hash_hmac('sha256', $parts[1] . $parts[2], Config::$FORGOT_PASS_SECRET_TOKEN, true);
                if(hash_equals($hash, Config::urlSafeDecode($parts[0]))) {
                    return true;
                }
            }
            return false;
        }

        protected static function getUserIDFromEmail($email) {
            return parent::sqlSelect('SELECT id FROM users WHERE email=?', 's',$email)->fetch_assoc()['id'];
        }


        protected static function forgotPasswordAttemptExisting($hash) {
            return parent::sqlSelect('SELECT id FROM forgot_password_attempts WHERE hash=? AND status="on"' , 's',$hash)->num_rows == 1; 
        }

        protected static function getUserIDFromHashForgotPassword($hash) {
            return parent::sqlSelect('SELECT user_id FROM forgot_password_attempts WHERE hash=?', 's',$hash)->fetch_assoc()['user_id']; 
        }

        protected static function destroyAttempt($hash){
            return parent::sqlUpdate('UPDATE forgot_password_attempts SET status="off" WHERE hash=?', 's',$hash);
        }

        protected static function getHashFromUserID($id) {
            return parent::sqlSelect('SELECT connection_token FROM users WHERE id=?', 'i',$id)->fetch_assoc()['connection_token']; 
        }

       

        protected static function isCorrectPassword($userID, $password) {
            return password_verify($password, parent::sqlSelect('SELECT password FROM users WHERE id=?', 'i',$userID)->fetch_assoc()['password']);
        }


        // modify users

        protected static function maxAttemptsAchieved($userID, $type) {
            return parent::sqlSelect('SELECT COUNT(id) FROM modification_users WHERE user_id = ? && type = ? && timestamp > ?', 'isi', $userID, $type, time() - Config::$MAX_ATTEMPTS_TIME_USERS[$type][0])->fetch_assoc()['COUNT(id)'] >= Config::$MAX_ATTEMPTS_TIME_USERS[$type][1];
        }

        protected static function isAcceptableInput($input, $type) {
            switch ($type) {
                case 'username':
                    return preg_match(Config::$USERNAME_REGEX, $input);
                
                case 'password':
                    return preg_match(Config::$PASSWORD_REGEX, $input);
                
                case 'bio':
                    return preg_match(Config::$BIO_REGEX, $input);
                
                case 'email':
                    return checkdnsrr(substr($input, strpos($input, '@') + 1), 'MX') && filter_var($input, FILTER_VALIDATE_EMAIL);
                
                case 'profilePicture':
                    return self::validateImageType($input);
                
                default:
                    return false;
            }
        }

        protected static function validateImageType($file) {
            if ($file["error"] === 0) {
                $allowed = array('png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg');
                return array_key_exists(pathinfo($file["name"], PATHINFO_EXTENSION), $allowed) && $file["size"] <= Config::$MAX_SIZE_PROFILE_PICTURE;
            }
            return false;
        }


        protected static function modifyUserProfile($userID, $type, $args) {
            if ($type === 'profilePicture') {
                $args = self::modifyUserProfilePicture($userID, $args, self::createProfilePicturefileName(), true);
            }
            return Database::sqlUpdate("UPDATE users SET {$type} = ? WHERE user_id = ?", 'si', $args, $userID);
        }

        protected static function modifyUserProfilePicture($userID, $file, $seq, $returnSeq) {
            if (self::deleteUserProfilePicture($userID)) {
                if (self::addUserProfilePicture($userID, $file, $seq)) {
                    return $returnSeq ? $seq . pathinfo($file['name'], PATHINFO_EXTENSION) : true; 
                }
            }
            return false;
            // users/userID/seq. -> /png/jpg/jpeg
        }
        
        private static function deleteUserProfilePicture($userID) {
            if (file_exists(Config::$FOLDER_STACK_USERS . $userID . '/' . self::getProfilePictureSeq($userID))) {
                return unlink(Config::$FOLDER_STACK_USERS .  $userID . '/' .self::getProfilePictureSeq($userID));
            }
        }

        private static function addUserProfilePicture($userID, $file, $seq) {
            while (!file_exists(Config::$FOLDER_STACK_USERS . $userID . '/' . $seq . '.' . pathinfo($file['name'], PATHINFO_EXTENSION))) {
                return move_uploaded_file($file["tmp_name"], Config::$FOLDER_STACK_USERS .  $userID . '/' . $seq . '.' . pathinfo($file['name'], PATHINFO_EXTENSION));
            }
        }

        protected static function createProfilePicturefileName() {
            do {
                $res = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(25/strlen($x)) )),1,25);
            } while (self::seqExist($res));
            return $res;
        }

        protected static function seqExist($seq) {
            foreach (Database::sqlSelect('SELECT profilePicture FROM users')->fetch_assoc()['profilePicture'] as $userSeq) {
                if (explode('.', $userSeq)[0] === $seq) {
                    return true;
                }
            }
            return false;
        }
        protected static function getProfilePictureSeq($userID) {
            return Database::sqlSelect('SELECT profilePicture FROM users WHERE id=?', 'i', $userID);
        }

        // connection token

            protected static function createConnectionHash($id) {
                return parent::sqlUpdate('UPDATE users SET connection_token=? WHERE id=?', 'si', self::randomConnectiontoken(), $id); 
            }

            protected static function verifyConnectionToken($userID, $token) {
                if (self::userExisting($userID)) {
                    return password_verify(self::getHashFromUserID($userID), $token);
                }
                return false;
            }
            protected static function randomConnectiontoken() {
                return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(100/strlen($x)) )),1,100);
            }
        //
    }