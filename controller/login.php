<?php 

    require_once('../model/login.php');

    class ControllerLogin extends Login {
        public static function login() {
            if (isset($_POST['email']) && isset($_POST['password']) ) { 
                if (!parent::userExisting()) {
                if (isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
                    if (!parent::isMaxLoginAttemptsAchevied($_POST['email'])) {
                        if (parent::isCorrectPassword($_POST['email'], $_POST['password'])) {
                            if(parent::isVerified($_POST['email'])) {
                                parent::setSessionVariables($_POST['email']);
                                parent::suppAttempts($_POST['email']);
                                return 0;
                            } else {
                                //utilisateur non vérifié
                                return 4;
                            }
                        } else {
                            // password incorrect
                            if(parent::createLoginAttempt(parent::getId($_POST['email'])) !== 1){
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
                // email already using
            }
            } else {
                // toutes les données sont obligatoires
                return 6;
            }
        }
    }

    echo json_encode(ControllerLogin::login());
    