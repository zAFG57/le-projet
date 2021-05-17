<?php
    namespace Controller;

    use \Model\Service;
    use \Model\Config;

    include_once '../model/serviceManager.php';
    include_once '../model/config.php';
    include_once '../controller/user.php';
    include_once '../controller/csrfConfig.php';

    class ControllerService extends Service {

        /**
         * @param int $id
         * @param string $domain
         * @param string $subdomain
         * @param string $title
         * @param string $description
         * @param array $file
         * 
         * @return bool
         */
        public static function createService($id, $domain, $subdomain, $title, $description, $file) {
            if (empty($id) || empty($domain)  || empty($subdomain) || empty($title) || empty($description) || empty($file)) {
                return 1;
            }
            
            if (strlen($title) >= 255 ||  strlen($title) <= 4) { // a voir
                return 8;
            }

            if (strlen($description) >= 2000 || strlen($description) <= 4) { // a voir
                return 9;
            }

            if (!parent::acceptableDomain([$domain, $subdomain])) {
                return 7;
            }
            if (!parent::maxNumAttemptsachieved($id)) {
                if(ControllerUser::userExisiting($id)) {
                    $serviceId = parent::newServiceID();
                    // return parent::uploadServiceFile($file, $id, $serviceId);
                    if (parent::uploadServiceFile($file, $id, $serviceId)) {
                        if (parent::submitService($serviceId, $id, $domain, $subdomain, $title, $description) !== -1) {
                            if(parent::addServiceAttempt($serviceId)){
                                return 0;
                            } else {
                                return 2;
                            }
                        } else {
                            return 4;
                        }
                    } else {
                        return 3;
                    }
                } else {
                    // utilisateur non existant
                    return 5;
                }
            } else {
                // attempts equals at max
                return 10;
            }
            return 6;
        }

        public static function hasPresta($userID) {
            if(ControllerUser::userExisiting($userID)) {
                return parent::hasPresta($userID);
            }
        }

        public static function displayPDF($userID, $serviceID) {
            $res = '';
            for ($i=2; $i < sizeof(scandir(Config::$FOLDER_STACK_SERVICES_DOCS . $userID . '/' . $serviceID)); $i++) {
               $res .= '<iframe src="' . Config::$FOLDER_STACK_SERVICES_DOCS . $userID . '/' . $serviceID . '/' . ($i-2) . '.pdf"></iframe>';
            }
            return $res;
        }

        public static function showAllServices($id) {
            if(ControllerUser::userExisiting($id)) {
                $services = parent::getAllUserServices($id);
                if ($services) {
                    foreach ($services as &$service) {  
                        parent::decodeService($service);
                        unset($service['creation_date'], $service['encryption_IV_domain'], $service['encryption_IV_desc'], $service['encryption_IV_sub_domain'], $service['encryption_IV_title']);  
                    }
                    return $services;
                } else {
                    return false;
                }
               
            }
        }


        public static function showServiceAttempt($id, $userID, $adminToken) {
            if (ControllerUser::userExisiting(intval($userID)) && intval($userID) === $_SESSION['userID']) {
                if(parent::serviceAttemptExisting($id)) {
                    if (ControllerAdmin::verifAll($_SESSION['userID'], $adminToken)) {
                        return parent::getServiceAttempt($id);
                    }else {
                        return -198798; 
                    }
                } else {
                    return -2; 
                }
            } else {
                return -3; 
            }
        }
        

        public static function showAllServicesAttempts($userID, $adminToken) {
            if (ControllerUser::userExisiting(intval($userID)) && intval($userID) === $_SESSION['userID']) {
                if (ControllerAdmin::verifAll($_SESSION['userID'], $adminToken)) {
                    return parent::getAllServicesAttempt();
                }
            }
            return -1;
        }

        public static function acceptServiceManager($serviceId, $accept) {
            if (parent::serviceExisting($serviceId)) {
                if (ControllerUser::userExisiting(parent::getUserIdFromService($serviceId))) {
                    if (parent::serviceExisting($serviceId)) {
                        if ($accept === 'true') {
                            if (parent::activateService($serviceId)) {
                                if (parent::deleteServiceFile(parent::getUserIdFromService($serviceId), $serviceId)){;
                                    if (parent::remServiceAttempt($serviceId)) {
                                        return 0;
                                    } else {
                                        return -1;
                                    }
                                } else {
                                    return -2;
                                }
                            } 
                        } else if($accept === 'false') {
                            if (parent::deleteServiceFile(parent::getUserIdFromService($serviceId), $serviceId)) {
                                if (parent::deleteService($serviceId)) {
                                    if (parent::remServiceAttempt($serviceId)) {
                                        return 0;
                                    } else {
                                        return -1;
                                    } 
                                } else {
                                    return -3;
                                }
                            } else {
                                return -2;
                            }
                        } else {
                            return -4;
                            }
                    } else {
                        return -5;
                    }
                }  else {
                    return -6;
                }
            } else {
                return -7;
            }
        }
    }

    if (isset($_POST['domain']) && isset($_POST['subdomain']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['csrf_token']) && isset($_FILES["doccumentsLegeaux"])) {
        session_start();
        if (ControllerUser::isConnected()) {
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                echo json_encode(ControllerService::createService($_SESSION['userID'], $_POST['domain'], $_POST['subdomain'], $_POST['title'], $_POST['description'], $_FILES["doccumentsLegeaux"]));
            } else {
                echo -7;
            }
        } else {
            echo json_encode(-1);
        }
    }

    if (isset($_POST['serviceIDSubmited']) && isset($_POST['accept']) && isset($_POST['csrf_token']) && isset($_POST['adminToken'])) {
        session_start();
        if (ControllerAdmin::verifAll($_SESSION['userID'], $_POST['adminToken'])) {
            if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                echo json_encode(ControllerService::acceptServiceManager($_POST['serviceIDSubmited'], $_POST['accept']));
            }
        }
    }