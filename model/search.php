<?php
    require_once('util.php');
    session_start();


    if (isset($_POST['search'])  && strlen($_POST['search']) >= 3 && isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
        $db = connect();

        if($db) {
            $res = sqlSelect($db, 'SELECT id FROM pro_users WHERE objets_reparables LIKE ? ORDER BY note DESC' ,'s', "%" . $_POST['search'] . "%");

            if ($res->num_rows > 0) {
                $object = $res->fetch_all(MYSQLI_ASSOC);

                foreach ($object as $key) {
                    echo $key['id'] . "\n";
                }
                
            } else {
                echo -2;
                return;
            }
        }
    } else {
        echo -1;
    }