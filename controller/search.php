<?php 

    require_once('csrfConfig.php');
    require_once('../model/search.php');


    class ControllerSearch extends Search {
        public static function searchByDomainName($search, $csrfToken) {
            // if(isset($search) && strlen($search) >= 3 && isset($csrfToken) && ControllerCsrf::validateCsrfToken($csrfToken)) {
                return parent::searchDomainName($search);
            // } else {
            //     return -1;
            // }
        }
    }

    if (isset($_POST['search']) && isset($_POST['csrf_token'])) {
        if(ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
            echo json_encode(ControllerSearch::searchByDomainName(htmlspecialchars($_POST['search']), htmlspecialchars($_POST['csrf_token'])));
        }
    }
    