<?php

    // require_once(ROOTPATH . '/model/create_account.php');
    // require_once(ROOTPATH . '/model/email_verification.php');
    require_once('../model/create_account.php');
    require_once('../model/email_verification.php');

    class ControllerCreateAccount extends CreateAccount{
        public static function createAccount() {
            if(!isset($_POST['username']) || strlen($_POST['username']) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])){
                return 1;
            }
            
            if(!isset($_POST['email']) || strlen($_POST['email']) > 255 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                return 2;
            }elseif (!checkdnsrr(substr($_POST['email'], strpos($_POST['email'], '@') + 1), 'MX')) {
               return 3;
            }
            
            if(!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])){
                return 4;
            } elseif (!isset($_POST['passwordVerify']) || $_POST['passwordVerify'] !== $_POST['password']) {
                return 5;
            }

            if (isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
                if (parent::isEmailNotAlreadyUsing($_POST['email'])) {
                    if(parent::addUser(parent::createId(), $_POST['username'], $_POST['email'], $_POST['password']) !== -1){
                        if (snedValidationEmail($_POST['email']) === 0) {
                            return 0;
                        } else {
                            return 10;
                        }
                    } else {
                        return 6;
                    }
                }  else {
                    return 7;
                }     
            } else {
                return 9;
            }
        }

        public static function test(){
            return parent::createId();
        }
    }

    echo json_encode(ControllerCreateAccount::createAccount());

    // var_dump(ControllerCreateAccount::test());