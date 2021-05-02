<?php

    require_once('../controller/csrfConfig.php');
    require_once('../model/serviceManager.php');
    require_once('../controller/user.php');

    class ControllerService extends Service {

        /**
         * @param int $id
         * @param string $domaine
         * @param string $description
         * 
         * @return bool
         */
        public static function createService($id, $domaine, $subdomain, $title, $description) {
            if(ControllerUser::userExisiting($id)) {
                return parent::submitService(parent::newServiceID(), $id, $domaine, $subdomain, $title, $description);
            }
        }

        public static function showAllServices($id) {
            if(ControllerUser::userExisiting($id)) {
                $services = parent::getAllServices($id);
                if ($services) {
                    foreach ($services as &$service) {
                        parent::decodeDomain($service['domaine'], $service['encryption_IV_domaine']);
                        parent::decodeDescription($service['description'], $service['encryption_IV_desc']);
                        parent::decodeSubDomain($service['sub_domain'], $service['encryption_IV_sub_domain']);
                        parent::decodeTitle($service['title'], $service['encryption_IV_title']);
                        unset($service['creation_date'], $service['encryption_IV_domaine'], $service['encryption_IV_desc'], $service['encryption_IV_sub_domain'], $service['encryption_IV_title']);
                    }
                    return $services;

                } else {
                    return false;
                }
               
            }
        }
    }

    if (isset($_POST['id']) && isset($_POST['domaine']) && isset($_POST['subdomain']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['csrf_token'])) {
        if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
            echo json_encode(ControllerService::createService(intval($_POST['id']), $_POST['domaine'], $_POST['subdomain'], $_POST['title'], $_POST['description']));
        }
    }
    