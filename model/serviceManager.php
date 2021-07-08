<?php 
    namespace Model;

    include_once  __DIR__ . '/database.php';
    include_once  __DIR__ . '/config.php';
    include_once  __DIR__ . '/service.php';
    include_once  __DIR__ . '/user.php';


    class ServiceManager extends User {

        protected $userServices = [];

        public function __construct(int $userID = NULL, string $email = NULL, User $user = NULL) {
            parent::__construct($userID, $email, $user);
            $this->setUserService();
        }

        private function setUserService() {
            if ($this->errorCode === 0) {
                $services = Database::sqlSelect('SELECT * FROM services WHERE user_id = ? ORDER BY creation_date DESC', 'i', $this->userID);

                if ($services && $services->num_rows >= 1) {
                    $services = $services->fetch_all(MYSQLI_ASSOC);

                    foreach ($services as $service) {
                        array_push($this->userServices, new Service(null, $service));
                    }
                    return true;
                }
                $this->userServices = null;
            }
            return false;
        }

        /**
         * create a new service in database
         * 
         * @param string $serviceID
         * @param int $id
         * @param string $domain
         * @param string $description
         * 
         * @return bool insert worked successfully
         */
        protected function submitService($serviceID, $id, $domain, $subDomain, $title, $description ) {
            $domainIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));
            $subDomainIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));
            $titleIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));
            $descriptionIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));
            
            return parent::sqlInsert('INSERT INTO
                services (id, user_id, domain, sub_domain, title, description, creation_date, encryption_IV_domain, encryption_IV_desc, encryption_IV_sub_domain, encryption_IV_title, active, note) VALUES (?,?,?,?,?,?,?,?,?,?,?, false, -1)',
                'sissssissss',

                $serviceID, $id, 
                Config::encodeData($domain, $domainIV, Config::DOMAIN_KEY_SECRET), 
                Config::encodeData($subDomain,$subDomainIV, Config::SUBDOMAIN_KEY_SECRET),  
                Config::encodeData($title, $titleIV, Config::TITLE_KEY_SECRET), 
                Config::encodeData($description, $descriptionIV, Config::DESCRIPTION_KEY_SECRET), 
                time(), $domainIV, $descriptionIV, $subDomainIV, $titleIV);
        }

         /** 
         * create an unused id for service
         * @return string $id
         */
        protected static function newServiceID() {
            do {
                $id = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(30/strlen($x)) )),1,30);
            } while (self::serviceIDAlreadyExist($id));
            return $id;
        }


        /**
         * return if id is already used for another service
         * @param string $id
         * @return bool
         */
        protected static function serviceIDAlreadyExist($id){
            return parent::sqlSelect('SELECT id FROM services WHERE id=?', 's', $id)->num_rows === 1;
        }
    }