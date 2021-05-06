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
        public static function createService($id, $domain, $subdomain, $title, $description, $file) {
            if (empty($id) || empty($domain)  || empty($subdomain) || empty($title) || empty($description) || empty($file)) {
                return 1;
            }
            if(ControllerUser::userExisiting($id)) {
                $serviceId = parent::newServiceID();
                if (parent::submitService($serviceId, $id, $domain, $subdomain, $title, $description) !== -1) {
                    if (parent::uploadServiceFile($file, $id, $serviceId)) {
                        if(parent::addServiceAttempt($serviceId)){
                            return 0;
                        } else {
                            return 2;
                        }
                    } else {
                        return 3;
                    }
                } else {
                    return 4;
                }
            } else {
                // utilisateur non existant
                return 5;
            }
            return 6;
        }

        public static function showAllServices($id) {
            if(ControllerUser::userExisiting($id)) {
                $services = parent::getAllServices($id);
                if ($services) {
                    foreach ($services as &$service) {
                        // if ($service['active']) {
                            $service['domain'] = parent::decodeDomain($service['domain'], $service['encryption_IV_domaine']);
                            $service['description'] = parent::decodeDescription($service['description'], $service['encryption_IV_desc']);
                            $service['sub_domain'] = parent::decodeSubDomain($service['sub_domain'], $service['encryption_IV_sub_domain']);
                            $service['title'] = parent::decodeTitle($service['title'], $service['encryption_IV_title']);
                            unset($service['creation_date'], $service['encryption_IV_domaine'], $service['encryption_IV_desc'], $service['encryption_IV_sub_domain'], $service['encryption_IV_title']);
                        // }
                    }
                    return $services;
                } else {
                    return false;
                }
               
            }
        }

        public static function enableService($serviceId) {
            if (ControllerUser::userExisiting(parent::getUserIdFromService($serviceId))) {
                if (parent::serviceExisting($serviceId)) {
                    if (parent::activateService($serviceId)) {
                        parent::deleteServiceFile(parent::getUserIdFromService($serviceId), $serviceId);
                        return parent::remServiceAttempt($serviceId);
                    }
                }
            }
        }
    }

    if (isset($_POST['domaine']) && isset($_POST['subdomain']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['csrf_token']) && isset($_FILES["doccumentsLegeaux"])) {
        session_start();
        if (ControllerUser::isConnected()) {
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                echo json_encode(ControllerService::createService($_SESSION['userID'], $_POST['domaine'], $_POST['subdomain'], $_POST['title'], $_POST['description'], $_FILES["doccumentsLegeaux"]));
            }
        } else {
            echo json_encode(-1);
        }
    }

    if (isset($_POST['serviceID']) && isset($_POST['csrf_token']) && isset($_POST['adminToken'])) {
        session_start();
        if (ControllerAdmin::verifAll($_SESSION['userID'], $_POST['adminToken'])) {
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                echo json_encode(ControllerService::enableService($_POST['serviceID']));
            }
        }
    }
    