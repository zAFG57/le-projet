<?php 
require_once('util.php');
session_start();



if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) { 
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = connect();
    if ($db) {

        $hourAgo = time() - 60*60;

        $res = sqlSelect($db, 'SELECT users.id, users.password, users.verified, COUNT(loginattempts.id) FROM users LEFT JOIN loginattempts ON users.id = user AND timestamp>? WHERE email=? GROUP BY users.id','is', $hourAgo, $email);

        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();

                if($user['COUNT(loginattempts.id)'] < MAX_LOGIN_ATTEMPTS_PER_HOUR) {

                        if(password_verify($password, $user['password'])){
                            if ($user['verified']) {

                                // login
                                $_SESSION['loggedin'] = true;
                                $_SESSION['userID'] = $user['id'];
                                sqlUpdate($db, 'DELETE FROM loginattempts WHERE user=?', 'i', $user['id']);
                                echo 0;

                            } else {
                                echo 4;
                            }

                        } else {
                            $id = sqlInsert($db, 'INSERT INTO loginattempts VALUES (NULL, ?, ?, ?)', 'isi', $user['id'], $_SERVER['REMOTE_ADDR'], time());

                            if($id !== -1) {
                                echo 1;
                            } else {
                                echo 2;
                            }
                        }

                } else {
                    echo 3;
                }

            
            $res->free_result();
        } else {
            echo 1;
        }
        $db->close();
        
    } else {
        echo 2;
    }

} else {
    echo 1;
}

