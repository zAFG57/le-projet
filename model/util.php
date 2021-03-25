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

    function createToken() {
        $seed = random_bytes(8);
        $t = time();

        $hash = hash_hmac('sha256', session_id() . $seed . $t, CSRF_TOKEN_SECRET, true);

        return urlSafeEncode($hash . '|' . $seed . '|' . $t);
    }

    function validtaeToken($token){
        $parts = explode('|', urlSafeDecode($token));
        if (count($parts) === 3) {
            $hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2], CSRF_TOKEN_SECRET, true);
            if (hash_equals($hash, $part[0])) {
                return true;
            }
        }
        return false;
    }

    function urlSafeEncode($m){
        return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
    }

    function urlSafeDecode($m){
        return base64_decode(strtr($m), '-_', '+/');
    }