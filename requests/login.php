<?php 
    namespace Request;

    // use \Model\Csrf;
    // use \Model\Login;
    // use \Model\User;
    // use \Model\Config;

    include_once __DIR__ . '/../model/csrfConfig.php';
    include_once __DIR__ . '/../model/config.php';
    include_once __DIR__ . '/../model/user.php';
    include_once __DIR__ . '/../model/login.php';


    class LoginRequests extends \Model\Login {
        public static function login(string $email, string $password, string $csrfToken){
            session_start();
            if ( \Model\Csrf::validateToken($csrfToken)) {
                
                $user = new \Model\Login(null, $email);

                if ($user->isVerified()) {
                    if (!count($user->getLoginAttempts()) >= \Model\Config::MAX_LOGIN_ATTEMPTS_PER_HOUR) {
                        if ($user->isCorrectPassword($password)) {
                            $user->setSessionVariables();
                            return 0;
                        } else {
                            $user->createLoginAttempt();
                            return 1;
                        }
                    }
                    return 2;
                }
                return 3;
            }
            return 4;
        }
    }
    

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf_token'])) {
        echo json_encode(LoginRequests::login($_POST['email'], $_POST['password'], $_POST['csrf_token']));
    }