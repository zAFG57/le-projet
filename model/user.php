<?php 
    require_once('database.php');
    require_once('../controller/email_verification.php');


    /**
     * undocumented class
     * 
     */
    
    class User extends database{

        private $userInfo;

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
            if (parent::sqlUpdate('UPDATE users SET username=? WHERE id = ?', 'si', password_hash($newPassword, PASSWORD_DEFAULT), $id)) {
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


    }
    