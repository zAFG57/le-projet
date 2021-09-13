<?php 
    namespace Model;
    
    class Config {
        protected const DOMAI_NNAME = '127.0.0.2';

        protected const DB_USERNAME = 'root';
        protected const DB_PASSWORD = '';
        protected const DB_DATABASE = 'sitetheproject';
        protected const DB_HOST = 'localhost';
        
        protected const CONNECTION_SECRET_TOKEN = 'qz534dqz56d4qz4dq8z94a49h89jyytg98kyu987ly84d65gz56q4f9J8syhe4DZQ98DQ984YH9Q8sdS';
        protected const CSRF_TOKEN_SECRET = '123zqddrg123rth14561f21fq54d9821hz65qdzzqdq';
        protected const ADMIN_TOKEN_SECRET = '1qzd5q4r7zd6q5z415q4z56q4dzq84dq5d1zq87rf8v5k6i8r4rd84qnz';
        protected const FORGOT_PASS_SECRET_TOKEN = 'LojuBUBD4f54q5qpouqGFUGHPIQFPLKQQ4G65qqPIUIYUGYUGQZDIJpqOPKG542Q455';
        protected const MESSAGE_KEY_SECRET = '5d4f88t965az625l5i1u21b5e456w4x56dzd54qzdz845484zd4qzd5sd6r99ikupo87sef845151s5jjh5d4dz';
        protected const DOMAIN_KEY_SECRET = 'd6qz54d98q4654z6d54qz65d4q987t4hf9t84jf9t87hfg654hft984h9e8798s4f9s84fq9874dq65fg474s51qz6';
        protected const SUBDOMAIN_KEY_SECRET = '654DZ984DQZ651DFQ65T165UJ165KI1UY651KJBIHBUBVIYVzq5d1qz65d1qt54q94dZqzdqzddq65d4q9';
        protected const DESCRIPTION_KEY_SECRET = '4a5844d511321654t564984s4F65165d9q8z4d6q5f1q6z54dqz98d45g56j1564lk9jip4984oui89o54gf65h4dgsresf4qd48zqdzq';
        protected const TITLE_KEY_SECRET = 'arsg178a4f5g84OIHA54A4f51fz3k85k68re4zqqzd5g6q5zd8dqzdqdq4561f41q4f1q4f1zqf4q65f4qz65fq5dq21j5kl145o564594h';

        protected const SMTP_HOST = 'smtp.gmail.com';
        protected const SMTP_PORT = 465;
        protected const SMTP_USERNAME = 'contact.mesreparations@gmail.com';
        protected const SMTP_PASSWORD = 'jjmumjlrozleukka';
        protected const SMTP_FROM = 'contact.mesreparations@gmail.com';
        protected const SMTP_FROM_NAME = '[Mes reparations.com] No-reply';

        protected const MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY = 3;
        protected const MAX_LOGIN_ATTEMPTS_PER_HOUR = 5; 
        protected const maxChangeAttempt = 1;
        protected const MAX_SERVICE_ATTEMPTS = 5;

        protected const MAX_SIZE_SERVICES_DOCS = 5 * 1024 * 1024;
        protected const FOLDER_STACK_SERVICES_DOCS = "../users/";

        protected const ENCODING_MESSAGES_SCHEMA = 'AES-192-CBC';
        protected const ENCODING_SERVICES_SCHEMA = 'AES-192-CBC';

        protected const MAX_SERVICES_DISPLAY = 25;
        protected const MIN_PERCENTAGE_CORRESPONDE_DOMAIN_SEARCH = 70;
        protected const MIN_SIZE_WORD_FOR_SEARCH = 3;

        protected const MAX_NOTE_VALUE = 5;

        protected const FORGOT_PASSWORD_LINK = 'http://127.0.0.2/view/forgot_password.php';


        //////////////////////////// USER //////////////////////

        protected const PASSWORD_REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/';
        protected const USERNAME_REGEX = '//'; // todo
        protected const BIO_REGEX = '//'; // todo

        protected const MAX_SIZE_PROFILE_PICTURE = 5 * 1024 * 1024;
        protected const FOLDER_STACK_USERS = '../users/';

        protected const MAX_ATTEMPTS_TIME_USERS = array(
            'username' => [60*60*24* 20, 1], // 1 time in 20 days
            'password' => [60*60*24* 20, 1], // 1 time in 20 days
            'bio' => [60*60* 1, 3], // 3 times in 1 hour
            'profilePicture' => [60*60* 1, 3], // 3 times in 1 hour
            'email' => [60*60*24* 100, 1], // 1 time in 100 days
            'general' =>  60*60*24* 356, // 1 year
        );

        protected const MAX_ATTEMPTS_FORGOT_PASSWORD = [60*30, 1]; // 30 minutes

        protected const LANGUAGE_FILE = 'public/js/language/';

        protected const DEFAULT_LANGUAGE = 'fr';


        
        public static function urlSafeEncode($m) {
            return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
        }

        public static function urlSafeDecode($m) {
            return base64_decode(strtr($m, '-_', '+/'));
        }

        protected static function createRandomSeq(int $num) {
            return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($num/strlen($x)) )),1,$num);
        }

        /**
         * encode with domain key
         * @param string $domain 
         * @param string $IV using do decrypt
         * 
         * @return string encoded domain
         */
        protected static function encodeData($data, $IV, $schema) {
            return Config::urlSafeEncode(openssl_encrypt($data, Config::ENCODING_SERVICES_SCHEMA, $schema, 0, $IV));
        }

        /**
         * decode with domain key
         * @param string $encryptedDomain
         * @param string $IV
         * 
         * @return string decoded domain
         */
        protected static function decodeData($encryptedData, $IV, $schema) {
            return openssl_decrypt(Config::urlSafeDecode($encryptedData), Config::ENCODING_SERVICES_SCHEMA,  $schema, 0, $IV);
        }

    }
    