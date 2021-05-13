<?php
    
    require_once('database.php');
    require_once('../model/serviceManager.php');

    class Search extends Service {
        protected static function getAllServices($min, $max) {
            return Database::sqlSelect('SELECT `services`.`id`, `user_id`, `domain`, `sub_domain`, `title`, `description`, `services`.`creation_date`, `encryption_IV_domain`, `encryption_IV_desc`, `encryption_IV_sub_domain`, `encryption_IV_title`, `active`, `note`, `username`, `verified` FROM services INNER JOIN users ON users.id = services.user_id LIMIT ' . $min . ', ' . $max)->fetch_all(MYSQLI_ASSOC);
        }

        protected static function isActivate($serviceID) {
            return Database::sqlSelect('SELECT active FROM services WHERE id=?', 's', $serviceID)->fetch_assoc()['active'] == 1;
        }

        protected static function numPageVerify(&$page) {
            $nbMaxRow = ceil(Database::sqlSelect('SELECT id FROM services')->num_rows / Config::$MAX_SERVICES_DISPLAY);
            if ($page > $nbMaxRow) {
                $page = $nbMaxRow;
            }
            return $nbMaxRow;
        }

        
        // $sim = similar_text('machine a laver', 'machine', $perc);
        // echo "similarity: $sim ($perc %)\n";
    }
    