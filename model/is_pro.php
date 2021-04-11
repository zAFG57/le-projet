<?php 
require_once('util.php');
session_start();


function isPro(){
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']) && is_int($_SESSION['userID'])) {
        $db = connect();
        if($db) {
            $res = sqlSelect($db, 'SELECT users.pro, users.verified FROM users WHERE users.id = ?' ,'i', $_SESSION['userID']);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro['verified']) {
                    if($userPro['pro'] === 1){
                        return true;
                    }
                }
            }
    
        }
    }
    return false;
}

// if (condition) {
    echo isPro();
// }