<?php
    // session_start();
    require_once('database.php');

    class Search extends Database {
        protected static function searchDomainName($query) {
            $res = parent::sqlSelect('SELECT users.id, users.username, users.email, pro_users.note FROM users INNER JOIN pro_users ON users.id=pro_users.user_id WHERE pro_users.objets_reparables LIKE ? ORDER BY pro_users.note DESC LIMIT 0,25' ,'s', "%" . $query . "%");
            // return $res;
            if ($res && $res->num_rows > 0) {
                return $res->fetch_all(MYSQLI_ASSOC);
            } else {
                return -2;
            }
        }
    }
    