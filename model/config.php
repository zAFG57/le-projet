<?php 

    class Config {

        protected static $DB_USERNAME = 'root';
        protected static $DB_PASSWORD = '';
        protected static $DB_DATABASE = 'sitetheproject';
        protected static $DB_HOST = 'localhost';

        protected static $CSRF_TOKEN_SECRET = '123zqddrg123rth14561f21fq54d9821hz65qdzzqdq';

        protected static $ADMIN_TOKEN_SECRET = '1qzd5q4r7zd6q5z415q4z56q4dzq84dq5d1zq87rf8v5k6i8r4rd84qnz';

        protected static $MESSAGE_KEY_SECRET = '5d4f88t965az625l5i1u21b5e456w4x56dzd54qzdz845484zd4qzd5sd6r99ikupo87sef845151s5jjh5d4dz';

        protected static $SMTP_HOST = 'smtp.gmail.com';
        protected static $SMTP_PORT = 465;
        protected static $SMTP_USERNAME = 'contact.mesreparations@gmail.com';
        protected static $SMTP_PASSWORD = 'jjmumjlrozleukka';
        protected static $SMTP_FROM = 'contact.mesreparations@gmail.com';
        protected static $SMTP_FROM_NAME = '[Mes reparations.com] No-reply';

        protected static $MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY = 3;
        protected static $MAX_LOGIN_ATTEMPTS_PER_HOUR = 5; 
        protected static $maxChangeAttempt = 1;
        
        protected static function urlSafeEncode($m) {
            return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
        }

        protected static function urlSafeDecode($m) {
            return base64_decode(strtr($m, '-_', '+/'));
        }
    }
    