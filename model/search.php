<?php
    require_once('util.php');
    session_start();


    if (isset($_POST['search']) && strlen($_POST['search']) >= 3 && isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
        $db = connect();

        if($db) {
            $res = sqlSelect($db, 'SELECT users.id, users.username, users.email, pro_users.note FROM users INNER JOIN pro_users ON users.id=pro_users.id WHERE pro_users.objets_reparables LIKE ? ORDER BY pro_users.note DESC LIMIT 0,25' ,'s', "%" . remAccents($_POST['search']) . "%");

            if ($res->num_rows > 0) {
                $object = $res->fetch_all(MYSQLI_ASSOC);
                array_push($object, $_POST['search']);
                echo json_encode($object);
            } else {
                echo -2;
            }
        }
    } else {
        echo -1;
    }