<?php 

    require_once('../model/user.php');
    require_once('../model/csrfConfig.php');


    class ControllerUser extends User {
        public static function getUserInfo($id) {
            if (is_int($id)) {
                return parent::getInfoUser($id);
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

        public static function modifyUser($id, $username, $email, $password, $passwordVerify) {
            $res = 0;
            if (!self::userExisiting($id)) {
                return 1;
            }
            if (password_verify($password, $passwordVerify)) {
                $user = self::getInfoUser($id, false, true);

                if (!$user['username'] === $username) {
                    if(parent::maxAttemptsChangeUsernameAchieved($id)) {
                        return 2;
                    } else {
                        if(strlen($username) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $username)){
                            return 3;
                        }
                        if (parent::ModifyUsername($id, $username)) {
                            if(!parent::addAttemptChangeUsername($id)) {
                                return 9; // 
                            }
                            
                        } else {
                            return 9; // 
                        }
                    }
                }  
                
                if (!$user['email'] === $email) {
                    if(parent::maxAttemptsChangeEmailAchieved($id)) {
                        return 4;
                    } else {
                        if(strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                            return 5;
                        }elseif (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {
                           return 6;
                        }
                        if (parent::ModifyEmail($id, $email)) {
                            if(!parent::addAttemptChangeEmail($id)) {
                                return 9; // 
                            }
                            
                        } else {
                            return 9; // 
                        }
                    }
                }
                
                if (!password_verify($password, $user['password'])) {
                    if(parent::maxAttemptsChangePasswordAchieved($id)) {
                        return 7;
                    } else {
                        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $password)){
                            return 8;
                        }
                        if (parent::ModifyPassword($id, $password)) {
                            if(!parent::addAttemptChangePass($id)) {
                                return 9; // 
                            }
                        } else {
                            return 9; // 
                        }
                    }
                }
            }
            return $res;
        }
    }


    
    if (isset($_POST['usernameChange']) && isset($_POST['emailChange']) && isset($_POST['passwordChange']) && isset($_POST['passwordVerifyChange']) && isset($_POST['userIdChange']) && isset($_POST['csrf_token'])){
        session_start();
        if(ControllerCsrf::validateCsrfToken($_POST['csrf_token']) && $_POST['userIdChange'] === $SESSION['userID']) {
            echo json_encode(ControllerUser::modifyUser($_POST['userIdChange'], $_POST['usernameChange'], $_POST['emailChange'], $_POST['passwordChange'], $_POST['passwordVerifyChange']));
        }
    }
    