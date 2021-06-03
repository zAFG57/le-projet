<?php 
    namespace Controller;

    use \Model\User;

    include_once  __DIR__ . '/../model/user.php';
    include_once  __DIR__ . '/../controller/email_verification.php';
    include_once  __DIR__ . '/../controller/csrfConfig.php';

    class ControllerUser extends User {
        public static function getUserInfo($id, $protectEmail = true, $getPassword = false, $bothEmail = false) {
            if (is_int($id)) {
                return parent::getInfoUser($id, $protectEmail, $getPassword, $bothEmail);
            }
        }

        public static function userExisiting($id) {
            return parent::userExisting($id);
        }
        public static function isPro($id) {
            if (is_int($id)) {
                return parent::isPro($id);
            }
        }

        public static function isConnected() {
            return parent::isConnected();
        }

        public static function isAdmin($id) {
            if (is_int($id)) {
                return parent::isAdmin($id);
            }
        }

        public static function getUserName($id) {
            if (is_int($id)) {
                return parent::getUserName($id);
            }
        }

        public static function modifyUser($id, $username, $email, $password, $passwordVerify, $csrfToken) {

            $res = 0;
            if (!self::userExisiting($id)) {
                return 1;
            }

            $user = self::getUserInfo($id, false, true, true);
          
            if (password_verify($passwordVerify, $user['password'])) {

                if ($user['username'] !== $username) {
                    if(parent::maxAttemptsChangeUsernameAchieved($id)) {
                        return 2;
                    } else {
                        if(strlen($username) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $username)){
                            return 3;
                        }
                        if (parent::ModifyUsername($id, $username)) {
                            if(!parent::addAttemptChangeUsername($id)) {
                                return 9;
                            }
                        } else {
                            return 9;
                        }
                    }
                }  
                
                if ($user['email'] !== $email && $user['emailProtected'] !== $email) {

                    if(parent::maxAttemptsChangeEmailAchieved($id)) {
                        return 4;
                    } else {

                        if(strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                            return 5;
                        }elseif (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {
                           return 6;
                        }
                        if (parent::ModifyEmail($id, $email, $csrfToken)) {
                            if(!parent::addAttemptChangeEmail($id)) {
                                return 9;
                            }   
                            
                        } else {
                            return 9;
                        }
                    }
                }
                
                if ($password !==  "defaultPassword") {
                    if(parent::maxAttemptsChangePasswordAchieved($id)) {
                        return 7;
                    } else {
                        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $password)){
                            return 8;
                        }
                        if (parent::ModifyPassword($id, $password)) {
                            if(!parent::addAttemptChangePass($id)) {
                                return 9;
                            }
                        } else {
                            return 9;
                        }
                    }
                }
            } else {
                return 10;
            }
            return $res;
        }

        public static function forgotPasswordSend($email) {
            $userID = parent::getUserIDFromEmail($email);
            if ($userID) {
                if (self::userExisiting($userID)) {
                    if (!parent::maxForgotPasswordAttemptAchieved($userID)) {
                        $hash = parent::createTokenForgotPassword();
                        parent::saveForgotPasswordAttempt($userID, $hash);
                        if (ControllerEmailVerification::sendEmailForgotPassword($email, $hash)) {
                            return 0;
                        } else {
                            return 1;
                        }
                    } else {
                        return 2;
                    }
                } else {
                    return 3;
                }
            } else {
                return 4;
            }
        }

        public static function forgotPasswordVerify($hash) {
            return parent::validateTokenForgotPassword(htmlspecialchars($hash));
        }

        public static function changePasswordForgot($newPassword, $newPasswordVerify, $hash) {
            if (parent::forgotPasswordAttemptExisting($hash)) {
                if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $newPassword)){
                    if ($newPassword === $newPasswordVerify) {
                        if(parent::ModifyPassword(parent::getUserIDFromHashForgotPassword($hash), $newPassword)) {
                            parent::destroyAttempt($hash);
                            return 0;
                        } else {
                            return 1;
                        }
                    } else {
                        return 2;
                    }
                } else {
                    return 3;
                }
            } else {
                return 4;
            }
        }
    }
    
    if (isset($_POST['usernameChange']) && isset($_POST['emailChange']) && isset($_POST['passwordChange']) && isset($_POST['passwordVerifyChange']) && isset($_POST['userIdChange']) && isset($_POST['csrf_token'])){
        session_start();
        if(ControllerCsrf::validateCsrfToken($_POST['csrf_token']) && intval($_POST['userIdChange']) === $_SESSION['userID']) { 
            echo json_encode(ControllerUser::modifyUser(intval(($_POST['userIdChange'])), trim($_POST['usernameChange']), trim($_POST['emailChange']), trim($_POST['passwordChange']), trim($_POST['passwordVerifyChange']), trim($_POST['csrf_token'])));
        }
    }
    if (isset($_POST['newPasswordForgotPassword']) && isset($_POST['newValidatePasswordForgotPassword']) && isset($_POST['hash']) && isset($_POST['csrf_token'])){
        session_start();
        if(ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) { 
            echo json_encode(ControllerUser::changePasswordForgot($_POST['newPasswordForgotPassword'], $_POST['newValidatePasswordForgotPassword'], $_POST['hash']));
        }
    }
    
    if (isset($_POST['emailForgotPassword']) && isset($_POST['csrf_token'])){
        session_start();
        if(ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) { 
            echo json_encode(ControllerUser::forgotPasswordSend(htmlspecialchars($_POST['emailForgotPassword'])));
        }
    }
    