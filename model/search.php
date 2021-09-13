<?php
    namespace Model;

    include_once 'serviceManager.php';

    class Search extends Service {

        protected $query;
        protected $types = [];

        public function __construct(String $query, ...$types) {
            $this->query = $query;
            $this->types = self::verifyTypes(...$types);
        }

        public function searchService($page) {
            self::numPageVerify($page);
            $max = $page * Config::MAX_SERVICES_DISPLAY;
            $min = $max - Config::MAX_SERVICES_DISPLAY;

            $services = self::getAllActivatedServices($min, $max);

            $resultSearch = [];

            foreach ($services as $service) {
                Service::decodeService($service);
                if ($this->accepteServiceInSearch($service)) {
                    unset($service['encryption_IV_domain'], $service['encryption_IV_desc'], $service['encryption_IV_sub_domain'], $service['encryption_IV_title'], $service['active'], $service['verified']);
                    array_push($resultSearch, $service);
                } 
            }
            return $resultSearch;
        }

        private function accepteServiceInSearch($service) {
            foreach ($this->types as $type) {
                foreach (explode(' ', $this->query) as $queryPart) {
                    foreach (explode(' ', $service[$type]) as $servicePart) {
                        if (strlen($servicePart) >= Config::MIN_SIZE_WORD_FOR_SEARCH && strlen($queryPart) >= Config::MIN_SIZE_WORD_FOR_SEARCH) {
                            similar_text($queryPart, $servicePart, $perc);
                            if ($perc >= Config::MIN_PERCENTAGE_CORRESPONDE_DOMAIN_SEARCH) {
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        }

        public function getNearestServices($nbServices) {
            $nearestServices = [];
            $services = self::getAllActivatedServices();

            foreach ($services as $service) {
                Service::decodeService($service);
                // if ($this->getHighestPercentage($service)) {
                if (count($nearestServices) < $nbServices) {
                    unset($service['encryption_IV_domain'], $service['encryption_IV_desc'], $service['encryption_IV_sub_domain'], $service['encryption_IV_title'], $service['active'], $service['verified']);
                    array_push($nearestServices, [$service, $this->getHighestPercentage($service)]);
                } else {
                    foreach ($nearestServices as $serviceInArray) {
                        $highestPerc = $this->getHighestPercentage($service);
                        if ($highestPerc > $serviceInArray[1]) {
                            $serviceInArray = [$service, $highestPerc];
                        }
                    }
                } 
            }
            return $nearestServices;
        }

        private function getHighestPercentage($service) {
            $hp = 0;

            foreach ($this->types as $type) {
                foreach (explode(' ', $this->query) as $queryPart) {
                    foreach (explode(' ', $service[$type]) as $servicePart) {
                        if (strlen($servicePart) >= Config::MIN_SIZE_WORD_FOR_SEARCH && strlen($queryPart) >= Config::MIN_SIZE_WORD_FOR_SEARCH) {
                            similar_text($queryPart, $servicePart, $perc);
                            if ($perc > $hp) {
                                $hp = $perc;
                            }
                        }
                    }
                }
            }
            return $hp;
        }

        public static function createStars($nbStars){
            $res = '';
            while ($nbStars > 0) {
                $res += '★';
                $nbStars --;
            }
            return $res;
        }
           
        //////////////////////////////////
        //////////////////////////////////
        //////////////////////////////////
        //////////////////////////////////
        //////////////////////////////////

        private static function getAllActivatedServices($min = 0, $max = 0) {
            return Database::sqlSelect('SELECT `service_id`, `users`.`user_id`, `domain`, `sub_domain`, `title`, `description`, `services`.`creation_date`, `encryption_IV_domain`, `encryption_IV_desc`, `encryption_IV_sub_domain`, `encryption_IV_title`, `active`, `note`, `username`, `verified` FROM services INNER JOIN users ON users.user_id = services.user_id WHERE `active` = 1 ORDER BY `note` DESC ' . ($max > 0 ? 'LIMIT ' . $min . ', ' . $max : ''))->fetch_all(MYSQLI_ASSOC);
        }

        private static function isActivate($serviceID) {
            return Database::sqlSelect('SELECT active FROM services WHERE service_id=?', 's', $serviceID)->fetch_assoc()['active'] == 1;
        }

        private static function numPageVerify(&$page) {
            $nbMaxRow = ceil(Database::sqlSelect('SELECT service_id FROM services')->num_rows / Config::MAX_SERVICES_DISPLAY);
            if ($page > $nbMaxRow) {
                $page = $nbMaxRow;
            }
            return $nbMaxRow;
        }

        private static function verifyTypes(&...$types){
            $typesAllowed = ['domain', 'sub_domain','title','description'];

            // if (condition) {
            //     # code...
            // }
            // foreach ($types as &$key) {
            //     htmlspecialchars($key);
            // }
            return !empty(array_intersect($typesAllowed, $types)) ? array_values(array_intersect($typesAllowed, $types)) : $typesAllowed;
        }
    }