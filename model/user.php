<?php 
    namespace Model;

    use Controller\ControllerEmailVerification;
    
    include_once  __DIR__ . '/../controller/email_verification.php';
    include_once  __DIR__ . '/database.php';

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

        protected static function ModifyUsername($id, $username) {
            if (parent::sqlUpdate('UPDATE users SET username=? WHERE id = ?', 'si', $username, $id)) {
                return ControllerEmailVerification::sendEmailToModifyUsername($id);
            }
        } 

        protected static function ModifyPassword($id, $newPassword) {
            if (parent::sqlUpdate('UPDATE users SET password=? WHERE id = ?', 'si', password_hash($newPassword, PASSWORD_DEFAULT), $id)) {
                return ControllerEmailVerification::sendEmailToModifyPassword($id);
            }
        }

        protected static function ModifyEmail($id, $newEmail, $csrfToken) {
            if (parent::sqlUpdate('UPDATE users SET email=? WHERE id = ?', 'si', $newEmail, $id)) {
                ControllerEmailVerification::sendValidationEmailFromArgs($newEmail, $csrfToken);
                return parent::sqlUpdate('UPDATE users SET verified=0 WHERE id = ?', 'i', $id);
            }
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
    }
    