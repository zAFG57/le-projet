<?php 
    namespace Controller;

    use \Model\EmailVerification;
    use \Model\Config;

    include_once __DIR__ . '/../model/email_verification.php';
    include_once __DIR__ . '/../model/config.php';

    class ControllerEmailVerification extends EmailVerification {
        private static function sendEmailVerification($email) {
            if (parent::userExisting($email)) {
                if (!parent::isVerified($email)) {
                    if (!parent::isMaxEmailVerificationAttemptsAchevied($email)) {
                        $verifyCode = random_bytes(16);
                        $requestID = parent::saveHash(parent::getId($email), parent::createHashCode($verifyCode));
                        if ($requestID !== -1) {
                            if(parent::sendEmail($email, parent::getUsername($email), 'Email Verification', '<html><head></head><body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><table bgcolor="#2f743b" width="100%" border="0" cellpadding="0" cellspacing="0"><tbody><tr><td><table width="50%" leftmargin="25%" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td height="250" style="font-size:250px;line-height:250px;" border="0"> </td></tr><tr><td style="text-align:center;font-size:200%;"><a href="http://localhost/site/view/email_verification?id=' . $requestID . '&amp;hash=' . Config::urlSafeEncode($verifyCode) . '" style="color: #FFF;text-decoration:none;">cliquez ici pour vérifier votre email</a></td></tr><tr><td height="250" style="font-size:250px;line-height:250px;" border="0"> </td></tr></tbody></table></td></tr></tbody></table></body></html>')){
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

        public static function sendEmailVerificationFromPOST($email) {
           
                return self::sendEmailVerification($email);
            
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
        echo json_encode(ControllerEmailVerification::sendEmailVerificationFromPOST(htmlspecialchars($_POST['validateEmail'])));
    }