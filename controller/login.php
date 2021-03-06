<?php
    namespace Controller;
    
    use \Model\Login;
    
    include_once '../controller/csrfConfig.php';
    include_once '../model/login.php';

    
    class ControllerLogin extends Login {
        public static function login($email, $password, $csrfToken) {
            if (isset($email) && isset($password) ) {
                if (parent::userExisting($email)) {
                if (isset($csrfToken) && ControllerCsrf::validateCsrfToken($csrfToken)) {
                    if (!parent::isMaxLoginAttemptsAchevied($email, $_SERVER['REMOTE_ADDR'])) {
                        if (parent::isCorrectPassword($email, $password)) {
                            if(parent::isVerified($email)) {
                                // session_start();
                                parent::setSessionVariables($email);
                                parent::suppAttempts($email, $_SERVER['REMOTE_ADDR']);
                                return 0;
                            } else {
                                //utilisateur non vérifié
                                return 4;
                            }
                        } else {
                            // password incorrect (email or pass bad)
                            if(parent::createLoginAttempt(parent::getId($email)) !== 1){
                                return 1;
                            } else {
                                return 2;
                            }
                        }
                    } else {
                        //trop d'essay en 1 heure
                        return 3;
                    }
                } else {
                    // csrf token invalide
                    return 5;
                }
            } else {
                // user not existing (email or pass bad)
                return 1;
            }
            } else {
                // toutes les données sont obligatoires
                return 6;
            }
        }
    }

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf_token'])) {
        session_start();
        echo json_encode(ControllerLogin::login($_POST['email'], $_POST['password'], $_POST['csrf_token']));
    }
