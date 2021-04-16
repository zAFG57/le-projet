<?php 

    require_once('csrfConfig.php');
    require_once('../model/search.php');


    class ControllerSearch extends Search {
        public static function searchByDomainName() {
            if(isset($_POST['search']) && strlen($_POST['search']) >= 3 && isset($_POST['csrf_token']) && ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                return parent::searchDomainName($_POST['search']);
            } else {
                return -1;
            }
        }
    }

    if (isset($_POST['search']) && isset($_POST['csrf_token'])) {
        echo json_encode(ControllerSearch::searchByDomainName());
    }
    