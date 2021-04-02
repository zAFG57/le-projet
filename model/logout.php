<?php 
    require_once('util.php');
    session_start();
    if(isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])){ 
        session_destroy();
        echo 0;
    } else {
        echo 1;
    }
