<?php 

    require_once('csrfConfig.php');
    require_once('../model/search.php');


    class ControllerSearch extends Search {
        public static function searchByDomainName($query, $page) {
            parent::numPageVerify($page);
            $max = $page * Config::$MAX_SERVICES_DISPLAY;
            $min = $max - Config::$MAX_SERVICES_DISPLAY;
            $services = parent::getAllServices($min, $max);

            $i = 0;
            while ($i < count($services)) {
                if (!parent::isActivate($services[$i]['id'])) {
                    array_splice($services, $i, 1);
                } else if ($services[$i]['verified'] != 1) {
                    array_splice($services, $i, 1);
                } else {
                    Service::decodeService($services[$i]);
                    similar_text($query, $services[$i]['domain'], $perc);
                    if ($perc < Config::$MIN_PERCENTAGE_CORRESPONDE_DOMAIN_SEARCH) {
                        array_splice($services, $i, 1);
                    } else {
                        unset($services[$i]['encryption_IV_domain'], $services[$i]['encryption_IV_desc'], $services[$i]['encryption_IV_sub_domain'], $services[$i]['encryption_IV_title'], $services[$i]['active'], $services[$i]['verified']);
                        $i++; 
                    }
                } 
            }
            return $services;
        }
    }
    