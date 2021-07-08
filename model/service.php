<?php 
    namespace Model;

    include_once  __DIR__ . '/database.php';
    include_once  __DIR__ . '/config.php';

    abstract class Service extends ServiceManager {

        protected $serviceID;
        protected $userID;
        protected $domain;
        protected $subDomain;
        protected $title;
        protected $description;
        protected $creationDate;
        protected $active;
        protected $note;
        

        public function __construct(string $serviceID = null, Service $service = null) {
            $this->setServiceInfo($serviceID, $service);
        }


        private function setServiceInfo(string $serviceID = null, Service $service = null) {
            if (!is_null($serviceID)) {
                $serviceData = Database::sqlSelect('SELECT * FROM services WHERE service_id = ?', 's', $serviceID);
                $serviceData = $this->decodeService($serviceData);

                $this->serviceID = $serviceID;
                $this->userID = $serviceData['user_id'];
                $this->domain = $serviceData['domain'];
                $this->subDomain = $serviceData['sub_domain'];
                $this->title = $serviceData['title'];
                $this->description = $serviceData['description'];
                $this->creationDate = $serviceData['creation_date'];
                $this->active = $serviceData['active'];
                $this->note = $serviceData['note'];
                return ;
            } elseif(!is_null($service)) {
                $this->serviceID = $service->serviceID;
                $this->userID = $service->userID;
                $this->domain = $service->domain;
                $this->subDomain = $service->sub_domain;
                $this->title = $service->title;
                $this->description = $service->description;
                $this->creationDate = $$service->creationDate;
                $this->active = $service->active;
                $this->note = $service->note;
            }
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
         * get all service of an user id
         * @param string $id
         * 
         * @return array of all elements 
         */
        protected static function getAllUserServices($user_id) {
            return parent::sqlSelect('SELECT * FROM services WHERE user_id=? ORDER BY creation_date DESC', 'i', $user_id)->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * remove a service with his id
         * @param string $id
         * 
         * @return boolean for the rerquest's sucess
         */
        protected function remServices() {
            return parent::sqlUpdate('DELETE FROM services WHERE id=?', 's', $this->serviceID);
        }

        /**
         * remove a service with his id
         * @param string $id serviceID
         * 
         * @return boolean if the service existing
         */
        protected static function serviceExisting($id) {
            return parent::sqlSelect('SELECT id from services WHERE id=?', 's', $id)->num_rows === 1;
        }


        /**
         * remove a service with his id
         * @param string $id serviceID
         * 
         * @return boolean if the insert is sucessfull
         */
        protected static function serviceAttemptExisting($id) {
            return parent::sqlSelect('SELECT service_id from services_attempts WHERE service_id=?', 's', $id)->num_rows === 1;
        }

        /**
         * remove a service with his id
         * 
         * @return array if the insert is sucessfull
         */
        protected static function getAllServicesAttempt() {
            $services = parent::sqlSelect('SELECT * from services_attempts INNER JOIN services ON services_attempts.service_id = services.id WHERE services.active = 0')->fetch_all(MYSQLI_ASSOC);
            
            foreach ($services as &$service) {
                self::decodeService($service);
            }
            return  $services;
        }


        /**
         * remove a service with his id
         * @param string $id serviceID
         * 
         * @return boolean if the insert is sucessfull
         */
        protected static function getServiceAttempt($id) {
            return self::decodeService(parent::sqlSelect('SELECT * from services_attempts INNER JOIN services ON services_attempts.service_id = services.id WHERE services.active = 0 AND services.id=?', 's', $id)->fetch_all(MYSQLI_ASSOC)[0]);
        }


        /**
         * remove a service with his id
         * @param string $id serviceID
         * 
         * @return boolean if the insert is sucessfull
         */
        protected static function addServiceAttempt($id) {
            return parent::sqlInsert('INSERT INTO services_attempts (`id`, `service_id`, `timestamp`) VALUES (null,?,?)', 'si', $id, time());
        }

        /**
         * active the service
         * @param string $id serviceID
         * 
         * @return boolean if the update is sucessfull
         */
        protected static function activateService($id) {
            return parent::sqlUpdate('UPDATE services SET active=? WHERE id=?', 'is',1,  $id);
        }

        /**
         * disable the service
         * @param string $id serviceID
         * 
         * @return boolean if the update is sucessfull
         */
        protected static function disableService($id) {
            return parent::sqlUpdate('UPDATE services SET active=false WHERE id=?', 's', $id);
        }

        /**
         * delete the service
         * @param string $id serviceID
         * 
         * @return boolean if the update is sucessfull
         */
        protected static function deleteService($id) {
            return parent::sqlUpdate('DELETE from services WHERE id=?', 's', $id);
        }

        /**
         * remove a service_attempt with his id
         * @param string $id serviceID
         * 
         * @return boolean if the deletation is sucessfull 
         */
        protected static function remServiceAttempt($id) {
            return parent::sqlUpdate('DELETE FROM services_attempts WHERE service_id=?', 's', $id);
        }


        /**
         * allow to upload files to the server
         * @param array $file
         * 
         * @return boolean if the action is success
         */
        protected static function uploadServiceFile($file,$id, $serviceID, $fileName='0') {
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
                if (!file_exists(Config::FOLDER_STACK_SERVICES_DOCS . $id)) {
                    mkdir(Config::FOLDER_STACK_SERVICES_DOCS . $id);
                }
                // Vérifie si le fichier existe avant de le télécharger.
                if(!file_exists(Config::FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID)){
                    mkdir(Config::FOLDER_STACK_SERVICES_DOCS . $id. '/' . $serviceID );
                }
                return move_uploaded_file($file["tmp_name"], Config::FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID . '/' .  $fileName . '.' . $ext);
            } else {
                return -5;
            }
            return -15;
        }

        /**
         * delete the service picture
         * @param int $id
         * @param string $serviceID
         * 
         * @return boolean if the deletation sucess
         */
        protected static function deleteServiceFile($id, $serviceID, $fileName='0') {
            $allowed = ["pdf"];
            
            foreach ($allowed as $allowedKey) {
                if (file_exists(Config::FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID . "/" . $fileName . '.' . $allowedKey)){
                    return unlink(Config::FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID . "/" . $fileName . '.' . $allowedKey);
                }
            }
            return false;
        }


        /**
         * get user id from service id
         * @param string $serviceID
         * 
         * @return int the user id
         */
        protected static function getUserIdFromService($serviceID) {
            return parent::sqlSelect('SELECT user_id FROM services WHERE id=?', 's', $serviceID)->fetch_assoc()['user_id'];
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
         * @return boolean if the user has send a prestation and verified by the admins
         */
        protected static function hasPresta($userID){
            return Database::sqlSelect('SELECT id FROM services WHERE id=? and active=1', 'i',$userID)->num_rows > 0;
        }

        protected static function maxNumAttemptsachieved($userID) {
            return Database::sqlSelect('SELECT id FROM services WHERE user_id=? and active=0', 'i',$userID)->num_rows >= Config::MAX_SERVICE_ATTEMPTS;
        }


        protected static function removePresta($prestaID) {
            return Database::sqlUpdate('DELETE FROM services WHERE id=?', 's', $prestaID);
        }

        protected static function addNote($userFrom, $serviceID, $note) {
            return parent::sqlInsert('INSERT INTO notes VALUES (NULL, ?, ?, ?, ?)', 'isii', $userFrom, $serviceID, $note, time());
        }

        protected static function updateNote($serviceID) {
            $notes = parent::sqlSelect('SELECT SUM(note) as note, COUNT(note) as nbNotes FROM notes WHERE service_id=?', 's', $serviceID)->fetch_all(MYSQLI_ASSOC);
            $moyNotes = $notes['value'] / $notes['nbNotes'];
            return parent::sqlUpdate('UPDATE services SET note=? WHERE id=?', 'ii', $moyNotes, $serviceID);
        }

        protected static function getNote($serviceID) {
            return Database::sqlSelect('SELECT note FROM services WHERE id=? and active=0', 'i',$serviceID)->fetch_assoc()['note'];
        }
    }