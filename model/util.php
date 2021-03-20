<?php 
    require_once('../private/config.php');

    function connect() {
        $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if($db->connect_error) {
            return false;
        }
        return $db;
    }

    function sqlSelect($db, $query, $format = false, ...$vars){
        $stmt = $db->prepare($query);
        if(!$stmt) {
            return false;
        }
        if ($format) {
            $stmt->bind_param($format, ...$vars);
        }
        if ($stmt->execute()) {
            $res = $stmt->get_result();
            $stmt->close();
            return $res;
        }
        $stmt->close();
        return false;
    }

    function sqlInsert($db, $query, $format = false, ...$vars) {
		$stmt = $db->prepare($query);
		if($format) {
			$stmt->bind_param($format, ...$vars);
		}
		if($stmt->execute()) {
			$id = $stmt->insert_id;
			$stmt->close();
			return $id;
		}
		$stmt->close();
		return -1;
	}