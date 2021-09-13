<?php 
    namespace Model;

    include_once  __DIR__ . '/database.php';
    include_once  __DIR__ . '/config.php';
    include_once  __DIR__ . '/service.php';
    include_once  __DIR__ . '/user.php';


    class ServiceManager extends User {

        protected $userServices = [];
        protected $userServicsAttempts = [];

        /**
         * **create an ServiceManager**
         * 
         * @param int $userID
         * @param string $email
         * @param User $user
         */
        public function __construct(int $userID = NULL, string $email = NULL, User $user = NULL) {
            parent::__construct($userID, $email, $user);
            $this->setUserService();
            $this->setUserServiceAttempts();
        }
        /**
         * set the variable services to the actual services of the user
         */
        private function setUserService() {
            if ($this->errorCode === 0) {
                $services = Database::sqlSelect('SELECT * FROM services WHERE user_id = ? AND active = 1 ORDER BY creation_date DESC', 'i', $this->userID);

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
         * set the variable service attempts to the actual services attempts
         * @return bool if the action successful
         */
        private function setUserServiceAttempts() {
            if ($this->errorCode === 0) {
                $attempts = Database::sqlSelect('SELECT services_attempts.id, services_attempts.service_id, services_attempts.timestamp FROM services_attempts INNER JOIN services ON services_attempts.service_id = services.service_id WHERE services.user_id = ?', 'i', $this->userID);
                if ($attempts &&  $attempts->num_rows >= 1) {
                    $this->userServicsAttempts = $attempts->fetch_all(MYSQLI_ASSOC);
                    return true;
                }
            }
            $this->userServicsAttempts = null;
            return false;
        }

        /**
         * @return array services
         */
        public function getUserService() {
           return $this->userServices;
        }

        /**
         * @return array servicesAttempts
         */
        public function getUserServiceAttempts() {
            return $this->userServicsAttempts;
        }

        /**
         * create a new service in database
         * 
         * @param string $domain
         * @param string $subDomain
         * @param string $title
         * @param string $description
         * 
         * @return bool insert worked successfully
         */
        protected function createService($domain, $subDomain, $title, $description, $file) {
            if ($this->errorCode === 0) {
                if ($this->acceptableDomain([$domain, $subDomain])) {
                    
                    $serviceID = $this->newServiceID();
                    $domainIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));
                    $subDomainIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));
                    $titleIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));
                    $descriptionIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length(Config::ENCODING_SERVICES_SCHEMA));

                    $this->uploadServiceFile($file, $serviceID);
                    
                    return parent::sqlInsert('INSERT INTO services 
                        (service_id, user_id, domain, sub_domain, title, description, creation_date, encryption_IV_domain, encryption_IV_desc, encryption_IV_sub_domain, encryption_IV_title, active, note) VALUES (?,?,?,?,?,?,?,?,?,?,?, false, -1)',
                        'sissssissss',

                        $serviceID, $this->userID, 
                        Config::encodeData($domain, $domainIV, Config::DOMAIN_KEY_SECRET), 
                        Config::encodeData($subDomain,$subDomainIV, Config::SUBDOMAIN_KEY_SECRET),  
                        Config::encodeData($title, $titleIV, Config::TITLE_KEY_SECRET), 
                        Config::encodeData($description, $descriptionIV, Config::DESCRIPTION_KEY_SECRET), 
                        time(), $domainIV, $descriptionIV, $subDomainIV, $titleIV
                    );
                }
            }
            return false;
        }

        /**
         * allow to upload files to the server
         * @param array $file
         * 
         * @return boolean if the action is success
         */
        private function uploadServiceFile($file, $serviceID, $fileName='0') {
            if ($file["error"] != 0) {
                return 1;
            }

            $allowed = array("pdf" => "application/pdf");
            $filename = $file["name"];
            $filetype = $file["type"];
            $filesize = $file["size"];
        
            // Vérifie l'extension du fichier
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) {
                return 2;
            }
        
            if($filesize > Config::MAX_SIZE_SERVICES_DOCS) {
                return 3;
            }
        
            // Vérifie le type MIME du fichier

            if(in_array($filetype, $allowed)){
                if (!file_exists(Config::FOLDER_STACK_SERVICES_DOCS . $this->userID)) {
                    mkdir(Config::FOLDER_STACK_SERVICES_DOCS . $this->userID);
                }
                // Vérifie si le fichier existe avant de le télécharger.
                if(!file_exists(Config::FOLDER_STACK_SERVICES_DOCS . $this->userID . '/' . $serviceID)){
                    mkdir(Config::FOLDER_STACK_SERVICES_DOCS . $this->userID . '/' . $serviceID );
                }
                return move_uploaded_file($file["tmp_name"], Config::FOLDER_STACK_SERVICES_DOCS . $this->userID . '/' . $serviceID . '/' .  $fileName . '.' . $ext);
            } else {
                return 4;
            }
            return 5;
        }

        /**
         * delete the service picture
         * @param int $id
         * @param string $serviceID
         * 
         * @return boolean if the deletation sucess
         */
        protected function deleteServiceFile($serviceID, $fileName='0') {
            $allowed = ["pdf"];
            
            foreach ($allowed as $allowedKey) {
                if (file_exists(Config::FOLDER_STACK_SERVICES_DOCS . $this->userID . '/' . $serviceID . "/" . $fileName . '.' . $allowedKey)){
                    return unlink(Config::FOLDER_STACK_SERVICES_DOCS . $this->userID . '/' . $serviceID . "/" . $fileName . '.' . $allowedKey);
                }
            }
            return false;
        }

        /**
         * verify if the entry is correcte
         * @param array @data [domain, subdomain]
         * @return boolean if the domain is accepted
         */
        protected static function acceptableDomain($data) {
            $json = file_get_contents('../public/js/domains.json');
            $json_data = json_decode($json, true);

            if (isset($json_data[$data[0]])) {
                foreach ($json_data[$data[0]] as $subdomain) {
                    if ($subdomain[0] === $data[1]) {
                        return true;
                    }
                }
            }
            return false;
        }

        /** 
         * create an unused id for service
         * @return string $id
         */
        protected static function newServiceID() {
            do {
                $id = Config::createRandomSeq(30);
            } while (self::serviceExisting($id));
            return $id;
        }

        /**
         * return if id is already used for another service
         * @param string $id
         * @return bool
         */
        protected static function serviceExisting($id){
            return parent::sqlSelect('SELECT service_id FROM services WHERE service_id=?', 's', $id)->num_rows === 1;
        }
    }