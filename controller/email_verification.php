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
            if (isset($_POST['validateEmail']) && isset($_POST['csrf_token']) && ControllerCsrf::validateCsrfToken(htmlspecialchars($_POST['csrf_token']))) {
                return self::sendEmailVerification(htmlspecialchars($_POST['validateEmail']));
            }
        }
        public static function sendValidationEmailFromArgs($email, $csrfToken){
            if (isset($email) && isset($csrfToken) && ControllerCsrf::validateCsrfToken(htmlspecialchars($csrfToken))) {
                return self::sendEmailVerification(htmlspecialchars($email));
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

        public static function sendEmailToModifyUsername($id){
            return parent::sendEmail(parent::getEmail($id), parent::getUsername(parent::getEmail($id)), "modification du nom d'utilisateur", "Votre nom d'utilisateur a bien été changé");
        }

        public static function sendEmailToModifyPassword($id){
            return parent::sendEmail(parent::getEmail($id), parent::getUsername(parent::getEmail($id)), "Mot de passe modifié", "Votre mot de passe a bien été changé");
        }

        public static function sendEmailForgotPassword($email, $hash){
            return parent::sendEmail($email, parent::getUsername($email), "Changement de mot de passe", '<a href="' . Config::$FORGOT_PASSWORD_LINK . '?h=' . $hash . '">Cliquez ici pour reset votre mot de passe</a> <br/> <p>si vous n\'etes pas a l\'origine de ce changement ne cliquez sur aucun lien</p>');
        }
    }

    if (isset($_POST['validateEmail']) && isset($_POST['csrf_token'])){
        echo json_encode(ControllerEmailVerification::sendEmailVerificationFromPOST());
    }