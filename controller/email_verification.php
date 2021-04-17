<?php 

    require_once('../model/login.php');
    require_once('../model/email_verification.php');
    require_once('csrfConfig.php');



    class ControllerEmailVerification extends EmailVerification {
        private static function sendEmailVerification($email) {
            if (parent::userExisting($email)) {
                if (!parent::isVerified($email)) {
                    if (!parent::isMaxEmailVerificationAttemptsAchevied($email)) {
                        $verifyCode = random_bytes(16);
                        $requestID = parent::saveHash(parent::getId($email), parent::createHashCode($verifyCode));
                        if ($requestID !== -1) {
                            if(parent::sendEmail($email, parent::getUsername($email), 'Email Verification', '<a href="http://localhost/site/view/email_verification?id=' . $requestID . '&hash=' . Config::urlSafeEncode($verifyCode) . '">cliquez sur ce lien pour vérifier votre email</a>')){
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
            if (isset($_POST['validateEmail']) && isset($_POST['csrf_token']) && ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                return self::sendEmailVerification($_POST['validateEmail']);
            }
        }
        public static function sendValidationEmailFromArgs($email, $csrfToken){
            if (isset($email) && isset($csrfToken) && ControllerCsrf::validateCsrfToken($csrfToken)) {
                return self::sendEmailVerification($email);
            }
        }

        public static function verificationEmailValidation($requestId, $hash){
            if (isset($requestId) && $requestId !== '' && isset($hash) && $hash !== '') {
                if (parent::requestExisting($requestId)) {
                    if (!parent::requestTimestampEcceded($requestId)) {
                        if (parent::verifyHash($hash, parent::getHash($requestId))) {
                            if (parent::updateDbVerified(parent::getUserId($requestId))) {
                                parent::deleteOldsRequests(parent::getUserId($requestId));
                                // email verified
                                return true;
                            }
                        }
                    }
                }
            }
            // email could not be verrified
            return false;
        }

    }

    if (isset($_POST['validateEmail']) && isset($_POST['csrf_token'])){
        echo json_encode(ControllerEmailVerification::sendEmailVerificationFromPOST());
    }