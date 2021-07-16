<?php 
    namespace Controller;

    use \Model\User;
    use \Model\Config;

    include_once __DIR__ . '/../model/user.php';
    include_once __DIR__ . '/../controller/email_verification.php';
    include_once __DIR__ . '/../controller/csrfConfig.php';

    class ControllerUser extends User {
        // public static function getUserInfo($id, $protectEmail = true, $getPassword = false, $bothEmail = false) {
        //     if (is_int($id)) {
        //         return parent::getInfoUser($id, $protectEmail, $getPassword, $bothEmail);
        //     }
        // }

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
        
        /**
         * @param string $hash 
         * @return int the userID of the user
         */

        public static function getHashFromUserID($id) {
            if (self::userExisting($id)) {
                return parent::getHashFromUserID($id);
            }
            return false;
        }

        public static function createConnectionHash($userID) {
            if (parent::userExisting($userID)) {
                parent::createConnectionHash($userID);
            }
            return false;
        }

        public static function verifyConnectionToken($userID, $token) {
            if (parent::userExisting($userID)) {
                return parent::verifyConnectionToken($userID, $token);
            }
            return false;
        }

        public static function isCorrectPassword($userID, $password) {
            return parent::isCorrectPassword($userID, $password);
        }

        /////////////////////////  MODIFY USER /////////////////////

        public static function modifyUser($userID, $connectionToken, $password, $type, ...$args) {
            if (parent::userExisting($userID)) {
                if (self::verifyConnectionToken($userID, $connectionToken)) {
                    if (self::isCorrectPassword($userID, $password)) {
                        $typesAllowed = ['username', 'password', 'bio', 'profilePicture', 'email'];
                        if (in_array($type, $typesAllowed, true)) {
                            if (!parent::maxAttemptsAchieved($userID, $type)) {
                                if (parent::isAcceptableInput($type, $args[0])) {

                                    switch ($type) {
                                        case 'password':
                                            // password and passwordverify
                                            if (!$args[0] === $args[1]) {
                                                return 8;
                                            }
                                            break;
                                    }

                                    if(parent::modifyUserProfile($userID, $type, $args[0])){
                                        return 0;
                                    }
                                    return 1;
                                }   
                                return 2;
                            }
                            return 3;
                        }
                        return 4;
                    }
                    return 5;
                }
                return 6;
            }
            return 7;
        }

    }
    
    // if (isset($_POST['usernameChange']) && isset($_POST['emailChange']) && isset($_POST['passwordChange']) && isset($_POST['passwordVerifyChange']) && isset($_POST['userIdChange']) && isset($_POST['csrf_token'])){
    //     session_start();
    //     if(ControllerCsrf::validateCsrfToken($_POST['csrf_token']) && intval($_POST['userIdChange']) === $_SESSION['userID']) { 
    //         echo json_encode(ControllerUser::modifyUser(intval(($_POST['userIdChange'])), trim($_POST['usernameChange']), trim($_POST['emailChange']), trim($_POST['passwordChange']), trim($_POST['passwordVerifyChange']), trim($_POST['csrf_token'])));
    //     }
    // }
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
