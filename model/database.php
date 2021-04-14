<?php
    require_once('../private/config.php');

    class Database {
        public static $db = null;

        public function __construct(Type $var = null) {
            self::$db = $this->connect();
        }

        protected static function connect() {
            $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    
            if($db->connect_error) {
                return false;
            }
            return $db;
        }

        protected static function sqlSelect($query, $format = false, ...$vars){
            if (self::$db === null) {
                self::$db = Database::connect();
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
            self::$db = null;
            return false;
        }

        protected static function sqlInsert($query, $format = false, ...$vars) {
            if (self::$db === null) {
                self::$db = $this->connect();
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
            self::$db = null;
            return -1;
        }

        protected static function sqlUpdate($query, $format = false, ...$vars){
            if (self::$db === null) {
                self::$db = $this->connect();
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
            self::$db = null;
            return false;
        }
    
    }
    