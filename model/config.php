<?php 

    class Config {

        protected static $DB_USERNAME = 'root';
        protected static $DB_PASSWORD = '';
        protected static $DB_DATABASE = 'sitetheproject';
        protected static $DB_HOST = 'localhost';

        protected static $CSRF_TOKEN_SECRET = '123zqddrg123rth14561f21fq54d9821hz65qdzzqdq';
        protected static $ADMIN_TOKEN_SECRET = '1qzd5q4r7zd6q5z415q4z56q4dzq84dq5d1zq87rf8v5k6i8r4rd84qnz';
        protected static $MESSAGE_KEY_SECRET = '5d4f88t965az625l5i1u21b5e456w4x56dzd54qzdz845484zd4qzd5sd6r99ikupo87sef845151s5jjh5d4dz';
        protected static $DOMAIN_KEY_SECRET = 'd6qz54d98q4654z6d54qz65d4q987t4hf9t84jf9t87hfg654hft984h9e8798s4f9s84fq9874dq65fg474s51qz6';
        protected static $SUBDOMAIN_KEY_SECRET = '654DZ984DQZ651DFQ65T165UJ165KI1UY651KJBIHBUBVIYVzq5d1qz65d1qt54q94dZqzdqzddq65d4q9';
        protected static $DESCRIPTION_KEY_SECRET = '4a5844d511321654t564984s4f65165d9q8z4d6q5f1q6z54dqz98d45g56j1564lk9jip4984oui89o54gf65h4dgsresf4qd48zqdzq';
        protected static $TITLE_KEY_SECRET = 'arsg178a4f5g84OIHA54A4f51fz3k85k68re4zqqzd5g6q5zd8dqzdqdq4561f41q4f1q4f1zqf4q65f4qz65fq5dq21j5kl145o564594h';

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
    