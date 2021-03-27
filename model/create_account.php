<?php
require_once('util.php');
require_once('email_verification.php');

$errors = [];

if(!isset($_POST['username']) || strlen($_POST['username']) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])){
    $errors[] = 1;
}

if(!isset($_POST['email']) || strlen($_POST['email']) > 255 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $errors[] = 2;
}elseif (!checkdnsrr(substr($_POST['email'], strpos($_POST['email'], '@') + 1), 'MX')) {
   $errors[] = 3;
}

if(!isset($_POST['password']) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $_POST['password'])){
    $errors[] = 4;
} elseif (!isset($_POST['passwordVerify']) || $_POST['passwordVerify'] !== $_POST['password']) {
    $errosr[] = 5;
}

if (count($errors) === 0) {
    if (isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
        
        $db = connect();
        if($db) {
            $res = sqlSelect($db, 'SELECT id FROM users WHERE email=?', 's', $_POST['email']);
            if($res && $res->num_rows === 0){
                $passHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $id = sqlInsert($db, 'INSERT INTO users VALUES (NULL, ?, ?, ?, 0)', 'sss', $_POST['username'], $_POST['email'], $passHash);
            
                if ($id !== -1) {
                    $err = snedValidationEmail($_POST['email']);
                    if ($err === 0) {
                        $errors[] = 0;
                    } else {
						$errors[] = $err + 9;
					}
                    
                    
                } else {
                    $errors[] = 6;
                }
                $res->free_result();
            } else {
                $errors[] = 7;
            }
        } else {
            $errors[] = 8;
        }
    } else {
        // bad csrf token
        $errors[] = 9;
    }
}

echo json_encode($errors);