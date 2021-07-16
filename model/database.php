<?php
    namespace Model;

    use Mysqli;
    
    include_once __DIR__ . '/config.php';

    class Database extends Config{
        public static $db = null;

        public function __construct() {
            self::$db = $this->connect();
        }

        private static function connect() {
            $db = new Mysqli(Config::DB_HOST, Config::DB_USERNAME, Config::DB_PASSWORD, Config::DB_DATABASE);
    
            if($db->connect_error) {
                return false;
            }
            return $db;
        }


        protected static function sqlSelect($query, $format = false, ...$vars){
            if (self::$db === null) {
                self::$db = self::connect();
            }
            $stmt = self::$db->prepare($query);
            if(!$stmt) {
                return false;
            }
            if ($format) {
                $stmt->bind_param($format, ...$vars);
            }
            if ($stmt->execute()) {
                $res = $stmt->get_result();
                $stmt->close();
                self::$db = null;
                return $res;
            }
            $stmt->close();
            self::$db->close();
            self::$db = null;
            return false;
        }

        protected static function sqlInsert($query, $format = false, ...$vars) {
            if (self::$db === null) {
                self::$db = self::connect();
            }
            $stmt = self::$db->prepare($query);
            if($format) {
                $stmt->bind_param($format, ...$vars);
            }

            if($stmt->execute()) {
                $id = $stmt->insert_id;
                $stmt->close();
                self::$db = null;
                return $id;
            }
            $stmt->close();
            self::$db->close();
            self::$db = null;
            return -1;
        }

        protected static function sqlUpdate($query, $format = false, ...$vars){
            if (self::$db === null) {
                self::$db = self::connect();
            }
            $stmt = self::$db->prepare($query);
            if($format) {
                $stmt->bind_param($format, ...$vars);
            }
            if($stmt->execute()) {
                $stmt->close();
                self::$db = null;
                return true;
            }
            $stmt->close();
            self::$db->close();
            self::$db = null;
            return false;
        }
    
    }
    