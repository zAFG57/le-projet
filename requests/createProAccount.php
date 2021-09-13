<?php 
    namespace Request;

    include_once __DIR__ . '/../model/csrfConfig.php';
    include_once __DIR__ . '/../model/config.php';
    include_once __DIR__ . '/../controller/email_verification.php';


    class CreateProAccountRequests extends \Model\CreateProAccount {
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
                } elseif (!isset($passwordverify) || $passwordverify !== $password) {
                    return 5;
                }
                    if (parent::isEmailNotAlreadyUsing($email)) {
                        if(parent::addUser(parent::createId(), $username, $email, $password) !== -1) {
                            if (\Controller\ControllerEmailVerification::sendValidationEmailFromArgs($email, $csrfToken) === 0) {
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
                return 10;
            }
            return 8;
        }
    }
    

    if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordVerify']) && isset($_POST['csrf_token'])) {
        echo json_encode(CreateProAccountRequests::login($_POST['email'], $_POST['username'], $_POST['password'], $_POST['passwordVerify'], $_POST['csrf_token']));
    }