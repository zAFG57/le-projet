<?php 

    require_once('../model/login.php');
    require_once('../model/email_verification.php');


    class ControllerEmailVerification extends EmailVerification {
        private static function sendEmailVerification($email) {
            if (parent::userExisting($email)) {
                if (!parent::isVerified($email)) {
                    if (!parent::isMaxEmailVerificationAttemptsAchevied($email)) {
                        $verifyCode = random_bytes(16);
                        $requestID = parent::saveHash(parent::getId($email), parent::createHashCode($verifyCode));
                        if ($requestID !== -1) {
                            if(parent::sendEmail($email, parent::getUsername($email), 'Email Verification', '<a href="http://localhost/site/view/email_verification?id=' . $requestID . '&hash=' .urlSafeEncode($verifyCode) . '">cliquez sur ce lien pour vérifier votre email</a>')){
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
            } else {
                return 5;
            }
            return 6;
        }

        public static function sendEmailVerificationFromPOST() {
            if (isset($_POST['validateEmail']) && isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
                return self::sendEmailVerification($_POST['validateEmail']);
            }
        }
        public static function sendValidationEmailFromArgs($email, $csrfToken){
            if (isset($email) && isset($csrfToken) && validateToken($csrfToken)) {
                return self::sendEmailVerification($email);
            }
        }

    }

    return json_encode(ControllerEmailVerification::sendEmailVerificationFromPOST());