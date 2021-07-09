<?php 
    namespace Model;

    include_once  __DIR__ . '/database.php';
    include_once  __DIR__ . '/config.php';

    class Service extends Database {

        protected $serviceID;
        protected $userID;
        protected $domain;
        protected $subDomain;
        protected $title;
        protected $description;
        protected $creationDate;
        protected $active;
        protected $note;

        protected $errorCode = 0;
        
        /**
         * **init a service object**
         * 
         * @param string $serviceID
         * @param array $serviceArray
         * @param Service $service
         */
        public function __construct(string $serviceID = null, array $serviceArray, Service $service = null) {
            try {
                $this->setServiceInfo($serviceID, $serviceArray, $service);
            } catch (\Throwable $th) {
                $this->errorCode = $th->getCode();
            }
        }
        
        /**
         * @return string serviceID
         */
        public function __getServiceID() {
            return ($this->errorCode === 0) ? $this->serviceID : false;
        }

        /**
         * set the services variables 
         * @param string $serviceID
         * @param array $serviceArray
         * @param Service $service
         * 
         * @return void
         */
        private function setServiceInfo(string $serviceID = null, array $serviceArray = null, Service $service = null) {
            if (!is_null($serviceID)) {
                $serviceArray = Database::sqlSelect('SELECT * FROM services WHERE service_id = ?', 's', $serviceID);
                if ($serviceArray && $serviceArray->num_rows >= 1) {
                    $serviceArray->fetch_assoc();
                } else {
                    throw new \Exception("Unexisting service", 1);
                    
                }
            }
            
            if (!is_null($service)) {

                $this->serviceID = $service->serviceID;
                $this->userID = $service->userID;
                $this->domain = $service->domain;
                $this->subDomain = $service->sub_domain;
                $this->title = $service->title;
                $this->description = $service->description;
                $this->creationDate = $service->creationDate;
                $this->active = $service->active;
                $this->note = $service->note;
                return;
            }

            
            $serviceArray = $this->decodeService($serviceArray);

            $this->serviceID = $serviceArray['service_id'];
            $this->userID = $serviceArray['user_id'];
            $this->domain = $serviceArray['domain'];
            $this->subDomain = $serviceArray['sub_domain'];
            $this->title = $serviceArray['title'];
            $this->description = $serviceArray['description'];
            $this->creationDate = $serviceArray['creation_date'];
            $this->active = $serviceArray['active'];
            $this->note = $serviceArray['note'];
        }

        /**
         * @param array $service 
         * @return array return the decoded service
         */
        protected static function decodeService(&$service) {
            $service['domain'] = self::decodeData($service['domain'], $service['encryption_IV_domain'], Config::DOMAIN_KEY_SECRET);
            $service['description'] = self::decodeData($service['description'], $service['encryption_IV_desc'], Config::DESCRIPTION_KEY_SECRET);
            $service['sub_domain'] = self::decodeData($service['sub_domain'], $service['encryption_IV_sub_domain'], Config::SUBDOMAIN_KEY_SECRET);
            $service['title'] = self::decodeData($service['title'], $service['encryption_IV_title'], Config::TITLE_KEY_SECRET);
            return $service;
        }

        /**
         * remove a service with his id
         * 
         * @return boolean for the rerquest's sucess
         */
        protected function removeService() {
            return parent::sqlUpdate('DELETE FROM services WHERE id=?', 's', $this->serviceID);
        }

        /**
         * active the service
         * @param string $id serviceID
         * 
         * @return boolean if the update is sucessfull
         */
        protected function activateService() {
            return parent::sqlUpdate('UPDATE services SET active=? WHERE service_id=?', 'is',1,  $this->serviceID);
        }

        /**
         * disable the service
         * @param string $id serviceID
         * 
         * @return boolean if the update is sucessfull
         */
        protected function disableService() {
            return parent::sqlUpdate('UPDATE services SET active=false WHERE id=?', 's', $this->serviceID);
        }

        protected function addNote($userFrom, $note) {
            return parent::sqlInsert('INSERT INTO notes VALUES (NULL, ?, ?, ?, ?)', 'isii', $userFrom, $this->serviceID, $note, time());
        }

        protected function updateNote() {
            $notes = parent::sqlSelect('SELECT SUM(note) as note, COUNT(note) as nbNotes FROM notes WHERE service_id=?', 's', $this->serviceID)->fetch_all(MYSQLI_ASSOC);
            $moyNotes = $notes['value'] / $notes['nbNotes'];
            return parent::sqlUpdate('UPDATE services SET note=? WHERE id=?', 'ii', $moyNotes, $this->serviceID);
        }

        /**
         * remove a service with his id
         * @param string $id serviceID
         * 
         * @return boolean if the insert is sucessfull
         */
        protected function createServiceAttempt() {
            return parent::sqlInsert('INSERT INTO services_attempts (`id`, `service_id`, `timestamp`) VALUES (null,?,?)', 'si', $this->serviceID, time());
        }

        /**
         * remove a service_attempt with his id
         * @param string $id serviceID
         * 
         * @return boolean if the deletation is sucessfull 
         */
        protected function removeServiceAttempt() {
            return parent::sqlUpdate('DELETE FROM services_attempts WHERE service_id=?', 's', $this->serviceID);
        }
    }