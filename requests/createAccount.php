<?php 
    namespace Request;

    include_once __DIR__ . '/../model/csrfConfig.php';
    include_once __DIR__ . '/../model/config.php';
    include_once __DIR__ . '/../model/create_account.php';
    include_once __DIR__ . '/../controller/email_verification.php';

    class CreateAccountRequests extends \Model\CreateAccount {
        public static function login(string $email, string $username, string $password, string $passwordVerify, string $csrfToken){
            session_start();
            if ( \Model\Csrf::validateToken($csrfToken)) {
                if (!isset($username) || strlen($username) > 255 || !preg_match(\model\Config::USERNAME_REGEX, $username)){
                    return 1;
                }
    
                if (!isset($email) || strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                    return 2;
                } elseif (!checkdnsrr(substr($email, strpos($email, '@') + 1), 'MX')) {
                   return 3;
                }
                
                if(!isset($password) || !preg_match(\model\Config::PASSWORD_REGEX, $password)){
                    return 4;
                } elseif (!isset($passwordVerify) || $passwordVerify !== $password) {
                    return 5;
                }
                    if (parent::isEmailNotAlreadyUsing($email)) {
                        if(parent::addUser(parent::createId(), $username, $email, $password) !== -1) {
                            // if (\Controller\ControllerEmailVerification::sendValidationEmailFromArgs($email, $csrfToken) === 0) {
                                return \Controller\ControllerEmailVerification::sendValidationEmailFromArgs($email, $csrfToken);
                            //     return 0;
                            // } else {
                            //     return 9;
                            // }
                        } else {
                            return 6;
                        }
                    } else {
                        return 7;
                    }     
                return 10;
            }
            return 8;
        }
    }
    

    if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordVerify']) && isset($_POST['csrf_token'])) {
        // echo  $_POST['password'] === $_POST['passwordVerify'];

        echo json_encode(CreateAccountRequests::login($_POST['email'], $_POST['username'], $_POST['password'], $_POST['passwordVerify'],  $_POST['csrf_token']));
    }