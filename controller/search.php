<?php 
    namespace Controller;

    use \Model\Search;
    use \Model\Config;
    use \Model\Service;

    include_once '../model/search.php';
    include_once '../model/config.php';
    include_once '../model/serviceManager.php';

    class ControllerSearch extends Search {
        public static function searchService($query, $page, ...$types) {
            parent::numPageVerify($page);
            $max = $page * Config::$MAX_SERVICES_DISPLAY;
            $min = $max - Config::$MAX_SERVICES_DISPLAY;
            $services = parent::getAllServices($min, $max);
            $types = parent::verifyTypes(...$types);
            $i = 0;
            while ($i < count($services)) {
                if (!parent::isActivate($services[$i]['id'])) {
                    array_splice($services, $i, 1);
                } else if ($services[$i]['verified'] != 1) {
                    array_splice($services, $i, 1);
                } else {
                    $accepted = false;
                    Service::decodeService($services[$i]);
                    foreach ($types as $key) {
                        if(isset($services[$i][$key])) {
                            foreach (explode(' ', $query) as $queryPart) {
                                similar_text($queryPart, $services[$i][$key], $perc);
                                if ($perc >= Config::$MIN_PERCENTAGE_CORRESPONDE_DOMAIN_SEARCH) {
                                    unset($services[$i]['encryption_IV_domain'], $services[$i]['encryption_IV_desc'], $services[$i]['encryption_IV_sub_domain'], $services[$i]['encryption_IV_title'], $services[$i]['active'], $services[$i]['verified']); 
                                    $accepted ? : $i++;
                                    $accepted = true;
                                    break;
                                }
                            }
                        }
                    }
                    if (!$accepted) {
                        array_splice($services, $i, 1);
                    }
                } 
            }
            return $services;
        }

        public static function createStars($nbStars){
            $res = '';
            while ($nbStars > 0) {
                $res += '★';
                $nbStars --;
            }
            return $res;
        }
    }
    