<?php 

    require_once('database.php');


    class Service extends Database {

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
        protected static function submitService($serviceID, $id, $domain, $subDomain, $title, $description ) {
            $domainIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-192-CBC'));
            $subDomainIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-192-CBC'));
            $titleIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-192-CBC'));
            $descriptionIV = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-192-CBC'));
            
            return parent::sqlInsert('INSERT INTO services (id, user_id, domain, sub_domain, title, description, creation_date, encryption_IV_domaine, encryption_IV_desc, encryption_IV_sub_domain, encryption_IV_title, active) VALUES (?,?,?,?,?,?,?,?,?,?,?, false)', 'sissssissss', $serviceID, $id, self::encodeDomain($domain, $domainIV), self::encodeDescription($description,$descriptionIV), self::encodeSubDomain($subDomain,$subDomainIV),  self::encodeTitle($title,$titleIV), time(), $domainIV, $descriptionIV, $subDomainIV, $titleIV);
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

        /**
         * encode with domain key
         * @param string $domain 
         * @param string $IV using do decrypt
         * 
         * @return string encoded domain
         */
        protected static function encodeDomain($domain, $IV) {
            return Config::urlSafeEncode(openssl_encrypt($domain, "AES-192-CBC", Config::$DOMAIN_KEY_SECRET, 0, $IV));
        }

        /**
         * decode with domain key
         * @param string $encryptedDomain
         * @param string $IV
         * 
         * @return string decoded domain
         */
        protected static function decodeDomain($encryptedDomain, $IV) {
            return openssl_decrypt(Config::urlSafeDecode($encryptedDomain), "AES-192-CBC",  Config::$DOMAIN_KEY_SECRET, 0, $IV);
        }

        /**
         * encode with description key
         * @param string $description 
         * @param string $IV used do decrypt
         * 
         * @return string encoded domain
         */
        protected static function encodeDescription($description, $IV) {
            return Config::urlSafeEncode(openssl_encrypt($description, "AES-192-CBC", Config::$DESCRIPTION_KEY_SECRET, 0, $IV));
        }

        /**
         * decode with description key
         * @param string $encryptedDescription
         * @param string $IV
         * 
         * @return string decoded domain
         */
        protected static function decodeDescription($encryptedDescription, $IV) {
            return openssl_decrypt(Config::urlSafeDecode($encryptedDescription), "AES-192-CBC",  Config::$DESCRIPTION_KEY_SECRET, 0, $IV);
        }

          /**
         * encode with description key
         * @param string $subDomain 
         * @param string $IV used do decrypt
         * 
         * @return string encoded domain
         */
        protected static function encodeSubDomain($subDomain, $IV) {
            return Config::urlSafeEncode(openssl_encrypt($subDomain, "AES-192-CBC", Config::$SUBDOMAIN_KEY_SECRET, 0, $IV));
        }

        /**
         * decode with description key
         * @param string $subDomain
         * @param string $IV
         * 
         * @return string decoded domain
         */
        protected static function decodeSubDomain($subDomain, $IV) {
            return openssl_decrypt(Config::urlSafeDecode($subDomain), "AES-192-CBC",  Config::$SUBDOMAIN_KEY_SECRET, 0, $IV);
        }

          /**
         * encode with description key
         * @param string $title 
         * @param string $IV used do decrypt
         * 
         * @return string encoded domain
         */
        protected static function encodeTitle($title, $IV) {
            return Config::urlSafeEncode(openssl_encrypt($title, "AES-192-CBC", Config::$TITLE_KEY_SECRET, 0, $IV));
        }

        /**
         * decode with description key
         * @param string $encryptedTitle
         * @param string $IV
         * 
         * @return string decoded domain
         */
        protected static function decodeTitle($encryptedTitle, $IV) {
            return openssl_decrypt(Config::urlSafeDecode($encryptedTitle), "AES-192-CBC",  Config::$TITLE_KEY_SECRET, 0, $IV);
        }

        /**
         * get all service of an user id
         * @param string $id
         * 
         * @return array of all elements 
         */
        protected static function getAllServices($user_id) {
            return parent::sqlSelect('SELECT * FROM services WHERE user_id=? ORDER BY creation_date DESC', 'i', $user_id)->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * remove a service with his id
         * @param string $id
         * 
         * @return boolean for the rerquest's sucess
         */
        protected static function remServices($id) {
            return parent::sqlUpdate('DELETE FROM services WHERE id=?', 's', $id);
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
            return parent::sqlUpdate('UPDATE services SET active=true WHERE service_id=?', 's', $id);
        }

        /**
         * disable the service
         * @param string $id serviceID
         * 
         * @return boolean if the update is sucessfull
         */
        protected static function disableService($id) {
            return parent::sqlUpdate('UPDATE services SET active=false WHERE service_id=?', 's', $id);
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
        protected static function uploadServiceFile($file,$id, $serviceID) {
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
            $filename = $file["name"];
            $filetype = $file["type"];
            $filesize = $file["size"];
        
            // Vérifie l'extension du fichier
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) {
                return -1;
            }
        
            if($filesize > Config::$MAX_SIZE_SERVICES_DOCS) {
                return -2;
            }
        
            // Vérifie le type MIME du fichier

            if(in_array($filetype, $allowed)){
                if (!file_exists(Config::$FOLDER_STACK_SERVICES_DOCS . $id)) {
                    mkdir(Config::$FOLDER_STACK_SERVICES_DOCS . $id);
                }
                // Vérifie si le fichier existe avant de le télécharger.
                if(file_exists(Config::$FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID . '.' . $ext)){
                    return -3;
                } else{
                    return move_uploaded_file($file["tmp_name"], Config::$FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID . '.' . $ext);
                } 
            } else{
                return -4;
            }
        }
        /**
         * 
         */
        protected static function deleteServiceFile($id, $serviceID) {
            $allowed = ["jpg", "jpeg", "png"];
            
            foreach ($allowed as $allowedKey) {
                if (file_exists(Config::$FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID .  '.' . $allowedKey)){
                    return unlink(Config::$FOLDER_STACK_SERVICES_DOCS . $id . '/' . $serviceID .  '.' . $allowedKey);
                }
            }
            return false;
        }



        protected static function getUserIdFromService($serviceID) {
            parent::sqlSelect('SELECT user_id FROM services WHERE id=?', 's', $serviceID)->fetch_assoc()['id'];
        }
    }
