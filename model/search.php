<?php
    require_once('util.php');
    session_start();


    if (isset($_POST['search']) && isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
    
        echo 'test';
        
    }