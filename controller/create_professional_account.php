<?php

    // require_once(ROOTPATH . '/model/create_account.php');
    // require_once(ROOTPATH . '/model/email_verification.php');
    require_once('../model/create_professional_account.php');
    require_once('email_verification.php');
    require_once('csrfConfig.php');



    class ControllerProCreateAccount extends CreateProAccount {
        public static function createAccount($username, $email, $password, $passwordverify, $csrfToken) {
            if(!isset($username) || strlen($username) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $username)){
                return 1;
            }

            if(!isset($email) || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                return 2;
            }elseif (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {
               return 3;
            }
            
            if(!isset($password) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $password)){
                return 4;
            } elseif (!isset($passwordverify) || $passwordverify !== $password) {
                return 5;
            }

            if (isset($csrfToken) && ControllerCsrf::validateCsrfToken($csrfToken)) {
                if (parent::isEmailNotAlreadyUsing($email)) {
                    if(parent::addUser(parent::createId(), $username, $email, $password) !== -1) {
                        if (ControllerEmailVerification::sendValidationEmailFromArgs($email, $csrfToken) === 0) {
                            return 0;
                        } else {
                            return 9;
                        }
                    } else {
                        return 6;
                    }
                } else {
                    return 7;
                }     
            } else {
                return 8;
            }
            return 10;
        }
    }

    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordVerify'])) {
        echo json_encode(ControllerProCreateAccount::createAccount(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['passwordVerify']), htmlspecialchars($_POST['csrf_token'])));
    }